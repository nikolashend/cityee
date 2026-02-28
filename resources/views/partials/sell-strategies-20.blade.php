{{-- Top 20 Sales Strategies for sell page (Phase 4 STEP 5) --}}
@php
    $strategies = config("cityee-intent.sell_strategies_20.{$locale}", []);
@endphp

@if(!empty($strategies['items']))
<section class="sell-strategies-20" id="strategies-20">
  <div class="container">
    <h2>{{ $strategies['title'] }}</h2>
    <div class="strategies-grid">
      @foreach($strategies['items'] as $i => $item)
      <div class="strategy-card">
        <div class="strategy-card__num">{{ $i + 1 }}</div>
        <h3 class="strategy-card__title">{{ $item['title'] }}</h3>
        <p class="strategy-card__desc">{{ $item['desc'] }}</p>
      </div>
      @endforeach
    </div>
  </div>
</section>
@endif
