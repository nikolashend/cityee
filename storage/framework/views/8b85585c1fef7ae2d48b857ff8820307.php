
<?php if(!empty($table)): ?>
<div class="comparison-table-wrap">
  <div class="v3-table-wrap" role="region" tabindex="0">
    <table class="v3-table comparison-table">
      <thead>
        <tr>
          <?php $__currentLoopData = $table['headers']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $header): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
          <th><?php echo e($header); ?></th>
          <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </tr>
      </thead>
      <tbody>
        <?php $__currentLoopData = $table['rows']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <tr>
          <td><strong><?php echo e($row[0]); ?></strong></td>
          <td><?php echo e($row[1]); ?></td>
          <td class="comparison-highlight"><?php echo e($row[2]); ?></td>
        </tr>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
      </tbody>
    </table>
  </div>
</div>
<?php endif; ?>
<?php /**PATH C:\Users\nikol\Documents\projects\cityee-laravel\resources\views/partials/comparison-table.blade.php ENDPATH**/ ?>