
<?php
    $value = config("cityee-intent.sell_value_20.{$locale}", []);
?>

<?php if(!empty($value['items'])): ?>
<section class="sell-value-20" id="value-20">
  <div class="container">
    <h2><?php echo e($value['title']); ?></h2>
    <div class="value-grid">
      <?php $__currentLoopData = $value['items']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $i => $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
      <div class="value-card">
        <div class="value-card__num"><?php echo e($i + 1); ?></div>
        <h3 class="value-card__title"><?php echo e($item['title']); ?></h3>
        <p class="value-card__desc"><?php echo e($item['desc']); ?></p>
      </div>
      <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </div>
  </div>
</section>
<?php endif; ?>
<?php /**PATH C:\Users\nikol\Documents\projects\cityee-laravel\resources\views/partials/sell-value-20.blade.php ENDPATH**/ ?>