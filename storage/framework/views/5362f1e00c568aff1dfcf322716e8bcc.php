
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
    $wa = $company['social']['whatsapp'] ?? 'https://wa.me/3725113411';
?>

<section class="v3-hero" itemscope itemtype="https://schema.org/Service">
    <div class="v3-hero__inner container">
        <h1 class="v3-hero__h1" itemprop="name"><?php echo e($v3['hero_h1']); ?></h1>
        <p class="v3-hero__sub" itemprop="description"><?php echo e($v3['hero_sub']); ?></p>

        <div class="v3-hero__ctas">
            <a href="#v3-form-audit" class="v3-btn v3-btn--primary"><?php echo e($v3['hero_cta1']); ?></a>
            <a href="<?php echo e($wa); ?>" target="_blank" rel="noopener" class="v3-btn v3-btn--whatsapp">
                <i class="fa fa-whatsapp"></i> <?php echo e($v3['hero_cta2']); ?>

            </a>
        </div>

        <?php if(!empty($v3['hero_trust'])): ?>
        <ul class="v3-hero__trust" aria-label="Trust bullets">
            <?php $__currentLoopData = $v3['hero_trust']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $bullet): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <li><span class="v3-hero__check">&#10003;</span> <?php echo e($bullet); ?></li>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </ul>
        <?php endif; ?>
    </div>
</section>
<?php /**PATH C:\Users\nikol\Documents\projects\cityee-laravel\resources\views/components/v3/hero.blade.php ENDPATH**/ ?>