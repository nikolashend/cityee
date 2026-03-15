
<?php $ui = $ui ?? config('cityee.ui.' . ($locale ?? 'et')); ?>

<section class="advantages<?php echo e(isset($isPage) && $isPage ? ' advantages--page' : ''); ?>">
  <div class="container">
    <h2 class="advantages__title"><?php echo e($ui['advantages_title'] ?? 'Meiega koostöö eelised'); ?></h2>
    <ul class="advantages__list">
      <li class="advantages__item">
        <div class="advantages__img advantages__img--speed"></div>
        <p class="advantages__text"><?php echo e($ui['adv_speed']); ?></p>
      </li>
      <li class="advantages__item">
        <div class="advantages__img advantages__img--availability"></div>
        <p class="advantages__text"><?php echo e($ui['adv_quality']); ?></p>
      </li>
      <li class="advantages__item">
        <div class="advantages__img advantages__img--confidentiality"></div>
        <p class="advantages__text"><?php echo e($ui['adv_confid']); ?></p>
      </li>
      <li class="advantages__item">
        <div class="advantages__img advantages__img--reliability"></div>
        <p class="advantages__text"><?php echo e($ui['adv_reliable']); ?></p>
      </li>
    </ul>
  </div>
</section>
<?php /**PATH C:\Users\nikol\Documents\projects\cityee-laravel\resources\views/partials/advantages.blade.php ENDPATH**/ ?>