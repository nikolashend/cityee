{{-- Knowledge Hub Crosslinks — Phase 5 STEP 7 --}}
@php
    $guideKeys = [
        'guide_sell_tallinn', 'guide_rent', 'guide_pricing',
        'guide_negotiation', 'guide_staging', 'guide_market_2026', 'guide_mistakes',
    ];
    $icons = ['📖', '🔑', '💰', '🤝', '🏠', '📊', '⚠️'];
    $currentGuideKey = $currentGuideKey ?? '';
@endphp

<section class="knowledge-crosslinks">
  <div class="container">
    <h2>{{ $locale === 'ru' ? 'Другие руководства' : ($locale === 'en' ? 'More Guides' : 'Teised juhendid') }}</h2>
    <div class="crosslinks-grid">
      @foreach($guideKeys as $i => $gk)
        @if($gk !== $currentGuideKey)
        @php
            $gc = config("cityee-knowledge.{$gk}", []);
            $gl = $gc[$locale] ?? $gc['en'] ?? [];
            $slugField = match($locale) { 'ru' => 'slug_ru', 'en' => 'slug_en', default => 'slug' };
            $slug = $gc[$slugField] ?? '';
        @endphp
        @if(!empty($gl['h1']))
        <a href="{{ route("{$locale}.pillar", $slug) }}" class="crosslink-card">
          <span class="crosslink-card__icon">{{ $icons[$i] ?? '📄' }}</span>
          <span class="crosslink-card__title">{{ $gl['h1'] }}</span>
        </a>
        @endif
        @endif
      @endforeach

      {{-- Link back to cases --}}
      <a href="{{ route("{$locale}.cases") }}" class="crosslink-card crosslink-card--primary">
        <span class="crosslink-card__icon">🏆</span>
        <span class="crosslink-card__title">{{ $locale === 'ru' ? 'Кейсы CityEE' : ($locale === 'en' ? 'CityEE Cases' : 'CityEE juhtumid') }}</span>
      </a>
    </div>
  </div>
</section>
