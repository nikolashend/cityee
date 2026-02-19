{{-- Guides index page — ЭТАП 5: category filters + proper cards --}}
@extends('layouts.app')

@section('title', $locale === 'ru' ? 'Гиды по недвижимости Таллинн | CityEE' : ($locale === 'en' ? 'Real Estate Guides Tallinn | CityEE' : 'Kinnisvarajuhised Tallinn | CityEE'))
@section('description', $locale === 'ru' ? 'Экспертные гиды CityEE: продажа, покупка, аренда недвижимости в Таллинне и Харьюмаа. 10+ лет опыта, 300+ сделок.' : ($locale === 'en' ? 'CityEE expert guides: selling, buying, renting real estate in Tallinn & Harjumaa. 10+ years, 300+ deals.' : 'CityEE ekspertjuhised: kinnisvara müük, ost, üür Tallinnas ja Harjumaal. 10+ aastat, 300+ tehingut.'))
@section('logo_text', $ui['logo_text'] ?? '')
@section('footer_class', 'footer--page')

@section('lang_et_url', route('et.guides'))
@section('lang_ru_url', route('ru.guides'))
@section('lang_en_url', route('en.guides'))

@push('jsonld')
{!! \App\Support\JsonLd::webPage(
    $locale === 'ru' ? 'Гиды CityEE' : ($locale === 'en' ? 'CityEE Guides' : 'CityEE Juhised'),
    url()->current(),
    $locale === 'ru' ? 'Экспертные гиды по недвижимости.' : ($locale === 'en' ? 'Expert real estate guides.' : 'Ekspert kinnisvarajuhised.')
) !!}
{!! \App\Support\JsonLd::breadcrumbs([
    ['name' => $nav[0]['label'] ?? 'Home', 'url' => route("{$locale}.home")],
    ['name' => $locale === 'ru' ? 'Гиды' : ($locale === 'en' ? 'Guides' : 'Juhised')],
]) !!}
{!! \App\Support\Schema::speakable(url()->current()) !!}
@endpush

@section('content')
@php
    $categoryLabels = [
        'sell'      => $locale === 'ru' ? 'Продажа' : ($locale === 'en' ? 'Selling' : 'Müük'),
        'rent'      => $locale === 'ru' ? 'Аренда' : ($locale === 'en' ? 'Rental' : 'Üür'),
        'pricing'   => $locale === 'ru' ? 'Цены' : ($locale === 'en' ? 'Pricing' : 'Hinnad'),
        'legal'     => $locale === 'ru' ? 'Юридика' : ($locale === 'en' ? 'Legal' : 'Juriidika'),
        'marketing' => $locale === 'ru' ? 'Маркетинг' : ($locale === 'en' ? 'Marketing' : 'Turundus'),
    ];
@endphp

<section class="guide-hero guide-hero--index">
    <div class="container">
        <h1>{{ $locale === 'ru' ? 'Гиды по недвижимости' : ($locale === 'en' ? 'Real Estate Guides' : 'Kinnisvarajuhised') }}</h1>
        <p class="lead">{{ $locale === 'ru' ? 'Экспертные материалы от Александра Примакова — 10+ лет опыта, 300+ сделок в Таллинне и Харьюмаа' : ($locale === 'en' ? 'Expert materials from Aleksandr Primakov — 10+ years experience, 300+ deals in Tallinn & Harjumaa' : 'Ekspertmaterjalid Aleksandr Primakovilt — 10+ aastat kogemust, 300+ tehingut Tallinnas ja Harjumaal') }}</p>
    </div>
</section>

{{-- Category filter pills --}}
@if($categories->isNotEmpty())
<section class="guide-filters">
    <div class="container">
        <div class="guide-filter-pills">
            <a href="{{ route("{$locale}.guides") }}" class="guide-filter-pill {{ !$activeCategory ? 'active' : '' }}">
                {{ $locale === 'ru' ? 'Все' : ($locale === 'en' ? 'All' : 'Kõik') }}
            </a>
            @foreach($categories as $cat)
                <a href="{{ route("{$locale}.guides", ['category' => $cat]) }}" class="guide-filter-pill {{ $activeCategory === $cat ? 'active' : '' }}">
                    {{ $categoryLabels[$cat] ?? ucfirst($cat) }}
                </a>
            @endforeach
        </div>
    </div>
</section>
@endif

<section class="section-padding" itemscope itemtype="https://schema.org/CollectionPage">
    <div class="container">
        @if($guides->isEmpty())
            <div class="text-center py-5">
                <p class="text-muted">{{ $locale === 'ru' ? 'Гиды скоро появятся.' : ($locale === 'en' ? 'Guides coming soon.' : 'Juhised ilmuvad varsti.') }}</p>
            </div>
        @else
            <div class="row g-4">
                @foreach($guides as $guide)
                    <div class="col-md-6 col-lg-4">
                        <article class="knowledge-card" itemscope itemtype="https://schema.org/Article">
                            <a href="{{ route("{$locale}.guides.show", $guide->slug) }}" class="knowledge-card__link">
                                @if($guide->category)
                                    <span class="knowledge-card__cat">{{ $categoryLabels[$guide->category] ?? ucfirst($guide->category) }}</span>
                                @endif
                                <h2 class="knowledge-card__title" itemprop="headline">{{ $guide->title }}</h2>
                                @if($guide->excerpt)
                                    <p class="knowledge-card__desc" itemprop="description">{{ Str::limit($guide->excerpt, 140) }}</p>
                                @endif
                                <div class="knowledge-card__meta">
                                    <meta itemprop="author" content="Aleksandr Primakov" />
                                    <meta itemprop="datePublished" content="{{ $guide->published_at?->toDateString() }}" />
                                    @if($guide->reading_time_minutes)
                                        <span>{{ $guide->reading_time_minutes }} {{ $locale === 'ru' ? 'мин' : 'min' }}</span>
                                    @endif
                                </div>
                                <span class="knowledge-card__cta">{{ $locale === 'ru' ? 'Читать →' : ($locale === 'en' ? 'Read →' : 'Loe →') }}</span>
                            </a>
                        </article>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
</section>

{{-- CTA --}}
<section class="section-padding guide-cta-section">
    <div class="container text-center">
        <h2>{{ $locale === 'ru' ? 'Не нашли ответ?' : ($locale === 'en' ? 'Didn\'t find your answer?' : 'Ei leidnud vastust?') }}</h2>
        <p>{{ $locale === 'ru' ? 'Задайте вопрос напрямую — ответим за 30 минут.' : ($locale === 'en' ? 'Ask directly — we respond within 30 minutes.' : 'Küsige otse — vastame 30 minuti jooksul.') }}</p>
        <div class="guide-cta-buttons">
            <a href="https://wa.me/+37258829892" target="_blank" rel="noopener" class="intent-btn intent-btn--primary">
                <i class="fa fa-whatsapp"></i> WhatsApp
            </a>
            <a href="https://t.me/cityee_tallinn" target="_blank" rel="noopener" class="intent-btn intent-btn--accent">
                <i class="fa fa-telegram"></i> Telegram
            </a>
        </div>
    </div>
</section>
@endsection
