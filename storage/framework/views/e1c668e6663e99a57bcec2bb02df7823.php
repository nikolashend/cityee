
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

<?php if(!empty($v3['ai_short'])): ?>
<section class="v3-ai-chunks" aria-labelledby="v3-ai-short-title" data-nosnippet>
    <div class="container">
        
        <div class="v3-ai-chunk">
            <h2 id="v3-ai-short-title" class="v3-ai-chunk__title"><?php echo e($v3['ai_short_title']); ?></h2>
            <p class="v3-ai-chunk__text"><?php echo e($v3['ai_short']); ?></p>
        </div>

        
        <?php if(!empty($v3['ai_bullets'])): ?>
        <div class="v3-ai-chunk">
            <h3 class="v3-ai-chunk__title"><?php echo e($v3['ai_bullets_title']); ?></h3>
            <ul class="v3-ai-chunk__list">
                <?php $__currentLoopData = $v3['ai_bullets']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $b): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <li><?php echo e($b); ?></li>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </ul>
        </div>
        <?php endif; ?>

        
        <?php if(!empty($v3['ai_next'])): ?>
        <div class="v3-ai-chunk">
            <h3 class="v3-ai-chunk__title"><?php echo e($v3['ai_next_title']); ?></h3>
            <ol class="v3-ai-chunk__list v3-ai-chunk__list--numbered">
                <?php $__currentLoopData = $v3['ai_next']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $step): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <li><?php echo e($step); ?></li>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </ol>
        </div>
        <?php endif; ?>
    </div>
</section>
<?php endif; ?>
<?php /**PATH C:\Users\nikol\Documents\projects\cityee-laravel\resources\views/components/v3/ai-chunks.blade.php ENDPATH**/ ?>