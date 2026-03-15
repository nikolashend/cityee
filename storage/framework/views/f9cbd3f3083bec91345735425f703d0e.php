


<?php $__env->startSection('title', $t['meta_title'] ?? ''); ?>
<?php $__env->startSection('description', $t['meta_description'] ?? ''); ?>
<?php $__env->startSection('logo_text', $ui['logo_text'] ?? ''); ?>

<?php $__env->startSection('lang_et_url', route('et.home')); ?>
<?php $__env->startSection('lang_ru_url', route('ru.home')); ?>
<?php $__env->startSection('lang_en_url', route('en.home')); ?>

<?php
    $co    = config('cityee.company');
    $agent = config('cityee.agent');
    $heroTitles = [
        'et' => 'Müüge kinnisvara Tallinnas ja Harjumaal ilma hinnakaduta',
        'ru' => 'Продажа недвижимости в Таллинне и Харьюмаа без потери в цене',
        'en' => 'Sell Property in Tallinn & Harjumaa Without Price Loss',
    ];
    $heroSubs = [
        'et' => 'Strateegia, audit ja läbirääkimised, mis kaitsevad Teie lõplikku summat.',
        'ru' => 'Стратегия, аудит и переговоры, которые защищают вашу финальную сумму.',
        'en' => 'Strategy, audit and negotiation that protect your final amount.',
    ];
    $heroProcess = [
        'et' => 'Audit → Strateegia → Läbirääkimised → Tehing',
        'ru' => 'Аудит → Стратегия → Переговоры → Сделка',
        'en' => 'Audit → Strategy → Negotiation → Deal',
    ];
    $intentBtns = [
        'et' => [
            ['label' => 'Arvuta reaalne turuhind', 'class' => 'intent-btn--primary', 'href' => '#feedback', 'id' => 'feedback'],
            ['label' => 'Telli kuulutuse audit', 'class' => 'intent-btn--secondary', 'href' => route("{$locale}.audit")],
            ['label' => 'Üüri välja turvaliselt', 'class' => 'intent-btn--accent', 'href' => route("{$locale}.rent")],
        ],
        'ru' => [
            ['label' => 'Рассчитать реальную стоимость', 'class' => 'intent-btn--primary', 'href' => '#feedback', 'id' => 'feedback'],
            ['label' => 'Заказать аудит объявления', 'class' => 'intent-btn--secondary', 'href' => route("{$locale}.audit")],
            ['label' => 'Сдать в аренду безопасно', 'class' => 'intent-btn--accent', 'href' => route("{$locale}.rent")],
        ],
        'en' => [
            ['label' => 'Calculate Real Market Value', 'class' => 'intent-btn--primary', 'href' => '#feedback', 'id' => 'feedback'],
            ['label' => 'Get Listing Audit', 'class' => 'intent-btn--secondary', 'href' => route("{$locale}.audit")],
            ['label' => 'Rent Out Safely', 'class' => 'intent-btn--accent', 'href' => route("{$locale}.rent")],
        ],
    ];
    $trustLines = [
        'et' => ['10+ aastat turul', '300+ tehingut', 'Eksklusiivne strateegia'],
        'ru' => ['10+ лет на рынке', '300+ сделок', 'Эксклюзивная стратегия'],
        'en' => ['10+ years on market', '300+ deals', 'Exclusive strategy'],
    ];
?>

<?php $__env->startPush('jsonld'); ?>
<script type="application/ld+json"><?php echo json_encode(\App\Support\Schema::orgJsonLd(), JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT); ?></script>
<script type="application/ld+json"><?php echo json_encode(\App\Support\Schema::personJsonLd(), JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT); ?></script>
<?php echo \App\Support\Schema::speakable(\App\Support\SeoLinks::canonical('home')); ?>

<?php echo \App\Support\JsonLd::breadcrumbs([
    ['name' => $t['h1'] ?? 'Home', 'url' => \App\Support\SeoLinks::canonical('home')],
]); ?>

<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>


<div class="banners">
  <ul class="banners__list">
    <li class="banners__item">
      <div class="container">
        <div class="banners__wrapp">
          <h1 class="banners__title"><?php echo e($heroTitles[$locale] ?? $heroTitles['en']); ?></h1>
          <p class="banners__text"><?php echo e($heroSubs[$locale] ?? $heroSubs['en']); ?><br>
            <small style="font-size:15px;opacity:0.85;"><?php echo e($heroProcess[$locale] ?? $heroProcess['en']); ?></small>
          </p>

          
          <div class="intent-buttons">
            <?php $__currentLoopData = ($intentBtns[$locale] ?? $intentBtns['en']); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $btn): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
              <a href="<?php echo e($btn['href']); ?>" class="intent-btn <?php echo e($btn['class']); ?>" <?php if(!empty($btn['id'])): ?> id="<?php echo e($btn['id']); ?>" <?php endif; ?>>
                <?php echo e($btn['label']); ?>

              </a>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
          </div>

          
          <div class="hero-trust-line">
            <?php $__currentLoopData = ($trustLines[$locale] ?? $trustLines['en']); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $i => $line): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
              <?php if($i > 0): ?><div class="hero-trust-line__divider"></div><?php endif; ?>
              <div class="hero-trust-line__item"><?php echo e($line); ?></div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
          </div>
          <div class="risk-reversal" style="margin-top:12px;">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z"/></svg>
            <span><?php echo e($locale === 'et' ? 'Ilma ettemaksuta. Komisjon ainult tehingu korral.' : ($locale === 'ru' ? 'Без аванса. Комиссия только по факту сделки.' : 'No advance payment. Commission only on successful deal.')); ?></span>
          </div>
        </div>
      </div>
    </li>
    <li class="banners__item banners__item--tallinn">
      <div class="container">
        <div class="banners__wrapp">
          <h2 class="banners__title"><?php echo e($t['banner2_h2']); ?><span> <?php echo e($t['banner2_span']); ?></span></h2>
          <p class="banners__text"><?php echo $t['banner2_text']; ?></p>
          <a href="" id="feedback2" class="btn"><?php echo e($ui['send_inquiry']); ?></a> <a href="" id="feedback2b" class="btn btn--spec"><?php echo e($locale === 'en' ? 'Order Property Review' : ($locale === 'ru' ? 'Заказать разбор объекта' : 'Telli objekti analüüs')); ?></a>
        </div>
      </div>
    </li>
    <li class="banners__item banners__item--city">
      <div class="container">
        <div class="banners__wrapp">
          <h2 class="banners__title"><?php echo e($t['banner3_h2']); ?><span><?php echo e($t['banner3_span']); ?></span></h2>
          <p class="banners__text"><?php echo $t['banner3_text']; ?></p>
          <a href="" id="feedback3" class="btn"><?php echo e($ui['send_inquiry']); ?></a> <a href="" id="feedback3b" class="btn btn--spec"><?php echo e($locale === 'en' ? 'Order Property Review' : ($locale === 'ru' ? 'Заказать разбор объекта' : 'Telli objekti analüüs')); ?></a>
        </div>
      </div>
    </li>
  </ul>

  
  <?php echo $__env->make('partials.trust-metrics', ['locale' => $locale], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

  <section class="advantages">
  <div class="container">
    <h2 class="advantages__title"><?php echo e($t['advantages_title']); ?></h2>
    <ul class="advantages__list">
      <li class="advantages__item">
        <div class="advantages__img advantages__img--speed"></div>
        <p class="advantages__text"><?php echo e($ui['adv_speed']); ?></p>
      </li>
      <li class="advantages__item">
        <div class="advantages__img advantages__img--availability"></div>
        <p class="advantages__text"><?php echo e($ui['adv_quality']); ?></p>
      </li>
      <li class="advantages__item">
        <div class="advantages__img advantages__img--confidentiality"></div>
        <p class="advantages__text"><?php echo e($ui['adv_confid']); ?></p>
      </li>
      <li class="advantages__item">
        <div class="advantages__img advantages__img--reliability"></div>
        <p class="advantages__text"><?php echo e($ui['adv_reliable']); ?></p>
      </li>
    </ul>
</div>
</section>

  </div>


<?php echo $__env->make('partials.trust-layer', ['locale' => $locale], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>


<?php if(!empty($homeJtbd)): ?>
<?php echo $__env->make('components.v3.jtbd', ['v3' => ['jtbd_title' => $homeJtbd['title'], 'jtbd' => $homeJtbd['items']]], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
<?php endif; ?>


<?php echo $__env->make('partials.problem-solution', ['locale' => $locale], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>


<div class="container">
  <?php echo $__env->make('partials.ai-summary', ['locale' => $locale], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
</div>

<div id="spec-link" class="container">
  <section class="offers">
    <h2 class="main-h2"><?php echo e($t['offers_title']); ?></h2>
    <div class="offers__wrapp">
      <a href="https://www.kv.ee/?act=search.simple&last_deal_type=1&deal_type=1&search_type=old&keyword=cityee" target="_blank" class="offers__item">
        <h3 class="offers__title"><?php echo e($t['offers_apartments']); ?></h3>
        <div class="offers__img offers__img--polsha"></div>
        <ul class="offers__list">
        </ul>
      </a>
      <a href="https://www.kv.ee/?act=search.simple&last_deal_type=1&deal_type=1&search_type=old&keyword=cityee" target="_blank" class="offers__item">
        <h3 class="offers__title"><?php echo e($t['offers_houses']); ?></h3>
        <div class="offers__img offers__img--scotland"></div>
        <ul class="offers__list">
        </ul>
      </a>
      <a href="https://www.kv.ee/?act=search.simple&last_deal_type=1&deal_type=1&search_type=old&keyword=cityee" target="_blank" class="offers__item">
        <h3 class="offers__title"><?php echo e($t['offers_commercial']); ?></h3>
        <div class="offers__img offers__img--new-zealand"></div>
        <ul class="offers__list">
        </ul>
      </a>
    </div>
    <div class="offers__bonus">
      <p><?php echo $t['offers_bonus']; ?></p>
    </div>
  </section>
</div>


<section class="services">
  <div class="container">
    <h2 class="main-h2"><?php echo e($t['services_title']); ?></h2>
    <div class="services__wrapp">
      <a href="<?php echo e(route("{$locale}.sell")); ?>" class="services__item services__item--offshors">
        <div class="services__img">
        </div>
        <h3 class="services__title"><?php echo e($t['srv_sell']); ?></h3>
        <p class="services__text"><?php echo $t['srv_sell_desc']; ?></p>
      </a>
      <a href="<?php echo e(route("{$locale}.rent")); ?>" class="services__item services__item--europe">
      <div class="services__img">
        </div>
        <h3 class="services__title"><?php echo e($t['srv_rent']); ?></h3>
        <p class="services__text"><?php echo $t['srv_rent_desc']; ?></p>
      </a>
      <a href="<?php echo e(route("{$locale}.consultation")); ?>" class="services__item services__item--banks">
      <div class="services__img">
      </div>
        <h3 class="services__title"><?php echo e($t['srv_consult']); ?></h3>
        <p class="services__text"><?php echo $t['srv_consult_desc']; ?></p>
      </a>
    </div>
  </div>
</section>


<?php echo $__env->make('partials.about', ['ui' => $ui], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

<h2 class="main-h2"><?php echo e($t['deals_title']); ?></h2>

<div class="container">
  <div class="container-slider">
    <div class="square-gallery">
      <?php for($i = 1; $i <= 9; $i++): ?>
      <div class="popup-gallery">
        <a class="gallery-item services__item lightboxed" rel="group<?php echo e($i); ?>" href="/assets/kinnisvara/<?php echo e($i); ?>/main.jpg" data-caption="" title="" description="" style="background-image:url('/assets/kinnisvara/<?php echo e($i); ?>/main.jpg');"></a>
      </div>
      <?php endfor; ?>
    </div>
  </div>
</div>

<div>
  <h2 class="main-h2 bordeless"><?php echo e($t['result_title']); ?>

    <small style="display: block; text-transform: none; font-size: 17px; margin-bottom: 15px;"><?php echo e($t['result_subtitle']); ?></small>
  </h2>
  <div class="text-center" style="margin-bottom: 7px;"><?php if (isset($component)) { $__componentOriginalb12907cd921e95cd9263783896c04e9f = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalb12907cd921e95cd9263783896c04e9f = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.webp-img','data' => ['src' => '/assets/templates/offshors/img/ap1.png','width' => '240','height' => '320','alt' => $agent['name'] . ' — Real Estate Deal Optimization Partner in Tallinn & Harjumaa']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('webp-img'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['src' => '/assets/templates/offshors/img/ap1.png','width' => '240','height' => '320','alt' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($agent['name'] . ' — Real Estate Deal Optimization Partner in Tallinn & Harjumaa')]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalb12907cd921e95cd9263783896c04e9f)): ?>
<?php $attributes = $__attributesOriginalb12907cd921e95cd9263783896c04e9f; ?>
<?php unset($__attributesOriginalb12907cd921e95cd9263783896c04e9f); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalb12907cd921e95cd9263783896c04e9f)): ?>
<?php $component = $__componentOriginalb12907cd921e95cd9263783896c04e9f; ?>
<?php unset($__componentOriginalb12907cd921e95cd9263783896c04e9f); ?>
<?php endif; ?></div>
  <div class="text-center">
    <div style="color:#7b1f45; font-weight: bold;"><?php echo e($agent['name']); ?></div>
    <div style="color: #777777; margin-bottom: 15px"><?php echo e($t['result_agent_title']); ?> | CITYEE Tallinn</div>
    <div style="color:#7b1f45;"><?php echo e($agent['phone']); ?></div>
    <div style="color:#7b1f45; margin-bottom: 15px;"><?php echo e($agent['email']); ?></div>
  </div>
  <div class="text-center"><a class="btn" href="javascript:void(0)" id="feedback"><?php echo e($t['result_cta']); ?></a></div>
  <div class="risk-reversal" style="margin-top:12px;margin-bottom:20px;">
    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="16" height="16"><path fill="#25D366" d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z"/></svg>
    <span><?php echo e($locale === 'et' ? 'Ilma ettemaksuta. Komisjon ainult tehingu korral.' : ($locale === 'ru' ? 'Без аванса. Комиссия только по факту сделки.' : 'No advance payment. Commission only on successful deal.')); ?></span>
  </div>
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
  <section class="faq-section" style="background:transparent;padding:30px 0;">
    <h2 class="main-h2"><?php echo e($locale === 'et' ? 'Kuidas me määrame hinna?' : ($locale === 'ru' ? 'Как мы определяем цену?' : 'How do we determine the price?')); ?></h2>
    <div class="faq-list">
      <?php
        $pricingFaq = [
          'et' => [
            ['q' => 'Tehingute analüüs', 'a' => 'Uurime piirkonna viimaste kuude tegelikke müügihindu — mitte pakkumishindu, vaid reaalseid tehinguhindu.'],
            ['q' => 'Ostjate käitumine', 'a' => 'Analüüsime, kui palju ostjaid otsib Teie piirkonnas ja millised on nende eelarved ning ootused.'],
            ['q' => 'Läbirääkimisstrateegia', 'a' => 'Kujundame hinnastrateegia nii, et jätame ruumi läbirääkimisteks, kaotamata tegelikku väärtust.'],
            ['q' => 'Müügi tõenäosuse prognoos', 'a' => 'Hindame, milline on müügi tõenäosus 1-3 kuu jooksul antud hinnaga ja turutingimustes.'],
          ],
          'ru' => [
            ['q' => 'Анализ сделок', 'a' => 'Изучаем реальные цены продаж в районе за последние месяцы — не цены объявлений, а реальные цены сделок.'],
            ['q' => 'Поведение покупателей', 'a' => 'Анализируем сколько покупателей ищет в вашем районе, их бюджеты и ожидания.'],
            ['q' => 'Переговорная стратегия', 'a' => 'Формируем ценовую стратегию так, чтобы оставить пространство для переговоров, не теряя реальную стоимость.'],
            ['q' => 'Прогноз вероятности продажи', 'a' => 'Оцениваем вероятность продажи в течение 1-3 месяцев по данной цене в текущих рыночных условиях.'],
          ],
          'en' => [
            ['q' => 'Transaction analysis', 'a' => 'We study actual selling prices in the area for recent months — not listing prices, but real transaction prices.'],
            ['q' => 'Buyer behavior analysis', 'a' => 'We analyze how many buyers are searching in your area, their budgets and expectations.'],
            ['q' => 'Negotiation strategy', 'a' => 'We shape the pricing strategy to leave room for negotiation without losing actual value.'],
            ['q' => 'Sale probability forecast', 'a' => 'We assess the probability of selling within 1-3 months at the given price in current market conditions.'],
          ],
        ];
      ?>
      <?php $__currentLoopData = ($pricingFaq[$locale] ?? $pricingFaq['en']); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <div class="faq-item">
          <div class="faq-question" role="button" tabindex="0" aria-expanded="false" onclick="this.parentElement.classList.toggle('active');this.setAttribute('aria-expanded',this.parentElement.classList.contains('active'))">
            <h3 style="font-size:inherit;margin:0;font-weight:inherit;"><?php echo e($item['q']); ?></h3>
          </div>
          <div class="faq-answer">
            <p><?php echo e($item['a']); ?></p>
          </div>
        </div>
      <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </div>
  </section>
</div>


<div class="container">
  <?php echo $__env->make('partials.ai-citation', ['locale' => $locale], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
</div>

<div class="container">
  <section class="steps">
    <h2 class="main-h2"><?php echo e($t['steps_title']); ?></h2>
    <ul class="steps__list">
      <center>
        <?php $__currentLoopData = $t['steps']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $step): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <li class="steps__item"><p><?php echo $step; ?></p></li>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
      </center>
    </ul>
  </section>
</div>

<section class="jurisdiction">
  <div class="container">
    <h2 class="main-h2"><?php echo e($t['team_title']); ?></h2>
    <div class="jurisdiction__wrapp">
      <a href="" class="jurisdiction__item jurisdiction__item--newZealand">
        <h3 class="jurisdiction__title"><?php echo e($agent['name']); ?></h3>
        <h2 class="jurisdiction__price"><?php echo e($t['result_agent_title']); ?></h2>
        <ul class="jurisdiction__item-list">
          <li><?php echo e($agent['email']); ?></li>
          <li>tel. <?php echo e($agent['phone']); ?></li>
        </ul>
      </a>
    </div>
  </div>
</section>


<?php echo $__env->make('components.v3.trust-agent', ['locale' => $locale], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>


<?php if(!empty($homeAi)): ?>
<?php echo $__env->make('components.v3.ai-chunks', ['v3' => $homeAi], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
<?php endif; ?>


<?php if(!empty($homeFaq)): ?>
<?php echo $__env->make('partials.faq', ['faq' => $homeFaq, 'faqTitle' => 'FAQ'], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
<?php endif; ?>


<?php if($locale === 'ru'): ?>
<section style="padding:2rem 0;background:#f8fafb">
  <div class="container" style="max-width:900px">
    <h3 style="font-size:1.05rem;margin-bottom:1rem">Полезные разделы</h3>
    <div style="display:flex;flex-wrap:wrap;gap:.7rem">
      <a href="/ru/prodat-kvartiru-v-tallinne/" style="display:inline-block;padding:.45rem 1rem;background:#fff;border-radius:6px;text-decoration:none;color:#1a1a2e;font-size:.9rem;box-shadow:0 1px 3px rgba(0,0,0,.07)">Продать квартиру</a>
      <a href="/ru/makler-v-tallinne/" style="display:inline-block;padding:.45rem 1rem;background:#fff;border-radius:6px;text-decoration:none;color:#1a1a2e;font-size:.9rem;box-shadow:0 1px 3px rgba(0,0,0,.07)">Маклер в Таллине</a>
      <a href="/ru/ocenka-kvartiry-v-tallinne/" style="display:inline-block;padding:.45rem 1rem;background:#fff;border-radius:6px;text-decoration:none;color:#1a1a2e;font-size:.9rem;box-shadow:0 1px 3px rgba(0,0,0,.07)">Оценка квартиры</a>
      <a href="/ru/kvartira-ne-prodaetsya/" style="display:inline-block;padding:.45rem 1rem;background:#fff;border-radius:6px;text-decoration:none;color:#1a1a2e;font-size:.9rem;box-shadow:0 1px 3px rgba(0,0,0,.07)">Не продаётся?</a>
      <a href="/ru/tallinn/" style="display:inline-block;padding:.45rem 1rem;background:#fff;border-radius:6px;text-decoration:none;color:#1a1a2e;font-size:.9rem;box-shadow:0 1px 3px rgba(0,0,0,.07)">Районы Таллина</a>
      <a href="/ru/cases/" style="display:inline-block;padding:.45rem 1rem;background:#fff;border-radius:6px;text-decoration:none;color:#1a1a2e;font-size:.9rem;box-shadow:0 1px 3px rgba(0,0,0,.07)">Кейсы продаж</a>
      <a href="<?php echo e(route('ru.profile')); ?>" style="display:inline-block;padding:.45rem 1rem;background:#fff;border-radius:6px;text-decoration:none;color:#1a1a2e;font-size:.9rem;box-shadow:0 1px 3px rgba(0,0,0,.07)">Александр Примаков</a>
    </div>
  </div>
</section>
<?php endif; ?>


<?php echo $__env->make('components.v3.form-audit', ['locale' => $locale], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
<?php echo $__env->make('components.v3.form-calc', ['locale' => $locale], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
<?php echo $__env->make('components.v3.form-scripts', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('footer_class', ''); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\nikol\Documents\projects\cityee-laravel\resources\views/pages/home.blade.php ENDPATH**/ ?>