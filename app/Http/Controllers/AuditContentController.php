<?php

namespace App\Http\Controllers;

use App\Models\AreaAudit;
use App\Models\Guide;
use App\Support\JsonLd;
use App\Support\SeoLinks;
use Illuminate\Http\Request;

class AuditContentController extends Controller
{
    /**
     * Audits index — list all published audits, optional audit_type filter.
     */
    public function index(Request $request, string $locale = 'et')
    {
        app()->setLocale($locale);
        $ui  = config("cityee.ui.{$locale}", []);
        $nav = config("cityee.nav.{$locale}", []);

        $query = AreaAudit::published()->locale($locale)->latest('published_at');

        $auditType = $request->query('type');
        if ($auditType && in_array($auditType, ['listing_audit', 'price_corridor', 'sales_plan'])) {
            $query->auditType($auditType);
        }

        $audits = $query->get();
        $auditTypes = AreaAudit::published()->locale($locale)
            ->select('audit_type')
            ->distinct()
            ->pluck('audit_type');

        return view('pages.audits.index', [
            'locale'         => $locale,
            'ui'             => $ui,
            'nav'            => $nav,
            'audits'         => $audits,
            'auditTypes'     => $auditTypes,
            'activeType'     => $auditType,
            'pageKey'        => 'audits',
        ]);
    }

    /**
     * Show a single audit with related content.
     */
    public function show(string $slug, string $locale = 'et')
    {
        app()->setLocale($locale);
        $ui  = config("cityee.ui.{$locale}", []);
        $nav = config("cityee.nav.{$locale}", []);

        $audit = AreaAudit::published()->locale($locale)->where('slug', $slug)->firstOrFail();

        // Alternates for hreflang
        $alternates = AreaAudit::published()->where('slug', $slug)->get()->keyBy('locale');

        // Build per-page canonical + hreflang for this specific audit
        $base = 'https://cityee.ee';
        $prefixMap = ['et' => '', 'ru' => '/ru', 'en' => '/en'];
        $canonicalUrl = $base . ($prefixMap[$locale] ?? '') . "/audits/{$slug}";

        $hreflangLinks = [];
        $hreflangCodeMap = ['et' => 'et-EE', 'ru' => 'ru-EE', 'en' => 'en-EE'];
        foreach ($alternates as $altLocale => $altAudit) {
            $hreflangLinks[] = [
                'hreflang' => $hreflangCodeMap[$altLocale] ?? $altLocale,
                'href'     => $base . ($prefixMap[$altLocale] ?? '') . "/audits/{$slug}",
            ];
        }
        if ($alternates->has('et')) {
            $hreflangLinks[] = [
                'hreflang' => 'x-default',
                'href'     => $base . "/audits/{$slug}",
            ];
        }

        // Related content
        $relatedGuides = $audit->relatedGuides();
        $relatedAudits = $audit->relatedAudits();

        return view('pages.audits.show', [
            'locale'         => $locale,
            'ui'             => $ui,
            'nav'            => $nav,
            'audit'          => $audit,
            'alternates'     => $alternates,
            'relatedGuides'  => $relatedGuides,
            'relatedAudits'  => $relatedAudits,
            'pageKey'        => 'audits',
            'canonicalUrl'   => $canonicalUrl,
            'hreflangLinks'  => $hreflangLinks,
        ]);
    }
}
