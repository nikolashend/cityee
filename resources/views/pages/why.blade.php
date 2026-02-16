{{-- Why CityEE page (miks-cityee / pochemu-cityee / why-cityee) --}}
@extends('layouts.app')

@section('title', $t['meta_title'] ?? '')
@section('description', $t['meta_description'] ?? '')
@section('logo_text', $ui['logo_text'] ?? '')
@section('footer_class', 'footer--page')

@section('lang_et_url', route('et.why'))
@section('lang_ru_url', route('ru.why'))
@section('lang_en_url', route('en.why'))

@push('jsonld')
{!! \App\Support\JsonLd::webPage($t['h1'], \App\Support\SeoLinks::canonical('why'), $t['meta_description'] ?? '') !!}
{!! \App\Support\JsonLd::breadcrumbs([
    ['name' => $nav[0]['label'] ?? 'Home', 'url' => route("{$locale}.home")],
    ['name' => $t['h1']],
]) !!}
@endpush

@section('content')

<div class="page-title" style="background: url({{ $t['hero_bg'] }}) no-repeat; background-position: center top; background-size: cover;">
  <div class="container">
    <h1 class="page-title__name">{{ $t['h1'] }}</h1>
    <p class="page-title__text">{{ $t['hero_subtitle'] }}</p>
    <a href="{{ config('cityee.company.whatsapp') }}" target="_blank" class="btn">
      {{ $locale === 'en' ? 'Contact via WhatsApp' : ($locale === 'ru' ? 'Написать в WhatsApp' : 'Kirjuta WhatsAppi') }}
    </a>
  </div>
</div>

<div class="container">
  <div class="row">
    <div class="col-md-3 col-sm-3 text-center">
      @include('partials.sidebar-services', ['locale' => $locale, 'pageKey' => $pageKey])
    </div>
    <div class="col-md-9 col-sm-9">
      <div class="content">

        @if ($locale === 'et')
        <h2>Miks valida CityEE kinnisvaramaakler?</h2>
        <p>CityEE on kinnisvaratehingute optimeerimise partner Tallinnas ja Harjumaal. Meie eesmärk on aidata Teil saavutada parim tulemus kinnisvara müügil, ostmisel, üürile andmisel ja üürimisel.</p>

        <div class="possibilities">
          <ul>
            <li><strong>Minimaalne vahendustasu — ainult 2%</strong> ainuesinduslepingu korral</li>
            <li><strong>Kiire müügiaeg</strong> — keskmine korteri müügiaeg on 1–1,5 kuud</li>
            <li><strong>Tasuta kinnisvara hindamine</strong> ainuesinduslepingu sõlmimisel (vähemalt 3 kuuks)</li>
            <li><strong>Professionaalsed fotod ja reklaam</strong> — maksimaalne reklaampakett</li>
            <li><strong>Juriidiline konsultatsioon</strong> — kontrollime dokumentatsiooni ja kaitseme Teie huve</li>
            <li><strong>Koostöö teiste maakleritega</strong> — laiendame müügikanalit</li>
            <li><strong>Üle 120 000 kontakti</strong> reklaamivõrgustikus</li>
            <li><strong>Isiklik maakler</strong> — Aleksandr Primakov, kättesaadav 10:00–22:00</li>
          </ul>
        </div>

        <h2>Meie teenused</h2>
        <p>Pakume terviklikku kinnisvarateenust alates turuhinna analüüsist ja dokumentide kontrollimisest kuni notariaalse tehinguni.</p>
        @elseif ($locale === 'ru')
        <h2>Почему выбирают маклера CityEE?</h2>
        <p>CityEE — партнер по оптимизации сделок с недвижимостью в Таллинне и Харьюмаа. Наша цель — помочь вам достичь лучшего результата при продаже, покупке, сдаче в аренду недвижимости.</p>

        <div class="possibilities">
          <ul>
            <li><strong>Минимальная комиссия — всего 2%</strong> при эксклюзивном договоре</li>
            <li><strong>Быстрая продажа</strong> — средний срок продажи квартиры 1–1,5 месяца</li>
            <li><strong>Бесплатная оценка недвижимости</strong> при заключении эксклюзивного договора (мин. 3 месяца)</li>
            <li><strong>Профессиональные фотографии и реклама</strong> — максимальный рекламный пакет</li>
            <li><strong>Юридическая консультация</strong> — проверяем документацию и защищаем ваши интересы</li>
            <li><strong>Сотрудничество с другими маклерами</strong> — расширяем каналы продаж</li>
            <li><strong>Более 120 000 контактов</strong> в рекламной сети</li>
            <li><strong>Персональный маклер</strong> — Александр Примаков, доступен 10:00–22:00</li>
          </ul>
        </div>

        <h2>Наши услуги</h2>
        <p>Предлагаем комплексную услугу в сфере недвижимости от анализа рыночной цены и проверки документов до нотариальной сделки.</p>
        @else
        <h2>Why choose CityEE?</h2>
        <p>CityEE is a real estate deal optimization partner in Tallinn and Harjumaa. Our goal is to help you achieve the best result when selling, buying, or renting property.</p>

        <div class="possibilities">
          <ul>
            <li><strong>Minimal commission — only 2%</strong> with an exclusive agreement</li>
            <li><strong>Fast selling time</strong> — average apartment selling time is 1–1.5 months</li>
            <li><strong>Free property valuation</strong> when signing an exclusive agreement (min. 3 months)</li>
            <li><strong>Professional photos and advertising</strong> — maximum advertising package</li>
            <li><strong>Legal consultation</strong> — we verify documentation and protect your interests</li>
            <li><strong>Cooperation with other brokers</strong> — expanding sales channels</li>
            <li><strong>Over 120,000 contacts</strong> in the advertising network</li>
            <li><strong>Personal broker</strong> — Aleksandr Primakov, available 10:00–22:00</li>
          </ul>
        </div>

        <h2>Our Services</h2>
        <p>We offer a comprehensive real estate service from market price analysis and document verification to notarial transactions.</p>
        @endif

        <div class="offers__bonus">
          <p>
            @if ($locale === 'ru')
              Заключив с нами эксклюзивный договор, вы получите максимальный рекламный пакет с минимальной комиссией — <strong>ВСЕГО 2% от цены продажи!</strong>
            @elseif ($locale === 'en')
              By signing an exclusive agreement, you get the maximum advertising package with minimal commission — <strong>ONLY 2% of the selling price!</strong>
            @else
              Sõlmides meiega ainuesinduslepingu, saate maksimaalse reklaamipaketi minimaalse vahendustasuga — <strong>AINULT 2% müügihinnast!</strong>
            @endif
          </p>
        </div>

        <h2 class="text-left">{{ $ui['write_now'] ?? 'KIRJUTAGE MEILE KOHE!' }} </h2>
        <p class="text-left"><a href="" id="feedback1" class="btn"> {{ $ui['send_inquiry'] ?? 'SAADA PÄRING' }}</a></p>

      </div>
    </div>
  </div>
</div>

@include('partials.advantages', ['ui' => $ui, 'isPage' => true])

@include('partials.about', ['ui' => $ui, 'isPage' => true])

@endsection
