{{-- Problem → Solution section for home page --}}
@php
    $locale = $locale ?? app()->getLocale();
    $co = config('cityee.company');
    $titles = [
        'et' => 'Kui müüte ise',
        'ru' => 'Если вы продаёте самостоятельно',
        'en' => 'If you are selling on your own',
    ];
    $cards = [
        'et' => [
            ['icon' => '📵', 'title' => 'Pole kõnesid', 'text' => 'Kuulutus on aktiivne, aga helistajaid ei tule. Põhjus on sageli vales hinnas või nõrgas esitluses.', 'cta' => 'Telli audit'],
            ['icon' => '👀', 'title' => 'Vaatamised on, pakkumisi pole', 'text' => 'Inimesed tulevad vaatama, aga keegi ei tee pakkumist. See viitab hinna või objekti esitlemise probleemile.', 'cta' => 'Saa analüüs'],
            ['icon' => '📉', 'title' => 'Surve hindade alandamiseks', 'text' => 'Ostjad suruvad hinda alla ja te ei tea, kuidas argumenteerida. Strateegiline positsion on puudu.', 'cta' => 'Räägi eksperdiga'],
        ],
        'ru' => [
            ['icon' => '📵', 'title' => 'Нет звонков', 'text' => 'Объявление активно, но звонков нет. Причина — часто в неправильной цене или слабой подаче.', 'cta' => 'Заказать аудит'],
            ['icon' => '👀', 'title' => 'Много просмотров — нет предложений', 'text' => 'Люди приходят на просмотр, но никто не делает предложение. Это сигнал проблемы с ценой или подачей.', 'cta' => 'Получить разбор'],
            ['icon' => '📉', 'title' => 'Давят на торг', 'text' => 'Покупатели давят на снижение цены, а вы не знаете как аргументировать. Не хватает стратегии позиционирования.', 'cta' => 'Поговорить с экспертом'],
        ],
        'en' => [
            ['icon' => '📵', 'title' => 'No calls', 'text' => 'Your listing is active but no one is calling. The reason is often wrong pricing or weak presentation.', 'cta' => 'Order audit'],
            ['icon' => '👀', 'title' => 'Views but no offers', 'text' => 'People come to view but nobody makes an offer. This signals a pricing or presentation issue.', 'cta' => 'Get analysis'],
            ['icon' => '📉', 'title' => 'Pressure to lower price', 'text' => 'Buyers push the price down and you don\'t know how to argue. A positioning strategy is missing.', 'cta' => 'Talk to expert'],
        ],
    ];
@endphp
<section class="problem-section">
  <div class="container">
    <h2 class="problem-section__title">{{ $titles[$locale] ?? $titles['en'] }}</h2>
    <div class="problem-cards">
      @foreach (($cards[$locale] ?? $cards['en']) as $card)
        <div class="problem-card">
          <div class="problem-card__icon">{{ $card['icon'] }}</div>
          <div class="problem-card__title">{{ $card['title'] }}</div>
          <p class="problem-card__text">{{ $card['text'] }}</p>
          <a href="{{ $co['whatsapp'] }}" target="_blank" rel="noopener" class="problem-card__cta">{{ $card['cta'] }}</a>
        </div>
      @endforeach
    </div>
  </div>
</section>
