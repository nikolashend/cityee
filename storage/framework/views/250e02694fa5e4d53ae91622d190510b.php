


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
    ['name' => 'Кейсы'],
]); ?>

<?php echo \App\Support\Schema::speakable(url()->current()); ?>

<script type="application/ld+json"><?php echo json_encode(\App\Support\Schema::orgJsonLd(), JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT); ?></script>
<script type="application/ld+json">
<?php echo json_encode([
    '<?php $__contextArgs = [];
if (context()->has($__contextArgs[0])) :
if (isset($value)) { $__contextPrevious[] = $value; }
$value = context()->get($__contextArgs[0]); ?>' => 'https://schema.org',
    '@type' => 'CollectionPage',
    'name' => $hub['meta_title'] ?? 'Кейсы продажи квартир',
    'description' => $hub['meta_description'] ?? '',
    'url' => url()->current(),
    'isPartOf' => ['@id' => 'https://cityee.ee/#website'],
    'about' => ['@id' => 'https://cityee.ee/#organization'],
    'mainEntity' => [
        '@type' => 'ItemList',
        'numberOfItems' => count($cases ?? []),
        'itemListElement' => collect($cases ?? [])->values()->map(fn($c, $i) => [
            '@type' => 'ListItem',
            'position' => $i + 1,
            'name' => $c['h1'] ?? '',
            'url' => url('/ru/cases/' . array_keys($cases)[$i]) . '/',
        ])->toArray(),
    ],
], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT); ?>

</script>
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


<section style="padding:3rem 0">
  <div class="container">
    <div style="display:grid;grid-template-columns:repeat(auto-fit,minmax(320px,1fr));gap:1.5rem">
      <?php $__currentLoopData = $cases; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $caseSlug => $caseData): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
      <a href="<?php echo e(url('/ru/cases/' . $caseSlug)); ?>/" class="phase3-case-card" style="background:#fff;padding:1.8rem;border-radius:10px;text-decoration:none;color:inherit;border-left:4px solid #7b1f45;box-shadow:0 2px 8px rgba(0,0,0,.06);transition:box-shadow .2s,transform .15s">
        <h3 style="margin:0 0 .8rem;font-size:1.1rem;color:#1a1a2e"><?php echo e($caseData['h1'] ?? ''); ?></h3>
        <div style="display:flex;flex-wrap:wrap;gap:.5rem;margin-bottom:.8rem">
          <span style="background:#f0f0f0;padding:.25rem .6rem;border-radius:4px;font-size:.8rem"><?php echo e($caseData['district'] ?? ''); ?></span>
          <span style="background:#f0f0f0;padding:.25rem .6rem;border-radius:4px;font-size:.8rem"><?php echo e($caseData['type'] ?? ''); ?></span>
          <span style="background:#f0f0f0;padding:.25rem .6rem;border-radius:4px;font-size:.8rem"><?php echo e($caseData['area'] ?? ''); ?></span>
          <span style="background:#e8f5e9;padding:.25rem .6rem;border-radius:4px;font-size:.8rem;color:#2e7d32"><?php echo e($caseData['time'] ?? ''); ?></span>
        </div>
        <p style="font-size:.9rem;opacity:.7;margin:0;line-height:1.5"><?php echo e(Str::limit($caseData['summary'] ?? '', 140)); ?></p>
      </a>
      <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </div>
  </div>
</section>


<?php echo $__env->make('partials.advantages', ['ui' => $ui, 'isPage' => true], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>


<?php echo $__env->make('components.v3.trust-agent', ['locale' => $locale], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>


<section style="padding:3rem 0;text-align:center;background:var(--ce-warm-bg,#faf8f5)">
  <div class="container">
    <h2>Хотите такой же результат?</h2>
    <p style="max-width:500px;margin:1rem auto;opacity:.8">Расскажем, как стратегия продажи может работать для вашего объекта.</p>
    <a href="#v3-form-audit" class="btn btn-v3-primary" style="margin-top:1rem">Получить аудит объекта</a>
  </div>
</section>


<section style="padding:2.5rem 0">
  <div class="container" style="max-width:800px">
    <h3 style="font-size:1.05rem;margin-bottom:1rem">Смотрите также</h3>
    <ul style="list-style:none;padding:0;display:flex;flex-wrap:wrap;gap:.75rem">
      <li><a href="/ru/prodat-kvartiru-v-tallinne/" style="display:inline-block;padding:.45rem 1rem;background:#f0f0f0;border-radius:6px;text-decoration:none;color:#1a1a2e;font-size:.92rem">Продать квартиру</a></li>
      <li><a href="/ru/makler-v-tallinne/" style="display:inline-block;padding:.45rem 1rem;background:#f0f0f0;border-radius:6px;text-decoration:none;color:#1a1a2e;font-size:.92rem">Маклер в Таллине</a></li>
      <li><a href="/ru/tallinn/" style="display:inline-block;padding:.45rem 1rem;background:#f0f0f0;border-radius:6px;text-decoration:none;color:#1a1a2e;font-size:.92rem">Районы Таллина</a></li>
      <li><a href="/ru/aleksandr-primakov/" style="display:inline-block;padding:.45rem 1rem;background:#f0f0f0;border-radius:6px;text-decoration:none;color:#1a1a2e;font-size:.92rem">Александр Примаков</a></li>
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

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\nikol\Documents\projects\cityee-laravel\resources\views/pages/phase3-cases-hub.blade.php ENDPATH**/ ?>