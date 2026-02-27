<?php

namespace App\Http\Controllers;

use App\Support\JsonLd;
use App\Support\Schema;
use App\Support\SeoLinks;

class LocationController extends Controller
{
    /**
     * Location page — show local area info with services, schema, interlinking.
     */
    public function show(string $slug, string $locale = 'et')
    {
        app()->setLocale($locale);
        $ui  = config("cityee.ui.{$locale}", []);
        $nav = config("cityee.nav.{$locale}", []);
        $co  = config('cityee.company');

        $locations = config('cityee-v3.locations', []);
        $location = $locations[$slug] ?? null;

        if (!$location) {
            abort(404);
        }

        $t = $location[$locale] ?? $location['et'] ?? [];

        // Build canonical + hreflang for this location
        $base = 'https://cityee.ee';
        $prefixMap = ['et' => '', 'ru' => '/ru', 'en' => '/en'];
        $canonicalUrl = $base . ($prefixMap[$locale] ?? '') . "/locations/{$slug}/";

        $hreflangLinks = [];
        $hreflangCodeMap = ['et' => 'et-EE', 'ru' => 'ru-EE', 'en' => 'en-EE'];
        foreach (['et', 'ru', 'en'] as $altLocale) {
            if (!empty($location[$altLocale])) {
                $hreflangLinks[] = [
                    'hreflang' => $hreflangCodeMap[$altLocale],
                    'href'     => $base . ($prefixMap[$altLocale] ?? '') . "/locations/{$slug}/",
                ];
            }
        }
        $hreflangLinks[] = [
            'hreflang' => 'x-default',
            'href'     => $base . "/locations/{$slug}/",
        ];

        return view('pages.location', [
            'locale'        => $locale,
            'ui'            => $ui,
            'nav'           => $nav,
            'pageKey'       => 'home', // fallback for nav active state
            'slug'          => $slug,
            't'             => $t,
            'location'      => $location,
            'canonicalUrl'  => $canonicalUrl,
            'hreflangLinks' => $hreflangLinks,
        ]);
    }
}
