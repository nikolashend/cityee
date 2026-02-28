<?php

namespace App\Http\Controllers;

use App\Support\Lang;
use App\Support\SeoLinks;
use App\Support\JsonLd;
use Illuminate\Http\Request;

class PageController extends Controller
{
    /**
     * Resolve the current locale from route default or domain.
     */
    private function locale(string $locale = 'et'): string
    {
        app()->setLocale($locale);
        return $locale;
    }

    /**
     * Get texts for a config section + locale.
     */
    private function texts(string $section, string $locale): array
    {
        return config("cityee.{$section}.{$locale}", []);
    }

    /**
     * Get UI strings for locale.
     */
    private function ui(string $locale): array
    {
        return config("cityee.ui.{$locale}", []);
    }

    /**
     * Get nav items for locale.
     */
    private function nav(string $locale): array
    {
        return config("cityee.nav.{$locale}", []);
    }

    // ─── Home ───────────────────────────────────────────────
    public function home(string $locale = 'et')
    {
        $locale = $this->locale($locale);
        $t      = $this->texts('home', $locale);
        $ui     = $this->ui($locale);

        return view('pages.home', [
            'locale'   => $locale,
            't'        => $t,
            'ui'       => $ui,
            'nav'      => $this->nav($locale),
            'pageKey'  => 'home',
            'homeFaq'  => config("cityee-v3.home_faq.{$locale}", []),
            'homeJtbd' => config("cityee-v3.home_jtbd.{$locale}", []),
            'homeAi'   => config("cityee-v3.home_ai.{$locale}", []),
        ]);
    }

    // ─── Sell (kinnisvara-muuk) ─────────────────────────────
    public function sell(string $locale = 'et')
    {
        $locale = $this->locale($locale);
        $t      = $this->texts('sell', $locale);
        $ui     = $this->ui($locale);

        return view('pages.service-v3', [
            'locale'  => $locale,
            't'       => $t,
            'ui'      => $ui,
            'nav'     => $this->nav($locale),
            'pageKey' => 'sell',
            'v3'      => config("cityee-v3.sell.{$locale}", []),
            'v3Faq'   => config("cityee-v3.sell_faq.{$locale}", []),
        ]);
    }

    // ─── Rent (kinnisvara-uur) ──────────────────────────────
    public function rent(string $locale = 'et')
    {
        $locale = $this->locale($locale);
        $t      = $this->texts('rent', $locale);
        $ui     = $this->ui($locale);

        return view('pages.service-v3', [
            'locale'  => $locale,
            't'       => $t,
            'ui'      => $ui,
            'nav'     => $this->nav($locale),
            'pageKey' => 'rent',
            'v3'      => config("cityee-v3.rent.{$locale}", []),
            'v3Faq'   => config("cityee-v3.rent_faq.{$locale}", []),
        ]);
    }

    // ─── Consultation (konsultatsioon) ──────────────────────
    public function consultation(string $locale = 'et')
    {
        $locale = $this->locale($locale);
        $t      = $this->texts('consultation', $locale);
        $ui     = $this->ui($locale);

        return view('pages.service-v3', [
            'locale'  => $locale,
            't'       => $t,
            'ui'      => $ui,
            'nav'     => $this->nav($locale),
            'pageKey' => 'consultation',
            'v3'      => config("cityee-v3.consultation.{$locale}", []),
            'v3Faq'   => config("cityee-v3.consultation_faq.{$locale}", []),
        ]);
    }

    // ─── Contacts (kontaktid) ───────────────────────────────
    public function contacts(string $locale = 'et')
    {
        $locale = $this->locale($locale);
        $t      = $this->texts('contacts', $locale);
        $ui     = $this->ui($locale);

        return view('pages.contacts', [
            'locale'      => $locale,
            't'           => $t,
            'ui'          => $ui,
            'nav'         => $this->nav($locale),
            'pageKey'     => 'contacts',
            'contactsFaq' => config("cityee-v3.contacts_faq.{$locale}", []),
        ]);
    }

    // ─── Why CityEE ─────────────────────────────────────────
    public function whyCityee(string $locale = 'et')
    {
        $locale = $this->locale($locale);
        $t      = $this->texts('why', $locale);
        $ui     = $this->ui($locale);

        return view('pages.why', [
            'locale'  => $locale,
            't'       => $t,
            'ui'      => $ui,
            'nav'     => $this->nav($locale),
            'pageKey' => 'why',
        ]);
    }

    // ─── Audit (property audit landing page) ────────────────
    public function audit(string $locale = 'et')
    {
        $locale = $this->locale($locale);
        $t      = $this->texts('audit', $locale);
        $ui     = $this->ui($locale);

        return view('pages.audit', [
            'locale'  => $locale,
            't'       => $t,
            'ui'      => $ui,
            'nav'     => $this->nav($locale),
            'pageKey' => 'audit',
        ]);
    }

    // ─── Knowledge (AI index hub) ───────────────────────────
    public function knowledge(string $locale = 'et')
    {
        $locale = $this->locale($locale);
        $ui     = $this->ui($locale);

        return view('pages.knowledge', [
            'locale'  => $locale,
            'ui'      => $ui,
            'nav'     => $this->nav($locale),
            'pageKey' => 'knowledge',
        ]);
    }

    // ─── Dashboard (SEO/UX scorecard) ───────────────────────
    public function dashboard(string $locale = 'et')
    {
        $locale = $this->locale($locale);
        $ui     = $this->ui($locale);

        return view('pages.dashboard', [
            'locale'  => $locale,
            'ui'      => $ui,
            'nav'     => $this->nav($locale),
            'pageKey' => 'dashboard',
        ]);
    }

    // ─── Aleksandr Primakov (EEAT Profile) ──────────────────
    public function profile(string $locale = 'et')
    {
        $locale = $this->locale($locale);
        $ui     = $this->ui($locale);

        return view('pages.profile', [
            'locale'  => $locale,
            'ui'      => $ui,
            'nav'     => $this->nav($locale),
            'pageKey' => 'profile',
        ]);
    }

    // ─── Intent Pages (Phase 4) ─────────────────────────────
    public function intentPage(string $locale = 'et', string $intentKey = '')
    {
        $locale = $this->locale($locale);
        $ui     = $this->ui($locale);
        $intent = config("cityee-intent.{$intentKey}.{$locale}", []);

        return view('pages.intent', [
            'locale'  => $locale,
            'ui'      => $ui,
            'nav'     => $this->nav($locale),
            'pageKey' => $intentKey,
            'intent'  => $intent,
        ]);
    }

    // ─── Pillar Guide (Phase 5) ─────────────────────────────
    public function pillarGuide(string $slug, string $locale = 'et')
    {
        $locale = $this->locale($locale);
        $ui     = $this->ui($locale);

        // Find guide by slug across all guide keys
        $guideKeys = [
            'guide_sell_tallinn', 'guide_rent', 'guide_pricing',
            'guide_negotiation', 'guide_staging', 'guide_market_2026', 'guide_mistakes',
        ];

        $slugField = match ($locale) {
            'ru' => 'slug_ru',
            'en' => 'slug_en',
            default => 'slug',
        };

        $guideKey    = null;
        $guideConfig = null;

        foreach ($guideKeys as $key) {
            $cfg = config("cityee-knowledge.pillar_guides.{$key}");
            if ($cfg && $cfg[$slugField] === $slug) {
                $guideKey    = $key;
                $guideConfig = $cfg;
                break;
            }
        }

        if (! $guideConfig) {
            abort(404);
        }

        $guide = $guideConfig[$locale] ?? $guideConfig['et'];

        return view('pages.pillar-guide', [
            'locale'      => $locale,
            'ui'          => $ui,
            'nav'         => $this->nav($locale),
            'pageKey'     => 'pillar',
            'guideKey'    => $guideKey,
            'guideConfig' => $guideConfig,
            'guide'       => $guide,
        ]);
    }

    // ─── Cases Page (Phase 5) ───────────────────────────────
    public function casesPage(string $locale = 'et')
    {
        $locale = $this->locale($locale);
        $ui     = $this->ui($locale);

        return view('pages.cases', [
            'locale'  => $locale,
            'ui'      => $ui,
            'nav'     => $this->nav($locale),
            'pageKey' => 'cases',
        ]);
    }
}
