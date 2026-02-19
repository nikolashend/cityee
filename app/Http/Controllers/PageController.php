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
}
