


<?php $__env->startSection('title', $t['meta_title'] ?? ''); ?>
<?php $__env->startSection('description', $t['meta_description'] ?? ''); ?>
<?php $__env->startSection('logo_text', $ui['logo_text'] ?? ''); ?>
<?php $__env->startSection('footer_class', 'footer--page'); ?>

<?php $__env->startSection('lang_et_url', route('et.' . $pageKey)); ?>
<?php $__env->startSection('lang_ru_url', route('ru.' . $pageKey)); ?>
<?php $__env->startSection('lang_en_url', route('en.' . $pageKey)); ?>

<?php $__env->startPush('jsonld'); ?>
<?php echo \App\Support\JsonLd::servicePage($pageKey, $t); ?>

<?php echo \App\Support\JsonLd::breadcrumbs([
    ['name' => $nav[0]['label'] ?? 'Home', 'url' => route("{$locale}.home")],
    ['name' => $t['h1']],
]); ?>

<?php echo \App\Support\Schema::speakable(\App\Support\SeoLinks::canonical($pageKey)); ?>

<?php
    $faqForSchema = $v3Faq ?? $t['faq'] ?? [];
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


<?php echo $__env->make('components.v3.hero', ['v3' => $v3, 'company' => config('cityee.company')], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>


<?php echo $__env->make('partials.trust-metrics', ['locale' => $locale], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>


<?php echo $__env->make('components.v3.jtbd', ['v3' => $v3], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>


<div class="container">
  <div class="row">
    <div class="col-md-3 col-sm-3 text-center">
      <?php echo $__env->make('partials.sidebar-services', ['locale' => $locale, 'pageKey' => $pageKey], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
    </div>
    <div class="col-md-9 col-sm-9">
      <div class="content">
        <?php echo $__env->make('partials.ai-summary', ['locale' => $locale, 'pageKey' => $pageKey], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

        <?php echo $t['intro']; ?>


        <?php if(!empty($t['services'])): ?>
        <div class="possibilities">
          <?php if(!empty($t['services_title'])): ?>
          <h2><?php echo e($t['services_title']); ?></h2>
          <?php endif; ?>
          <ul>
            <?php $__currentLoopData = $t['services']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $service): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
              <li><?php echo e($service); ?></li>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
          </ul>
        </div>
        <?php endif; ?>

        
        <?php if(!empty($t['pricing_table'])): ?>
        <h2><?php echo e($t['pricing_title'] ?? ''); ?></h2>
        <div class="v3-table-wrap" role="region" tabindex="0">
            <table class="v3-table">
                <thead>
                    <tr>
                        <th><?php echo e($t['pricing_table_headers'][0] ?? ''); ?></th>
                        <th><?php echo e($t['pricing_table_headers'][1] ?? ''); ?></th>
                    </tr>
                </thead>
                <tbody>
                    <?php $__currentLoopData = $t['pricing_table']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <tr>
                        <td><?php echo e($row['service']); ?></td>
                        <td><?php echo e($row['price']); ?></td>
                    </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </tbody>
            </table>
        </div>
        <?php elseif(!empty($t['pricing_title'])): ?>
        <h2><?php echo e($t['pricing_title']); ?></h2>
        <?php endif; ?>

        <?php if(!empty($t['pricing_text'])): ?>
        <?php echo $t['pricing_text']; ?>

        <?php endif; ?>

        <?php if(!empty($t['bonus'])): ?>
        <div class="offers__bonus">
          <p><?php echo $t['bonus']; ?></p>
        </div>
        <?php endif; ?>

        <?php echo $__env->make('partials.ai-citation', ['locale' => $locale], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
      </div>
    </div>
  </div>
</div>


<?php echo $__env->make('components.v3.outcomes', ['v3' => $v3], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>


<?php echo $__env->make('components.v3.process', ['v3' => $v3], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>


<?php echo $__env->make('components.v3.price-table', ['v3' => $v3], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>


<?php echo $__env->make('components.v3.cases', ['v3' => $v3, 'company' => config('cityee.company')], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>


<?php if($pageKey === 'sell'): ?>
<?php echo $__env->make('partials.sell-jtbd-30', ['locale' => $locale], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
<?php echo $__env->make('partials.sell-fears-30', ['locale' => $locale], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
<?php echo $__env->make('partials.sell-value-20', ['locale' => $locale], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
<?php echo $__env->make('partials.sell-strategies-20', ['locale' => $locale], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
<?php echo $__env->make('partials.zero-click', ['locale' => $locale], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
<?php echo $__env->make('partials.micro-conversion', ['locale' => $locale], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
<?php endif; ?>


<?php if($pageKey === 'sell'): ?>
<?php echo $__env->make('partials.trust-protection', ['locale' => $locale], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
<?php echo $__env->make('partials.inaction-risks', ['locale' => $locale], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
<?php echo $__env->make('partials.data-authority', ['locale' => $locale], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
<?php echo $__env->make('partials.before-after', ['locale' => $locale], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
<?php endif; ?>


<?php echo $__env->make('partials.advantages', ['ui' => $ui, 'isPage' => true], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>


<?php echo $__env->make('components.v3.trust-agent', ['locale' => $locale], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>


<?php echo $__env->make('partials.about', ['ui' => $ui, 'isPage' => true], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>


<?php if(!empty($v3['ai_short'])): ?>
<?php echo $__env->make('components.v3.ai-chunks', ['v3' => $v3], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
<?php endif; ?>


<?php if(!empty($t['answer_block'])): ?>
<div class="container">
<?php echo $__env->make('components.v3.answer-block', [
    'question' => $t['answer_block']['question'] ?? '',
    'answer'   => $t['answer_block']['answer'] ?? '',
    'bullets'  => $t['answer_block']['bullets'] ?? [],
    'locale'   => $locale,
], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
</div>
<?php endif; ?>


<?php if(!empty($t['voice_qa'])): ?>
<div class="container">
<?php echo $__env->make('components.v3.voice-answer', ['items' => $t['voice_qa'], 'locale' => $locale], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
</div>
<?php endif; ?>


<?php if(!empty($v3Faq)): ?>
<?php echo $__env->make('partials.faq', ['faq' => $v3Faq, 'faqTitle' => 'FAQ'], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
<?php elseif(!empty($t['faq'])): ?>
<?php echo $__env->make('partials.faq', ['faq' => $t['faq'], 'faqTitle' => 'FAQ'], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
<?php endif; ?>


<?php echo $__env->make('partials.service-crosslinks', ['locale' => $locale, 'pageKey' => $pageKey], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>


<?php if($pageKey === 'sell'): ?>
<?php echo $__env->make('partials.intent-crosslinks', ['locale' => $locale, 'pageKey' => $pageKey], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
<?php endif; ?>


<?php echo $__env->make('components.v3.form-audit', ['locale' => $locale], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
<?php echo $__env->make('components.v3.form-calc', ['locale' => $locale], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>


<?php echo $__env->make('components.v3.form-scripts', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\nikol\Documents\projects\cityee-laravel\resources\views/pages/service-v3.blade.php ENDPATH**/ ?>