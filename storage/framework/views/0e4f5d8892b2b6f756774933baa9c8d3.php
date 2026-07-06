
<?php
    $strategies = config("cityee-intent.sell_strategies_20.{$locale}", []);
?>

<?php if(!empty($strategies['items'])): ?>
<section class="sell-strategies-20" id="strategies-20">
  <div class="container">
    <h2><?php echo e($strategies['title']); ?></h2>
    <div class="strategies-grid">
      <?php $__currentLoopData = $strategies['items']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $i => $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
      <div class="strategy-card">
        <div class="strategy-card__num"><?php echo e($i + 1); ?></div>
        <h3 class="strategy-card__title"><?php echo e($item['title']); ?></h3>
        <p class="strategy-card__desc"><?php echo e($item['desc']); ?></p>
      </div>
      <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </div>
  </div>
</section>
<?php endif; ?>
<?php /**PATH C:\Users\nikol\Documents\projects\cityee-laravel\resources\views/partials/sell-strategies-20.blade.php ENDPATH**/ ?>