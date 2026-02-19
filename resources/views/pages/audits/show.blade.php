{{-- Single audit page — ЭТАП 5: AI/GEO + EEAT + Schema + Internal Links --}}
@extends('layouts.app')

@section('title', $audit->og_title ?: ($audit->meta_title ?: $audit->title . ' | CityEE'))
@section('description', $audit->og_description ?: ($audit->meta_description ?: $audit->excerpt))
@section('logo_text', $ui['logo_text'] ?? '')
@section('footer_class', 'footer--page')

@if($alternates->has('et'))
@section('lang_et_url', route('et.audits.show', $audit->slug))
@endif
@if($alternates->has('ru'))
@section('lang_ru_url', route('ru.audits.show', $audit->slug))
@endif
@if($alternates->has('en'))
@section('lang_en_url', route('en.audits.show', $audit->slug))
@endif

@push('jsonld')
{!! \App\Support\JsonLd::article(
    $audit->title,
    $audit->url,
    $audit->meta_description ?: $audit->excerpt ?: '',
    $audit->published_at?->toIso8601String() ?? now()->toIso8601String(),
    $audit->updated_at?->toIso8601String() ?? now()->toIso8601String()
) !!}
{!! \App\Support\JsonLd::breadcrumbs([
    ['name' => $nav[0]['label'] ?? 'Home', 'url' => route("{$locale}.home")],
    ['name' => $locale === 'ru' ? 'Разборы' : ($locale === 'en' ? 'Audits' : 'Auditid'), 'url' => route("{$locale}.audits")],
    ['name' => $audit->title],
]) !!}
{!! \App\Support\Schema::speakable($audit->url) !!}
@php
    $blocks = $audit->content_blocks ?? [];
    $faqItems = $audit->faq_json ?? $blocks['faq'] ?? [];
@endphp
@if(!empty($faqItems))
{!! \App\Support\JsonLd::faqPage($faqItems) !!}
@endif
@endpush

@section('content')
@php
    $blocks = $audit->content_blocks ?? [];
    $faqItems = $audit->faq_json ?? $blocks['faq'] ?? [];
    $aiSummary = $audit->ai_summary;
    $keyTakeaways = $audit->key_takeaways ?? [];
@endphp

{{-- ═══════════════════════  5.3.1  HERO  ═══════════════════════ --}}
<section class="guide-hero audit-hero" itemscope itemtype="https://schema.org/Article">
    <meta itemprop="about" content="Real estate audit — {{ $audit->title }}" />
    <meta itemprop="inLanguage" content="{{ $locale }}" />
    <meta itemprop="datePublished" content="{{ $audit->published_at?->toIso8601String() }}" />
    <meta itemprop="dateModified" content="{{ $audit->updated_at?->toIso8601String() }}" />
    <div itemprop="author" itemscope itemtype="https://schema.org/Person">
        <meta itemprop="name" content="Aleksandr Primakov" />
        <meta itemprop="jobTitle" content="Real Estate Deal Optimization Partner" />
        <meta itemprop="url" content="https://cityee.ee/" />
    </div>
    <div itemprop="publisher" itemscope itemtype="https://schema.org/Organization">
        <meta itemprop="name" content="CityEE" />
        <meta itemprop="url" content="https://cityee.ee" />
    </div>
    <div class="container">
        <nav class="guide-breadcrumb" aria-label="breadcrumb">
            <ol>
                <li><a href="{{ route("{$locale}.home") }}">{{ $nav[0]['label'] ?? 'Home' }}</a></li>
                <li><a href="{{ route("{$locale}.audits") }}">{{ $locale === 'ru' ? 'Разборы' : ($locale === 'en' ? 'Audits' : 'Auditid') }}</a></li>
                <li aria-current="page">{{ Str::limit($audit->title, 60) }}</li>
            </ol>
        </nav>

        <h1 itemprop="headline">{{ $audit->title }}</h1>

        {{-- Meta line --}}
        <div class="guide-meta">
            <span class="guide-meta__author">{{ $audit->author_name ?? 'Aleksandr Primakov' }}</span>
            @if($audit->reading_time_minutes)
                <span class="guide-meta__divider">·</span>
                <span class="guide-meta__reading">{{ $audit->reading_time_minutes }} {{ $locale === 'ru' ? 'мин чтения' : ($locale === 'en' ? 'min read' : 'min lugemist') }}</span>
            @endif
            @if($audit->published_at)
                <span class="guide-meta__divider">·</span>
                <time class="guide-meta__date" datetime="{{ $audit->published_at->toIso8601String() }}">{{ $audit->published_at->format('d.m.Y') }}</time>
            @endif
        </div>

        {{-- Two CTA buttons --}}
        <div class="guide-hero__ctas">
            <a href="https://wa.me/+37258829892?text={{ urlencode($locale === 'ru' ? 'Здравствуйте! Прочитал разбор «'.$audit->title.'». Хочу заказать такой же для моего объекта.' : ($locale === 'en' ? 'Hello! I read the audit "'.$audit->title.'". I want to order the same for my property.' : 'Tere! Lugesin auditi «'.$audit->title.'». Soovin sama oma kinnisvarale.')) }}" target="_blank" rel="noopener" class="intent-btn intent-btn--primary">
                <i class="fa fa-whatsapp"></i> {{ $locale === 'ru' ? 'Заказать в WhatsApp' : ($locale === 'en' ? 'Order via WhatsApp' : 'Telli WhatsAppis') }}
            </a>
            <a href="https://t.me/cityee_tallinn" target="_blank" rel="noopener" class="intent-btn intent-btn--secondary intent-btn--dark">
                <i class="fa fa-telegram"></i> {{ $locale === 'ru' ? 'Написать в Telegram' : ($locale === 'en' ? 'Message on Telegram' : 'Kirjuta Telegramis') }}
            </a>
        </div>

        {{-- EEAT Trust bar --}}
        <div class="guide-eeat-bar">
            <span class="eeat-badge">✅ {{ $locale === 'ru' ? '10+ лет опыта' : ($locale === 'en' ? '10+ years experience' : '10+ aastat kogemust') }}</span>
            <span class="eeat-badge">✅ {{ $locale === 'ru' ? '300+ сделок' : ($locale === 'en' ? '300+ deals' : '300+ tehingut') }}</span>
            <span class="eeat-badge">✅ {{ $locale === 'ru' ? 'Данные Maa-amet + KV.ee' : ($locale === 'en' ? 'Maa-amet + KV.ee data' : 'Maa-ameti + KV.ee andmed') }}</span>
        </div>
    </div>
</section>

{{-- ═══════════════════════  5.3.2  AI SUMMARY  ═══════════════════════ --}}
@if($aiSummary)
<section class="guide-ai-summary">
    <div class="container">
        <div class="ai-summary-box" data-ai-chunk="summary">
            <div class="ai-summary-box__icon">🤖</div>
            <div class="ai-summary-box__content">
                <h2 class="ai-summary-box__title">{{ $locale === 'ru' ? 'AI-резюме разбора' : ($locale === 'en' ? 'AI Audit Summary' : 'AI auditi kokkuvõte') }}</h2>
                <p>{{ $aiSummary }}</p>
            </div>
        </div>
    </div>
</section>
@endif

{{-- ═══════════════════════  5.3.3  KEY TAKEAWAYS  ═══════════════════════ --}}
@if(!empty($keyTakeaways))
<section class="guide-takeaways-section">
    <div class="container">
        <div class="guide-takeaways-box" data-ai-chunk="takeaways">
            <h2>{{ $locale === 'ru' ? '📋 Ключевые выводы' : ($locale === 'en' ? '📋 Key Takeaways' : '📋 Peamised järeldused') }}</h2>
            <ul class="guide-takeaways">
                @foreach($keyTakeaways as $takeaway)
                    <li>{{ $takeaway }}</li>
                @endforeach
            </ul>
        </div>
    </div>
</section>
@endif

{{-- ═══════════════════════  SUMMARY / MARKET OVERVIEW  ═══════════════════════ --}}
@if(!empty($blocks['summary']))
    <section class="section-padding bg-white">
        <div class="container">
            <div class="audit-summary" itemprop="text" data-ai-chunk="overview">
                {!! $blocks['summary'] !!}
            </div>
        </div>
    </section>
@endif

{{-- ═══════════════════════  MARKET DATA  ═══════════════════════ --}}
@if(!empty($blocks['market_data']))
    <section class="section-padding bg-light">
        <div class="container">
            <h2>{{ $locale === 'ru' ? '📊 Рыночные данные' : ($locale === 'en' ? '📊 Market Data' : '📊 Turuandmed') }}</h2>
            <div class="audit-market-data" data-ai-chunk="market-data">
                {!! $blocks['market_data'] !!}
            </div>
        </div>
    </section>
@endif

{{-- ═══════════════════════  5.3.4  CONTENT SECTIONS  ═══════════════════════ --}}
@if(!empty($blocks['sections']))
    @foreach($blocks['sections'] as $i => $section)
        <section class="section-padding {{ $i % 2 === 0 ? 'bg-white' : 'bg-light' }}">
            <div class="container">
                @if(!empty($section['heading']))
                    <h2>{{ $section['heading'] }}</h2>
                @endif
                @if(!empty($section['snippet']))
                    <div class="guide-snippet-answer" data-ai-chunk="section-{{ $i }}">
                        <p>{{ $section['snippet'] }}</p>
                    </div>
                @endif
                @if(!empty($section['body']))
                    <div class="audit-section__body">
                        {!! $section['body'] !!}
                    </div>
                @endif
            </div>
        </section>
    @endforeach
@endif

{{-- ═══════════════════════  5.3.5  FAQ (8-12 items)  ═══════════════════════ --}}
@if(!empty($faqItems))
    <section class="section-padding faq-section" itemscope itemtype="https://schema.org/FAQPage">
        <div class="container">
            <h2>{{ $locale === 'ru' ? 'Часто задаваемые вопросы' : ($locale === 'en' ? 'Frequently Asked Questions' : 'Korduma kippuvad küsimused') }}</h2>
            <div class="faq-list">
                @foreach($faqItems as $faq)
                    <div class="faq-item" itemscope itemprop="mainEntity" itemtype="https://schema.org/Question">
                        <button class="faq-question" itemprop="name" aria-expanded="false">{{ $faq['question'] }}</button>
                        <div class="faq-answer" itemscope itemprop="acceptedAnswer" itemtype="https://schema.org/Answer" hidden>
                            <div itemprop="text">{!! $faq['answer'] !!}</div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>
@endif

{{-- ═══════════════════════  5.3.6  INTERNAL LINKS  ═══════════════════════ --}}
@if(($relatedGuides && $relatedGuides->isNotEmpty()) || ($relatedAudits && $relatedAudits->isNotEmpty()))
<section class="section-padding bg-light guide-internal-links">
    <div class="container">
        <h2>{{ $locale === 'ru' ? '📖 Читайте также' : ($locale === 'en' ? '📖 Related Reading' : '📖 Loe ka') }}</h2>
        <div class="internal-links-grid">
            @if($relatedGuides && $relatedGuides->isNotEmpty())
                @foreach($relatedGuides as $rg)
                    <a href="{{ route("{$locale}.guides.show", $rg->slug) }}" class="internal-link-card">
                        <span class="internal-link-card__type">{{ $locale === 'ru' ? 'Гид' : ($locale === 'en' ? 'Guide' : 'Juhis') }}</span>
                        <span class="internal-link-card__title">{{ $rg->title }}</span>
                        @if($rg->excerpt)<span class="internal-link-card__desc">{{ Str::limit($rg->excerpt, 100) }}</span>@endif
                    </a>
                @endforeach
            @endif
            @if($relatedAudits && $relatedAudits->isNotEmpty())
                @foreach($relatedAudits as $ra)
                    <a href="{{ route("{$locale}.audits.show", $ra->slug) }}" class="internal-link-card">
                        <span class="internal-link-card__type">{{ $locale === 'ru' ? 'Разбор' : ($locale === 'en' ? 'Audit' : 'Audit') }}</span>
                        <span class="internal-link-card__title">{{ $ra->title }}</span>
                        @if($ra->excerpt)<span class="internal-link-card__desc">{{ Str::limit($ra->excerpt, 100) }}</span>@endif
                    </a>
                @endforeach
            @endif
        </div>
    </div>
</section>
@endif

{{-- ═══════════════════════  CTA SECTION  ═══════════════════════ --}}
<section class="section-padding guide-cta-section">
    <div class="container text-center">
        <h2>{{ $blocks['cta']['heading'] ?? ($locale === 'ru' ? 'Закажите такой же разбор для вашего объекта' : ($locale === 'en' ? 'Order the same audit for your property' : 'Telli sama audit oma kinnisvarale')) }}</h2>
        <p>{{ $blocks['cta']['text'] ?? ($locale === 'ru' ? 'Бесплатный анализ рынка и стратегия за 24 часа — без обязательств.' : ($locale === 'en' ? 'Free market analysis and strategy within 24 hours — no obligation.' : 'Tasuta turuanalüüs ja strateegia 24 tunni jooksul — kohustuseta.')) }}</p>
        <div class="guide-cta-buttons">
            <a href="https://wa.me/+37258829892" target="_blank" rel="noopener" class="intent-btn intent-btn--primary">
                <i class="fa fa-whatsapp"></i> {{ $locale === 'ru' ? 'WhatsApp' : 'WhatsApp' }}
            </a>
            <a href="https://t.me/cityee_tallinn" target="_blank" rel="noopener" class="intent-btn intent-btn--accent">
                <i class="fa fa-telegram"></i> {{ $locale === 'ru' ? 'Telegram' : 'Telegram' }}
            </a>
            <a href="{{ route("{$locale}.consultation") }}" class="intent-btn intent-btn--secondary intent-btn--dark">
                {{ $locale === 'ru' ? 'Консультация' : ($locale === 'en' ? 'Consultation' : 'Konsultatsioon') }}
            </a>
        </div>
    </div>
</section>

{{-- Geo reinforcement --}}
<div class="container guide-geo-line">
    <p><small>{{ $locale === 'ru' ? '📍 CityEE — Таллинн, Харьюмаа, Эстония. Viru väljak 2, Metro Plaza, 3 этаж.' : ($locale === 'en' ? '📍 CityEE — Tallinn, Harjumaa, Estonia. Viru väljak 2, Metro Plaza, 3rd floor.' : '📍 CityEE — Tallinn, Harjumaa, Eesti. Viru väljak 2, Metro Plaza, 3. korrus.') }}</small></p>
</div>
@endsection
