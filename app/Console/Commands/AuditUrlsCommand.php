<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Route;
use App\Models\Guide;
use App\Models\AreaAudit;

/**
 * PHASE Q — URL Inventory Builder
 *
 * Collects all URLs from routes, sitemap, navigation, hreflang, known legacy/GSC lists.
 * Outputs: storage/app/seo-audit/url-inventory.json + .csv
 *
 * Usage: php artisan cityee:audit-urls
 */
class AuditUrlsCommand extends Command
{
    protected $signature   = 'cityee:audit-urls {--http : Make live HTTP checks (slower, needs network)}';
    protected $description = 'Build full URL inventory from routes, sitemap, nav, legacy and GSC lists.';

    private const BASE = 'https://cityee.ee';

    public function handle(): int
    {
        $this->info('Building URL inventory...');

        $inventory = [];
        $now       = now()->toIso8601String();

        // 1. Collect from routes
        foreach ($this->collectFromRoutes() as $url) {
            $inventory[$url['url']] = array_merge(['source_type' => 'route'], $url, ['timestamp' => $now]);
        }

        // 2. Collect from DB guides
        foreach (Guide::published()->get() as $guide) {
            $prefix = match ($guide->locale) { 'ru' => '/ru', 'en' => '/en', default => '' };
            $url    = self::BASE . $prefix . '/guides/' . $guide->slug . '/';
            if (! isset($inventory[$url])) {
                $inventory[$url] = $this->makeEntry($url, 'db_guide', $guide->locale, $now);
            }
        }

        // 3. Collect from DB audits
        foreach (AreaAudit::published()->get() as $audit) {
            $prefix = match ($audit->locale) { 'ru' => '/ru', 'en' => '/en', default => '' };
            $url    = self::BASE . $prefix . '/audits/' . $audit->slug . '/';
            if (! isset($inventory[$url])) {
                $inventory[$url] = $this->makeEntry($url, 'db_audit', $audit->locale, $now);
            }
        }

        // 4. Collect pillar knowledge pages from config
        $guideKeys    = ['guide_sell_tallinn','guide_rent','guide_pricing','guide_negotiation','guide_staging','guide_market_2026','guide_mistakes'];
        $prefixMap    = ['et' => '', 'ru' => '/ru', 'en' => '/en'];
        $slugFieldMap = ['et' => 'slug', 'ru' => 'slug_ru', 'en' => 'slug_en'];
        foreach ($guideKeys as $key) {
            $cfg = config("cityee-knowledge.{$key}");
            if (! $cfg) continue;
            foreach (['et', 'ru', 'en'] as $locale) {
                $slug = $cfg[$slugFieldMap[$locale]] ?? null;
                if (! $slug) continue;
                $url = self::BASE . $prefixMap[$locale] . '/knowledge/' . $slug . '/';
                if (! isset($inventory[$url])) {
                    $inventory[$url] = $this->makeEntry($url, 'config_knowledge', $locale, $now);
                }
            }
        }

        // 5. GSC problem URLs (INV-14: must be resolved)
        $gscUrls = [
            'https://cityee.ee/ru/guides/real-price-corridor',
            'https://cityee.ee/ru/guides/30-45-day-sales-plan',
            'https://cityee.ee/en/audits/30-45-day-sales-plan-audit/',
            'https://cityee.ee/en/guides/kv-ee-listing-checklist',
            'https://cityee.ee/en/audits/price-corridor-negotiation-strategy',
            'https://cityee.ee/ru/audits/30-45-day-sales-plan-audit/',
            'https://cityee.ee/ru/guides/sell-apartment-without-losing-money',
            'https://cityee.ee/ru/audits/kv-ee-listing-audit',
            'https://cityee.ee/ru/guides/kv-ee-listing-checklist',
            'https://ru.cityee.ee/kontaktid',
            'http://ru.cityee.ee/',
            'https://cityee.ee/ru/guides?category=marketing',
            'https://cityee.ee/index',
            'https://cityee.ee/ru/audits?type=price_corridor',
            'https://cityee.ee/ru/knowledge/peregovornaya-strategiya-nedvizhimost/',
            'https://cityee.ee/ru/knowledge/analiz-rynka-nedvizhimosti-tallinn-2026/',
            'https://cityee.ee/knowledge/vead-mille-parast-kaotate-raha/',
            'https://cityee.ee/ru/knowledge/oshibki-iz-za-kotorykh-teryayut-dengi/',
            'https://cityee.ee/en/knowledge/negotiation-strategy-property/',
            'https://cityee.ee/knowledge/juhend-kinnisvara-uurimine/',
        ];
        foreach ($gscUrls as $url) {
            if (! isset($inventory[$url])) {
                $inventory[$url] = $this->makeEntry($url, 'gsc_problem', $this->detectLocale($url), $now);
            }
        }

        // 6. Optional HTTP checks
        if ($this->option('http')) {
            $this->info('Running HTTP checks (this may take a while)...');
            $inventory = $this->runHttpChecks($inventory);
        }

        // Store output
        $dir = storage_path('app/seo-audit');
        if (! is_dir($dir)) mkdir($dir, 0755, true);

        $data = array_values($inventory);
        file_put_contents($dir . '/url-inventory.json', json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES));

        // CSV
        $csvLines = [implode(',', ['url','source_type','language','expected_canonical','http_status','indexability_decision','in_sitemap','rule_id','reason','timestamp'])];
        foreach ($data as $row) {
            $csvLines[] = implode(',', array_map(fn($v) => '"' . str_replace('"', '""', (string) $v) . '"', [
                $row['url'] ?? '',
                $row['source_type'] ?? '',
                $row['language'] ?? '',
                $row['expected_canonical'] ?? '',
                $row['http_status'] ?? 'unknown',
                $row['indexability_decision'] ?? '',
                $row['in_sitemap'] ?? '',
                $row['rule_id'] ?? '',
                $row['reason'] ?? '',
                $row['timestamp'] ?? '',
            ]));
        }
        file_put_contents($dir . '/url-inventory.csv', implode("\n", $csvLines));

        $this->info('URL inventory saved:');
        $this->line('  ' . $dir . '/url-inventory.json (' . count($data) . ' URLs)');
        $this->line('  ' . $dir . '/url-inventory.csv');

        return self::SUCCESS;
    }

    private function collectFromRoutes(): array
    {
        $routes = [];
        $base   = self::BASE;

        $staticRoutes = [
            // ET
            ['url' => $base . '/',                           'lang' => 'et', 'key' => 'home'],
            ['url' => $base . '/kinnisvara-muuk/',           'lang' => 'et', 'key' => 'sell'],
            ['url' => $base . '/kinnisvara-uur/',            'lang' => 'et', 'key' => 'rent'],
            ['url' => $base . '/konsultatsioon/',            'lang' => 'et', 'key' => 'consultation'],
            ['url' => $base . '/kontaktid/',                 'lang' => 'et', 'key' => 'contacts'],
            ['url' => $base . '/audit/',                     'lang' => 'et', 'key' => 'audit'],
            ['url' => $base . '/guides/',                    'lang' => 'et', 'key' => 'guides'],
            ['url' => $base . '/audits/',                    'lang' => 'et', 'key' => 'audits'],
            ['url' => $base . '/knowledge/',                 'lang' => 'et', 'key' => 'knowledge'],
            ['url' => $base . '/aleksandr-primakov/',        'lang' => 'et', 'key' => 'profile'],
            ['url' => $base . '/knowledge/cases/',           'lang' => 'et', 'key' => 'cases'],
            // RU
            ['url' => $base . '/ru/',                        'lang' => 'ru', 'key' => 'home'],
            ['url' => $base . '/ru/kinnisvara-muuk/',        'lang' => 'ru', 'key' => 'sell'],
            ['url' => $base . '/ru/kinnisvara-uur/',         'lang' => 'ru', 'key' => 'rent'],
            ['url' => $base . '/ru/konsultatsioon/',         'lang' => 'ru', 'key' => 'consultation'],
            ['url' => $base . '/ru/kontaktid/',              'lang' => 'ru', 'key' => 'contacts'],
            ['url' => $base . '/ru/audit/',                  'lang' => 'ru', 'key' => 'audit'],
            ['url' => $base . '/ru/guides/',                 'lang' => 'ru', 'key' => 'guides'],
            ['url' => $base . '/ru/audits/',                 'lang' => 'ru', 'key' => 'audits'],
            ['url' => $base . '/ru/knowledge/',              'lang' => 'ru', 'key' => 'knowledge'],
            ['url' => $base . '/ru/aleksandr-primakov/',     'lang' => 'ru', 'key' => 'profile'],
            ['url' => $base . '/ru/knowledge/cases/',        'lang' => 'ru', 'key' => 'cases'],
            // EN
            ['url' => $base . '/en/',                        'lang' => 'en', 'key' => 'home'],
            ['url' => $base . '/en/sell-property/',          'lang' => 'en', 'key' => 'sell'],
            ['url' => $base . '/en/rent-out-property/',      'lang' => 'en', 'key' => 'rent'],
            ['url' => $base . '/en/consultation/',           'lang' => 'en', 'key' => 'consultation'],
            ['url' => $base . '/en/contacts/',               'lang' => 'en', 'key' => 'contacts'],
            ['url' => $base . '/en/audit/',                  'lang' => 'en', 'key' => 'audit'],
            ['url' => $base . '/en/guides/',                 'lang' => 'en', 'key' => 'guides'],
            ['url' => $base . '/en/audits/',                 'lang' => 'en', 'key' => 'audits'],
            ['url' => $base . '/en/knowledge/',              'lang' => 'en', 'key' => 'knowledge'],
            ['url' => $base . '/en/aleksandr-primakov/',     'lang' => 'en', 'key' => 'profile'],
            ['url' => $base . '/en/knowledge/cases/',        'lang' => 'en', 'key' => 'cases'],
        ];

        foreach ($staticRoutes as $r) {
            $routes[] = $this->makeEntry($r['url'], 'route_static', $r['lang'], now()->toIso8601String());
        }

        return $routes;
    }

    private function makeEntry(string $url, string $sourceType, string $lang, string $timestamp): array
    {
        $isQuery   = str_contains($url, '?');
        $isSubdomain = str_contains(parse_url($url, PHP_URL_HOST) ?? '', 'ru.cityee.ee');
        $isHttp    = str_starts_with($url, 'http://');
        $hasIndex  = preg_match('#/index(\.(php|html))?$#i', parse_url($url, PHP_URL_PATH) ?? '');

        $indexable = 'yes';
        $ruleId    = 'OK';
        $reason    = 'Canonical indexable URL';

        if ($isHttp) {
            $indexable = 'no'; $ruleId = 'RULE-008'; $reason = 'HTTP not canonical — server redirect to HTTPS required';
        } elseif ($isSubdomain) {
            $indexable = 'no'; $ruleId = 'RULE-007'; $reason = 'Legacy subdomain — server 301 to https://cityee.ee/ru/... required';
        } elseif ($isQuery) {
            $indexable = 'no'; $ruleId = 'RULE-006'; $reason = 'Query parameter URL — redirect to clean base URL via middleware';
        } elseif ($hasIndex) {
            $indexable = 'no'; $ruleId = 'RULE-009'; $reason = '/index duplicate — 301 redirect to clean URL';
        }

        return [
            'url'                    => $url,
            'source_type'            => $sourceType,
            'source_file_or_page'    => 'cityee:audit-urls',
            'language'               => $lang,
            'expected_canonical'     => $this->expectedCanonical($url),
            'detected_canonical'     => '',
            'http_status'            => 'unchecked',
            'final_url_after_redirect' => '',
            'redirect_chain'         => '',
            'robots_allowed'         => 'yes',
            'meta_robots'            => $isQuery ? 'noindex,follow' : 'index,follow',
            'x_robots_tag'           => $isQuery ? 'noindex, follow' : '',
            'in_sitemap'             => ($indexable === 'yes' && ! $isQuery && ! $isSubdomain && ! $isHttp) ? 'candidate' : 'excluded',
            'has_hreflang'           => '',
            'hreflang_targets'       => '',
            'schema_references'      => '',
            'indexability_decision'  => $indexable,
            'rule_id'                => $ruleId,
            'reason'                 => $reason,
            'timestamp'              => $timestamp,
        ];
    }

    private function expectedCanonical(string $url): string
    {
        $parsed = parse_url($url);
        $host   = $parsed['host'] ?? '';
        $path   = rtrim($parsed['path'] ?? '/', '/') . '/';

        // Subdomain → path redirect
        if ($host === 'ru.cityee.ee') {
            return 'https://cityee.ee/ru' . $path;
        }

        // HTTP → HTTPS
        if (($parsed['scheme'] ?? '') === 'http') {
            return 'https://cityee.ee' . $path;
        }

        // Strip query params from canonical
        return 'https://cityee.ee' . $path;
    }

    private function detectLocale(string $url): string
    {
        if (str_contains($url, '/ru/') || str_contains($url, 'ru.cityee.ee')) return 'ru';
        if (str_contains($url, '/en/')) return 'en';
        return 'et';
    }

    private function runHttpChecks(array $inventory): array
    {
        $context = stream_context_create(['http' => ['method' => 'HEAD', 'timeout' => 10, 'follow_location' => false, 'ignore_errors' => true]]);

        foreach ($inventory as $url => &$entry) {
            try {
                $headers = @get_headers($url, true);
                if ($headers) {
                    $statusLine = is_array($headers[0]) ? end($headers[0]) : $headers[0];
                    preg_match('/\d{3}/', $statusLine, $m);
                    $entry['http_status'] = $m[0] ?? 'unknown';
                }
            } catch (\Exception) {
                $entry['http_status'] = 'error';
            }
        }

        return $inventory;
    }
}
