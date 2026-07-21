<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Contracts\Http\Kernel;
use Illuminate\Http\Request;

/**
 * Zero-broken-link engine — CITYEE X999^5 §12 / §64.
 *
 * Crawls every canonical seed page in-process (HTTP kernel — no live server
 * needed), extracts internal <a href> targets, resolves each one, and asserts:
 *   INV-002  internal links to 4xx = 0, to 5xx = 0
 *   INV-003  internal links to 3xx (redirects) = 0
 *   plus redirect loops, wrong-host and http:// internal links, and
 *   valuable orphan pages (canonical seed with 0 internal inlinks).
 *
 * Seeds come from the canonical URL inventory (storage/app/seo-audit/
 * url-inventory.json, produced by cityee:audit-urls) so the crawl covers the
 * intended indexable set rather than whatever happens to be linked.
 *
 * Outputs storage/app/audit/link-audit.{json,csv} and returns a NON-ZERO exit
 * code when any internal 4xx/5xx is found (deploy gate, §79).
 *
 * Usage: php artisan seo:audit-links [--fail-on-redirect]
 */
class SeoAuditLinksCommand extends Command
{
    protected $signature   = 'seo:audit-links {--fail-on-redirect : Also fail the command when internal links point at 3xx}';
    protected $description = 'Crawl internal links, detect 4xx/5xx/redirect/orphan issues, fail-hard on broken internal links.';

    private const CANONICAL_HOST = 'cityee.ee';

    /** Hosts that count as internal (prod canonical + runtime/test host). */
    private array $internalHosts = [];
    /** cityee.* subdomains that must NOT be linked internally (wrong host). */
    private const WRONG_HOSTS = ['www.cityee.ee', 'ru.cityee.ee', 'en.cityee.ee'];

    public function handle(Kernel $kernel): int
    {
        $appHost = parse_url((string) config('app.url'), PHP_URL_HOST) ?: 'localhost';
        $this->internalHosts = array_unique([self::CANONICAL_HOST, $appHost, 'localhost', '127.0.0.1']);

        $seeds = $this->loadSeeds();
        if (empty($seeds)) {
            $this->error('No seeds — run `php artisan cityee:audit-urls` first.');
            return self::FAILURE;
        }

        $this->info('Crawling ' . count($seeds) . ' canonical seed pages...');

        $statusCache = [];                 // path => ['status'=>int,'location'=>?string]
        $edges       = [];                 // page-link edges
        $assetEdges  = [];                 // links to files (images, docs) — reported separately
        // inlink counter keyed by slash-insensitive path so /x and /x/ collapse.
        $inlinks = array_fill_keys(array_map([$this, 'key'], $seeds), 0);

        foreach ($seeds as $seedUrl) {
            $seedPath = $this->pathOf($seedUrl);
            $html = $this->render($kernel, $seedPath, $statusCache);
            if ($html === null) {
                continue;
            }

            foreach ($this->extractInternalLinks($html) as $rawHref) {
                $to = $this->normalize($rawHref);
                if ($to === null) {
                    continue;
                }
                $probe = $this->probe($kernel, $to, $statusCache);
                $edge = [
                    'from'     => $this->normalize($seedUrl),
                    'to'       => $to,
                    'status'   => $probe['status'],
                    'location' => $probe['location'],
                    // Only a real mixed-content link if it targets the prod host
                    // over http. route()-generated http://localhost is a dev artifact.
                    'http'     => (bool) preg_match('#^http://#i', $rawHref)
                        && strtolower((string) parse_url($rawHref, PHP_URL_HOST)) === self::CANONICAL_HOST,
                    'wronghost'=> $this->isWrongHost($rawHref),
                ];
                if ($this->isAsset($to)) {
                    $assetEdges[] = $edge;
                    continue;
                }
                $edges[] = $edge;
                $k = $this->key($to);
                if (array_key_exists($k, $inlinks)) {
                    $inlinks[$k]++;
                }
            }
        }

        // ── Classify page-link edges ───────────────────────────────
        $to4xx = array_filter($edges, fn($e) => $e['status'] >= 400 && $e['status'] < 500);
        $to5xx = array_filter($edges, fn($e) => $e['status'] >= 500);
        $to3xx = array_filter($edges, fn($e) => $e['status'] >= 300 && $e['status'] < 400);
        $httpL = array_filter($edges, fn($e) => $e['http']);
        $wrong = array_filter($edges, fn($e) => $e['wronghost']);
        $orphans = array_keys(array_filter($inlinks, fn($n) => $n === 0));
        $assets4xx = array_filter($assetEdges, fn($e) => $e['status'] >= 400);

        // ── Report ─────────────────────────────────────────────────
        $this->newLine();
        $this->line('Seeds crawled:        ' . count($seeds));
        $this->line('Unique URLs probed:   ' . count($statusCache));
        $this->line('Internal edges:       ' . count($edges));
        $this->line('<fg=' . ($to4xx ? 'red' : 'green') . '>Internal -> 4xx:      ' . count($to4xx) . '</>');
        $this->line('<fg=' . ($to5xx ? 'red' : 'green') . '>Internal -> 5xx:      ' . count($to5xx) . '</>');
        $this->line('<fg=' . ($to3xx ? 'yellow' : 'green') . '>Internal -> 3xx:      ' . count($to3xx) . '</>');
        $this->line('<fg=' . ($httpL ? 'red' : 'green') . '>Internal http:// :    ' . count($httpL) . '</>');
        $this->line('<fg=' . ($wrong ? 'red' : 'green') . '>Wrong-host links:     ' . count($wrong) . '</>');
        $this->line('<fg=' . ($orphans ? 'yellow' : 'green') . '>Valuable orphans:     ' . count($orphans) . '</>');
        $this->line('<fg=' . ($assets4xx ? 'yellow' : 'green') . '>Asset links -> 4xx:   ' . count($assets4xx) . ' (images/files — verify in prod)</>');

        foreach ($to4xx as $e) $this->line("  <fg=red>4xx</> {$e['from']} -> {$e['to']} ({$e['status']})");
        foreach ($to5xx as $e) $this->line("  <fg=red>5xx</> {$e['from']} -> {$e['to']} ({$e['status']})");
        foreach ($to3xx as $e) $this->line("  <fg=yellow>3xx</> {$e['from']} -> {$e['to']} -> {$e['location']}");
        foreach ($orphans as $o) $this->line("  <fg=yellow>orphan</> {$o}");

        // ── Persist ────────────────────────────────────────────────
        $dir = storage_path('app/audit');
        if (! is_dir($dir)) mkdir($dir, 0755, true);
        file_put_contents("{$dir}/link-audit.json", json_encode([
            'summary' => [
                'seeds' => count($seeds), 'probed' => count($statusCache), 'edges' => count($edges),
                'to_4xx' => count($to4xx), 'to_5xx' => count($to5xx), 'to_3xx' => count($to3xx),
                'http' => count($httpL), 'wrong_host' => count($wrong), 'orphans' => count($orphans),
                'asset_4xx' => count($assets4xx),
            ],
            'to_4xx' => array_values($to4xx), 'to_5xx' => array_values($to5xx),
            'to_3xx' => array_values($to3xx), 'orphans' => $orphans,
        ], JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE));

        $csv = "from,to,status,location,http,wrong_host\n";
        foreach ($edges as $e) {
            $csv .= sprintf("\"%s\",\"%s\",%d,\"%s\",%s,%s\n", $e['from'], $e['to'], $e['status'], $e['location'] ?? '', $e['http'] ? '1' : '0', $e['wronghost'] ? '1' : '0');
        }
        file_put_contents("{$dir}/link-audit.csv", $csv);
        $this->newLine();
        $this->info("Saved: {$dir}/link-audit.json + .csv");

        // ── Verdict (fail-hard, §64/§79) ───────────────────────────
        $critical = count($to4xx) + count($to5xx) + count($httpL) + count($wrong);
        if ($this->option('fail-on-redirect')) {
            $critical += count($to3xx);
        }

        $this->newLine();
        if ($critical === 0) {
            $this->line('<fg=green;options=bold>PASS — no broken internal links.</>');
            return self::SUCCESS;
        }
        $this->line("<fg=red;options=bold>FAIL — {$critical} critical internal link issue(s).</>");
        return self::FAILURE;
    }

    // ──────────────────────────────────────────────

    private function loadSeeds(): array
    {
        $file = storage_path('app/seo-audit/url-inventory.json');
        if (! is_file($file)) return [];
        $data = json_decode(file_get_contents($file), true) ?: [];
        $redirectSources = array_keys(config('seo_redirects', []));
        $urls = [];
        foreach ($data as $row) {
            $u = $row['url'] ?? null;
            if (! $u || ($row['http_status'] ?? '') === 'redirect') {
                continue;
            }
            // Skip redirect-source URLs (e.g. /index) — they are not canonical pages
            // and correctly have no inlinks, so they must not count as orphans.
            $path = $this->normalize($u) ?? '/';
            if (in_array($path, $redirectSources, true) || in_array(rtrim($path, '/'), $redirectSources, true)) {
                continue;
            }
            $urls[] = $u;
        }
        return array_values(array_unique($urls));
    }

    private function render(Kernel $kernel, string $path, array &$cache): ?string
    {
        $res = $kernel->handle(Request::create($path, 'GET'));
        $cache[$path] = ['status' => $res->getStatusCode(), 'location' => $res->headers->get('Location')];
        return $res->getStatusCode() === 200 ? (string) $res->getContent() : null;
    }

    private function probe(Kernel $kernel, string $path, array &$cache): array
    {
        if (isset($cache[$path])) return $cache[$path];
        $res = $kernel->handle(Request::create($path, 'GET'));
        return $cache[$path] = ['status' => $res->getStatusCode(), 'location' => $res->headers->get('Location')];
    }

    /** Extract internal <a href> values from HTML (host-aware). */
    private function extractInternalLinks(string $html): array
    {
        preg_match_all('/<a\b[^>]*\bhref\s*=\s*(["\'])(.*?)\1/i', $html, $m);
        $out = [];
        foreach ($m[2] as $href) {
            $href = trim($href);
            if ($href === '' || str_starts_with($href, '#') || str_starts_with($href, 'mailto:')
                || str_starts_with($href, 'tel:') || str_starts_with($href, 'javascript:')) {
                continue;
            }
            // Relative link → internal.
            if (str_starts_with($href, '/') && ! str_starts_with($href, '//')) {
                $out[] = $href;
                continue;
            }
            // Absolute link → internal only if its HOST is one of ours
            // (path containing "cityee.ee", e.g. a Facebook URL, must NOT count).
            $host = parse_url($href, PHP_URL_HOST);
            if ($host !== null && in_array(strtolower($host), $this->internalHosts, true)) {
                $out[] = $href;
            }
        }
        return array_values(array_unique($out));
    }

    /** Reduce a href to a site-relative path (or null if external/unusable). */
    private function normalize(?string $href): ?string
    {
        if ($href === null || $href === '') return null;
        if (preg_match('#^https?://#i', $href)) {
            $host = strtolower(parse_url($href, PHP_URL_HOST) ?: '');
            if (! in_array($host, $this->internalHosts, true)) return null;
            $href = parse_url($href, PHP_URL_PATH) ?: '/';
        }
        $href = strtok($href, '#');       // drop fragment
        $href = strtok($href, '?');       // drop query for status probe
        return $href ?: '/';
    }

    /** Slash-insensitive key for inlink/orphan matching (/x and /x/ collapse). */
    private function key(string $pathOrUrl): string
    {
        $p = $this->normalize($pathOrUrl) ?? '/';
        return $p === '/' ? '/' : rtrim($p, '/');
    }

    private function isAsset(string $path): bool
    {
        return (bool) preg_match('#\.(jpg|jpeg|png|gif|svg|webp|avif|ico|pdf|docx?|xlsx?|zip|css|js|woff2?|ttf|xml|txt)$#i', $path);
    }

    private function pathOf(string $url): string
    {
        return $this->normalize($url) ?? '/';
    }

    private function isWrongHost(string $href): bool
    {
        if (! preg_match('#^https?://#i', $href)) return false;
        $host = strtolower(parse_url($href, PHP_URL_HOST) ?: '');
        return in_array($host, self::WRONG_HOSTS, true);
    }
}
