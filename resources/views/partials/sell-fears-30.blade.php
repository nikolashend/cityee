{{-- Top 30 Fears block for sell page (Phase 4 STEP 3) --}}
@php
    $fears = config("cityee-intent.sell_fears_30.{$locale}", []);
@endphp

@if(!empty($fears['items']))
<section class="sell-fears-30" id="fears-30">
  <div class="container">
    <h2>{{ $fears['title'] }}</h2>
    <div class="fears-accordion">
      @foreach($fears['items'] as $i => $item)
      <details class="fear-item">
        <summary>
          <span class="fear-num">{{ $i + 1 }}</span>
          <span class="fear-title">{{ $item['fear'] }}</span>
        </summary>
        <div class="fear-solution">
          <p><strong>{{ $locale === 'ru' ? 'Решение' : ($locale === 'en' ? 'Solution' : 'Lahendus') }}:</strong> {{ $item['solution'] }}</p>
        </div>
      </details>
      @endforeach
    </div>
  </div>
</section>
@endif
