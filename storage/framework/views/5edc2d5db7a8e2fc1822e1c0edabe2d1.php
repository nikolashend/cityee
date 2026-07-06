
<?php
    $locale = $locale ?? app()->getLocale();
    $titles = [
        'et' => 'Miks omanikud valivad CityEE',
        'ru' => 'Почему собственники выбирают CityEE',
        'en' => 'Why property owners choose CityEE',
    ];
    $subtitles = [
        'et' => 'Kinnisvaratehingute optimeerimise partner Tallinnas ja Harjumaal',
        'ru' => 'Партнер по оптимизации сделок с недвижимостью в Tallinn и Harjumaa',
        'en' => 'Real estate deal optimization partner in Tallinn & Harjumaa',
    ];
    $stats = [
        'et' => [
            ['number' => '10+',   'label' => 'Aastat kogemust'],
            ['number' => '300+',  'label' => 'Tehingut'],
            ['number' => '1-1.5', 'label' => 'Kuud müügiaeg'],
            ['number' => '2%',    'label' => 'Vahendustasu'],
        ],
        'ru' => [
            ['number' => '10+',   'label' => 'Лет опыта'],
            ['number' => '300+',  'label' => 'Сделок'],
            ['number' => '1-1.5', 'label' => 'Мес. срок продажи'],
            ['number' => '2%',    'label' => 'Комиссия'],
        ],
        'en' => [
            ['number' => '10+',   'label' => 'Years experience'],
            ['number' => '300+',  'label' => 'Deals completed'],
            ['number' => '1-1.5', 'label' => 'Months avg. sale'],
            ['number' => '2%',    'label' => 'Commission'],
        ],
    ];
    $features = [
        'et' => [
            'Eksklusiivne strateegia',
            'Reaalne turuanalüüs',
            'Komisjon pärast tehingut',
            'Töö kuni notarini',
            'Professionaalsed fotod',
        ],
        'ru' => [
            'Эксклюзивная стратегия',
            'Реальный анализ рынка',
            'Комиссия после сделки',
            'Работа до нотариуса',
            'Профессиональные фото',
        ],
        'en' => [
            'Exclusive strategy',
            'Real market analysis',
            'Commission after deal',
            'Work through to notary',
            'Professional photography',
        ],
    ];
?>
<section class="trust-layer">
  <div class="container">
    <h2 class="trust-layer__title"><?php echo e($titles[$locale] ?? $titles['en']); ?></h2>
    <p class="trust-layer__subtitle"><?php echo e($subtitles[$locale] ?? $subtitles['en']); ?></p>

    <div class="trust-stats">
      <?php $__currentLoopData = ($stats[$locale] ?? $stats['en']); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $stat): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <div class="trust-stat">
          <span class="trust-stat__number"><?php echo e($stat['number']); ?></span>
          <span class="trust-stat__label"><?php echo e($stat['label']); ?></span>
        </div>
      <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </div>

    <div class="trust-features">
      <?php $__currentLoopData = ($features[$locale] ?? $features['en']); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $feat): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <div class="trust-feature">
          <span class="trust-feature__icon">&#10003;</span>
          <span><?php echo e($feat); ?></span>
        </div>
      <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </div>
  </div>
</section>
<?php /**PATH C:\Users\nikol\Documents\projects\cityee-laravel\resources\views/partials/trust-layer.blade.php ENDPATH**/ ?>