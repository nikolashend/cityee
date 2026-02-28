{{-- Service page v3: sell / rent / consultation — full intent→trust→conversion layout --}}
@extends('layouts.app')

@section('title', $t['meta_title'] ?? '')
@section('description', $t['meta_description'] ?? '')
@section('logo_text', $ui['logo_text'] ?? '')
@section('footer_class', 'footer--page')

@section('lang_et_url', route('et.' . $pageKey))
@section('lang_ru_url', route('ru.' . $pageKey))
@section('lang_en_url', route('en.' . $pageKey))

@push('jsonld')
{!! \App\Support\JsonLd::servicePage($pageKey, $t) !!}
{!! \App\Support\JsonLd::breadcrumbs([
    ['name' => $nav[0]['label'] ?? 'Home', 'url' => route("{$locale}.home")],
    ['name' => $t['h1']],
]) !!}
{!! \App\Support\Schema::speakable(\App\Support\SeoLinks::canonical($pageKey)) !!}
@php
    $faqForSchema = $v3Faq ?? $t['faq'] ?? [];
@endphp
@if(!empty($faqForSchema))
<x-faq-schema :items="$faqForSchema" />
@endif
@endpush

@section('content')

{{-- ======= C1: Hero v3 ======= --}}
@include('components.v3.hero', ['v3' => $v3, 'company' => config('cityee.company')])

{{-- Trust Metrics Bar --}}
@include('partials.trust-metrics', ['locale' => $locale])

{{-- ======= C2: JTBD "For whom" ======= --}}
@include('components.v3.jtbd', ['v3' => $v3])

{{-- ======= Original sidebar + content block ======= --}}
<div class="container">
  <div class="row">
    <div class="col-md-3 col-sm-3 text-center">
      @include('partials.sidebar-services', ['locale' => $locale, 'pageKey' => $pageKey])
    </div>
    <div class="col-md-9 col-sm-9">
      <div class="content">
        @include('partials.ai-summary', ['locale' => $locale, 'pageKey' => $pageKey])

        {!! $t['intro'] !!}

        @if (!empty($t['services']))
        <div class="possibilities">
          @if (!empty($t['services_title']))
          <h2>{{ $t['services_title'] }}</h2>
          @endif
          <ul>
            @foreach ($t['services'] as $service)
              <li>{{ $service }}</li>
            @endforeach
          </ul>
        </div>
        @endif

        {{-- Consultation pricing table (if present) --}}
        @if (!empty($t['pricing_table']))
        <h2>{{ $t['pricing_title'] ?? '' }}</h2>
        <div class="v3-table-wrap" role="region" tabindex="0">
            <table class="v3-table">
                <thead>
                    <tr>
                        <th>{{ $t['pricing_table_headers'][0] ?? '' }}</th>
                        <th>{{ $t['pricing_table_headers'][1] ?? '' }}</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($t['pricing_table'] as $row)
                    <tr>
                        <td>{{ $row['service'] }}</td>
                        <td>{{ $row['price'] }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @elseif (!empty($t['pricing_title']))
        <h2>{{ $t['pricing_title'] }}</h2>
        @endif

        @if (!empty($t['pricing_text']))
        {!! $t['pricing_text'] !!}
        @endif

        @if (!empty($t['bonus']))
        <div class="offers__bonus">
          <p>{!! $t['bonus'] !!}</p>
        </div>
        @endif

        @include('partials.ai-citation', ['locale' => $locale])
      </div>
    </div>
  </div>
</div>

{{-- ======= C3: Outcomes ======= --}}
@include('components.v3.outcomes', ['v3' => $v3])

{{-- ======= C4: Process ======= --}}
@include('components.v3.process', ['v3' => $v3])

{{-- ======= C5: Price / Commission Table ======= --}}
@include('components.v3.price-table', ['v3' => $v3])

{{-- ======= C6: Case Studies ======= --}}
@include('components.v3.cases', ['v3' => $v3, 'company' => config('cityee.company')])

{{-- ======= Phase 4: Sell page intent blocks (JTBD 30, Fears 30, Value 20, Strategies 20) ======= --}}
@if($pageKey === 'sell')
@include('partials.sell-jtbd-30', ['locale' => $locale])
@include('partials.sell-fears-30', ['locale' => $locale])
@include('partials.sell-value-20', ['locale' => $locale])
@include('partials.sell-strategies-20', ['locale' => $locale])
@include('partials.zero-click', ['locale' => $locale])
@include('partials.micro-conversion', ['locale' => $locale])
@endif

{{-- ======= Phase 5+6: Trust protection, inaction risks, data authority (sell page) ======= --}}
@if($pageKey === 'sell')
@include('partials.trust-protection', ['locale' => $locale])
@include('partials.inaction-risks', ['locale' => $locale])
@include('partials.data-authority', ['locale' => $locale])
@include('partials.before-after', ['locale' => $locale])
@endif

{{-- ======= Trust layer (existing) ======= --}}
@include('partials.advantages', ['ui' => $ui, 'isPage' => true])

{{-- ======= C8: Agent trust ======= --}}
@include('components.v3.trust-agent', ['locale' => $locale])

{{-- ======= About ======= --}}
@include('partials.about', ['ui' => $ui, 'isPage' => true])

{{-- ======= E: AI/SGE chunks ======= --}}
@if(!empty($v3['ai_short']))
@include('components.v3.ai-chunks', ['v3' => $v3])
@endif

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

{{-- ======= C7: Expanded FAQ ======= --}}
@if (!empty($v3Faq))
@include('partials.faq', ['faq' => $v3Faq, 'faqTitle' => 'FAQ'])
@elseif (!empty($t['faq']))
@include('partials.faq', ['faq' => $t['faq'], 'faqTitle' => 'FAQ'])
@endif

{{-- ======= D1: Internal cross-links (services ↔ guides ↔ audits) ======= --}}
@include('partials.service-crosslinks', ['locale' => $locale, 'pageKey' => $pageKey])

{{-- ======= Phase 4: Intent silo links (sell page only) ======= --}}
@if($pageKey === 'sell')
@include('partials.intent-crosslinks', ['locale' => $locale, 'pageKey' => $pageKey])
@endif

{{-- ======= D2: Forms — audit + calculator ======= --}}
@include('components.v3.form-audit', ['locale' => $locale])
@include('components.v3.form-calc', ['locale' => $locale])

{{-- ======= Form AJAX ======= --}}
@include('components.v3.form-scripts')

@endsection
