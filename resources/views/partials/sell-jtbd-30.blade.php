{{-- Top 30 JTBD block for sell page (Phase 4 STEP 2) --}}
@php
    $jtbd30 = config("cityee-intent.sell_jtbd_30.{$locale}", []);
@endphp

@if(!empty($jtbd30['items']))
<section class="sell-jtbd-30" id="jtbd-30">
  <div class="container">
    <h2>{{ $jtbd30['title'] }}</h2>
    <div class="jtbd-30-grid">
      @foreach($jtbd30['items'] as $i => $item)
      <div class="jtbd-30-item">
        <span class="jtbd-30-num">{{ $i + 1 }}</span>
        <span class="jtbd-30-text">{{ $item }}</span>
      </div>
      @endforeach
    </div>
    <div class="jtbd-30-cta">
      <p>{{ $locale === 'ru' ? 'CityEE берёт все 30 задач на себя.' : ($locale === 'en' ? 'CityEE handles all 30 tasks for you.' : 'CityEE võtab kõik 30 ülesannet enda peale.') }}</p>
      <a href="#v3-form-audit" class="btn btn-primary">{{ $locale === 'ru' ? 'Узнать подробнее' : ($locale === 'en' ? 'Learn more' : 'Loe lähemalt') }}</a>
    </div>
  </div>
</section>
@endif
