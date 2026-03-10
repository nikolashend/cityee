
<?php if(!empty($faq)): ?>
<section class="faq-section">
  <div class="container">
    <h2 class="main-h2"><?php echo e($faqTitle ?? 'FAQ'); ?></h2>
    <div class="faq-list">
      <?php $__currentLoopData = $faq; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $i => $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <div class="faq-item">
          <div class="faq-question" role="button" tabindex="0" aria-expanded="false" onclick="this.parentElement.classList.toggle('active');this.setAttribute('aria-expanded',this.parentElement.classList.contains('active'))">
            <h3 style="font-size:inherit;margin:0;font-weight:inherit;"><?php echo e($item['q']); ?></h3>
          </div>
          <div class="faq-answer">
            <p><?php echo e($item['a']); ?></p>
          </div>
        </div>
      <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </div>
  </div>
</section>
<?php endif; ?>
<?php /**PATH C:\Users\nikol\Documents\projects\cityee-laravel\resources\views/partials/faq.blade.php ENDPATH**/ ?>