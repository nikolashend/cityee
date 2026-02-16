<?php

namespace App\Http\Controllers;

use App\Support\Lang;
use Illuminate\Http\Response;

class SitemapController extends Controller
{
    public function index(): Response
    {
        $urls = [
            // ET
            ['loc' => 'https://cityee.ee/',                'priority' => '1.0', 'changefreq' => 'weekly'],
            ['loc' => 'https://cityee.ee/kinnisvara-muuk', 'priority' => '0.9', 'changefreq' => 'monthly'],
            ['loc' => 'https://cityee.ee/kinnisvara-uur',  'priority' => '0.9', 'changefreq' => 'monthly'],
            ['loc' => 'https://cityee.ee/konsultatsioon',  'priority' => '0.8', 'changefreq' => 'monthly'],
            ['loc' => 'https://cityee.ee/kontaktid',       'priority' => '0.8', 'changefreq' => 'monthly'],
            ['loc' => 'https://cityee.ee/miks-cityee',     'priority' => '0.7', 'changefreq' => 'monthly'],
            // RU
            ['loc' => 'https://ru.cityee.ee/',                'priority' => '1.0', 'changefreq' => 'weekly'],
            ['loc' => 'https://ru.cityee.ee/kinnisvara-muuk', 'priority' => '0.9', 'changefreq' => 'monthly'],
            ['loc' => 'https://ru.cityee.ee/kinnisvara-uur',  'priority' => '0.9', 'changefreq' => 'monthly'],
            ['loc' => 'https://ru.cityee.ee/konsultatsioon',  'priority' => '0.8', 'changefreq' => 'monthly'],
            ['loc' => 'https://ru.cityee.ee/kontaktid',       'priority' => '0.8', 'changefreq' => 'monthly'],
            ['loc' => 'https://ru.cityee.ee/pochemu-cityee',  'priority' => '0.7', 'changefreq' => 'monthly'],
            // EN
            ['loc' => 'https://en.cityee.ee/',               'priority' => '1.0', 'changefreq' => 'weekly'],
            ['loc' => 'https://en.cityee.ee/sell-property',   'priority' => '0.9', 'changefreq' => 'monthly'],
            ['loc' => 'https://en.cityee.ee/rent-out-property','priority' => '0.9', 'changefreq' => 'monthly'],
            ['loc' => 'https://en.cityee.ee/consultation',    'priority' => '0.8', 'changefreq' => 'monthly'],
            ['loc' => 'https://en.cityee.ee/contacts',        'priority' => '0.8', 'changefreq' => 'monthly'],
            ['loc' => 'https://en.cityee.ee/why-cityee',      'priority' => '0.7', 'changefreq' => 'monthly'],
        ];

        $xml = '<?xml version="1.0" encoding="UTF-8"?>' . "\n";
        $xml .= '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9"' . "\n";
        $xml .= '        xmlns:xhtml="http://www.w3.org/1999/xhtml">' . "\n";

        foreach ($urls as $url) {
            $xml .= "  <url>\n";
            $xml .= "    <loc>{$url['loc']}</loc>\n";
            $xml .= "    <changefreq>{$url['changefreq']}</changefreq>\n";
            $xml .= "    <priority>{$url['priority']}</priority>\n";
            $xml .= "  </url>\n";
        }

        $xml .= '</urlset>';

        return response($xml, 200)->header('Content-Type', 'application/xml');
    }

    public function robots(): Response
    {
        $content = "User-agent: *\n";
        $content .= "Allow: /\n\n";
        $content .= "Sitemap: https://cityee.ee/sitemap.xml\n";
        $content .= "Sitemap: https://ru.cityee.ee/sitemap.xml\n";
        $content .= "Sitemap: https://en.cityee.ee/sitemap.xml\n";

        return response($content, 200)->header('Content-Type', 'text/plain');
    }
}
