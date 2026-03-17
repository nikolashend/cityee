<!DOCTYPE html>
<?php
    $locale = $locale ?? app()->getLocale();
    $ui     = $ui ?? config("cityee.ui.{$locale}", []);
    $nav    = $nav ?? config("cityee.nav.{$locale}", []);
    $co     = config('cityee.company');
    $agent  = config('cityee.agent');
    $metrikaId = config("cityee.metrika.{$locale}", '87598929');
    $pageKey = $pageKey ?? 'home';
    $langMap = ['et' => 'et', 'ru' => 'ru', 'en' => 'en'];
    $pageTypeMap = [
        'home' => 'homepage',
        'sell' => 'service', 'rent' => 'service', 'consultation' => 'service', 'audit' => 'service',
        'contacts' => 'contacts',
        'guides_index' => 'blog', 'guides_show' => 'blog',
        'audits_index' => 'blog', 'audits_show' => 'blog',
        'knowledge' => 'blog',
        // Phase 4 intent pages
        'no_calls' => 'intent', 'no_offers' => 'intent', 'price_analysis' => 'intent',
        'mistakes' => 'intent', 'sell_faster' => 'intent', 'listing_audit' => 'intent',
        'comparison' => 'intent',
        // Phase 5 pillar guides + cases
        'pillar' => 'guide', 'cases' => 'cases',
    ];
    $dlPageType = $pageTypeMap[$pageKey] ?? 'other';
?>
<html class="no-js" lang="<?php echo e($locale); ?>">
<head>
<meta http-equiv="Content-Type" content="text/html;charset=utf-8" />
<title><?php echo $__env->yieldContent('title'); ?></title>
<meta name="description" content="<?php echo $__env->yieldContent('description'); ?>">
<meta name="keywords" content="<?php echo $__env->yieldContent('keywords', ''); ?>">
<link rel="icon" href="/favicon.png" type="image/x-icon"/>
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="theme-color" content="#7b1f45">
<meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">


<script>document.documentElement.className+=' '+((function(){var e=document.createElement('canvas');return e.toDataURL&&e.toDataURL('image/webp').indexOf('data:image/webp')===0})()?"webp":"no-webp")</script>


<link rel="preconnect" href="https://ajax.googleapis.com" crossorigin>
<link rel="preconnect" href="https://mc.yandex.ru" crossorigin>
<link rel="preconnect" href="https://www.googletagmanager.com" crossorigin>
<link rel="dns-prefetch" href="https://code.jivosite.com">



<link rel="preload" href="/assets/templates/offshors/img/banner-mans.webp" as="image" type="image/webp" fetchpriority="high">


<link rel="preload" href="/assets/templates/offshors/fonts/PTSansNarrow-Bold.woff2" as="font" type="font/woff2" crossorigin>
<link rel="preload" href="/assets/templates/offshors/fonts/PTSansNarrow-Regular.woff2" as="font" type="font/woff2" crossorigin>


<?php if(!empty($canonicalUrl)): ?>
<link rel="canonical" href="<?php echo e($canonicalUrl); ?>">
<?php if(!empty($hreflangLinks)): ?>
<?php $__currentLoopData = $hreflangLinks; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $alt): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
<link rel="alternate" hreflang="<?php echo e($alt['hreflang']); ?>" href="<?php echo e($alt['href']); ?>">
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
<?php endif; ?>
<?php elseif(isset($pageKey)): ?>
<link rel="canonical" href="<?php echo e(\App\Support\SeoLinks::canonical($pageKey)); ?>">
<?php $__currentLoopData = \App\Support\SeoLinks::hreflang($pageKey); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $alt): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
<link rel="alternate" hreflang="<?php echo e($alt['hreflang']); ?>" href="<?php echo e($alt['href']); ?>">
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
<?php endif; ?>


<meta property="og:site_name" content="CityEE">
<meta property="og:title" content="<?php echo $__env->yieldContent('title'); ?>">
<meta property="og:description" content="<?php echo $__env->yieldContent('description'); ?>">
<meta property="og:type" content="website">
<?php if(!empty($canonicalUrl)): ?>
<meta property="og:url" content="<?php echo e($canonicalUrl); ?>">
<?php elseif(isset($pageKey)): ?>
<meta property="og:url" content="<?php echo e(\App\Support\SeoLinks::canonical($pageKey)); ?>">
<?php endif; ?>
<meta property="og:image" content="https://cityee.ee/assets/templates/offshors/img/about-foto.jpg">
<meta property="og:locale" content="<?php echo e($locale === 'ru' ? 'ru_EE' : ($locale === 'en' ? 'en_US' : 'et_EE')); ?>">


<?php echo \App\Support\Schema::webSiteJsonLd(); ?>



<style>
/* Core layout — prevent layout shift */
*,*::before,*::after{box-sizing:border-box}
body{margin:0;font-family:'PT Sans Narrow',Arial,Helvetica,sans-serif;-webkit-text-size-adjust:100%}
.container{max-width:1200px;margin:0 auto;padding:0 15px}
img{max-width:100%;height:auto}
/* Hero skeleton — reserve space = prevent CLS */
.banners__item{min-height:786px;padding-top:170px;padding-bottom:310px;background-size:cover;background-position:center top;background-repeat:no-repeat}
.banners__list{list-style:none;padding:0;margin:0}
.banners__wrapp{max-width:800px;margin-top:80px;margin-bottom:40px}
.banners__title{font-weight:700;text-transform:uppercase;font-size:40px;line-height:1;color:#fff}
.banners__text{color:rgba(255,255,255,.9);font-size:18px;line-height:1.5}
/* V3 intent buttons */
.intent-buttons{display:flex;gap:14px;flex-wrap:wrap;margin-top:24px;justify-content:center}
.intent-btn{display:inline-flex;align-items:center;gap:8px;padding:16px 32px;border-radius:8px;font-size:15px;font-weight:700;text-decoration:none;transition:all .25s;border:2px solid transparent;cursor:pointer}
.intent-btn--primary{background:#7b1f45;color:#fff;font-size:16px;padding:18px 36px;box-shadow:0 4px 16px rgba(123,31,69,.25)}
.intent-btn--secondary{background:rgba(255,255,255,.12);color:#fff;border-color:rgba(255,255,255,.5)}
.intent-btn--accent{background:linear-gradient(135deg,#2c3e50,#3a3f47);color:#fff;border:2px solid rgba(123,31,69,.45)}
.hero-trust-line{display:flex;align-items:center;justify-content:center;gap:20px;margin-top:16px;flex-wrap:wrap}
.hero-trust-line__item{font-size:14px;color:rgba(255,255,255,.85);display:flex;align-items:center;gap:6px}
.hero-trust-line__divider{width:1px;height:16px;background:rgba(255,255,255,.3)}
</style>


<link rel="stylesheet" href="/assets/css/tokens.css?v=6">


<link rel="preload" href="/assets/templates/offshors/css/style.css?v=5" as="style">
<link rel="stylesheet" href="/assets/templates/offshors/css/style.css?v=5">
<link rel="stylesheet" href="/assets/templates/offshors/css/font-awesome.min.css" media="print" onload="this.media='all'">
<noscript><link rel="stylesheet" href="/assets/templates/offshors/css/font-awesome.min.css"></noscript>
<link rel="stylesheet" href="/assets/templates/offshors/css/jquery.bxslider.css" media="print" onload="this.media='all'">
<noscript><link rel="stylesheet" href="/assets/templates/offshors/css/jquery.bxslider.css"></noscript>
<link href="/assets/css/cityee-v3.css?v=5" rel="stylesheet">
<link href="/assets/css/cityee-v3-overrides.css?v=25" rel="stylesheet">


<?php if(in_array($dlPageType, ['intent', 'guide', 'cases', 'blog'])): ?>
<link href="/assets/css/cityee-phase4.css?v=2" rel="stylesheet">
<link href="/assets/css/cityee-phase5-6.css?v=2" rel="stylesheet">
<?php else: ?>
<link href="/assets/css/cityee-phase4.css?v=2" rel="stylesheet" media="print" onload="this.media='all'">
<noscript><link href="/assets/css/cityee-phase4.css?v=2" rel="stylesheet"></noscript>
<link href="/assets/css/cityee-phase5-6.css?v=2" rel="stylesheet" media="print" onload="this.media='all'">
<noscript><link href="/assets/css/cityee-phase5-6.css?v=2" rel="stylesheet"></noscript>
<?php endif; ?>


<?php echo $__env->yieldPushContent('jsonld'); ?>

<!-- Google Tag Manager — async, non-blocking -->
<script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
})(window,document,'script','dataLayer','GTM-5DRRX5ZJ');</script>
<!-- End Google Tag Manager -->


<style>
@font-face{font-family:'PT Sans Narrow';font-style:normal;font-weight:400;font-display:swap;src:url('/assets/templates/offshors/fonts/PTSansNarrow-Regular.woff2') format('woff2')}
@font-face{font-family:'PT Sans Narrow';font-style:normal;font-weight:700;font-display:swap;src:url('/assets/templates/offshors/fonts/PTSansNarrow-Bold.woff2') format('woff2')}
@font-face{font-family:'fontello';font-style:normal;font-weight:400;font-display:swap;src:url('/assets/templates/offshors/fonts/fontello.woff?31919061') format('woff')}
@font-face{font-family:'FontAwesome';font-display:swap;src:url('/assets/templates/offshors/fonts/fontawesome-webfont.woff2?v=4.6.3') format('woff2'),url('/assets/templates/offshors/fonts/fontawesome-webfont.woff?v=4.6.3') format('woff')}
</style>

</head>
<body class="v3" data-page-type="<?php echo e($dlPageType); ?>">
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
        <div class="logo__img"><img src="/assets/templates/offshors/img/logo.png" width="200" height="60" alt="CityEE" decoding="async"></div>
        <span class="logo__text"><?php echo $__env->yieldContent('logo_text', $ui['logo_text'] ?? ''); ?></span>
        <a class="logo__href" href="<?php echo e(route("{$locale}.home")); ?>"></a>
      </div>
    </div>

    <div class="header__contacts">
      <div class="contacts">
        <p class="contacts__adress"><?php echo e($co['address']); ?><br/> <?php echo e($co['city']); ?>, <?php echo e($co['postal_code']); ?></p>
        <p class="contacts__mail" style="font-size:15px;"><a href="mailto:<?php echo e($co['email']); ?>"><?php echo e($co['email']); ?></a></p>
      </div>
    </div>

    <div class="header__phones">
      <div class="phones">
        <div style="text-align:center;"><a href="<?php echo e($co['city24']); ?><?php echo e($locale === 'ru' ? 'ru/' : ''); ?>" target="_blank" rel="noopener">City24</a></div>
        <div style="text-align:center;"><a href="<?php echo e($co['facebook']); ?>" target="_blank" rel="noopener">Facebook</a></div>
        <div style="text-align:center;"><a href="<?php echo e($co['instagram']); ?>" target="_blank" rel="noopener">Instagram</a></div>
        <div style="text-align:center;"><a href="<?php echo e($co['linkedin']); ?>" target="_blank" rel="noopener">LinkedIn</a></div>
      </div>
    </div>

    <div class="header__main-phone">
      <div class="main-phone">
        <a class="main-phone__item" href="tel:<?php echo e($co['phone']); ?>"><?php echo e($co['phone_display']); ?></a>
        <span class="main-phone__time"><?php echo e($ui['hours'] ?? '10.00 kuni 22.00'); ?></span>
        <a class="main-phone__whatsapp" href="<?php echo e($co['whatsapp']); ?>" target="_blank" rel="noopener">
    <?php echo e($ui['call_whatsapp'] ?? "helista WhatsApp'i"); ?>

</a>
      </div>
      <a href="" class="mini-btn call-back"><?php echo e($ui['order_call'] ?? 'Telli kõne'); ?></a>
    </div>

    <div class="header__btn-wrapp">
      <a href="" class="header__mobile-btn header__mobile-btn--adress"><?php echo e($ui['contacts'] ?? 'Kontaktid'); ?></a>
      <a href="" class="header__mobile-btn header__mobile-btn--phones"><?php echo e($ui['objects'] ?? 'Objektid'); ?></a>
    </div>

  </div>

  <nav class="nav" aria-label="<?php echo e($locale === 'ru' ? 'Главное меню' : ($locale === 'en' ? 'Main navigation' : 'Peamine navigatsioon')); ?>">
    <div class="container">
      <ul class="nav__list">
        <?php $__currentLoopData = $nav; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $i => $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
          <?php
              $routeName = "{$locale}.{$item['route']}";
              $classes = 'nav__item';
              if ($i === 0) $classes .= ' first';
              if ($i === count($nav) - 1) $classes .= ' last';
              if (Route::currentRouteName() === $routeName) $classes .= ' active';
          ?>
          <li class="<?php echo e($classes); ?>"><a href="<?php echo e(route($routeName)); ?>" title="<?php echo e($item['title']); ?>"><?php echo e($item['label']); ?></a></li>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
      </ul>
      <a href="#" class="nav__btn"></a>
      <?php
        $langEtRoute = 'et.' . ($pageKey ?? 'home');
        $langRuRoute = 'ru.' . ($pageKey ?? 'home');
        $langEnRoute = 'en.' . ($pageKey ?? 'home');
        $langEtUrl = \Illuminate\Support\Facades\Route::has($langEtRoute) ? route($langEtRoute) : route('et.home');
        $langRuUrl = \Illuminate\Support\Facades\Route::has($langRuRoute) ? route($langRuRoute) : route('ru.home');
        $langEnUrl = \Illuminate\Support\Facades\Route::has($langEnRoute) ? route($langEnRoute) : route('en.home');
      ?>
      <div class="languages">
        <a href="<?php echo $__env->yieldContent('lang_et_url', $langEtUrl); ?>" class="languages__est<?php echo e($locale === 'et' ? ' active' : ''); ?>">
          <span>Est</span>
        </a>
        <a href="<?php echo $__env->yieldContent('lang_ru_url', $langRuUrl); ?>" class="languages__rus<?php echo e($locale === 'ru' ? ' active' : ''); ?>">
          <span>Rus</span>
        </a>
        <a href="<?php echo $__env->yieldContent('lang_en_url', $langEnUrl); ?>" class="languages__eng<?php echo e($locale === 'en' ? ' active' : ''); ?>">
          <span>Eng</span>
        </a>
      </div>
    </div>
  </nav>
</header>

<main id="main-content">
<?php echo $__env->yieldContent('content'); ?>
</main>

<footer class="footer <?php echo $__env->yieldContent('footer_class'); ?>" role="contentinfo">
  <div class="questions">
    <p><?php echo e($ui['questions_call'] ?? 'Kas Teil on küsimusi? Helistage!'); ?> <span><?php echo e($co['phone_display']); ?></span>&nbsp;
    <a href="<?php echo e(route("{$locale}.sell")); ?>" target="_blank" onclick="if(document.location.href.match('kinnisvara-muuk|sell')){$('#feedback').trigger('click'); return false;}"><font color="#fafae6" size="5">&nbsp;&nbsp;<?php echo e($ui['how_sell'] ?? ''); ?></font></a></p>
  </div>
  <div class="container">
    <div class="footer__menu">
      <ul class="footer__list">
        <?php $__currentLoopData = $nav; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $i => $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
          <?php
              $routeName = "{$locale}.{$item['route']}";
              $classes = '';
              if ($i === 0) $classes = 'first';
              if ($i === count($nav) - 1) $classes = 'last';
              if (Route::currentRouteName() === $routeName) $classes .= ' active';
          ?>
          <li class="<?php echo e(trim($classes)); ?>"><a href="<?php echo e(route($routeName)); ?>" title="<?php echo e($item['title']); ?>"><?php echo e($item['label']); ?></a></li>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
      </ul>
      <ul class="footer__list">
        <?php if($locale === 'ru'): ?>
        <li><a href="/ru/makler-v-tallinne/" title="Маклер в Таллине">Маклер в Таллине</a></li>
        <li><a href="/ru/ocenka-kvartiry-v-tallinne/" title="Оценка квартиры">Оценка квартиры</a></li>
        <li><a href="/ru/ne-prodaetsya-kvartira-v-tallinne/" title="Не продаётся квартира?">Не продаётся?</a></li>
        <li><a href="/ru/cases/" title="Кейсы">Кейсы</a></li>
        <li><a href="/ru/tallinn/" title="Районы Таллина">Районы</a></li>
        <li><a href="/ru/aleksandr-primakov/" title="Александр Примаков">Александр Примаков</a></li>
        <?php endif; ?>
      </ul>
    </div>

    <div class="footer__contacts">
      <div class="contacts">
        <p class="contacts__adress"><?php echo e($co['address']); ?><br/> <?php echo e($co['city']); ?>, <?php echo e($co['postal_code']); ?></p>
        <p class="contacts__mail" style="font-size:18px;"><a href="mailto:<?php echo e($co['email']); ?>"><?php echo e($co['email']); ?></a></p>
        <a href="" class="mini-btn call-back"><?php echo e($ui['order_call'] ?? 'Telli kõne'); ?></a>
      </div>
    </div>

    <div class="footer__phones">
      <div class="main-phone">
        <a class="main-phone__item" href="tel:<?php echo e($co['phone']); ?>"><?php echo e($co['phone_display']); ?></a><br/>
        <a class="main-phone__whatsapp" href="<?php echo e($co['whatsapp']); ?>" target="_blank" rel="noopener">
    <?php echo e($ui['call_whatsapp'] ?? "helista WhatsApp'i"); ?>

</a>
        <br/>
        <a class="main-phone__telegram" href="<?php echo e($co['telegram'] ?? 'https://t.me/cityee_tallinn'); ?>" target="_blank" rel="noopener" style="display:inline-flex;align-items:center;gap:4px;color:#0088cc;font-size:14px;font-weight:600;margin-top:4px;">
          <i class="fa fa-telegram" aria-hidden="true"></i> Telegram
        </a>
      </div>
      <div class="phones"></div>
    </div>

    <div class="footer__copy">
      <p>
        © CityEE <?php echo e(date('Y')); ?> <?php echo e($ui['copyright'] ?? ''); ?>

      </p>
      <p style="font-size:12px;color:#999;margin-top:8px;">
        CityEE — Property Sale & Rental Strategy Broker in Tallinn & Harjumaa.
        <?php echo e($co['address']); ?>, <?php echo e($co['city']); ?> <?php echo e($co['postal_code']); ?>, Estonia.
      </p>
    </div>
  </div>

<!-- BEGIN JIVOSITE CODE {lazy — loads on window.load} -->
<script type='text/javascript'>
(function(){ var widget_id = 'aQH4gFFc3a';var d=document;function l(){var s=d.createElement('script');s.type='text/javascript';s.async=true;s.src='//code.jivosite.com/script/widget/'+widget_id;var ss=d.getElementsByTagName('script')[0];ss.parentNode.insertBefore(s,ss);}if(d.readyState==='complete'){l();}else if(window.addEventListener){window.addEventListener('load',l,false);}else if(window.attachEvent){window.attachEvent('onload',l);}})();
</script>
<!-- END JIVOSITE CODE -->

<!-- Yandex.Metrika — deferred to window.load for zero render impact -->
<script type="text/javascript">
window.addEventListener('load', function() {
  (function(m,e,t,r,i,k,a){m[i]=m[i]||function(){(m[i].a=m[i].a||[]).push(arguments)};
  m[i].l=1*new Date();k=e.createElement(t),a=e.getElementsByTagName(t)[0],k.async=1,k.src=r,a.parentNode.insertBefore(k,a)})
  (window, document, "script", "https://mc.yandex.ru/metrika/tag.js", "ym");
  ym(<?php echo e($metrikaId); ?>, "init", {
    clickmap:true,
    trackLinks:true,
    accurateTrackBounce:true,
    webvisor:true
  });
});
</script>
<noscript><div><img src="https://mc.yandex.ru/watch/<?php echo e($metrikaId); ?>" style="position:absolute; left:-9999px;" alt="" /></div></noscript>

</footer>

<?php echo $__env->make('partials.sticky-buttons', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

<div class="backgroundPopup"></div>
<div id="popupContact2" class="pop-up">
<a href="" class="pop-up__close"></a>
<h3><?php echo e($ui['order_call'] ?? 'Telli kõne'); ?></h3>
  <form action="<?php echo e(route('contact.callback')); ?>" method="POST" class="pop-up__form ajax-form">
  <?php echo csrf_field(); ?>
  <div class="error"></div>
    <input type="text" class="pop-up__input" name="name" placeholder="<?php echo e($ui['your_name'] ?? 'Teie nimi'); ?>" aria-label="<?php echo e($ui['your_name'] ?? 'Teie nimi'); ?>" autocomplete="name">
    <input type="tel" class="pop-up__input" name="tel" value="" placeholder="<?php echo e($ui['your_phone'] ?? 'Teie telefoni number'); ?>" aria-label="<?php echo e($ui['your_phone'] ?? 'Teie telefoni number'); ?>" autocomplete="tel">
    <input type="submit" class="btn" name="submit" value="<?php echo e($ui['send'] ?? 'Saada'); ?>">
    <input type="hidden" name="query_type" value="call">
  </form>
</div>

<div id="popupContact1" class="pop-up">
<a href="" class="pop-up__close"></a>
<h3><?php echo e($ui['send_inquiry'] ?? 'SAADA PÄRING'); ?></h3>
  <form action="<?php echo e(route('contact.inquiry')); ?>" method="POST" class="pop-up__form ajax-form">
  <?php echo csrf_field(); ?>
  <div class="error"></div>
    <input type="text" class="pop-up__input" name="name" placeholder="<?php echo e($ui['your_name'] ?? 'Teie nimi'); ?>" aria-label="<?php echo e($ui['your_name'] ?? 'Teie nimi'); ?>" autocomplete="name">
    <input type="tel" class="pop-up__input" name="tel" value="" placeholder="<?php echo e($ui['your_phone'] ?? 'Teie telefoni number'); ?>" aria-label="<?php echo e($ui['your_phone'] ?? 'Teie telefoni number'); ?>" autocomplete="tel">
    <input type="email" class="pop-up__input" name="email" value="" placeholder="<?php echo e($ui['your_email'] ?? 'Teie email'); ?>" aria-label="<?php echo e($ui['your_email'] ?? 'Teie email'); ?>" autocomplete="email">
    <textarea rows="4" class="pop-up__input" name="comment" placeholder="<?php echo e($ui['your_comment'] ?? 'Teie komentaar'); ?>" aria-label="<?php echo e($ui['your_comment'] ?? 'Teie komentaar'); ?>"></textarea>
    <input type="submit" class="btn" name="submit" value="<?php echo e($ui['send'] ?? 'Saada'); ?>">
    <input type="hidden" name="query_type" value="buy_kompany">
    <p></p>
    <p><a href="<?php echo e(route("{$locale}.sell")); ?>" target="_blank"><font size="4"> <?php echo e($ui['how_sell'] ?? ''); ?></font></a></p>
  </form>
</div>

<script src="//ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js" defer></script>
<script src="/assets/templates/offshors/js/main.js?v=3" defer></script>
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

<?php echo $__env->make('partials.datalayer-leads', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
<?php echo $__env->make('partials.sticky-cta', ['locale' => $locale], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
<script>
(function(){var s=document.getElementById('sticky-cta');if(!s)return;var shown=false;window.addEventListener('scroll',function(){if(window.scrollY>600){if(!shown){s.classList.add('sticky-cta--visible');shown=true}}else{if(shown){s.classList.remove('sticky-cta--visible');shown=false}}},{passive:true});})();
</script>
</body>
</html>
<?php /**PATH C:\Users\nikol\Documents\projects\cityee-laravel\resources\views/layouts/app.blade.php ENDPATH**/ ?>