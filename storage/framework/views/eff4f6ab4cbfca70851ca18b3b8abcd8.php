
<?php
    $ir = config("cityee-knowledge.inaction_risks.{$locale}", []);
?>

<?php if(!empty($ir['risks'])): ?>
<section class="inaction-risks" id="inaction-risks">
  <div class="container">
    <h2><?php echo e($ir['title']); ?></h2>
    <div class="inaction-risks-grid">
      <?php $__currentLoopData = $ir['risks']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $i => $risk): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
      <div class="risk-card">
        <div class="risk-card__num"><?php echo e($i + 1); ?></div>
        <h3 class="risk-card__title"><?php echo e($risk['title']); ?></h3>
        <p class="risk-card__text"><?php echo e($risk['text']); ?></p>
      </div>
      <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </div>
  </div>
</section>
<?php endif; ?>
<?php /**PATH C:\Users\nikol\Documents\projects\cityee-laravel\resources\views/partials/inaction-risks.blade.php ENDPATH**/ ?>