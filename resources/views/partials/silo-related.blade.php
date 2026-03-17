{{--
  Silo Related Pages — semantic "next step" links for intent/service pages.
  Connects intent pages → guides → audits → conversion.
  
  @param string $locale
  @param string $pageKey  Current page key (e.g. 'no_calls', 'sell', 'audit')
--}}
@php
$locale = $locale ?? app()->getLocale();
$pageKey = $pageKey ?? '';

// Silo map: page → related pages with semantic anchors
$siloMap = [
    // ── Sell silo ──
    'sell' => [
        ['route' => "{$locale}.audit", 'et' => 'Kuulutuse audit enne müüki', 'ru' => 'Аудит объявления перед продажей', 'en' => 'Listing audit before sale'],
        ['route' => "{$locale}.no_calls", 'et' => 'Miks keegi ei helista?', 'ru' => 'Почему нет звонков?', 'en' => 'Why no calls?'],
        ['route' => "{$locale}.price_analysis", 'et' => 'Kinnisvara hinnaanalüüs', 'ru' => 'Анализ цены недвижимости', 'en' => 'Property price analysis'],
        ['route' => "{$locale}.profile", 'et' => 'Aleksandr Primakov — maakler', 'ru' => 'Александр Примаков — маклер', 'en' => 'Aleksandr Primakov — agent'],
    ],
    'rent' => [
        ['route' => "{$locale}.consultation", 'et' => 'Konsultatsioon enne üürimist', 'ru' => 'Консультация перед арендой', 'en' => 'Consultation before renting'],
        ['route' => "{$locale}.sell", 'et' => 'Kinnisvara müük', 'ru' => 'Продажа недвижимости', 'en' => 'Property sale'],
        ['route' => "{$locale}.profile", 'et' => 'Aleksandr Primakov — maakler', 'ru' => 'Александр Примаков — маклер', 'en' => 'Aleksandr Primakov — agent'],
    ],
    'consultation' => [
        ['route' => "{$locale}.sell", 'et' => 'Kinnisvara müük', 'ru' => 'Продажа недвижимости', 'en' => 'Property sale'],
        ['route' => "{$locale}.audit", 'et' => 'Kuulutuse audit', 'ru' => 'Аудит объявления', 'en' => 'Listing audit'],
        ['route' => "{$locale}.price_analysis", 'et' => 'Kinnisvara hinnaanalüüs', 'ru' => 'Анализ цены недвижимости', 'en' => 'Property price analysis'],
        ['route' => "{$locale}.profile", 'et' => 'Meie maakler', 'ru' => 'Наш маклер', 'en' => 'Our agent'],
    ],
    'audit' => [
        ['route' => "{$locale}.sell", 'et' => 'Kinnisvara müük', 'ru' => 'Продажа недвижимости', 'en' => 'Property sale'],
        ['route' => "{$locale}.no_calls", 'et' => 'Miks keegi ei helista?', 'ru' => 'Почему нет звонков?', 'en' => 'Why no calls?'],
        ['route' => "{$locale}.no_offers", 'et' => 'Vaatamised, aga pakkumisi pole?', 'ru' => 'Просмотры, но нет предложений?', 'en' => 'Viewings but no offers?'],
        ['route' => "{$locale}.consultation", 'et' => 'Konsultatsioon', 'ru' => 'Консультация', 'en' => 'Consultation'],
    ],
    // ── Intent silo ──
    'no_calls' => [
        ['route' => "{$locale}.listing_audit", 'et' => 'Kuulutuse audit', 'ru' => 'Аудит объявления', 'en' => 'Listing audit'],
        ['route' => "{$locale}.price_analysis", 'et' => 'Kinnisvara hinnaanalüüs', 'ru' => 'Анализ цены недвижимости', 'en' => 'Price analysis'],
        ['route' => "{$locale}.mistakes", 'et' => 'Vead kinnisvara müügil', 'ru' => 'Ошибки при продаже', 'en' => 'Selling mistakes'],
        ['route' => "{$locale}.consultation", 'et' => 'Konsultatsioon', 'ru' => 'Консультация', 'en' => 'Consultation'],
    ],
    'no_offers' => [
        ['route' => "{$locale}.price_analysis", 'et' => 'Kas hind on õige?', 'ru' => 'Верна ли цена?', 'en' => 'Is the price right?'],
        ['route' => "{$locale}.sell_faster", 'et' => 'Kuidas müüa kiiremini?', 'ru' => 'Как продать быстрее?', 'en' => 'How to sell faster?'],
        ['route' => "{$locale}.sell", 'et' => 'Kinnisvara müügivahendus', 'ru' => 'Продажа через маклера', 'en' => 'Sell with agent'],
        ['route' => "{$locale}.consultation", 'et' => 'Konsultatsioon', 'ru' => 'Консультация', 'en' => 'Consultation'],
    ],
    'price_analysis' => [
        ['route' => "{$locale}.audit", 'et' => 'Kuulutuse audit', 'ru' => 'Аудит объявления', 'en' => 'Listing audit'],
        ['route' => "{$locale}.sell", 'et' => 'Kinnisvara müük', 'ru' => 'Продажа недвижимости', 'en' => 'Property sale'],
        ['route' => "{$locale}.no_calls", 'et' => 'Miks keegi ei helista?', 'ru' => 'Почему нет звонков?', 'en' => 'Why no calls?'],
        ['route' => "{$locale}.consultation", 'et' => 'Konsultatsioon', 'ru' => 'Консультация', 'en' => 'Consultation'],
    ],
    'mistakes' => [
        ['route' => "{$locale}.sell_faster", 'et' => 'Kuidas müüa kiiremini?', 'ru' => 'Как продать быстрее?', 'en' => 'How to sell faster?'],
        ['route' => "{$locale}.comparison", 'et' => 'Ise vs strateegiline partner', 'ru' => 'Сам vs партнёр', 'en' => 'DIY vs partner'],
        ['route' => "{$locale}.listing_audit", 'et' => 'Kuulutuse audit', 'ru' => 'Аудит объявления', 'en' => 'Listing audit'],
        ['route' => "{$locale}.consultation", 'et' => 'Konsultatsioon', 'ru' => 'Консультация', 'en' => 'Consultation'],
    ],
    'sell_faster' => [
        ['route' => "{$locale}.price_analysis", 'et' => 'Kinnisvara hinnaanalüüs', 'ru' => 'Анализ цены', 'en' => 'Price analysis'],
        ['route' => "{$locale}.listing_audit", 'et' => 'Kuulutuse audit', 'ru' => 'Аудит объявления', 'en' => 'Listing audit'],
        ['route' => "{$locale}.sell", 'et' => 'Kinnisvara müük', 'ru' => 'Продажа недвижимости', 'en' => 'Property sale'],
        ['route' => "{$locale}.consultation", 'et' => 'Konsultatsioon', 'ru' => 'Консультация', 'en' => 'Consultation'],
    ],
    'listing_audit' => [
        ['route' => "{$locale}.audit", 'et' => 'Kinnisvara audit', 'ru' => 'Аудит недвижимости', 'en' => 'Property audit'],
        ['route' => "{$locale}.no_calls", 'et' => 'Miks keegi ei helista?', 'ru' => 'Почему нет звонков?', 'en' => 'Why no calls?'],
        ['route' => "{$locale}.sell", 'et' => 'Kinnisvara müük', 'ru' => 'Продажа недвижимости', 'en' => 'Property sale'],
        ['route' => "{$locale}.consultation", 'et' => 'Konsultatsioon', 'ru' => 'Консультация', 'en' => 'Consultation'],
    ],
    'comparison' => [
        ['route' => "{$locale}.sell", 'et' => 'Kinnisvara müük CityEE-ga', 'ru' => 'Продажа через CityEE', 'en' => 'Sell with CityEE'],
        ['route' => "{$locale}.mistakes", 'et' => 'Vead müügil', 'ru' => 'Ошибки при продаже', 'en' => 'Selling mistakes'],
        ['route' => "{$locale}.price_analysis", 'et' => 'Hinnaanalüüs', 'ru' => 'Анализ цены', 'en' => 'Price analysis'],
        ['route' => "{$locale}.consultation", 'et' => 'Konsultatsioon', 'ru' => 'Консультация', 'en' => 'Consultation'],
    ],
];

$links = $siloMap[$pageKey] ?? [];

$sectionTitles = [
    'et' => 'Kasulik edasi lugeda',
    'ru' => 'Полезно также',
    'en' => 'Useful next steps',
];
@endphp

@if(!empty($links))
<section class="silo-related" style="padding:2rem 0;background:#faf8f5">
  <div class="container" style="max-width:900px">
    <h3 style="font-size:1.1rem;margin-bottom:1rem;color:#1a1a2e">{{ $sectionTitles[$locale] ?? $sectionTitles['en'] }}</h3>
    <div style="display:grid;grid-template-columns:repeat(auto-fit,minmax(220px,1fr));gap:.75rem">
      @foreach($links as $link)
      <a href="{{ route($link['route']) }}" style="display:block;padding:.85rem 1.1rem;background:#fff;border-radius:8px;text-decoration:none;color:#1a1a2e;font-size:.95rem;border:1px solid #eee;transition:box-shadow .2s,border-color .2s" onmouseover="this.style.borderColor='#7b1f45';this.style.boxShadow='0 2px 8px rgba(123,31,69,.1)'" onmouseout="this.style.borderColor='#eee';this.style.boxShadow='none'">
        → {{ $link[$locale] ?? $link['en'] }}
      </a>
      @endforeach
    </div>
  </div>
</section>
@endif
