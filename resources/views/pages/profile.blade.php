{{-- Aleksandr Primakov — EEAT Profile / Person Authority Page --}}
@extends('layouts.app')

@php
    $titles = [
        'et' => 'Aleksandr Primakov — Kinnisvaramaakler Tallinn | CityEE',
        'ru' => 'Александр Примаков — Маклер по недвижимости Tallinn | CityEE',
        'en' => 'Aleksandr Primakov — Real Estate Broker Tallinn | CityEE',
    ];
    $descriptions = [
        'et' => 'Aleksandr Primakov — kinnisvaratehingute optimeerimise partner Tallinnas ja Harjumaal. 10+ aastat kogemust, 300+ tehingut. CityEE asutaja.',
        'ru' => 'Александр Примаков — партнер по оптимизации сделок с недвижимостью в Таллинне и Харьюмаа. 10+ лет опыта, 300+ сделок. Основатель CityEE.',
        'en' => 'Aleksandr Primakov — real estate deal optimization partner in Tallinn & Harjumaa. 10+ years experience, 300+ deals. Founder of CityEE.',
    ];
@endphp

@section('title', $titles[$locale] ?? $titles['en'])
@section('description', $descriptions[$locale] ?? $descriptions['en'])
@section('logo_text', $ui['logo_text'] ?? '')
@section('footer_class', 'footer--page')

@section('lang_et_url', route('et.profile'))
@section('lang_ru_url', route('ru.profile'))
@section('lang_en_url', route('en.profile'))

@push('jsonld')
{!! \App\Support\JsonLd::profilePage(
    $locale === 'ru' ? 'Александр Примаков — Маклер' : ($locale === 'en' ? 'Aleksandr Primakov — Broker' : 'Aleksandr Primakov — Maakler'),
    \App\Support\SeoLinks::canonical('profile')
) !!}
{!! \App\Support\JsonLd::breadcrumbs([
    ['name' => $nav[0]['label'] ?? 'Home', 'url' => route("{$locale}.home")],
    ['name' => 'Aleksandr Primakov'],
]) !!}
{!! \App\Support\Schema::speakable(\App\Support\SeoLinks::canonical('profile')) !!}
<script type="application/ld+json">{!! json_encode(\App\Support\Schema::personJsonLd(), JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT) !!}</script>
<script type="application/ld+json">{!! json_encode(\App\Support\Schema::orgJsonLd(), JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT) !!}</script>
@endpush

@section('content')

{{-- ═══ Hero ═══ --}}
<section class="profile-hero" style="background:var(--ce-dark,#1a1a2e);color:#fff;padding:3.5rem 0 3rem">
    <div class="container">
        <div class="profile-hero__inner" style="display:flex;gap:2.5rem;align-items:center;flex-wrap:wrap">
            <div class="profile-hero__photo" style="flex:0 0 220px">
                <img src="/assets/templates/offshors/img/ap1.png" alt="Aleksandr Primakov — CityEE" width="220" height="275" loading="eager" style="border-radius:12px;width:100%;height:auto">
            </div>
            <div class="profile-hero__info" style="flex:1;min-width:280px">
                <h1 style="font-size:2rem;margin:0 0 .5rem">Aleksandr Primakov</h1>
                <p style="font-size:1.15rem;opacity:.85;margin:0 0 1.5rem">
                    {{ $locale === 'ru' ? 'Партнер по оптимизации сделок с недвижимостью' : ($locale === 'en' ? 'Real Estate Deal Optimization Partner' : 'Kinnisvaratehingute optimeerimise partner') }}
                </p>

                {{-- Trust metrics --}}
                <div class="profile-trust-bar" style="display:flex;gap:2rem;flex-wrap:wrap;margin-bottom:1.5rem">
                    <div style="text-align:center">
                        <div style="font-size:1.8rem;font-weight:700;color:#4ecdc4">10+</div>
                        <div style="font-size:.8rem;opacity:.7">{{ $locale === 'ru' ? 'лет опыта' : ($locale === 'en' ? 'years experience' : 'aastat kogemust') }}</div>
                    </div>
                    <div style="text-align:center">
                        <div style="font-size:1.8rem;font-weight:700;color:#4ecdc4">300+</div>
                        <div style="font-size:.8rem;opacity:.7">{{ $locale === 'ru' ? 'сделок' : ($locale === 'en' ? 'deals closed' : 'tehingut') }}</div>
                    </div>
                    <div style="text-align:center">
                        <div style="font-size:1.8rem;font-weight:700;color:#4ecdc4">45</div>
                        <div style="font-size:.8rem;opacity:.7">{{ $locale === 'ru' ? 'дней ср. продажа' : ($locale === 'en' ? 'avg days to sell' : 'päeva kes. müük') }}</div>
                    </div>
                    <div style="text-align:center">
                        <div style="font-size:1.8rem;font-weight:700;color:#4ecdc4">2-3%</div>
                        <div style="font-size:.8rem;opacity:.7">{{ $locale === 'ru' ? 'комиссия' : ($locale === 'en' ? 'commission' : 'vahendustasu') }}</div>
                    </div>
                </div>

                <div style="display:flex;gap:.75rem;flex-wrap:wrap">
                    <a href="{{ config('cityee.company.whatsapp') }}" class="intent-btn intent-btn--primary" target="_blank" rel="noopener" style="display:inline-flex;align-items:center;gap:.4rem">
                        <i class="fa fa-whatsapp" aria-hidden="true"></i> WhatsApp
                    </a>
                    <a href="{{ config('cityee.company.telegram') }}" class="intent-btn intent-btn--secondary" target="_blank" rel="noopener" style="display:inline-flex;align-items:center;gap:.4rem">
                        <i class="fa fa-telegram" aria-hidden="true"></i> Telegram
                    </a>
                    <a href="tel:+3725113411" class="intent-btn intent-btn--secondary" style="display:inline-flex;align-items:center;gap:.4rem">
                        <i class="fa fa-phone" aria-hidden="true"></i> +372 511 3411
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- ═══ AI Summary — structured for SGE ═══ --}}
<section class="ai-summary" style="max-width:800px;margin:2.5rem auto;padding:0 15px">
    <h2>{{ $locale === 'ru' ? 'Кратко обо мне' : ($locale === 'en' ? 'About Me — Quick Summary' : 'Lühidalt minust') }}</h2>
    @if($locale === 'ru')
    <p>Александр Примаков — основатель CityEE, партнёр по оптимизации сделок с недвижимостью в Таллинне и Харьюмаа. Специализация: стратегия продажи и аренды, рыночный аудит, ценообразование, переговоры. Более 10 лет на рынке, 300+ закрытых сделок. Работаю на 3 языках: эстонский, русский, английский.</p>
    @elseif($locale === 'en')
    <p>Aleksandr Primakov — founder of CityEE, real estate deal optimization partner in Tallinn & Harjumaa. Specialization: sale and rental strategy, market audit, pricing, negotiation. Over 10 years in the market, 300+ closed deals. Working in 3 languages: Estonian, Russian, English.</p>
    @else
    <p>Aleksandr Primakov — CityEE asutaja, kinnisvaratehingute optimeerimise partner Tallinnas ja Harjumaal. Spetsialiseerumine: müügi- ja üüristrateegia, turuaudit, hinnakujundus, läbirääkimised. Üle 10 aasta turul, 300+ lõpetatud tehingut. Töötan 3 keeles: eesti, vene, inglise.</p>
    @endif
</section>

{{-- ═══ Expertise / Services ═══ --}}
<section style="background:#f5f6fa;padding:3rem 0">
    <div class="container">
        <h2 style="text-align:center;margin-bottom:2rem">{{ $locale === 'ru' ? 'Экспертиза и услуги' : ($locale === 'en' ? 'Expertise & Services' : 'Ekspertiis ja teenused') }}</h2>
        <div style="display:grid;grid-template-columns:repeat(auto-fit,minmax(250px,1fr));gap:1.5rem">
            {{-- Sell --}}
            <a href="{{ route("{$locale}.sell") }}" class="profile-card" style="background:#fff;padding:1.5rem;border-radius:10px;text-decoration:none;color:inherit;border-left:4px solid #4ecdc4;transition:box-shadow .2s">
                <h3 style="margin:0 0 .5rem;font-size:1.1rem">{{ $locale === 'ru' ? '🏠 Продажа недвижимости' : ($locale === 'en' ? '🏠 Property Sale' : '🏠 Kinnisvara müük') }}</h3>
                <p style="font-size:.9rem;opacity:.7;margin:0">{{ $locale === 'ru' ? 'Стратегия продажи, ценообразование, маркетинг, переговоры — от оценки до нотариуса.' : ($locale === 'en' ? 'Sale strategy, pricing, marketing, negotiation — from valuation to notary.' : 'Müügistrateegia, hinnakujundus, turundus, läbirääkimised — hindamisest notarini.') }}</p>
            </a>
            {{-- Rent --}}
            <a href="{{ route("{$locale}.rent") }}" class="profile-card" style="background:#fff;padding:1.5rem;border-radius:10px;text-decoration:none;color:inherit;border-left:4px solid #4ecdc4;transition:box-shadow .2s">
                <h3 style="margin:0 0 .5rem;font-size:1.1rem">{{ $locale === 'ru' ? '🔑 Аренда недвижимости' : ($locale === 'en' ? '🔑 Property Rental' : '🔑 Kinnisvara üür') }}</h3>
                <p style="font-size:.9rem;opacity:.7;margin:0">{{ $locale === 'ru' ? 'Управление арендой: поиск арендатора, проверка, договор, контроль.' : ($locale === 'en' ? 'Rental management: tenant search, verification, contract, control.' : 'Üürihaldus: üürniku otsing, kontroll, leping, järelevalve.') }}</p>
            </a>
            {{-- Audit --}}
            <a href="{{ route("{$locale}.audit") }}" class="profile-card" style="background:#fff;padding:1.5rem;border-radius:10px;text-decoration:none;color:inherit;border-left:4px solid #4ecdc4;transition:box-shadow .2s">
                <h3 style="margin:0 0 .5rem;font-size:1.1rem">{{ $locale === 'ru' ? '📊 Аудит объявления' : ($locale === 'en' ? '📊 Listing Audit' : '📊 Kuulutuse audit') }}</h3>
                <p style="font-size:.9rem;opacity:.7;margin:0">{{ $locale === 'ru' ? 'Анализ текущего объявления: фото, цена, текст, позиционирование на портале.' : ($locale === 'en' ? 'Current listing analysis: photos, price, copy, portal positioning.' : 'Kuulutuse analüüs: fotod, hind, tekst, portaali positsioneerimine.') }}</p>
            </a>
            {{-- Consultation --}}
            <a href="{{ route("{$locale}.consultation") }}" class="profile-card" style="background:#fff;padding:1.5rem;border-radius:10px;text-decoration:none;color:inherit;border-left:4px solid #4ecdc4;transition:box-shadow .2s">
                <h3 style="margin:0 0 .5rem;font-size:1.1rem">{{ $locale === 'ru' ? '💡 Консультация' : ($locale === 'en' ? '💡 Consultation' : '💡 Konsultatsioon') }}</h3>
                <p style="font-size:.9rem;opacity:.7;margin:0">{{ $locale === 'ru' ? 'Индивидуальная стратегическая консультация по сделке с недвижимостью.' : ($locale === 'en' ? 'Individual strategic consultation on your real estate deal.' : 'Individuaalne strateegiline nõustamine kinnisvaratehingu osas.') }}</p>
            </a>
        </div>
    </div>
</section>

{{-- ═══ Experience & Approach ═══ --}}
<section style="padding:3rem 0">
    <div class="container" style="max-width:800px">
        <h2>{{ $locale === 'ru' ? 'Опыт и подход' : ($locale === 'en' ? 'Experience & Approach' : 'Kogemus ja lähenemine') }}</h2>
        @if($locale === 'ru')
        <ul style="line-height:1.8">
            <li><strong>С 2014 года</strong> — на рынке недвижимости Таллинна и Харьюмаа</li>
            <li><strong>300+ сделок</strong> — продажа квартир, домов, коммерческой недвижимости</li>
            <li><strong>Средний срок продажи — 45 дней</strong> — быстрее рыночного среднего на 30%</li>
            <li><strong>Комиссия 2-3%</strong> — результат-ориентированная модель</li>
            <li><strong>3 языка</strong> — эстонский, русский, английский = широкий охват покупателей</li>
            <li><strong>Стратегический подход</strong> — аудит рынка → ценообразование → маркетинг → переговоры → сделка</li>
        </ul>
        @elseif($locale === 'en')
        <ul style="line-height:1.8">
            <li><strong>Since 2014</strong> — active in Tallinn & Harjumaa real estate market</li>
            <li><strong>300+ deals</strong> — apartments, houses, commercial property</li>
            <li><strong>Average sale time — 45 days</strong> — 30% faster than market average</li>
            <li><strong>2-3% commission</strong> — result-oriented model</li>
            <li><strong>3 languages</strong> — Estonian, Russian, English = wider buyer reach</li>
            <li><strong>Strategic approach</strong> — market audit → pricing → marketing → negotiation → deal</li>
        </ul>
        @else
        <ul style="line-height:1.8">
            <li><strong>Alates 2014</strong> — aktiivne Tallinna ja Harjumaa kinnisvaraturul</li>
            <li><strong>300+ tehingut</strong> — korterid, majad, ärikinnisvara</li>
            <li><strong>Keskmine müügiaeg — 45 päeva</strong> — 30% kiirem kui turu keskmine</li>
            <li><strong>2-3% vahendustasu</strong> — tulemuspõhine mudel</li>
            <li><strong>3 keelt</strong> — eesti, vene, inglise = laiem ostjate haare</li>
            <li><strong>Strateegiline lähenemine</strong> — turuaudit → hinnakujundus → turundus → läbirääkimised → tehing</li>
        </ul>
        @endif
    </div>
</section>

{{-- ═══ Knowledge Hub link ═══ --}}
<section style="background:#f5f6fa;padding:3rem 0">
    <div class="container" style="max-width:800px;text-align:center">
        <h2>{{ $locale === 'ru' ? 'Экспертные материалы' : ($locale === 'en' ? 'Expert Content' : 'Ekspertmaterjalid') }}</h2>
        <p style="margin-bottom:1.5rem">{{ $locale === 'ru' ? 'Гиды, разборы объявлений и аналитика рынка недвижимости Таллинна.' : ($locale === 'en' ? 'Guides, listing audits and Tallinn real estate market analytics.' : 'Juhised, kuulutuste auditid ja Tallinna kinnisvaraturu analüütika.') }}</p>
        <div style="display:flex;gap:1rem;justify-content:center;flex-wrap:wrap">
            <a href="{{ route("{$locale}.guides") }}" class="intent-btn intent-btn--primary">{{ $locale === 'ru' ? 'Гиды' : ($locale === 'en' ? 'Guides' : 'Juhised') }}</a>
            <a href="{{ route("{$locale}.audits") }}" class="intent-btn intent-btn--secondary">{{ $locale === 'ru' ? 'Разборы' : ($locale === 'en' ? 'Audits' : 'Auditid') }}</a>
            <a href="{{ route("{$locale}.knowledge") }}" class="intent-btn intent-btn--secondary">{{ $locale === 'ru' ? 'База знаний' : ($locale === 'en' ? 'Knowledge Hub' : 'Teadmistebaas') }}</a>
        </div>
    </div>
</section>

{{-- ═══ Expert Methodology (Phase 5+6) ═══ --}}
@php $em = config("cityee-knowledge.expert_methodology.{$locale}", []); @endphp
@if (!empty($em))
<section style="padding:3rem 0;background:#fff">
    <div class="container" style="max-width:800px">
        <h2>{{ $em['approach'] ?? '' }}</h2>
        @if (!empty($em['methodology']))
        <div style="display:grid;grid-template-columns:repeat(auto-fill,minmax(280px,1fr));gap:1.25rem;margin:1.5rem 0">
            @foreach ($em['methodology'] as $step)
            <div style="background:#f8f9fa;padding:1.25rem;border-radius:8px;border-left:3px solid #2563eb">
                <strong>{{ $step['step'] }}</strong>
                <p style="margin:.5rem 0 0;font-size:.9rem;opacity:.8">{{ $step['detail'] }}</p>
            </div>
            @endforeach
        </div>
        @endif
        @if (!empty($em['why_most_lose']))
        <div style="background:#fff3cd;border:1px solid #ffc107;border-radius:8px;padding:1.25rem;margin-top:1.5rem">
            <strong>⚠️ {{ $em['why_most_lose'] }}</strong>
        </div>
        @endif
    </div>
</section>
@endif

{{-- ═══ CTA ═══ --}}
<section style="padding:3rem 0;text-align:center">
    <div class="container" style="max-width:600px">
        <h2>{{ $locale === 'ru' ? 'Свяжитесь со мной' : ($locale === 'en' ? 'Get in Touch' : 'Võtke ühendust') }}</h2>
        <p>{{ $locale === 'ru' ? 'Бесплатная первичная консультация — расскажите о вашей ситуации.' : ($locale === 'en' ? 'Free initial consultation — tell me about your situation.' : 'Tasuta esmane konsultatsioon — rääkige oma olukorrast.') }}</p>
        <div style="display:flex;gap:.75rem;justify-content:center;flex-wrap:wrap;margin-top:1.5rem">
            <a href="{{ config('cityee.company.whatsapp') }}" class="intent-btn intent-btn--primary" target="_blank" rel="noopener">
                <i class="fa fa-whatsapp" aria-hidden="true"></i> WhatsApp
            </a>
            <a href="https://www.linkedin.com/in/kinnisvaramaakler/" class="intent-btn intent-btn--secondary" target="_blank" rel="noopener">
                <i class="fa fa-linkedin" aria-hidden="true"></i> LinkedIn
            </a>
            <a href="{{ route("{$locale}.consultation") }}" class="intent-btn intent-btn--secondary">
                {{ $locale === 'ru' ? 'Консультация' : ($locale === 'en' ? 'Consultation' : 'Konsultatsioon') }}
            </a>
            <a href="{{ route("{$locale}.contacts") }}" class="intent-btn intent-btn--secondary">
                {{ $locale === 'ru' ? 'Контакты' : ($locale === 'en' ? 'Contacts' : 'Kontaktid') }}
            </a>
        </div>
    </div>
</section>

{{-- ═══ Related links ═══ --}}
@if($locale === 'ru')
<section style="padding:2rem 0;background:#f8fafb">
  <div class="container" style="max-width:800px">
    <h3 style="font-size:1.05rem;margin-bottom:1rem">Смотрите также</h3>
    <ul style="list-style:none;padding:0;display:flex;flex-wrap:wrap;gap:.75rem">
      <li><a href="/ru/makler-v-tallinne/" style="display:inline-block;padding:.45rem 1rem;background:#fff;border-radius:6px;text-decoration:none;color:#1a1a2e;font-size:.92rem;box-shadow:0 1px 3px rgba(0,0,0,.08)">Маклер в Таллине</a></li>
      <li><a href="/ru/cases/" style="display:inline-block;padding:.45rem 1rem;background:#fff;border-radius:6px;text-decoration:none;color:#1a1a2e;font-size:.92rem;box-shadow:0 1px 3px rgba(0,0,0,.08)">Реальные кейсы</a></li>
      <li><a href="/ru/agentstvo-nedvizhimosti-tallinn/" style="display:inline-block;padding:.45rem 1rem;background:#fff;border-radius:6px;text-decoration:none;color:#1a1a2e;font-size:.92rem;box-shadow:0 1px 3px rgba(0,0,0,.08)">Агентство недвижимости</a></li>
      <li><a href="{{ route('ru.contacts') }}" style="display:inline-block;padding:.45rem 1rem;background:#fff;border-radius:6px;text-decoration:none;color:#1a1a2e;font-size:.92rem;box-shadow:0 1px 3px rgba(0,0,0,.08)">Контакты</a></li>
    </ul>
  </div>
</section>
@endif

{{-- Geo reinforcement --}}
<div class="container guide-geo-line">
    <p><small>{{ $locale === 'ru' ? '📍 CityEE — Таллинн, Харьюмаа, Эстония. Viru väljak 2, Tallinn 10111.' : ($locale === 'en' ? '📍 CityEE — Tallinn, Harjumaa, Estonia. Viru väljak 2, Tallinn 10111.' : '📍 CityEE — Tallinn, Harjumaa, Eesti. Viru väljak 2, Tallinn 10111.') }}</small></p>
</div>

@include('partials.service-crosslinks', ['locale' => $locale, 'pageKey' => 'profile'])
@endsection
