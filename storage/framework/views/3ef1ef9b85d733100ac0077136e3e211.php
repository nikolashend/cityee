
<?php
    $da = config("cityee-knowledge.data_authority.{$locale}", []);
?>

<?php if(!empty($da['metrics'])): ?>
<section class="data-authority" id="market-data">
  <div class="container">
    <h2><?php echo e($da['title']); ?></h2>
    <p class="data-authority__updated"><?php echo e($da['updated']); ?></p>

    <div class="data-metrics-grid">
      <?php $__currentLoopData = $da['metrics']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $m): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
      <div class="data-metric-card">
        <div class="data-metric-card__value"><?php echo e($m['value']); ?></div>
        <div class="data-metric-card__label"><?php echo e($m['label']); ?></div>
        <div class="data-metric-card__note"><?php echo e($m['note']); ?></div>
      </div>
      <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </div>

    <?php if(!empty($da['districts'])): ?>
    <div class="data-districts-table">
      <h3><?php echo e($locale === 'ru' ? 'Цены по районам' : ($locale === 'en' ? 'Prices by District' : 'Hinnad piirkonniti')); ?></h3>
      <div class="v3-table-wrap" role="region" tabindex="0">
        <table class="v3-table">
          <thead>
            <tr>
              <th><?php echo e($locale === 'ru' ? 'Район' : ($locale === 'en' ? 'District' : 'Piirkond')); ?></th>
              <th><?php echo e($locale === 'ru' ? 'Цена/м²' : ($locale === 'en' ? 'Price/m²' : 'Hind/m²')); ?></th>
              <th><?php echo e($locale === 'ru' ? 'Ср. дней' : ($locale === 'en' ? 'Avg days' : 'Kes. päevi')); ?></th>
              <th><?php echo e($locale === 'ru' ? 'Спрос' : ($locale === 'en' ? 'Demand' : 'Nõudlus')); ?></th>
            </tr>
          </thead>
          <tbody>
            <?php $__currentLoopData = $da['districts']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $d): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <tr>
              <td><strong><?php echo e($d['name']); ?></strong></td>
              <td><?php echo e($d['price']); ?></td>
              <td><?php echo e($d['avg_days']); ?></td>
              <td><?php echo e($d['demand']); ?></td>
            </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
          </tbody>
        </table>
      </div>
    </div>
    <?php endif; ?>
  </div>
</section>
<?php endif; ?>
<?php /**PATH C:\Users\nikol\Documents\projects\cityee-laravel\resources\views/partials/data-authority.blade.php ENDPATH**/ ?>