<?php

namespace App\Http\Controllers;

use App\Models\Guide;
use App\Models\AreaAudit;
use Illuminate\Http\Response;

class SitemapController extends Controller
{
    private const BASE = 'https://cityee.ee';

    /**
     * Sitemap index — points to section sitemaps (main, guides, audits).
     * GET /sitemap.xml
     */
    public function index(): Response
    {
        $today = now()->toDateString();
        $base  = self::BASE;

        $sitemaps = [
            "{$base}/sitemap-main.xml",
            "{$base}/sitemap-guides.xml",
            "{$base}/sitemap-audits.xml",
            "{$base}/sitemap-locations.xml",
        ];

        $xml = '<?xml version="1.0" encoding="UTF-8"?>' . "\n";
        $xml .= '<sitemapindex xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">' . "\n";

        foreach ($sitemaps as $loc) {
            $xml .= "  <sitemap>\n    <loc>{$loc}</loc>\n    <lastmod>{$today}</lastmod>\n  </sitemap>\n";
        }

        $xml .= '</sitemapindex>';

        return response($xml, 200)->withHeaders([
            'Content-Type'  => 'application/xml; charset=UTF-8',
            'Cache-Control' => 'public, max-age=3600, s-maxage=3600',
            'X-Robots-Tag'  => 'noindex',
        ]);
    }

    /**
     * Main sitemap — all static pages, all 3 languages, with hreflang alternates.
     * GET /sitemap-main.xml
     */
    public function main(): Response
    {
        $today = now()->toDateString();
        $base  = self::BASE;

        $hreflangMap = $this->buildHreflangMap();

        // All pages across all 3 languages
        $allPages = [];
        foreach (['et', 'ru', 'en'] as $lang) {
            foreach ($this->pagesForLang($lang) as $page) {
                $allPages[] = $page;
            }
        }

        $xml = '<?xml version="1.0" encoding="UTF-8"?>' . "\n";
        $xml .= '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9"' . "\n";
        $xml .= '        xmlns:xhtml="http://www.w3.org/1999/xhtml">' . "\n";

        foreach ($allPages as $page) {
            $xml .= "  <url>\n";
            $xml .= "    <loc>{$page['loc']}</loc>\n";
            $xml .= "    <lastmod>{$page['lastmod']}</lastmod>\n";
            $xml .= "    <changefreq>{$page['changefreq']}</changefreq>\n";
            $xml .= "    <priority>{$page['priority']}</priority>\n";

            foreach ($page['alternates'] as $alt) {
                $xml .= '    <xhtml:link rel="alternate" hreflang="' . $alt['lang'] . '" href="' . $alt['href'] . '" />' . "\n";
            }

            $xml .= "  </url>\n";
        }

        $xml .= '</urlset>';

        return response($xml, 200)->withHeaders([
            'Content-Type'  => 'application/xml; charset=UTF-8',
            'Cache-Control' => 'public, max-age=3600, s-maxage=3600',
            'X-Robots-Tag'  => 'noindex',
        ]);
    }

    /**
     * Guides sitemap — published guides from DB.
     * GET /sitemap-guides.xml
     */
    public function guides(): Response
    {
        $base = self::BASE;

        $xml = '<?xml version="1.0" encoding="UTF-8"?>' . "\n";
        $xml .= '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9"' . "\n";
        $xml .= '        xmlns:xhtml="http://www.w3.org/1999/xhtml">' . "\n";

        try {
            $allGuides = Guide::published()->get();
            $grouped = $allGuides->groupBy('slug');

            foreach ($grouped as $slug => $versions) {
                foreach ($versions as $guide) {
                    $prefix = match ($guide->locale) {
                        'ru' => '/ru', 'en' => '/en', default => '',
                    };
                    $loc = "{$base}{$prefix}/guides/{$slug}";

                    $xml .= "  <url>\n";
                    $xml .= "    <loc>{$loc}</loc>\n";
                    $xml .= "    <lastmod>" . ($guide->updated_at ?? now())->toDateString() . "</lastmod>\n";
                    $xml .= "    <changefreq>monthly</changefreq>\n";
                    $xml .= "    <priority>{$guide->priority}</priority>\n";

                    // Add hreflang for all versions of this slug
                    $hreflangCode = fn($l) => match($l) { 'et' => 'et-EE', 'ru' => 'ru-EE', 'en' => 'en-EE', default => $l };
                    foreach ($versions as $alt) {
                        $altPrefix = match ($alt->locale) {
                            'ru' => '/ru', 'en' => '/en', default => '',
                        };
                        $xml .= '    <xhtml:link rel="alternate" hreflang="' . $hreflangCode($alt->locale) . '" href="' . $base . $altPrefix . '/guides/' . $slug . '" />' . "\n";
                    }
                    // x-default = ET version
                    $etVersion = $versions->firstWhere('locale', 'et');
                    if ($etVersion) {
                        $xml .= '    <xhtml:link rel="alternate" hreflang="x-default" href="' . $base . '/guides/' . $slug . '" />' . "\n";
                    }

                    $xml .= "  </url>\n";
                }
            }
        } catch (\Exception $e) {
            // Table may not exist yet — return empty
        }

        $xml .= '</urlset>';

        return response($xml, 200)->withHeaders([
            'Content-Type'  => 'application/xml; charset=UTF-8',
            'Cache-Control' => 'public, max-age=3600, s-maxage=3600',
            'X-Robots-Tag'  => 'noindex',
        ]);
    }

    /**
     * Audits sitemap — published area audits from DB.
     * GET /sitemap-audits.xml
     */
    public function audits(): Response
    {
        $base = self::BASE;

        $xml = '<?xml version="1.0" encoding="UTF-8"?>' . "\n";
        $xml .= '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9"' . "\n";
        $xml .= '        xmlns:xhtml="http://www.w3.org/1999/xhtml">' . "\n";

        try {
            $allAudits = AreaAudit::published()->get();
            $grouped = $allAudits->groupBy('slug');

            foreach ($grouped as $slug => $versions) {
                foreach ($versions as $audit) {
                    $prefix = match ($audit->locale) {
                        'ru' => '/ru', 'en' => '/en', default => '',
                    };
                    $loc = "{$base}{$prefix}/audits/{$slug}";

                    $xml .= "  <url>\n";
                    $xml .= "    <loc>{$loc}</loc>\n";
                    $xml .= "    <lastmod>" . ($audit->updated_at ?? now())->toDateString() . "</lastmod>\n";
                    $xml .= "    <changefreq>monthly</changefreq>\n";
                    $xml .= "    <priority>{$audit->priority}</priority>\n";

                    $hreflangCode = fn($l) => match($l) { 'et' => 'et-EE', 'ru' => 'ru-EE', 'en' => 'en-EE', default => $l };
                    foreach ($versions as $alt) {
                        $altPrefix = match ($alt->locale) {
                            'ru' => '/ru', 'en' => '/en', default => '',
                        };
                        $xml .= '    <xhtml:link rel="alternate" hreflang="' . $hreflangCode($alt->locale) . '" href="' . $base . $altPrefix . '/audits/' . $slug . '" />' . "\n";
                    }
                    $etVersion = $versions->firstWhere('locale', 'et');
                    if ($etVersion) {
                        $xml .= '    <xhtml:link rel="alternate" hreflang="x-default" href="' . $base . '/audits/' . $slug . '" />' . "\n";
                    }

                    $xml .= "  </url>\n";
                }
            }
        } catch (\Exception $e) {
            // Table may not exist yet — return empty
        }

        $xml .= '</urlset>';

        return response($xml, 200)->withHeaders([
            'Content-Type'  => 'application/xml; charset=UTF-8',
            'Cache-Control' => 'public, max-age=3600, s-maxage=3600',
            'X-Robots-Tag'  => 'noindex',
        ]);
    }

    /**
     * Locations sitemap — static location pages from config.
     * GET /sitemap-locations.xml
     */
    public function locations(): Response
    {
        $base = self::BASE;
        $locations = config('cityee-v3.locations', []);

        $xml = '<?xml version="1.0" encoding="UTF-8"?>' . "\n";
        $xml .= '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9"' . "\n";
        $xml .= '        xmlns:xhtml="http://www.w3.org/1999/xhtml">' . "\n";

        $hreflangCode = fn($l) => match($l) { 'et' => 'et-EE', 'ru' => 'ru-EE', 'en' => 'en-EE', default => $l };
        $prefixMap = ['et' => '', 'ru' => '/ru', 'en' => '/en'];

        foreach ($locations as $slug => $locData) {
            $availableLocales = array_intersect(['et', 'ru', 'en'], array_keys($locData));

            foreach ($availableLocales as $locale) {
                $prefix = $prefixMap[$locale] ?? '';
                $loc = "{$base}{$prefix}/locations/{$slug}";

                $xml .= "  <url>\n";
                $xml .= "    <loc>{$loc}</loc>\n";
                $xml .= "    <changefreq>monthly</changefreq>\n";
                $xml .= "    <priority>0.7</priority>\n";

                foreach ($availableLocales as $altLocale) {
                    $altPrefix = $prefixMap[$altLocale] ?? '';
                    $xml .= '    <xhtml:link rel="alternate" hreflang="' . $hreflangCode($altLocale) . '" href="' . $base . $altPrefix . '/locations/' . $slug . '" />' . "\n";
                }
                $xml .= '    <xhtml:link rel="alternate" hreflang="x-default" href="' . $base . '/locations/' . $slug . '" />' . "\n";

                $xml .= "  </url>\n";
            }
        }

        $xml .= '</urlset>';

        return response($xml, 200)->withHeaders([
            'Content-Type'  => 'application/xml; charset=UTF-8',
            'Cache-Control' => 'public, max-age=3600, s-maxage=3600',
            'X-Robots-Tag'  => 'noindex',
        ]);
    }

    /**
     * robots.txt — single domain, ideal spec.
     * GET /robots.txt
     */
    public function robots(): Response
    {
        $base = self::BASE;

        $txt  = "# CityEE — Kinnisvaramaakler Tallinnas\n";
        $txt .= "# Single domain: {$base}\n\n";
        $txt .= "User-agent: *\n";
        $txt .= "Allow: /\n\n";
        $txt .= "# Disallow non-content paths\n";
        $txt .= "Disallow: /admin\n";
        $txt .= "Disallow: /login\n";
        $txt .= "Disallow: /register\n";
        $txt .= "Disallow: /storage/\n";
        $txt .= "Disallow: /vendor/\n";
        $txt .= "Disallow: /node_modules/\n";
        $txt .= "Disallow: /resources/\n";
        $txt .= "Disallow: /bootstrap/\n";
        $txt .= "Disallow: /config/\n";
        $txt .= "Disallow: /database/\n";
        $txt .= "Disallow: /tests/\n";
        $txt .= "Disallow: /index\n";
        $txt .= "Disallow: /index.html\n";
        $txt .= "Disallow: /index.php\n";
        $txt .= "Disallow: /*?sort=\n";
        $txt .= "Disallow: /*?utm_\n";
        $txt .= "Disallow: /*?trk=\n";
        $txt .= "Disallow: /*?page=\n";
        $txt .= "Disallow: /*?ref=\n";
        $txt .= "Disallow: /*?fbclid=\n";
        $txt .= "Disallow: /*?gclid=\n";
        $txt .= "Disallow: /*?yclid=\n\n";
        $txt .= "# AI crawlers — welcome\n";
        $txt .= "User-agent: GPTBot\n";
        $txt .= "Allow: /\n\n";
        $txt .= "User-agent: Google-Extended\n";
        $txt .= "Allow: /\n\n";
        $txt .= "User-agent: ChatGPT-User\n";
        $txt .= "Allow: /\n\n";
        $txt .= "User-agent: Bingbot\n";
        $txt .= "Allow: /\n\n";
        $txt .= "User-agent: PerplexityBot\n";
        $txt .= "Allow: /\n\n";
        $txt .= "Host: cityee.ee\n\n";
        $txt .= "Sitemap: {$base}/sitemap.xml\n";

        return response($txt, 200)->withHeaders([
            'Content-Type'  => 'text/plain; charset=UTF-8',
            'Cache-Control' => 'public, max-age=86400, s-maxage=86400',
        ]);
    }

    // ──────────────────────────────────────────────

    /**
     * Build page list for a given language — all URLs are path-based on single domain.
     */
    private function pagesForLang(string $lang): array
    {
        $today = now()->toDateString();
        $base  = self::BASE;

        $prefix = match ($lang) {
            'ru' => '/ru',
            'en' => '/en',
            default => '',
        };

        $slugs = match ($lang) {
            'et' => [
                ['slug' => '/',               'key' => 'home',         'p' => '1.0', 'f' => 'weekly'],
                ['slug' => '/kinnisvara-muuk', 'key' => 'sell',         'p' => '0.9', 'f' => 'weekly'],
                ['slug' => '/kinnisvara-uur',  'key' => 'rent',         'p' => '0.9', 'f' => 'weekly'],
                ['slug' => '/konsultatsioon',  'key' => 'consultation', 'p' => '0.8', 'f' => 'monthly'],
                ['slug' => '/kontaktid',       'key' => 'contacts',     'p' => '0.7', 'f' => 'monthly'],
                ['slug' => '/miks-cityee',     'key' => 'why',          'p' => '0.8', 'f' => 'monthly'],
                ['slug' => '/audit',           'key' => 'audit',        'p' => '0.8', 'f' => 'monthly'],
                ['slug' => '/knowledge',       'key' => 'knowledge',    'p' => '0.7', 'f' => 'monthly'],
                ['slug' => '/dashboard',       'key' => 'dashboard',    'p' => '0.6', 'f' => 'monthly'],
                ['slug' => '/guides',          'key' => 'guides',       'p' => '0.8', 'f' => 'weekly'],
                ['slug' => '/audits',          'key' => 'audits',       'p' => '0.8', 'f' => 'weekly'],
            ],
            'ru' => [
                ['slug' => '/',                'key' => 'home',         'p' => '1.0', 'f' => 'weekly'],
                ['slug' => '/kinnisvara-muuk', 'key' => 'sell',         'p' => '0.9', 'f' => 'weekly'],
                ['slug' => '/kinnisvara-uur',  'key' => 'rent',         'p' => '0.9', 'f' => 'weekly'],
                ['slug' => '/konsultatsioon',  'key' => 'consultation', 'p' => '0.8', 'f' => 'monthly'],
                ['slug' => '/kontaktid',       'key' => 'contacts',     'p' => '0.7', 'f' => 'monthly'],
                ['slug' => '/pochemu-cityee',  'key' => 'why',          'p' => '0.8', 'f' => 'monthly'],
                ['slug' => '/audit',           'key' => 'audit',        'p' => '0.8', 'f' => 'monthly'],
                ['slug' => '/knowledge',       'key' => 'knowledge',    'p' => '0.7', 'f' => 'monthly'],
                ['slug' => '/dashboard',       'key' => 'dashboard',    'p' => '0.6', 'f' => 'monthly'],
                ['slug' => '/guides',          'key' => 'guides',       'p' => '0.8', 'f' => 'weekly'],
                ['slug' => '/audits',          'key' => 'audits',       'p' => '0.8', 'f' => 'weekly'],
            ],
            'en' => [
                ['slug' => '/',                 'key' => 'home',         'p' => '1.0', 'f' => 'weekly'],
                ['slug' => '/sell-property',     'key' => 'sell',         'p' => '0.9', 'f' => 'weekly'],
                ['slug' => '/rent-out-property', 'key' => 'rent',         'p' => '0.9', 'f' => 'weekly'],
                ['slug' => '/consultation',      'key' => 'consultation', 'p' => '0.8', 'f' => 'monthly'],
                ['slug' => '/contacts',          'key' => 'contacts',     'p' => '0.7', 'f' => 'monthly'],
                ['slug' => '/why-cityee',        'key' => 'why',          'p' => '0.8', 'f' => 'monthly'],
                ['slug' => '/audit',             'key' => 'audit',        'p' => '0.8', 'f' => 'monthly'],
                ['slug' => '/knowledge',         'key' => 'knowledge',    'p' => '0.7', 'f' => 'monthly'],
                ['slug' => '/dashboard',         'key' => 'dashboard',    'p' => '0.6', 'f' => 'monthly'],
                ['slug' => '/guides',            'key' => 'guides',       'p' => '0.8', 'f' => 'weekly'],
                ['slug' => '/audits',            'key' => 'audits',       'p' => '0.8', 'f' => 'weekly'],
            ],
            default => [],
        };

        $hreflangMap = $this->buildHreflangMap();
        $pages = [];

        foreach ($slugs as $u) {
            $loc = $base . $prefix . $u['slug'];
            // Collapse double slashes (except in protocol) and normalize
            $loc = preg_replace('#(?<!:)/{2,}#', '/', $loc);
            // Remove trailing slash unless it's the site root
            if ($loc !== $base . '/') {
                $loc = rtrim($loc, '/');
            }

            $pages[] = [
                'loc'        => $loc,
                'lastmod'    => $today,
                'changefreq' => $u['f'],
                'priority'   => $u['p'],
                'alternates' => $hreflangMap[$u['key']] ?? [],
            ];
        }

        return $pages;
    }

    /**
     * Hreflang alternate map for all pages — single domain, path-based.
     */
    private function buildHreflangMap(): array
    {
        $base = self::BASE;

        $pages = [
            'home'         => ['et' => '/',              'ru' => '/ru',                'en' => '/en'],
            'sell'         => ['et' => '/kinnisvara-muuk','ru' => '/ru/kinnisvara-muuk','en' => '/en/sell-property'],
            'rent'         => ['et' => '/kinnisvara-uur', 'ru' => '/ru/kinnisvara-uur', 'en' => '/en/rent-out-property'],
            'consultation' => ['et' => '/konsultatsioon', 'ru' => '/ru/konsultatsioon', 'en' => '/en/consultation'],
            'contacts'     => ['et' => '/kontaktid',      'ru' => '/ru/kontaktid',      'en' => '/en/contacts'],
            'why'          => ['et' => '/miks-cityee',    'ru' => '/ru/pochemu-cityee', 'en' => '/en/why-cityee'],
            'audit'        => ['et' => '/audit',          'ru' => '/ru/audit',          'en' => '/en/audit'],
            'knowledge'    => ['et' => '/knowledge',      'ru' => '/ru/knowledge',      'en' => '/en/knowledge'],
            'dashboard'    => ['et' => '/dashboard',      'ru' => '/ru/dashboard',      'en' => '/en/dashboard'],
            'guides'       => ['et' => '/guides',         'ru' => '/ru/guides',         'en' => '/en/guides'],
            'audits'       => ['et' => '/audits',         'ru' => '/ru/audits',         'en' => '/en/audits'],
        ];

        $map = [];
        foreach ($pages as $key => $slugs) {
            $map[$key] = [
                ['lang' => 'et-EE',     'href' => $base . $slugs['et']],
                ['lang' => 'ru-EE',     'href' => $base . $slugs['ru']],
                ['lang' => 'en-EE',     'href' => $base . $slugs['en']],
                ['lang' => 'x-default', 'href' => $base . $slugs['et']],
            ];
        }

        return $map;
    }
}
