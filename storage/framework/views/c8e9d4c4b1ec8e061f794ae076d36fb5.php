
<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag;

$__newAttributes = [];
$__propNames = \Illuminate\View\ComponentAttributeBag::extractPropNames((['v3', 'company']));

foreach ($attributes->all() as $__key => $__value) {
    if (in_array($__key, $__propNames)) {
        $$__key = $$__key ?? $__value;
    } else {
        $__newAttributes[$__key] = $__value;
    }
}

$attributes = new \Illuminate\View\ComponentAttributeBag($__newAttributes);

unset($__propNames);
unset($__newAttributes);

foreach (array_filter((['v3', 'company']), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
}

$__defined_vars = get_defined_vars();

foreach ($attributes->all() as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
}

unset($__defined_vars, $__key, $__value); ?>
<?php
    $wa = config('cityee.company.whatsapp', 'https://wa.me/3725113411');
?>

<?php if(!empty($v3['cases'])): ?>
<section class="v3-cases" aria-labelledby="v3-cases-title">
    <div class="container">
        <h2 id="v3-cases-title" class="v3-section-title"><?php echo e($v3['cases_title']); ?></h2>

        <div class="v3-cases__grid">
            <?php $__currentLoopData = $v3['cases']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $c): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <article class="v3-cases__card">
                <p class="v3-cases__type"><strong><?php echo e($c['type']); ?></strong></p>
                <p class="v3-cases__problem"><?php echo e($c['problem']); ?></p>
                <ul class="v3-cases__actions">
                    <?php $__currentLoopData = $c['actions']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $a): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <li><?php echo e($a); ?></li>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </ul>
                <p class="v3-cases__result"><strong>&#10003;</strong> <?php echo e($c['result']); ?></p>
            </article>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>

        <?php if(!empty($v3['cases_cta'])): ?>
        <div class="v3-cases__cta-row">
            <a href="" id="feedback-cases" class="v3-btn v3-btn--primary">
                <?php echo e($v3['cases_cta']); ?>

            </a>
        </div>
        <?php endif; ?>
    </div>
</section>
<?php endif; ?>
<?php /**PATH C:\Users\nikol\Documents\projects\cityee-laravel\resources\views/components/v3/cases.blade.php ENDPATH**/ ?>