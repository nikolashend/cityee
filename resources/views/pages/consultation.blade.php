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
{!! \App\Support\Schema::speakable(url()->current()) !!}
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

        <div class="risk-reversal" style="margin-top:12px;margin-bottom:20px;">
          <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="16" height="16"><path fill="#25D366" d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z"/></svg>
          <span>{{ $locale === 'et' ? 'Ilma ettemaksuta. Komisjon ainult tehingu korral.' : ($locale === 'ru' ? 'Без аванса. Комиссия только по факту сделки.' : 'No advance payment. Commission only on successful deal.') }}</span>
        </div>

        <p class="text-center"><a href="{{ config('cityee.company.whatsapp') }}" target="_blank" rel="noopener" class="btn" style="background:#25D366;border-color:#25D366;">WhatsApp</a></p>

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
