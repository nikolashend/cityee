{{-- Home page — intent-hub for all locales --}}
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
    $heroTitles = [
        'et' => 'Müüge või üürige kinnisvara Tallinn & Harjumaa piirkonnas',
        'ru' => 'Продайте или сдайте недвижимость в Tallinn & Harjumaa',
        'en' => 'Sell or Rent Property in Tallinn & Harjumaa',
    ];
    $heroSubs = [
        'et' => 'Süsteemselt, turvaliselt ja reaalse turuhinnaga.',
        'ru' => 'Системно, безопасно и по реальной рыночной цене.',
        'en' => 'Strategically, safely and at real market price.',
    ];
    $heroProcess = [
        'et' => 'Audit → Strateegia → Läbirääkimised → Tehing',
        'ru' => 'Аудит → Стратегия → Переговоры → Сделка',
        'en' => 'Audit → Strategy → Negotiation → Deal',
    ];
    $intentBtns = [
        'et' => [
            ['label' => 'Arvuta turuhind', 'class' => 'intent-btn--primary', 'href' => '#feedback', 'id' => 'feedback'],
            ['label' => 'Telli kuulutuse audit', 'class' => 'intent-btn--secondary', 'href' => route("{$locale}.audit")],
            ['label' => 'Anna üürile turvaliselt', 'class' => 'intent-btn--accent', 'href' => route("{$locale}.rent")],
        ],
        'ru' => [
            ['label' => 'Рассчитать рыночную цену', 'class' => 'intent-btn--primary', 'href' => '#feedback', 'id' => 'feedback'],
            ['label' => 'Заказать аудит объявления', 'class' => 'intent-btn--secondary', 'href' => route("{$locale}.audit")],
            ['label' => 'Сдать в аренду безопасно', 'class' => 'intent-btn--accent', 'href' => route("{$locale}.rent")],
        ],
        'en' => [
            ['label' => 'Calculate Market Value', 'class' => 'intent-btn--primary', 'href' => '#feedback', 'id' => 'feedback'],
            ['label' => 'Get Property Audit', 'class' => 'intent-btn--secondary', 'href' => route("{$locale}.audit")],
            ['label' => 'Rent Out Safely', 'class' => 'intent-btn--accent', 'href' => route("{$locale}.rent")],
        ],
    ];
    $trustLines = [
        'et' => ['10+ aastat turul', '300+ tehingut', 'Eksklusiivne strateegia'],
        'ru' => ['10+ лет на рынке', '300+ сделок', 'Эксклюзивная стратегия'],
        'en' => ['10+ years on market', '300+ deals', 'Exclusive strategy'],
    ];
@endphp

@push('jsonld')
<script type="application/ld+json">{!! json_encode(\App\Support\Schema::orgJsonLd(), JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT) !!}</script>
<script type="application/ld+json">{!! json_encode(\App\Support\Schema::personJsonLd(), JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT) !!}</script>
{!! \App\Support\Schema::speakable(\App\Support\SeoLinks::canonical('home')) !!}
{!! \App\Support\JsonLd::breadcrumbs([
    ['name' => $t['h1'] ?? 'Home', 'url' => \App\Support\SeoLinks::canonical('home')],
]) !!}
@endpush

@section('content')

{{-- ═══ HERO — Intent Filter ═══ --}}
<div class="banners">
  <ul class="banners__list">
    <li class="banners__item">
      <div class="container">
        <div class="banners__wrapp">
          <h1 class="banners__title">{{ $heroTitles[$locale] ?? $heroTitles['en'] }}</h1>
          <p class="banners__text">{{ $heroSubs[$locale] ?? $heroSubs['en'] }}<br>
            <small style="font-size:15px;opacity:0.85;">{{ $heroProcess[$locale] ?? $heroProcess['en'] }}</small>
          </p>

          {{-- Intent Buttons --}}
          <div class="intent-buttons">
            @foreach (($intentBtns[$locale] ?? $intentBtns['en']) as $btn)
              <a href="{{ $btn['href'] }}" class="intent-btn {{ $btn['class'] }}" @if(!empty($btn['id'])) id="{{ $btn['id'] }}" @endif>
                {{ $btn['label'] }}
              </a>
            @endforeach
          </div>

          {{-- Trust Line --}}
          <div class="hero-trust-line">
            @foreach (($trustLines[$locale] ?? $trustLines['en']) as $i => $line)
              @if ($i > 0)<div class="hero-trust-line__divider"></div>@endif
              <div class="hero-trust-line__item">{{ $line }}</div>
            @endforeach
          </div>
          <div class="risk-reversal" style="margin-top:12px;">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z"/></svg>
            <span>{{ $locale === 'et' ? 'Ilma ettemaksuta. Komisjon ainult tehingu korral.' : ($locale === 'ru' ? 'Без аванса. Комиссия только по факту сделки.' : 'No advance payment. Commission only on successful deal.') }}</span>
          </div>
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

{{-- ═══ TRUST LAYER ═══ --}}
@include('partials.trust-layer', ['locale' => $locale])

{{-- ═══ PROBLEM → SOLUTION ═══ --}}
@include('partials.problem-solution', ['locale' => $locale])

{{-- ═══ AI SUMMARY ═══ --}}
<div class="container">
  @include('partials.ai-summary', ['locale' => $locale])
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
  <div class="text-center" style="margin-bottom: 7px;"><img src="{{ $agent['photo'] }}" width="240" height="320" alt="{{ $agent['name'] }} — Real Estate Deal Optimization Partner in Tallinn & Harjumaa" loading="lazy" /></div>
  <div class="text-center">
    <div style="color:#7b1f45; font-weight: bold;">{{ $agent['name'] }}</div>
    <div style="color: #777777; margin-bottom: 15px">{{ $t['result_agent_title'] }} | CITYEE Tallinn</div>
    <div style="color:#7b1f45;">{{ $agent['phone'] }}</div>
    <div style="color:#7b1f45; margin-bottom: 15px;">{{ $agent['email'] }}</div>
  </div>
  <div class="text-center"><a class="btn" href="javascript:void(0)" id="feedback">{{ $t['result_cta'] }}</a></div>
  <div class="risk-reversal" style="margin-top:12px;margin-bottom:20px;">
    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="16" height="16"><path fill="#25D366" d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z"/></svg>
    <span>{{ $locale === 'et' ? 'Ilma ettemaksuta. Komisjon ainult tehingu korral.' : ($locale === 'ru' ? 'Без аванса. Комиссия только по факту сделки.' : 'No advance payment. Commission only on successful deal.') }}</span>
  </div>
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

{{-- ═══ PRICING STRATEGY — AI/SGE Content Block ═══ --}}
<div class="container">
  <section class="faq-section" style="background:transparent;padding:30px 0;">
    <h2 class="main-h2">{{ $locale === 'et' ? 'Kuidas me määrame hinna?' : ($locale === 'ru' ? 'Как мы определяем цену?' : 'How do we determine the price?') }}</h2>
    <div class="faq-list">
      @php
        $pricingFaq = [
          'et' => [
            ['q' => 'Tehingute analüüs', 'a' => 'Uurime piirkonna viimaste kuude tegelikke müügihindu — mitte pakkumishindu, vaid reaalseid tehinguhindu.'],
            ['q' => 'Ostjate käitumine', 'a' => 'Analüüsime, kui palju ostjaid otsib Teie piirkonnas ja millised on nende eelarved ning ootused.'],
            ['q' => 'Läbirääkimisstrateegia', 'a' => 'Kujundame hinnastrateegia nii, et jätame ruumi läbirääkimisteks, kaotamata tegelikku väärtust.'],
            ['q' => 'Müügi tõenäosuse prognoos', 'a' => 'Hindame, milline on müügi tõenäosus 1-3 kuu jooksul antud hinnaga ja turutingimustes.'],
          ],
          'ru' => [
            ['q' => 'Анализ сделок', 'a' => 'Изучаем реальные цены продаж в районе за последние месяцы — не цены объявлений, а реальные цены сделок.'],
            ['q' => 'Поведение покупателей', 'a' => 'Анализируем сколько покупателей ищет в вашем районе, их бюджеты и ожидания.'],
            ['q' => 'Переговорная стратегия', 'a' => 'Формируем ценовую стратегию так, чтобы оставить пространство для переговоров, не теряя реальную стоимость.'],
            ['q' => 'Прогноз вероятности продажи', 'a' => 'Оцениваем вероятность продажи в течение 1-3 месяцев по данной цене в текущих рыночных условиях.'],
          ],
          'en' => [
            ['q' => 'Transaction analysis', 'a' => 'We study actual selling prices in the area for recent months — not listing prices, but real transaction prices.'],
            ['q' => 'Buyer behavior analysis', 'a' => 'We analyze how many buyers are searching in your area, their budgets and expectations.'],
            ['q' => 'Negotiation strategy', 'a' => 'We shape the pricing strategy to leave room for negotiation without losing actual value.'],
            ['q' => 'Sale probability forecast', 'a' => 'We assess the probability of selling within 1-3 months at the given price in current market conditions.'],
          ],
        ];
      @endphp
      @foreach (($pricingFaq[$locale] ?? $pricingFaq['en']) as $item)
        <div class="faq-item">
          <div class="faq-question" role="button" tabindex="0" aria-expanded="false" onclick="this.parentElement.classList.toggle('active');this.setAttribute('aria-expanded',this.parentElement.classList.contains('active'))">
            <h3 style="font-size:inherit;margin:0;font-weight:inherit;">{{ $item['q'] }}</h3>
          </div>
          <div class="faq-answer">
            <p>{{ $item['a'] }}</p>
          </div>
        </div>
      @endforeach
    </div>
  </section>
</div>

{{-- AI Citation --}}
<div class="container">
  @include('partials.ai-citation', ['locale' => $locale])
</div>

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
