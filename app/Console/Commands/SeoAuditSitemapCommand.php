<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Contracts\Http\Kernel as HttpKernel;
use Illuminate\Http\Request;

/**
 * seo:audit-sitemap — Verify every URL declared in the sitemap is a clean,
 * indexable 200. Fetches the sitemap index, follows into each child sitemap,
 * and requests every <loc> IN-PROCESS through the full middleware stack
 * (redirects, canonical, robots headers all apply). No network required.
 *
 * Flags a sitemap URL if it returns anything other than 200, if it redirects
 * (a sitemap must list final canonicals only), or if it carries X-Robots-Tag
 * noindex. Exits non-zero when any hard problem is found (CI-friendly).
 *
 * Usage: php artisan seo:audit-sitemap
 */
class SeoAuditSitemapCommand extends Command
{
    protected $signature   = 'seo:audit-sitemap {--sitemap=/sitemap.xml : Sitemap index path to start from}';
    protected $description = 'Audit every sitemap URL for 200 / no-redirect / indexable status.';

    public function handle(HttpKernel $kernel): int
    {
        $index = $this->option('sitemap');
        $this->info("Auditing sitemap: {$index}");

        // 1. Load sitemap index → child sitemaps → URLs.
        $childSitemaps = $this->extractLocs($this->fetchBody($kernel, $index), 'sitemap');
        if (empty($childSitemaps)) {
            // Not an index — treat the given file itself as a urlset.
            $childSitemaps = [$this->toAbsolute($index)];
        }

        $urls = [];
        foreach ($childSitemaps as $sm) {
            $path = $this->toPath($sm);
            foreach ($this->extractLocs($this->fetchBody($kernel, $path), 'url') as $loc) {
                $urls[$loc] = true; // dedupe
            }
        }
        $urls = array_keys($urls);

        if (empty($urls)) {
            $this->error('No <url><loc> entries found. Check sitemap generation.');
            return self::FAILURE;
        }

        $this->line('Child sitemaps: ' . count($childSitemaps) . ' | URLs: ' . count($urls));
        $this->newLine();

        // 2. Check each URL in-process.
        $problems = [];
        $counts   = [];
        foreach ($urls as $url) {
            $r = $this->probe($kernel, $this->toPath($url));
            $counts[$r['status']] = ($counts[$r['status']] ?? 0) + 1;

            $issue = null;
            if ($r['status'] >= 500) {
                $issue = '5xx SERVER ERROR';
            } elseif ($r['status'] === 403) {
                $issue = '403 FORBIDDEN';
            } elseif ($r['status'] === 404 || $r['status'] === 410) {
                $issue = $r['status'] . ' NOT FOUND';
            } elseif ($r['status'] >= 300 && $r['status'] < 400) {
                $issue = 'REDIRECT → ' . $r['location'] . ' (sitemap must list final URL)';
            } elseif ($r['noindex']) {
                $issue = 'NOINDEX header on a sitemap URL';
            }

            if ($issue) {
                $problems[] = compact('url') + ['status' => $r['status'], 'issue' => $issue];
            }
        }

        // 3. Report.
        ksort($counts);
        $this->info('Status distribution:');
        foreach ($counts as $code => $n) {
            $this->line(sprintf('  %-4s  %d', $code, $n));
        }
        $this->newLine();

        if (empty($problems)) {
            $this->info('PASS — all ' . count($urls) . ' sitemap URLs are clean 200 indexable pages.');
            return self::SUCCESS;
        }

        $this->error(count($problems) . ' problem URL(s):');
        $this->table(
            ['Status', 'Issue', 'URL'],
            array_map(fn ($p) => [$p['status'], $p['issue'], $p['url']], $problems)
        );
        return self::FAILURE;
    }

    /** Request a path in-process through the full HTTP middleware stack. */
    private function probe(HttpKernel $kernel, string $path): array
    {
        try {
            $response = $kernel->handle(Request::create($path, 'GET'));
            return [
                'status'   => $response->getStatusCode(),
                'location' => $response->headers->get('Location', ''),
                'noindex'  => str_contains(strtolower((string) $response->headers->get('X-Robots-Tag', '')), 'noindex'),
            ];
        } catch (\Throwable $e) {
            return ['status' => 500, 'location' => '', 'noindex' => false];
        }
    }

    private function fetchBody(HttpKernel $kernel, string $path): string
    {
        try {
            return $kernel->handle(Request::create($path, 'GET'))->getContent() ?: '';
        } catch (\Throwable $e) {
            return '';
        }
    }

    /** Extract <loc> values under <sitemap> or <url> parents. */
    private function extractLocs(string $xml, string $parent): array
    {
        if (trim($xml) === '') return [];
        libxml_use_internal_errors(true);
        $doc = simplexml_load_string($xml);
        if ($doc === false) return [];

        $locs = [];
        foreach ($doc->{$parent} ?? [] as $node) {
            $loc = trim((string) $node->loc);
            if ($loc !== '') $locs[] = $loc;
        }
        return $locs;
    }

    /** Absolute URL → app-local path (+query) for in-process dispatch. */
    private function toPath(string $url): string
    {
        $parts = parse_url($url);
        if (! isset($parts['scheme'])) {
            return $url; // already a path
        }
        return ($parts['path'] ?? '/') . (isset($parts['query']) ? '?' . $parts['query'] : '');
    }

    private function toAbsolute(string $path): string
    {
        return rtrim((string) config('app.url'), '/') . '/' . ltrim($path, '/');
    }
}
