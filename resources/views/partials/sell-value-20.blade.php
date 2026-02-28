{{-- Top 20 Value-Add strategies for sell page (Phase 4 STEP 4) --}}
@php
    $value = config("cityee-intent.sell_value_20.{$locale}", []);
@endphp

@if(!empty($value['items']))
<section class="sell-value-20" id="value-20">
  <div class="container">
    <h2>{{ $value['title'] }}</h2>
    <div class="value-grid">
      @foreach($value['items'] as $i => $item)
      <div class="value-card">
        <div class="value-card__num">{{ $i + 1 }}</div>
        <h3 class="value-card__title">{{ $item['title'] }}</h3>
        <p class="value-card__desc">{{ $item['desc'] }}</p>
      </div>
      @endforeach
    </div>
  </div>
</section>
@endif
