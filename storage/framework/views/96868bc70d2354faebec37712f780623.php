
<?php
    $locale = $locale ?? app()->getLocale();
    $currentPageKey = $pageKey ?? '';

    $services = [
        'sell' => [
            'et' => ['label' => 'Kinnisvara müük', 'desc' => 'Professionaalne kinnisvara vahendamine'],
            'ru' => ['label' => 'Продажа недвижимости', 'desc' => 'Профессиональное посредничество'],
            'en' => ['label' => 'Property Sale', 'desc' => 'Professional real estate brokerage'],
        ],
        'rent' => [
            'et' => ['label' => 'Kinnisvara üür', 'desc' => 'Abi üürilepingu koostamisel'],
            'ru' => ['label' => 'Аренда недвижимости', 'desc' => 'Помощь с арендным договором'],
            'en' => ['label' => 'Property Rental', 'desc' => 'Rental agreement assistance'],
        ],
        'consultation' => [
            'et' => ['label' => 'Konsultatsioon', 'desc' => 'Kinnisvaraalane nõustamine'],
            'ru' => ['label' => 'Консультация', 'desc' => 'Консультирование по недвижимости'],
            'en' => ['label' => 'Consultation', 'desc' => 'Real estate consulting'],
        ],
        'audit' => [
            'et' => ['label' => 'Kuulutuse audit', 'desc' => 'Objekti analüüs ja soovitused'],
            'ru' => ['label' => 'Аудит объявления', 'desc' => 'Анализ объекта и рекомендации'],
            'en' => ['label' => 'Listing Audit', 'desc' => 'Property analysis & recommendations'],
        ],
    ];

    $titleMap = [
        'et' => 'Vaata ka teisi teenuseid',
        'ru' => 'Смотрите также другие услуги',
        'en' => 'See also our other services',
    ];

    $guidesLabel = ['et' => 'Ekspertjuhised', 'ru' => 'Экспертные гиды', 'en' => 'Expert Guides'];
    $guidesDesc  = ['et' => 'Kasulikud artiklid kinnisvara teemal', 'ru' => 'Полезные статьи о недвижимости', 'en' => 'Useful articles about real estate'];
    $auditsLabel = ['et' => 'Kinnisvara auditid', 'ru' => 'Разборы объектов', 'en' => 'Property Audits'];
    $auditsDesc  = ['et' => 'Reaalsed analüüsid ja juhtumid', 'ru' => 'Реальные разборы и кейсы', 'en' => 'Real case studies and analyses'];
    $profileLabel = ['et' => 'Aleksandr Primakov', 'ru' => 'Александр Примаков', 'en' => 'Aleksandr Primakov'];
    $profileDesc  = ['et' => 'Maakler Tallinnas — 10+ aastat kogemust', 'ru' => 'Маклер в Таллинне — 10+ лет опыта', 'en' => 'Broker in Tallinn — 10+ years experience'];
    $comparisonLabel = ['et' => 'Müüa ise vs partner', 'ru' => 'Продать самому vs партнёр', 'en' => 'DIY vs Strategy Partner'];
    $comparisonDesc  = ['et' => 'Aus võrdlus: ise müümine vs CityEE', 'ru' => 'Честное сравнение: сам vs CityEE', 'en' => 'Honest comparison: DIY vs CityEE'];
?>

<section class="section-padding" style="background:#f9f9f9;">
  <div class="container">
    <h2 class="main-h2" style="font-size:22px;text-transform:none;margin-bottom:30px;"><?php echo e($titleMap[$locale] ?? $titleMap['et']); ?></h2>
    <div class="row">
      <?php $__currentLoopData = $services; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $svc): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <?php if($key !== $currentPageKey): ?>
        <div class="col-md-3 col-sm-6 col-xs-12" style="margin-bottom:20px;">
          <a href="<?php echo e(route("{$locale}.{$key}")); ?>" style="display:block;background:#fff;padding:20px 15px;border-radius:8px;text-decoration:none;color:#333;box-shadow:0 2px 8px rgba(0,0,0,.06);height:100%;">
            <strong style="display:block;font-size:17px;color:#7b1f45;margin-bottom:6px;"><?php echo e($svc[$locale]['label'] ?? $svc['et']['label']); ?></strong>
            <span style="font-size:14px;color:#666;"><?php echo e($svc[$locale]['desc'] ?? $svc['et']['desc']); ?></span>
          </a>
        </div>
        <?php endif; ?>
      <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
      <div class="col-md-3 col-sm-6 col-xs-12" style="margin-bottom:20px;">
        <a href="<?php echo e(route("{$locale}.guides")); ?>" style="display:block;background:#fff;padding:20px 15px;border-radius:8px;text-decoration:none;color:#333;box-shadow:0 2px 8px rgba(0,0,0,.06);height:100%;">
          <strong style="display:block;font-size:17px;color:#7b1f45;margin-bottom:6px;"><?php echo e($guidesLabel[$locale] ?? $guidesLabel['et']); ?></strong>
          <span style="font-size:14px;color:#666;"><?php echo e($guidesDesc[$locale] ?? $guidesDesc['et']); ?></span>
        </a>
      </div>
      <div class="col-md-3 col-sm-6 col-xs-12" style="margin-bottom:20px;">
        <a href="<?php echo e(route("{$locale}.audits")); ?>" style="display:block;background:#fff;padding:20px 15px;border-radius:8px;text-decoration:none;color:#333;box-shadow:0 2px 8px rgba(0,0,0,.06);height:100%;">
          <strong style="display:block;font-size:17px;color:#7b1f45;margin-bottom:6px;"><?php echo e($auditsLabel[$locale] ?? $auditsLabel['et']); ?></strong>
          <span style="font-size:14px;color:#666;"><?php echo e($auditsDesc[$locale] ?? $auditsDesc['et']); ?></span>
        </a>
      </div>
      <?php if($currentPageKey !== 'profile'): ?>
      <div class="col-md-3 col-sm-6 col-xs-12" style="margin-bottom:20px;">
        <a href="<?php echo e(route("{$locale}.profile")); ?>" style="display:block;background:#fff;padding:20px 15px;border-radius:8px;text-decoration:none;color:#333;box-shadow:0 2px 8px rgba(0,0,0,.06);height:100%;">
          <strong style="display:block;font-size:17px;color:#7b1f45;margin-bottom:6px;"><?php echo e($profileLabel[$locale] ?? $profileLabel['et']); ?></strong>
          <span style="font-size:14px;color:#666;"><?php echo e($profileDesc[$locale] ?? $profileDesc['et']); ?></span>
        </a>
      </div>
      <?php endif; ?>
      <?php if($currentPageKey !== 'comparison'): ?>
      <div class="col-md-3 col-sm-6 col-xs-12" style="margin-bottom:20px;">
        <a href="<?php echo e(route("{$locale}.comparison")); ?>" style="display:block;background:#fff;padding:20px 15px;border-radius:8px;text-decoration:none;color:#333;box-shadow:0 2px 8px rgba(0,0,0,.06);height:100%;">
          <strong style="display:block;font-size:17px;color:#7b1f45;margin-bottom:6px;"><?php echo e($comparisonLabel[$locale] ?? $comparisonLabel['et']); ?></strong>
          <span style="font-size:14px;color:#666;"><?php echo e($comparisonDesc[$locale] ?? $comparisonDesc['et']); ?></span>
        </a>
      </div>
      <?php endif; ?>
    </div>

    
    <?php if($locale === 'ru'): ?>
    <?php
        $phase3Links = [
            ['url' => '/ru/prodat-kvartiru-v-tallinne/', 'label' => 'Продать квартиру в Таллине'],
            ['url' => '/ru/makler-v-tallinne/', 'label' => 'Маклер в Таллине'],
            ['url' => '/ru/ocenka-kvartiry-v-tallinne/', 'label' => 'Оценка квартиры'],
            ['url' => '/ru/tallinn/', 'label' => 'Районы Таллина'],
            ['url' => '/ru/cases/', 'label' => 'Реальные кейсы'],
            ['url' => '/ru/agentstvo-nedvizhimosti-tallinn/', 'label' => 'Агентство недвижимости'],
        ];
    ?>
    <div style="margin-top:1.5rem">
      <h3 style="font-size:1rem;margin-bottom:.75rem;color:#333">Ещё по теме</h3>
      <div style="display:flex;flex-wrap:wrap;gap:.6rem">
        <?php $__currentLoopData = $phase3Links; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $p3): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <a href="<?php echo e($p3['url']); ?>" style="display:inline-block;padding:.4rem .9rem;background:#fff;border-radius:6px;text-decoration:none;color:#1a1a2e;font-size:.88rem;box-shadow:0 1px 3px rgba(0,0,0,.07)"><?php echo e($p3['label']); ?></a>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
      </div>
    </div>
    <?php endif; ?>
  </div>
</section>
<?php /**PATH C:\Users\nikol\Documents\projects\cityee-laravel\resources\views/partials/service-crosslinks.blade.php ENDPATH**/ ?>