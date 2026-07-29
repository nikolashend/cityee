
<?php
    $fears = config("cityee-intent.sell_fears_30.{$locale}", []);
?>

<?php if(!empty($fears['items'])): ?>
<section class="sell-fears-30" id="fears-30">
  <div class="container">
    <h2><?php echo e($fears['title']); ?></h2>
    <div class="fears-accordion">
      <?php $__currentLoopData = $fears['items']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $i => $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
      <details class="fear-item">
        <summary>
          <span class="fear-num"><?php echo e($i + 1); ?></span>
          <span class="fear-title"><?php echo e($item['fear']); ?></span>
        </summary>
        <div class="fear-solution">
          <p><strong><?php echo e($locale === 'ru' ? 'Решение' : ($locale === 'en' ? 'Solution' : 'Lahendus')); ?>:</strong> <?php echo e($item['solution']); ?></p>
        </div>
      </details>
      <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </div>
  </div>
</section>
<?php endif; ?>
<?php /**PATH C:\Users\nikol\Documents\projects\cityee-laravel\resources\views/partials/sell-fears-30.blade.php ENDPATH**/ ?>