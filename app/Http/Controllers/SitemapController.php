<?php

namespace App\Http\Controllers;

use Illuminate\Http\Response;

class SitemapController extends Controller
{
    private const BASE = 'https://cityee.ee';

    /**
     * Sitemap index — links to per-language + section sitemaps.
     */
    public function index(): Response
    {
        $sitemaps = [
            self::BASE . '/sitemap-et.xml',
            self::BASE . '/sitemap-ru.xml',
            self::BASE . '/sitemap-en.xml',
        ];

        $xml = '<?xml version="1.0" encoding="UTF-8"?>' . "\n";
        $xml .= '<sitemapindex xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">' . "\n";

        foreach ($sitemaps as $loc) {
            $xml .= "  <sitemap>\n    <loc>{$loc}</loc>\n    <lastmod>" . now()->toDateString() . "</lastmod>\n  </sitemap>\n";
        }

        $xml .= '</sitemapindex>';

        return response($xml, 200)->header('Content-Type', 'application/xml');
    }

    /**
     * Per-language sitemap with hreflang alternates.
     */
    public function lang(string $lang): Response
    {
        $pages = $this->pagesForLang($lang);

        $xml = '<?xml version="1.0" encoding="UTF-8"?>' . "\n";
        $xml .= '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9"' . "\n";
        $xml .= '        xmlns:xhtml="http://www.w3.org/1999/xhtml">' . "\n";

        foreach ($pages as $page) {
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

        return response($xml, 200)->header('Content-Type', 'application/xml');
    }

    /**
     * robots.txt — correct format with Host + Sitemap.
     */
    public function robots(): Response
    {
        $txt  = "User-agent: *\n";
        $txt .= "Allow: /\n\n";
        $txt .= "Disallow: /admin\n";
        $txt .= "Disallow: /storage/\n";
        $txt .= "Disallow: /vendor/\n\n";
        $txt .= "Sitemap: https://cityee.ee/sitemap.xml\n\n";
        $txt .= "Host: cityee.ee\n";

        return response($txt, 200)->header('Content-Type', 'text/plain');
    }

    // ──────────────────────────────────────────────

    private function pagesForLang(string $lang): array
    {
        $today = now()->toDateString();

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
            ],
            'ru' => [
                ['slug' => '/ru/',                'key' => 'home',         'p' => '1.0', 'f' => 'weekly'],
                ['slug' => '/ru/kinnisvara-muuk', 'key' => 'sell',         'p' => '0.9', 'f' => 'weekly'],
                ['slug' => '/ru/kinnisvara-uur',  'key' => 'rent',         'p' => '0.9', 'f' => 'weekly'],
                ['slug' => '/ru/konsultatsioon',  'key' => 'consultation', 'p' => '0.8', 'f' => 'monthly'],
                ['slug' => '/ru/kontaktid',       'key' => 'contacts',     'p' => '0.7', 'f' => 'monthly'],
                ['slug' => '/ru/pochemu-cityee',  'key' => 'why',          'p' => '0.8', 'f' => 'monthly'],
                ['slug' => '/ru/audit',           'key' => 'audit',        'p' => '0.8', 'f' => 'monthly'],
                ['slug' => '/ru/knowledge',       'key' => 'knowledge',    'p' => '0.7', 'f' => 'monthly'],
            ],
            'en' => [
                ['slug' => '/en/',                  'key' => 'home',         'p' => '1.0', 'f' => 'weekly'],
                ['slug' => '/en/sell-property',     'key' => 'sell',         'p' => '0.9', 'f' => 'weekly'],
                ['slug' => '/en/rent-out-property', 'key' => 'rent',         'p' => '0.9', 'f' => 'weekly'],
                ['slug' => '/en/consultation',      'key' => 'consultation', 'p' => '0.8', 'f' => 'monthly'],
                ['slug' => '/en/contacts',          'key' => 'contacts',     'p' => '0.7', 'f' => 'monthly'],
                ['slug' => '/en/why-cityee',        'key' => 'why',          'p' => '0.8', 'f' => 'monthly'],
                ['slug' => '/en/audit',             'key' => 'audit',        'p' => '0.8', 'f' => 'monthly'],
                ['slug' => '/en/knowledge',         'key' => 'knowledge',    'p' => '0.7', 'f' => 'monthly'],
            ],
            default => [],
        };

        $hreflangMap = $this->buildHreflangMap();
        $pages = [];

        foreach ($slugs as $u) {
            $pages[] = [
                'loc'        => self::BASE . $u['slug'],
                'lastmod'    => $today,
                'changefreq' => $u['f'],
                'priority'   => $u['p'],
                'alternates' => $hreflangMap[$u['key']] ?? [],
            ];
        }

        return $pages;
    }

    private function buildHreflangMap(): array
    {
        $pages = [
            'home'         => ['et' => '/',               'ru' => '/ru/',                'en' => '/en/'],
            'sell'         => ['et' => '/kinnisvara-muuk', 'ru' => '/ru/kinnisvara-muuk', 'en' => '/en/sell-property'],
            'rent'         => ['et' => '/kinnisvara-uur',  'ru' => '/ru/kinnisvara-uur',  'en' => '/en/rent-out-property'],
            'consultation' => ['et' => '/konsultatsioon',  'ru' => '/ru/konsultatsioon',  'en' => '/en/consultation'],
            'contacts'     => ['et' => '/kontaktid',       'ru' => '/ru/kontaktid',       'en' => '/en/contacts'],
            'why'          => ['et' => '/miks-cityee',     'ru' => '/ru/pochemu-cityee',  'en' => '/en/why-cityee'],
            'audit'        => ['et' => '/audit',           'ru' => '/ru/audit',           'en' => '/en/audit'],
            'knowledge'    => ['et' => '/knowledge',       'ru' => '/ru/knowledge',       'en' => '/en/knowledge'],
        ];

        $map = [];
        foreach ($pages as $key => $slugs) {
            $map[$key] = [
                ['lang' => 'et',        'href' => self::BASE . $slugs['et']],
                ['lang' => 'ru',        'href' => self::BASE . $slugs['ru']],
                ['lang' => 'en',        'href' => self::BASE . $slugs['en']],
                ['lang' => 'x-default', 'href' => self::BASE . $slugs['et']],
            ];
        }

        return $map;
    }
}
