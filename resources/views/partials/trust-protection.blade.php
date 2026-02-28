{{-- Trust Protection Block — Phase 6 STEP 1 --}}
@php
    $tp = config("cityee-knowledge.trust_protection.{$locale}", []);
@endphp

@if(!empty($tp['items']))
<section class="trust-protection" id="trust-protection">
  <div class="container">
    <h2>{{ $tp['title'] }}</h2>
    <div class="trust-protection-grid">
      @foreach($tp['items'] as $item)
      <div class="trust-prot-card">
        <span class="trust-prot-card__icon">{{ $item['icon'] }}</span>
        <h3 class="trust-prot-card__title">{{ $item['title'] }}</h3>
        <p class="trust-prot-card__text">{{ $item['text'] }}</p>
      </div>
      @endforeach
    </div>
  </div>
</section>
@endif
