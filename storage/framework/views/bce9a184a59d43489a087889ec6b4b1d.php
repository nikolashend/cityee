
<?php
    $jtbd30 = config("cityee-intent.sell_jtbd_30.{$locale}", []);
?>

<?php if(!empty($jtbd30['items'])): ?>
<section class="sell-jtbd-30" id="jtbd-30">
  <div class="container">
    <h2><?php echo e($jtbd30['title']); ?></h2>
    <div class="jtbd-30-grid">
      <?php $__currentLoopData = $jtbd30['items']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $i => $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
      <div class="jtbd-30-item">
        <span class="jtbd-30-num"><?php echo e($i + 1); ?></span>
        <span class="jtbd-30-text"><?php echo e($item); ?></span>
      </div>
      <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </div>
    <div class="jtbd-30-cta">
      <p><?php echo e($locale === 'ru' ? 'CityEE берёт все 30 задач на себя.' : ($locale === 'en' ? 'CityEE handles all 30 tasks for you.' : 'CityEE võtab kõik 30 ülesannet enda peale.')); ?></p>
      <a href="#v3-form-audit" class="btn btn-primary"><?php echo e($locale === 'ru' ? 'Узнать подробнее' : ($locale === 'en' ? 'Learn more' : 'Loe lähemalt')); ?></a>
    </div>
  </div>
</section>
<?php endif; ?>
<?php /**PATH C:\Users\nikol\Documents\projects\cityee-laravel\resources\views/partials/sell-jtbd-30.blade.php ENDPATH**/ ?>