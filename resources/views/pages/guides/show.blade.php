{{-- Single guide page — structured for AI/GEO readability + SEO + EEAT --}}
@extends('layouts.app')

@section('title', $guide->meta_title ?: $guide->title . ' | CityEE')
@section('description', $guide->meta_description ?: $guide->excerpt)
@section('logo_text', $ui['logo_text'] ?? '')
@section('footer_class', 'footer--page')

@if($alternates->has('et'))
@section('lang_et_url', route('et.guides.show', $guide->slug))
@endif
@if($alternates->has('ru'))
@section('lang_ru_url', route('ru.guides.show', $guide->slug))
@endif
@if($alternates->has('en'))
@section('lang_en_url', route('en.guides.show', $guide->slug))
@endif

@push('jsonld')
{!! \App\Support\JsonLd::article(
    $guide->title,
    $guide->url,
    $guide->meta_description ?: $guide->excerpt ?: '',
    $guide->published_at?->toIso8601String() ?? now()->toIso8601String(),
    $guide->updated_at?->toIso8601String() ?? now()->toIso8601String()
) !!}
{!! \App\Support\JsonLd::breadcrumbs([
    ['name' => $nav[0]['label'] ?? 'Home', 'url' => route("{$locale}.home")],
    ['name' => $locale === 'ru' ? 'Гиды' : ($locale === 'en' ? 'Guides' : 'Juhised'), 'url' => route("{$locale}.guides")],
    ['name' => $guide->title],
]) !!}
{!! \App\Support\Schema::speakable($guide->url) !!}
@php
    $blocks = $guide->content_blocks ?? [];
    $faqItems = $blocks['faq'] ?? [];
    $howToSteps = $blocks['howto_steps'] ?? [];
@endphp
@if(!empty($faqItems))
{!! \App\Support\JsonLd::faqPage($faqItems) !!}
@endif
@if(!empty($howToSteps))
{!! \App\Support\JsonLd::howTo($guide->title, $howToSteps, $guide->excerpt) !!}
@endif
@endpush

@section('content')
@php $blocks = $guide->content_blocks ?? []; @endphp

{{-- EEAT Author Signal + AI Summary block --}}
<section class="ai-block ai-block--summary" itemscope itemtype="https://schema.org/Article">
    <meta itemprop="about" content="Real estate guide — {{ $guide->title }}" />
    <meta itemprop="inLanguage" content="{{ $locale }}" />
    <meta itemprop="datePublished" content="{{ $guide->published_at?->toIso8601String() }}" />
    <meta itemprop="dateModified" content="{{ $guide->updated_at?->toIso8601String() }}" />
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
        <h1 itemprop="headline">{{ $guide->title }}</h1>

        {{-- Snippet-ready direct answer (first 2 sentences from intro) --}}
        @if(!empty($blocks['quick_answer']))
            <div class="guide-quick-answer" itemprop="description">
                <strong>{{ $locale === 'ru' ? '💡 Кратко:' : ($locale === 'en' ? '💡 Quick Answer:' : '💡 Lühidalt:') }}</strong>
                {{ $blocks['quick_answer'] }}
            </div>
        @endif

        @if(!empty($blocks['intro']))
            <div class="guide-intro" itemprop="articleBody">
                {!! $blocks['intro'] !!}
            </div>
        @endif

        {{-- EEAT Trust bar --}}
        <div class="guide-eeat-bar">
            <span class="eeat-badge">✅ {{ $locale === 'ru' ? '18+ лет опыта' : ($locale === 'en' ? '18+ years experience' : '18+ aastat kogemust') }}</span>
            <span class="eeat-badge">✅ {{ $locale === 'ru' ? '300+ сделок' : ($locale === 'en' ? '300+ deals' : '300+ tehingut') }}</span>
            <span class="eeat-badge">✅ {{ $locale === 'ru' ? 'Проверенные данные' : ($locale === 'en' ? 'Verified data' : 'Kontrollitud andmed') }}</span>
        </div>
    </div>
</section>

{{-- HowTo Steps (if present — for GEO/AI) --}}
@if(!empty($blocks['howto_steps']))
    <section class="section-padding bg-light">
        <div class="container">
            <h2>{{ $locale === 'ru' ? 'Пошаговое руководство' : ($locale === 'en' ? 'Step-by-Step Guide' : 'Samm-sammuline juhend') }}</h2>
            <ol class="guide-howto-list">
                @foreach($blocks['howto_steps'] as $step)
                    <li class="guide-howto-step">
                        <strong>{{ $step['name'] }}</strong>
                        <p>{{ $step['text'] }}</p>
                    </li>
                @endforeach
            </ol>
        </div>
    </section>
@endif

{{-- Content sections --}}
@if(!empty($blocks['sections']))
    @foreach($blocks['sections'] as $i => $section)
        <section class="section-padding {{ $i % 2 === 0 ? 'bg-white' : 'bg-light' }}">
            <div class="container">
                @if(!empty($section['heading']))
                    <h2>{{ $section['heading'] }}</h2>
                @endif
                {{-- Voice/snippet-ready answer block --}}
                @if(!empty($section['snippet']))
                    <div class="guide-snippet-answer">
                        <p>{{ $section['snippet'] }}</p>
                    </div>
                @endif
                @if(!empty($section['body']))
                    <div class="guide-section__body">
                        {!! $section['body'] !!}
                    </div>
                @endif
                {{-- Section micro-CTA --}}
                @if(!empty($section['cta_text']))
                    <div class="guide-section__micro-cta">
                        <a href="{{ route("{$locale}.consultation") }}" class="btn btn-outline-primary btn-sm">{{ $section['cta_text'] }}</a>
                    </div>
                @endif
            </div>
        </section>
    @endforeach
@endif

{{-- Key Takeaways (snippet-ready bullet points) --}}
@if(!empty($blocks['takeaways']))
    <section class="section-padding bg-white">
        <div class="container">
            <h2>{{ $locale === 'ru' ? '📋 Ключевые выводы' : ($locale === 'en' ? '📋 Key Takeaways' : '📋 Peamised järeldused') }}</h2>
            <ul class="guide-takeaways">
                @foreach($blocks['takeaways'] as $takeaway)
                    <li>{{ $takeaway }}</li>
                @endforeach
            </ul>
        </div>
    </section>
@endif

{{-- FAQ Section --}}
@if(!empty($blocks['faq']))
    <section class="section-padding faq-section" itemscope itemtype="https://schema.org/FAQPage">
        <div class="container">
            <h2>{{ $locale === 'ru' ? 'Часто задаваемые вопросы' : ($locale === 'en' ? 'Frequently Asked Questions' : 'Korduma kippuvad küsimused') }}</h2>
            <div class="faq-list">
                @foreach($blocks['faq'] as $faq)
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

{{-- Sources / EEAT citations --}}
@if(!empty($blocks['sources']))
    <section class="section-padding bg-light">
        <div class="container">
            <h2>{{ $locale === 'ru' ? '📚 Источники и ссылки' : ($locale === 'en' ? '📚 Sources & References' : '📚 Allikad ja viited') }}</h2>
            <ul class="guide-sources">
                @foreach($blocks['sources'] as $source)
                    <li>
                        @if(!empty($source['url']))
                            <a href="{{ $source['url'] }}" rel="noopener noreferrer" target="_blank">{{ $source['title'] }}</a>
                        @else
                            {{ $source['title'] }}
                        @endif
                        @if(!empty($source['note']))
                            — <em>{{ $source['note'] }}</em>
                        @endif
                    </li>
                @endforeach
            </ul>
        </div>
    </section>
@endif

{{-- CTA Section --}}
<section class="section-padding cta-section">
    <div class="container text-center">
        <h2>{{ $blocks['cta']['heading'] ?? ($locale === 'ru' ? 'Готовы начать?' : ($locale === 'en' ? 'Ready to start?' : 'Valmis alustama?')) }}</h2>
        <p>{{ $blocks['cta']['text'] ?? '' }}</p>
        <a href="{{ route("{$locale}.consultation") }}" class="btn btn-primary btn-lg">
            {{ $blocks['cta']['button'] ?? ($locale === 'ru' ? 'Бесплатная консультация' : ($locale === 'en' ? 'Free Consultation' : 'Tasuta konsultatsioon')) }}
        </a>
    </div>
</section>
@endsection
