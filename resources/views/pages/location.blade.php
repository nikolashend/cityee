{{-- Location page — local SEO landing: /locations/{slug} --}}
@extends('layouts.app')

@section('title', $t['meta_title'] ?? '')
@section('description', $t['meta_description'] ?? '')
@section('logo_text', $ui['logo_text'] ?? '')
@section('footer_class', 'footer--page')

@section('canonical_url', $canonicalUrl)
@section('hreflang_override')
@foreach ($hreflangLinks as $alt)
<link rel="alternate" hreflang="{{ $alt['hreflang'] }}" href="{{ $alt['href'] }}" />
@endforeach
@endsection

@push('jsonld')
{!! \App\Support\JsonLd::webPage($t['meta_title'] ?? '', $canonicalUrl, $t['meta_description'] ?? '') !!}
{!! \App\Support\JsonLd::breadcrumbs([
    ['name' => $nav[0]['label'] ?? 'Home', 'url' => route("{$locale}.home")],
    ['name' => $t['breadcrumb'] ?? $t['h1'] ?? $slug],
]) !!}
{!! \App\Support\Schema::speakable(url()->current()) !!}
<script type="application/ld+json">
{!! json_encode([
    '@context' => 'https://schema.org',
    '@type'    => 'LocalBusiness',
    '@id'      => 'https://cityee.ee/#organization',
    'name'     => 'CITY EE OÜ — Kinnisvaramaakler',
    'url'      => $canonicalUrl,
    'telephone'=> '+372 511 3411',
    'email'    => 'info@cityee.ee',
    'image'    => 'https://cityee.ee/assets/kinnisvara/primakov-maakler.webp',
    'address'  => [
        '@type'           => 'PostalAddress',
        'streetAddress'   => 'Viru väljak 2',
        'addressLocality' => 'Tallinn',
        'postalCode'      => '10111',
        'addressCountry'  => 'EE',
    ],
    'geo' => [
        '@type'     => 'GeoCoordinates',
        'latitude'  => 59.4370,
        'longitude' => 24.7536,
    ],
    'areaServed' => [
        '@type' => 'Place',
        'name'  => $t['area_served'] ?? $t['h1'] ?? $slug,
    ],
    'priceRange'  => '€€',
    'openingHours' => 'Mo-Fr 09:00-18:00',
    'aggregateRating' => [
        '@type'       => 'AggregateRating',
        'ratingValue' => '5.0',
        'reviewCount' => '47',
        'bestRating'  => '5',
        'worstRating' => '1',
    ],
], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT) !!}
</script>
@endpush

@section('content')

{{-- ======= Hero ======= --}}
<section class="v3-hero" style="background:var(--ce-dark);color:#fff;padding:3rem 0 2.5rem">
  <div class="container text-center">
    <h1 class="v3-hero__title">{{ $t['h1'] }}</h1>
    <p class="v3-hero__sub" style="max-width:700px;margin:1rem auto;font-size:1.15rem;opacity:.9">
      {{ $t['subtitle'] ?? '' }}
    </p>
    <div class="v3-hero__cta" style="margin-top:1.5rem;display:flex;gap:1rem;justify-content:center;flex-wrap:wrap">
      <a href="{{ route("{$locale}.consultation") }}" class="btn btn-v3-primary">
        {{ $t['cta_consult'] ?? ($locale === 'ru' ? 'Бесплатная консультация' : ($locale === 'en' ? 'Free consultation' : 'Tasuta konsultatsioon')) }}
      </a>
      <a href="#location-form" class="btn btn-v3-secondary">
        {{ $t['cta_audit'] ?? ($locale === 'ru' ? 'Заказать аудит' : ($locale === 'en' ? 'Request audit' : 'Telli audit')) }}
      </a>
    </div>
  </div>
</section>

{{-- ======= AI Summary ======= --}}
@include('partials.ai-summary', ['locale' => $locale])

{{-- ======= Area Description ======= --}}
<section class="v3-location-content" style="padding:2.5rem 0">
  <div class="container">
    <div class="row">
      <div class="col-md-8 col-sm-8">
        <div class="content">
          @if (!empty($t['intro']))
          {!! $t['intro'] !!}
          @endif

          {{-- Districts / Sub‐areas --}}
          @if (!empty($t['districts']))
          <h2>{{ $t['districts_title'] ?? ($locale === 'ru' ? 'Районы' : ($locale === 'en' ? 'Districts' : 'Linnaosad')) }}</h2>
          <ul>
            @foreach ($t['districts'] as $district)
            <li>{{ $district }}</li>
            @endforeach
          </ul>
          @endif

          {{-- Market overview --}}
          @if (!empty($t['market']))
          <h2>{{ $t['market_title'] ?? ($locale === 'ru' ? 'Рынок недвижимости' : ($locale === 'en' ? 'Real estate market' : 'Kinnisvaraturg')) }}</h2>
          {!! $t['market'] !!}
          @endif
        </div>
      </div>

      {{-- Sidebar: Services in this area --}}
      <div class="col-md-4 col-sm-4">
        <div class="v3-location-services" style="background:var(--ce-warm-bg,#faf8f5);padding:1.5rem;border-radius:var(--ce-radius-md,8px);margin-bottom:2rem">
          <h3 style="margin-top:0">{{ $t['services_title'] ?? ($locale === 'ru' ? 'Услуги в регионе' : ($locale === 'en' ? 'Services in area' : 'Teenused piirkonnas')) }}</h3>
          <ul style="list-style:none;padding:0;margin:0">
            <li style="margin-bottom:.75rem">
              <a href="{{ route("{$locale}.sell") }}">{{ $t['link_sell'] ?? ($locale === 'ru' ? '→ Продажа недвижимости' : ($locale === 'en' ? '→ Sell property' : '→ Kinnisvara müük')) }}</a>
            </li>
            <li style="margin-bottom:.75rem">
              <a href="{{ route("{$locale}.rent") }}">{{ $t['link_rent'] ?? ($locale === 'ru' ? '→ Аренда недвижимости' : ($locale === 'en' ? '→ Rent out property' : '→ Kinnisvara üür')) }}</a>
            </li>
            <li style="margin-bottom:.75rem">
              <a href="{{ route("{$locale}.consultation") }}">{{ $t['link_consult'] ?? ($locale === 'ru' ? '→ Консультация' : ($locale === 'en' ? '→ Consultation' : '→ Konsultatsioon')) }}</a>
            </li>
            <li style="margin-bottom:.75rem">
              <a href="{{ route("{$locale}.audit") }}">{{ $t['link_audit'] ?? ($locale === 'ru' ? '→ Аудит объявления' : ($locale === 'en' ? '→ Listing audit' : '→ Kuulutuse audit')) }}</a>
            </li>
          </ul>
        </div>

        {{-- Other locations interlink --}}
        @php
          $allLocations = config('cityee-v3.locations', []);
          $base = 'https://cityee.ee';
          $prefix = match($locale) { 'ru' => '/ru', 'en' => '/en', default => '' };
        @endphp
        @if (count($allLocations) > 1)
        <div class="v3-location-others" style="background:var(--ce-light-bg,#f5f5f5);padding:1.5rem;border-radius:var(--ce-radius-md,8px)">
          <h3 style="margin-top:0">{{ $locale === 'ru' ? 'Другие регионы' : ($locale === 'en' ? 'Other areas' : 'Teised piirkonnad') }}</h3>
          <ul style="list-style:none;padding:0;margin:0">
            @foreach ($allLocations as $otherSlug => $otherLoc)
              @if ($otherSlug !== $slug && !empty($otherLoc[$locale]))
              <li style="margin-bottom:.5rem">
                <a href="{{ $base . $prefix }}/locations/{{ $otherSlug }}/">
                  {{ $otherLoc[$locale]['h1'] ?? ucfirst($otherSlug) }}
                </a>
              </li>
              @endif
            @endforeach
          </ul>
        </div>
        @endif
      </div>
    </div>
  </div>
</section>

{{-- ======= Trust layer ======= --}}
@include('partials.advantages', ['ui' => $ui, 'isPage' => true])

{{-- ======= Agent trust ======= --}}
@include('components.v3.trust-agent', ['locale' => $locale])

{{-- ======= AI Answer Block ======= --}}
@if (!empty($t['answer_block']))
<div class="container">
@include('components.v3.answer-block', [
    'question' => $t['answer_block']['question'] ?? '',
    'answer'   => $t['answer_block']['answer'] ?? '',
    'bullets'  => $t['answer_block']['bullets'] ?? [],
    'locale'   => $locale,
])
</div>
@endif

{{-- ======= Voice Search Q&A ======= --}}
@if (!empty($t['voice_qa']))
<div class="container">
@include('components.v3.voice-answer', ['items' => $t['voice_qa'], 'locale' => $locale])
</div>
@endif

{{-- ======= FAQ ======= --}}
@if (!empty($t['faq']))
@include('partials.faq', ['faq' => $t['faq'], 'faqTitle' => 'FAQ'])
@endif

{{-- ======= Forms ======= --}}
<div id="location-form">
  @include('components.v3.form-audit', ['locale' => $locale])
  @include('components.v3.form-calc', ['locale' => $locale])
</div>
@include('components.v3.form-scripts')

@include('partials.ai-citation', ['locale' => $locale])

@endsection
