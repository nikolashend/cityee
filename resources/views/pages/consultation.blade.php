{{-- Consultation page (konsultatsioon) --}}
@extends('layouts.app')

@section('title', $t['meta_title'] ?? '')
@section('description', $t['meta_description'] ?? '')
@section('logo_text', $ui['logo_text'] ?? '')
@section('footer_class', 'footer--page')

@section('lang_et_url', route('et.consultation'))
@section('lang_ru_url', route('ru.consultation'))
@section('lang_en_url', route('en.consultation'))

@push('jsonld')
{!! \App\Support\JsonLd::servicePage('consultation', $t) !!}
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
      @if (!empty($t['hero_subtitle2']))
      <p class="page-title__text">{{ $t['hero_subtitle2'] }}</p>
      @endif
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
        @include('partials.ai-summary', ['locale' => $locale])

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

        @if (!empty($t['bonus']))
        <div class="offers__bonus offers__bonus--bank">
          <p>{!! $t['bonus'] !!}</p>
        </div>
        @endif

        @if (!empty($t['pricing_title']))
        <h2>{{ $t['pricing_title'] }}</h2>
        @endif

        @if (!empty($t['pricing_table']))
        <div class="table__wrapp">
          <table>
            <tr>
              <th>{{ $locale === 'en' ? 'Services' : ($locale === 'ru' ? 'Услуги' : 'Teenused') }}</th>
              <th>{{ $locale === 'en' ? 'Price' : ($locale === 'ru' ? 'Цена' : 'Hind') }}</th>
            </tr>
            @foreach ($t['pricing_table'] as $row)
            <tr>
              <td>{{ $row['service'] }}</td>
              <td>{{ $row['price'] }}</td>
            </tr>
            @endforeach
          </table>
        </div>
        @endif

        <h2 class="text-left">{{ $ui['write_now'] ?? 'KIRJUTAGE MEILE KOHE!' }} </h2>

        <p class="text-left"><a href="" id="feedback1" class="btn"> {{ $ui['send_inquiry'] ?? 'SAADA PÄRING' }}</a></p>

        @include('partials.ai-citation', ['locale' => $locale])

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
