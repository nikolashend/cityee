{{-- Universal service page: sell (kinnisvara-muuk) / rent (kinnisvara-uur) --}}
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
@endpush

@section('content')

<div class="page-title" style="background: url({{ $t['hero_bg'] }}) no-repeat; background-position: center top; background-size: cover;">
  <div class="container">
    <h1 class="page-title__name">{{ $t['h1'] }}</h1>
      <p class="page-title__text">{{ $t['hero_subtitle'] }}</p>
    @if (!empty($t['hero_add']))
    <p class="page-title__add">{{ $t['hero_add'] }}</p>
    @endif
      <a href="" id="feedback" class="btn"> {{ $t['hero_cta'] }}</a>
  </div>
</div>


<div class="container">
  <div class="row">
    <div class="col-md-3 col-sm-3 text-center">
      @include('partials.sidebar-services', ['locale' => $locale, 'pageKey' => $pageKey])
    </div>
    <div class="col-md-9 col-sm-9">
      <div class="content">
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

        @if (!empty($t['pricing_title']))
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

        <h2 class="text-left">{{ $ui['write_now'] ?? 'KIRJUTAGE MEILE KOHE!' }} </h2>

        <p class="text-left"><a href="" id="feedback1" class="btn"> {{ $ui['send_inquiry'] ?? 'SAADA PÄRING' }}</a></p>

      </div>
    </div>
  </div>
</div>

@include('partials.advantages', ['ui' => $ui, 'isPage' => true])

@include('partials.about', ['ui' => $ui, 'isPage' => true])

@if (!empty($t['faq']))
@include('partials.faq', ['faq' => $t['faq'], 'faqTitle' => 'FAQ'])
@endif

@endsection
