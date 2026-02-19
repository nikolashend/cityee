@extends('layouts.app')

@section('title', 'Продать недвижимость - Надежный маклер в Таллинне')
@section('description', 'Продажа квартиры в Таллинне быстро и по наилучшей цене. Маклерская комиссия всего 2%. Профессиональная реклама, международная сеть контактов. Звоните ☎ (372) 511-34-11')
@section('keywords', 'продажа квартиры таллинн, маклер таллинн, продать квартиру эстония, недвижимость таллинн продажа')
@section('logo_text', 'ВАШ МАКЛЕР ПО НЕДВИЖИМОСТИ В ТАЛЛИННЕ')
@section('lang_et_url', '/kinnisvara-muuk')
@section('lang_ru_url', '/ru/kinnisvara-muuk')
@section('footer_class', 'footer--page')

@section('content')

<div class="page-title" style="background: url(/assets/templates/offshors/img/offshors.jpg) no-repeat; background-position: center top; background-size: cover;">
  <div class="container">
    <h1 class="page-title__name">Продать недвижимость</h1>
      <p class="page-title__text">Надежный маклер в Таллинне</p>
    <p class="page-title__add">Продажа квартиры быстро и по наилучшей цене!
     </p>
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
          <li class="sidebar-menu__item active"><a href="{{ route('ru.kinnisvara-muuk') }}" title="Надежный маклер в Таллинне">Продать недвижимость</a></li>
          <li class="sidebar-menu__item"><a href="{{ route('ru.kinnisvara-uur') }}" title="Надежный маклер в Таллинне">Сдать недвижимость в аренду</a></li>
          <li class="sidebar-menu__item"><a href="{{ route('ru.konsultatsioon') }}" title="Консультирование">Kонсультации</a></li>
          <li class="sidebar-menu__item last"><a href="{{ route('ru.kontaktid') }}" title="Маклер Таллинн">Контакты</a></li>
        </ul>
      </div>
    </div>
    <div class="col-md-9 col-sm-9">
      <div class="content">
        <h3><p><strong>Продажа квартиры в Таллинне: быстрые и выгодные решения для вас</strong></p></h3> Ищете надежного маклера в Таллинне для продажи квартиры? Мы — профессиональная компания по недвижимости, предлагающая быстрые и выгодные услуги по продаже квартир, домов и другой недвижимости в Таллинне и Харьюмаа. Мы позаботимся обо всех этапах сделки, начиная от рекламы вашей квартиры до оформления документов, и сделаем это с минимальной комиссией всего 2%.
         <p>Мы предлагаем:</p>

         <h4><p><strong>Максимальный рекламный охват и сеть международных контактов.</strong></p></h4>Мы размещаем объявления не только на крупнейших платформах недвижимости в Эстонии (City24, KV.ee), но и используем международные каналы: Прибалтика, Швеция, Финляндия, Санкт-Петербург. Ваша квартира будет в топе на всех крупных платформах, включая рекламу в соцсетях и Google.
         <h4><p><strong>Мы берем все расходы на себя</strong></p></h4>Все расходы, связанные с продажей квартиры, включая фотографа, копирайтера и рекламный бюджет, мы берем на себя. Вы платите только за результат.
         <h4><p><strong>Быстрая продажа квартиры, в среднем за 1 месяц.</strong></p></h4>
Мы гарантируем продажу вашей квартиры в короткие сроки — за счет рекламы на популярных платформах и эффективной работы нашего агентства.
        <p>
          Персональное ценовое предложение можно спросить у наших консультантов в Таллинне или же отослать нам запрос. Свяжитесь с нами уже сегодня, и мы быстро найдем выгодного  покупателя для вашего жилья!
        </p>

        <div class="possibilities">
          <h2>Содержание нашей услуги:</h2>
          <ul>
            <li>Подготовка, сбор необходимой информации по обьекту</li>
            <li>Определение правильной цены продажи</li>
            <li>Профессиональные фотографии</li>
            <li>Юридическая консультация и проверка правильности документов</li>
            <li>Aктивная продажа</li>
            <li>Мы даем вам регулярные отзывы о продаже</li>
            <li>При необходимости, организуем презентацию недвижимости и все необходимые для этого материалы</li>
            <li>Организуем нотариальное оформление сделки</li>
            <li>Сотрудничаем с другими маклерами и делимся посреднической платой со всеми, кто приводит к нам клиентов</li>
          </ul>
        </div>

         <h2>Как это работает?</h2>

        <p><i>1. Заполните заявку на нашем сайте или свяжитесь с нами по телефону.</i></p>
        <p><i>2. Получите бесплатную оценку вашей квартиры и консультацию по продажам.</i></p>
        <p><i>3. Запускаем рекламную кампанию для вашей квартиры и находим вам покупателя.</i></p>
        
        <h2>Цены за оказание услуги</h2>

        <p><i>Плата за организацию продажи является договорной. Зависит от продажной цены недвижимости, местоположения и содержания услуги, которую вы ожидаете от маклера.</i></p>
        <p><i>В среднем цена за услуги составляет 2-5% от суммы сделки.</i></p>
        <div class="offers__bonus">
          <p>Заключив договор на оказание посреднических услуг, Вы получите максимальный рекламный пакет для продажи вашей квартиры с минимальной маклерской комиссией <strong>ВСЕГО 2% от стоимости квартиры ! </strong></p>
        </div>

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
        <img  class="about__mobile-img" src="/assets/templates/offshors/img/about-foto-mobile.jpg" alt="CITY EE — продажа недвижимости" loading="lazy" width="600" height="400">
      </div>
      <div class="col-sm-6 col-xs-12">
        <p>С нашей помощью можно продать или сдать в аренду недвижимость быстро и выгодно, поскольку мы используем самую эффективную стратегию и каналы рынка.</p>
        <p>Продажа недвижимости имеет очень много нюансов, начиная от регионального анализа рынка, проверки документации объекта, правильного маркетинга и выбора каналов для рекламы, до поиска лучшего кредитного решения и юридической консультации.</p>
        <p>Для гарантирования получения наилучшего качества услуги рекомендуем заключить с нами договор об единоличном представительстве.</p>
      </div>
      <div class="col-sm-6 col-xs-12">
        <img  class="about__desctop-img" src="/assets/templates/offshors/img/about-foto.jpg" alt="CITY EE — продажа недвижимости" loading="lazy" width="555" height="740">
      </div>
    </div>
  </article>
</div>

@endsection
