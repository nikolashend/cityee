@extends('layouts.app')

@section('title', 'Abi üürilepingu koostamisel - Teie Kinnisvaramaakler Tallinnas')
@section('description', 'Arvutame üüritootluse ja määrame õige hinna. Teeme professionaalseid fotosid ja käivitame aktiivse massireklaami. Vajadusel konsulteerime Teid huvitavates küsimustes, maksude ja muude kohustuste osas. Kontrollime kliendi andmeid ja dokumentide õigsust.')
@section('keywords', 'Oma kinnisvara üürile andmiseks tuleb täita päringu www.cityee.ee kodulehel, misjärel helistab meie spetsialist Sulle tagasi. Ühendust saab võtta ka e-posti aadressil info@cityee.ee või telefonil ☎ (372) 511-34-11.')
@section('logo_text', 'TEIE KINNISVARAMAAKLER TALLINNAS')
@section('lang_et_url', '/kinnisvara-uur')
@section('lang_ru_url', '/ru/kinnisvara-uur')
@section('footer_class', 'footer--page')

@section('content')

<div class="page-title" style="background: url(/assets/templates/offshors/img/city.jpg) no-repeat; background-position: center top; background-size: cover;">
  <div class="container">
    <h1 class="page-title__name">Kinnisvara üürileandmine</h1>
      <p class="page-title__text">Abi üürilepingu koostamisel</p>
    <p class="page-title__add">
    Potentsiaalse üürilevõtja kontrollimine </p>
      <a href="" id="feedback" class="btn"> Saada päring</a>
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
          <li class="sidebar-menu__item active"><a href="{{ route('et.kinnisvara-uur') }}" title="Abi üürilepingu koostamisel">Kinnisvara üürileandmine</a></li>
          <li class="sidebar-menu__item"><a href="{{ route('et.konsultatsioon') }}" title="Konsulteerimine">Konsultatsioonid</a></li>
          <li class="sidebar-menu__item last"><a href="{{ route('et.kontaktid') }}" title="Kontaktid">Kontaktid</a></li>
        </ul>
      </div>
    </div>
    <div class="col-md-9 col-sm-9">
      <div class="content">
        <p>Enamike inimeste jaoks <strong>kinnisvara üürile andmine</strong> võib tunduda esialgu üsna lihtsa ülesandena, kuid ettenägematute probleemide ja tõrgete vältimiseks peab teadma seadusandlust, taustauuringu läbiviimise tööriistu ja olema inimeste heaks asjatundjaks. Meie spetsialistid aitavad leida Teile usaldusväärse üürniku. Me kontrollime potentsiaalset klienti hoolikalt ja aitame koostada Teile juriidiliselt korrektse lepingu. </p>

        <p>Personaalset hinnapakkumist võib küsida meie konsultantidelt Tallinnas või saata meile päringu.</p>

        <div class="possibilities">
          <h2>ÜÜRNIKU OTSIMISE TEENUS:</h2>
          <ul>
            <li>Arvutame üüritulu</li>
            <li>Õige üürihinna määramine</li>
            <li>Professionaalsed fotod</li>
            <li>Juriidiline konsultatsioon ja dokumentide õigsuse kontrollimine</li>
            <li>Otsime aktiivselt üürnikku</li>
            <li>Konsulteerime maksude ja muude kohustuste osas</li>
            <li>Vajadusel korraldame kinnisvara presentatsiooni ja kõik selleks vajalikud materjalid.</li>
            <li>Teostame kliendi andmete kontrolli</li>
            <li>Teeme koostööd teiste kinnisvara büroodega ja jagame vahendustasu kõigiga, kes toovad meile kliente</li>
          </ul>
        </div>

        <h2>TEENUSE PAKKUMISE HIND</h2>

        <p><i>Üürniku otsimine ja õigesti koostatud üürilepingu allkirjastamine on tavaliselt ühe kuu üüritasu.</i></p>

        <h2 class="text-left">KIRJUTAGE MEILE KOHE! </h2>

        <p class="text-left"><a href="" id="feedback1" class="btn"> SAADA PÄRING</a></p>

      </div>
    </div>
  </div>
</div>

<section class="advantages advantages--page">
  <div class="container">
    <h2 class="advantages__title">Meiega koostöö eelised</h2>
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

<div class="container">
  <article class="about about--page">
    <h2 class="main-h2">CityEE - TEIE KINNISVARA MÜÜGIPARTNER</h2>
    <div class="row">
      <div class="col-xs-12">
        <img  class="about__mobile-img" src="/assets/templates/offshors/img/about-foto-mobile.jpg" alt="">
      </div>
      <div class="col-sm-6 col-xs-12">
        <p>Meie abiga on võimalik müüa kinnisvara või anda üürile kiiresti ja soodsalt, kuna me kasutame kõige tõhusamat strateegiat ja turukanaleid.</p>
        <p>Kinnisvara müügil on väga palju nüansse, alustades turupiirkonna analüüsiga, objekti dokumentatsiooni kontrollimise, õige turunduse ja kanalite valimisega reklaami jaoks, kuni parima krediidilahenduse ja juriidilise konsultatsiooni otsimiseni.</p>
        <p>Parima teenuse garanteerimiseks soovitame sõlmida meiega ainuesinduslepingu.</p>
      </div>
      <div class="col-sm-6 col-xs-12">
        <img  class="about__desctop-img" src="/assets/templates/offshors/img/about-foto.jpg" alt="">
      </div>
    </div>
  </article>
</div>

@endsection
