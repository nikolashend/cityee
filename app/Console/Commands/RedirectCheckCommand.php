<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

/**
 * Redirect Chain Checker (PHASE Q — redirect-check)
 *
 * Reads config/seo_redirects.php and verifies:
 * - No redirect chains > 1 hop
 * - No redirect to self
 * - Optionally makes live HTTP checks
 *
 * Usage: php artisan cityee:redirect-check [--http]
 */
class RedirectCheckCommand extends Command
{
    protected $signature   = 'cityee:redirect-check {--http : Make live HTTP checks for all redirect sources}';
    protected $description = 'Check redirect map for chains, loops and invalid targets.';

    private const LEGACY_URLS = [
        'http://ru.cityee.ee/',
        'http://ru.cityee.ee/kontaktid',
        'https://ru.cityee.ee/kontaktid',
        'https://cityee.ee/index',
        'https://cityee.ee/ru/index',
        'https://cityee.ee/en/index',
        'https://cityee.ee/ru/guides?category=marketing',
        'https://cityee.ee/ru/audits?type=price_corridor',
        'http://www.cityee.ee/',
        'https://www.cityee.ee/',
    ];

    public function handle(): int
    {
        $this->info('Checking redirect map...');
        $redirects = config('seo_redirects', []);
        $issues    = [];

        // 1. Check for chains (A → B, B → C)
        foreach ($redirects as $from => $rule) {
            $target = $rule['target'] ?? null;
            if (! $target) { $issues[] = "MISSING target for {$from}"; continue; }
            if ($from === $target) { $issues[] = "SELF-REDIRECT: {$from}"; continue; }
            if (isset($redirects[$target])) {
                $issues[] = "CHAIN: {$from} → {$target} → " . ($redirects[$target]['target'] ?? '?') . " (RULE-016: max 1 hop)";
            }
        }

        if (! empty($issues)) {
            $this->error('Redirect issues found:');
            foreach ($issues as $i) $this->line('  - ' . $i);
        } else {
            $this->info('No redirect chains or loops found in static map.');
        }

        // 2. Verify middleware handles all GSC problem URLs
        $this->newLine();
        $this->info('Checking GSC legacy URL handling:');
        foreach (self::LEGACY_URLS as $url) {
            $parsed = parse_url($url);
            $scheme = $parsed['scheme'] ?? 'https';
            $host   = $parsed['host'] ?? '';
            $path   = $parsed['path'] ?? '/';
            $query  = isset($parsed['query']) ? '?' . $parsed['query'] : '';

            $handledBy = 'UNKNOWN';
            if ($scheme === 'http') {
                $handledBy = 'server-level (Nginx/Apache): http→https redirect';
            } elseif (str_contains($host, 'ru.cityee.ee')) {
                $handledBy = 'server-level (Nginx/Apache): subdomain→path redirect';
            } elseif (str_contains($host, 'www.cityee.ee')) {
                $handledBy = 'server-level (Nginx/Apache): www→non-www redirect';
            } elseif (str_ends_with(rtrim($path, '/'), '/index')) {
                $handledBy = 'CanonicalRedirects middleware + RedirectOldUrls';
            } elseif ($query) {
                $handledBy = 'RedirectOldUrls QUERY_REDIRECTS (301 to clean URL)';
            } else {
                $handledBy = 'No handler found — INVESTIGATE';
            }

            $this->line('  ' . $url . ' → ' . $handledBy);
        }

        // 3. Optional HTTP check
        if ($this->option('http')) {
            $this->newLine();
            $this->info('Running HTTP checks on legacy URLs...');
            foreach (self::LEGACY_URLS as $url) {
                $status = $this->getHttpStatus($url);
                $ok     = in_array($status, [301, 302]);
                $this->line('  ' . ($ok ? '<fg=green>[' . $status . ']</>' : '<fg=red>[' . $status . ']</>') . ' ' . $url);
            }
        }

        $dir = storage_path('app/seo-audit');
        if (! is_dir($dir)) mkdir($dir, 0755, true);

        file_put_contents($dir . '/redirect-check.json', json_encode([
            'generated' => now()->toIso8601String(),
            'issues'    => $issues,
            'legacy_urls' => self::LEGACY_URLS,
        ], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES));

        return empty($issues) ? self::SUCCESS : self::FAILURE;
    }

    private function getHttpStatus(string $url): int
    {
        $ctx = stream_context_create(['http' => ['method' => 'HEAD', 'timeout' => 8, 'follow_location' => false, 'ignore_errors' => true]]);
        $headers = @get_headers($url, true, $ctx);
        if ($headers) {
            $first = is_array($headers[0]) ? $headers[0][0] : $headers[0];
            preg_match('/HTTP\/\d\.?\d? (\d{3})/', $first, $m);
            return (int) ($m[1] ?? 0);
        }
        return 0;
    }
}
