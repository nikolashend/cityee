{{-- Contacts page (kontaktid) --}}
@extends('layouts.app')

@section('title', $t['meta_title'] ?? '')
@section('description', $t['meta_description'] ?? '')
@section('logo_text', $ui['logo_text'] ?? '')
@section('footer_class', 'footer--page')

@section('lang_et_url', route('et.contacts'))
@section('lang_ru_url', route('ru.contacts'))
@section('lang_en_url', route('en.contacts'))

@php $co = config('cityee.company'); @endphp

@push('jsonld')
{!! \App\Support\JsonLd::contactPage($t) !!}
{!! \App\Support\JsonLd::breadcrumbs([
    ['name' => $nav[0]['label'] ?? 'Home', 'url' => route("{$locale}.home")],
    ['name' => $t['h1']],
]) !!}
{!! \App\Support\Schema::speakable(url()->current()) !!}
@endpush

@section('content')

<div class="page-title" style="background: url(/assets/templates/offshors/img/map-bg.jpg) no-repeat; background-position: center bottom; background-size: cover;">
  <div class="container">
      <h1 class="page-title__name">{{ $t['h1'] }}</h1>
  </div>
</div>


<div class="container">
  <div class="row">
    <div class="col-md-3 col-sm-3 text-center">
      @include('partials.sidebar-services', ['locale' => $locale, 'pageKey' => $pageKey])
    </div>
    <div class="col-md-9 col-sm-9">
      <div class="content">
        <p><b class="pink">{{ $t['office_label'] }} </b>{{ $co['name'] }}</p>
        <p><b class="pink">{{ $t['address_label'] }} </b>Viru-väljak 2, Metro Plaza (3 Korrus), {{ $co['city'] }}, {{ $co['postal_code'] }}</p>
        <p><b class="pink">{{ $t['phone_label'] }} </b>{{ $co['phone_display'] }}</p>
        <p><b class="pink">{{ $t['app_phones'] }} </b></p>
        <ul>
          <li><span class="pink">Viber: </span>+372 5113411</li>
          <li><span class="pink">Whatsapp: </span>+372 5113411</li>
          <li><span class="pink">Telegram: </span>+372 5113411</li>
        </ul>
        <p><b class="pink">WhatsApp: </b><a href="{{ $co['whatsapp'] }}" target="_blank" rel="noopener">{{ $locale === 'en' ? 'Message on WhatsApp' : ($locale === 'ru' ? 'Написать в WhatsApp' : 'Kirjuta WhatsAppi') }}</a></p>
        <p><b class="pink">{{ $t['email_label'] }} </b><a href="mailto:{{ $co['email'] }}">{{ $co['email'] }}</a></p>
        <p><b class="pink">Facebook: </b><a href="{{ $co['facebook'] }}">facebook.com/cityee.ee</a></p>
        <p><b class="pink">Instagram: </b><a href="{{ $co['instagram'] }}">cityee_ee</a></p>

        <div style="margin:20px 0;">
          <a href="{{ $co['whatsapp'] }}" target="_blank" rel="noopener" class="btn" style="background:#25D366;border-color:#25D366;">{{ $locale === 'ru' ? 'Написать в WhatsApp' : ($locale === 'en' ? 'Message on WhatsApp' : 'Kirjuta WhatsAppi') }}</a>
          <a href="{{ $co['telegram'] }}" target="_blank" rel="noopener" class="btn" style="background:#0088cc;border-color:#0088cc;margin-left:8px;">Telegram</a>
        </div>

        @include('partials.ai-citation', ['locale' => $locale])

        <h2>{{ $t['map_label'] }}</h2>

        <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2841.693973851092!2d24.74187045400807!3d59.43609556972047!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x469293621d944e45%3A0x531f7293499d42cd!2sViru%20t%C3%A4nav%202%2C%2010140%20Tallinn%2C%20Estonia!5e0!3m2!1sen!2sus!4v1594240713115!5m2!1sen!2sus" width="600" height="450" frameborder="0" style="border:0;" allowfullscreen="" aria-hidden="false" tabindex="0" loading="lazy"></iframe>

      </div>
    </div>
  </div>
</div>

@endsection
