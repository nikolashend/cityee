{{-- Audits index page — ЭТАП 5: type filters + proper cards --}}
@extends('layouts.app')

@section('title', $locale === 'ru' ? 'Разборы объектов и аудиты | CityEE' : ($locale === 'en' ? 'Property Audits & Case Studies | CityEE' : 'Kinnisvara auditid ja analüüsid | CityEE'))
@section('description', $locale === 'ru' ? 'Реальные разборы объектов: аудит объявления на KV.ee, ценовой коридор, план продажи. 10+ лет опыта в Таллинне.' : ($locale === 'en' ? 'Real property case studies: KV.ee listing audit, price corridor, sales plan. 10+ years experience in Tallinn.' : 'Tegelikud kinnisvara analüüsid: KV.ee kuulutuse audit, hinnakoridor, müügiplaan. 10+ aastat kogemust Tallinnas.'))
@section('logo_text', $ui['logo_text'] ?? '')
@section('footer_class', 'footer--page')

@section('lang_et_url', route('et.audits'))
@section('lang_ru_url', route('ru.audits'))
@section('lang_en_url', route('en.audits'))

@push('jsonld')
{!! \App\Support\JsonLd::webPage(
    $locale === 'ru' ? 'Разборы CityEE' : ($locale === 'en' ? 'CityEE Audits' : 'CityEE Auditid'),
    url()->current(),
    $locale === 'ru' ? 'Реальные разборы объектов недвижимости.' : ($locale === 'en' ? 'Real property audit case studies.' : 'Tegelikud kinnisvara analüüsid.')
) !!}
{!! \App\Support\JsonLd::breadcrumbs([
    ['name' => $nav[0]['label'] ?? 'Home', 'url' => route("{$locale}.home")],
    ['name' => $locale === 'ru' ? 'Разборы' : ($locale === 'en' ? 'Audits' : 'Auditid')],
]) !!}
{!! \App\Support\Schema::speakable(url()->current()) !!}
@endpush

@section('content')
@php
    $typeLabels = [
        'listing_audit'  => $locale === 'ru' ? 'Аудит объявления' : ($locale === 'en' ? 'Listing Audit' : 'Kuulutuse audit'),
        'price_corridor' => $locale === 'ru' ? 'Ценовой коридор' : ($locale === 'en' ? 'Price Corridor' : 'Hinnakoridor'),
        'sales_plan'     => $locale === 'ru' ? 'План продажи' : ($locale === 'en' ? 'Sales Plan' : 'Müügiplaan'),
    ];
@endphp

<section class="guide-hero guide-hero--index audit-hero--index">
    <div class="container">
        <h1>{{ $locale === 'ru' ? 'Разборы объектов' : ($locale === 'en' ? 'Property Audits' : 'Kinnisvara auditid') }}</h1>
        <p class="lead">{{ $locale === 'ru' ? 'Реальные кейсы: аудит объявлений, ценовые коридоры, планы продажи — всё на основе данных Maa-amet и KV.ee' : ($locale === 'en' ? 'Real case studies: listing audits, price corridors, sales plans — all based on Maa-amet & KV.ee data' : 'Tegelikud juhtumid: kuulutuste auditid, hinnakoridorid, müügiplaanid — Maa-ameti ja KV.ee andmetel') }}</p>
    </div>
</section>

{{-- Type filter pills --}}
@if($auditTypes->isNotEmpty())
<section class="guide-filters">
    <div class="container">
        <div class="guide-filter-pills">
            <a href="{{ route("{$locale}.audits") }}" class="guide-filter-pill {{ !$activeType ? 'active' : '' }}">
                {{ $locale === 'ru' ? 'Все' : ($locale === 'en' ? 'All' : 'Kõik') }}
            </a>
            @foreach($auditTypes as $type)
                <a href="{{ route("{$locale}.audits", ['type' => $type]) }}" class="guide-filter-pill {{ $activeType === $type ? 'active' : '' }}">
                    {{ $typeLabels[$type] ?? ucfirst(str_replace('_', ' ', $type)) }}
                </a>
            @endforeach
        </div>
    </div>
</section>
@endif

<section class="section-padding" itemscope itemtype="https://schema.org/CollectionPage">
    <div class="container">
        @if($audits->isEmpty())
            <div class="text-center py-5">
                <p class="text-muted">{{ $locale === 'ru' ? 'Разборы скоро появятся.' : ($locale === 'en' ? 'Audits coming soon.' : 'Auditid ilmuvad varsti.') }}</p>
            </div>
        @else
            <div class="row g-4">
                @foreach($audits as $audit)
                    <div class="col-md-6 col-lg-4">
                        <article class="knowledge-card knowledge-card--audit" itemscope itemtype="https://schema.org/Article">
                            <a href="{{ route("{$locale}.audits.show", $audit->slug) }}" class="knowledge-card__link">
                                @if($audit->audit_type)
                                    <span class="knowledge-card__cat knowledge-card__cat--audit">{{ $typeLabels[$audit->audit_type] ?? ucfirst(str_replace('_', ' ', $audit->audit_type)) }}</span>
                                @endif
                                <h2 class="knowledge-card__title" itemprop="headline">{{ $audit->title }}</h2>
                                @if($audit->excerpt)
                                    <p class="knowledge-card__desc" itemprop="description">{{ Str::limit($audit->excerpt, 140) }}</p>
                                @endif
                                <div class="knowledge-card__meta">
                                    <meta itemprop="author" content="Aleksandr Primakov" />
                                    <meta itemprop="datePublished" content="{{ $audit->published_at?->toDateString() }}" />
                                    @if($audit->reading_time_minutes)
                                        <span>{{ $audit->reading_time_minutes }} {{ $locale === 'ru' ? 'мин' : 'min' }}</span>
                                    @endif
                                </div>
                                <span class="knowledge-card__cta">{{ $locale === 'ru' ? 'Читать разбор →' : ($locale === 'en' ? 'Read audit →' : 'Loe auditi →') }}</span>
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
        <h2>{{ $locale === 'ru' ? 'Хотите такой же разбор для вашего объекта?' : ($locale === 'en' ? 'Want the same audit for your property?' : 'Soovite sama auditi oma kinnisvarale?') }}</h2>
        <p>{{ $locale === 'ru' ? 'Бесплатный анализ рынка и стратегия за 24 часа.' : ($locale === 'en' ? 'Free market analysis and strategy within 24 hours.' : 'Tasuta turuanalüüs ja strateegia 24 tunni jooksul.') }}</p>
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
