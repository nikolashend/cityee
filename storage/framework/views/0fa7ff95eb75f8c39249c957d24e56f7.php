
<?php
    $locale = $locale ?? app()->getLocale();
    $title  = $locale === 'ru' ? 'Частые вопросы (голосовой поиск)' : ($locale === 'en' ? 'Voice Search Q&A' : 'Häälotsingu KKK');
?>
<?php if(!empty($items)): ?>
<section class="v3-voice-qa" aria-label="<?php echo e($title); ?>">
  <h2 class="v3-section-title"><?php echo e($title); ?></h2>
  <div class="v3-voice-qa__list">
    <?php $__currentLoopData = $items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
    <div class="v3-voice-qa__item" itemscope itemtype="https://schema.org/Question">
      <h3 class="v3-voice-qa__question" itemprop="name"><?php echo e($item['q']); ?></h3>
      <div class="v3-voice-qa__answer" itemscope itemtype="https://schema.org/Answer" itemprop="acceptedAnswer">
        <p itemprop="text"><?php echo e($item['a']); ?></p>
      </div>
    </div>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
  </div>
</section>
<?php endif; ?>
<?php /**PATH C:\Users\nikol\Documents\projects\cityee-laravel\resources\views/components/v3/voice-answer.blade.php ENDPATH**/ ?>