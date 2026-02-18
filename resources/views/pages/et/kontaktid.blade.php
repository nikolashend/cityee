@extends('layouts.app')

@section('title', 'Kontaktid - Teie Kinnisvaramaakler Tallinnas')
@section('description', 'Meil on partnerid Venemaal, Rootsis, Soomes ja Eestis, kes kas ostavad oma raha eest kinnisvara Tallinnas. Keskmiselt 1 kuu on korteri müügiaeg. Meie on üle 120000 kontakti reklaami võrgustikus, Facebook, Instagram, ning City24 ja KV-s oled punases topis.')
@section('keywords', 'Meiega kontakteerimiseks tuleb saata päringu www.cityee.ee kodulehelt, ja meie maakler helistab Teile tagasi. Samuti saate meiega ühendust võtta meili teel info@cityee.ee või helistades ☎ (372) 511-34-11')
@section('logo_text', 'TEIE KINNISVARAMAAKLER TALLINNAS')
@section('lang_et_url', '/kontaktid')
@section('lang_ru_url', '/ru/kontaktid')
@section('footer_class', 'footer--page')

@section('content')

<div class="page-title" style="background: url(/assets/templates/offshors/img/map-bg.jpg) no-repeat; background-position: center bottom; background-size: cover;">
  <div class="container">
      <h1 class="page-title__name">Kontaktid</h1>
  </div>
</div>


<div class="container">
  <div class="row">
    <div class="col-md-3 col-sm-3 text-center">
      <div class="sidebar-menu">
        <strong class="sidebar-menu__title">Teenused</strong>
        <ul class="sidebar-menu__list">
          <li class="sidebar-menu__item first"><a href="{{ route('et.home') }}" title="Pealeht">Pealeht</a></li>
          <li class="sidebar-menu__item"><a href="{{ route('et.kinnisvara-muuk') }}" title="Kinnisvara müük parima võimaliku hinna ja parima võimaliku ajaga !">Kinnisvara vahendamine</a></li>
          <li class="sidebar-menu__item"><a href="{{ route('et.kinnisvara-uur') }}" title="Abi üürilepingu koostamisel">Kinnisvara üürileandmine</a></li>
          <li class="sidebar-menu__item"><a href="{{ route('et.konsultatsioon') }}" title="Konsulteerimine">Konsultatsioonid</a></li>
          <li class="sidebar-menu__item last active"><a href="{{ route('et.kontaktid') }}" title="Kontaktid">Kontaktid</a></li>
        </ul>
      </div>
    </div>
    <div class="col-md-9 col-sm-9">
      <div class="content">
        <p><b class="pink">Kinnisvarabüroo: </b>CITY EE OÜ</p>
        <p><b class="pink">Aadres: </b>Viru-väljak 2, Metro Plaza (3 Korrus), Tallinn, 10111</p>
        <p><b class="pink">Telefoni number: </b>(+372)5113411</p>
        <p><b class="pink">Rakenduste telefonid: </b></p>
        <ul>
          <li><span class="pink">Viber: </span>+372 5113411</li>
          <li><span class="pink">Whatsapp: </span>+372 5113411</li>
          <li><span class="pink">Telegram: </span>+372 5113411</li>
        </ul>
        <p><b class="pink">WhatsApp: </b><a href="https://wa.me/3725113411" target="_blank" rel="noopener">Kirjuta WhatsAppi</a></p>
        <p><b class="pink">Email: </b><a href="mailto:info@cityee.ee">info@cityee.ee</a></p>
        <p><b class="pink">Facebook: </b><a href="https://www.facebook.com/cityee.ee">facebook.com/cityee.ee</a></p>
        <p><b class="pink">Instagram: </b><a href="https://www.instagram.com/cityee_ee">cityee_ee</a></p>

        <h2>Kaardil:</h2>

        <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2841.693973851092!2d24.74187045400807!3d59.43609556972047!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x469293621d944e45%3A0x531f7293499d42cd!2sViru%20t%C3%A4nav%202%2C%2010140%20Tallinn%2C%20Estonia!5e0!3m2!1sen!2sus!4v1594240713115!5m2!1sen!2sus" width="600" height="450" frameborder="0" style="border:0;" allowfullscreen="" aria-hidden="false" tabindex="0"></iframe>

      </div>
    </div>
  </div>
</div>

@endsection
