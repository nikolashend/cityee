{{-- Phase 3 district page — /ru/tallinn/{district} --}}
@extends('layouts.app')

@section('title', $district['meta_title'] ?? '')
@section('description', $district['meta_description'] ?? '')
@section('logo_text', $ui['logo_text'] ?? '')
@section('footer_class', 'footer--page')

@section('lang_et_url', route('et.home'))
@section('lang_ru_url', url()->current())
@section('lang_en_url', route('en.home'))

@push('jsonld')
{!! \App\Support\JsonLd::webPage($district['meta_title'] ?? '', url()->current(), $district['meta_description'] ?? '') !!}
{!! \App\Support\JsonLd::breadcrumbs([
    ['name' => $nav[0]['label'] ?? 'Главная', 'url' => route('ru.home')],
    ['name' => 'Районы Таллина', 'url' => route('ru.phase3.geo-hub')],
    ['name' => $district['name'] ?? $slug],
]) !!}
{!! \App\Support\Schema::speakable(url()->current()) !!}
<script type="application/ld+json">{!! json_encode(\App\Support\Schema::orgJsonLd(), JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT) !!}</script>
@php $faqSchema = $district['faq'] ?? []; @endphp
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
@endpush

@section('content')

{{-- ======= Hero ======= --}}
<section class="v3-hero" style="background:var(--ce-dark,#1a1a2e);color:#fff;padding:3.5rem 0 3rem">
  <div class="container text-center">
    <h1 class="v3-hero__title">{{ $district['h1'] }}</h1>
    <p class="v3-hero__sub" style="max-width:720px;margin:1rem auto;font-size:1.15rem;opacity:.9">
      {{ $district['subtitle'] ?? '' }}
    </p>
    <div class="v3-hero__cta" style="margin-top:1.8rem;display:flex;gap:1rem;justify-content:center;flex-wrap:wrap">
      <a href="#v3-form-audit" class="btn btn-v3-primary">Получить аудит</a>
      <a href="#v3-form-calc" class="btn btn-v3-secondary">Узнать ценовой коридор</a>
    </div>
  </div>
</section>

{{-- ======= Trust Metrics Bar ======= --}}
@include('partials.trust-metrics', ['locale' => $locale])

{{-- ======= AI Answer ======= --}}
@if(!empty($district['ai_answer']))
<section class="phase3-ai-answer" style="padding:2.5rem 0;background:#f8fafb">
  <div class="container" style="max-width:800px">
    <div style="background:#fff;border-left:4px solid #4ecdc4;border-radius:8px;padding:1.5rem 2rem;box-shadow:0 2px 8px rgba(0,0,0,.06)">
      <h2 style="font-size:1.15rem;margin:0 0 .75rem;color:#1a1a2e">Короткий ответ: продажа квартиры в {{ $district['name'] }}</h2>
      <p style="margin:0;line-height:1.7;font-size:1rem;color:#333">{{ $district['ai_answer'] }}</p>
    </div>
  </div>
</section>
@endif

{{-- ======= Content Sections ======= --}}
<div class="container" style="padding:2.5rem 0">
  <div class="row">
    <div class="col-md-8 col-sm-8">
      @foreach($district['sections'] ?? [] as $section)
      <section style="margin-bottom:2.5rem">
        <h2>{{ $section['h2'] }}</h2>
        <div style="line-height:1.75">{!! $section['text'] !!}</div>
      </section>
      @endforeach
    </div>

    {{-- Sidebar: Other districts --}}
    <div class="col-md-4 col-sm-4">
      <div style="background:var(--ce-warm-bg,#faf8f5);padding:1.5rem;border-radius:8px;margin-bottom:2rem">
        <h3 style="margin-top:0;font-size:1.05rem">Другие районы Таллина</h3>
        <ul style="list-style:none;padding:0;margin:0">
          @php $allDistricts = config('cityee-phase3.districts', []); @endphp
          @foreach($allDistricts as $dSlug => $dData)
            @if($dSlug !== $slug)
            <li style="margin-bottom:.6rem">
              <a href="{{ url('/ru/tallinn/' . $dSlug) }}/">→ {{ $dData['name'] ?? ucfirst($dSlug) }}</a>
            </li>
            @endif
          @endforeach
        </ul>
      </div>

      <div style="background:#f0f0f0;padding:1.5rem;border-radius:8px">
        <h3 style="margin-top:0;font-size:1.05rem">Услуги</h3>
        <ul style="list-style:none;padding:0;margin:0">
          <li style="margin-bottom:.6rem"><a href="/ru/prodat-kvartiru-v-tallinne/">→ Продать квартиру</a></li>
          <li style="margin-bottom:.6rem"><a href="/ru/ocenka-kvartiry-v-tallinne/">→ Оценка квартиры</a></li>
          <li style="margin-bottom:.6rem"><a href="/ru/audit-nedvizhimosti-tallinn/">→ Аудит объекта</a></li>
          <li style="margin-bottom:.6rem"><a href="/ru/makler-v-tallinne/">→ Маклер в Таллине</a></li>
        </ul>
      </div>
    </div>
  </div>
</div>

{{-- ======= Trust layer ======= --}}
@include('partials.advantages', ['ui' => $ui, 'isPage' => true])

{{-- ======= Agent trust ======= --}}
@include('components.v3.trust-agent', ['locale' => $locale])

{{-- ======= FAQ ======= --}}
@if (!empty($district['faq']))
@include('partials.faq', ['faq' => $district['faq'], 'faqTitle' => 'FAQ'])
@endif

{{-- ======= CTA ======= --}}
<section style="padding:3rem 0;text-align:center;background:var(--ce-warm-bg,#faf8f5)">
  <div class="container">
    <h2>Хотите продать квартиру в {{ $district['name'] }}?</h2>
    <a href="#v3-form-audit" class="btn btn-v3-primary" style="margin-top:1rem">Получить аудит объекта</a>
  </div>
</section>

{{-- ======= Cross-links ======= --}}
<section style="padding:2rem 0">
  <div class="container" style="max-width:800px">
    <h3 style="font-size:1.05rem;margin-bottom:1rem">Смотрите также</h3>
    <ul style="list-style:none;padding:0;display:flex;flex-wrap:wrap;gap:.75rem">
      <li><a href="/ru/tallinn/" style="display:inline-block;padding:.45rem 1rem;background:#f0f0f0;border-radius:6px;text-decoration:none;color:#1a1a2e;font-size:.92rem">Все районы Таллина</a></li>
      <li><a href="/ru/prodat-kvartiru-v-tallinne/" style="display:inline-block;padding:.45rem 1rem;background:#f0f0f0;border-radius:6px;text-decoration:none;color:#1a1a2e;font-size:.92rem">Продать квартиру</a></li>
      <li><a href="/ru/cases/" style="display:inline-block;padding:.45rem 1rem;background:#f0f0f0;border-radius:6px;text-decoration:none;color:#1a1a2e;font-size:.92rem">Реальные кейсы</a></li>
      <li><a href="/ru/makler-v-tallinne/" style="display:inline-block;padding:.45rem 1rem;background:#f0f0f0;border-radius:6px;text-decoration:none;color:#1a1a2e;font-size:.92rem">Маклер в Таллине</a></li>
    </ul>
  </div>
</section>

{{-- ======= Forms ======= --}}
@include('components.v3.form-audit', ['locale' => $locale])
@include('components.v3.form-calc', ['locale' => $locale])
@include('components.v3.form-scripts')

<div class="container" style="padding:1rem 0">
  <p><small>📍 CityEE — Таллинн, {{ $district['name'] }}, Эстония. Viru väljak 2, Tallinn 10111.</small></p>
</div>

@endsection
