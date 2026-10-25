{{-- Paid-traffic landing page (Google Ads) — one job per page, mobile-first.
     noindex/self-canonical/no-hreflang come from PpcLandingController. --}}
@extends('layouts.app')

@section('title', $ppc['meta_title'] ?? '')
@section('description', $ppc['meta_description'] ?? '')
@section('logo_text', $ui['logo_text'] ?? '')
@section('footer_class', 'footer--page')

@section('content')

<style>
/* PPC visual shell. Scoped to .page-ppc / .ppc-* — no shared class is
   redefined, so there is no cascade collision with cityee-v3.css /
   cityee-v3-overrides.css / cityee-phase5-6.css.

   NOTE ON UNITS: style.css sets html{font-size:10px}, so 1rem == 10px on this
   site, not 16px. Every length below is therefore stated in px — rem values
   written for a 16px root render at 62.5% of their intended size, which is
   exactly how this hero's copy became unreadably small. */

/* ── Header / hero collision — ONE root cause, both breakpoints ──
   The global header is position:fixed at >=768px and position:absolute at
   <=767px, so it sits OUTSIDE normal flow and nothing reserves space for it.
   Organic pages compensate with hard-coded per-breakpoint top padding on
   .v3-hero (208 / 192 / 308px). Copying those magic numbers here would break
   the moment the header's height changes, so the PPC shell instead puts the
   header BACK into normal flow for these two pages only — the hero then
   starts after it at every width, with no pixel arithmetic.
   position:relative, NOT static, is deliberate: .nav, .header__contacts,
   .header__phones and .languages are absolutely positioned against .header
   and must keep it as their containing block. */
.page-ppc header.header{position:relative}

/* Anchor offset: the site reserves 140px for the fixed header. On a PPC page
   the header scrolls away, so that reserve would leave a gap above the form. */
.page-ppc [id]{scroll-margin-top:16px}

/* Hero palette stated explicitly rather than inherited. Same burgundy gradient
   as the organic .v3-hero, so a paid visitor lands on a page that looks like
   CityEE: the logo, the sticky bar and every organic hero already use it.
   (The washed-out look in the owner's first screenshots was white hero text
   seen THROUGH the header's rgba(255,255,255,.9) background, not a wrong
   colour — but an explicit palette makes the hero immune to cascade changes.) */
.ppc-hero{background:linear-gradient(135deg,#7b1f45 0%,#4a1129 100%);color:#fff;padding:36px 0 32px}
.ppc-hero__title{color:#fff;font-size:clamp(26px,6vw,42px);line-height:1.18;margin:0 0 12px;text-wrap:balance}
.ppc-hero__sub{color:#fff;opacity:.92;font-size:clamp(16px,2.2vw,19px);line-height:1.55;margin:0 0 24px;max-width:36em}
.ppc-hero__cta{display:inline-block;padding:15px 26px;font-size:17px;font-weight:700;
  border-radius:8px;background:#4ecdc4;color:#10303a;text-decoration:none;min-height:48px;line-height:1.4}
.ppc-hero__cta:hover,.ppc-hero__cta:focus{background:#3fb8b0;color:#0b2429}
.ppc-block{padding:28px 0;border-bottom:1px solid #eee;background:#fff}
.ppc-block__title{font-size:19px;margin:0 0 14px;color:#1a1a2e}
.ppc-list{margin:0;padding-left:18px;line-height:1.65;font-size:16px;color:#333}
.ppc-list li{margin-bottom:8px}
.ppc-steps{list-style:none;margin:0;padding:0;counter-reset:ppcstep}
.ppc-steps li{position:relative;padding-left:40px;margin-bottom:18px;counter-increment:ppcstep}
.ppc-steps li::before{content:counter(ppcstep);position:absolute;left:0;top:0;width:28px;height:28px;
  border-radius:50%;background:#1a1a2e;color:#fff;font-weight:700;font-size:15px;
  display:flex;align-items:center;justify-content:center}
.ppc-steps__title{display:block;font-weight:700;font-size:17px;color:#1a1a2e;margin-bottom:3px}
.ppc-steps__text{display:block;line-height:1.6;color:#444;font-size:16px}
.ppc-note{background:#faf8f5;padding:20px 0;font-size:16px;line-height:1.6;color:#444}
@media (min-width:768px){
  .ppc-hero{padding:52px 0 48px}
}
/* Mobile single-job focus — same contract as the RU/ET valuation CRO work:
   the redundant right-hand float stack is removed, the primary action is
   available from the first viewport, and no fixed bar covers the submit. */
@media (max-width:767px){
  /* PPC-only header compaction: the global mobile header is 288px tall, 34% of
     a 844px phone before the paid message appears. Only DUPLICATE controls go:
     the fixed bottom bar already carries phone, WhatsApp and the primary CTA
     permanently, so the header copy of them costs a third of the paid first
     viewport and buys nothing. Brand and the burger navigation both stay. */
  .page-ppc .header__btn-wrapp{display:none}
  .page-ppc .header__main-phone{display:none}
  .page-ppc .header__logo{margin-bottom:8px}
  .sticky-buttons{display:none!important}
  .sticky-cta{transform:translateY(0)!important}
  #v3-form-calc,#v3-form-bank{padding-bottom:56px}
}
</style>

@if(($ppc['form'] ?? '') === 'bank-appraisal')
<style>
/* Bank variant only — this block is not emitted for the Lasnamäe LP, whose
   #v3-form-calc exists and whose floating calculator works.

   This page renders #v3-form-bank instead, so the sitewide floating
   «Рассчитать цену» pointed at a fragment that is not here. The shell above
   hides the whole floating stack at <=767px, which is why the dead control
   only ever surfaced on desktop; this removes just that one entry at every
   width and leaves WhatsApp and Telegram alone. display:none also drops it
   from the tab order. */
.sticky-btn--calc{display:none!important}
</style>
@endif
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
