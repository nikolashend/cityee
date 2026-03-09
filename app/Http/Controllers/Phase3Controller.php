<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class Phase3Controller extends Controller
{
    private function locale(): string
    {
        app()->setLocale('ru');
        return 'ru';
    }

    private function ui(): array
    {
        return config('cityee.ui.ru', []);
    }

    private function nav(): array
    {
        return config('cityee.nav.ru', []);
    }

    // ─── Intent Landing Pages ───────────────────────────────
    public function landing(string $landingKey)
    {
        $locale  = $this->locale();
        $landing = config("cityee-phase3.landings.{$landingKey}");

        if (! $landing) {
            abort(404);
        }

        return view('pages.phase3-landing', [
            'locale'     => $locale,
            'ui'         => $this->ui(),
            'nav'        => $this->nav(),
            'pageKey'    => 'phase3.' . $landingKey,
            'landingKey' => $landingKey,
            'landing'    => $landing,
        ]);
    }

    // ─── GEO Hub — /ru/tallinn/ ─────────────────────────────
    public function geoHub()
    {
        $locale    = $this->locale();
        $hub       = config('cityee-phase3.geo_hub', []);
        $districts = config('cityee-phase3.districts', []);

        return view('pages.phase3-geo-hub', [
            'locale'    => $locale,
            'ui'        => $this->ui(),
            'nav'       => $this->nav(),
            'pageKey'   => 'phase3.geo-hub',
            'hub'       => $hub,
            'districts' => $districts,
        ]);
    }

    // ─── District Page — /ru/tallinn/{district} ─────────────
    public function district(string $slug)
    {
        $locale   = $this->locale();
        $district = config("cityee-phase3.districts.{$slug}");

        if (! $district) {
            abort(404);
        }

        return view('pages.phase3-district', [
            'locale'   => $locale,
            'ui'       => $this->ui(),
            'nav'      => $this->nav(),
            'pageKey'  => 'phase3.district.' . $slug,
            'slug'     => $slug,
            'district' => $district,
        ]);
    }

    // ─── Cases Hub — /ru/cases/ ─────────────────────────────
    public function casesHub()
    {
        $locale = $this->locale();
        $hub    = config('cityee-phase3.cases_hub', []);
        $cases  = config('cityee-phase3.cases', []);

        return view('pages.phase3-cases-hub', [
            'locale'  => $locale,
            'ui'      => $this->ui(),
            'nav'     => $this->nav(),
            'pageKey' => 'phase3.cases-hub',
            'hub'     => $hub,
            'cases'   => $cases,
        ]);
    }

    // ─── Individual Case — /ru/cases/{slug} ─────────────────
    public function caseDetail(string $slug)
    {
        $locale = $this->locale();
        $case   = config("cityee-phase3.cases.{$slug}");

        if (! $case) {
            abort(404);
        }

        return view('pages.phase3-case', [
            'locale'  => $locale,
            'ui'      => $this->ui(),
            'nav'     => $this->nav(),
            'pageKey' => 'phase3.case.' . $slug,
            'slug'    => $slug,
            'case'    => $case,
        ]);
    }
}
