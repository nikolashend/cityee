


<?php $__env->startSection('title', $locale === 'ru' ? 'Реальные кейсы — Продажа недвижимости Tallinn | CityEE' : ($locale === 'en' ? 'Real Cases — Property Sales Tallinn | CityEE' : 'Tegelikud juhtumid — Kinnisvara müük Tallinn | CityEE')); ?>
<?php $__env->startSection('description', $locale === 'ru' ? '10 реальных кейсов продажи недвижимости в Таллинне: проблемы, решения, результаты и сроки.' : ($locale === 'en' ? '10 real estate sales cases in Tallinn: problems, solutions, results and timelines.' : '10 tegelikku kinnisvara müügijuhtumit Tallinnas: probleemid, lahendused, tulemused ja tähtajad.')); ?>
<?php $__env->startSection('logo_text', $ui['logo_text'] ?? ''); ?>
<?php $__env->startSection('footer_class', 'footer--page'); ?>

<?php $__env->startSection('lang_et_url', route('et.cases')); ?>
<?php $__env->startSection('lang_ru_url', route('ru.cases')); ?>
<?php $__env->startSection('lang_en_url', route('en.cases')); ?>

<?php $__env->startPush('jsonld'); ?>
<?php echo \App\Support\JsonLd::breadcrumbs([
    ['name' => $nav[0]['label'] ?? 'Home', 'url' => route("{$locale}.home")],
    ['name' => $locale === 'ru' ? 'База знаний' : ($locale === 'en' ? 'Knowledge Hub' : 'Teadmistebaas'), 'url' => route("{$locale}.knowledge")],
    ['name' => $locale === 'ru' ? 'Кейсы' : ($locale === 'en' ? 'Cases' : 'Juhtumid')],
]); ?>

<?php echo \App\Support\Schema::speakable(\App\Support\SeoLinks::canonical('cases')); ?>

<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>

<section class="hero hero--guide">
  <div class="container text-center">
    <h1><?php echo e($locale === 'ru' ? 'Реальные кейсы CityEE' : ($locale === 'en' ? 'Real CityEE Cases' : 'CityEE tegelikud juhtumid')); ?></h1>
    <p class="guide-hero-meta"><?php echo e($locale === 'ru' ? '10 объектов. Конкретные проблемы. Конкретные результаты.' : ($locale === 'en' ? '10 properties. Real problems. Real results.' : '10 objekti. Konkreetsed probleemid. Konkreetsed tulemused.')); ?></p>
  </div>
</section>


<?php echo $__env->make('partials.case-cards', ['locale' => $locale], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>


<?php echo $__env->make('partials.before-after', ['locale' => $locale], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>


<?php echo $__env->make('partials.data-authority', ['locale' => $locale], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>


<?php echo $__env->make('components.v3.trust-agent', ['locale' => $locale], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>


<section class="guide-cta">
  <div class="container text-center">
    <h2><?php echo e($locale === 'ru' ? 'Хотите такой же результат?' : ($locale === 'en' ? 'Want the same result?' : 'Soovite sama tulemust?')); ?></h2>
    <a href="#v3-form-audit" class="btn btn-primary btn-lg"><?php echo e($locale === 'ru' ? 'Бесплатный аудит' : ($locale === 'en' ? 'Free audit' : 'Tasuta audit')); ?></a>
  </div>
</section>


<?php echo $__env->make('partials.knowledge-crosslinks', ['locale' => $locale, 'currentGuideKey' => ''], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>


<?php echo $__env->make('components.v3.form-audit', ['locale' => $locale], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
<?php echo $__env->make('components.v3.form-calc', ['locale' => $locale], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
<?php echo $__env->make('components.v3.form-scripts', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\nikol\Documents\projects\cityee-laravel\resources\views/pages/cases.blade.php ENDPATH**/ ?>