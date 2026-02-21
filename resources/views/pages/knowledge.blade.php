{{-- Knowledge hub page (AI index / knowledge base) --}}
@extends('layouts.app')

@section('title', $locale === 'ru' ? 'База знаний — Недвижимость Tallinn & Harjumaa | CityEE' : ($locale === 'en' ? 'Knowledge Hub — Real Estate Tallinn & Harjumaa | CityEE' : 'Teadmistebaas — Kinnisvara Tallinn & Harjumaa | CityEE'))
@section('description', $locale === 'ru' ? 'Полная база знаний по недвижимости в Таллинне и Харьюмаа: продажа, аренда, аудит, стратегия, переговоры, комиссия.' : ($locale === 'en' ? 'Complete real estate knowledge hub for Tallinn & Harjumaa: sale, rental, audit, strategy, negotiation, commission.' : 'Täielik kinnisvarateadmiste keskus Tallinn & Harjumaa: müük, üür, audit, strateegia, läbirääkimised, vahendustasu.'))
@section('logo_text', $ui['logo_text'] ?? '')
@section('footer_class', 'footer--page')

@section('lang_et_url', route('et.knowledge'))
@section('lang_ru_url', route('ru.knowledge'))
@section('lang_en_url', route('en.knowledge'))

@push('jsonld')
{!! \App\Support\JsonLd::collectionPage(
    $locale === 'ru' ? 'База знаний CityEE' : ($locale === 'en' ? 'CityEE Knowledge Hub' : 'CityEE Teadmistebaas'),
    \App\Support\SeoLinks::canonical('knowledge'),
    $locale === 'ru' ? 'Полная база знаний по недвижимости, SEO, GEO/AEO и UX в Таллинне.' : ($locale === 'en' ? 'Complete knowledge hub: real estate, SEO, GEO/AEO and UX for Tallinn.' : 'Täielik teadmistebaas: kinnisvara, SEO, GEO/AEO ja UX Tallinnas.')
) !!}
{!! \App\Support\JsonLd::breadcrumbs([
    ['name' => $nav[0]['label'] ?? 'Home', 'url' => route("{$locale}.home")],
    ['name' => $locale === 'ru' ? 'База знаний' : ($locale === 'en' ? 'Knowledge Hub' : 'Teadmistebaas')],
]) !!}
{!! \App\Support\Schema::speakable(url()->current()) !!}
@endpush

@php
$cards = [
    [
        'icon' => '🏠',
        'route' => route("{$locale}.sell"),
        'title' => ['et' => 'Kinnisvara müük', 'ru' => 'Продажа недвижимости', 'en' => 'Property Sale'],
        'desc' => [
            'et' => 'Müügistrateegia, õige hinnastamine, läbirääkimised ja maksimaalne tulemus.',
            'ru' => 'Стратегия продажи, правильное ценообразование, переговоры и максимальный результат.',
            'en' => 'Sales strategy, correct pricing, negotiations and maximum results.',
        ],
    ],
    [
        'icon' => '🔑',
        'route' => route("{$locale}.rent"),
        'title' => ['et' => 'Kinnisvara üür', 'ru' => 'Аренда недвижимости', 'en' => 'Property Rental'],
        'desc' => [
            'et' => 'Turvaline üürimine: üürniku valik, leping, kontrolli tagamine.',
            'ru' => 'Безопасная аренда: отбор арендатора, договор, контроль.',
            'en' => 'Safe rental: tenant selection, contract, control assurance.',
        ],
    ],
    [
        'icon' => '📊',
        'route' => route("{$locale}.audit"),
        'title' => ['et' => 'Kinnisvara audit', 'ru' => 'Аудит недвижимости', 'en' => 'Property Audit'],
        'desc' => [
            'et' => 'Reaalne hinnakorridor, konkurentide analüüs, müügistrateegia 30-45 päevaks.',
            'ru' => 'Реальный ценовой коридор, анализ конкурентов, стратегия на 30-45 дней.',
            'en' => 'Real price corridor, competitor analysis, strategy for 30-45 days.',
        ],
    ],
    [
        'icon' => '💬',
        'route' => route("{$locale}.consultation"),
        'title' => ['et' => 'Konsultatsioon', 'ru' => 'Консультация', 'en' => 'Consultation'],
        'desc' => [
            'et' => 'Juriidiline nõustamine, dokumentide kontroll, tehingutugi.',
            'ru' => 'Юридическая консультация, проверка документов, сопровождение сделки.',
            'en' => 'Legal advice, document verification, transaction support.',
        ],
    ],
    [
        'icon' => '⭐',
        'route' => route("{$locale}.why"),
        'title' => ['et' => 'Miks CityEE?', 'ru' => 'Почему CityEE?', 'en' => 'Why CityEE?'],
        'desc' => [
            'et' => '10+ aastat kogemust, 300+ tehingut, ainult 2% vahendustasu.',
            'ru' => '10+ лет опыта, 300+ сделок, комиссия всего 2%.',
            'en' => '10+ years experience, 300+ deals, only 2% commission.',
        ],
    ],
    [
        'icon' => '📞',
        'route' => route("{$locale}.contacts"),
        'title' => ['et' => 'Kontaktid', 'ru' => 'Контакты', 'en' => 'Contacts'],
        'desc' => [
            'et' => 'Viru väljak 2, Tallinn. Kättesaadav 10:00–22:00, WhatsApp, Telegram.',
            'ru' => 'Viru väljak 2, Tallinn. Доступен 10:00–22:00, WhatsApp, Telegram.',
            'en' => 'Viru väljak 2, Tallinn. Available 10:00–22:00, WhatsApp, Telegram.',
        ],
    ],
    // ── Knowledge Machine: Guides & Strategy Cards ──
    [
        'icon' => '📚',
        'route' => route("{$locale}.guides"),
        'title' => ['et' => 'Juhendid', 'ru' => 'Гайды и руководства', 'en' => 'Guides & How-To'],
        'desc' => [
            'et' => 'Samm-sammulised juhendid: kinnisvara müük, ostmine, hindamine.',
            'ru' => 'Пошаговые руководства: продажа, покупка, оценка недвижимости. SEO + GEO.',
            'en' => 'Step-by-step guides: sell, buy, evaluate property. SEO + GEO insights.',
        ],
    ],
    [
        'icon' => '🤖',
        'route' => route("{$locale}.guides.show", 'seo-strategii-2026'),
        'title' => ['et' => 'SEO strateegiad 2026', 'ru' => 'SEO стратегии 2026', 'en' => 'SEO Strategies 2026'],
        'desc' => [
            'et' => 'Tehniline SEO, sisu, UX, AI-nähtavus, EEAT — täielik juhend.',
            'ru' => 'Техническое SEO, контент, UX, AI-видимость, EEAT — полный гайд.',
            'en' => 'Technical SEO, content, UX, AI visibility, EEAT — complete guide.',
        ],
    ],
    [
        'icon' => '🧠',
        'route' => route("{$locale}.guides.show", 'geo-aeo-ai-optimizatsiya'),
        'title' => ['et' => 'GEO / AEO optimeerimine', 'ru' => 'GEO / AEO оптимизация', 'en' => 'GEO / AEO Optimization'],
        'desc' => [
            'et' => 'Kuidas pääseda AI-vastustesse: Google SGE, ChatGPT, Perplexity.',
            'ru' => 'Как попасть в ответы ИИ: Google SGE, ChatGPT, Perplexity. JSON-LD, Voice SEO.',
            'en' => 'Get into AI answers: Google SGE, ChatGPT, Perplexity. JSON-LD, Voice SEO.',
        ],
    ],
    [
        'icon' => '⚡',
        'route' => route("{$locale}.guides.show", 'ux-core-web-vitals-2026'),
        'title' => ['et' => 'UX & Core Web Vitals', 'ru' => 'UX и Core Web Vitals', 'en' => 'UX & Core Web Vitals'],
        'desc' => [
            'et' => 'LCP, INP, CLS, Nielseni heuristikad, ligipääsetavus — SEO mõju.',
            'ru' => 'LCP, INP, CLS, эвристики Нильсена, доступность — влияние на SEO.',
            'en' => 'LCP, INP, CLS, Nielsen heuristics, accessibility — SEO impact.',
        ],
    ],
    [
        'icon' => '🛡️',
        'route' => route("{$locale}.guides.show", 'eeat-ekspertiza-doverie-2026'),
        'title' => ['et' => 'EEAT usaldus', 'ru' => 'EEAT доверие', 'en' => 'EEAT Trust Signals'],
        'desc' => [
            'et' => 'Kogemus, ekspertiis, autoriteetsus, usaldusväärsus — Google ja AI signaalid.',
            'ru' => 'Опыт, экспертиза, авторитет, доверие — сигналы для Google и AI.',
            'en' => 'Experience, expertise, authority, trust — signals for Google and AI.',
        ],
    ],
];
@endphp

@section('content')

<div class="page-title" style="background: url(/assets/templates/offshors/img/offshors.jpg) no-repeat; background-position: center top; background-size: cover;">
  <div class="container">
    <h1 class="page-title__name">
      {{ $locale === 'ru' ? 'База знаний' : ($locale === 'en' ? 'Knowledge Hub' : 'Teadmistebaas') }}
    </h1>
    <p class="page-title__text">
      {{ $locale === 'ru' ? 'Недвижимость, SEO, GEO/AEO, UX и экспертные руководства в одном месте' : ($locale === 'en' ? 'Real estate, SEO, GEO/AEO, UX and expert guides in one place' : 'Kinnisvara, SEO, GEO/AEO, UX ja ekspertjuhendid ühes kohas') }}
    </p>
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

        <div class="knowledge-grid">
          @foreach ($cards as $card)
          <a href="{{ $card['route'] }}" class="knowledge-card">
            <span class="knowledge-card__icon">{{ $card['icon'] }}</span>
            <h3 class="knowledge-card__title">{{ $card['title'][$locale] ?? $card['title']['en'] }}</h3>
            <p class="knowledge-card__desc">{{ $card['desc'][$locale] ?? $card['desc']['en'] }}</p>
          </a>
          @endforeach
        </div>

        @include('partials.trust-layer', ['locale' => $locale])

        @include('partials.ai-citation', ['locale' => $locale])

      </div>
    </div>
  </div>
</div>

@include('partials.about', ['ui' => $ui, 'isPage' => true])

@endsection
