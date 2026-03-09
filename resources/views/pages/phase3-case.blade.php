{{-- Phase 3 individual case page — /ru/cases/{slug} --}}
@extends('layouts.app')

@section('title', $case['meta_title'] ?? '')
@section('description', $case['meta_description'] ?? '')
@section('logo_text', $ui['logo_text'] ?? '')
@section('footer_class', 'footer--page')

@section('lang_ru_url', url()->current())

@push('jsonld')
{!! \App\Support\JsonLd::webPage($case['meta_title'] ?? '', url()->current(), $case['meta_description'] ?? '') !!}
{!! \App\Support\JsonLd::breadcrumbs([
    ['name' => $nav[0]['label'] ?? 'Главная', 'url' => route('ru.home')],
    ['name' => 'Кейсы', 'url' => route('ru.phase3.cases-hub')],
    ['name' => $case['h1'] ?? ''],
]) !!}
{!! \App\Support\Schema::speakable(url()->current()) !!}
<script type="application/ld+json">{!! json_encode(\App\Support\Schema::orgJsonLd(), JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT) !!}</script>
@endpush

@section('content')

{{-- ======= Hero ======= --}}
<section class="v3-hero" style="background:var(--ce-dark,#1a1a2e);color:#fff;padding:3.5rem 0 3rem">
  <div class="container text-center">
    <h1 class="v3-hero__title">{{ $case['h1'] }}</h1>
    {{-- Quick stats --}}
    <div style="margin-top:1.5rem;display:flex;gap:1.5rem;justify-content:center;flex-wrap:wrap">
      <div style="text-align:center">
        <div style="font-size:1.4rem;font-weight:700;color:#4ecdc4">{{ $case['district'] ?? '' }}</div>
        <div style="font-size:.75rem;opacity:.6">Район</div>
      </div>
      <div style="text-align:center">
        <div style="font-size:1.4rem;font-weight:700;color:#4ecdc4">{{ $case['area'] ?? '' }}</div>
        <div style="font-size:.75rem;opacity:.6">Площадь</div>
      </div>
      <div style="text-align:center">
        <div style="font-size:1.4rem;font-weight:700;color:#4ecdc4">{{ $case['time'] ?? '' }}</div>
        <div style="font-size:.75rem;opacity:.6">Срок</div>
      </div>
      <div style="text-align:center">
        <div style="font-size:1.4rem;font-weight:700;color:#4ecdc4">{{ $case['price_result'] ?? '' }}</div>
        <div style="font-size:.75rem;opacity:.6">Цена</div>
      </div>
    </div>
  </div>
</section>

{{-- ======= Trust Metrics Bar ======= --}}
@include('partials.trust-metrics', ['locale' => $locale])

{{-- ======= Case Content ======= --}}
<section style="padding:3rem 0">
  <div class="container" style="max-width:800px">

    {{-- Summary --}}
    <div style="background:#f8fafb;border-left:4px solid #4ecdc4;border-radius:8px;padding:1.5rem 2rem;margin-bottom:2.5rem;box-shadow:0 2px 8px rgba(0,0,0,.06)">
      <h2 style="font-size:1.15rem;margin:0 0 .75rem;color:#1a1a2e">Суть кейса</h2>
      <p style="margin:0;line-height:1.75">{{ $case['summary'] ?? '' }}</p>
    </div>

    {{-- Before --}}
    @if(!empty($case['before']))
    <h2 style="font-size:1.15rem;margin-bottom:.75rem">📋 Исходная ситуация</h2>
    <p style="line-height:1.75;margin-bottom:2rem">{{ $case['before'] }}</p>
    @endif

    {{-- Context --}}
    @if(!empty($case['context']))
    <h2 style="font-size:1.15rem;margin-bottom:.75rem">📊 Рыночный контекст</h2>
    <p style="line-height:1.75;margin-bottom:2rem">{{ $case['context'] }}</p>
    @endif

    {{-- Changes --}}
    @if(!empty($case['changes']))
    <h2 style="font-size:1.15rem;margin-bottom:.75rem">🔧 Что мы изменили</h2>
    <ul style="line-height:1.8;margin-bottom:2rem">
      @foreach($case['changes'] as $change)
      <li>{{ $change }}</li>
      @endforeach
    </ul>
    @endif

    {{-- Result --}}
    @if(!empty($case['result']))
    <h2 style="font-size:1.15rem;margin-bottom:.75rem">✅ Результат</h2>
    <p style="line-height:1.75;margin-bottom:2rem;font-weight:600;color:#2e7d32">{{ $case['result'] }}</p>
    @endif

    {{-- Lesson --}}
    @if(!empty($case['lesson']))
    <div style="background:#fff3e0;border:1px solid #ff9800;border-radius:8px;padding:1.25rem;margin-top:1rem">
      <strong>💡 Вывод:</strong> {{ $case['lesson'] }}
    </div>
    @endif

    {{-- Quick facts table --}}
    <div style="margin-top:2.5rem;overflow-x:auto">
      <table style="width:100%;border-collapse:collapse;font-size:.92rem">
        <tbody>
          <tr style="border-bottom:1px solid #eee"><td style="padding:.6rem;font-weight:600;width:40%">Тип объекта</td><td style="padding:.6rem">{{ $case['type'] ?? '' }}</td></tr>
          <tr style="border-bottom:1px solid #eee"><td style="padding:.6rem;font-weight:600">Район</td><td style="padding:.6rem">{{ $case['district'] ?? '' }}</td></tr>
          <tr style="border-bottom:1px solid #eee"><td style="padding:.6rem;font-weight:600">Площадь</td><td style="padding:.6rem">{{ $case['area'] ?? '' }}</td></tr>
          <tr style="border-bottom:1px solid #eee"><td style="padding:.6rem;font-weight:600">Срок продажи</td><td style="padding:.6rem">{{ $case['time'] ?? '' }}</td></tr>
          <tr style="border-bottom:1px solid #eee"><td style="padding:.6rem;font-weight:600">Конкуренция</td><td style="padding:.6rem">{{ $case['competitors'] ?? '' }}</td></tr>
          <tr style="border-bottom:1px solid #eee"><td style="padding:.6rem;font-weight:600">Цена сделки</td><td style="padding:.6rem">{{ $case['price_result'] ?? '' }}</td></tr>
          <tr><td style="padding:.6rem;font-weight:600">Торг</td><td style="padding:.6rem">{{ $case['bargaining'] ?? '' }}</td></tr>
        </tbody>
      </table>
    </div>
  </div>
</section>

{{-- ======= Agent trust ======= --}}
@include('components.v3.trust-agent', ['locale' => $locale])

{{-- ======= CTA ======= --}}
<section style="padding:3rem 0;text-align:center;background:var(--ce-warm-bg,#faf8f5)">
  <div class="container">
    <h2>Хотите такой же результат для вашей квартиры?</h2>
    <p style="max-width:500px;margin:1rem auto;opacity:.8">Проведём аудит, определим ценовой коридор и построим стратегию.</p>
    <a href="#v3-form-audit" class="btn btn-v3-primary" style="margin-top:1rem">Получить аудит объекта</a>
  </div>
</section>

{{-- ======= Other Cases ======= --}}
<section style="padding:2.5rem 0">
  <div class="container" style="max-width:800px">
    <h3 style="font-size:1.05rem;margin-bottom:1rem">Другие кейсы</h3>
    <ul style="list-style:none;padding:0;display:flex;flex-wrap:wrap;gap:.75rem">
      @php $allCases = config('cityee-phase3.cases', []); @endphp
      @foreach($allCases as $otherSlug => $otherCase)
        @if($otherSlug !== $slug)
        <li><a href="{{ url('/ru/cases/' . $otherSlug) }}/" style="display:inline-block;padding:.45rem 1rem;background:#f0f0f0;border-radius:6px;text-decoration:none;color:#1a1a2e;font-size:.88rem">{{ Str::limit($otherCase['h1'] ?? '', 50) }}</a></li>
        @endif
      @endforeach
    </ul>
    <div style="margin-top:1rem">
      <a href="/ru/cases/" style="font-weight:600;color:#7b1f45">← Все кейсы</a>
    </div>
  </div>
</section>

{{-- ======= Cross-links ======= --}}
<section style="padding:2rem 0">
  <div class="container" style="max-width:800px">
    <ul style="list-style:none;padding:0;display:flex;flex-wrap:wrap;gap:.75rem">
      <li><a href="/ru/prodat-kvartiru-v-tallinne/" style="display:inline-block;padding:.45rem 1rem;background:#f0f0f0;border-radius:6px;text-decoration:none;color:#1a1a2e;font-size:.92rem">Продать квартиру</a></li>
      <li><a href="/ru/makler-v-tallinne/" style="display:inline-block;padding:.45rem 1rem;background:#f0f0f0;border-radius:6px;text-decoration:none;color:#1a1a2e;font-size:.92rem">Маклер в Таллине</a></li>
      <li><a href="/ru/tallinn/" style="display:inline-block;padding:.45rem 1rem;background:#f0f0f0;border-radius:6px;text-decoration:none;color:#1a1a2e;font-size:.92rem">Районы Таллина</a></li>
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
