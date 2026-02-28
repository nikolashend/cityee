{{-- Cases Page — Phase 5 STEP 3 (full 10 cases) --}}
@extends('layouts.app')

@section('title', $locale === 'ru' ? 'Реальные кейсы — Продажа недвижимости Tallinn | CityEE' : ($locale === 'en' ? 'Real Cases — Property Sales Tallinn | CityEE' : 'Tegelikud juhtumid — Kinnisvara müük Tallinn | CityEE'))
@section('description', $locale === 'ru' ? '10 реальных кейсов продажи недвижимости в Таллинне: проблемы, решения, результаты и сроки.' : ($locale === 'en' ? '10 real estate sales cases in Tallinn: problems, solutions, results and timelines.' : '10 tegelikku kinnisvara müügijuhtumit Tallinnas: probleemid, lahendused, tulemused ja tähtajad.'))
@section('logo_text', $ui['logo_text'] ?? '')
@section('footer_class', 'footer--page')

@section('lang_et_url', route('et.cases'))
@section('lang_ru_url', route('ru.cases'))
@section('lang_en_url', route('en.cases'))

@push('jsonld')
{!! \App\Support\JsonLd::breadcrumbs([
    ['name' => $nav[0]['label'] ?? 'Home', 'url' => route("{$locale}.home")],
    ['name' => $locale === 'ru' ? 'База знаний' : ($locale === 'en' ? 'Knowledge Hub' : 'Teadmistebaas'), 'url' => route("{$locale}.knowledge")],
    ['name' => $locale === 'ru' ? 'Кейсы' : ($locale === 'en' ? 'Cases' : 'Juhtumid')],
]) !!}
{!! \App\Support\Schema::speakable(\App\Support\SeoLinks::canonical('cases')) !!}
@endpush

@section('content')

<section class="hero hero--guide">
  <div class="container text-center">
    <h1>{{ $locale === 'ru' ? 'Реальные кейсы CityEE' : ($locale === 'en' ? 'Real CityEE Cases' : 'CityEE tegelikud juhtumid') }}</h1>
    <p class="guide-hero-meta">{{ $locale === 'ru' ? '10 объектов. Конкретные проблемы. Конкретные результаты.' : ($locale === 'en' ? '10 properties. Real problems. Real results.' : '10 objekti. Konkreetsed probleemid. Konkreetsed tulemused.') }}</p>
  </div>
</section>

{{-- All cases --}}
@include('partials.case-cards', ['locale' => $locale])

{{-- Before/After --}}
@include('partials.before-after', ['locale' => $locale])

{{-- Data authority --}}
@include('partials.data-authority', ['locale' => $locale])

{{-- Trust Agent --}}
@include('components.v3.trust-agent', ['locale' => $locale])

{{-- CTA --}}
<section class="guide-cta">
  <div class="container text-center">
    <h2>{{ $locale === 'ru' ? 'Хотите такой же результат?' : ($locale === 'en' ? 'Want the same result?' : 'Soovite sama tulemust?') }}</h2>
    <a href="#audit-form" class="btn btn-primary btn-lg">{{ $locale === 'ru' ? 'Бесплатный аудит' : ($locale === 'en' ? 'Free audit' : 'Tasuta audit') }}</a>
  </div>
</section>

{{-- Knowledge crosslinks --}}
@include('partials.knowledge-crosslinks', ['locale' => $locale, 'currentGuideKey' => ''])

{{-- Forms --}}
@include('components.v3.form-audit', ['locale' => $locale])
@include('components.v3.form-calc', ['locale' => $locale])
@include('components.v3.form-scripts')

@endsection
