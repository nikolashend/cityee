{{-- Audit landing page (kinnisvara-audit) --}}
@extends('layouts.app')

@section('title', $t['meta_title'] ?? '')
@section('description', $t['meta_description'] ?? '')
@section('logo_text', $ui['logo_text'] ?? '')
@section('footer_class', 'footer--page')

@section('lang_et_url', route('et.audit'))
@section('lang_ru_url', route('ru.audit'))
@section('lang_en_url', route('en.audit'))

@push('jsonld')
{!! \App\Support\JsonLd::servicePage('audit', $t) !!}
{!! \App\Support\JsonLd::breadcrumbs([
    ['name' => $nav[0]['label'] ?? 'Home', 'url' => route("{$locale}.home")],
    ['name' => $t['h1']],
]) !!}
{!! \App\Support\Schema::speakable(url()->current()) !!}
<script type="application/ld+json">{!! json_encode(\App\Support\Schema::personJsonLd(), JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT) !!}</script>
@endpush

@section('content')

<div class="page-title" style="background: url({{ $t['hero_bg'] }}) no-repeat; background-position: center top; background-size: cover;">
  <div class="container">
    <h1 class="page-title__name">{{ $t['h1'] }}</h1>
    <p class="page-title__text">{{ $t['hero_subtitle'] }}</p>
    <a href="#audit-form" class="btn">{{ $t['form_submit'] }}</a>
  </div>
</div>

<div class="container">
  <div class="row">
    <div class="col-md-3 col-sm-3 text-center">
      @include('partials.sidebar-services', ['locale' => $locale, 'pageKey' => $pageKey])
    </div>
    <div class="col-md-9 col-sm-9">
      <div class="content">

        @include('partials.ai-summary', ['locale' => $locale])

        {{-- Problem statement --}}
        <div class="trust-layer" style="margin-bottom:30px;">
          <p style="font-size:1.15em;font-weight:600;text-align:center;margin:0;">
            ⚠️ {{ $t['problem_title'] }}
          </p>
        </div>

        {{-- What the audit includes --}}
        <h2>{{ $t['audit_title'] }}</h2>
        <div class="possibilities">
          <ul>
            @foreach ($t['audit_items'] as $item)
              <li><strong>{{ $item }}</strong></li>
            @endforeach
          </ul>
        </div>

        {{-- Who benefits --}}
        <h2>{{ $t['for_whom_title'] }}</h2>
        <ul>
          @foreach ($t['for_whom'] as $whom)
            <li>{{ $whom }}</li>
          @endforeach
        </ul>

        {{-- Audit request form --}}
        <div id="audit-form" class="audit-form">
          <h2>{{ $t['form_title'] }}</h2>

          <form action="{{ config('cityee.company.whatsapp') }}" method="get" target="_blank" onsubmit="return buildAuditWhatsApp(this);">
            <div class="row">
              <div class="col-md-6">
                <label>{{ $t['form_type'] }}</label>
                <select name="type" class="form-control" required>
                  <option value="{{ $t['form_apartment'] }}">{{ $t['form_apartment'] }}</option>
                  <option value="{{ $t['form_house'] }}">{{ $t['form_house'] }}</option>
                  <option value="{{ $t['form_commercial'] }}">{{ $t['form_commercial'] }}</option>
                </select>
              </div>
              <div class="col-md-6">
                <label>{{ $t['form_district'] }}</label>
                <input type="text" name="district" class="form-control" required>
              </div>
            </div>
            <div class="row" style="margin-top:12px;">
              <div class="col-md-6">
                <label>{{ $t['form_area'] }}</label>
                <input type="text" name="area" class="form-control" required>
              </div>
              <div class="col-md-6">
                <label>{{ $t['form_phone'] }}</label>
                <input type="text" name="phone" class="form-control" required>
              </div>
            </div>
            <div class="row" style="margin-top:12px;">
              <div class="col-md-12">
                <label>{{ $t['form_link'] }}</label>
                <input type="url" name="link" class="form-control" placeholder="https://...">
              </div>
            </div>
            <div style="margin-top:18px;">
              <button type="submit" class="btn">{{ $t['form_submit'] }}</button>
              <p style="margin-top:8px;font-size:0.9em;color:#666;">{{ $t['form_note'] }}</p>
            </div>
          </form>
        </div>

        @include('partials.ai-citation', ['locale' => $locale])

      </div>
    </div>
  </div>
</div>

{{-- FAQ accordion --}}
@if (!empty($t['faq']))
@include('partials.faq', ['faq' => $t['faq'], 'faqTitle' => 'FAQ'])
@endif

@include('partials.advantages', ['ui' => $ui, 'isPage' => true])

@include('partials.about', ['ui' => $ui, 'isPage' => true])

<script>
function buildAuditWhatsApp(form) {
  var msg = '{{ $locale === "ru" ? "Заявка на аудит" : ($locale === "en" ? "Audit request" : "Auditi tellimus") }}:\n';
  msg += '{{ $t["form_type"] }}: ' + form.type.value + '\n';
  msg += '{{ $t["form_district"] }}: ' + form.district.value + '\n';
  msg += '{{ $t["form_area"] }}: ' + form.area.value + '\n';
  if (form.link.value) msg += 'Link: ' + form.link.value + '\n';
  msg += '{{ $t["form_phone"] }}: ' + form.phone.value;
  window.open('https://wa.me/3725113411?text=' + encodeURIComponent(msg), '_blank');
  return false;
}
</script>

@endsection
