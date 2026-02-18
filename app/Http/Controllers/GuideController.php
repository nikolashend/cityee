<?php

namespace App\Http\Controllers;

use App\Models\Guide;
use App\Support\JsonLd;
use App\Support\SeoLinks;

class GuideController extends Controller
{
    /**
     * Guides index — list all published guides for the locale.
     */
    public function index(string $locale = 'et')
    {
        app()->setLocale($locale);
        $ui  = config("cityee.ui.{$locale}", []);
        $nav = config("cityee.nav.{$locale}", []);

        $guides = Guide::published()->locale($locale)->latest('published_at')->get();

        return view('pages.guides.index', [
            'locale'  => $locale,
            'ui'      => $ui,
            'nav'     => $nav,
            'guides'  => $guides,
        ]);
    }

    /**
     * Show a single guide.
     */
    public function show(string $slug, string $locale = 'et')
    {
        app()->setLocale($locale);
        $ui  = config("cityee.ui.{$locale}", []);
        $nav = config("cityee.nav.{$locale}", []);

        $guide = Guide::published()->locale($locale)->where('slug', $slug)->firstOrFail();

        // Find alternate-language versions for hreflang
        $alternates = Guide::published()->where('slug', $slug)->get()->keyBy('locale');

        return view('pages.guides.show', [
            'locale'     => $locale,
            'ui'         => $ui,
            'nav'        => $nav,
            'guide'      => $guide,
            'alternates' => $alternates,
        ]);
    }
}
