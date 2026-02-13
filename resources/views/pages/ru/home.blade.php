@extends('layouts.app')

@section('title', 'Главная - Ваш Маклер по Недвижимости в Таллинне')
@section('description', 'CityEE - профессиональный маклер по недвижимости в Таллинне. Продажа и аренда квартир, домов. Быстро, качественно, надежно! Звоните ☎ (372) 511-34-11')
@section('keywords', 'маклер таллинн, недвижимость таллинн, продажа квартиры таллинн, аренда квартиры таллинн, риэлтор эстония')
@section('logo_text', 'ВАШ МАКЛЕР ПО НЕДВИЖИМОСТИ В ТАЛЛИННЕ')
@section('lang_et_url', '/')
@section('lang_ru_url', '/ru')

@section('content')

<div class="banners">
  <ul class="banners__list">
    <li class="banners__item">
      <div class="container">
        <div class="banners__wrapp">
          <h1 class="banners__title"> Желаете купить или продать<span>сдать в аренду Вашу недвижимость?</span></h1>
          <p class="banners__text"><span>Наши специалисты помогут Вам в этом.</span> Профессиональная консультация онлайн!</p>
          <a href="" id="feedback1" class="btn">ОТПРАВИТЬ ЗАЯВКУ</a> <a href="/#spec-link" class="btn btn--spec">Предложения</a>
        </div>
      </div>
    </li>
    <li class="banners__item banners__item--tallinn">
      <div class="container">
        <div class="banners__wrapp">
          <h2 class="banners__title"> Подберем оптимальный вариант <span> по местоположению и инфраструктуре</span></h2>
          <p class="banners__text"><span>Защита интересов клиента. Проверим застройщика, оценим риски!</span></p>
          <a href="" id="feedback2" class="btn">ОТПРАВИТЬ ЗАЯВКУ</a> <a href="/#spec-link" class="btn btn--spec">Предложения</a>
        </div>
      </div>
    </li>
    <li class="banners__item banners__item--city">
      <div class="container">
        <div class="banners__wrapp">
          <h2 class="banners__title"> Сэкономьте время продажи квартиры несколько раз <span> Вам поможет Ваш личный эксперт по продаже</span></h2>
          <p class="banners__text"><span>Профессиональная реклама обьекта</span>Комплексный подход к оказанию услуг</p>
          <a href="" id="feedback3" class="btn">ОТПРАВИТЬ ЗАЯВКУ</a> <a href="/#spec-link" class="btn btn--spec">Предложения</a>
        </div>
      </div>
    </li>
  </ul>
  <section class="advantages">
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

  </div>

<div id="spec-link" class="container">
  <section class="offers">
    <h2 class="main-h2">Мы предлагаем</h2>
    <div class="offers__wrapp">
      <a href="https://www.kv.ee/?act=search.simple&last_deal_type=1&deal_type=1&search_type=old&keyword=cityee" target="_blank" class="offers__item">
        <h3 class="offers__title">Квартиры</h3>
        <div class="offers__img offers__img--polsha"></div>
        <ul class="offers__list">
        </ul>
      </a>
      <a href="https://www.kv.ee/?act=search.simple&last_deal_type=1&deal_type=1&search_type=old&keyword=cityee" target="_blank" class="offers__item">
        <h3 class="offers__title">Дома и участки земли</h3>
        <div class="offers__img offers__img--scotland"></div>
        <ul class="offers__list">
        </ul>
      </a>
      <a href="https://www.kv.ee/?act=search.simple&last_deal_type=1&deal_type=1&search_type=old&keyword=cityee" target="_blank" class="offers__item">
        <h3 class="offers__title">Коммерческая недвижимость</h3>
        <div class="offers__img offers__img--new-zealand"></div>
        <ul class="offers__list">
        </ul>
      </a>
    </div>
    <div class="offers__bonus">
      <p>Заключив договор на оказание посреднических услуг, Вы получите максимальный рекламный пакет по продаже вашей недвижимости с минимальной маклерской комиссией <strong>ВСЕГО 2% от стоимости квартиры ! </strong></p>
    </div>
  </section>
</div>


<section class="services">
  <div class="container">
    <h2 class="main-h2">Наши услуги</h2>
    <div class="services__wrapp">
      <a href="{{ route('ru.kinnisvara-muuk') }}" class="services__item services__item--offshors">
        <div class="services__img">
        </div>
        <h3 class="services__title">Услуги по продаже недвижимости</h3>
        <p class="services__text">Выбор лучшего канала продажи<br/>Бесплатная ценовая консультация</p>
      </a>
      <a href="{{ route('ru.kinnisvara-uur') }}" class="services__item services__item--europe">
      <div class="services__img">
        </div>
        <h3 class="services__title">Сдача недвижимости в аренду</h3>
        <p class="services__text">Поиск надежного арендатора<br/>Поможем составить корректный договор<br/>Консультируем по налогам и другим обязательствам</p>
      </a>
      <a href="{{ route('ru.konsultatsioon') }}" class="services__item services__item--banks">
      <div class="services__img">
      </div>
        <h3 class="services__title">Консультирование</h3>
        <p class="services__text">Подготовка сделок купли-продажи<br/>Максимальная конфеденциальность</p>
      </a>
    </div>
  </div>
</section>


<div class="container">
  <article class="about">
    <h2 class="main-h2">CityEE - Ваш Маклер / Риэлтор по продаже недвижимости</h2>
    <div class="row">
      <div class="col-xs-12">
        <img  class="about__mobile-img" src="/assets/templates/offshors/img/about-foto-mobile.jpg" alt="">
      </div>
      <div class="col-sm-6 col-xs-12">
        <p>С нашей помощью можно продать или сдать в аренду недвижимость быстро и выгодно, поскольку мы используем самую эффективную стратегию и каналы рынка.</p>
        <p>Продажа недвижимости имеет очень много нюансов, начиная от регионального анализа рынка, проверки документации объекта, правильного маркетинга и выбора каналов для рекламы, до поиска лучшего кредитного решения и юридической консультации.</p>
        <p>Для гарантирования получения наилучшего качества услуги рекомендуем заключить с нами договор об единоличном представительстве.</p>
      </div>
      <div class="col-sm-6 col-xs-12">
        <img  class="about__desctop-img" src="/assets/templates/offshors/img/about-foto.jpg" alt="">
      </div>
    </div>
  </article>
</div>

<h2 class="main-h2">СОВЕРШЕННЫЕ СДЕЛКИ</h2>

<div class="container">
  <div class="container-slider">
    <div class="square-gallery">
      <div class="popup-gallery">
        <a class="gallery-item services__item lightboxed" rel="group1" href="/assets/kinnisvara/1/main.jpg" data-caption="<div>3-КОМНАТНАЯ КВАРТИРА<br>Махтра, Ласнамяэ, Таллинн</div>" title="3-КОМНАТНАЯ КВАРТИРА" description="Махтра, Ласнамяэ, Таллинн" style="background-image:url('/assets/kinnisvara/1/main.jpg');"></a>
      </div>
      <div class="popup-gallery">
        <a class="gallery-item services__item lightboxed" rel="group2" href="/assets/kinnisvara/2/main.jpg" data-caption="<div>2-КОМНАТНАЯ КВАРТИРА<br>Пае, Ласнамяэ, Таллинн</div>" title="2-КОМНАТНАЯ КВАРТИРА" description="Пае, Ласнамяэ, Таллинн" style="background-image:url('/assets/kinnisvara/2/main.jpg');"></a>
      </div>
      <div class="popup-gallery">
        <a class="gallery-item services__item lightboxed" rel="group3" href="/assets/kinnisvara/3/main.jpg" data-caption="<div>2-КОМНАТНАЯ КВАРТИРА<br>Линнамяэ теэ, Ласнамяэ, Таллинн</div>" title="2-КОМНАТНАЯ КВАРТИРА" description="Линнамяэ теэ, Ласнамяэ, Таллинн" style="background-image:url('/assets/kinnisvara/3/main.jpg');"></a>
      </div>
      <div class="popup-gallery">
        <a class="gallery-item services__item lightboxed" rel="group4" href="/assets/kinnisvara/4/main.jpg" data-caption="<div>2-КОМНАТНАЯ КВАРТИРА<br>Викерласе, Ласнамяэ, Таллинн</div>" title="2-КОМНАТНАЯ КВАРТИРА" description="Викерласе, Ласнамяэ, Таллинн" style="background-image:url('/assets/kinnisvara/4/main.jpg');"></a>
      </div>
      <div class="popup-gallery">
        <a class="gallery-item services__item lightboxed" rel="group5" href="/assets/kinnisvara/5/main.jpg" data-caption="<div>3-КОМНАТНАЯ КВАРТИРА<br>Пунане, Ласнамяэ, Таллинн</div>" title="3-КОМНАТНАЯ КВАРТИРА" description="Пунане, Ласнамяэ, Таллинн" style="background-image:url('/assets/kinnisvara/5/main.jpg');"></a>
      </div>
      <div class="popup-gallery">
        <a class="gallery-item services__item lightboxed" rel="group6" href="/assets/kinnisvara/6/main.jpg" data-caption="<div>2-КОМНАТНАЯ КВАРТИРА<br>Старди, Маарду</div>" title="2-КОМНАТНАЯ КВАРТИРА" description="Старди, Маарду" style="background-image:url('/assets/kinnisvara/6/main.jpg');"></a>
      </div>
      <div class="popup-gallery">
        <a class="gallery-item services__item lightboxed" rel="group7" href="/assets/kinnisvara/7/main.jpg" data-caption="<div>2-КОМНАТНАЯ КВАРТИРА<br>Пунане 33, Ласнамяэ, Таллинн</div>" title="2-КОМНАТНАЯ КВАРТИРА" description="Пунане 33, Ласнамяэ, Таллинн" style="background-image:url('/assets/kinnisvara/7/main.jpg');"></a>
      </div>
      <div class="popup-gallery">
        <a class="gallery-item services__item lightboxed" rel="group8" href="/assets/kinnisvara/8/main.jpg" data-caption="<div>2-КОМНАТНАЯ КВАРТИРА<br>Асундусе 4, Ласнамяэ, Таллинн</div>" title="2-КОМНАТНАЯ КВАРТИРА" description="Асундусе 4, Ласнамяэ, Таллинн" style="background-image:url('/assets/kinnisvara/8/main.jpg');"></a>
      </div>
      <div class="popup-gallery">
        <a class="gallery-item services__item lightboxed" rel="group9" href="/assets/kinnisvara/9/main.jpg" data-caption="<div>3-КОМНАТНАЯ КВАРТИРА<br>Ляэнемере теэ 9, Ласнамяэ, Таллинн</div>" title="3-КОМНАТНАЯ КВАРТИРА" description="Ляэнемере теэ 9, Ласнамяэ, Таллинн" style="background-image:url('/assets/kinnisvara/9/main.jpg');"></a>
      </div>
    </div>
  </div>
</div>

<div>
  <h2 class="main-h2 bordeless">Хотите результат?
    <small style="display: block; text-transform: none; font-size: 17px; margin-bottom: 15px;">Очень профессиональное и быстрое обслуживание!</small>
  </h2>
  <div class="text-center" style="margin-bottom: 7px;"><img src="/assets/templates/offshors/img/ap1.png" width="240" /></div>
  <div class="text-center">
    <div style="color:#7b1f45; font-weight: bold;">Александр Примаков</div>
    <div style="color: #777777; margin-bottom: 15px">Маклер | CITYEE Таллинн</div>
    <div style="color:#7b1f45;">+372 511 3411</div>
    <div style="color:#7b1f45; margin-bottom: 15px;">aleksandr@cityee.ee</div>
  </div>
  <div class="text-center"><a class="btn" href="javascript:void(0)" id="feedback">Связаться</a></div>
</div>

<style type="text/css">
  .main-h2.bordeless {
    margin-bottom: 5px;
  }
  .main-h2.bordeless::after {
    display:none;
  }
  .gallery-item.services__item::before {
    display:none;
  }
  .container-slider {
    padding: 0;
    width: 100%;
    margin: 0 auto;
    display: flex;
    justify-content: center;
  }
  .square-gallery {
    --items: 3;
    --width: 60vw;
    display: grid;
    grid-template-columns: repeat(var(--items), 1fr);
    background: white;
    width: var(--width);
    margin: 0 auto;
  }
  .gallery-item {
    display: flex;
    justify-content: center;
    width: calc(var(--width) / var(--items));
    padding-bottom: calc(var(--width) / var(--items));
    background-color: #ccc;
    background-position: center center;
    background-size: cover;
    background-repeat: no-repeat;
    opacity: 1;
    margin-right: 20px;
    margin-bottom: 20px;
  }
  .gallery-item:hover {
    opacity: 0.7;
  }
  @media only screen and (max-width: 1047px) {
    .container-slider {
      width: calc(70% + 0px);
    }
    .square-gallery {
      --items: 1;
      --width: 70vw;
    }
  }
</style>

<div class="container">
  <section class="steps">
    <h2 class="main-h2">ЭТАПЫ СОТРУДНИЧЕСТВА С НАМИ</h2>
    <ul class="steps__list">
      <center>
        <li class="steps__item"><p>КОНСУЛЬТАЦИЯ</p></li>
        <li class="steps__item"><p>ПОДГОТОВКА<br/> ДОКУМЕНТОВ</p></li>
        <li class="steps__item"><p>АКТИВНАЯ ПРОДАЖА</p></li>
        <li class="steps__item"><p>НОТАРИАЛЬНАЯ СДЕЛКА</p></li>
      </center>
    </ul>
  </section>
</div>

<section class="jurisdiction">
  <div class="container">
    <h2 class="main-h2">НАШИ СОТРУДНИКИ</h2>
    <div class="jurisdiction__wrapp">
      <a href="" class="jurisdiction__item jurisdiction__item--newZealand">
        <h3 class="jurisdiction__title">Александр Примаков</h3>
        <h2 class="jurisdiction__price">Ваш персональный маклер</h2>
        <ul class="jurisdiction__item-list">
          <li>aleksandr@cityee.ee</li>
          <li>тел. +(372) 5113411</li>
        </ul>
      </a>
    </div>
  </div>
</section>

@endsection

@section('footer_class', '')
