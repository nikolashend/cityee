{{-- Single guide page — structured for AI readability + SEO --}}
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
@endphp
@if(!empty($faqItems))
{!! \App\Support\JsonLd::faqPage($faqItems) !!}
@endif
@endpush

@section('content')
@php $blocks = $guide->content_blocks ?? []; @endphp

{{-- AI Summary block --}}
<section class="ai-block ai-block--summary" itemscope itemtype="https://schema.org/CreativeWork">
    <meta itemprop="about" content="Real estate guide — {{ $guide->title }}" />
    <meta itemprop="author" content="Aleksandr Tarasov" />
    <meta itemprop="inLanguage" content="{{ $locale }}" />
    <div class="container">
        <h1 itemprop="headline">{{ $guide->title }}</h1>
        @if(!empty($blocks['intro']))
            <div class="guide-intro" itemprop="text">
                {!! $blocks['intro'] !!}
            </div>
        @endif
    </div>
</section>

{{-- Content sections --}}
@if(!empty($blocks['sections']))
    @foreach($blocks['sections'] as $i => $section)
        <section class="section-padding {{ $i % 2 === 0 ? 'bg-white' : 'bg-light' }}">
            <div class="container">
                @if(!empty($section['heading']))
                    <h2>{{ $section['heading'] }}</h2>
                @endif
                @if(!empty($section['body']))
                    <div class="guide-section__body">
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
@if(!empty($blocks['cta']))
    <section class="section-padding cta-section">
        <div class="container text-center">
            <h2>{{ $blocks['cta']['heading'] ?? ($locale === 'ru' ? 'Готовы начать?' : ($locale === 'en' ? 'Ready to start?' : 'Valmis alustama?')) }}</h2>
            <p>{{ $blocks['cta']['text'] ?? '' }}</p>
            <a href="{{ route("{$locale}.consultation") }}" class="btn btn-primary btn-lg">
                {{ $blocks['cta']['button'] ?? ($locale === 'ru' ? 'Бесплатная консультация' : ($locale === 'en' ? 'Free Consultation' : 'Tasuta konsultatsioon')) }}
            </a>
        </div>
    </section>
@endif
@endsection
