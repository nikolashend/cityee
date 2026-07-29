


<?php $__env->startSection('title', $intent['meta_title'] ?? ''); ?>
<?php $__env->startSection('description', $intent['meta_description'] ?? ''); ?>
<?php $__env->startSection('logo_text', $ui['logo_text'] ?? ''); ?>
<?php $__env->startSection('footer_class', 'footer--page'); ?>

<?php $__env->startSection('lang_et_url', route('et.' . $pageKey)); ?>
<?php $__env->startSection('lang_ru_url', route('ru.' . $pageKey)); ?>
<?php $__env->startSection('lang_en_url', route('en.' . $pageKey)); ?>

<?php $__env->startPush('jsonld'); ?>
<?php echo \App\Support\JsonLd::webPage($intent['h1'] ?? '', \App\Support\SeoLinks::canonical($pageKey), $intent['meta_description'] ?? ''); ?>

<?php echo \App\Support\JsonLd::breadcrumbs([
    ['name' => $nav[0]['label'] ?? 'Home', 'url' => route("{$locale}.home")],
    ['name' => $intent['h1']],
]); ?>

<?php echo \App\Support\Schema::speakable(\App\Support\SeoLinks::canonical($pageKey)); ?>

<script type="application/ld+json"><?php echo json_encode(\App\Support\Schema::orgJsonLd(), JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT); ?></script>
<?php
    $faqForSchema = $intent['faq'] ?? [];
?>
<?php if(!empty($faqForSchema)): ?>
<?php if (isset($component)) { $__componentOriginal631a4b8665f0bb533881a844059661c7 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal631a4b8665f0bb533881a844059661c7 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.faq-schema','data' => ['items' => $faqForSchema]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('faq-schema'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['items' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($faqForSchema)]); ?>
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


<section class="hero hero--intent">
  <div class="container">
    <h1><?php echo e($intent['h1']); ?></h1>
    <?php if(!empty($intent['ai_summary'])): ?>
    <div class="intent-hero-summary">
      <strong><?php echo e($intent['ai_summary']['problem']); ?></strong>
    </div>
    <?php endif; ?>
  </div>
</section>


<?php echo $__env->make('partials.trust-metrics', ['locale' => $locale], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>


<?php if(!empty($intent['ai_summary'])): ?>
<section class="intent-ai-summary">
  <div class="container">
    <div class="ai-box">
      <h2 class="ai-box__title"><?php echo e($intent['ai_summary']['title']); ?></h2>
      <dl class="ai-box__list">
        <dt><?php echo e($locale === 'ru' ? 'Проблема' : ($locale === 'en' ? 'Problem' : 'Probleem')); ?></dt>
        <dd><?php echo e($intent['ai_summary']['problem']); ?></dd>
        <dt><?php echo e($locale === 'ru' ? 'Решение' : ($locale === 'en' ? 'Solution' : 'Lahendus')); ?></dt>
        <dd><?php echo e($intent['ai_summary']['solution']); ?></dd>
        <dt><?php echo e($locale === 'ru' ? 'Сроки' : ($locale === 'en' ? 'Timeline' : 'Aeg')); ?></dt>
        <dd><?php echo e($intent['ai_summary']['timeline']); ?></dd>
        <dt><?php echo e($locale === 'ru' ? 'Стоимость' : ($locale === 'en' ? 'Cost' : 'Hind')); ?></dt>
        <dd><?php echo e($intent['ai_summary']['commission']); ?></dd>
        <dt><?php echo e($locale === 'ru' ? 'Результат' : ($locale === 'en' ? 'Result' : 'Tulemus')); ?></dt>
        <dd><?php echo e($intent['ai_summary']['result']); ?></dd>
      </dl>
    </div>
  </div>
</section>
<?php endif; ?>


<div class="container">
  <div class="row">
    <div class="col-md-3 col-sm-3 text-center">
      <?php echo $__env->make('partials.sidebar-services', ['locale' => $locale, 'pageKey' => $pageKey], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
    </div>
    <div class="col-md-9 col-sm-9">
      <div class="content intent-content">

        
        <?php if(!empty($intent['comparison_table'])): ?>
        <?php echo $__env->make('partials.comparison-table', ['table' => $intent['comparison_table'], 'locale' => $locale], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
        <?php endif; ?>

        <?php $__currentLoopData = $intent['sections']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $section): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <section class="intent-section">
          <h2><?php echo e($section['h2']); ?></h2>
          <p><?php echo e($section['text']); ?></p>
        </section>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

        <?php echo $__env->make('partials.ai-citation', ['locale' => $locale], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
      </div>
    </div>
  </div>
</div>


<?php echo $__env->make('partials.advantages', ['ui' => $ui, 'isPage' => true], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>


<?php echo $__env->make('components.v3.trust-agent', ['locale' => $locale], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>


<?php echo $__env->make('partials.ai-recommends', ['locale' => $locale], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>


<?php echo $__env->make('partials.about', ['ui' => $ui, 'isPage' => true], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>


<?php echo $__env->make('partials.zero-click', ['locale' => $locale], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>


<?php if(!empty($intent['faq'])): ?>
<?php echo $__env->make('partials.faq', ['faq' => $intent['faq'], 'faqTitle' => 'FAQ'], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
<?php endif; ?>


<?php if(!empty($intent['cta_title'])): ?>
<section class="intent-cta">
  <div class="container text-center">
    <h2><?php echo e($intent['cta_title']); ?></h2>
    <a href="#v3-form-audit" class="btn btn-primary btn-lg"><?php echo e($intent['cta_btn']); ?></a>
  </div>
</section>
<?php endif; ?>


<?php echo $__env->make('partials.silo-related', ['locale' => $locale, 'pageKey' => $pageKey], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>


<?php echo $__env->make('partials.intent-crosslinks', ['locale' => $locale, 'pageKey' => $pageKey], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>


<?php echo $__env->make('partials.micro-conversion', ['locale' => $locale], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>


<?php echo $__env->make('components.v3.form-audit', ['locale' => $locale], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
<?php echo $__env->make('components.v3.form-calc', ['locale' => $locale], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
<?php echo $__env->make('components.v3.form-scripts', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

<?php echo $__env->make('partials.service-crosslinks', ['locale' => $locale, 'pageKey' => $intentKey ?? ''], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\nikol\Documents\projects\cityee-laravel\resources\views/pages/intent.blade.php ENDPATH**/ ?>