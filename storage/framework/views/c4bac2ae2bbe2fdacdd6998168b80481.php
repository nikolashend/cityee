
<?php
    $zeroClick = config("cityee-intent.zero_click.{$locale}", []);
?>

<?php if(!empty($zeroClick)): ?>
<section class="zero-click-answers" itemscope itemtype="https://schema.org/FAQPage">
  <div class="container">
    <h2><?php echo e($locale === 'ru' ? 'Быстрые ответы' : ($locale === 'en' ? 'Quick Answers' : 'Kiired vastused')); ?></h2>
    <div class="zero-click-grid">
      <?php $__currentLoopData = $zeroClick; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
      <div class="zero-click-card" itemscope itemprop="mainEntity" itemtype="https://schema.org/Question">
        <h3 itemprop="name"><?php echo e($item['q']); ?></h3>
        <div itemscope itemprop="acceptedAnswer" itemtype="https://schema.org/Answer">
          <p itemprop="text"><?php echo e($item['a']); ?></p>
        </div>
      </div>
      <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </div>
  </div>
</section>
<?php endif; ?>
<?php /**PATH C:\Users\nikol\Documents\projects\cityee-laravel\resources\views/partials/zero-click.blade.php ENDPATH**/ ?>