


<?php $__env->startSection('title', $hub['meta_title'] ?? ''); ?>
<?php $__env->startSection('description', $hub['meta_description'] ?? ''); ?>
<?php $__env->startSection('logo_text', $ui['logo_text'] ?? ''); ?>
<?php $__env->startSection('footer_class', 'footer--page'); ?>

<?php $__env->startSection('lang_et_url', route('et.home')); ?>
<?php $__env->startSection('lang_ru_url', url()->current()); ?>
<?php $__env->startSection('lang_en_url', route('en.home')); ?>

<?php $__env->startPush('jsonld'); ?>
<?php echo \App\Support\JsonLd::webPage($hub['meta_title'] ?? '', url()->current(), $hub['meta_description'] ?? ''); ?>

<?php echo \App\Support\JsonLd::breadcrumbs([
    ['name' => $nav[0]['label'] ?? 'Главная', 'url' => route('ru.home')],
    ['name' => 'Районы Таллина'],
]); ?>

<?php echo \App\Support\Schema::speakable(url()->current()); ?>

<script type="application/ld+json"><?php echo json_encode(\App\Support\Schema::orgJsonLd(), JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT); ?></script>
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>


<section class="v3-hero" style="background:var(--ce-dark,#1a1a2e);color:#fff;padding:3.5rem 0 3rem">
  <div class="container text-center">
    <h1 class="v3-hero__title"><?php echo e($hub['h1']); ?></h1>
    <p class="v3-hero__sub" style="max-width:720px;margin:1rem auto;font-size:1.15rem;opacity:.9">
      <?php echo e($hub['intro'] ?? ''); ?>

    </p>
  </div>
</section>


<?php echo $__env->make('partials.trust-metrics', ['locale' => $locale], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>


<?php if(!empty($hub['why_district'])): ?>
<section style="padding:2.5rem 0;background:#f8fafb">
  <div class="container" style="max-width:800px">
    <div style="background:#fff;border-left:4px solid #4ecdc4;border-radius:8px;padding:1.5rem 2rem;box-shadow:0 2px 8px rgba(0,0,0,.06)">
      <h2 style="font-size:1.15rem;margin:0 0 .75rem;color:#1a1a2e"><?php echo e($hub['why_district']['title']); ?></h2>
      <p style="margin:0;line-height:1.7;font-size:1rem;color:#333"><?php echo e($hub['why_district']['text']); ?></p>
    </div>
  </div>
</section>
<?php endif; ?>


<section style="padding:3rem 0">
  <div class="container">
    <h2 style="text-align:center;margin-bottom:2rem">Ключевые районы Таллина</h2>
    <div style="display:grid;grid-template-columns:repeat(auto-fit,minmax(300px,1fr));gap:1.5rem">
      <?php $__currentLoopData = $districts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $dSlug => $dData): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
      <a href="<?php echo e(url('/ru/tallinn/' . $dSlug)); ?>/" class="phase3-district-card" style="background:#fff;padding:1.8rem;border-radius:10px;text-decoration:none;color:inherit;border-left:4px solid #4ecdc4;box-shadow:0 2px 8px rgba(0,0,0,.06);transition:box-shadow .2s">
        <h3 style="margin:0 0 .6rem;font-size:1.2rem;color:#1a1a2e"><?php echo e($dData['name'] ?? ucfirst($dSlug)); ?></h3>
        <p style="font-size:.92rem;opacity:.75;margin:0;line-height:1.6"><?php echo e($dData['subtitle'] ?? ''); ?></p>
      </a>
      <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </div>
  </div>
</section>


<section style="padding:3rem 0;background:var(--ce-warm-bg,#faf8f5)">
  <div class="container" style="text-align:center">
    <h2>Нужна помощь с продажей квартиры в Таллине?</h2>
    <p style="max-width:600px;margin:1rem auto;opacity:.8">Определим ценовой коридор, сравним с конкурентами и построим стратегию продажи для вашего объекта.</p>
    <div style="margin-top:1.5rem;display:flex;gap:1rem;justify-content:center;flex-wrap:wrap">
      <a href="#v3-form-audit" class="btn btn-v3-primary">Получить аудит объекта</a>
      <a href="/ru/makler-v-tallinne/" class="btn btn-v3-secondary">Подробнее о нашей работе</a>
    </div>
  </div>
</section>


<?php echo $__env->make('partials.advantages', ['ui' => $ui, 'isPage' => true], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>


<?php echo $__env->make('components.v3.trust-agent', ['locale' => $locale], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>


<section style="padding:2.5rem 0">
  <div class="container" style="max-width:800px">
    <h3 style="font-size:1.05rem;margin-bottom:1rem">Смотрите также</h3>
    <ul style="list-style:none;padding:0;display:flex;flex-wrap:wrap;gap:.75rem">
      <li><a href="/ru/prodat-kvartiru-v-tallinne/" style="display:inline-block;padding:.45rem 1rem;background:#f0f0f0;border-radius:6px;text-decoration:none;color:#1a1a2e;font-size:.92rem">Продать квартиру в Таллине</a></li>
      <li><a href="/ru/makler-v-tallinne/" style="display:inline-block;padding:.45rem 1rem;background:#f0f0f0;border-radius:6px;text-decoration:none;color:#1a1a2e;font-size:.92rem">Маклер в Таллине</a></li>
      <li><a href="/ru/ocenka-kvartiry-v-tallinne/" style="display:inline-block;padding:.45rem 1rem;background:#f0f0f0;border-radius:6px;text-decoration:none;color:#1a1a2e;font-size:.92rem">Оценка квартиры</a></li>
      <li><a href="/ru/cases/" style="display:inline-block;padding:.45rem 1rem;background:#f0f0f0;border-radius:6px;text-decoration:none;color:#1a1a2e;font-size:.92rem">Реальные кейсы</a></li>
    </ul>
  </div>
</section>


<?php echo $__env->make('components.v3.form-audit', ['locale' => $locale], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
<?php echo $__env->make('components.v3.form-calc', ['locale' => $locale], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
<?php echo $__env->make('components.v3.form-scripts', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

<div class="container" style="padding:1rem 0">
  <p><small>📍 CityEE — Таллинн, Харьюмаа, Эстония. Viru väljak 2, Tallinn 10111.</small></p>
</div>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\nikol\Documents\projects\cityee-laravel\resources\views/pages/phase3-geo-hub.blade.php ENDPATH**/ ?>