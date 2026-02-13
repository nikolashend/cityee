@extends('layouts.app')

@section('title', 'Контакты - Маклер Таллинн')
@section('description', 'Контактная информация агенства недвижимости CityEE в Таллинне. Адрес: Viru-väljak 2, Metro Plaza, 3 этаж. Телефон: (+372)5113411. Email: info@cityee.ee')
@section('keywords', 'контакты маклер таллинн, агенство недвижимости таллинн контакты, cityee контакты')
@section('logo_text', 'ВАШ МАКЛЕР ПО НЕДВИЖИМОСТИ В ТАЛЛИННЕ')
@section('lang_et_url', '/kontaktid')
@section('lang_ru_url', '/ru/kontaktid')
@section('footer_class', 'footer--page')

@section('content')

<div class="page-title" style="background: url(/assets/templates/offshors/img/map-bg.jpg) no-repeat; background-position: center bottom; background-size: cover;">
  <div class="container">
      <h1 class="page-title__name">Маклер Таллинн</h1>
  </div>
</div>


<div class="container">
  <div class="row">
    <div class="col-md-3 col-sm-3 text-center">
      <div class="sidebar-menu">
        <strong class="sidebar-menu__title">Услуги</strong>
        <ul class="sidebar-menu__list">
          <li class="sidebar-menu__item first"><a href="{{ route('ru.home') }}" title="Главная">Главная</a></li>
          <li class="sidebar-menu__item"><a href="{{ route('ru.kinnisvara-muuk') }}" title="Надежный маклер в Таллинне">Продать недвижимость</a></li>
          <li class="sidebar-menu__item"><a href="{{ route('ru.kinnisvara-uur') }}" title="Надежный маклер в Таллинне">Сдать недвижимость в аренду</a></li>
          <li class="sidebar-menu__item"><a href="{{ route('ru.konsultatsioon') }}" title="Консультирование">Kонсультации</a></li>
          <li class="sidebar-menu__item last active"><a href="{{ route('ru.kontaktid') }}" title="Маклер Таллинн">Контакты</a></li>
        </ul>
      </div>
    </div>
    <div class="col-md-9 col-sm-9">
      <div class="content">
        <p><b class="pink">Агентство недвижимости: </b>CITY EE OÜ</p>
        <p><b class="pink">Адрес: </b>Viru-väljak 2, Metro Plaza (3 этаж), 10111</p>
        <p><b class="pink">Номер телефона: </b>(+372)5113411</p>
        <p><b class="pink">Телефоны для приложений: </b></p>
        <ul>
          <li><span class="pink">Viber: </span>+372 5113411</li>
          <li><span class="pink">Whatsapp: </span>+372 5113411</li>
          <li><span class="pink">Telegram: </span>+372 5113411</li>
        </ul>
        <p><b class="pink">Skype: </b><a href="skype:aleksander.primakov?call">позвонить в Skype</a></p>
        <p><b class="pink">Email: </b><a href="mailto:info@cityee.ee">info@cityee.ee</a></p>
        <p><b class="pink">Facebook: </b><a href="https://www.facebook.com/cityee.ee">facebook.com/cityee.ee</a></p>
        <p><b class="pink">Instagram: </b><a href="https://www.instagram.com/cityee_ee">cityee_ee</a></p>

        <h2>На карте:</h2>

        <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d1784.4844040948747!2d24.751998131845923!3d59.43758147982005!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x46929360ff21f69d%3A0xfd3309b885a5eb45!2sViru%20v%C3%A4ljak%202%2C%2010111%20Tallinn!5e0!3m2!1sru!2see!4v1585659015045!5m2!1sru!2see" width="100%" height="350" frameborder="0" style="border:0" allowfullscreen></iframe>

      </div>
    </div>
  </div>
</div>

@endsection
