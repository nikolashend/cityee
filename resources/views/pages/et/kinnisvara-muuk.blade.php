@extends('layouts.app')

@section('title', 'Kinnisvara müük parima võimaliku hinna ja parima võimaliku ajaga ! - Teie Kinnisvaramaakler Tallinnas')
@section('description', 'CityEE Kinnisvara pakub kvaliteetset vahendusteenust kinnisvara müümisel - Lühikese ajaga (1-1.5 kuud) ja parima hinnaga. Maakleriteenuste hind ( vahendustasu ) on minimaalne - 2% korteri maksumusest. Pakume professionaalset ja kiiret teenindust Eestis.')
@section('keywords', 'Oma kinnisvara müüki panemiseks tuleb täita www.cityee.ee kodulehel avaldus, misjärel helistab meie spetsialist Sulle tagasi. Samuti saate meiega ühendust võtta meili teel info@cityee.ee või helistades ☎ (372) 511-34-11')
@section('logo_text', 'TEIE KINNISVARAMAAKLER TALLINNAS')
@section('lang_et_url', '/kinnisvara-muuk')
@section('lang_ru_url', '/ru/kinnisvara-muuk')
@section('footer_class', 'footer--page')

@section('content')

<div class="page-title" style="background: url(/assets/templates/offshors/img/offshors.jpg) no-repeat; background-position: center top; background-size: cover;">
  <div class="container">
    <h1 class="page-title__name">Kinnisvara vahendamine</h1>
      <p class="page-title__text">Kinnisvara müük parima võimaliku hinna ja parima võimaliku ajaga !</p>
    <p class="page-title__add">
     </p>
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
          <li class="sidebar-menu__item active"><a href="{{ route('et.kinnisvara-muuk') }}" title="Kinnisvara müük parima võimaliku hinna ja parima võimaliku ajaga !">Kinnisvara vahendamine</a></li>
          <li class="sidebar-menu__item"><a href="{{ route('et.kinnisvara-uur') }}" title="Abi üürilepingu koostamisel">Kinnisvara üürileandmine</a></li>
          <li class="sidebar-menu__item"><a href="{{ route('et.konsultatsioon') }}" title="Konsulteerimine">Konsultatsioonid</a></li>
          <li class="sidebar-menu__item last"><a href="{{ route('et.kontaktid') }}" title="Kontaktid">Kontaktid</a></li>
        </ul>
      </div>
    </div>
    <div class="col-md-9 col-sm-9">
      <div class="content">
        <p>
          <strong>KINNISVARAVAHENDUS</strong>  Kinnisvara müük on sündmus, mis juhtub inimese elus harva, seetõttu parima ja kiirema tulemuse saavutamiseks tasub usaldada see protsess antud valdkonna spetsialistidele. Me aitame leida lahenduse nii era- kui äriklientidele.
        </p>
        <p>
          Personaalse hinnapakkumise võib küsida meie konsultantidelt Tallinnas või saata meile päringu.
        </p>

        <div class="possibilities">
          <h2>MEIE TEENUSE SISU:</h2>
          <ul>
            <li>Objekti kohta vajaliku informatsiooni kogumine, ettevalmistamine</li>
            <li>Õige müügihinna määramine</li>
            <li>Professionaalsed fotod</li>
            <li>Juriidiline konsultatsioon ja dokumentide õigsuse kontrollimine</li>
            <li>Aktiivne müük</li>
            <li>Anname teile regulaarselt müügitegevuse kohta tagasisidet</li>
            <li>Vajadusel korraldame kinnisvara presentatsiooni ja selle jaoks kõik vajalikud materjalid</li>
            <li>Kontrollime tehingu notariaalse tõestamise</li>
            <li>Teeme koostööd teiste maakleritega ja jagame vahendustasu kõigiga, kes toovad meile kliente</li>
          </ul>
        </div>
        
        <h2>TEENUSE PAKKUMISE HINNAD</h2>

        <p><i>Tasu müügi korraldamise eest on kokkuleppeline. Sõltub kinnisvara müügihinnast, asukohast ja teenuse sisust, mida te ootate maaklerilt.</i></p>
        <p><i>Keskmiselt on teenuste hind 2-5 % tehingusummast.</i></p>
        <div class="offers__bonus">
          <p>Sõlmides meiega ainusesinduslepingu, saate oma korteri müügiks maksimaalse reklaamipaketi minimaalse vahendustasuga  <strong>AINULT 2% korteri müügihinnast ! </strong></p>
        </div>

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
