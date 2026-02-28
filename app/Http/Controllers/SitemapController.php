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
                    $loc = "{$base}{$prefix}/guides/{$slug}/";

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
                        $xml .= '    <xhtml:link rel="alternate" hreflang="' . $hreflangCode($alt->locale) . '" href="' . $base . $altPrefix . '/guides/' . $slug . '/" />' . "\n";
                    }
                    // x-default = ET version
                    $etVersion = $versions->firstWhere('locale', 'et');
                    if ($etVersion) {
                        $xml .= '    <xhtml:link rel="alternate" hreflang="x-default" href="' . $base . '/guides/' . $slug . '/" />' . "\n";
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
                    $loc = "{$base}{$prefix}/audits/{$slug}/";

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
                        $xml .= '    <xhtml:link rel="alternate" hreflang="' . $hreflangCode($alt->locale) . '" href="' . $base . $altPrefix . '/audits/' . $slug . '/" />' . "\n";
                    }
                    $etVersion = $versions->firstWhere('locale', 'et');
                    if ($etVersion) {
                        $xml .= '    <xhtml:link rel="alternate" hreflang="x-default" href="' . $base . '/audits/' . $slug . '/" />' . "\n";
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
                $loc = "{$base}{$prefix}/locations/{$slug}/";

                $xml .= "  <url>\n";
                $xml .= "    <loc>{$loc}</loc>\n";
                $xml .= "    <changefreq>monthly</changefreq>\n";
                $xml .= "    <priority>0.7</priority>\n";

                foreach ($availableLocales as $altLocale) {
                    $altPrefix = $prefixMap[$altLocale] ?? '';
                    $xml .= '    <xhtml:link rel="alternate" hreflang="' . $hreflangCode($altLocale) . '" href="' . $base . $altPrefix . '/locations/' . $slug . '/" />' . "\n";
                }
                $xml .= '    <xhtml:link rel="alternate" hreflang="x-default" href="' . $base . '/locations/' . $slug . '/" />' . "\n";

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
        $txt .= "Disallow: /*?yclid=\n";
        $txt .= "Disallow: /*?category=\n";
        $txt .= "Disallow: /*?type=\n";
        $txt .= "Disallow: /*?q=\n\n";
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
                ['slug' => '/',                'key' => 'home',         'p' => '1.0', 'f' => 'weekly'],
                ['slug' => '/kinnisvara-muuk/', 'key' => 'sell',         'p' => '0.9', 'f' => 'weekly'],
                ['slug' => '/kinnisvara-uur/',  'key' => 'rent',         'p' => '0.9', 'f' => 'weekly'],
                ['slug' => '/konsultatsioon/',  'key' => 'consultation', 'p' => '0.8', 'f' => 'monthly'],
                ['slug' => '/kontaktid/',       'key' => 'contacts',     'p' => '0.7', 'f' => 'monthly'],
                ['slug' => '/miks-cityee/',     'key' => 'why',          'p' => '0.8', 'f' => 'monthly'],
                ['slug' => '/audit/',           'key' => 'audit',        'p' => '0.8', 'f' => 'monthly'],
                ['slug' => '/knowledge/',       'key' => 'knowledge',    'p' => '0.7', 'f' => 'monthly'],
                ['slug' => '/dashboard/',       'key' => 'dashboard',    'p' => '0.6', 'f' => 'monthly'],
                ['slug' => '/guides/',          'key' => 'guides',       'p' => '0.8', 'f' => 'weekly'],
                ['slug' => '/audits/',          'key' => 'audits',       'p' => '0.8', 'f' => 'weekly'],
                ['slug' => '/aleksandr-primakov/', 'key' => 'profile',  'p' => '0.7', 'f' => 'monthly'],
                // Phase 4 intent pages
                ['slug' => '/muud-ise-keegi-ei-helista/',      'key' => 'no_calls',       'p' => '0.8', 'f' => 'monthly'],
                ['slug' => '/vaatamised-aga-pakkumisi-pole/',   'key' => 'no_offers',      'p' => '0.8', 'f' => 'monthly'],
                ['slug' => '/kinnisvara-hinnaanaluus-tallinn/', 'key' => 'price_analysis', 'p' => '0.8', 'f' => 'monthly'],
                ['slug' => '/vead-kinnisvara-muugil/',          'key' => 'mistakes',       'p' => '0.8', 'f' => 'monthly'],
                ['slug' => '/kuidas-muua-kiiremini/',           'key' => 'sell_faster',    'p' => '0.8', 'f' => 'monthly'],
                ['slug' => '/kuulutuse-audit/',                 'key' => 'listing_audit',  'p' => '0.8', 'f' => 'monthly'],
                ['slug' => '/muua-ise-vs-strateegiline-partner/', 'key' => 'comparison',  'p' => '0.8', 'f' => 'monthly'],
                // Phase 5 pillar guides + cases
                ['slug' => '/knowledge/cases/',                                       'key' => 'cases',              'p' => '0.8', 'f' => 'weekly'],
                ['slug' => '/knowledge/terviklik-juhend-kinnisvara-muugiks-tallinnas/', 'key' => 'guide_sell_tallinn', 'p' => '0.9', 'f' => 'monthly'],
                ['slug' => '/knowledge/juhend-kinnisvara-uurimine/',                   'key' => 'guide_rent',         'p' => '0.9', 'f' => 'monthly'],
                ['slug' => '/knowledge/kuidas-maarata-kinnisvara-turuhind/',            'key' => 'guide_pricing',      'p' => '0.9', 'f' => 'monthly'],
                ['slug' => '/knowledge/labirakimiste-strateegia-kinnisvara/',           'key' => 'guide_negotiation',  'p' => '0.8', 'f' => 'monthly'],
                ['slug' => '/knowledge/kuidas-valmistada-korter-muugiks/',              'key' => 'guide_staging',      'p' => '0.8', 'f' => 'monthly'],
                ['slug' => '/knowledge/kinnisvara-turu-analuus-tallinn-2026/',          'key' => 'guide_market_2026',  'p' => '0.9', 'f' => 'weekly'],
                ['slug' => '/knowledge/vead-mille-parast-kaotate-raha/',                'key' => 'guide_mistakes',     'p' => '0.8', 'f' => 'monthly'],
            ],
            'ru' => [
                ['slug' => '/',                 'key' => 'home',         'p' => '1.0', 'f' => 'weekly'],
                ['slug' => '/kinnisvara-muuk/', 'key' => 'sell',         'p' => '0.9', 'f' => 'weekly'],
                ['slug' => '/kinnisvara-uur/',  'key' => 'rent',         'p' => '0.9', 'f' => 'weekly'],
                ['slug' => '/konsultatsioon/',  'key' => 'consultation', 'p' => '0.8', 'f' => 'monthly'],
                ['slug' => '/kontaktid/',       'key' => 'contacts',     'p' => '0.7', 'f' => 'monthly'],
                ['slug' => '/pochemu-cityee/',  'key' => 'why',          'p' => '0.8', 'f' => 'monthly'],
                ['slug' => '/audit/',           'key' => 'audit',        'p' => '0.8', 'f' => 'monthly'],
                ['slug' => '/knowledge/',       'key' => 'knowledge',    'p' => '0.7', 'f' => 'monthly'],
                ['slug' => '/dashboard/',       'key' => 'dashboard',    'p' => '0.6', 'f' => 'monthly'],
                ['slug' => '/guides/',          'key' => 'guides',       'p' => '0.8', 'f' => 'weekly'],
                ['slug' => '/audits/',          'key' => 'audits',       'p' => '0.8', 'f' => 'weekly'],
                ['slug' => '/aleksandr-primakov/', 'key' => 'profile',  'p' => '0.7', 'f' => 'monthly'],
                // Phase 4 intent pages
                ['slug' => '/prodayu-sam-nikto-ne-zvonit/',       'key' => 'no_calls',       'p' => '0.8', 'f' => 'monthly'],
                ['slug' => '/prosmotry-est-predlozheniy-net/',    'key' => 'no_offers',      'p' => '0.8', 'f' => 'monthly'],
                ['slug' => '/analiz-ceny-nedvizhimosti-tallinn/', 'key' => 'price_analysis', 'p' => '0.8', 'f' => 'monthly'],
                ['slug' => '/oshibki-pri-prodazhe/',              'key' => 'mistakes',       'p' => '0.8', 'f' => 'monthly'],
                ['slug' => '/kak-prodat-bystree/',                'key' => 'sell_faster',    'p' => '0.8', 'f' => 'monthly'],
                ['slug' => '/audit-obyavleniya/',                 'key' => 'listing_audit',  'p' => '0.8', 'f' => 'monthly'],
                ['slug' => '/prodat-samomu-vs-partner/',          'key' => 'comparison',     'p' => '0.8', 'f' => 'monthly'],
                // Phase 5 pillar guides + cases
                ['slug' => '/knowledge/cases/',                                              'key' => 'cases',              'p' => '0.8', 'f' => 'weekly'],
                ['slug' => '/knowledge/polnoe-rukovodstvo-prodazha-nedvizhimosti-tallinn/',  'key' => 'guide_sell_tallinn', 'p' => '0.9', 'f' => 'monthly'],
                ['slug' => '/knowledge/rukovodstvo-sdacha-v-arendu/',                        'key' => 'guide_rent',         'p' => '0.9', 'f' => 'monthly'],
                ['slug' => '/knowledge/kak-opredelit-rynochnuyu-cenu/',                      'key' => 'guide_pricing',      'p' => '0.9', 'f' => 'monthly'],
                ['slug' => '/knowledge/peregovornaya-strategiya-nedvizhimost/',              'key' => 'guide_negotiation',  'p' => '0.8', 'f' => 'monthly'],
                ['slug' => '/knowledge/kak-podgotovit-kvartiru-k-prodazhe/',                 'key' => 'guide_staging',      'p' => '0.8', 'f' => 'monthly'],
                ['slug' => '/knowledge/analiz-rynka-nedvizhimosti-tallinn-2026/',            'key' => 'guide_market_2026',  'p' => '0.9', 'f' => 'weekly'],
                ['slug' => '/knowledge/oshibki-iz-za-kotorykh-teryayut-dengi/',              'key' => 'guide_mistakes',     'p' => '0.8', 'f' => 'monthly'],
            ],
            'en' => [
                ['slug' => '/',                  'key' => 'home',         'p' => '1.0', 'f' => 'weekly'],
                ['slug' => '/sell-property/',     'key' => 'sell',         'p' => '0.9', 'f' => 'weekly'],
                ['slug' => '/rent-out-property/', 'key' => 'rent',         'p' => '0.9', 'f' => 'weekly'],
                ['slug' => '/consultation/',      'key' => 'consultation', 'p' => '0.8', 'f' => 'monthly'],
                ['slug' => '/contacts/',          'key' => 'contacts',     'p' => '0.7', 'f' => 'monthly'],
                ['slug' => '/why-cityee/',        'key' => 'why',          'p' => '0.8', 'f' => 'monthly'],
                ['slug' => '/audit/',             'key' => 'audit',        'p' => '0.8', 'f' => 'monthly'],
                ['slug' => '/knowledge/',         'key' => 'knowledge',    'p' => '0.7', 'f' => 'monthly'],
                ['slug' => '/dashboard/',         'key' => 'dashboard',    'p' => '0.6', 'f' => 'monthly'],
                ['slug' => '/guides/',            'key' => 'guides',       'p' => '0.8', 'f' => 'weekly'],
                ['slug' => '/audits/',            'key' => 'audits',       'p' => '0.8', 'f' => 'weekly'],
                ['slug' => '/aleksandr-primakov/', 'key' => 'profile',    'p' => '0.7', 'f' => 'monthly'],
                // Phase 4 intent pages
                ['slug' => '/selling-yourself-no-calls/',         'key' => 'no_calls',       'p' => '0.8', 'f' => 'monthly'],
                ['slug' => '/viewings-but-no-offers/',            'key' => 'no_offers',      'p' => '0.8', 'f' => 'monthly'],
                ['slug' => '/property-price-analysis-tallinn/',   'key' => 'price_analysis', 'p' => '0.8', 'f' => 'monthly'],
                ['slug' => '/mistakes-selling-property/',         'key' => 'mistakes',       'p' => '0.8', 'f' => 'monthly'],
                ['slug' => '/how-to-sell-faster/',                'key' => 'sell_faster',    'p' => '0.8', 'f' => 'monthly'],
                ['slug' => '/listing-audit/',                     'key' => 'listing_audit',  'p' => '0.8', 'f' => 'monthly'],
                ['slug' => '/sell-yourself-vs-strategy-partner/', 'key' => 'comparison',     'p' => '0.8', 'f' => 'monthly'],
                // Phase 5 pillar guides + cases
                ['slug' => '/knowledge/cases/',                                              'key' => 'cases',              'p' => '0.8', 'f' => 'weekly'],
                ['slug' => '/knowledge/complete-guide-selling-property-tallinn/',             'key' => 'guide_sell_tallinn', 'p' => '0.9', 'f' => 'monthly'],
                ['slug' => '/knowledge/guide-renting-out-property/',                         'key' => 'guide_rent',         'p' => '0.9', 'f' => 'monthly'],
                ['slug' => '/knowledge/how-to-determine-market-price/',                      'key' => 'guide_pricing',      'p' => '0.9', 'f' => 'monthly'],
                ['slug' => '/knowledge/negotiation-strategy-property/',                      'key' => 'guide_negotiation',  'p' => '0.8', 'f' => 'monthly'],
                ['slug' => '/knowledge/how-to-prepare-apartment-for-sale/',                  'key' => 'guide_staging',      'p' => '0.8', 'f' => 'monthly'],
                ['slug' => '/knowledge/real-estate-market-analysis-tallinn-2026/',            'key' => 'guide_market_2026',  'p' => '0.9', 'f' => 'weekly'],
                ['slug' => '/knowledge/mistakes-that-cost-money/',                           'key' => 'guide_mistakes',     'p' => '0.8', 'f' => 'monthly'],
            ],
            default => [],
        };

        $hreflangMap = $this->buildHreflangMap();
        $pages = [];

        foreach ($slugs as $u) {
            $loc = $base . $prefix . $u['slug'];
            // Collapse double slashes (except in protocol) and normalize
            $loc = preg_replace('#(?<!:)/{2,}#', '/', $loc);
            // Ensure trailing slash (canonical format)
            $loc = rtrim($loc, '/') . '/';

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
            'home'         => ['et' => '/',               'ru' => '/ru/',                'en' => '/en/'],
            'sell'         => ['et' => '/kinnisvara-muuk/','ru' => '/ru/kinnisvara-muuk/','en' => '/en/sell-property/'],
            'rent'         => ['et' => '/kinnisvara-uur/', 'ru' => '/ru/kinnisvara-uur/', 'en' => '/en/rent-out-property/'],
            'consultation' => ['et' => '/konsultatsioon/', 'ru' => '/ru/konsultatsioon/', 'en' => '/en/consultation/'],
            'contacts'     => ['et' => '/kontaktid/',      'ru' => '/ru/kontaktid/',      'en' => '/en/contacts/'],
            'why'          => ['et' => '/miks-cityee/',    'ru' => '/ru/pochemu-cityee/', 'en' => '/en/why-cityee/'],
            'audit'        => ['et' => '/audit/',          'ru' => '/ru/audit/',          'en' => '/en/audit/'],
            'knowledge'    => ['et' => '/knowledge/',      'ru' => '/ru/knowledge/',      'en' => '/en/knowledge/'],
            'dashboard'    => ['et' => '/dashboard/',      'ru' => '/ru/dashboard/',      'en' => '/en/dashboard/'],
            'guides'       => ['et' => '/guides/',         'ru' => '/ru/guides/',         'en' => '/en/guides/'],
            'audits'       => ['et' => '/audits/',         'ru' => '/ru/audits/',         'en' => '/en/audits/'],
            'profile'      => ['et' => '/aleksandr-primakov/', 'ru' => '/ru/aleksandr-primakov/', 'en' => '/en/aleksandr-primakov/'],
            // Phase 4 intent pages
            'no_calls'      => ['et' => '/muud-ise-keegi-ei-helista/',       'ru' => '/ru/prodayu-sam-nikto-ne-zvonit/',        'en' => '/en/selling-yourself-no-calls/'],
            'no_offers'     => ['et' => '/vaatamised-aga-pakkumisi-pole/',    'ru' => '/ru/prosmotry-est-predlozheniy-net/',     'en' => '/en/viewings-but-no-offers/'],
            'price_analysis'=> ['et' => '/kinnisvara-hinnaanaluus-tallinn/',  'ru' => '/ru/analiz-ceny-nedvizhimosti-tallinn/',  'en' => '/en/property-price-analysis-tallinn/'],
            'mistakes'      => ['et' => '/vead-kinnisvara-muugil/',           'ru' => '/ru/oshibki-pri-prodazhe/',               'en' => '/en/mistakes-selling-property/'],
            'sell_faster'   => ['et' => '/kuidas-muua-kiiremini/',            'ru' => '/ru/kak-prodat-bystree/',                 'en' => '/en/how-to-sell-faster/'],
            'listing_audit' => ['et' => '/kuulutuse-audit/',                  'ru' => '/ru/audit-obyavleniya/',                  'en' => '/en/listing-audit/'],
            'comparison'    => ['et' => '/muua-ise-vs-strateegiline-partner/','ru' => '/ru/prodat-samomu-vs-partner/',            'en' => '/en/sell-yourself-vs-strategy-partner/'],
            // Phase 5 pillar guides + cases
            'cases'              => ['et' => '/knowledge/cases/',                                        'ru' => '/ru/knowledge/cases/',                                              'en' => '/en/knowledge/cases/'],
            'guide_sell_tallinn' => ['et' => '/knowledge/terviklik-juhend-kinnisvara-muugiks-tallinnas/', 'ru' => '/ru/knowledge/polnoe-rukovodstvo-prodazha-nedvizhimosti-tallinn/',  'en' => '/en/knowledge/complete-guide-selling-property-tallinn/'],
            'guide_rent'         => ['et' => '/knowledge/juhend-kinnisvara-uurimine/',                   'ru' => '/ru/knowledge/rukovodstvo-sdacha-v-arendu/',                        'en' => '/en/knowledge/guide-renting-out-property/'],
            'guide_pricing'      => ['et' => '/knowledge/kuidas-maarata-kinnisvara-turuhind/',            'ru' => '/ru/knowledge/kak-opredelit-rynochnuyu-cenu/',                      'en' => '/en/knowledge/how-to-determine-market-price/'],
            'guide_negotiation'  => ['et' => '/knowledge/labirakimiste-strateegia-kinnisvara/',           'ru' => '/ru/knowledge/peregovornaya-strategiya-nedvizhimost/',              'en' => '/en/knowledge/negotiation-strategy-property/'],
            'guide_staging'      => ['et' => '/knowledge/kuidas-valmistada-korter-muugiks/',              'ru' => '/ru/knowledge/kak-podgotovit-kvartiru-k-prodazhe/',                 'en' => '/en/knowledge/how-to-prepare-apartment-for-sale/'],
            'guide_market_2026'  => ['et' => '/knowledge/kinnisvara-turu-analuus-tallinn-2026/',          'ru' => '/ru/knowledge/analiz-rynka-nedvizhimosti-tallinn-2026/',            'en' => '/en/knowledge/real-estate-market-analysis-tallinn-2026/'],
            'guide_mistakes'     => ['et' => '/knowledge/vead-mille-parast-kaotate-raha/',                'ru' => '/ru/knowledge/oshibki-iz-za-kotorykh-teryayut-dengi/',              'en' => '/en/knowledge/mistakes-that-cost-money/'],
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
