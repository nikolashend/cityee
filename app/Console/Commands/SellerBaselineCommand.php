<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Contracts\Http\Kernel;
use Illuminate\Http\Request;

/**
 * Seller money-page baseline + internal authority graph.
 * CITYEE X999^5 Seller-Domination §2 / §10.
 *
 * Renders each seller money page in-process, extracts on-page SEO fields, and
 * — from a full crawl of the canonical inventory — computes each page's inbound
 * internal-link count, unique anchor texts, source pages and click depth from /.
 *
 * Non-destructive (read-only). Outputs:
 *   storage/app/audit/seller-money-pages-baseline.csv
 *   storage/app/audit/money-page-link-graph.csv
 *
 * This MUST be run before any seller-money-page edit so before/after is provable.
 *
 * Usage: php artisan seo:seller-baseline
 */
class SellerBaselineCommand extends Command
{
    protected $signature   = 'seo:seller-baseline';
    protected $description = 'Baseline seller money pages + internal authority graph (read-only).';

    private const HOST = 'cityee.ee';

    /** Seller money pages to baseline (§2). */
    private const MONEY_PATHS = [
        '/', '/ru/', '/ru/makler-v-tallinne/', '/ru/prodat-kvartiru-v-tallinne/',
        '/ru/ocenka-kvartiry-v-tallinne/', '/ru/kinnisvara-uur/',
        '/ru/agentstvo-nedvizhimosti-tallinn/', '/ru/aleksandr-primakov/', '/ru/tallinn/',
    ];

    private array $internalHosts = [];

    public function handle(Kernel $kernel): int
    {
        $appHost = parse_url((string) config('app.url'), PHP_URL_HOST) ?: 'localhost';
        $this->internalHosts = array_unique([self::HOST, $appHost, 'localhost', '127.0.0.1']);

        // ── Full crawl for the authority graph ─────────────────────
        $seeds = $this->seeds();
        $this->info('Crawling ' . count($seeds) . ' pages for the authority graph...');
        $edges = [];              // ['from'=>path,'to'=>key,'anchor'=>text]
        $adj   = [];              // from => [to,...] for BFS
        foreach ($seeds as $seed) {
            $from = $this->key($seed);
            $html = $this->render($kernel, $this->pathOf($seed));
            if ($html === null) continue;
            foreach ($this->links($html) as [$href, $anchor]) {
                $to = $this->key($href);
                if ($to === null) continue;
                $edges[] = ['from' => $from, 'to' => $to, 'anchor' => trim(mb_substr($anchor, 0, 80))];
                $adj[$from][] = $to;
            }
        }
        $depth = $this->bfsDepth($adj, '/');

        // ── Aggregate authority per money page ─────────────────────
        $graph = [];
        foreach (self::MONEY_PATHS as $p) {
            $k = $this->key($p);
            $in = array_filter($edges, fn($e) => $e['to'] === $k);
            $anchors = array_values(array_unique(array_filter(array_map(fn($e) => $e['anchor'], $in))));
            $sources = array_values(array_unique(array_map(fn($e) => $e['from'], $in)));
            $graph[$k] = [
                'inlinks'        => count($in),
                'unique_sources' => count($sources),
                'anchor_diversity' => count($anchors),
                'click_depth'    => $depth[$k] ?? -1,
                'anchors'        => $anchors,
            ];
        }

        // ── On-page baseline per money page ────────────────────────
        $dir = storage_path('app/audit');
        if (! is_dir($dir)) mkdir($dir, 0755, true);

        $rows = [];
        foreach (self::MONEY_PATHS as $p) {
            $res  = $kernel->handle(Request::create($p, 'GET'));
            $html = $res->getStatusCode() === 200 ? (string) $res->getContent() : '';
            $k = $this->key($p);
            $g = $graph[$k];
            $rows[] = [
                'url'              => 'https://cityee.ee' . $p,
                'status'           => $res->getStatusCode(),
                'canonical'        => $this->meta($html, 'canonical'),
                'meta_robots'      => $this->metaName($html, 'robots') ?: 'index,follow (default)',
                'title'            => $this->tag($html, 'title'),
                'title_len'        => mb_strlen($this->tag($html, 'title')),
                'meta_description' => $this->metaName($html, 'description'),
                'h1'               => $this->tag($html, 'h1'),
                'word_count'       => str_word_count(strip_tags($html)),
                'schema_types'     => implode('|', $this->schemaTypes($html)),
                'hreflang_count'   => substr_count($html, 'rel="alternate"'),
                'inlinks'          => $g['inlinks'],
                'unique_sources'   => $g['unique_sources'],
                'anchor_diversity' => $g['anchor_diversity'],
                'click_depth'      => $g['click_depth'],
                'outgoing_links'   => count($this->links($html)),
            ];
        }

        // baseline CSV
        $cols = array_keys($rows[0]);
        $csv = implode(',', $cols) . "\n";
        foreach ($rows as $r) {
            $csv .= implode(',', array_map(fn($v) => '"' . str_replace('"', '""', (string) $v) . '"', $r)) . "\n";
        }
        file_put_contents("{$dir}/seller-money-pages-baseline.csv", $csv);

        // link graph CSV
        $g = "money_page,inlinks,unique_sources,anchor_diversity,click_depth,sample_anchors\n";
        foreach (self::MONEY_PATHS as $p) {
            $k = $this->key($p);
            $x = $graph[$k];
            $g .= sprintf("\"%s\",%d,%d,%d,%d,\"%s\"\n", $k, $x['inlinks'], $x['unique_sources'],
                $x['anchor_diversity'], $x['click_depth'], str_replace('"', '""', implode(' | ', array_slice($x['anchors'], 0, 6))));
        }
        file_put_contents("{$dir}/money-page-link-graph.csv", $g);

        // ── Console summary ────────────────────────────────────────
        $this->newLine();
        $this->line(str_pad('money page', 40) . str_pad('in', 5) . str_pad('src', 5) . str_pad('anc', 5) . 'depth');
        foreach (self::MONEY_PATHS as $p) {
            $x = $graph[$this->key($p)];
            $flag = ($x['inlinks'] === 0) ? '<fg=red>' : (($x['click_depth'] > 2 || $x['click_depth'] < 0) ? '<fg=yellow>' : '<fg=green>');
            $this->line($flag . str_pad($p, 40) . str_pad((string) $x['inlinks'], 5) . str_pad((string) $x['unique_sources'], 5) . str_pad((string) $x['anchor_diversity'], 5) . $x['click_depth'] . '</>');
        }
        $this->newLine();
        $this->info("Saved: {$dir}/seller-money-pages-baseline.csv + money-page-link-graph.csv");

        // Warn (non-fatal) on INV-011/012: S-tier orphan or footer-only.
        $weak = array_filter(self::MONEY_PATHS, fn($p) => $graph[$this->key($p)]['inlinks'] === 0);
        if ($weak) {
            $this->warn('S-tier pages with 0 internal inlinks (INV-012 risk): ' . implode(', ', $weak));
        }
        return self::SUCCESS;
    }

    // ── helpers ──────────────────────────────────────────────────

    private function seeds(): array
    {
        $file = storage_path('app/seo-audit/url-inventory.json');
        $data = is_file($file) ? (json_decode(file_get_contents($file), true) ?: []) : [];
        $redir = array_keys(config('seo_redirects', []));
        $out = [];
        foreach ($data as $row) {
            $u = $row['url'] ?? null;
            if (! $u || ($row['http_status'] ?? '') === 'redirect') continue;
            $p = $this->key($u);
            if (in_array($p, $redir, true) || in_array(rtrim((string) $p, '/'), $redir, true)) continue;
            $out[$u] = $u;
        }
        return array_values($out);
    }

    private function render(Kernel $kernel, string $path): ?string
    {
        $res = $kernel->handle(Request::create($path, 'GET'));
        return $res->getStatusCode() === 200 ? (string) $res->getContent() : null;
    }

    /** [href, anchorText] pairs for internal links. */
    private function links(string $html): array
    {
        preg_match_all('/<a\b[^>]*\bhref\s*=\s*(["\'])(.*?)\1[^>]*>(.*?)<\/a>/is', $html, $m, PREG_SET_ORDER);
        $out = [];
        foreach ($m as $x) {
            $href = trim($x[2]);
            if ($href === '' || str_starts_with($href, '#') || str_starts_with($href, 'mailto:')
                || str_starts_with($href, 'tel:') || str_starts_with($href, 'javascript:')) continue;
            if (str_starts_with($href, '/') && ! str_starts_with($href, '//')) {
                $out[] = [$href, strip_tags($x[3])];
                continue;
            }
            $host = parse_url($href, PHP_URL_HOST);
            if ($host !== null && in_array(strtolower($host), $this->internalHosts, true)) {
                $out[] = [$href, strip_tags($x[3])];
            }
        }
        return $out;
    }

    private function key(?string $hrefOrUrl): ?string
    {
        if ($hrefOrUrl === null || $hrefOrUrl === '') return null;
        $h = $hrefOrUrl;
        if (preg_match('#^https?://#i', $h)) {
            $host = strtolower(parse_url($h, PHP_URL_HOST) ?: '');
            if (! in_array($host, $this->internalHosts, true)) return null;
            $h = parse_url($h, PHP_URL_PATH) ?: '/';
        }
        $h = strtok($h, '#'); $h = strtok($h, '?');
        if ($h === false || $h === '') return '/';
        return $h === '/' ? '/' : rtrim($h, '/');
    }

    private function pathOf(string $url): string
    {
        return (parse_url($url, PHP_URL_PATH) ?: '/');
    }

    private function bfsDepth(array $adj, string $root): array
    {
        $depth = [$root => 0];
        $q = [$root];
        while ($q) {
            $n = array_shift($q);
            foreach ($adj[$n] ?? [] as $m) {
                if (! isset($depth[$m])) { $depth[$m] = $depth[$n] + 1; $q[] = $m; }
            }
        }
        return $depth;
    }

    private function tag(string $html, string $tag): string
    {
        return preg_match("#<{$tag}\b[^>]*>(.*?)</{$tag}>#is", $html, $m) ? trim(preg_replace('/\s+/', ' ', strip_tags($m[1]))) : '';
    }

    private function meta(string $html, string $rel): string
    {
        return preg_match('#<link[^>]*rel=["\']' . $rel . '["\'][^>]*href=["\'](.*?)["\']#i', $html, $m) ? $m[1] : '';
    }

    private function metaName(string $html, string $name): string
    {
        return preg_match('#<meta[^>]*name=["\']' . $name . '["\'][^>]*content=["\'](.*?)["\']#i', $html, $m) ? trim($m[1]) : '';
    }

    private function schemaTypes(string $html): array
    {
        preg_match_all('#"@type"\s*:\s*"([^"]+)"#', $html, $m);
        return array_values(array_unique($m[1] ?? []));
    }
}
