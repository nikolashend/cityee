<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Contracts\Http\Kernel as HttpKernel;
use Illuminate\Http\Request;

/**
 * seo:audit-urls — Replay the curated list of GSC-critical URLs in-process
 * through the full middleware stack and report status + redirect target.
 *
 * Verifies the indexation contract:
 *   - important public pages          → 200
 *   - obsolete/changed slugs          → 301 (one hop) to a live equivalent
 *   - query-filter URLs               → 301 to clean canonical
 *   - invalid slugs                   → 404 (never 403 / 5xx)
 *
 * Use --googlebot to send the Googlebot User-Agent (parity check — the app
 * must return the SAME status; any 403 for Googlebot is a CDN/WAF issue, not
 * a Laravel one — see docs/seo-indexation-diagnosis.md).
 *
 * Usage:
 *   php artisan seo:audit-urls
 *   php artisan seo:audit-urls --googlebot
 */
class SeoAuditUrlsCommand extends Command
{
    protected $signature   = 'seo:audit-urls {--googlebot : Send Googlebot User-Agent (parity check)}';
    protected $description = 'Replay GSC-critical URLs and assert expected status codes.';

    /** path => expected status ('200', '301', '404', or '3xx' for any redirect). */
    private const EXPECTATIONS = [
        // Core pages — must be 200
        '/'                                 => '200',
        '/ru'                               => '200',
        '/ru/'                              => '200',
        '/en'                               => '200',
        '/kinnisvara-muuk'                  => '200',
        '/ru/kinnisvara-muuk'               => '200',
        '/en/sell-property'                 => '200',
        '/kontaktid'                        => '200',
        '/ru/kontaktid'                     => '200',
        '/en/contacts'                      => '200',
        '/audit'                            => '200',
        '/guides'                           => '200',
        '/ru/guides'                        => '200',
        '/en/guides'                        => '200',
        '/aleksandr-primakov'               => '200',
        '/muua-ise-vs-strateegiline-partner'=> '200',
        '/knowledge/labirakimiste-strateegia-kinnisvara'  => '200',
        '/knowledge/vead-mille-parast-kaotate-raha'       => '200',
        '/knowledge/kuidas-valmistada-korter-muugiks'     => '200',
        '/ru/knowledge/kak-podgotovit-kvartiru-k-prodazhe'=> '200',
        '/en/knowledge/mistakes-that-cost-money'          => '200',

        // Query-filter URLs — must 301 to clean canonical
        '/guides?category=pricing'          => '301',
        '/guides?category=rent'             => '301',
        '/ru/guides?category=rent'          => '301',
        '/en/guides?category=pricing'       => '301',

        // Obsolete / changed slugs — must 301 to a live equivalent
        '/en/index'                         => '301',
        '/index'                            => '301',
        '/knowledge/labiraakimiste-strateegia-kinnisvara' => '301',
        '/ru/kvartira-ne-prodaetsya'        => '301',
        '/guides/seo-strategi-2026'         => '301',
        '/guides/geo-aeo-ai-optimizatsiya'  => '301',

        // Invalid slugs — must 404 (never 403 / 5xx)
        '/knowledge/this-does-not-exist'    => '404',
        '/guides/nonexistent-guide'         => '404',
    ];

    private const GOOGLEBOT_UA = 'Mozilla/5.0 (compatible; Googlebot/2.1; +http://www.google.com/bot.html)';

    public function handle(HttpKernel $kernel): int
    {
        $asBot = (bool) $this->option('googlebot');
        $this->info('Auditing ' . count(self::EXPECTATIONS) . ' URLs' . ($asBot ? ' as Googlebot' : '') . '...');
        $this->newLine();

        $rows   = [];
        $failed = 0;

        foreach (self::EXPECTATIONS as $path => $expected) {
            $r      = $this->probe($kernel, $path, $asBot);
            $ok     = $this->matches($r['status'], $expected);
            $failed += $ok ? 0 : 1;

            $rows[] = [
                $ok ? 'OK' : 'FAIL',
                $expected,
                $r['status'],
                $r['location'] ? '→ ' . $r['location'] : '',
                $path,
            ];
        }

        $this->table(['', 'Want', 'Got', 'Redirect', 'URL'], $rows);
        $this->newLine();

        if ($failed === 0) {
            $this->info('PASS — all ' . count(self::EXPECTATIONS) . ' URLs match expectations.');
            return self::SUCCESS;
        }

        $this->error("FAIL — {$failed} URL(s) did not match expected status.");
        if ($asBot) {
            $this->warn('Note: a mismatch under --googlebot that passes without it indicates a '
                . 'CDN/WAF User-Agent issue, not a Laravel bug.');
        }
        return self::FAILURE;
    }

    private function probe(HttpKernel $kernel, string $path, bool $asBot): array
    {
        $server = $asBot ? ['HTTP_USER_AGENT' => self::GOOGLEBOT_UA] : [];
        try {
            $request  = Request::create($path, 'GET', [], [], [], $server);
            $response = $kernel->handle($request);
            $loc      = $response->headers->get('Location', '');
            // Show only the path of the redirect target for readability.
            if ($loc) {
                $loc = parse_url($loc, PHP_URL_PATH) . (parse_url($loc, PHP_URL_QUERY) ? '?' . parse_url($loc, PHP_URL_QUERY) : '');
            }
            return ['status' => $response->getStatusCode(), 'location' => $loc];
        } catch (\Throwable $e) {
            return ['status' => 500, 'location' => ''];
        }
    }

    private function matches(int $status, string $expected): bool
    {
        return match ($expected) {
            '200'   => $status === 200,
            '301'   => $status === 301,
            '3xx'   => $status >= 300 && $status < 400,
            '404'   => $status === 404,
            '410'   => $status === 410,
            default => (string) $status === $expected,
        };
    }
}
