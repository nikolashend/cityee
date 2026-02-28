{{-- Inaction Risks Block — Phase 6 STEP 1 --}}
@php
    $ir = config("cityee-knowledge.inaction_risks.{$locale}", []);
@endphp

@if(!empty($ir['risks']))
<section class="inaction-risks" id="inaction-risks">
  <div class="container">
    <h2>{{ $ir['title'] }}</h2>
    <div class="inaction-risks-grid">
      @foreach($ir['risks'] as $i => $risk)
      <div class="risk-card">
        <div class="risk-card__num">{{ $i + 1 }}</div>
        <h3 class="risk-card__title">{{ $risk['title'] }}</h3>
        <p class="risk-card__text">{{ $risk['text'] }}</p>
      </div>
      @endforeach
    </div>
  </div>
</section>
@endif
