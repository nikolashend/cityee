
<?php $ui = $ui ?? config('cityee.ui.' . ($locale ?? 'et')); ?>

<div class="container">
  <article class="about<?php echo e(isset($isPage) && $isPage ? ' about--page' : ''); ?>">
    <h2 class="main-h2"><?php echo e($ui['about_title']); ?></h2>
    <div class="row">
      <div class="col-xs-12">
        <?php if (isset($component)) { $__componentOriginalb12907cd921e95cd9263783896c04e9f = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalb12907cd921e95cd9263783896c04e9f = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.webp-img','data' => ['class' => 'about__mobile-img','src' => '/assets/templates/offshors/img/about-foto-mobile.jpg','alt' => $ui['about_title'],'width' => '600','height' => '400']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('webp-img'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['class' => 'about__mobile-img','src' => '/assets/templates/offshors/img/about-foto-mobile.jpg','alt' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($ui['about_title']),'width' => '600','height' => '400']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalb12907cd921e95cd9263783896c04e9f)): ?>
<?php $attributes = $__attributesOriginalb12907cd921e95cd9263783896c04e9f; ?>
<?php unset($__attributesOriginalb12907cd921e95cd9263783896c04e9f); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalb12907cd921e95cd9263783896c04e9f)): ?>
<?php $component = $__componentOriginalb12907cd921e95cd9263783896c04e9f; ?>
<?php unset($__componentOriginalb12907cd921e95cd9263783896c04e9f); ?>
<?php endif; ?>
      </div>
      <div class="col-sm-6 col-xs-12">
        <p><?php echo e($ui['about_p1']); ?></p>
        <p><?php echo e($ui['about_p2']); ?></p>
        <p><?php echo e($ui['about_p3']); ?></p>
      </div>
      <div class="col-sm-6 col-xs-12">
        <?php if (isset($component)) { $__componentOriginalb12907cd921e95cd9263783896c04e9f = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalb12907cd921e95cd9263783896c04e9f = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.webp-img','data' => ['class' => 'about__desctop-img','src' => '/assets/templates/offshors/img/about-foto.jpg','alt' => $ui['about_title'],'width' => '555','height' => '740']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('webp-img'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['class' => 'about__desctop-img','src' => '/assets/templates/offshors/img/about-foto.jpg','alt' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($ui['about_title']),'width' => '555','height' => '740']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalb12907cd921e95cd9263783896c04e9f)): ?>
<?php $attributes = $__attributesOriginalb12907cd921e95cd9263783896c04e9f; ?>
<?php unset($__attributesOriginalb12907cd921e95cd9263783896c04e9f); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalb12907cd921e95cd9263783896c04e9f)): ?>
<?php $component = $__componentOriginalb12907cd921e95cd9263783896c04e9f; ?>
<?php unset($__componentOriginalb12907cd921e95cd9263783896c04e9f); ?>
<?php endif; ?>
      </div>
    </div>
  </article>
</div>
<?php /**PATH C:\Users\nikol\Documents\projects\cityee-laravel\resources\views/partials/about.blade.php ENDPATH**/ ?>