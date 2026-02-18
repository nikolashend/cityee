{{-- Guides index page --}}
@extends('layouts.app')

@section('title', $locale === 'ru' ? 'Гиды по недвижимости Tallinn | CityEE' : ($locale === 'en' ? 'Real Estate Guides Tallinn | CityEE' : 'Kinnisvarajuhised Tallinn | CityEE'))
@section('description', $locale === 'ru' ? 'Экспертные гиды CityEE: продажа, покупка, аренда недвижимости в Таллинне и Харьюмаа.' : ($locale === 'en' ? 'CityEE expert guides: selling, buying, renting real estate in Tallinn & Harjumaa.' : 'CityEE ekspertjuhised: kinnisvara müük, ost, üür Tallinnas ja Harjumaal.'))
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
@endpush

@section('content')
<section class="page-title-area">
    <div class="container">
        <h1>{{ $locale === 'ru' ? 'Гиды по недвижимости' : ($locale === 'en' ? 'Real Estate Guides' : 'Kinnisvarajuhised') }}</h1>
        <p class="lead">{{ $locale === 'ru' ? 'Экспертные материалы от Александра Тарасова — кинisваraмaaклер с 18+ лет опыта' : ($locale === 'en' ? 'Expert materials from Aleksandr Tarasov — real estate broker with 18+ years experience' : 'Ekspertmaterjalid Aleksandr Tarasovilt — kinnisvaramaakler 18+ aastat kogemust') }}</p>
    </div>
</section>

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
                                <h2 class="knowledge-card__title" itemprop="headline">{{ $guide->title }}</h2>
                                @if($guide->excerpt)
                                    <p class="knowledge-card__desc" itemprop="description">{{ $guide->excerpt }}</p>
                                @endif
                                <meta itemprop="author" content="Aleksandr Tarasov" />
                                <meta itemprop="datePublished" content="{{ $guide->published_at?->toDateString() }}" />
                                <span class="knowledge-card__cta">{{ $locale === 'ru' ? 'Читать →' : ($locale === 'en' ? 'Read →' : 'Loe →') }}</span>
                            </a>
                        </article>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
</section>
@endsection
