<?php

namespace App\Http\Controllers;

use App\Models\Guide;
use App\Models\AreaAudit;
use App\Support\JsonLd;
use App\Support\SeoLinks;
use Illuminate\Http\Request;

class GuideController extends Controller
{
    /**
     * Guides index — list all published guides, optional category filter.
     */
    public function index(Request $request, string $locale = 'et')
    {
        app()->setLocale($locale);
        $ui  = config("cityee.ui.{$locale}", []);
        $nav = config("cityee.nav.{$locale}", []);

        $query = Guide::published()->locale($locale)->latest('published_at');

        $category = $request->query('category');
        if ($category && in_array($category, ['sell', 'rent', 'pricing', 'legal', 'marketing'])) {
            $query->category($category);
        }

        $guides = $query->get();
        $categories = Guide::published()->locale($locale)
            ->select('category')
            ->distinct()
            ->pluck('category');

        return view('pages.guides.index', [
            'locale'          => $locale,
            'ui'              => $ui,
            'nav'             => $nav,
            'guides'          => $guides,
            'categories'      => $categories,
            'activeCategory'  => $category,
            'pageKey'         => 'guides',
        ]);
    }

    /**
     * Show a single guide with related content.
     */
    public function show(string $slug, string $locale = 'et')
    {
        app()->setLocale($locale);
        $ui  = config("cityee.ui.{$locale}", []);
        $nav = config("cityee.nav.{$locale}", []);

        $guide = Guide::published()->locale($locale)->where('slug', $slug)->firstOrFail();

        // Alternates for hreflang
        $alternates = Guide::published()->where('slug', $slug)->get()->keyBy('locale');

        // Build per-page canonical + hreflang for this specific guide
        $base = 'https://cityee.ee';
        $prefixMap = ['et' => '', 'ru' => '/ru', 'en' => '/en'];
        $canonicalUrl = $base . ($prefixMap[$locale] ?? '') . "/guides/{$slug}/";

        $hreflangLinks = [];
        $hreflangCodeMap = ['et' => 'et-EE', 'ru' => 'ru-EE', 'en' => 'en-EE'];
        foreach ($alternates as $altLocale => $altGuide) {
            $hreflangLinks[] = [
                'hreflang' => $hreflangCodeMap[$altLocale] ?? $altLocale,
                'href'     => $base . ($prefixMap[$altLocale] ?? '') . "/guides/{$slug}/",
            ];
        }
        if ($alternates->has('et')) {
            $hreflangLinks[] = [
                'hreflang' => 'x-default',
                'href'     => $base . "/guides/{$slug}/",
            ];
        }

        // Related content
        $relatedGuides = $guide->relatedGuides();
        $relatedAudits = $guide->relatedAudits();

        return view('pages.guides.show', [
            'locale'         => $locale,
            'ui'             => $ui,
            'nav'            => $nav,
            'guide'          => $guide,
            'alternates'     => $alternates,
            'relatedGuides'  => $relatedGuides,
            'relatedAudits'  => $relatedAudits,
            'pageKey'        => 'guides',
            'canonicalUrl'   => $canonicalUrl,
            'hreflangLinks'  => $hreflangLinks,
        ]);
    }
}
