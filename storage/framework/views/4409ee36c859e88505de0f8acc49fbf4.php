


<?php $__env->startSection('title', $guide['meta_title'] ?? ''); ?>
<?php $__env->startSection('description', $guide['meta_description'] ?? ''); ?>
<?php $__env->startSection('logo_text', $ui['logo_text'] ?? ''); ?>
<?php $__env->startSection('footer_class', 'footer--page'); ?>

<?php $__env->startSection('lang_et_url', route('et.pillar', $guideConfig['slug'])); ?>
<?php $__env->startSection('lang_ru_url', route('ru.pillar', $guideConfig['slug_ru'])); ?>
<?php $__env->startSection('lang_en_url', route('en.pillar', $guideConfig['slug_en'])); ?>

<?php $__env->startPush('jsonld'); ?>
<?php echo \App\Support\JsonLd::article(
    $guide['h1'],
    $canonicalUrl,
    $guide['meta_description'],
    $guideConfig['date_published'] ?? null,
    $guideConfig['date_modified'] ?? null
); ?>

<?php echo \App\Support\JsonLd::breadcrumbs([
    ['name' => $nav[0]['label'] ?? 'Home', 'url' => route("{$locale}.home")],
    ['name' => $locale === 'ru' ? 'База знаний' : ($locale === 'en' ? 'Knowledge Hub' : 'Teadmistebaas'), 'url' => route("{$locale}.knowledge")],
    ['name' => $guide['h1']],
]); ?>

<?php echo \App\Support\Schema::speakable($canonicalUrl); ?>

<?php if(!empty($guide['faq'])): ?>
<?php if (isset($component)) { $__componentOriginal631a4b8665f0bb533881a844059661c7 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal631a4b8665f0bb533881a844059661c7 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.faq-schema','data' => ['items' => $guide['faq']]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('faq-schema'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['items' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($guide['faq'])]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal631a4b8665f0bb533881a844059661c7)): ?>
<?php $attributes = $__attributesOriginal631a4b8665f0bb533881a844059661c7; ?>
<?php unset($__attributesOriginal631a4b8665f0bb533881a844059661c7); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal631a4b8665f0bb533881a844059661c7)): ?>
<?php $component = $__componentOriginal631a4b8665f0bb533881a844059661c7; ?>
<?php unset($__componentOriginal631a4b8665f0bb533881a844059661c7); ?>
<?php endif; ?>
<?php endif; ?>
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>


<section class="hero hero--guide">
  <div class="container text-center">
    <h1><?php echo e($guide['h1']); ?></h1>
    <p class="guide-hero-meta">
      <span class="guide-updated">📅 <?php echo e($guide['updated']); ?></span>
      <span class="guide-author">✍️ Aleksandr Primakov</span>
    </p>
  </div>
</section>


<?php if(!empty($guide['ai_summary'])): ?>
<section class="guide-ai-summary">
  <div class="container">
    <div class="ai-box">
      <h2 class="ai-box__title"><?php echo e($guide['ai_summary']['title']); ?></h2>
      <dl class="ai-box__list">
        <dt><?php echo e($locale === 'ru' ? 'Проблема' : ($locale === 'en' ? 'Problem' : 'Probleem')); ?></dt>
        <dd><?php echo e($guide['ai_summary']['problem']); ?></dd>
        <dt><?php echo e($locale === 'ru' ? 'Решение' : ($locale === 'en' ? 'Solution' : 'Lahendus')); ?></dt>
        <dd><?php echo e($guide['ai_summary']['solution']); ?></dd>
        <dt><?php echo e($locale === 'ru' ? 'Сроки' : ($locale === 'en' ? 'Timeline' : 'Aeg')); ?></dt>
        <dd><?php echo e($guide['ai_summary']['timeline']); ?></dd>
        <dt><?php echo e($locale === 'ru' ? 'Стоимость' : ($locale === 'en' ? 'Cost' : 'Hind')); ?></dt>
        <dd><?php echo e($guide['ai_summary']['cost']); ?></dd>
        <dt><?php echo e($locale === 'ru' ? 'Результат' : ($locale === 'en' ? 'Result' : 'Tulemus')); ?></dt>
        <dd><?php echo e($guide['ai_summary']['result']); ?></dd>
      </dl>
    </div>
  </div>
</section>
<?php endif; ?>


<?php if(!empty($guide['sections'])): ?>
<nav class="guide-toc" aria-label="Table of Contents">
  <div class="container">
    <details open>
      <summary><?php echo e($locale === 'ru' ? 'Содержание' : ($locale === 'en' ? 'Table of Contents' : 'Sisukord')); ?></summary>
      <ol class="guide-toc__list">
        <?php $__currentLoopData = $guide['sections']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $i => $sec): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <li><a href="#section-<?php echo e($i + 1); ?>"><?php echo e($sec['h2']); ?></a></li>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
      </ol>
    </details>
  </div>
</nav>
<?php endif; ?>


<div class="container">
  <div class="row">
    <div class="col-md-3 col-sm-3 text-center">
      <?php echo $__env->make('partials.sidebar-services', ['locale' => $locale, 'pageKey' => $pageKey], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
    </div>
    <div class="col-md-9 col-sm-9">
      <div class="content guide-content">

        <?php $__currentLoopData = $guide['sections']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $i => $section): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <section class="guide-section" id="section-<?php echo e($i + 1); ?>">
          <h2><?php echo e($section['h2']); ?></h2>
          <p><?php echo e($section['text']); ?></p>
        </section>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

        
        <?php echo $__env->make('partials.data-authority', ['locale' => $locale], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

        <?php echo $__env->make('partials.ai-citation', ['locale' => $locale], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
      </div>
    </div>
  </div>
</div>


<?php echo $__env->make('partials.trust-protection', ['locale' => $locale], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>


<?php echo $__env->make('partials.inaction-risks', ['locale' => $locale], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>


<?php echo $__env->make('partials.case-cards', ['locale' => $locale, 'limit' => 3], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>


<?php echo $__env->make('components.v3.trust-agent', ['locale' => $locale], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>


<?php if(!empty($guide['faq'])): ?>
<?php echo $__env->make('partials.faq', ['faq' => $guide['faq'], 'faqTitle' => 'FAQ'], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
<?php endif; ?>


<?php if(!empty($guide['cta_title'])): ?>
<section class="guide-cta">
  <div class="container text-center">
    <h2><?php echo e($guide['cta_title']); ?></h2>
    <a href="#v3-form-audit" class="btn btn-primary btn-lg"><?php echo e($guide['cta_btn']); ?></a>
  </div>
</section>
<?php endif; ?>


<?php echo $__env->make('partials.knowledge-crosslinks', ['locale' => $locale, 'currentGuideKey' => $guideKey], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>


<?php echo $__env->make('components.v3.form-audit', ['locale' => $locale], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
<?php echo $__env->make('components.v3.form-calc', ['locale' => $locale], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
<?php echo $__env->make('components.v3.form-scripts', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\nikol\Documents\projects\cityee-laravel\resources\views/pages/pillar-guide.blade.php ENDPATH**/ ?>