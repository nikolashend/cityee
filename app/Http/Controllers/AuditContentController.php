<?php

namespace App\Http\Controllers;

use App\Models\AreaAudit;
use App\Support\JsonLd;
use App\Support\SeoLinks;

class AuditContentController extends Controller
{
    /**
     * Area audits index — list all published audits for the locale.
     */
    public function index(string $locale = 'et')
    {
        app()->setLocale($locale);
        $ui  = config("cityee.ui.{$locale}", []);
        $nav = config("cityee.nav.{$locale}", []);

        $audits = AreaAudit::published()->locale($locale)->latest('published_at')->get();

        return view('pages.audits.index', [
            'locale' => $locale,
            'ui'     => $ui,
            'nav'    => $nav,
            'audits' => $audits,
        ]);
    }

    /**
     * Show a single area audit.
     */
    public function show(string $slug, string $locale = 'et')
    {
        app()->setLocale($locale);
        $ui  = config("cityee.ui.{$locale}", []);
        $nav = config("cityee.nav.{$locale}", []);

        $audit = AreaAudit::published()->locale($locale)->where('slug', $slug)->firstOrFail();

        // Find alternate-language versions for hreflang
        $alternates = AreaAudit::published()->where('slug', $slug)->get()->keyBy('locale');

        return view('pages.audits.show', [
            'locale'     => $locale,
            'ui'         => $ui,
            'nav'        => $nav,
            'audit'      => $audit,
            'alternates' => $alternates,
        ]);
    }
}
