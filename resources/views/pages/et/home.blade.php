@extends('layouts.app')

@section('title', 'Pealeht - Teie Kinnisvaramaakler Tallinnas')
@section('description', 'Kui soovid müüa oma maja või korterit parima hinnaga, siis CityEE kinnisvaramaakler aitab Sind! Kiire müük ja kvaliteetne teenindus garanteeritud ! Korterite keskmine müügiaeg on 1 kuu | Helista ☎ (372) 511-34-11')
@section('keywords', 'Väga professionaalne ja kiire teenindus. Maaklertasu on vaid 2%. Tasuta kinnisvara hindamine, ainuesinduslepingu sõlmimisel vähemalt 3 kuuks. Pole vaja üle maksta seal, kus pole vajadust. Kontaktnumber ☎ (372) 511-34-11')
@section('logo_text', 'TEIE KINNISVARAMAAKLER TALLINNAS')
@section('lang_et_url', '/')
@section('lang_ru_url', '/ru')

@section('content')

<div class="banners">
  <ul class="banners__list">
    <li class="banners__item">
      <div class="container">
        <div class="banners__wrapp">
          <h1 class="banners__title">KAS SOOVITE OSTA VÕI MÜÜA<span> ANDA OMA KINNISVARA ÜÜRILE?</span></h1>
          <p class="banners__text"><span>Meie spetsialistid aitavad Teid sellega.</span> Professionaalne online konsultatsioon!</p>
          <a href="" id="feedback1" class="btn">SAADA PÄRING</a> <a href="/#spec-link" class="btn btn--spec">Pakkumised</a>
        </div>
      </div>
    </li>
    <li class="banners__item banners__item--tallinn">
      <div class="container">
        <div class="banners__wrapp">
          <h2 class="banners__title">VALIME OPTIMAALSE VARIANDI<span> ASUKOHA JA INFRASTRUKTUURI PÕHJAL</span></h2>
          <p class="banners__text"><span>Kliendi huvide kaitsmine. Kontrollime arendajat, hindame riske!</span></p>
          <a href="" id="feedback2" class="btn">SAADA PÄRING</a> <a href="/#spec-link" class="btn btn--spec">Pakkumised</a>
        </div>
      </div>
    </li>
    <li class="banners__item banners__item--city">
      <div class="container">
        <div class="banners__wrapp">
          <h2 class="banners__title">SÄÄSTKE KORTERI MÜÜGIAEGA 2 KORDA<span>TEIE ISIKLIK MÜÜGIEKSPERT AITAB TEID</span></h2>
          <p class="banners__text"><span>Objekti professionaalne reklaam</span>Kompleksne lähenemisviis teenuste pakkumisele</p>
          <a href="" id="feedback3" class="btn">SAADA PÄRING</a> <a href="/#spec-link" class="btn btn--spec">Pakkumised</a>
        </div>
      </div>
    </li>
  </ul>
  <section class="advantages">
  <div class="container">
    <h2 class="advantages__title">MEIEGA KOOSTÖÖ EELISED</h2>
    <ul class="advantages__list">
      <li class="advantages__item">
        <div class="advantages__img advantages__img--speed"></div>
        <p class="advantages__text">OPERATIIVSELT</p>
      </li>
      <li class="advantages__item">
        <div class="advantages__img advantages__img--availability"></div>
        <p class="advantages__text">KVALITEETSELT</p>
      </li>
      <li class="advantages__item">
        <div class="advantages__img advantages__img--confidentiality"></div>
        <p class="advantages__text">KONFIDENTSIAALSELT</p>
      </li>
      <li class="advantages__item">
        <div class="advantages__img advantages__img--reliability"></div>
        <p class="advantages__text">USALDUSVÄÄRSELT</p>
      </li>
    </ul>
</div>
</section>

  </div>

<div id="spec-link" class="container">
  <section class="offers">
    <h2 class="main-h2">MEIE PAKKUME</h2>
    <div class="offers__wrapp">
      <a href="https://www.kv.ee/?act=search.simple&last_deal_type=1&deal_type=1&search_type=old&keyword=cityee" target="_blank" class="offers__item">
        <h3 class="offers__title">Korterid</h3>
        <div class="offers__img offers__img--polsha"></div>
        <ul class="offers__list">
        </ul>
      </a>
      <a href="https://www.kv.ee/?act=search.simple&last_deal_type=1&deal_type=1&search_type=old&keyword=cityee" target="_blank" class="offers__item">
        <h3 class="offers__title">Majad ja maatükkid</h3>
        <div class="offers__img offers__img--scotland"></div>
        <ul class="offers__list">
        </ul>
      </a>
      <a href="https://www.kv.ee/?act=search.simple&last_deal_type=1&deal_type=1&search_type=old&keyword=cityee" target="_blank" class="offers__item">
        <h3 class="offers__title">Ärihooned</h3>
        <div class="offers__img offers__img--new-zealand"></div>
        <ul class="offers__list">
        </ul>
      </a>
    </div>
    <div class="offers__bonus">
      <p>Sõlmides meiega ainusesinduslepingu, saate oma kinnisvara müügiks maksimaalse reklaamipaketi minimaalse vahendustasuga  <strong>AINULT 2% korteri müügihinnast ! </strong></p>
    </div>
  </section>
</div>


<section class="services">
  <div class="container">
    <h2 class="main-h2">Meie teenused</h2>
    <div class="services__wrapp">
      <a href="{{ route('et.kinnisvara-muuk') }}" class="services__item services__item--offshors">
        <div class="services__img">
        </div>
        <h3 class="services__title">Kinnisvara müük</h3>
        <p class="services__text">Parima müügikanali valimine<br/>Tasuta hinnakonsultatsioon</p>
      </a>
      <a href="{{ route('et.kinnisvara-uur') }}" class="services__item services__item--europe">
      <div class="services__img">
        </div>
        <h3 class="services__title">Kinnisvara üürile andmine</h3>
        <p class="services__text">Usaldusväärse üürniku otsimine<br/>Aitame koostada korrektse lepingu<br/>Konsulteerime maksu ja muude kohustuste osas</p>
      </a>
      <a href="{{ route('et.konsultatsioon') }}" class="services__item services__item--banks">
      <div class="services__img">
      </div>
        <h3 class="services__title">Konsultatsioon</h3>
        <p class="services__text">Ostu-müügitehingute ettevalmistamine<br/>Maksimaalne konfidentsiaalsus</p>
      </a>
    </div>
  </div>
</section>


<div class="container">
  <article class="about">
    <h2 class="main-h2">CityEE - Teie Kinnisvara Müügipartner</h2>
    <div class="row">
      <div class="col-xs-12">
        <img  class="about__mobile-img" src="/assets/templates/offshors/img/about-foto-mobile.jpg" alt="CITY EE — kinnisvaramaakler Tallinnas" loading="lazy" width="600" height="400">
      </div>
      <div class="col-sm-6 col-xs-12">
        <p>Meie abiga on võimalik müüa kinnisvara või anda üürile kiiresti ja soodsalt, kuna me kasutame kõige tõhusamat strateegiat ja turukanaleid.</p>
        <p>Kinnisvara müügil on väga palju nüansse, alustades turupiirkonna analüüsiga, objekti dokumentatsiooni kontrollimise, õige turunduse ja kanalite valimisega reklaami jaoks, kuni parima krediidilahenduse ja juriidilise konsultatsiooni otsimiseni.</p>
        <p>Parima teenuse garanteerimiseks soovitame sõlmida meiega ainuesinduslepingu.</p>
      </div>
      <div class="col-sm-6 col-xs-12">
        <img  class="about__desctop-img" src="/assets/templates/offshors/img/about-foto.jpg" alt="CITY EE — kinnisvaramaakler Tallinnas" loading="lazy" width="555" height="740">
      </div>
    </div>
  </article>
</div>

<h2 class="main-h2">TEHTUD TEHINGUD</h2>

<div class="container">
  <div class="container-slider">
    <div class="square-gallery">
      <div class="popup-gallery">
        <a class="gallery-item services__item lightboxed" rel="group1" href="/assets/kinnisvara/1/main.jpg" data-caption="<div>3-TOALINE KORTER<br>Mahtra tn, Lasnamäe, Tallinn</div>" title="3-TOALINE KORTER" description="Mahtra tn, Lasnamäe, Tallinn" style="background-image:url('/assets/kinnisvara/1/main.jpg');"></a>
      </div>
      <div class="popup-gallery">
        <a class="gallery-item services__item lightboxed" rel="group2" href="/assets/kinnisvara/2/main.jpg" data-caption="<div>2-TOALINE KORTER<br>Pae tn, Lasnamäe, Tallinn</div>" title="2-TOALINE KORTER" description="Pae tn, Lasnamäe, Tallinn" style="background-image:url('/assets/kinnisvara/2/main.jpg');"></a>
      </div>
      <div class="popup-gallery">
        <a class="gallery-item services__item lightboxed" rel="group3" href="/assets/kinnisvara/3/main.jpg" data-caption="<div>2-TOALINE KORTER<br>Linnamäe tee, Lasnamäe, Tallinn</div>" title="2-TOALINE KORTER" description="Linnamäe tee, Lasnamäe, Tallinn" style="background-image:url('/assets/kinnisvara/3/main.jpg');"></a>
      </div>
      <div class="popup-gallery">
        <a class="gallery-item services__item lightboxed" rel="group4" href="/assets/kinnisvara/4/main.jpg" data-caption="<div>2-TOALINE KORTER<br>Vikerlase tn, Lasnamäe, Tallinn</div>" title="2-TOALINE KORTER" description="Vikerlase tn, Lasnamäe, Tallinn" style="background-image:url('/assets/kinnisvara/4/main.jpg');"></a>
      </div>
      <div class="popup-gallery">
        <a class="gallery-item services__item lightboxed" rel="group5" href="/assets/kinnisvara/5/main.jpg" data-caption="<div>3-TOALINE KORTER<br>Punane tn, Lasnamäe, Tallinn</div>" title="3-TOALINE KORTER" description="Punane tn, Lasnamäe, Tallinn" style="background-image:url('/assets/kinnisvara/5/main.jpg');"></a>
      </div>
      <div class="popup-gallery">
        <a class="gallery-item services__item lightboxed" rel="group6" href="/assets/kinnisvara/6/main.jpg" data-caption="<div>2-TOALINE KORTER<br>Stardi tn, Maardu</div>" title="2-TOALINE KORTER" description="Stardi tn, Maardu" style="background-image:url('/assets/kinnisvara/6/main.jpg');"></a>
      </div>
      <div class="popup-gallery">
        <a class="gallery-item services__item lightboxed" rel="group7" href="/assets/kinnisvara/7/main.jpg" data-caption="<div>2-TOALINE KORTER<br>Punane tn 33, Lasnamäe, Tallinn</div>" title="2-TOALINE KORTER" description="Punane tn 33, Lasnamäe, Tallinn" style="background-image:url('/assets/kinnisvara/7/main.jpg');"></a>
      </div>
      <div class="popup-gallery">
        <a class="gallery-item services__item lightboxed" rel="group8" href="/assets/kinnisvara/8/main.jpg" data-caption="<div>2-TOALINE KORTER<br>Asunduse tn 4, Lasnamäe, Tallinn</div>" title="2-TOALINE KORTER" description="Asunduse tn 4, Lasnamäe, Tallinn" style="background-image:url('/assets/kinnisvara/8/main.jpg');"></a>
      </div>
      <div class="popup-gallery">
        <a class="gallery-item services__item lightboxed" rel="group9" href="/assets/kinnisvara/9/main.jpg" data-caption="<div>3-TOALINE KORTER<br>Läänemere tee 9, Lasnamäe, Tallinn</div>" title="3-TOALINE KORTER" description="Läänemere tee 9, Lasnamäe, Tallinn" style="background-image:url('/assets/kinnisvara/9/main.jpg');"></a>
      </div>
    </div>
  </div>
</div>

<div>
  <h2 class="main-h2 bordeless">SOOVID TULEMUST?
    <small style="display: block; text-transform: none; font-size: 17px; margin-bottom: 15px;">Väga professionaalne ja kiire teenindus!</small>
  </h2>
  <div class="text-center" style="margin-bottom: 7px;"><img src="/assets/templates/offshors/img/ap1.png" width="240" height="320" alt="Aleksandr Primakov — maakler CITY EE Tallinn" loading="lazy" /></div>
  <div class="text-center">
    <div style="color:#7b1f45; font-weight: bold;">Aleksandr Primakov</div>
    <div style="color: #777777; margin-bottom: 15px">Maakler | CITYEE Tallinn</div>
    <div style="color:#7b1f45;">+372 511 3411</div>
    <div style="color:#7b1f45; margin-bottom: 15px;">aleksandr@cityee.ee</div>
  </div>
  <div class="text-center"><a class="btn" href="javascript:void(0)" id="feedback">Võta ühendust</a></div>
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
    <h2 class="main-h2">MEIGA KOOSTÖÖ ETAPID</h2>
    <ul class="steps__list">
      <center>
        <li class="steps__item"><p>KONSULTATSIOON</p></li>
        <li class="steps__item"><p>DOKUMENTIDE<br/> ETTEVALMISTAMINE</p></li>
        <li class="steps__item"><p>AKTIIVNE MÜÜK</p></li>
        <li class="steps__item"><p>NOTARITEHING</p></li>
      </center>
    </ul>
  </section>
</div>

<section class="jurisdiction">
  <div class="container">
    <h2 class="main-h2">MEIE TÖÖTAJAD</h2>
    <div class="jurisdiction__wrapp">
      <a href="" class="jurisdiction__item jurisdiction__item--newZealand">
        <h3 class="jurisdiction__title">Aleksandr Primakov</h3>
        <h2 class="jurisdiction__price">Teie isiklik maakler</h2>
        <ul class="jurisdiction__item-list">
          <li>aleksandr@cityee.ee</li>
          <li>tel. +(372) 5113411</li>
        </ul>
      </a>
    </div>
  </div>
</section>

@endsection

@section('footer_class', '')
