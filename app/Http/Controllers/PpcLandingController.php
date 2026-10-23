<?php

namespace App\Http\Controllers;

/**
 * Paid-traffic landing pages (Google Ads) — CITYEE PPC Monetization Train V2.
 *
 * Deliberately separate from Phase3Controller: these pages are NOT organic
 * assets. The controller is the single place that guarantees the paid-page
 * contract for every LP it serves:
 *
 *   • pageNoindex = true  → <meta name="robots" content="noindex, follow">
 *   • canonicalUrl set    → self-canonical, and (because $hreflangLinks stays
 *                           unset) layouts/app.blade.php emits NO hreflang
 *   • never registered in any sitemap (see config/cityee-ppc.php header)
 *
 * No JSON-LD is pushed: a noindex page should not publish structured data.
 */
class PpcLandingController extends Controller
{
    public function landing(string $ppcKey)
    {
        $ppc = config("cityee-ppc.landings.{$ppcKey}");

        if (! $ppc) {
            abort(404);
        }

        $locale = $ppc['locale'] ?? 'ru';
        app()->setLocale($locale);

        return view('pages.ppc-landing', [
            'locale'       => $locale,
            'ui'           => config("cityee.ui.{$locale}", []),
            'nav'          => config("cityee.nav.{$locale}", []),
            'pageKey'      => 'ppc.' . $ppcKey,
            'ppcKey'       => $ppcKey,
            'ppc'          => $ppc,

            // Paid-page contract — see class docblock.
            'pageNoindex'  => true,
            'canonicalUrl' => url()->current(),

            // Re-points the sitewide sticky bar at this page's single job.
            // Same override idiom as the RU/ET valuation CRO experiments.
            'landing'      => [
                'sticky_cta_target' => $ppc['sticky_cta_target'] ?? null,
                'sticky_cta_label'  => $ppc['sticky_cta_label'] ?? null,
            ],
        ]);
    }
}
