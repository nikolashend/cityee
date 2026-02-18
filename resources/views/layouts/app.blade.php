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

{{-- Preconnect to third-party origins --}}
<link rel="preconnect" href="https://fonts.googleapis.com" crossorigin>
<link rel="preconnect" href="https://ajax.googleapis.com" crossorigin>
<link rel="preconnect" href="https://mc.yandex.ru" crossorigin>
<link rel="preconnect" href="https://www.googletagmanager.com" crossorigin>
<link rel="dns-prefetch" href="https://code.jivosite.com">

{{-- Preload hero image --}}
<link rel="preload" href="/assets/templates/offshors/img/offshors.jpg" as="image" fetchpriority="high">

{{-- Preload critical fonts --}}
<link rel="preload" href="/assets/templates/offshors/fonts/PTSansNarrow-Bold.woff2" as="font" type="font/woff2" crossorigin>
<link rel="preload" href="/assets/templates/offshors/fonts/PTSansNarrow-Regular.woff2" as="font" type="font/woff2" crossorigin>

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
<meta property="og:image" content="https://cityee.ee/assets/templates/offshors/img/about-foto.jpg">
<meta property="og:locale" content="{{ $locale === 'ru' ? 'ru_EE' : ($locale === 'en' ? 'en_US' : 'et_EE') }}">

{{-- Critical CSS inline — above-the-fold rendering --}}
<style>
/* Critical: Reset + Header + Hero + Nav + Banner layout */
*,*::before,*::after{box-sizing:border-box}body{margin:0;font-family:-apple-system,BlinkMacSystemFont,'Segoe UI','PT Sans Narrow',Roboto,sans-serif;-webkit-font-smoothing:antialiased;color:#333;background:#fff}img{max-width:100%;height:auto}a{text-decoration:none;color:inherit}.container{max-width:1200px;margin:0 auto;padding:0 15px}
.header{background:#fff;position:relative;z-index:100}.header .container{display:flex;align-items:center;flex-wrap:wrap;padding:10px 15px}.header__logo{flex:0 0 auto}.logo{display:flex;align-items:center;gap:8px;text-decoration:none}.logo__img img{display:block}.logo__text{font-size:12px;text-transform:uppercase;color:#7b1f45;font-weight:600;letter-spacing:.02em;white-space:nowrap}
.nav{background:#7b1f45}.nav .container{display:flex;align-items:center;justify-content:space-between}.nav__list{display:flex;list-style:none;margin:0;padding:0;flex-wrap:wrap}.nav__item a{display:block;padding:12px 16px;color:#fff;font-size:14px;text-transform:uppercase;letter-spacing:.04em;transition:background .2s}.nav__item a:hover,.nav__item.active a{background:rgba(255,255,255,.15)}
.banners{position:relative;overflow:hidden}.banners__item{position:relative;background-size:cover;background-position:center;min-height:420px;display:flex;align-items:center;color:#fff}.banners__wrapp{position:relative;z-index:2;text-align:center;width:100%}.banners__title{font-size:clamp(28px,4.5vw,52px);font-weight:800;line-height:1.1;letter-spacing:-.02em;text-shadow:0 2px 16px rgba(0,0,0,.2);margin:0 0 12px}.banners__text{font-size:clamp(15px,2vw,18px);line-height:1.5;opacity:.92;max-width:640px;margin:0 auto}
.banners__item::before{content:'';position:absolute;inset:0;background:linear-gradient(135deg,rgba(26,26,26,.55),rgba(26,26,26,.2) 60%,rgba(123,31,69,.15));z-index:1;pointer-events:none}
.intent-buttons{display:flex;gap:14px;flex-wrap:wrap;margin-top:24px;justify-content:center}.intent-btn{display:inline-flex;align-items:center;gap:8px;padding:16px 32px;border-radius:8px;font-size:15px;font-weight:700;text-decoration:none;transition:all .25s;border:2px solid transparent;cursor:pointer}.intent-btn--primary{background:#7b1f45;color:#fff;font-size:16px;padding:18px 36px;box-shadow:0 4px 16px rgba(123,31,69,.25)}.intent-btn--secondary{background:rgba(255,255,255,.12);color:#fff;border-color:rgba(255,255,255,.5)}.intent-btn--accent{background:#25D366;color:#fff}
.hero-trust-line{display:flex;align-items:center;justify-content:center;gap:20px;margin-top:16px;flex-wrap:wrap}.hero-trust-line__item{font-size:14px;color:rgba(255,255,255,.85);display:flex;align-items:center;gap:6px}.hero-trust-line__divider{width:1px;height:16px;background:rgba(255,255,255,.3)}
.page-title{position:relative;background-size:cover;background-position:center;min-height:260px;display:flex;align-items:center;color:#fff}.page-title::before{content:'';position:absolute;inset:0;background:linear-gradient(135deg,rgba(26,26,26,.55),rgba(26,26,26,.25));z-index:0;pointer-events:none}.page-title .container{position:relative;z-index:1}.page-title__name{font-size:clamp(28px,4.5vw,52px);font-weight:800;line-height:1.1;margin:0 0 12px}.page-title__text{font-size:clamp(15px,2vw,18px);opacity:.92;max-width:640px}
.languages{display:flex;gap:4px}.languages a{padding:4px 10px;border-radius:4px;font-size:13px;color:rgba(255,255,255,.7)}.languages a.active{background:rgba(255,255,255,.2);color:#fff}
@media(max-width:768px){.header .container{flex-direction:column;align-items:flex-start}.nav__list{flex-direction:column;width:100%}.banners__title{font-size:24px!important}.intent-buttons{flex-direction:column;align-items:stretch}.intent-btn{justify-content:center;width:100%}}
</style>

{{-- Non-critical CSS — deferred loading --}}
<link rel="stylesheet" href="/assets/templates/offshors/css/style.css?v=4" media="print" onload="this.media='all'">
<noscript><link rel="stylesheet" href="/assets/templates/offshors/css/style.css?v=4"></noscript>
<link rel="stylesheet" href="/assets/templates/offshors/css/font-awesome.min.css" media="print" onload="this.media='all'">
<noscript><link rel="stylesheet" href="/assets/templates/offshors/css/font-awesome.min.css"></noscript>
<link rel="stylesheet" href="/assets/templates/offshors/css/jquery.bxslider.css" media="print" onload="this.media='all'">
<noscript><link rel="stylesheet" href="/assets/templates/offshors/css/jquery.bxslider.css"></noscript>
<link href="/assets/css/cityee-v3.css?v=4" rel="stylesheet">

{{-- JSON-LD --}}
@stack('jsonld')

<!-- Google Tag Manager -->
<script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
})(window,document,'script','dataLayer','GTM-5DRRX5ZJ');</script>
<!-- End Google Tag Manager -->

{{-- GTM noscript moved to body --}}

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

{{-- Font display:swap for all custom fonts --}}
<style>
@font-face{font-family:'PT Sans Narrow';font-style:normal;font-weight:400;font-display:swap;src:url('/assets/templates/offshors/fonts/PTSansNarrow-Regular.woff2') format('woff2')}
@font-face{font-family:'PT Sans Narrow';font-style:normal;font-weight:700;font-display:swap;src:url('/assets/templates/offshors/fonts/PTSansNarrow-Bold.woff2') format('woff2')}
@font-face{font-family:'fontello';font-style:normal;font-weight:400;font-display:swap;src:url('/assets/templates/offshors/fonts/fontello.woff?31919061') format('woff')}
</style>

</head>
<body>
<!-- Skip to content link for accessibility -->
<a href="#main-content" class="sr-only" style="position:absolute;left:-9999px;top:auto;width:1px;height:1px;overflow:hidden;">Skip to content</a>
<!-- Google Tag Manager (noscript) -->
<noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-5DRRX5ZJ"
height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
<!-- End Google Tag Manager (noscript) -->

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
        <a class="main-phone__whatsapp" href="{{ $co['whatsapp'] }}" target="_blank" rel="noopener">
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

  <nav class="nav" aria-label="{{ $locale === 'ru' ? 'Главное меню' : ($locale === 'en' ? 'Main navigation' : 'Peamine navigatsioon') }}">
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

<main id="main-content">
@yield('content')
</main>

<footer class="footer @yield('footer_class')" role="contentinfo">>
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
        <a class="main-phone__whatsapp" href="{{ $co['whatsapp'] }}" target="_blank" rel="noopener">
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

<script src="//ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js" defer></script>
<script>window.jQuery || document.write('<script src="/js/jquery.2.1.3.min.js" defer><\/script>')</script>
<script src="/assets/templates/offshors/js/main.js?v=2" defer></script>
<script src="/assets/templates/offshors/js/jquery.bxslider.js" defer></script>

<link rel="stylesheet" href="/assets/lightboxed/lightboxed.css?v=1.31" media="print" onload="this.media='all'">
<noscript><link rel="stylesheet" href="/assets/lightboxed/lightboxed.css?v=1.31"></noscript>
<script src="/assets/lightboxed/lightboxed.js?v=1.1" defer></script>

<link rel="stylesheet" href="/assets/magnific-popup/magnific-popup.css" media="print" onload="this.media='all'">
<noscript><link rel="stylesheet" href="/assets/magnific-popup/magnific-popup.css"></noscript>
<script src="/assets/magnific-popup/jquery.magnific-popup.js" defer></script>
<script defer>
  document.addEventListener('DOMContentLoaded', function() {
    if (typeof jQuery === 'undefined') return;
    jQuery('.popup-gallery___').each(function() {
      jQuery(this).magnificPopup({
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
            var jdiv = document.querySelector('jdiv');
            if (jdiv) jdiv.style.display = 'none';
          },
          beforeClose: function() {
            var jdiv = document.querySelector('jdiv');
            if (jdiv) jdiv.style.display = 'inline';
          },
        },
      });
    });
  });
</script>

</body>
</html>
