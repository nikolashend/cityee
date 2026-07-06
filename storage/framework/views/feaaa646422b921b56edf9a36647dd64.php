


<?php $__env->startSection('title', $case['meta_title'] ?? ''); ?>
<?php $__env->startSection('description', $case['meta_description'] ?? ''); ?>
<?php $__env->startSection('logo_text', $ui['logo_text'] ?? ''); ?>
<?php $__env->startSection('footer_class', 'footer--page'); ?>

<?php $__env->startSection('lang_et_url', route('et.home')); ?>
<?php $__env->startSection('lang_ru_url', url()->current()); ?>
<?php $__env->startSection('lang_en_url', route('en.home')); ?>

<?php $__env->startPush('jsonld'); ?>
<?php echo \App\Support\JsonLd::webPage($case['meta_title'] ?? '', url()->current(), $case['meta_description'] ?? ''); ?>

<?php echo \App\Support\JsonLd::breadcrumbs([
    ['name' => $nav[0]['label'] ?? 'Главная', 'url' => route('ru.home')],
    ['name' => 'Кейсы', 'url' => route('ru.phase3.cases-hub')],
    ['name' => $case['h1'] ?? ''],
]); ?>

<?php echo \App\Support\Schema::speakable(url()->current()); ?>

<script type="application/ld+json"><?php echo json_encode(\App\Support\Schema::orgJsonLd(), JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT); ?></script>
<script type="application/ld+json">
<?php echo json_encode([
    '<?php $__contextArgs = [];
if (context()->has($__contextArgs[0])) :
if (isset($value)) { $__contextPrevious[] = $value; }
$value = context()->get($__contextArgs[0]); ?>' => 'https://schema.org',
    '@type' => 'Article',
    'headline' => $case['h1'] ?? '',
    'description' => $case['meta_description'] ?? '',
    'url' => url()->current(),
    'author' => ['@id' => 'https://cityee.ee/#aleksandr'],
    'publisher' => ['@id' => 'https://cityee.ee/#organization'],
    'mainEntityOfPage' => url()->current(),
    'about' => [
        '@type' => 'RealEstateListing',
        'name' => $case['h1'] ?? '',
        'description' => $case['summary'] ?? '',
    ],
    'articleSection' => 'Кейсы продажи недвижимости',
    'inLanguage' => 'ru',
], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT); ?>

</script>
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>


<section class="v3-hero" style="background:var(--ce-dark,#1a1a2e);color:#fff;padding:3.5rem 0 3rem">
  <div class="container text-center">
    <h1 class="v3-hero__title"><?php echo e($case['h1']); ?></h1>
    
    <div style="margin-top:1.5rem;display:flex;gap:1.5rem;justify-content:center;flex-wrap:wrap">
      <div style="text-align:center">
        <div style="font-size:1.4rem;font-weight:700;color:#4ecdc4"><?php echo e($case['district'] ?? ''); ?></div>
        <div style="font-size:.75rem;opacity:.6">Район</div>
      </div>
      <div style="text-align:center">
        <div style="font-size:1.4rem;font-weight:700;color:#4ecdc4"><?php echo e($case['area'] ?? ''); ?></div>
        <div style="font-size:.75rem;opacity:.6">Площадь</div>
      </div>
      <div style="text-align:center">
        <div style="font-size:1.4rem;font-weight:700;color:#4ecdc4"><?php echo e($case['time'] ?? ''); ?></div>
        <div style="font-size:.75rem;opacity:.6">Срок</div>
      </div>
      <div style="text-align:center">
        <div style="font-size:1.4rem;font-weight:700;color:#4ecdc4"><?php echo e($case['price_result'] ?? ''); ?></div>
        <div style="font-size:.75rem;opacity:.6">Цена</div>
      </div>
    </div>
  </div>
</section>


<?php echo $__env->make('partials.trust-metrics', ['locale' => $locale], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>


<section style="padding:3rem 0">
  <div class="container" style="max-width:800px">

    
    <div style="background:#f8fafb;border-left:4px solid #4ecdc4;border-radius:8px;padding:1.5rem 2rem;margin-bottom:2.5rem;box-shadow:0 2px 8px rgba(0,0,0,.06)">
      <h2 style="font-size:1.15rem;margin:0 0 .75rem;color:#1a1a2e">Суть кейса</h2>
      <p style="margin:0;line-height:1.75"><?php echo e($case['summary'] ?? ''); ?></p>
    </div>

    
    <?php if(!empty($case['before'])): ?>
    <h2 style="font-size:1.15rem;margin-bottom:.75rem">📋 Исходная ситуация</h2>
    <p style="line-height:1.75;margin-bottom:2rem"><?php echo e($case['before']); ?></p>
    <?php endif; ?>

    
    <?php if(!empty($case['context'])): ?>
    <h2 style="font-size:1.15rem;margin-bottom:.75rem">📊 Рыночный контекст</h2>
    <p style="line-height:1.75;margin-bottom:2rem"><?php echo e($case['context']); ?></p>
    <?php endif; ?>

    
    <?php if(!empty($case['changes'])): ?>
    <h2 style="font-size:1.15rem;margin-bottom:.75rem">🔧 Что мы изменили</h2>
    <ul style="line-height:1.8;margin-bottom:2rem">
      <?php $__currentLoopData = $case['changes']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $change): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
      <li><?php echo e($change); ?></li>
      <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </ul>
    <?php endif; ?>

    
    <?php if(!empty($case['result'])): ?>
    <h2 style="font-size:1.15rem;margin-bottom:.75rem">✅ Результат</h2>
    <p style="line-height:1.75;margin-bottom:2rem;font-weight:600;color:#2e7d32"><?php echo e($case['result']); ?></p>
    <?php endif; ?>

    
    <?php if(!empty($case['lesson'])): ?>
    <div style="background:#fff3e0;border:1px solid #ff9800;border-radius:8px;padding:1.25rem;margin-top:1rem">
      <strong>💡 Вывод:</strong> <?php echo e($case['lesson']); ?>

    </div>
    <?php endif; ?>

    
    <div style="margin-top:2.5rem;overflow-x:auto">
      <table style="width:100%;border-collapse:collapse;font-size:.92rem">
        <tbody>
          <tr style="border-bottom:1px solid #eee"><td style="padding:.6rem;font-weight:600;width:40%">Тип объекта</td><td style="padding:.6rem"><?php echo e($case['type'] ?? ''); ?></td></tr>
          <tr style="border-bottom:1px solid #eee"><td style="padding:.6rem;font-weight:600">Район</td><td style="padding:.6rem"><?php echo e($case['district'] ?? ''); ?></td></tr>
          <tr style="border-bottom:1px solid #eee"><td style="padding:.6rem;font-weight:600">Площадь</td><td style="padding:.6rem"><?php echo e($case['area'] ?? ''); ?></td></tr>
          <tr style="border-bottom:1px solid #eee"><td style="padding:.6rem;font-weight:600">Срок продажи</td><td style="padding:.6rem"><?php echo e($case['time'] ?? ''); ?></td></tr>
          <tr style="border-bottom:1px solid #eee"><td style="padding:.6rem;font-weight:600">Конкуренция</td><td style="padding:.6rem"><?php echo e($case['competitors'] ?? ''); ?></td></tr>
          <tr style="border-bottom:1px solid #eee"><td style="padding:.6rem;font-weight:600">Цена сделки</td><td style="padding:.6rem"><?php echo e($case['price_result'] ?? ''); ?></td></tr>
          <tr><td style="padding:.6rem;font-weight:600">Торг</td><td style="padding:.6rem"><?php echo e($case['bargaining'] ?? ''); ?></td></tr>
        </tbody>
      </table>
    </div>
  </div>
</section>


<?php echo $__env->make('components.v3.trust-agent', ['locale' => $locale], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>


<section style="padding:3rem 0;text-align:center;background:var(--ce-warm-bg,#faf8f5)">
  <div class="container">
    <h2>Хотите такой же результат для вашей квартиры?</h2>
    <p style="max-width:500px;margin:1rem auto;opacity:.8">Проведём аудит, определим ценовой коридор и построим стратегию.</p>
    <a href="#v3-form-audit" class="btn btn-v3-primary" style="margin-top:1rem">Получить аудит объекта</a>
  </div>
</section>


<section style="padding:2.5rem 0">
  <div class="container" style="max-width:800px">
    <h3 style="font-size:1.05rem;margin-bottom:1rem">Другие кейсы</h3>
    <ul style="list-style:none;padding:0;display:flex;flex-wrap:wrap;gap:.75rem">
      <?php $allCases = config('cityee-phase3.cases', []); ?>
      <?php $__currentLoopData = $allCases; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $otherSlug => $otherCase): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <?php if($otherSlug !== $slug): ?>
        <li><a href="<?php echo e(url('/ru/cases/' . $otherSlug)); ?>/" style="display:inline-block;padding:.45rem 1rem;background:#f0f0f0;border-radius:6px;text-decoration:none;color:#1a1a2e;font-size:.88rem"><?php echo e(Str::limit($otherCase['h1'] ?? '', 50)); ?></a></li>
        <?php endif; ?>
      <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </ul>
    <div style="margin-top:1rem">
      <a href="/ru/cases/" style="font-weight:600;color:#7b1f45">← Все кейсы</a>
    </div>
  </div>
</section>


<section style="padding:2rem 0">
  <div class="container" style="max-width:800px">
    <ul style="list-style:none;padding:0;display:flex;flex-wrap:wrap;gap:.75rem">
      <li><a href="/ru/prodat-kvartiru-v-tallinne/" style="display:inline-block;padding:.45rem 1rem;background:#f0f0f0;border-radius:6px;text-decoration:none;color:#1a1a2e;font-size:.92rem">Продать квартиру</a></li>
      <li><a href="/ru/makler-v-tallinne/" style="display:inline-block;padding:.45rem 1rem;background:#f0f0f0;border-radius:6px;text-decoration:none;color:#1a1a2e;font-size:.92rem">Маклер в Таллине</a></li>
      <li><a href="/ru/tallinn/" style="display:inline-block;padding:.45rem 1rem;background:#f0f0f0;border-radius:6px;text-decoration:none;color:#1a1a2e;font-size:.92rem">Районы Таллина</a></li>
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

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\nikol\Documents\projects\cityee-laravel\resources\views/pages/phase3-case.blade.php ENDPATH**/ ?>