{{-- Pillar Guide page — Phase 5 topical authority --}}
@extends('layouts.app')

@section('title', $guide['meta_title'] ?? '')
@section('description', $guide['meta_description'] ?? '')
@section('logo_text', $ui['logo_text'] ?? '')
@section('footer_class', 'footer--page')

@section('lang_et_url', route('et.pillar', $guideConfig['slug']))
@section('lang_ru_url', route('ru.pillar', $guideConfig['slug_ru']))
@section('lang_en_url', route('en.pillar', $guideConfig['slug_en']))

@push('jsonld')
{!! \App\Support\JsonLd::article(
    $guide['h1'],
    \App\Support\SeoLinks::canonical($pageKey),
    $guide['meta_description'],
    $guideConfig['date_published'] ?? null,
    $guideConfig['date_modified'] ?? null
) !!}
{!! \App\Support\JsonLd::breadcrumbs([
    ['name' => $nav[0]['label'] ?? 'Home', 'url' => route("{$locale}.home")],
    ['name' => $locale === 'ru' ? 'База знаний' : ($locale === 'en' ? 'Knowledge Hub' : 'Teadmistebaas'), 'url' => route("{$locale}.knowledge")],
    ['name' => $guide['h1']],
]) !!}
{!! \App\Support\Schema::speakable(\App\Support\SeoLinks::canonical($pageKey)) !!}
@if(!empty($guide['faq']))
<x-faq-schema :items="$guide['faq']" />
@endif
@endpush

@section('content')

{{-- ═══ Hero ═══ --}}
<section class="hero hero--guide">
  <div class="container text-center">
    <h1>{{ $guide['h1'] }}</h1>
    <p class="guide-hero-meta">
      <span class="guide-updated">📅 {{ $guide['updated'] }}</span>
      <span class="guide-author">✍️ Aleksandr Primakov</span>
    </p>
  </div>
</section>

{{-- ═══ AI Summary ═══ --}}
@if(!empty($guide['ai_summary']))
<section class="guide-ai-summary">
  <div class="container">
    <div class="ai-box">
      <h2 class="ai-box__title">{{ $guide['ai_summary']['title'] }}</h2>
      <dl class="ai-box__list">
        <dt>{{ $locale === 'ru' ? 'Проблема' : ($locale === 'en' ? 'Problem' : 'Probleem') }}</dt>
        <dd>{{ $guide['ai_summary']['problem'] }}</dd>
        <dt>{{ $locale === 'ru' ? 'Решение' : ($locale === 'en' ? 'Solution' : 'Lahendus') }}</dt>
        <dd>{{ $guide['ai_summary']['solution'] }}</dd>
        <dt>{{ $locale === 'ru' ? 'Сроки' : ($locale === 'en' ? 'Timeline' : 'Aeg') }}</dt>
        <dd>{{ $guide['ai_summary']['timeline'] }}</dd>
        <dt>{{ $locale === 'ru' ? 'Стоимость' : ($locale === 'en' ? 'Cost' : 'Hind') }}</dt>
        <dd>{{ $guide['ai_summary']['cost'] }}</dd>
        <dt>{{ $locale === 'ru' ? 'Результат' : ($locale === 'en' ? 'Result' : 'Tulemus') }}</dt>
        <dd>{{ $guide['ai_summary']['result'] }}</dd>
      </dl>
    </div>
  </div>
</section>
@endif

{{-- ═══ Table of Contents ═══ --}}
@if(!empty($guide['sections']))
<nav class="guide-toc" aria-label="Table of Contents">
  <div class="container">
    <details open>
      <summary>{{ $locale === 'ru' ? 'Содержание' : ($locale === 'en' ? 'Table of Contents' : 'Sisukord') }}</summary>
      <ol class="guide-toc__list">
        @foreach($guide['sections'] as $i => $sec)
        <li><a href="#section-{{ $i + 1 }}">{{ $sec['h2'] }}</a></li>
        @endforeach
      </ol>
    </details>
  </div>
</nav>
@endif

{{-- ═══ Content sections ═══ --}}
<div class="container">
  <div class="row">
    <div class="col-md-3 col-sm-3 text-center">
      @include('partials.sidebar-services', ['locale' => $locale, 'pageKey' => $pageKey])
    </div>
    <div class="col-md-9 col-sm-9">
      <div class="content guide-content">

        @foreach($guide['sections'] as $i => $section)
        <section class="guide-section" id="section-{{ $i + 1 }}">
          <h2>{{ $section['h2'] }}</h2>
          <p>{{ $section['text'] }}</p>
        </section>
        @endforeach

        {{-- Data authority block --}}
        @include('partials.data-authority', ['locale' => $locale])

        @include('partials.ai-citation', ['locale' => $locale])
      </div>
    </div>
  </div>
</div>

{{-- ═══ Trust layer ═══ --}}
@include('partials.trust-protection', ['locale' => $locale])

{{-- ═══ Inaction risks ═══ --}}
@include('partials.inaction-risks', ['locale' => $locale])

{{-- ═══ Cases ═══ --}}
@include('partials.case-cards', ['locale' => $locale, 'limit' => 3])

{{-- ═══ Agent trust ═══ --}}
@include('components.v3.trust-agent', ['locale' => $locale])

{{-- ═══ FAQ ═══ --}}
@if(!empty($guide['faq']))
@include('partials.faq', ['faq' => $guide['faq'], 'faqTitle' => 'FAQ'])
@endif

{{-- ═══ CTA ═══ --}}
@if(!empty($guide['cta_title']))
<section class="guide-cta">
  <div class="container text-center">
    <h2>{{ $guide['cta_title'] }}</h2>
    <a href="#audit-form" class="btn btn-primary btn-lg">{{ $guide['cta_btn'] }}</a>
  </div>
</section>
@endif

{{-- ═══ Knowledge hub crosslinks ═══ --}}
@include('partials.knowledge-crosslinks', ['locale' => $locale, 'currentGuideKey' => $guideKey])

{{-- ═══ Forms ═══ --}}
@include('components.v3.form-audit', ['locale' => $locale])
@include('components.v3.form-calc', ['locale' => $locale])
@include('components.v3.form-scripts')

@endsection
