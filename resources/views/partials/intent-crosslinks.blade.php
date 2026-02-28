{{-- Intent page cross-links — internal silo linking between intent pages and sell page --}}
@php
    $intentPages = [
        'no_calls'       => ['et' => 'Müüte ise, aga keegi ei helista?',         'ru' => 'Продаёте сами, но никто не звонит?',        'en' => 'Selling Yourself but No Calls?'],
        'no_offers'      => ['et' => 'Vaatamised on, aga pakkumisi pole?',       'ru' => 'Просмотры есть, но предложений нет?',        'en' => 'Viewings But No Offers?'],
        'price_analysis' => ['et' => 'Kinnisvara hinnaanalüüs Tallinnas',        'ru' => 'Анализ цены недвижимости в Таллинне',        'en' => 'Property Price Analysis Tallinn'],
        'mistakes'       => ['et' => 'Vead kinnisvara müümisel',                 'ru' => 'Ошибки при продаже недвижимости',             'en' => 'Mistakes When Selling Property'],
        'sell_faster'    => ['et' => 'Kuidas müüa kiiremini?',                   'ru' => 'Как продать быстрее?',                        'en' => 'How to Sell Faster?'],
        'listing_audit'  => ['et' => 'Kuulutuse audit',                          'ru' => 'Аудит объявления',                            'en' => 'Listing Audit'],
        'comparison'     => ['et' => 'Müüa ise vs strateegiline partner',        'ru' => 'Продавать самому или через партнёра',          'en' => 'Sell Yourself vs Strategy Partner'],
    ];
    $sellLabel = ['et' => 'Kinnisvara müük', 'ru' => 'Продажа недвижимости', 'en' => 'Sell Property'];
@endphp

<section class="intent-crosslinks">
  <div class="container">
    <h2>{{ $locale === 'ru' ? 'Полезные материалы для собственников' : ($locale === 'en' ? 'Helpful Resources for Property Owners' : 'Kasulikud materjalid omanikele') }}</h2>
    <div class="crosslinks-grid">
      {{-- Link to main sell page --}}
      <a href="{{ route("{$locale}.sell") }}" class="crosslink-card crosslink-card--primary">
        <span class="crosslink-card__icon">🏠</span>
        <span class="crosslink-card__title">{{ $sellLabel[$locale] ?? $sellLabel['et'] }}</span>
      </a>

      @foreach($intentPages as $key => $labels)
        @if($key !== ($pageKey ?? ''))
        <a href="{{ route("{$locale}.{$key}") }}" class="crosslink-card">
          <span class="crosslink-card__title">{{ $labels[$locale] ?? $labels['et'] }}</span>
        </a>
        @endif
      @endforeach
    </div>
  </div>
</section>
