
<?php
    $cases = config('cityee-knowledge.cases', []);
    $displayCases = isset($limit) ? array_slice($cases, 0, $limit) : $cases;
?>

<?php if(!empty($displayCases)): ?>
<section class="case-intelligence" id="cases">
  <div class="container">
    <h2><?php echo e($locale === 'ru' ? 'Реальные кейсы CityEE' : ($locale === 'en' ? 'Real CityEE Cases' : 'CityEE tegelikud juhtumid')); ?></h2>
    <p class="case-intelligence__sub"><?php echo e($locale === 'ru' ? 'Конкретные объекты, конкретные результаты.' : ($locale === 'en' ? 'Real properties, real results.' : 'Konkreetsed objektid, konkreetsed tulemused.')); ?></p>

    <div class="cases-grid">
      <?php $__currentLoopData = $displayCases; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $case): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
      <div class="case-card">
        <div class="case-card__header">
          <span class="case-card__object">🏠 <?php echo e($case['object'][$locale] ?? $case['object']['en']); ?></span>
          <span class="case-card__days"><?php echo e($case['timeframe']); ?> <?php echo e($locale === 'ru' ? 'дн.' : ($locale === 'en' ? 'days' : 'p.')); ?></span>
        </div>
        <div class="case-card__body">
          <div class="case-card__row">
            <span class="case-card__label"><?php echo e($locale === 'ru' ? 'Проблема' : ($locale === 'en' ? 'Problem' : 'Probleem')); ?></span>
            <span><?php echo e($case['problem'][$locale] ?? $case['problem']['en']); ?></span>
          </div>
          <div class="case-card__row">
            <span class="case-card__label"><?php echo e($locale === 'ru' ? 'Причина' : ($locale === 'en' ? 'Root cause' : 'Põhjus')); ?></span>
            <span><?php echo e($case['issue'][$locale] ?? $case['issue']['en']); ?></span>
          </div>
          <div class="case-card__row">
            <span class="case-card__label"><?php echo e($locale === 'ru' ? 'Что сделали' : ($locale === 'en' ? 'Action' : 'Tegevus')); ?></span>
            <span><?php echo e($case['action'][$locale] ?? $case['action']['en']); ?></span>
          </div>
          <div class="case-card__row case-card__row--result">
            <span class="case-card__label"><?php echo e($locale === 'ru' ? 'Результат' : ($locale === 'en' ? 'Result' : 'Tulemus')); ?></span>
            <span><?php echo e($case['result'][$locale] ?? $case['result']['en']); ?></span>
          </div>
          <div class="case-card__diff"><?php echo e($case['price_diff'][$locale] ?? $case['price_diff']['en']); ?></div>
        </div>
      </div>
      <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </div>

    <?php if(isset($limit) && count($cases) > $limit): ?>
    <div class="text-center" style="margin-top:25px">
      <a href="<?php echo e(route("{$locale}.cases")); ?>" class="btn btn-outline-primary"><?php echo e($locale === 'ru' ? 'Все кейсы' : ($locale === 'en' ? 'All cases' : 'Kõik juhtumid')); ?> →</a>
    </div>
    <?php endif; ?>
  </div>
</section>
<?php endif; ?>
<?php /**PATH C:\Users\nikol\Documents\projects\cityee-laravel\resources\views/partials/case-cards.blade.php ENDPATH**/ ?>