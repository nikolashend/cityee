{{-- Single area audit page — structured for AI readability + SEO --}}
@extends('layouts.app')

@section('title', $audit->meta_title ?: $audit->title . ' | CityEE')
@section('description', $audit->meta_description ?: $audit->excerpt)
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
    ['name' => $locale === 'ru' ? 'Аудит районов' : ($locale === 'en' ? 'Area Audits' : 'Piirkonna auditid')],
    ['name' => $audit->title],
]) !!}
{!! \App\Support\Schema::speakable($audit->url) !!}
@php
    $blocks = $audit->content_blocks ?? [];
    $faqItems = $blocks['faq'] ?? [];
@endphp
@if(!empty($faqItems))
{!! \App\Support\JsonLd::faqPage($faqItems) !!}
@endif
@endpush

@section('content')
@php $blocks = $audit->content_blocks ?? []; @endphp

{{-- AI Summary / Market Overview --}}
<section class="ai-block ai-block--summary" itemscope itemtype="https://schema.org/CreativeWork">
    <meta itemprop="about" content="Area audit — {{ $audit->title }}" />
    <meta itemprop="author" content="Aleksandr Tarasov" />
    <meta itemprop="inLanguage" content="{{ $locale }}" />
    <div class="container">
        <h1 itemprop="headline">{{ $audit->title }}</h1>
        @if(!empty($blocks['summary']))
            <div class="audit-summary" itemprop="text">
                {!! $blocks['summary'] !!}
            </div>
        @endif
    </div>
</section>

{{-- Market Data --}}
@if(!empty($blocks['market_data']))
    <section class="section-padding bg-light">
        <div class="container">
            <h2>{{ $locale === 'ru' ? 'Рыночные данные' : ($locale === 'en' ? 'Market Data' : 'Turuandmed') }}</h2>
            <div class="audit-market-data">
                {!! $blocks['market_data'] !!}
            </div>
        </div>
    </section>
@endif

{{-- Strategy / Analysis sections --}}
@if(!empty($blocks['sections']))
    @foreach($blocks['sections'] as $i => $section)
        <section class="section-padding {{ $i % 2 === 0 ? 'bg-white' : 'bg-light' }}">
            <div class="container">
                @if(!empty($section['heading']))
                    <h2>{{ $section['heading'] }}</h2>
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

{{-- FAQ Section --}}
@if(!empty($blocks['faq']))
    <section class="section-padding faq-section">
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

{{-- CTA Section --}}
<section class="section-padding cta-section">
    <div class="container text-center">
        <h2>{{ $blocks['cta']['heading'] ?? ($locale === 'ru' ? 'Закажите аудит вашего объекта' : ($locale === 'en' ? 'Order an audit for your property' : 'Telli oma kinnisvara audit')) }}</h2>
        <p>{{ $blocks['cta']['text'] ?? ($locale === 'ru' ? 'Бесплатный анализ рынка и стратегия за 24 часа' : ($locale === 'en' ? 'Free market analysis and strategy within 24 hours' : 'Tasuta turuanalüüs ja strateegia 24 tunni jooksul')) }}</p>
        <a href="{{ route("{$locale}.consultation") }}" class="btn btn-primary btn-lg">
            {{ $blocks['cta']['button'] ?? ($locale === 'ru' ? 'Заказать аудит' : ($locale === 'en' ? 'Order Audit' : 'Telli audit')) }}
        </a>
    </div>
</section>
@endsection
