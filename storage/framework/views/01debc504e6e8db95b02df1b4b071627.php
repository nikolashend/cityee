
<?php
    $tp = config("cityee-knowledge.trust_protection.{$locale}", []);
?>

<?php if(!empty($tp['items'])): ?>
<section class="trust-protection" id="trust-protection">
  <div class="container">
    <h2><?php echo e($tp['title']); ?></h2>
    <div class="trust-protection-grid">
      <?php $__currentLoopData = $tp['items']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
      <div class="trust-prot-card">
        <span class="trust-prot-card__icon"><?php echo e($item['icon']); ?></span>
        <h3 class="trust-prot-card__title"><?php echo e($item['title']); ?></h3>
        <p class="trust-prot-card__text"><?php echo e($item['text']); ?></p>
      </div>
      <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </div>
  </div>
</section>
<?php endif; ?>
<?php /**PATH C:\Users\nikol\Documents\projects\cityee-laravel\resources\views/partials/trust-protection.blade.php ENDPATH**/ ?>