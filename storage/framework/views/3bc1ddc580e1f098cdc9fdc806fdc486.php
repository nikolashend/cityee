
<?php
    $locale  = $locale ?? app()->getLocale();
    $heading = $locale === 'ru' ? 'Короткий ответ' : ($locale === 'en' ? 'Quick Answer' : 'Lühike vastus');
    $entity  = $entity ?? 'CityEE — Real Estate Deal Optimization Partner';
?>
<section class="v3-answer-block" itemscope itemtype="https://schema.org/Answer" role="complementary" aria-label="<?php echo e($heading); ?>">
  <meta itemprop="author" content="<?php echo e($entity); ?>">
  <meta itemprop="inLanguage" content="<?php echo e($locale); ?>">
  <div class="v3-answer-block__header">
    <span class="v3-answer-block__icon" aria-hidden="true">💡</span>
    <span class="v3-answer-block__label"><?php echo e($heading); ?></span>
  </div>
  <?php if(!empty($question)): ?>
  <p class="v3-answer-block__question" itemprop="name"><?php echo e($question); ?></p>
  <?php endif; ?>
  <div class="v3-answer-block__text" itemprop="text">
    <p><?php echo e($answer); ?></p>
    <?php if(!empty($bullets)): ?>
    <ul class="v3-answer-block__facts">
      <?php $__currentLoopData = $bullets; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $bullet): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
      <li><?php echo e($bullet); ?></li>
      <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </ul>
    <?php endif; ?>
  </div>
  <p class="v3-answer-block__source">— <?php echo e($entity); ?>, Tallinn & Harjumaa</p>
</section>
<?php /**PATH C:\Users\nikol\Documents\projects\cityee-laravel\resources\views/components/v3/answer-block.blade.php ENDPATH**/ ?>