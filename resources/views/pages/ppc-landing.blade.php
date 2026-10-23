{{-- Paid-traffic landing page (Google Ads) — one job per page, mobile-first.
     noindex/self-canonical/no-hreflang come from PpcLandingController. --}}
@extends('layouts.app')

@section('title', $ppc['meta_title'] ?? '')
@section('description', $ppc['meta_description'] ?? '')
@section('logo_text', $ui['logo_text'] ?? '')
@section('footer_class', 'footer--page')

@section('content')

<style>
/* Scoped to .ppc-* — no shared class is redefined, so no cascade collision
   with cityee-v3.css / cityee-v3-overrides.css / cityee-phase5-6.css. */
.ppc-hero{background:var(--ce-dark,#1a1a2e);color:#fff;padding:2.25rem 0 2rem}
.ppc-hero__title{font-size:1.6rem;line-height:1.2;margin:0 0 .75rem;text-wrap:balance}
.ppc-hero__sub{font-size:1.02rem;line-height:1.55;opacity:.92;margin:0 0 1.5rem;max-width:34rem}
.ppc-hero__cta{display:inline-block;padding:.95rem 1.5rem;font-size:1.05rem;font-weight:700;
  border-radius:8px;background:#4ecdc4;color:#10303a;text-decoration:none;min-height:48px;line-height:1.4}
.ppc-hero__cta:hover,.ppc-hero__cta:focus{background:#3fb8b0;color:#0b2429}
.ppc-block{padding:1.75rem 0;border-bottom:1px solid #eee;background:#fff}
.ppc-block__title{font-size:1.15rem;margin:0 0 .9rem;color:#1a1a2e}
.ppc-list{margin:0;padding-left:1.15rem;line-height:1.65;font-size:1rem;color:#333}
.ppc-list li{margin-bottom:.5rem}
.ppc-steps{list-style:none;margin:0;padding:0;counter-reset:ppcstep}
.ppc-steps li{position:relative;padding-left:2.4rem;margin-bottom:1.1rem;counter-increment:ppcstep}
.ppc-steps li::before{content:counter(ppcstep);position:absolute;left:0;top:0;width:1.7rem;height:1.7rem;
  border-radius:50%;background:#1a1a2e;color:#fff;font-weight:700;font-size:.95rem;
  display:flex;align-items:center;justify-content:center}
.ppc-steps__title{display:block;font-weight:700;color:#1a1a2e;margin-bottom:.15rem}
.ppc-steps__text{display:block;line-height:1.6;color:#444;font-size:.97rem}
.ppc-note{background:#faf8f5;padding:1.25rem 0;font-size:.95rem;line-height:1.6;color:#444}
@media (min-width:768px){
  .ppc-hero{padding:3.25rem 0 3rem}
  .ppc-hero__title{font-size:2.1rem}
}
/* Mobile single-job focus — same contract as the RU/ET valuation CRO work:
   the redundant right-hand float stack is removed, the primary action is
   available from the first viewport, and no fixed bar covers the submit. */
@media (max-width:767px){
  .sticky-buttons{display:none!important}
  .sticky-cta{transform:translateY(0)!important}
  #v3-form-calc,#v3-form-bank{padding-bottom:3.5rem}
}
</style>

<section class="ppc-hero">
  <div class="container">
    <h1 class="ppc-hero__title">{{ $ppc['h1'] }}</h1>
    @if(!empty($ppc['subtitle']))
    <p class="ppc-hero__sub">{{ $ppc['subtitle'] }}</p>
    @endif
    <a href="{{ $ppc['cta_target'] }}" class="ppc-hero__cta">{{ $ppc['cta_label'] }}</a>
  </div>
</section>

@if(!empty($ppc['bullets']))
<section class="ppc-block">
  <div class="container">
    <ul class="ppc-list">
      @foreach($ppc['bullets'] as $bullet)
      <li>{{ $bullet }}</li>
      @endforeach
    </ul>
  </div>
</section>
@endif

@if(!empty($ppc['steps']))
<section class="ppc-block">
  <div class="container">
    <h2 class="ppc-block__title">{{ $ppc['steps_title'] ?? 'Как это работает' }}</h2>
    <ol class="ppc-steps">
      @foreach($ppc['steps'] as $step)
      <li>
        <span class="ppc-steps__title">{{ $step['title'] }}</span>
        <span class="ppc-steps__text">{{ $step['text'] }}</span>
      </li>
      @endforeach
    </ol>
  </div>
</section>
@endif

@if(!empty($ppc['facts']))
<section class="ppc-block">
  <div class="container">
    <h2 class="ppc-block__title">{{ $ppc['facts_title'] ?? '' }}</h2>
    <ul class="ppc-list">
      @foreach($ppc['facts'] as $fact)
      <li>{{ $fact }}</li>
      @endforeach
    </ul>
  </div>
</section>
@endif

@if(($ppc['form'] ?? '') === 'bank-appraisal')
@include('components.v3.form-bank-appraisal', ['locale' => $locale, 'ppc' => $ppc])
@else
@include('components.v3.form-calc', ['locale' => $locale])
@endif
@include('components.v3.form-scripts')

@if(!empty($ppc['reassurance']))
<section class="ppc-note">
  <div class="container">
    <p style="margin:0">{{ $ppc['reassurance'] }}</p>
  </div>
</section>
@endif

@include('components.v3.trust-agent', ['locale' => $locale])

@endsection
