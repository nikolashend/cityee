
<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag;

$__newAttributes = [];
$__propNames = \Illuminate\View\ComponentAttributeBag::extractPropNames((['v3']));

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

foreach (array_filter((['v3']), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
}

$__defined_vars = get_defined_vars();

foreach ($attributes->all() as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
}

unset($__defined_vars, $__key, $__value); ?>

<section class="v3-outcomes" aria-labelledby="v3-outcomes-title">
    <div class="container">
        <h2 id="v3-outcomes-title" class="v3-section-title"><?php echo e($v3['outcomes_title']); ?></h2>
        <div class="v3-outcomes__grid">
            <?php $__currentLoopData = $v3['outcomes']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $o): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <article class="v3-outcomes__card">
                <span class="v3-outcomes__icon" aria-hidden="true"><?php echo e($o['icon']); ?></span>
                <h3 class="v3-outcomes__card-title"><?php echo e($o['title']); ?></h3>
                <p class="v3-outcomes__desc"><?php echo e($o['desc']); ?></p>
            </article>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
    </div>
</section>
<?php /**PATH C:\Users\nikol\Documents\projects\cityee-laravel\resources\views/components/v3/outcomes.blade.php ENDPATH**/ ?>