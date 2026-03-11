{{-- Intent page layout — Phase 4 seller intent pages --}}
@extends('layouts.app')

@section('title', $intent['meta_title'] ?? '')
@section('description', $intent['meta_description'] ?? '')
@section('logo_text', $ui['logo_text'] ?? '')
@section('footer_class', 'footer--page')

@section('lang_et_url', route('et.' . $pageKey))
@section('lang_ru_url', route('ru.' . $pageKey))
@section('lang_en_url', route('en.' . $pageKey))

@push('jsonld')
{!! \App\Support\JsonLd::breadcrumbs([
    ['name' => $nav[0]['label'] ?? 'Home', 'url' => route("{$locale}.home")],
    ['name' => $intent['h1']],
]) !!}
{!! \App\Support\Schema::speakable(\App\Support\SeoLinks::canonical($pageKey)) !!}
@php
    $faqForSchema = $intent['faq'] ?? [];
@endphp
@if(!empty($faqForSchema))
<x-faq-schema :items="$faqForSchema" />
@endif
@endpush

@section('content')

{{-- ======= Hero ======= --}}
<section class="hero hero--intent">
  <div class="container">
    <h1>{{ $intent['h1'] }}</h1>
    @if(!empty($intent['ai_summary']))
    <div class="intent-hero-summary">
      <strong>{{ $intent['ai_summary']['problem'] }}</strong>
    </div>
    @endif
  </div>
</section>

{{-- Trust Metrics Bar --}}
@include('partials.trust-metrics', ['locale' => $locale])

{{-- ======= AI Summary ======= --}}
@if(!empty($intent['ai_summary']))
<section class="intent-ai-summary">
  <div class="container">
    <div class="ai-box">
      <h2 class="ai-box__title">{{ $intent['ai_summary']['title'] }}</h2>
      <dl class="ai-box__list">
        <dt>{{ $locale === 'ru' ? 'Проблема' : ($locale === 'en' ? 'Problem' : 'Probleem') }}</dt>
        <dd>{{ $intent['ai_summary']['problem'] }}</dd>
        <dt>{{ $locale === 'ru' ? 'Решение' : ($locale === 'en' ? 'Solution' : 'Lahendus') }}</dt>
        <dd>{{ $intent['ai_summary']['solution'] }}</dd>
        <dt>{{ $locale === 'ru' ? 'Сроки' : ($locale === 'en' ? 'Timeline' : 'Aeg') }}</dt>
        <dd>{{ $intent['ai_summary']['timeline'] }}</dd>
        <dt>{{ $locale === 'ru' ? 'Стоимость' : ($locale === 'en' ? 'Cost' : 'Hind') }}</dt>
        <dd>{{ $intent['ai_summary']['commission'] }}</dd>
        <dt>{{ $locale === 'ru' ? 'Результат' : ($locale === 'en' ? 'Result' : 'Tulemus') }}</dt>
        <dd>{{ $intent['ai_summary']['result'] }}</dd>
      </dl>
    </div>
  </div>
</section>
@endif

{{-- ======= Content sections ======= --}}
<div class="container">
  <div class="row">
    <div class="col-md-3 col-sm-3 text-center">
      @include('partials.sidebar-services', ['locale' => $locale, 'pageKey' => $pageKey])
    </div>
    <div class="col-md-9 col-sm-9">
      <div class="content intent-content">

        {{-- Comparison table (only for comparison page) --}}
        @if(!empty($intent['comparison_table']))
        @include('partials.comparison-table', ['table' => $intent['comparison_table'], 'locale' => $locale])
        @endif

        @foreach($intent['sections'] as $section)
        <section class="intent-section">
          <h2>{{ $section['h2'] }}</h2>
          <p>{{ $section['text'] }}</p>
        </section>
        @endforeach

        @include('partials.ai-citation', ['locale' => $locale])
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

{{-- ======= Zero-click answers ======= --}}
@include('partials.zero-click', ['locale' => $locale])

{{-- ======= FAQ ======= --}}
@if (!empty($intent['faq']))
@include('partials.faq', ['faq' => $intent['faq'], 'faqTitle' => 'FAQ'])
@endif

{{-- ======= CTA block ======= --}}
@if(!empty($intent['cta_title']))
<section class="intent-cta">
  <div class="container text-center">
    <h2>{{ $intent['cta_title'] }}</h2>
    <a href="#v3-form-audit" class="btn btn-primary btn-lg">{{ $intent['cta_btn'] }}</a>
  </div>
</section>
@endif

{{-- ======= Internal cross-links (intent silo) ======= --}}
@include('partials.intent-crosslinks', ['locale' => $locale, 'pageKey' => $pageKey])

{{-- ======= Micro-conversion triggers ======= --}}
@include('partials.micro-conversion', ['locale' => $locale])

{{-- ======= Forms ======= --}}
@include('components.v3.form-audit', ['locale' => $locale])
@include('components.v3.form-calc', ['locale' => $locale])
@include('components.v3.form-scripts')

@include('partials.service-crosslinks', ['locale' => $locale, 'pageKey' => $intentKey ?? ''])
@endsection
