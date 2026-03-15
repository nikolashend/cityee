
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

<section class="v3-process" aria-labelledby="v3-process-title">
    <div class="container">
        <h2 id="v3-process-title" class="v3-section-title"><?php echo e($v3['process_title']); ?></h2>
        <ol class="v3-process__steps">
            <?php $__currentLoopData = $v3['process']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $s): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <li class="v3-process__step">
                <span class="v3-process__num" aria-hidden="true"><?php echo e($s['step']); ?></span>
                <div class="v3-process__body">
                    <h3 class="v3-process__step-title"><?php echo e($s['title']); ?></h3>
                    <p class="v3-process__desc"><?php echo e($s['desc']); ?></p>
                </div>
            </li>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </ol>
    </div>
</section>
<?php /**PATH C:\Users\nikol\Documents\projects\cityee-laravel\resources\views/components/v3/process.blade.php ENDPATH**/ ?>