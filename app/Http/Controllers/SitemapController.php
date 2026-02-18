<?php

namespace App\Http\Controllers;

use Illuminate\Http\Response;

class SitemapController extends Controller
{
    private const BASES = [
        'et' => 'https://cityee.ee',
        'ru' => 'https://ru.cityee.ee',
        'en' => 'https://en.cityee.ee',
    ];

    /**
     * Sitemap index — links to per-language + section sitemaps.
     */
    public function index(): Response
    {
        $sitemaps = [
            self::BASES['et'] . '/sitemap-et.xml',
            self::BASES['ru'] . '/sitemap-ru.xml',
            self::BASES['en'] . '/sitemap-en.xml',
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
     * robots.txt — domain-aware with proper sitemaps.
     */
    public function robots(): Response
    {
        $host = request()->getHost();

        $txt  = "User-agent: *\n";
        $txt .= "Allow: /\n\n";

        // Per-domain sitemap + host
        if (str_starts_with($host, 'ru.')) {
            $txt .= "Host: ru.cityee.ee\n";
            $txt .= "Sitemap: https://ru.cityee.ee/sitemap.xml\n";
        } elseif (str_starts_with($host, 'en.')) {
            $txt .= "Host: en.cityee.ee\n";
            $txt .= "Sitemap: https://en.cityee.ee/sitemap.xml\n";
        } else {
            $txt .= "Host: cityee.ee\n";
            $txt .= "Sitemap: https://cityee.ee/sitemap.xml\n";
            $txt .= "Sitemap: https://ru.cityee.ee/sitemap.xml\n";
            $txt .= "Sitemap: https://en.cityee.ee/sitemap.xml\n";
        }

        return response($txt, 200)->header('Content-Type', 'text/plain');
    }

    // ──────────────────────────────────────────────

    private function pagesForLang(string $lang): array
    {
        $today = now()->toDateString();
        $base = self::BASES[$lang] ?? self::BASES['et'];

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
                ['slug' => '/',                'key' => 'home',         'p' => '1.0', 'f' => 'weekly'],
                ['slug' => '/kinnisvara-muuk', 'key' => 'sell',         'p' => '0.9', 'f' => 'weekly'],
                ['slug' => '/kinnisvara-uur',  'key' => 'rent',         'p' => '0.9', 'f' => 'weekly'],
                ['slug' => '/konsultatsioon',  'key' => 'consultation', 'p' => '0.8', 'f' => 'monthly'],
                ['slug' => '/kontaktid',       'key' => 'contacts',     'p' => '0.7', 'f' => 'monthly'],
                ['slug' => '/pochemu-cityee',  'key' => 'why',          'p' => '0.8', 'f' => 'monthly'],
                ['slug' => '/audit',           'key' => 'audit',        'p' => '0.8', 'f' => 'monthly'],
                ['slug' => '/knowledge',       'key' => 'knowledge',    'p' => '0.7', 'f' => 'monthly'],
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
            ],
            default => [],
        };

        $hreflangMap = $this->buildHreflangMap();
        $pages = [];

        foreach ($slugs as $u) {
            $pages[] = [
                'loc'        => $base . $u['slug'],
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
            'home'         => ['et' => '/',               'ru' => '/',                'en' => '/'],
            'sell'         => ['et' => '/kinnisvara-muuk', 'ru' => '/kinnisvara-muuk', 'en' => '/sell-property'],
            'rent'         => ['et' => '/kinnisvara-uur',  'ru' => '/kinnisvara-uur',  'en' => '/rent-out-property'],
            'consultation' => ['et' => '/konsultatsioon',  'ru' => '/konsultatsioon',  'en' => '/consultation'],
            'contacts'     => ['et' => '/kontaktid',       'ru' => '/kontaktid',       'en' => '/contacts'],
            'why'          => ['et' => '/miks-cityee',     'ru' => '/pochemu-cityee',  'en' => '/why-cityee'],
            'audit'        => ['et' => '/audit',           'ru' => '/audit',           'en' => '/audit'],
            'knowledge'    => ['et' => '/knowledge',       'ru' => '/knowledge',       'en' => '/knowledge'],
        ];

        $map = [];
        foreach ($pages as $key => $slugs) {
            $map[$key] = [
                ['lang' => 'et',        'href' => self::BASES['et'] . $slugs['et']],
                ['lang' => 'ru',        'href' => self::BASES['ru'] . $slugs['ru']],
                ['lang' => 'en',        'href' => self::BASES['en'] . $slugs['en']],
                ['lang' => 'x-default', 'href' => self::BASES['et'] . $slugs['et']],
            ];
        }

        return $map;
    }
}
