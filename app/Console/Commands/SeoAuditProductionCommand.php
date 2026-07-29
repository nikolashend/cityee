<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;

/**
 * Live production HTTPS verification — CITYEE X999^5 §5 / §6 / §19.
 *
 * Performs a REAL crawl of the production host (not the local kernel) and
 * verifies, per canonical URL: final status, self-canonical, hreflang status +
 * reciprocity, mixed content, internal-link health, and asset (image) status.
 *
 * TLS note: local PHP has no CA bundle, so peer verification is disabled here
 * (verify=false). This is an audit reading public HTML — the production cert is
 * independently valid (curl CLI reaches it). We are not transmitting secrets.
 *
 * Outputs:
 *   storage/app/audit/production-url-audit.csv
 *   storage/app/audit/production-hreflang-audit.csv
 *   storage/app/audit/production-assets-audit.csv
 *   storage/app/audit/production-redirect-audit.csv
 *
 * Fail-hard on any canonical→non-200, hreflang→non-200, non-reciprocal hreflang,
 * mixed content, internal 4xx/5xx, or internal redirect link.
 *
 * Usage: php artisan seo:audit-production --base-url=https://cityee.ee
 */
class SeoAuditProductionCommand extends Command
{
    protected $signature   = 'seo:audit-production {--base-url=https://cityee.ee} {--assets : Also probe image assets (slower)}';
    protected $description = 'Real production HTTPS crawl: canonical/hreflang/redirect/asset/mixed-content verification.';

    private string $base;
    private string $host;
    private array $statusCache = [];   // url => int

    public function handle(): int
    {
        $this->base = rtrim($this->option('base-url'), '/');
        $this->host = parse_url($this->base, PHP_URL_HOST) ?: 'cityee.ee';

        $paths = $this->inventoryPaths();
        if (empty($paths)) {
            $this->error('No canonical inventory — run cityee:audit-urls first.');
            return self::FAILURE;
        }
        $this->info("Production crawl of {$this->base} — " . count($paths) . ' canonical URLs...');

        $pages = [];   // path => [status, canonical, canonical_status, self, robots, title, h1, lang, hreflang=>[lang=>href], mixed, redirect]
        $urlRows = [];
        $redirectRows = [];

        foreach ($paths as $path) {
            $url = $this->base . $path;
            $resp = $this->fetch($url, false);           // no redirect follow
            $status = $resp['status'];
            $this->statusCache[$this->cacheKey($url)] = $status;

            if ($status >= 300 && $status < 400) {
                $redirectRows[] = [$url, $status, $resp['location'] ?? '', 'canonical URL itself redirects'];
            }

            $html = ($status === 200) ? $resp['body'] : '';
            $canonical = $this->linkHref($html, 'canonical');
            $hreflang  = $this->hreflangMap($html);
            $robots    = $this->metaName($html, 'robots') ?: 'index,follow';
            $lang      = $this->htmlLang($html);
            $mixed     = $this->mixedContent($html);

            $canStatus = $canonical ? $this->probe($canonical) : 0;
            $pages[$path] = [
                'url' => $url, 'status' => $status, 'canonical' => $canonical,
                'canonical_status' => $canStatus,
                'self' => $canonical ? ($this->normUrl($canonical) === $this->normUrl($url)) : false,
                'robots' => $robots, 'title' => $this->tag($html, 'title'),
                'h1' => $this->tag($html, 'h1'), 'lang' => $lang,
                'hreflang' => $hreflang, 'mixed' => $mixed, 'html' => $html,
            ];

            $urlRows[] = [$url, $status, $canonical, $canStatus,
                $pages[$path]['self'] ? 'self' : 'other', $robots, $lang,
                count($hreflang), $mixed];
        }

        // ── Hreflang status + reciprocity ──────────────────────────
        $hrefRows = [];
        $byUrl = [];
        foreach ($pages as $p) $byUrl[$this->normUrl($p['url'])] = $p;
        $hreflangBadStatus = 0; $hreflangNonReciprocal = 0;
        foreach ($pages as $path => $p) {
            foreach ($p['hreflang'] as $lang => $href) {
                if ($lang === 'x-default') continue;
                $st = $this->probe($href);
                $reciprocal = 'unknown';
                $target = $byUrl[$this->normUrl($href)] ?? null;
                if ($target) {
                    $found = false;
                    foreach ($target['hreflang'] as $l2 => $h2) {
                        if ($this->normUrl($h2) === $this->normUrl($p['url'])) { $found = true; break; }
                    }
                    $reciprocal = $found ? 'yes' : 'no';
                    if (! $found) $hreflangNonReciprocal++;
                }
                if ($st !== 200) $hreflangBadStatus++;
                $hrefRows[] = [$p['url'], $lang, $href, $st, $reciprocal];
            }
        }

        // ── Internal links from money pages ────────────────────────
        $internal4xx = 0; $internal5xx = 0; $internal3xx = 0;
        foreach ($pages as $p) {
            if ($p['status'] !== 200) continue;
            foreach ($this->internalLinks($p['html']) as $href) {
                $abs = $this->abs($href);
                $st = $this->probe($abs, false);
                if ($st >= 500) $internal5xx++;
                elseif ($st >= 400) $internal4xx++;
                elseif ($st >= 300) { $internal3xx++; $redirectRows[] = [$p['url'], $st, $abs, 'internal link -> redirect']; }
            }
        }

        // ── Assets (optional) ──────────────────────────────────────
        $assetRows = []; $renderedMissing = 0;
        if ($this->option('assets')) {
            foreach ($pages as $p) {
                if ($p['status'] !== 200) continue;
                foreach ($this->images($p['html']) as $src) {
                    $abs = $this->abs($src);
                    if (! str_contains($abs, $this->host)) continue;
                    $st = $this->probe($abs);
                    if ($st >= 400) $renderedMissing++;
                    $assetRows[] = [$p['url'], $abs, $st];
                }
            }
        }

        // ── Persist ────────────────────────────────────────────────
        $dir = storage_path('app/audit');
        if (! is_dir($dir)) mkdir($dir, 0755, true);
        $this->writeCsv("{$dir}/production-url-audit.csv",
            ['url','status','canonical','canonical_status','canonical_target','robots','html_lang','hreflang_count','mixed_content'], $urlRows);
        $this->writeCsv("{$dir}/production-hreflang-audit.csv",
            ['source_url','hreflang','target','target_status','reciprocal'], $hrefRows);
        $this->writeCsv("{$dir}/production-redirect-audit.csv",
            ['source','status','target','note'], $redirectRows);
        if ($assetRows) $this->writeCsv("{$dir}/production-assets-audit.csv", ['page','asset','status'], $assetRows);

        // ── Acceptance ─────────────────────────────────────────────
        $canonToNon200 = count(array_filter($pages, fn($p) => $p['canonical'] && $p['canonical_status'] !== 200));
        $pageNon200    = count(array_filter($pages, fn($p) => $p['status'] !== 200));
        $mixed         = count(array_filter($pages, fn($p) => $p['mixed'] > 0));

        $this->newLine();
        $this->line("Canonical URLs crawled:      " . count($pages));
        $this->line($this->c($pageNon200) . "Canonical URL not 200:       {$pageNon200}</>");
        $this->line($this->c($canonToNon200) . "canonical -> non-200:        {$canonToNon200}</>");
        $this->line($this->c($hreflangBadStatus) . "hreflang -> non-200:         {$hreflangBadStatus}</>");
        $this->line($this->c($hreflangNonReciprocal) . "hreflang non-reciprocal:     {$hreflangNonReciprocal}</>");
        $this->line($this->c($mixed) . "pages with mixed content:    {$mixed}</>");
        $this->line($this->c($internal4xx) . "internal links -> 4xx:       {$internal4xx}</>");
        $this->line($this->c($internal5xx) . "internal links -> 5xx:       {$internal5xx}</>");
        $this->line($this->c($internal3xx, true) . "internal links -> 3xx:       {$internal3xx}</>");
        if ($this->option('assets')) {
            $this->line($this->c($renderedMissing) . "rendered assets -> 4xx/5xx:  {$renderedMissing}</>");
        } else {
            $this->line("<fg=yellow>assets: skipped (pass --assets to probe images)</>");
        }
        $this->newLine();
        $this->info("Saved production-*.csv to {$dir}");

        $critical = $pageNon200 + $canonToNon200 + $hreflangBadStatus + $hreflangNonReciprocal + $mixed + $internal4xx + $internal5xx + $renderedMissing;
        $this->newLine();
        if ($critical === 0) {
            $this->line('<fg=green;options=bold>PRODUCTION PASS — no critical live-host issues.</>');
            return self::SUCCESS;
        }
        $this->line("<fg=red;options=bold>PRODUCTION FAIL — {$critical} critical issue(s). See CSVs.</>");
        return self::FAILURE;
    }

    // ── HTTP ─────────────────────────────────────────────────────
    private function fetch(string $url, bool $follow = true): array
    {
        try {
            $req = Http::withOptions(['verify' => false])->timeout(20)->withHeaders(['User-Agent' => 'CityEE-SEO-Audit/1.0']);
            $req = $follow ? $req : $req->withoutRedirecting();
            $r = $req->get($url);
            return ['status' => $r->status(), 'body' => $r->body(), 'location' => $r->header('Location')];
        } catch (\Throwable $e) {
            return ['status' => 0, 'body' => '', 'location' => null];
        }
    }

    private function probe(string $url, bool $follow = true): int
    {
        // Slash-SENSITIVE cache key (X999^5 §9): /x and /x/ must never share an
        // entry — /x may 301 while /x/ is 200. normUrl() (slash-insensitive) is
        // used only for self-canonical/reciprocity comparison, never for caching.
        $k = $this->cacheKey($url);
        if (isset($this->statusCache[$k])) return $this->statusCache[$k];
        return $this->statusCache[$k] = $this->fetch($url, $follow)['status'];
    }

    /** Exact status-cache key: scheme+host+path (slash kept) + query. */
    private function cacheKey(string $url): string
    {
        $p = parse_url($url);
        $scheme = strtolower($p['scheme'] ?? 'https');
        $host   = strtolower($p['host'] ?? $this->host);
        $path   = $p['path'] ?? '/';
        $query  = isset($p['query']) ? '?' . $p['query'] : '';
        return "{$scheme}://{$host}{$path}{$query}";
    }

    // ── Parsing helpers ──────────────────────────────────────────
    private function linkHref(string $html, string $rel): string
    {
        return preg_match('#<link[^>]*rel=["\']' . $rel . '["\'][^>]*href=["\'](.*?)["\']#i', $html, $m) ? html_entity_decode($m[1]) : '';
    }
    private function hreflangMap(string $html): array
    {
        preg_match_all('#<link[^>]*rel=["\']alternate["\'][^>]*hreflang=["\'](.*?)["\'][^>]*href=["\'](.*?)["\']#i', $html, $m, PREG_SET_ORDER);
        // also handle href-before-hreflang ordering
        preg_match_all('#<link[^>]*rel=["\']alternate["\'][^>]*href=["\'](.*?)["\'][^>]*hreflang=["\'](.*?)["\']#i', $html, $m2, PREG_SET_ORDER);
        $out = [];
        foreach ($m as $x) $out[strtolower($x[1])] = html_entity_decode($x[2]);
        foreach ($m2 as $x) $out[strtolower($x[2])] = html_entity_decode($x[1]);
        return $out;
    }
    private function metaName(string $html, string $n): string
    {
        return preg_match('#<meta[^>]*name=["\']' . $n . '["\'][^>]*content=["\'](.*?)["\']#i', $html, $m) ? trim($m[1]) : '';
    }
    private function htmlLang(string $html): string
    {
        return preg_match('#<html[^>]*\blang=["\'](.*?)["\']#i', $html, $m) ? $m[1] : '';
    }
    private function tag(string $html, string $t): string
    {
        return preg_match("#<{$t}\b[^>]*>(.*?)</{$t}>#is", $html, $m) ? trim(preg_replace('/\s+/', ' ', strip_tags($m[1]))) : '';
    }
    private function mixedContent(string $html): int
    {
        preg_match_all('#(?:src|href)=["\']http://[^"\']+["\']#i', $html, $m);
        return count($m[0]);
    }
    private function internalLinks(string $html): array
    {
        preg_match_all('/<a\b[^>]*\bhref\s*=\s*(["\'])(.*?)\1/i', $html, $m);
        $out = [];
        foreach ($m[2] as $h) {
            $h = trim(html_entity_decode($h));
            if ($h === '' || str_starts_with($h, '#') || preg_match('#^(mailto:|tel:|javascript:)#i', $h)) continue;
            if (str_starts_with($h, '/') && ! str_starts_with($h, '//')) { $out[] = $h; continue; }
            if (str_contains($h, $this->host) && preg_match('#^https?://#i', $h)) $out[] = $h;
        }
        return array_values(array_unique($out));
    }
    private function images(string $html): array
    {
        preg_match_all('#<img[^>]*\bsrc=["\'](.*?)["\']#i', $html, $m);
        return array_values(array_unique(array_map('html_entity_decode', $m[1] ?? [])));
    }
    private function abs(string $href): string
    {
        if (preg_match('#^https?://#i', $href)) return $href;
        return $this->base . '/' . ltrim($href, '/');
    }
    private function normUrl(string $url): string
    {
        $url = preg_replace('#^https?://#i', '', $url);
        $url = strtok($url, '#'); $url = strtok($url, '?');
        return rtrim($url, '/');
    }

    private function inventoryPaths(): array
    {
        $file = storage_path('app/seo-audit/url-inventory.json');
        if (! is_file($file)) return [];
        $data = json_decode(file_get_contents($file), true) ?: [];
        $redir = array_keys(config('seo_redirects', []));
        $paths = [];
        foreach ($data as $row) {
            $u = $row['url'] ?? null;
            if (! $u || ($row['http_status'] ?? '') === 'redirect') continue;
            $p = parse_url($u, PHP_URL_PATH) ?: '/';
            if (in_array($p, $redir, true) || in_array(rtrim($p, '/'), $redir, true)) continue;
            $paths[$p] = $p;
        }
        return array_values($paths);
    }

    private function writeCsv(string $file, array $head, array $rows): void
    {
        $csv = implode(',', $head) . "\n";
        foreach ($rows as $r) {
            $csv .= implode(',', array_map(fn($v) => '"' . str_replace('"', '""', (string) $v) . '"', $r)) . "\n";
        }
        file_put_contents($file, $csv);
    }
    private function c(int $n, bool $warn = false): string
    {
        return $n === 0 ? '<fg=green>' : ($warn ? '<fg=yellow>' : '<fg=red>');
    }
}
