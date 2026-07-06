
<?php
    $locale = $locale ?? app()->getLocale();
    $metrics = [
        [
            'value' => '10+',
            'label' => ['et' => 'aastat kogemust', 'ru' => 'лет опыта', 'en' => 'years experience'],
        ],
        [
            'value' => '300+',
            'label' => ['et' => 'tehingut', 'ru' => 'сделок', 'en' => 'deals closed'],
        ],
        [
            'value' => '45',
            'label' => ['et' => 'päeva kes. müük', 'ru' => 'дней ср. продажа', 'en' => 'avg days to sell'],
        ],
        [
            'value' => '⭐ 5.0',
            'label' => ['et' => 'Google hinnang', 'ru' => 'рейтинг Google', 'en' => 'Google rating'],
        ],
    ];
?>
<div class="trust-metrics-bar" role="complementary" aria-label="Trust metrics" style="background:#f8f9fb;padding:1.25rem 0;border-bottom:1px solid #e8e9ed">
    <div class="container">
        <div style="display:flex;justify-content:center;gap:2.5rem;flex-wrap:wrap;text-align:center">
            <?php $__currentLoopData = $metrics; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $m): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div>
                <div style="font-size:1.4rem;font-weight:700;color:var(--ce-accent,#4ecdc4)"><?php echo e($m['value']); ?></div>
                <div style="font-size:.75rem;opacity:.6;text-transform:uppercase;letter-spacing:.5px"><?php echo e($m['label'][$locale] ?? $m['label']['en']); ?></div>
            </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
    </div>
</div>
<?php /**PATH C:\Users\nikol\Documents\projects\cityee-laravel\resources\views/partials/trust-metrics.blade.php ENDPATH**/ ?>