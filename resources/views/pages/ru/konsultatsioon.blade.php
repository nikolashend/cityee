@extends('layouts.app')

@section('title', 'Консультирование - Ваш Маклер по Недвижимости в Таллинне')
@section('description', 'CityEE предоставляет консультации по юридическим вопросам в праве финансов и собственности. Оценка недвижимости, помощь в получении кредита, разрешения на строительство. Звоните ☎ (372) 511-34-11')
@section('keywords', 'консультация недвижимость таллинн, оценка недвижимости эстония, юридическая консультация недвижимость')
@section('logo_text', 'ВАШ МАКЛЕР ПО НЕДВИЖИМОСТИ В ТАЛЛИННЕ')
@section('lang_et_url', '/konsultatsioon')
@section('lang_ru_url', '/ru/konsultatsioon')
@section('footer_class', 'footer--page')

@section('content')

<div class="page-title" style="background: url(/assets/templates/offshors/img/banks-bg.jpg) no-repeat; background-position: center top; background-size: cover;">
  <div class="container">
    <h1 class="page-title__name">Консультирование</h1>
      <p class="page-title__text">Kонсультируем при покупке и продаже недвижимости.</p>
      <p class="page-title__text">Определение правильной рыночной цены обьекта.</p>
    <p class="page-title__add">Предоставляем консультации по юридическим вопросам в праве финансов и собственности.</p>
      <a href="" id="feedback" class="btn"> Заказать консультацию</a>
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
          <li class="sidebar-menu__item active"><a href="{{ route('ru.konsultatsioon') }}" title="Консультирование">Kонсультации</a></li>
          <li class="sidebar-menu__item last"><a href="{{ route('ru.kontaktid') }}" title="Маклер Таллинн">Контакты</a></li>
        </ul>
      </div>
    </div>
    <div class="col-md-9 col-sm-9">
      <div class="content">
        <p>Каждая сделка или операция связанная с недвижимостью уникальна, и даже на первый взгляд кажущаяся простой может скрывать как риски, так и возможности.</p>

        <p>Мы комплексно оценим ситуацию и поможем найти правильное решение для клиента. Мы предлагаем лучшие возможности и хеджируем все риски.</p>

        <div class="possibilities">
        <ul>
          <li>Посреднические услуги при купле-продаже недвижимости</li>
          <li>Подбор объектов под заказ для желающего купить объект в Таллинне или за городом.</li>
          <li>Первичная проверка и контроль документации по легализация недвижимости</li>
          <li>Оценка недвижимости Таллинн и Харьюмаа</li>
          <li>Управление процессом получения разрешения на строительство</li>
          <li>Управление процессом получения разрешения на использование недвижимости.</li>
          <li>Юридические консультации в сфере недвижимости.</li>
          <li>Подготовка и составление документации по недвижимости.</li>
          <li>Помощь в получении кредита на покупку недвижимости.</li>
        </ul>
        </div>

        <div class="offers__bonus offers__bonus--bank">
          <p>Первичная юридичская консультация связанная с недвижимостью по телефону или онлайн<strong>- БЕСПЛАТНО!</strong></p>
        </div>

        <h2>Плата за обслуживание</h2>
        <div class="table__wrapp">
          <table>
            <tr>
              <th>Услуги</th>
              <th>Стоимость</th>
            </tr>
            <tr>
              <td>Посредничество в сфере недвижимости</td>
              <td>2-3%</td>
            </tr>
            <tr>
              <td>Подбор объектов под заказ</td>
              <td>200 EUR</td>
            </tr>
            <tr>
              <td>Оценка недвижимости</td>
              <td>300 EUR</td>
            </tr>
            <tr>
              <td>Первичная проверка и контроль документации</td>
              <td>150 EUR</td>
            </tr>
            <tr>
              <td>Получение разрешения на строительство</td>
              <td>1500 EUR</td>
            </tr>
            <tr>
              <td>Получение разрешения на использование</td>
              <td>1500 EUR</td>
            </tr>
          </table>

        <h2 class="text-left">НАПИШИТЕ НАМ СЕЙЧАС! </h2>

        <p class="text-left"><a href="" id="feedback1" class="btn"> ОТПРАВИТЬ ЗАЯВКУ</a></p>

      </div>
    </div>
  </div>
</div>

<section class="advantages advantages--page">
  <div class="container">
    <h2 class="advantages__title">Преимущества работы с нами</h2>
    <ul class="advantages__list">
      <li class="advantages__item">
        <div class="advantages__img advantages__img--speed"></div>
        <p class="advantages__text">Оперативно</p>
      </li>
      <li class="advantages__item">
        <div class="advantages__img advantages__img--availability"></div>
        <p class="advantages__text">Качественно</p>
      </li>
      <li class="advantages__item">
        <div class="advantages__img advantages__img--confidentiality"></div>
        <p class="advantages__text">Конфеденциально</p>
      </li>
      <li class="advantages__item">
        <div class="advantages__img advantages__img--reliability"></div>
        <p class="advantages__text">Надежно</p>
      </li>
    </ul>
</div>
</section>

<div class="container">
  <article class="about about--page">
    <h2 class="main-h2">CityEE - ВАШ РИЭЛТОР-МАКЛЕР НЕДВИЖИМОСТИ В ТАЛЛИННЕ</h2>
    <div class="row">
      <div class="col-xs-12">
        <img  class="about__mobile-img" src="/assets/templates/offshors/img/about-foto-mobile.jpg" alt="CITY EE — консультация" loading="lazy" width="600" height="400">
      </div>
      <div class="col-sm-6 col-xs-12">
        <p>С нашей помощью можно продать или сдать в аренду недвижимость быстро и выгодно, поскольку мы используем самую эффективную стратегию и каналы рынка.</p>
        <p>Продажа недвижимости имеет очень много нюансов, начиная от регионального анализа рынка, проверки документации объекта, правильного маркетинга и выбора каналов для рекламы, до поиска лучшего кредитного решения и юридической консультации.</p>
        <p>Для гарантирования получения наилучшего качества услуги рекомендуем заключить с нами договор об единоличном представительстве.</p>
      </div>
      <div class="col-sm-6 col-xs-12">
        <img  class="about__desctop-img" src="/assets/templates/offshors/img/about-foto.jpg" alt="CITY EE — консультация" loading="lazy" width="555" height="740">
      </div>
    </div>
  </article>
</div>

@endsection
