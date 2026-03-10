


<?php $__env->startSection('title', $landing['meta_title'] ?? ''); ?>
<?php $__env->startSection('description', $landing['meta_description'] ?? ''); ?>
<?php $__env->startSection('logo_text', $ui['logo_text'] ?? ''); ?>
<?php $__env->startSection('footer_class', 'footer--page'); ?>

<?php $__env->startSection('lang_et_url', route('et.home')); ?>
<?php $__env->startSection('lang_ru_url', url()->current()); ?>
<?php $__env->startSection('lang_en_url', route('en.home')); ?>

<?php $__env->startPush('jsonld'); ?>
<?php echo \App\Support\JsonLd::webPage($landing['meta_title'] ?? '', url()->current(), $landing['meta_description'] ?? ''); ?>

<?php echo \App\Support\JsonLd::breadcrumbs([
    ['name' => $nav[0]['label'] ?? 'Главная', 'url' => route('ru.home')],
    ['name' => $landing['h1']],
]); ?>

<?php echo \App\Support\Schema::speakable(url()->current()); ?>

<script type="application/ld+json"><?php echo json_encode(\App\Support\Schema::orgJsonLd(), JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT); ?></script>
<?php $faqSchema = $landing['faq'] ?? []; ?>
<?php if(!empty($faqSchema)): ?>
<script type="application/ld+json">
<?php echo json_encode([
    '<?php $__contextArgs = [];
if (context()->has($__contextArgs[0])) :
if (isset($value)) { $__contextPrevious[] = $value; }
$value = context()->get($__contextArgs[0]); ?>' => 'https://schema.org',
    '@type' => 'FAQPage',
    'mainEntity' => collect($faqSchema)->map(fn($f) => [
        '@type' => 'Question',
        'name' => $f['q'],
        'acceptedAnswer' => ['@type' => 'Answer', 'text' => $f['a']],
    ])->toArray(),
], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT); ?>

</script>
<?php endif; ?>
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>


<section class="v3-hero" style="background:var(--ce-dark,#1a1a2e);color:#fff;padding:3.5rem 0 3rem">
  <div class="container text-center">
    <h1 class="v3-hero__title"><?php echo e($landing['h1']); ?></h1>
    <p class="v3-hero__sub" style="max-width:720px;margin:1rem auto;font-size:1.15rem;opacity:.9">
      <?php echo e($landing['subtitle'] ?? ''); ?>

    </p>
    <div class="v3-hero__cta" style="margin-top:1.8rem;display:flex;gap:1rem;justify-content:center;flex-wrap:wrap">
      <a href="#v3-form-audit" class="btn btn-v3-primary"><?php echo e($landing['cta_primary'] ?? 'Получить аудит'); ?></a>
      <a href="#v3-form-calc" class="btn btn-v3-secondary"><?php echo e($landing['cta_secondary'] ?? 'Узнать цену'); ?></a>
    </div>
  </div>
</section>


<?php echo $__env->make('partials.trust-metrics', ['locale' => $locale], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>


<?php if(!empty($landing['ai_answer'])): ?>
<section class="phase3-ai-answer" style="padding:2.5rem 0;background:#f8fafb">
  <div class="container" style="max-width:800px">
    <div style="background:#fff;border-left:4px solid #4ecdc4;border-radius:8px;padding:1.5rem 2rem;box-shadow:0 2px 8px rgba(0,0,0,.06)">
      <h2 style="font-size:1.2rem;margin:0 0 .75rem;color:#1a1a2e"><?php echo e($landing['ai_answer']['title']); ?></h2>
      <p style="margin:0;line-height:1.7;font-size:1rem;color:#333"><?php echo e($landing['ai_answer']['text']); ?></p>
    </div>
  </div>
</section>
<?php endif; ?>


<?php if(!empty($landing['when_needed'])): ?>
<section style="padding:2rem 0">
  <div class="container" style="max-width:800px">
    <h2 style="font-size:1.15rem;margin-bottom:1rem"><?php echo e($landing['when_needed']['title']); ?></h2>
    <ul style="line-height:1.8;padding-left:1.2rem">
      <?php $__currentLoopData = $landing['when_needed']['items']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
      <li><?php echo e($item); ?></li>
      <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </ul>
  </div>
</section>
<?php endif; ?>


<div class="container">
  <div class="row">
    <div class="col-md-3 col-sm-3 text-center">
      <?php echo $__env->make('partials.sidebar-services', ['locale' => $locale, 'pageKey' => $pageKey], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
    </div>
    <div class="col-md-9 col-sm-9">
      <div class="content phase3-content">
        <?php $__currentLoopData = $landing['sections']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $section): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <section class="phase3-section" style="margin-bottom:2.5rem">
          <h2><?php echo e($section['h2']); ?></h2>
          <div style="line-height:1.75"><?php echo $section['text']; ?></div>
        </section>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
      </div>
    </div>
  </div>
</div>


<?php echo $__env->make('partials.advantages', ['ui' => $ui, 'isPage' => true], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>


<?php echo $__env->make('components.v3.trust-agent', ['locale' => $locale], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>


<?php echo $__env->make('partials.about', ['ui' => $ui, 'isPage' => true], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>


<?php if(!empty($landing['faq'])): ?>
<?php echo $__env->make('partials.faq', ['faq' => $landing['faq'], 'faqTitle' => 'FAQ'], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
<?php endif; ?>


<?php if(!empty($landing['cta_bottom_title'])): ?>
<section class="phase3-cta" style="padding:3rem 0;text-align:center;background:var(--ce-warm-bg,#faf8f5)">
  <div class="container">
    <h2><?php echo e($landing['cta_bottom_title']); ?></h2>
    <a href="#v3-form-audit" class="btn btn-v3-primary" style="margin-top:1rem"><?php echo e($landing['cta_bottom_btn'] ?? 'Связаться'); ?></a>
  </div>
</section>
<?php endif; ?>


<?php if(!empty($landing['internal_links'])): ?>
<section class="phase3-crosslinks" style="padding:2.5rem 0">
  <div class="container" style="max-width:800px">
    <h3 style="font-size:1.1rem;margin-bottom:1rem">Полезные ссылки</h3>
    <ul style="list-style:none;padding:0;display:flex;flex-wrap:wrap;gap:.75rem">
      <?php $__currentLoopData = $landing['internal_links']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $link): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
      <li><a href="<?php echo e($link['url']); ?>" style="display:inline-block;padding:.45rem 1rem;background:#f0f0f0;border-radius:6px;text-decoration:none;color:#1a1a2e;font-size:.92rem;transition:background .2s"><?php echo e($link['anchor']); ?></a></li>
      <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </ul>
  </div>
</section>
<?php endif; ?>


<?php echo $__env->make('components.v3.form-audit', ['locale' => $locale], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
<?php echo $__env->make('components.v3.form-calc', ['locale' => $locale], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
<?php echo $__env->make('components.v3.form-scripts', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>


<div class="container" style="padding:1rem 0">
  <p><small>📍 CityEE — Таллинн, Харьюмаа, Эстония. Viru väljak 2, Tallinn 10111.</small></p>
</div>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\nikol\Documents\projects\cityee-laravel\resources\views/pages/phase3-landing.blade.php ENDPATH**/ ?>