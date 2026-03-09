{{-- Phase 3 cases hub — /ru/cases/ --}}
@extends('layouts.app')

@section('title', $hub['meta_title'] ?? '')
@section('description', $hub['meta_description'] ?? '')
@section('logo_text', $ui['logo_text'] ?? '')
@section('footer_class', 'footer--page')

@section('lang_ru_url', url()->current())

@push('jsonld')
{!! \App\Support\JsonLd::webPage($hub['meta_title'] ?? '', url()->current(), $hub['meta_description'] ?? '') !!}
{!! \App\Support\JsonLd::breadcrumbs([
    ['name' => $nav[0]['label'] ?? 'Главная', 'url' => route('ru.home')],
    ['name' => 'Кейсы'],
]) !!}
{!! \App\Support\Schema::speakable(url()->current()) !!}
<script type="application/ld+json">{!! json_encode(\App\Support\Schema::orgJsonLd(), JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT) !!}</script>
@endpush

@section('content')

{{-- ======= Hero ======= --}}
<section class="v3-hero" style="background:var(--ce-dark,#1a1a2e);color:#fff;padding:3.5rem 0 3rem">
  <div class="container text-center">
    <h1 class="v3-hero__title">{{ $hub['h1'] }}</h1>
    <p class="v3-hero__sub" style="max-width:720px;margin:1rem auto;font-size:1.15rem;opacity:.9">
      {{ $hub['intro'] ?? '' }}
    </p>
  </div>
</section>

{{-- ======= Trust Metrics Bar ======= --}}
@include('partials.trust-metrics', ['locale' => $locale])

{{-- ======= Case Cards ======= --}}
<section style="padding:3rem 0">
  <div class="container">
    <div style="display:grid;grid-template-columns:repeat(auto-fit,minmax(320px,1fr));gap:1.5rem">
      @foreach($cases as $caseSlug => $caseData)
      <a href="{{ url('/ru/cases/' . $caseSlug) }}/" class="phase3-case-card" style="background:#fff;padding:1.8rem;border-radius:10px;text-decoration:none;color:inherit;border-left:4px solid #7b1f45;box-shadow:0 2px 8px rgba(0,0,0,.06);transition:box-shadow .2s,transform .15s">
        <h3 style="margin:0 0 .8rem;font-size:1.1rem;color:#1a1a2e">{{ $caseData['h1'] ?? '' }}</h3>
        <div style="display:flex;flex-wrap:wrap;gap:.5rem;margin-bottom:.8rem">
          <span style="background:#f0f0f0;padding:.25rem .6rem;border-radius:4px;font-size:.8rem">{{ $caseData['district'] ?? '' }}</span>
          <span style="background:#f0f0f0;padding:.25rem .6rem;border-radius:4px;font-size:.8rem">{{ $caseData['type'] ?? '' }}</span>
          <span style="background:#f0f0f0;padding:.25rem .6rem;border-radius:4px;font-size:.8rem">{{ $caseData['area'] ?? '' }}</span>
          <span style="background:#e8f5e9;padding:.25rem .6rem;border-radius:4px;font-size:.8rem;color:#2e7d32">{{ $caseData['time'] ?? '' }}</span>
        </div>
        <p style="font-size:.9rem;opacity:.7;margin:0;line-height:1.5">{{ Str::limit($caseData['summary'] ?? '', 140) }}</p>
      </a>
      @endforeach
    </div>
  </div>
</section>

{{-- ======= Trust layer ======= --}}
@include('partials.advantages', ['ui' => $ui, 'isPage' => true])

{{-- ======= Agent trust ======= --}}
@include('components.v3.trust-agent', ['locale' => $locale])

{{-- ======= CTA ======= --}}
<section style="padding:3rem 0;text-align:center;background:var(--ce-warm-bg,#faf8f5)">
  <div class="container">
    <h2>Хотите такой же результат?</h2>
    <p style="max-width:500px;margin:1rem auto;opacity:.8">Расскажем, как стратегия продажи может работать для вашего объекта.</p>
    <a href="#v3-form-audit" class="btn btn-v3-primary" style="margin-top:1rem">Получить аудит объекта</a>
  </div>
</section>

{{-- ======= Cross-links ======= --}}
<section style="padding:2.5rem 0">
  <div class="container" style="max-width:800px">
    <h3 style="font-size:1.05rem;margin-bottom:1rem">Смотрите также</h3>
    <ul style="list-style:none;padding:0;display:flex;flex-wrap:wrap;gap:.75rem">
      <li><a href="/ru/prodat-kvartiru-v-tallinne/" style="display:inline-block;padding:.45rem 1rem;background:#f0f0f0;border-radius:6px;text-decoration:none;color:#1a1a2e;font-size:.92rem">Продать квартиру</a></li>
      <li><a href="/ru/makler-v-tallinne/" style="display:inline-block;padding:.45rem 1rem;background:#f0f0f0;border-radius:6px;text-decoration:none;color:#1a1a2e;font-size:.92rem">Маклер в Таллине</a></li>
      <li><a href="/ru/tallinn/" style="display:inline-block;padding:.45rem 1rem;background:#f0f0f0;border-radius:6px;text-decoration:none;color:#1a1a2e;font-size:.92rem">Районы Таллина</a></li>
      <li><a href="/ru/aleksandr-primakov/" style="display:inline-block;padding:.45rem 1rem;background:#f0f0f0;border-radius:6px;text-decoration:none;color:#1a1a2e;font-size:.92rem">Александр Примаков</a></li>
    </ul>
  </div>
</section>

{{-- ======= Forms ======= --}}
@include('components.v3.form-audit', ['locale' => $locale])
@include('components.v3.form-calc', ['locale' => $locale])
@include('components.v3.form-scripts')

<div class="container" style="padding:1rem 0">
  <p><small>📍 CityEE — Таллинн, Харьюмаа, Эстония. Viru väljak 2, Tallinn 10111.</small></p>
</div>

@endsection
