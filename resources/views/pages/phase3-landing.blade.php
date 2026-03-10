{{-- Phase 3 intent landing page — RU SEO pages --}}
@extends('layouts.app')

@section('title', $landing['meta_title'] ?? '')
@section('description', $landing['meta_description'] ?? '')
@section('logo_text', $ui['logo_text'] ?? '')
@section('footer_class', 'footer--page')

@section('lang_et_url', route('et.home'))
@section('lang_ru_url', url()->current())
@section('lang_en_url', route('en.home'))

@push('jsonld')
{!! \App\Support\JsonLd::webPage($landing['meta_title'] ?? '', url()->current(), $landing['meta_description'] ?? '') !!}
{!! \App\Support\JsonLd::breadcrumbs([
    ['name' => $nav[0]['label'] ?? 'Главная', 'url' => route('ru.home')],
    ['name' => $landing['h1']],
]) !!}
{!! \App\Support\Schema::speakable(url()->current()) !!}
<script type="application/ld+json">{!! json_encode(\App\Support\Schema::orgJsonLd(), JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT) !!}</script>
@php $faqSchema = $landing['faq'] ?? []; @endphp
@if(!empty($faqSchema))
<script type="application/ld+json">
{!! json_encode([
    '@context' => 'https://schema.org',
    '@type' => 'FAQPage',
    'mainEntity' => collect($faqSchema)->map(fn($f) => [
        '@type' => 'Question',
        'name' => $f['q'],
        'acceptedAnswer' => ['@type' => 'Answer', 'text' => $f['a']],
    ])->toArray(),
], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT) !!}
</script>
@endif
<script type="application/ld+json">
{!! json_encode([
    '@context' => 'https://schema.org',
    '@type' => 'Service',
    'name' => $landing['h1'] ?? '',
    'description' => $landing['meta_description'] ?? '',
    'url' => url()->current(),
    'provider' => ['@id' => 'https://cityee.ee/#organization'],
    'areaServed' => [
        ['@type' => 'City', 'name' => 'Tallinn'],
        ['@type' => 'AdministrativeArea', 'name' => 'Harjumaa'],
    ],
    'availableChannel' => [
        '@type' => 'ServiceChannel',
        'serviceUrl' => url()->current(),
        'servicePhone' => '+3725113411',
    ],
], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT) !!}
</script>
@endpush

@section('content')

{{-- ======= Hero ======= --}}
<section class="v3-hero" style="background:var(--ce-dark,#1a1a2e);color:#fff;padding:3.5rem 0 3rem">
  <div class="container text-center">
    <h1 class="v3-hero__title">{{ $landing['h1'] }}</h1>
    <p class="v3-hero__sub" style="max-width:720px;margin:1rem auto;font-size:1.15rem;opacity:.9">
      {{ $landing['subtitle'] ?? '' }}
    </p>
    <div class="v3-hero__cta" style="margin-top:1.8rem;display:flex;gap:1rem;justify-content:center;flex-wrap:wrap">
      <a href="#v3-form-audit" class="btn btn-v3-primary">{{ $landing['cta_primary'] ?? 'Получить аудит' }}</a>
      <a href="#v3-form-calc" class="btn btn-v3-secondary">{{ $landing['cta_secondary'] ?? 'Узнать цену' }}</a>
    </div>
  </div>
</section>

{{-- ======= Trust Metrics Bar ======= --}}
@include('partials.trust-metrics', ['locale' => $locale])

{{-- ======= AI Answer Block ======= --}}
@if(!empty($landing['ai_answer']))
<section class="phase3-ai-answer" style="padding:2.5rem 0;background:#f8fafb">
  <div class="container" style="max-width:800px">
    <div style="background:#fff;border-left:4px solid #4ecdc4;border-radius:8px;padding:1.5rem 2rem;box-shadow:0 2px 8px rgba(0,0,0,.06)">
      <h2 style="font-size:1.2rem;margin:0 0 .75rem;color:#1a1a2e">{{ $landing['ai_answer']['title'] }}</h2>
      <p style="margin:0;line-height:1.7;font-size:1rem;color:#333">{{ $landing['ai_answer']['text'] }}</p>
    </div>
  </div>
</section>
@endif

{{-- ======= When Needed Block ======= --}}
@if(!empty($landing['when_needed']))
<section style="padding:2rem 0">
  <div class="container" style="max-width:800px">
    <h2 style="font-size:1.15rem;margin-bottom:1rem">{{ $landing['when_needed']['title'] }}</h2>
    <ul style="line-height:1.8;padding-left:1.2rem">
      @foreach($landing['when_needed']['items'] as $item)
      <li>{{ $item }}</li>
      @endforeach
    </ul>
  </div>
</section>
@endif

{{-- ======= Content Sections ======= --}}
<div class="container">
  <div class="row">
    <div class="col-md-3 col-sm-3 text-center">
      @include('partials.sidebar-services', ['locale' => $locale, 'pageKey' => $pageKey])
    </div>
    <div class="col-md-9 col-sm-9">
      <div class="content phase3-content">
        @foreach($landing['sections'] as $section)
        <section class="phase3-section" style="margin-bottom:2.5rem">
          <h2>{{ $section['h2'] }}</h2>
          <div style="line-height:1.75">{!! $section['text'] !!}</div>
        </section>
        @endforeach
      </div>
    </div>
  </div>
</div>

{{-- ======= Trust layer ======= --}}
@include('partials.advantages', ['ui' => $ui, 'isPage' => true])

{{-- ======= Agent trust ======= --}}
@include('components.v3.trust-agent', ['locale' => $locale])

{{-- ======= About ======= --}}
@include('partials.about', ['ui' => $ui, 'isPage' => true])

{{-- ======= FAQ ======= --}}
@if (!empty($landing['faq']))
@include('partials.faq', ['faq' => $landing['faq'], 'faqTitle' => 'FAQ'])
@endif

{{-- ======= CTA Bottom ======= --}}
@if(!empty($landing['cta_bottom_title']))
<section class="phase3-cta" style="padding:3rem 0;text-align:center;background:var(--ce-warm-bg,#faf8f5)">
  <div class="container">
    <h2>{{ $landing['cta_bottom_title'] }}</h2>
    <a href="#v3-form-audit" class="btn btn-v3-primary" style="margin-top:1rem">{{ $landing['cta_bottom_btn'] ?? 'Связаться' }}</a>
  </div>
</section>
@endif

{{-- ======= Internal Cross-links ======= --}}
@if(!empty($landing['internal_links']))
<section class="phase3-crosslinks" style="padding:2.5rem 0">
  <div class="container" style="max-width:800px">
    <h3 style="font-size:1.1rem;margin-bottom:1rem">Полезные ссылки</h3>
    <ul style="list-style:none;padding:0;display:flex;flex-wrap:wrap;gap:.75rem">
      @foreach($landing['internal_links'] as $link)
      <li><a href="{{ $link['url'] }}" style="display:inline-block;padding:.45rem 1rem;background:#f0f0f0;border-radius:6px;text-decoration:none;color:#1a1a2e;font-size:.92rem;transition:background .2s">{{ $link['anchor'] }}</a></li>
      @endforeach
    </ul>
  </div>
</section>
@endif

{{-- ======= Forms ======= --}}
@include('components.v3.form-audit', ['locale' => $locale])
@include('components.v3.form-calc', ['locale' => $locale])
@include('components.v3.form-scripts')

{{-- Geo reinforcement --}}
<div class="container" style="padding:1rem 0">
  <p><small>📍 CityEE — Таллинн, Харьюмаа, Эстония. Viru väljak 2, Tallinn 10111.</small></p>
</div>

@endsection
