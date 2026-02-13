@extends('layouts.app')

@section('title', 'Konsulteerimine - Teie Kinnisvaramaakler Tallinnas')
@section('description', 'CityEE kinnisvaravahendaja pakub konsultatsioone finants- ja varaõiguse küsimustes. Leiame Sulle parima kodu Tallinnas või linnast väljas. Teeme kinnisvara legaliseerimiseks esmase kontrolli ja dokumentatsiooni kontrolli.')
@section('keywords', 'Meiega ühenduse võtmiseks tuleb saata päring saidilt www.cityee.ee, misjärel helistab kinnisvaramaakler tagasi. Samuti võite meiega ühendust võtta e-posti aadressil info@cityee.ee või telefonil ☎ (372) 511-34-11.')
@section('logo_text', 'TEIE KINNISVARAMAAKLER TALLINNAS')
@section('lang_et_url', '/konsultatsioon')
@section('lang_ru_url', '/ru/konsultatsioon')
@section('footer_class', 'footer--page')

@section('content')

<div class="page-title" style="background: url(/assets/templates/offshors/img/banks-bg.jpg) no-repeat; background-position: center top; background-size: cover;">
  <div class="container">
    <h1 class="page-title__name">Konsulteerimine</h1>
      <p class="page-title__text">Konsulteerime kinnisvara ostu ja müügi korral.</p>
      <p class="page-title__text">Objekti õige turuhinna määramine.</p>
    <p class="page-title__add">Pakume konsultatsioone finants- ja varaõiguse küsimustes.</p>
      <a href="" id="feedback" class="btn"> Telli konsultatsioon</a>
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
          <li class="sidebar-menu__item active"><a href="{{ route('et.konsultatsioon') }}" title="Konsulteerimine">Konsultatsioonid</a></li>
          <li class="sidebar-menu__item last"><a href="{{ route('et.kontaktid') }}" title="Kontaktid">Kontaktid</a></li>
        </ul>
      </div>
    </div>
    <div class="col-md-9 col-sm-9">
      <div class="content">
        <p>Iga kinnisvaraga seotud tehing või protsess on ainulaadne, mis esmapilgul tundub lihtne, võib varjata nii riske kui ka võimalusi.</p>

        <p>Hindame olukorda kompleksselt ja aitame leida kliendile sobiva lahenduse. Me pakume parimaid võimalusi ja maandame kõiki riske.</p>

        <div class="possibilities">
        <ul>
          <li>Kinnisvara vahendamine</li>
          <li>Objektide valik tellimuse alusel soovijale osta objekt Tallinnas või väljaspool linna.</li>
          <li>Esmane ülevaatus ja kinnisvara legaliseerimise dokumentatsiooni kontroll</li>
          <li>Kinnisvara hindamine Tallinn ja Harjumaa</li>
          <li>Ehitusloa saamise protsessi juhtimine</li>
          <li>Kinnisvara kasutusloa saamise protsessi juhtimine.</li>
          <li>Juriidiline konsultatsioon kinnisvara alal.</li>
          <li>Kinnisvara dokumentatsiooni ettevalmistamine ja koostamine</li>
          <li>Abi kinnisvara ostmiseks laenu saamisel</li>
        </ul>
        </div>

        <div class="offers__bonus offers__bonus--bank">
          <p>Esmane kinnisvaraalane juriidiline konsultatsioon ja nõustamine telefoni teel või online on <strong>- TASUTA!</strong></p>
        </div>

        <h2>Teenuste eest tasumise</h2>
        <div class="table__wrapp">
          <table>
            <tr>
              <th>Teenused</th>
              <th>Hind</th>
            </tr>
            <tr>
              <td>Kinnisvaravahendus</td>
              <td>2-3%</td>
            </tr>
            <tr>
              <td>Objektide valik tellimuse alusel</td>
              <td>200 EUR</td>
            </tr>
            <tr>
              <td>Kinnisvara hindamine</td>
              <td>300 EUR</td>
            </tr>
            <tr>
              <td>Dokumentatsiooni esmane ülevaatus ja kontroll</td>
              <td>150 EUR</td>
            </tr>
            <tr>
              <td>Ehitusloa saamine</td>
              <td>1500 EUR</td>
            </tr>
            <tr>
              <td>Kasutusloa saamine</td>
              <td>1500 EUR</td>
            </tr>
          </table>

        <h2 class="text-left">KIRJUTA MEILE KOHE! </h2>

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
    <h2 class="main-h2">CityEE - TEIE KINNISVARAMAAKLER TALLINNAS</h2>
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
