{{-- Home page — unified for all locales --}}
@extends('layouts.app')

@section('title', $t['meta_title'] ?? '')
@section('description', $t['meta_description'] ?? '')
@section('logo_text', $ui['logo_text'] ?? '')

@section('lang_et_url', route('et.home'))
@section('lang_ru_url', route('ru.home'))
@section('lang_en_url', route('en.home'))

@php
    $co    = config('cityee.company');
    $agent = config('cityee.agent');
@endphp

@push('jsonld')
<script type="application/ld+json">{!! json_encode(\App\Support\Schema::orgJsonLd(), JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT) !!}</script>
{!! \App\Support\JsonLd::breadcrumbs([
    ['name' => $t['h1'] ?? 'Home', 'url' => \App\Support\SeoLinks::canonical('home')],
]) !!}
@endpush

@section('content')

<div class="banners">
  <ul class="banners__list">
    <li class="banners__item">
      <div class="container">
        <div class="banners__wrapp">
          <h1 class="banners__title">{{ $t['h1'] }}<span> {{ $t['h1_span'] }}</span></h1>
          <p class="banners__text">{!! $t['banner_text'] !!}</p>
          <a href="" id="feedback1" class="btn">{{ $ui['send_inquiry'] }}</a> <a href="/#spec-link" class="btn btn--spec">{{ $locale === 'en' ? 'Offers' : ($locale === 'ru' ? 'Предложения' : 'Pakkumised') }}</a>
        </div>
      </div>
    </li>
    <li class="banners__item banners__item--tallinn">
      <div class="container">
        <div class="banners__wrapp">
          <h2 class="banners__title">{{ $t['banner2_h2'] }}<span> {{ $t['banner2_span'] }}</span></h2>
          <p class="banners__text">{!! $t['banner2_text'] !!}</p>
          <a href="" id="feedback2" class="btn">{{ $ui['send_inquiry'] }}</a> <a href="/#spec-link" class="btn btn--spec">{{ $locale === 'en' ? 'Offers' : ($locale === 'ru' ? 'Предложения' : 'Pakkumised') }}</a>
        </div>
      </div>
    </li>
    <li class="banners__item banners__item--city">
      <div class="container">
        <div class="banners__wrapp">
          <h2 class="banners__title">{{ $t['banner3_h2'] }}<span>{{ $t['banner3_span'] }}</span></h2>
          <p class="banners__text">{!! $t['banner3_text'] !!}</p>
          <a href="" id="feedback3" class="btn">{{ $ui['send_inquiry'] }}</a> <a href="/#spec-link" class="btn btn--spec">{{ $locale === 'en' ? 'Offers' : ($locale === 'ru' ? 'Предложения' : 'Pakkumised') }}</a>
        </div>
      </div>
    </li>
  </ul>
  <section class="advantages">
  <div class="container">
    <h2 class="advantages__title">{{ $t['advantages_title'] }}</h2>
    <ul class="advantages__list">
      <li class="advantages__item">
        <div class="advantages__img advantages__img--speed"></div>
        <p class="advantages__text">{{ $ui['adv_speed'] }}</p>
      </li>
      <li class="advantages__item">
        <div class="advantages__img advantages__img--availability"></div>
        <p class="advantages__text">{{ $ui['adv_quality'] }}</p>
      </li>
      <li class="advantages__item">
        <div class="advantages__img advantages__img--confidentiality"></div>
        <p class="advantages__text">{{ $ui['adv_confid'] }}</p>
      </li>
      <li class="advantages__item">
        <div class="advantages__img advantages__img--reliability"></div>
        <p class="advantages__text">{{ $ui['adv_reliable'] }}</p>
      </li>
    </ul>
</div>
</section>

  </div>

<div id="spec-link" class="container">
  <section class="offers">
    <h2 class="main-h2">{{ $t['offers_title'] }}</h2>
    <div class="offers__wrapp">
      <a href="https://www.kv.ee/?act=search.simple&last_deal_type=1&deal_type=1&search_type=old&keyword=cityee" target="_blank" class="offers__item">
        <h3 class="offers__title">{{ $t['offers_apartments'] }}</h3>
        <div class="offers__img offers__img--polsha"></div>
        <ul class="offers__list">
        </ul>
      </a>
      <a href="https://www.kv.ee/?act=search.simple&last_deal_type=1&deal_type=1&search_type=old&keyword=cityee" target="_blank" class="offers__item">
        <h3 class="offers__title">{{ $t['offers_houses'] }}</h3>
        <div class="offers__img offers__img--scotland"></div>
        <ul class="offers__list">
        </ul>
      </a>
      <a href="https://www.kv.ee/?act=search.simple&last_deal_type=1&deal_type=1&search_type=old&keyword=cityee" target="_blank" class="offers__item">
        <h3 class="offers__title">{{ $t['offers_commercial'] }}</h3>
        <div class="offers__img offers__img--new-zealand"></div>
        <ul class="offers__list">
        </ul>
      </a>
    </div>
    <div class="offers__bonus">
      <p>{!! $t['offers_bonus'] !!}</p>
    </div>
  </section>
</div>


<section class="services">
  <div class="container">
    <h2 class="main-h2">{{ $t['services_title'] }}</h2>
    <div class="services__wrapp">
      <a href="{{ route("{$locale}.sell") }}" class="services__item services__item--offshors">
        <div class="services__img">
        </div>
        <h3 class="services__title">{{ $t['srv_sell'] }}</h3>
        <p class="services__text">{!! $t['srv_sell_desc'] !!}</p>
      </a>
      <a href="{{ route("{$locale}.rent") }}" class="services__item services__item--europe">
      <div class="services__img">
        </div>
        <h3 class="services__title">{{ $t['srv_rent'] }}</h3>
        <p class="services__text">{!! $t['srv_rent_desc'] !!}</p>
      </a>
      <a href="{{ route("{$locale}.consultation") }}" class="services__item services__item--banks">
      <div class="services__img">
      </div>
        <h3 class="services__title">{{ $t['srv_consult'] }}</h3>
        <p class="services__text">{!! $t['srv_consult_desc'] !!}</p>
      </a>
    </div>
  </div>
</section>


@include('partials.about', ['ui' => $ui])

<h2 class="main-h2">{{ $t['deals_title'] }}</h2>

<div class="container">
  <div class="container-slider">
    <div class="square-gallery">
      @for ($i = 1; $i <= 9; $i++)
      <div class="popup-gallery">
        <a class="gallery-item services__item lightboxed" rel="group{{ $i }}" href="/assets/kinnisvara/{{ $i }}/main.jpg" data-caption="" title="" description="" style="background-image:url('/assets/kinnisvara/{{ $i }}/main.jpg');"></a>
      </div>
      @endfor
    </div>
  </div>
</div>

<div>
  <h2 class="main-h2 bordeless">{{ $t['result_title'] }}
    <small style="display: block; text-transform: none; font-size: 17px; margin-bottom: 15px;">{{ $t['result_subtitle'] }}</small>
  </h2>
  <div class="text-center" style="margin-bottom: 7px;"><img src="{{ $agent['photo'] }}" width="240" alt="{{ $agent['name'] }}" /></div>
  <div class="text-center">
    <div style="color:#7b1f45; font-weight: bold;">{{ $agent['name'] }}</div>
    <div style="color: #777777; margin-bottom: 15px">{{ $t['result_agent_title'] }} | CITYEE Tallinn</div>
    <div style="color:#7b1f45;">{{ $agent['phone'] }}</div>
    <div style="color:#7b1f45; margin-bottom: 15px;">{{ $agent['email'] }}</div>
  </div>
  <div class="text-center"><a class="btn" href="javascript:void(0)" id="feedback">{{ $t['result_cta'] }}</a></div>
</div>

<style type="text/css">
  .main-h2.bordeless {
    margin-bottom: 5px;
  }
  .main-h2.bordeless::after {
    display:none;
  }
  .gallery-item.services__item::before {
    display:none;
  }
  .container-slider {
    padding: 0;
    width: 100%;
    margin: 0 auto;
    display: flex;
    justify-content: center;
  }
  .square-gallery {
    --items: 3;
    --width: 60vw;
    display: grid;
    grid-template-columns: repeat(var(--items), 1fr);
    background: white;
    width: var(--width);
    margin: 0 auto;
  }
  .gallery-item {
    display: flex;
    justify-content: center;
    width: calc(var(--width) / var(--items));
    padding-bottom: calc(var(--width) / var(--items));
    background-color: #ccc;
    background-position: center center;
    background-size: cover;
    background-repeat: no-repeat;
    opacity: 1;
    margin-right: 20px;
    margin-bottom: 20px;
  }
  .gallery-item:hover {
    opacity: 0.7;
  }
  @media only screen and (max-width: 1047px) {
    .container-slider {
      width: calc(70% + 0px);
    }
    .square-gallery {
      --items: 1;
      --width: 70vw;
    }
  }
</style>

<div class="container">
  <section class="steps">
    <h2 class="main-h2">{{ $t['steps_title'] }}</h2>
    <ul class="steps__list">
      <center>
        @foreach ($t['steps'] as $step)
        <li class="steps__item"><p>{!! $step !!}</p></li>
        @endforeach
      </center>
    </ul>
  </section>
</div>

<section class="jurisdiction">
  <div class="container">
    <h2 class="main-h2">{{ $t['team_title'] }}</h2>
    <div class="jurisdiction__wrapp">
      <a href="" class="jurisdiction__item jurisdiction__item--newZealand">
        <h3 class="jurisdiction__title">{{ $agent['name'] }}</h3>
        <h2 class="jurisdiction__price">{{ $t['result_agent_title'] }}</h2>
        <ul class="jurisdiction__item-list">
          <li>{{ $agent['email'] }}</li>
          <li>tel. {{ $agent['phone'] }}</li>
        </ul>
      </a>
    </div>
  </div>
</section>

@endsection

@section('footer_class', '')
