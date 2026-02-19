@extends('layouts.app')

@section('title', 'Сдать недвижимость в аренду - Надежный маклер в Таллинне')
@section('description', 'Сдать квартиру в аренду в Таллинне быстро и выгодно. Поиск надежного арендатора в среднем за 10 дней. Проверка арендаторов, составление договора. Звоните ☎ (372) 511-34-11')
@section('keywords', 'сдать квартиру таллинн, аренда квартиры таллинн, маклер аренда таллинн, сдача недвижимости эстония')
@section('logo_text', 'ВАШ МАКЛЕР ПО НЕДВИЖИМОСТИ В ТАЛЛИННЕ')
@section('lang_et_url', '/kinnisvara-uur')
@section('lang_ru_url', '/ru/kinnisvara-uur')
@section('footer_class', 'footer--page')

@section('content')

<div class="page-title" style="background: url(/assets/templates/offshors/img/city.jpg) no-repeat; background-position: center top; background-size: cover;">
  <div class="container">
    <h1 class="page-title__name">Сдать недвижимость в аренду</h1>
      <p class="page-title__text">Надежный маклер в Таллинне</p>
    <p class="page-title__add">
    Сдам вашу квартиру быстро и выгодно! </p>
      <a href="" id="feedback" class="btn"> ОТПРАВИТЬ ЗАЯВКУ</a>
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
          <li class="sidebar-menu__item active"><a href="{{ route('ru.kinnisvara-uur') }}" title="Надежный маклер в Таллинне">Сдать недвижимость в аренду</a></li>
          <li class="sidebar-menu__item"><a href="{{ route('ru.konsultatsioon') }}" title="Консультирование">Kонсультации</a></li>
          <li class="sidebar-menu__item last"><a href="{{ route('ru.kontaktid') }}" title="Маклер Таллинн">Контакты</a></li>
        </ul>
      </div>
    </div>
    <div class="col-md-9 col-sm-9">
      <div class="content">
        <h3><p><strong>Хотите найти надежного арендатора для своей квартиры в Таллинне? </strong></p></h3>Агенство недвижимости CityEE — это профессиональная компания по недвижимости, которая сделает процесс сдачи вашего жилья простым и комфортным.

        <p>Мы предлагаем:</p>

        <h4><p><strong>Квалифицированные маклерские услуги без комиссии для владельца.</strong></p></h4>
        <h4><p><strong>Гарантированный поиск арендатора в среднем за 10 дней.</strong></p></h4>
        <h4><p><strong>Полную помощь на каждом этапе — от проверки арендаторов до составления договора.</strong></p></h4>

        <p>С CityEE вы экономите время, избегаете рисков и доверяете свою квартиру профессионалам. Свяжитесь с нами уже сегодня, и мы найдем надежного арендатора для вашего жилья!</p>

        <div class="possibilities">
          <h2>Почему клиенты выбирают нас?</h2>
          <ul>
            <li>Сдача квартиры в аренду в Таллинне без комиссии для собственника.</li>
            <li>Помощь в поиске арендаторов на длительный срок.</li>
            <li>Определение правильной цены аренды</li>
            <li>Профессиональные фотографии</li>
            <li>Проверка арендаторов, составление договора аренды.</li>
            <li>Маклер в Таллинне, который решит все вопросы по сдаче вашей квартиры.</li>
            <li>Активный поиск арендатора - Обширная рекламная сеть.</li>
            <li>Широкая сеть международных контактов</li>
            <li>Консультируем по налогам и другим обязательствам</li>
            <li>При необходимости, организуем презентацию недвижимости и все необходимые для этого материалы</li>
          </ul>
        </div>
        
        <h2>Как это работает?</h2>

        <p><i>1. Свяжитесь с нами по телефону, электронной почте или  оставьте заявку: заполните форму на нашем сайте и сообщите о своей недвижимости.</i></p>
        <p><i>2. Мы подберем арендаторов: все кандидаты проходят тщательную проверку.</i></p>
        <p><i>3. Составим договор: мы поможем вам заключить юридически корректный договор и передать квартиру.</i></p>

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
    <h2 class="main-h2">CityEE - ВАШ ПАРТНЁР ПО ПРОДАЖЕ НЕДВИЖИМОСТИ</h2>
    <div class="row">
      <div class="col-xs-12">
        <img  class="about__mobile-img" src="/assets/templates/offshors/img/about-foto-mobile.jpg" alt="CITY EE — аренда недвижимости" loading="lazy" width="600" height="400">
      </div>
      <div class="col-sm-6 col-xs-12">
        <p>С нашей помощью можно продать или сдать в аренду недвижимость быстро и выгодно, поскольку мы используем самую эффективную стратегию и каналы рынка.</p>
        <p>Продажа недвижимости имеет очень много нюансов, начиная от регионального анализа рынка, проверки документации объекта, правильного маркетинга и выбора каналов для рекламы, до поиска лучшего кредитного решения и юридической консультации.</p>
        <p>Для гарантирования получения наилучшего качества услуги рекомендуем заключить с нами договор об единоличном представительстве.</p>
      </div>
      <div class="col-sm-6 col-xs-12">
        <img  class="about__desctop-img" src="/assets/templates/offshors/img/about-foto.jpg" alt="CITY EE — аренда недвижимости" loading="lazy" width="555" height="740">
      </div>
    </div>
  </article>
</div>

@endsection
