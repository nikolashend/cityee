<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Contracts\Http\Kernel;
use Illuminate\Http\Request;

/**
 * Intent cannibalization audit — CITYEE X999^5 Seller-Domination §5 / INV-004.
 *
 * Reads the ownership registries (config/search_intents.php, config/money_pages.php)
 * and checks:
 *   - duplicate PRIMARY ownership (one URL declared primary for >1 cluster) — FAIL
 *   - competing title/H1 between two different primaries (same language) — WARN/FAIL
 *   - primaries that do not return 200 — FAIL
 *
 * Non-destructive. Emits storage/app/audit/intent-cannibalization.csv and returns
 * a NON-ZERO exit code when a critical conflict is found (deploy gate, §26).
 *
 * Usage: php artisan seo:audit-intents
 */
class SeoAuditIntentsCommand extends Command
{
    protected $signature   = 'seo:audit-intents';
    protected $description = 'Audit intent ownership for cannibalization (duplicate primaries, competing titles).';

    public function handle(Kernel $kernel): int
    {
        $intents = config('search_intents', []);
        $rows = [];       // csv rows
        $critical = 0;

        // Flatten (lang, cluster, primary) tuples.
        $primaries = [];  // [lang][cluster] = url
        foreach ($intents as $lang => $clusters) {
            foreach ($clusters as $cluster => $def) {
                $primaries[$lang][$cluster] = $def['primary'] ?? null;
            }
        }

        // ── 1. Duplicate primary ownership within a language ───────
        foreach ($primaries as $lang => $map) {
            $byUrl = [];
            foreach ($map as $cluster => $url) {
                if ($url) $byUrl[$url][] = $cluster;
            }
            foreach ($byUrl as $url => $clusters) {
                if (count($clusters) > 1) {
                    $critical++;
                    $rows[] = [$lang, implode('+', $clusters), $url, $url, 'duplicate_primary', 'CRITICAL',
                        'one URL is primary for multiple clusters', 'split intents or demote one to supporting'];
                }
            }
        }

        // ── 2. Render primaries, capture title/H1, check 200 ───────
        $meta = [];       // url => ['status'=>,'title'=>,'h1'=>,'lang'=>]
        foreach ($primaries as $lang => $map) {
            foreach ($map as $cluster => $url) {
                if (! $url || isset($meta[$url])) continue;
                $path = parse_url($url, PHP_URL_PATH) ?: $url;
                $res  = $kernel->handle(Request::create($path, 'GET'));
                $html = $res->getStatusCode() === 200 ? (string) $res->getContent() : '';
                $meta[$url] = [
                    'status' => $res->getStatusCode(),
                    'title'  => $this->tag($html, 'title'),
                    'h1'     => $this->tag($html, 'h1'),
                    'lang'   => $lang,
                ];
                if ($res->getStatusCode() !== 200) {
                    $critical++;
                    $rows[] = [$lang, $cluster, $url, '', 'primary_not_200', 'CRITICAL',
                        "primary returned {$res->getStatusCode()}", 'fix route/content'];
                }
            }
        }

        // ── 3. Competing title/H1 between different primaries ──────
        $urls = array_keys($meta);
        for ($i = 0; $i < count($urls); $i++) {
            for ($j = $i + 1; $j < count($urls); $j++) {
                $a = $meta[$urls[$i]]; $b = $meta[$urls[$j]];
                if ($a['lang'] !== $b['lang']) continue;
                $tSim = $this->sim($a['title'], $b['title']);
                $hSim = $this->sim($a['h1'], $b['h1']);
                if ($tSim >= 0.8 || $hSim >= 0.85) {
                    $sev = ($tSim >= 0.9 || $hSim >= 0.95) ? 'HIGH' : 'MEDIUM';
                    $rows[] = [$a['lang'], 'title/h1 overlap', $urls[$i], $urls[$j], 'competing_title_h1', $sev,
                        sprintf('title=%.0f%% h1=%.0f%%', $tSim * 100, $hSim * 100), 'differentiate title/H1 promise'];
                }
            }
        }

        // ── Output ─────────────────────────────────────────────────
        $dir = storage_path('app/audit');
        if (! is_dir($dir)) mkdir($dir, 0755, true);
        $csv = "lang,cluster,primary_url,competing_url,conflict_type,severity,evidence,recommended_action\n";
        foreach ($rows as $r) {
            $csv .= implode(',', array_map(fn($v) => '"' . str_replace('"', '""', (string) $v) . '"', $r)) . "\n";
        }
        file_put_contents("{$dir}/intent-cannibalization.csv", $csv);

        $this->line('Primaries checked: ' . count($meta));
        $dupes = array_filter($rows, fn($r) => $r[4] === 'duplicate_primary');
        $bad   = array_filter($rows, fn($r) => $r[4] === 'primary_not_200');
        $comp  = array_filter($rows, fn($r) => $r[4] === 'competing_title_h1');
        $this->line('<fg=' . ($dupes ? 'red' : 'green') . '>Duplicate primary ownership: ' . count($dupes) . '</>');
        $this->line('<fg=' . ($bad ? 'red' : 'green') . '>Primaries not 200:           ' . count($bad) . '</>');
        $this->line('<fg=' . ($comp ? 'yellow' : 'green') . '>Competing title/H1 pairs:    ' . count($comp) . '</>');
        foreach ($comp as $r) $this->line("  <fg=yellow>{$r[5]}</> {$r[2]} ~ {$r[3]} ({$r[6]})");
        $this->newLine();
        $this->info("Saved: {$dir}/intent-cannibalization.csv");

        $this->newLine();
        if ($critical === 0) {
            $this->line('<fg=green;options=bold>PASS — no critical intent cannibalization.</>');
            return self::SUCCESS;
        }
        $this->line("<fg=red;options=bold>FAIL — {$critical} critical conflict(s).</>");
        return self::FAILURE;
    }

    private function tag(string $html, string $tag): string
    {
        return preg_match("#<{$tag}\b[^>]*>(.*?)</{$tag}>#is", $html, $m)
            ? trim(preg_replace('/\s+/', ' ', strip_tags($m[1]))) : '';
    }

    /** Token Jaccard similarity, case/spacing-insensitive. */
    private function sim(string $a, string $b): float
    {
        $ta = array_filter(preg_split('/\W+/u', mb_strtolower($a)));
        $tb = array_filter(preg_split('/\W+/u', mb_strtolower($b)));
        if (! $ta || ! $tb) return 0.0;
        $inter = count(array_intersect($ta, $tb));
        $union = count(array_unique(array_merge($ta, $tb)));
        return $union ? $inter / $union : 0.0;
    }
}
