<!DOCTYPE html>
@php
    $locale = $locale ?? app()->getLocale();
    $ui     = $ui ?? config("cityee.ui.{$locale}", []);
    $nav    = $nav ?? config("cityee.nav.{$locale}", []);
    $co     = config('cityee.company');
    $agent  = config('cityee.agent');
    $metrikaId = config("cityee.metrika.{$locale}", '87598929');
    $pageKey = $pageKey ?? 'home';
    $langMap = ['et' => 'et', 'ru' => 'ru', 'en' => 'en'];
@endphp
<html class="no-js" lang="{{ $locale }}">
<head>
<meta http-equiv="Content-Type" content="text/html;charset=utf-8" />
<title>@yield('title')</title>
<meta name="description" content="@yield('description')">
<meta name="keywords" content="@yield('keywords', '')">
<link rel="icon" href="/favicon.png" type="image/x-icon"/>
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="csrf-token" content="{{ csrf_token() }}">

{{-- Preload critical assets --}}
<link rel="preload" href="/assets/templates/offshors/img/offshors.jpg" as="image">
<link rel="preload" href="/assets/templates/offshors/css/style.css?v=4" as="style">
<link rel="preconnect" href="https://fonts.googleapis.com" crossorigin>
<link rel="preconnect" href="https://ajax.googleapis.com" crossorigin>

{{-- Canonical + Hreflang --}}
@if (isset($pageKey))
<link rel="canonical" href="{{ \App\Support\SeoLinks::canonical($pageKey) }}">
@foreach (\App\Support\SeoLinks::hreflang($pageKey) as $alt)
<link rel="alternate" hreflang="{{ $alt['hreflang'] }}" href="{{ $alt['href'] }}">
@endforeach
@endif

{{-- OG tags --}}
<meta property="og:site_name" content="CityEE">
<meta property="og:title" content="@yield('title')">
<meta property="og:description" content="@yield('description')">
<meta property="og:type" content="website">
@if (isset($pageKey))
<meta property="og:url" content="{{ \App\Support\SeoLinks::canonical($pageKey) }}">
@endif
<meta property="og:image" content="/assets/templates/offshors/img/about-foto.jpg">

<link href="/assets/templates/offshors/css/style.css?v=4" rel="stylesheet" media="screen">
<link href="/assets/templates/offshors/css/font-awesome.min.css" rel="stylesheet" media="screen">
<link href="/assets/templates/offshors/css/jquery.bxslider.css" rel="stylesheet" media="screen">
<link href="/assets/css/cityee-v3.css?v=2" rel="stylesheet" media="screen">

{{-- JSON-LD --}}
@stack('jsonld')

<!-- Google Tag Manager -->
<script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
})(window,document,'script','dataLayer','GTM-5DRRX5ZJ');</script>
<!-- End Google Tag Manager -->

<!-- Google Tag Manager (noscript) -->
<noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-5DRRX5ZJ"
height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
<!-- End Google Tag Manager (noscript) -->

<!-- Yandex.Metrika counter -->
<script type="text/javascript" defer>
   (function(m,e,t,r,i,k,a){m[i]=m[i]||function(){(m[i].a=m[i].a||[]).push(arguments)};
   m[i].l=1*new Date();k=e.createElement(t),a=e.getElementsByTagName(t)[0],k.async=1,k.src=r,a.parentNode.insertBefore(k,a)})
   (window, document, "script", "https://mc.yandex.ru/metrika/tag.js", "ym");
   ym({{ $metrikaId }}, "init", {
        clickmap:true,
        trackLinks:true,
        accurateTrackBounce:true,
        webvisor:true
   });
</script>
<noscript><div><img src="https://mc.yandex.ru/watch/{{ $metrikaId }}" style="position:absolute; left:-9999px;" alt="" /></div></noscript>
<!-- /Yandex.Metrika counter -->

{{-- Font display swap for custom fonts --}}
<style>@font-face{font-display:swap!important}</style>

</head>
<body>

<header class="header">
  <div class="container">

    <div class="header__logo">
      <div class="logo" href="/">
        <div class="logo__img"><img src="/assets/templates/offshors/img/logo.png" width="200" height="60" alt="CityEE"></div>
        <span class="logo__text">@yield('logo_text', $ui['logo_text'] ?? '')</span>
        <a class="logo__href" href="{{ route("{$locale}.home") }}"></a>
      </div>
    </div>

    <div class="header__contacts">
      <div class="contacts">
        <p class="contacts__adress">{{ $co['address'] }}<br/> {{ $co['city'] }}, {{ $co['postal_code'] }}</p>
        <p class="contacts__mail" style="font-size:15px;"><a href="mailto:{{ $co['email'] }}">{{ $co['email'] }}</a></p>
      </div>
    </div>

    <div class="header__phones">
      <div class="phones">
        <div style="text-align:center;"><a href="{{ $co['city24'] }}{{ $locale === 'ru' ? 'ru/' : '' }}" target="blank">City24</a></div>
        <div style="text-align:center;"><a href="{{ $co['facebook'] }}" target="blank">Facebook</a></div>
        <div style="text-align:center;"><a href="{{ $co['instagram'] }}" target="blank">Instagram</a></div>
        <div style="text-align:center;"><a href="{{ $co['linkedin'] }}" target="blank">LinkedIn</a></div>
      </div>
    </div>

    <div class="header__main-phone">
      <div class="main-phone">
        <span class="main-phone__item">{{ $co['phone_display'] }} </span>
        <span class="main-phone__time">{{ $ui['hours'] ?? '10.00 kuni 22.00' }}</span>
        <a class="main-phone__skype" href="{{ $co['whatsapp'] }}" target="_blank">
    {{ $ui['call_whatsapp'] ?? "helista WhatsApp'i" }}
</a>
      </div>
      <a href="" class="mini-btn call-back">{{ $ui['order_call'] ?? 'Telli kõne' }}</a>
    </div>

    <div class="header__btn-wrapp">
      <a href="" class="header__mobile-btn header__mobile-btn--adress">{{ $ui['contacts'] ?? 'Kontaktid' }}</a>
      <a href="" class="header__mobile-btn header__mobile-btn--phones">{{ $ui['objects'] ?? 'Objektid' }}</a>
    </div>

  </div>

  <nav class="nav">
    <div class="container">
      <ul class="nav__list">
        @foreach ($nav as $i => $item)
          @php
              $routeName = "{$locale}.{$item['route']}";
              $classes = 'nav__item';
              if ($i === 0) $classes .= ' first';
              if ($i === count($nav) - 1) $classes .= ' last';
              if (Route::currentRouteName() === $routeName) $classes .= ' active';
          @endphp
          <li class="{{ $classes }}"><a href="{{ route($routeName) }}" title="{{ $item['title'] }}">{{ $item['label'] }}</a></li>
        @endforeach
      </ul>
      <a href="#" class="nav__btn"></a>
      <div class="languages">
        <a href="@yield('lang_et_url', route('et.' . ($pageKey ?? 'home')))" class="languages__est{{ $locale === 'et' ? ' active' : '' }}">
          <span>Est</span>
        </a>
        <a href="@yield('lang_ru_url', route('ru.' . ($pageKey ?? 'home')))" class="languages__rus{{ $locale === 'ru' ? ' active' : '' }}">
          <span>Rus</span>
        </a>
        <a href="@yield('lang_en_url', route('en.' . ($pageKey ?? 'home')))" class="languages__eng{{ $locale === 'en' ? ' active' : '' }}">
          <span>Eng</span>
        </a>
      </div>
    </div>
  </nav>
</header>

@yield('content')

<footer class="footer @yield('footer_class')">
  <div class="questions">
    <p>{{ $ui['questions_call'] ?? 'Kas Teil on küsimusi? Helistage!' }} <span>{{ $co['phone_display'] }}</span>&nbsp;
    <a href="{{ route("{$locale}.sell") }}" target="_blank" onclick="if(document.location.href.match('kinnisvara-muuk|sell')){$('#feedback').trigger('click'); return false;}"><font color="#fafae6" size="5">&nbsp;&nbsp;{{ $ui['how_sell'] ?? '' }}</font></a></p>
  </div>
  <div class="container">
    <div class="footer__menu">
      <ul class="footer__list">
        @foreach ($nav as $i => $item)
          @php
              $routeName = "{$locale}.{$item['route']}";
              $classes = '';
              if ($i === 0) $classes = 'first';
              if ($i === count($nav) - 1) $classes = 'last';
              if (Route::currentRouteName() === $routeName) $classes .= ' active';
          @endphp
          <li class="{{ trim($classes) }}"><a href="{{ route($routeName) }}" title="{{ $item['title'] }}">{{ $item['label'] }}</a></li>
        @endforeach
      </ul>
      <ul class="footer__list"></ul>
    </div>

    <div class="footer__contacts">
      <div class="contacts">
        <p class="contacts__adress">{{ $co['address'] }}<br/> {{ $co['city'] }}, {{ $co['postal_code'] }}</p>
        <p class="contacts__mail" style="font-size:18px;"><a href="mailto:{{ $co['email'] }}">{{ $co['email'] }}</a></p>
        <a href="" class="mini-btn call-back">{{ $ui['order_call'] ?? 'Telli kõne' }}</a>
      </div>
    </div>

    <div class="footer__phones">
      <div class="main-phone">
        <span class="main-phone__item">{{ $co['phone_display'] }}</span><br/>
        <a class="main-phone__skype" href="{{ $co['whatsapp'] }}" target="_blank">
    {{ $ui['call_whatsapp'] ?? "helista WhatsApp'i" }}
</a>
      </div>
      <div class="phones"></div>
    </div>

    <div class="footer__copy">
      <p>
        © CityEE {{ date('Y') }} {{ $ui['copyright'] ?? '' }}
      </p>
      <p style="font-size:12px;color:#999;margin-top:8px;">
        CityEE — Property Sale & Rental Strategy Broker in Tallinn & Harjumaa.
        {{ $co['address'] }}, {{ $co['city'] }} {{ $co['postal_code'] }}, Estonia.
      </p>
    </div>
  </div>

<!-- BEGIN JIVOSITE CODE {lazy} -->
<script type='text/javascript'>
(function(){ var widget_id = 'aQH4gFFc3a';var d=document;function l(){var s=d.createElement('script');s.type='text/javascript';s.async=true;s.src='//code.jivosite.com/script/widget/'+widget_id;var ss=d.getElementsByTagName('script')[0];ss.parentNode.insertBefore(s,ss);}if(d.readyState==='complete'){l();}else if(window.addEventListener){window.addEventListener('load',l,false);}else if(window.attachEvent){window.attachEvent('onload',l);}})();
</script>
<!-- END JIVOSITE CODE -->

</footer>

@include('partials.sticky-buttons')

<div class="backgroundPopup"></div>
<div id="popupContact2" class="pop-up">
<a href="" class="pop-up__close"></a>
<h3>{{ $ui['order_call'] ?? 'Telli kõne' }}</h3>
  <form action="{{ route('contact.callback') }}" method="POST" class="pop-up__form ajax-form">
  @csrf
  <div class="error"></div>
    <input type="text" class="pop-up__input" name="name" placeholder="{{ $ui['your_name'] ?? 'Teie nimi' }}">
    <input type="text" class="pop-up__input" name="tel" value="" placeholder="{{ $ui['your_phone'] ?? 'Teie telefoni number' }}">
    <input type="submit" class="btn" name="submit" value="{{ $ui['send'] ?? 'Saada' }}">
    <input type="hidden" name="query_type" value="call">
  </form>
</div>

<div id="popupContact1" class="pop-up">
<a href="" class="pop-up__close"></a>
<h3>{{ $ui['send_inquiry'] ?? 'SAADA PÄRING' }}</h3>
  <form action="{{ route('contact.inquiry') }}" method="POST" class="pop-up__form ajax-form">
  @csrf
  <div class="error"></div>
    <input type="text" class="pop-up__input" name="name" placeholder="{{ $ui['your_name'] ?? 'Teie nimi' }}">
    <input type="text" class="pop-up__input" name="tel" value="" placeholder="{{ $ui['your_phone'] ?? 'Teie telefoni number' }}">
    <input type="text" class="pop-up__input" name="email" value="" placeholder="{{ $ui['your_email'] ?? 'Teie email' }}">
    <textarea rows="4" class="pop-up__input" name="comment" value="" placeholder="{{ $ui['your_comment'] ?? 'Teie komentaar' }}"></textarea>
    <input type="submit" class="btn" name="submit" value="{{ $ui['send'] ?? 'Saada' }}">
    <input type="hidden" name="query_type" value="buy_kompany">
    <p></p>
    <p><a href="{{ route("{$locale}.sell") }}" target="_blank"><font size="4"> {{ $ui['how_sell'] ?? '' }}</font></a></p>
  </form>
</div>

<script src="//ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
<script>window.jQuery || document.write('<script src="/js/jquery.2.1.3.min.js"><\/script>')</script>
<script src="/assets/templates/offshors/js/main.js?v=2" defer></script>
<script src="/assets/templates/offshors/js/jquery.bxslider.js" defer></script>

<link rel="stylesheet" href="/assets/lightboxed/lightboxed.css?v=1.31" media="print" onload="this.media='all'">
<noscript><link rel="stylesheet" href="/assets/lightboxed/lightboxed.css?v=1.31"></noscript>
<script src="/assets/lightboxed/lightboxed.js?v=1.1" defer></script>

<link rel="stylesheet" href="/assets/magnific-popup/magnific-popup.css" media="print" onload="this.media='all'">
<noscript><link rel="stylesheet" href="/assets/magnific-popup/magnific-popup.css"></noscript>
<script src="/assets/magnific-popup/jquery.magnific-popup.js" defer></script>
<script type="text/javascript">
  $(document).ready(function() {
    $('.popup-gallery___').each(function() {
      $(this).magnificPopup({
        delegate: 'a',
        type: 'image',
        tLoading: 'Loading image #%curr%...',
        mainClass: 'mfp-img-mobile',
        gallery: {
          enabled: true,
          navigateByImgClick: true,
          preload: [0,1]
        },
        image: {
          tError: '<a href="%url%">The image #%curr%</a> could not be loaded.',
          titleSrc: function(item) {
            var url = 'https://' + item.el.attr('url');
            return item.el.attr('title') + '<small>' + item.el.attr('description') + '&nbsp;&nbsp;&nbsp;&nbsp;<a href="' + url + '" target="_blank">' + url + '</a></small>';
          }
        },
        callbacks: {
          beforeOpen: function() {
            $('jdiv:first').css({'display': 'none'});
          },
          beforeClose: function() {
            $('jdiv:first').css({'display': 'inline'});
          },
        },
      });
    });
  });
</script>

</body>
</html>
