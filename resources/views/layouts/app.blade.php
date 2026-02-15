<!DOCTYPE html>
<html class="no-js" lang="{{ app()->getLocale() == 'ru' ? 'ru' : 'et' }}">
<head>
<meta http-equiv="Content-Type" content="text/html;charset=utf-8" />
<title>@yield('title')</title>
<meta name="description" content="@yield('description')">
<meta name="keywords" content="@yield('keywords', '')">
<link rel="icon" href="/favicon.png" type="image/x-icon"/>
<meta name="viewport" content="width=1000">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="csrf-token" content="{{ csrf_token() }}">
<link href="/assets/templates/offshors/css/style.css?v=4" rel="stylesheet" media="screen">
<link href="/assets/templates/offshors/css/font-awesome.min.css" rel="stylesheet" media="screen">
<link href="/assets/templates/offshors/css/jquery.bxslider.css" rel="stylesheet" media="screen">

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
<script type="text/javascript">
   (function(m,e,t,r,i,k,a){m[i]=m[i]||function(){(m[i].a=m[i].a||[]).push(arguments)};
   m[i].l=1*new Date();k=e.createElement(t),a=e.getElementsByTagName(t)[0],k.async=1,k.src=r,a.parentNode.insertBefore(k,a)})
   (window, document, "script", "https://mc.yandex.ru/metrika/tag.js", "ym");
   ym({{ app()->getLocale() == 'ru' ? '87599735' : '87598929' }}, "init", {
        clickmap:true,
        trackLinks:true,
        accurateTrackBounce:true,
        webvisor:true
   });
</script>
<noscript><div><img src="https://mc.yandex.ru/watch/{{ app()->getLocale() == 'ru' ? '87599735' : '87598929' }}" style="position:absolute; left:-9999px;" alt="" /></div></noscript>
<!-- /Yandex.Metrika counter -->

</head>
<body>

<header class="header">
  <div class="container">

    <div class="header__logo">
      <div class="logo" href="/">
        <div class="logo__img"><img src="/assets/templates/offshors/img/logo.png"></div>
        <span class="logo__text">@yield('logo_text')</span>
        <a class="logo__href" href="{{ app()->getLocale() == 'ru' ? '/ru' : '/' }}"></a>
      </div>
    </div>

    <div class="header__contacts">
      <div class="contacts">
        <p class="contacts__adress">Viru väljak 2<br/> Tallinn, 10111</p>
        <p class="contacts__mail" style="font-size:15px;"><a href="mailto:info@cityee.ee">info@cityee.ee</a></p>
      </div>
    </div>

    <div class="header__phones">
      <div class="phones">
        <div style="text-align:center;"><a href="https://www.city24.ee/{{ app()->getLocale() == 'ru' ? 'ru/' : '' }}company-detail/9898/city-ee-ou" target="blank">City24</a></div>
        <div style="text-align:center;"><a href="https://www.facebook.com/cityee.ee" target="blank">Facebook</a></div>
        <div style="text-align:center;"><a href="https://www.instagram.com/cityee_ee/" target="blank">Instagram</a></div>
        <div style="text-align:center;"><a href="https://www.linkedin.com/in/kinnisvaramaakler/" target="blank">LinkedIn</a></div>
      </div>
    </div>

    <div class="header__main-phone">
      <div class="main-phone">
        <span class="main-phone__item">(+372)5113411 </span>
        <span class="main-phone__time">10.00 {{ app()->getLocale() == 'ru' ? 'до' : 'kuni' }} 22.00</span>
        <a class="main-phone__skype" href="https://wa.me/3725113411" target="_blank">
    {{ app()->getLocale() == 'ru' ? 'позвонить в WhatsApp' : 'helista WhatsApp\'i' }}
</a>
      </div>
      <a href="" class="mini-btn call-back">{{ app()->getLocale() == 'ru' ? 'Заказать звонок' : 'Telli kõne' }}</a>
    </div>

    <div class="header__btn-wrapp">
      <a href="" class="header__mobile-btn header__mobile-btn--adress">{{ app()->getLocale() == 'ru' ? 'Контакты' : 'Kontaktid' }}</a>
      <a href="" class="header__mobile-btn header__mobile-btn--phones">{{ app()->getLocale() == 'ru' ? 'Объекты' : 'Objektid' }}</a>
    </div>

  </div>

  <nav class="nav">
    <div class="container">
      @if(app()->getLocale() == 'ru')
      <ul class="nav__list">
        <li class="nav__item first {{ Route::currentRouteName() == 'ru.home' ? 'active' : '' }}"><a href="{{ route('ru.home') }}" title="Главная">Главная</a></li>
        <li class="nav__item {{ Route::currentRouteName() == 'ru.kinnisvara-muuk' ? 'active' : '' }}"><a href="{{ route('ru.kinnisvara-muuk') }}" title="Надежный маклер в Таллинне">Продать недвижимость</a></li>
        <li class="nav__item {{ Route::currentRouteName() == 'ru.kinnisvara-uur' ? 'active' : '' }}"><a href="{{ route('ru.kinnisvara-uur') }}" title="Надежный маклер в Таллинне">Сдать недвижимость в аренду</a></li>
        <li class="nav__item {{ Route::currentRouteName() == 'ru.konsultatsioon' ? 'active' : '' }}"><a href="{{ route('ru.konsultatsioon') }}" title="Консультирование">Kонсультации</a></li>
        <li class="nav__item last {{ Route::currentRouteName() == 'ru.kontaktid' ? 'active' : '' }}"><a href="{{ route('ru.kontaktid') }}" title="Маклер Таллинн">Контакты</a></li>
      </ul>
      @else
      <ul class="nav__list">
        <li class="nav__item first {{ Route::currentRouteName() == 'et.home' ? 'active' : '' }}"><a href="{{ route('et.home') }}" title="Pealeht">Pealeht</a></li>
        <li class="nav__item {{ Route::currentRouteName() == 'et.kinnisvara-muuk' ? 'active' : '' }}"><a href="{{ route('et.kinnisvara-muuk') }}" title="Kinnisvara müük parima võimaliku hinna ja parima võimaliku ajaga !">Kinnisvara vahendamine</a></li>
        <li class="nav__item {{ Route::currentRouteName() == 'et.kinnisvara-uur' ? 'active' : '' }}"><a href="{{ route('et.kinnisvara-uur') }}" title="Abi üürilepingu koostamisel">Kinnisvara üürileandmine</a></li>
        <li class="nav__item {{ Route::currentRouteName() == 'et.konsultatsioon' ? 'active' : '' }}"><a href="{{ route('et.konsultatsioon') }}" title="Konsulteerimine">Konsultatsioonid</a></li>
        <li class="nav__item last {{ Route::currentRouteName() == 'et.kontaktid' ? 'active' : '' }}"><a href="{{ route('et.kontaktid') }}" title="Kontaktid">Kontaktid</a></li>
      </ul>
      @endif
      <a href="#" class="nav__btn"></a>
      <div class="languages">
        <a href="@yield('lang_et_url', '/')" class="languages__est{{ app()->getLocale() == 'et' ? ' active' : '' }}">
          <span>Est</span>
        </a>
        <a href="@yield('lang_ru_url', '/ru')" class="languages__rus{{ app()->getLocale() == 'ru' ? ' active' : '' }}">
          <span>Rus</span>
        </a>
      </div>
    </div>
  </nav>
</header>

@yield('content')

<footer class="footer @yield('footer_class')">
  <div class="questions">
    <p>{{ app()->getLocale() == 'ru' ? 'У вас есть вопросы? Звоните!' : 'Kas Teil on küsimusi? Helistage!' }} <span>(+372)5113411</span>&nbsp;
    <a href="{{ route(app()->getLocale() == 'ru' ? 'ru.kinnisvara-muuk' : 'et.kinnisvara-muuk') }}" target="_blank" onclick="if(document.location.href.match('kinnisvara-muuk')){$('#feedback').trigger('click'); return false;}"><font color="#fafae6" size="5">&nbsp;&nbsp;{{ app()->getLocale() == 'ru' ? 'Как успешно продать недвижимость?' : 'Kuidas edukalt kinnisvara müüa?' }}</font></a></p>
  </div>
  <div class="container">
    <div class="footer__menu">
      @if(app()->getLocale() == 'ru')
      <ul class="footer__list">
        <li class="first {{ Route::currentRouteName() == 'ru.home' ? 'active' : '' }}"><a href="{{ route('ru.home') }}" title="Главная">Главная</a></li>
        <li class="{{ Route::currentRouteName() == 'ru.kinnisvara-muuk' ? 'active' : '' }}"><a href="{{ route('ru.kinnisvara-muuk') }}" title="Надежный маклер в Таллинне">Продать недвижимость</a></li>
        <li class="{{ Route::currentRouteName() == 'ru.kinnisvara-uur' ? 'active' : '' }}"><a href="{{ route('ru.kinnisvara-uur') }}" title="Надежный маклер в Таллинне">Сдать недвижимость в аренду</a></li>
        <li class="{{ Route::currentRouteName() == 'ru.konsultatsioon' ? 'active' : '' }}"><a href="{{ route('ru.konsultatsioon') }}" title="Консультирование">Kонсультации</a></li>
        <li class="last {{ Route::currentRouteName() == 'ru.kontaktid' ? 'active' : '' }}"><a href="{{ route('ru.kontaktid') }}" title="Маклер Таллинн">Контакты</a></li>
      </ul>
      @else
      <ul class="footer__list">
        <li class="first {{ Route::currentRouteName() == 'et.home' ? 'active' : '' }}"><a href="{{ route('et.home') }}" title="Pealeht">Pealeht</a></li>
        <li class="{{ Route::currentRouteName() == 'et.kinnisvara-muuk' ? 'active' : '' }}"><a href="{{ route('et.kinnisvara-muuk') }}" title="Kinnisvara müük parima võimaliku hinna ja parima võimaliku ajaga !">Kinnisvara vahendamine</a></li>
        <li class="{{ Route::currentRouteName() == 'et.kinnisvara-uur' ? 'active' : '' }}"><a href="{{ route('et.kinnisvara-uur') }}" title="Abi üürilepingu koostamisel">Kinnisvara üürileandmine</a></li>
        <li class="{{ Route::currentRouteName() == 'et.konsultatsioon' ? 'active' : '' }}"><a href="{{ route('et.konsultatsioon') }}" title="Konsulteerimine">Konsultatsioonid</a></li>
        <li class="last {{ Route::currentRouteName() == 'et.kontaktid' ? 'active' : '' }}"><a href="{{ route('et.kontaktid') }}" title="Kontaktid">Kontaktid</a></li>
      </ul>
      @endif
      <ul class="footer__list"></ul>
    </div>

    <div class="footer__contacts">
      <div class="contacts">
        <p class="contacts__adress">Viru väljak 2<br/> Tallinn, 10111</p>
        <p class="contacts__mail" style="font-size:18px;"><a href="mailto:info@cityee.ee">info@cityee.ee</a></p>
        <a href="" class="mini-btn call-back">{{ app()->getLocale() == 'ru' ? 'Заказать звонок' : 'Telli kõne' }}</a>
      </div>
    </div>

    <div class="footer__phones">
      <div class="main-phone">
        <span class="main-phone__item">(+372)5113411</span><br/>
        <a class="main-phone__skype" href="https://wa.me/3725113411" target="_blank">
    {{ app()->getLocale() == 'ru' ? 'позвонить в WhatsApp' : 'helista WhatsApp\'i' }}
</a>
      </div>
      <div class="phones"></div>
    </div>

    <div class="footer__copy">
      <p>
        © CityEE {{ date('Y') }} {{ app()->getLocale() == 'ru' ? 'г. Все права защищены. Бюро по недвижимости / Маклер в Таллинне и Харьюмаа / ПАРТНЕР ПО ОПТИМИЗАЦИИ СДЕЛОК С НЕДВИЖИМОСТЬЮ.' : 'a. Kõik õigused kaitstud. Kinnisvara Büroo / Maakler Tallinnas ja Harjumaal / KINNISVARATEHINGUTE OPTIMEERIMISE PARTNER.' }}
      </p>
    </div>
  </div>

<!-- BEGIN JIVOSITE CODE -->
<script type='text/javascript'>
(function(){ var widget_id = 'aQH4gFFc3a';
var s = document.createElement('script'); s.type = 'text/javascript'; s.async = true; s.src = '//code.jivosite.com/script/widget/'+widget_id; var ss = document.getElementsByTagName('script')[0]; ss.parentNode.insertBefore(s, ss);})();
</script>
<!-- END JIVOSITE CODE -->

</footer>

<div class="backgroundPopup"></div>
<div id="popupContact2" class="pop-up">
<a href="" class="pop-up__close"></a>
<h3>{{ app()->getLocale() == 'ru' ? 'Заказать звонок' : 'Telli kõne' }}</h3>
  <form action="{{ route('contact.callback') }}" method="POST" class="pop-up__form ajax-form">
  @csrf
  <div class="error"></div>
    <input type="text" class="pop-up__input" name="name" placeholder="{{ app()->getLocale() == 'ru' ? 'Ваше имя' : 'Teie nimi' }}">
    <input type="text" class="pop-up__input" name="tel" value="" placeholder="{{ app()->getLocale() == 'ru' ? 'Ваш номер телефона' : 'Teie telefoni number' }}">
    <input type="submit" class="btn" name="submit" value="{{ app()->getLocale() == 'ru' ? 'Отправить' : 'Saada' }}">
    <input type="hidden" name="query_type" value="call">
  </form>
</div>

<div id="popupContact1" class="pop-up">
<a href="" class="pop-up__close"></a>
<h3>{{ app()->getLocale() == 'ru' ? 'ОТПРАВИТЬ ЗАЯВКУ' : 'SAADA PÄRING' }}</h3>
  <form action="{{ route('contact.inquiry') }}" method="POST" class="pop-up__form ajax-form">
  @csrf
  <div class="error"></div>
    <input type="text" class="pop-up__input" name="name" placeholder="{{ app()->getLocale() == 'ru' ? 'Ваше имя' : 'Teie nimi' }}">
    <input type="text" class="pop-up__input" name="tel" value="" placeholder="{{ app()->getLocale() == 'ru' ? 'Ваш номер телефона' : 'Teie telefoni number' }}">
    <input type="text" class="pop-up__input" name="email" value="" placeholder="{{ app()->getLocale() == 'ru' ? 'Ваш email' : 'Teie email' }}">
    <textarea rows="4" class="pop-up__input" name="comment" value="" placeholder="{{ app()->getLocale() == 'ru' ? 'Ваш комментарий' : 'Teie komentaar' }}"></textarea>
    <input type="submit" class="btn" name="submit" value="{{ app()->getLocale() == 'ru' ? 'Отправить' : 'Saada' }}">
    <input type="hidden" name="query_type" value="buy_kompany">
    <p></p>
    <p><a href="{{ route(app()->getLocale() == 'ru' ? 'ru.kinnisvara-muuk' : 'et.kinnisvara-muuk') }}" target="_blank"><font size="4"> {{ app()->getLocale() == 'ru' ? 'Как успешно продать недвижимость' : 'Kuidas edukalt kinnisvara müüa' }}</font></a></p>
  </form>
</div>

<script src="//ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
<script>window.jQuery || document.write('<script src="/js/jquery.2.1.3.min.js"><\/script>')</script>
<script src="/assets/templates/offshors/js/main.js?v=2"></script>
<script src="/assets/templates/offshors/js/jquery.bxslider.js"></script>

<link rel="stylesheet" href="/assets/lightboxed/lightboxed.css?v=1.31">
<script src="/assets/lightboxed/lightboxed.js?v=1.1"></script>

<link rel="stylesheet" href="/assets/magnific-popup/magnific-popup.css">
<script src="/assets/magnific-popup/jquery.magnific-popup.js"></script>
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
