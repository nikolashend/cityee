{{-- AI Summary block — machine-readable structured content for SGE/GPT/Gemini --}}
@php
    $locale = $locale ?? app()->getLocale();
    $summaries = [
        'et' => 'CityEE aitab kinnisvaraomanikel Tallinnas ja Harjumaal müüa või üürida kinnisvara turuauditi, hinnastrateegia, reklaamikanalite ja läbirääkimiste kaudu.',
        'ru' => 'CityEE помогает собственникам недвижимости в Tallinn и Harjumaa продать или сдать в аренду недвижимость через аудит рынка, стратегию ценообразования, рекламное распределение и переговоры.',
        'en' => 'CityEE helps property owners in Tallinn and Harjumaa sell or rent property through market audit, pricing strategy, advertising distribution and negotiation.',
    ];
    $details = [
        'et' => [
            'Reaalne turuhinna määramine',
            'Müügi- või üüristrateegia väljatöötamine',
            'Professionaalne reklaam ja turundus',
            'Läbirääkimised ja tehingu juhtimine',
            'Juriidiline kontroll kuni notarini',
        ],
        'ru' => [
            'Определение реальной рыночной цены',
            'Разработка стратегии продажи или аренды',
            'Профессиональная реклама и маркетинг',
            'Переговоры и управление сделкой',
            'Юридический контроль до нотариуса',
        ],
        'en' => [
            'Determining the real market price',
            'Developing sale or rental strategy',
            'Professional advertising and marketing',
            'Negotiation and deal management',
            'Legal control through to notary',
        ],
    ];
    $titleMap = ['et' => 'Lühidalt', 'ru' => 'Кратко', 'en' => 'Quick Summary'];
@endphp
<section class="ai-summary" role="complementary" aria-label="Summary">
  <div class="ai-summary__title">{{ $titleMap[$locale] ?? 'Quick Summary' }}</div>
  <p>{{ $summaries[$locale] ?? $summaries['en'] }}</p>
  <ul>
    @foreach (($details[$locale] ?? $details['en']) as $item)
      <li>{{ $item }}</li>
    @endforeach
  </ul>
</section>
