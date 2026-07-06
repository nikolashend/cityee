<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Guide;
use App\Models\AreaAudit;

/**
 * Sitemap Rebuild Command (PHASE Q — sitemap-rebuild)
 *
 * Validates all URLs that would appear in sitemaps and outputs a verified list.
 * Does NOT modify live sitemap (which is dynamic via SitemapController).
 * Instead outputs: storage/app/seo-audit/sitemap-audit.json
 *
 * Usage: php artisan cityee:sitemap-rebuild
 */
class SitemapRebuildCommand extends Command
{
    protected $signature   = 'cityee:sitemap-rebuild';
    protected $description = 'Validate and rebuild sitemap URL list from canonical sources.';

    private const BASE = 'https://cityee.ee';

    public function handle(): int
    {
        $this->info('Rebuilding sitemap audit...');

        $allUrls  = [];
        $excluded = [];
        $today    = now()->toDateString();

        // Main sitemap URLs (from SitemapController static list)
        $mainUrls = $this->getMainUrls($today);
        $allUrls  = array_merge($allUrls, $mainUrls);

        // Guide URLs from DB
        $guideUrls = $this->getGuideUrls($today);
        $allUrls   = array_merge($allUrls, $guideUrls);

        // Audit URLs from DB
        $auditUrls = $this->getAuditUrls($today);
        $allUrls   = array_merge($allUrls, $auditUrls);

        // Knowledge URLs from config
        $knowledgeUrls = $this->getKnowledgeUrls($today);
        $allUrls       = array_merge($allUrls, $knowledgeUrls);

        // Phase3 URLs from config
        $phase3Urls = $this->getPhase3Urls($today);
        $allUrls    = array_merge($allUrls, $phase3Urls);

        // Validate each URL
        $validated = [];
        foreach ($allUrls as $entry) {
            $issues = $this->validateEntry($entry);
            if (! empty($issues)) {
                $entry['sitemap_include'] = false;
                $entry['exclusion_reasons'] = $issues;
                $excluded[] = $entry;
            } else {
                $entry['sitemap_include'] = true;
                $validated[] = $entry;
            }
        }

        $this->info('Results:');
        $this->line('  Include: ' . count($validated));
        $this->line('  Exclude: ' . count($excluded));

        if (! empty($excluded)) {
            $this->warn('Excluded URLs:');
            foreach ($excluded as $e) {
                $this->line('  - ' . $e['loc'] . ' → ' . implode(', ', $e['exclusion_reasons']));
            }
        }

        $dir = storage_path('app/seo-audit');
        if (! is_dir($dir)) mkdir($dir, 0755, true);

        file_put_contents($dir . '/sitemap-audit.json', json_encode([
            'generated'  => now()->toIso8601String(),
            'total'      => count($allUrls),
            'included'   => count($validated),
            'excluded'   => count($excluded),
            'urls'       => $validated,
            'excluded_urls' => $excluded,
        ], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES));

        $this->info('Sitemap audit saved: ' . $dir . '/sitemap-audit.json');

        return self::SUCCESS;
    }

    private function validateEntry(array $entry): array
    {
        $issues = [];
        $loc    = $entry['loc'] ?? '';

        if (! str_starts_with($loc, 'https://')) $issues[] = 'RULE-008: not HTTPS';
        if (! str_starts_with($loc, 'https://cityee.ee/')) $issues[] = 'RULE-012: wrong domain';
        if (str_contains($loc, '?')) $issues[] = 'RULE-006: has query params';
        if (str_contains($loc, '//cityee.ee//')) $issues[] = 'double slash';
        if (str_contains($loc, '/index')) $issues[] = 'RULE-009: /index in URL';

        return $issues;
    }

    private function getMainUrls(string $today): array
    {
        $base    = self::BASE;
        $entries = [];
        $slugs   = [
            ['loc' => $base . '/',                          'priority' => '1.0'],
            ['loc' => $base . '/kinnisvara-muuk/',          'priority' => '0.9'],
            ['loc' => $base . '/kinnisvara-uur/',           'priority' => '0.9'],
            ['loc' => $base . '/konsultatsioon/',           'priority' => '0.8'],
            ['loc' => $base . '/kontaktid/',                'priority' => '0.7'],
            ['loc' => $base . '/audit/',                    'priority' => '0.8'],
            ['loc' => $base . '/guides/',                   'priority' => '0.8'],
            ['loc' => $base . '/audits/',                   'priority' => '0.8'],
            ['loc' => $base . '/knowledge/',                'priority' => '0.7'],
            ['loc' => $base . '/aleksandr-primakov/',       'priority' => '0.7'],
            ['loc' => $base . '/ru/',                       'priority' => '1.0'],
            ['loc' => $base . '/ru/kinnisvara-muuk/',       'priority' => '0.9'],
            ['loc' => $base . '/ru/kinnisvara-uur/',        'priority' => '0.9'],
            ['loc' => $base . '/ru/kontaktid/',             'priority' => '0.7'],
            ['loc' => $base . '/ru/guides/',                'priority' => '0.8'],
            ['loc' => $base . '/ru/audits/',                'priority' => '0.8'],
            ['loc' => $base . '/en/',                       'priority' => '1.0'],
            ['loc' => $base . '/en/sell-property/',         'priority' => '0.9'],
            ['loc' => $base . '/en/guides/',                'priority' => '0.8'],
            ['loc' => $base . '/en/audits/',                'priority' => '0.8'],
        ];

        foreach ($slugs as $s) {
            $entries[] = ['loc' => $s['loc'], 'priority' => $s['priority'], 'lastmod' => $today, 'source' => 'main', 'changefreq' => 'monthly'];
        }

        return $entries;
    }

    private function getGuideUrls(string $today): array
    {
        $base    = self::BASE;
        $entries = [];
        foreach (Guide::published()->get() as $guide) {
            $prefix    = match ($guide->locale) { 'ru' => '/ru', 'en' => '/en', default => '' };
            $entries[] = [
                'loc'        => $base . $prefix . '/guides/' . $guide->slug . '/',
                'priority'   => '0.8',
                'lastmod'    => $guide->updated_at?->toDateString() ?? $today,
                'source'     => 'db_guide',
                'changefreq' => 'monthly',
            ];
        }
        return $entries;
    }

    private function getAuditUrls(string $today): array
    {
        $base    = self::BASE;
        $entries = [];
        foreach (AreaAudit::published()->get() as $audit) {
            $prefix    = match ($audit->locale) { 'ru' => '/ru', 'en' => '/en', default => '' };
            $entries[] = [
                'loc'        => $base . $prefix . '/audits/' . $audit->slug . '/',
                'priority'   => '0.8',
                'lastmod'    => $audit->updated_at?->toDateString() ?? $today,
                'source'     => 'db_audit',
                'changefreq' => 'monthly',
            ];
        }
        return $entries;
    }

    private function getKnowledgeUrls(string $today): array
    {
        $base         = self::BASE;
        $entries      = [];
        $guideKeys    = ['guide_sell_tallinn','guide_rent','guide_pricing','guide_negotiation','guide_staging','guide_market_2026','guide_mistakes'];
        $prefixMap    = ['et' => '', 'ru' => '/ru', 'en' => '/en'];
        $slugFieldMap = ['et' => 'slug', 'ru' => 'slug_ru', 'en' => 'slug_en'];

        foreach ($guideKeys as $key) {
            $cfg = config("cityee-knowledge.{$key}");
            if (! $cfg) continue;
            foreach (['et', 'ru', 'en'] as $locale) {
                $slug = $cfg[$slugFieldMap[$locale]] ?? null;
                if (! $slug) continue;
                $entries[] = [
                    'loc'        => $base . $prefixMap[$locale] . '/knowledge/' . $slug . '/',
                    'priority'   => '0.85',
                    'lastmod'    => $cfg['date_modified'] ?? $today,
                    'source'     => 'config_knowledge',
                    'changefreq' => 'monthly',
                ];
            }
        }
        return $entries;
    }

    private function getPhase3Urls(string $today): array
    {
        $base    = self::BASE;
        $entries = [];

        $landings = config('cityee-phase3.landings', []);
        foreach ($landings as $slug => $data) {
            $entries[] = ['loc' => "{$base}/ru/{$slug}/", 'priority' => '0.9', 'lastmod' => $today, 'source' => 'phase3', 'changefreq' => 'monthly'];
        }

        $entries[] = ['loc' => "{$base}/ru/tallinn/", 'priority' => '0.8', 'lastmod' => $today, 'source' => 'phase3', 'changefreq' => 'monthly'];

        $districts = config('cityee-phase3.districts', []);
        foreach ($districts as $slug => $data) {
            $entries[] = ['loc' => "{$base}/ru/tallinn/{$slug}/", 'priority' => '0.8', 'lastmod' => $today, 'source' => 'phase3', 'changefreq' => 'monthly'];
        }

        return $entries;
    }
}
