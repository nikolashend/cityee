{{-- Before/After block — Phase 5 --}}
@php
  $ba = [
    'ru' => [
      'title' => 'До и после: как работает CityEE',
      'before_label' => 'ДО',
      'after_label' => 'ПОСЛЕ',
      'items' => [
        ['before' => 'Квартира на рынке 6+ месяцев', 'after' => 'Продана за 38 дней'],
        ['before' => 'Цена занижена на 10-15%', 'after' => 'Продана на 3% выше стартовой'],
        ['before' => 'Покупатели не перезванивают', 'after' => '12 показов за 2 недели'],
        ['before' => 'Фотографии на телефон', 'after' => 'Профессиональная подготовка'],
        ['before' => 'Нет стратегии переговоров', 'after' => 'Структурированный аукцион'],
      ],
    ],
    'en' => [
      'title' => 'Before & After: How CityEE Works',
      'before_label' => 'BEFORE',
      'after_label' => 'AFTER',
      'items' => [
        ['before' => 'Apartment on market 6+ months', 'after' => 'Sold in 38 days'],
        ['before' => 'Price undervalued by 10-15%', 'after' => 'Sold 3% above asking price'],
        ['before' => 'Buyers not calling back', 'after' => '12 viewings in 2 weeks'],
        ['before' => 'Phone photos', 'after' => 'Professional staging'],
        ['before' => 'No negotiation strategy', 'after' => 'Structured bidding process'],
      ],
    ],
    'et' => [
      'title' => 'Enne ja pärast: kuidas CityEE töötab',
      'before_label' => 'ENNE',
      'after_label' => 'PÄRAST',
      'items' => [
        ['before' => 'Korter turul 6+ kuud', 'after' => 'Müüdud 38 päevaga'],
        ['before' => 'Hind alahinnatud 10-15%', 'after' => 'Müüdud 3% üle alghinna'],
        ['before' => 'Ostjad ei helista tagasi', 'after' => '12 vaatamist 2 nädalaga'],
        ['before' => 'Telefoni fotod', 'after' => 'Professionaalne ettevalmistus'],
        ['before' => 'Puudub läbirääkimiste strateegia', 'after' => 'Struktureeritud pakkumisprotsess'],
      ],
    ],
  ];
  $d = $ba[$locale] ?? $ba['et'];
@endphp

<section class="before-after">
  <div class="container">
    <h2 class="section-title text-center">{{ $d['title'] }}</h2>
    <div class="ba-grid">
      @foreach ($d['items'] as $item)
        <div class="ba-row">
          <div class="ba-cell ba-before">
            <span class="ba-label">{{ $d['before_label'] }}</span>
            <span>{{ $item['before'] }}</span>
          </div>
          <div class="ba-arrow">→</div>
          <div class="ba-cell ba-after">
            <span class="ba-label">{{ $d['after_label'] }}</span>
            <span>{{ $item['after'] }}</span>
          </div>
        </div>
      @endforeach
    </div>
  </div>
</section>
