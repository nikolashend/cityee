<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag;

$__newAttributes = [];
$__propNames = \Illuminate\View\ComponentAttributeBag::extractPropNames((['src', 'alt' => '', 'class' => '', 'width' => null, 'height' => null, 'loading' => 'lazy', 'decoding' => 'async', 'fetchpriority' => null]));

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

foreach (array_filter((['src', 'alt' => '', 'class' => '', 'width' => null, 'height' => null, 'loading' => 'lazy', 'decoding' => 'async', 'fetchpriority' => null]), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
}

$__defined_vars = get_defined_vars();

foreach ($attributes->all() as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
}

unset($__defined_vars, $__key, $__value); ?>
<?php
    $webp = preg_replace('/\.(jpe?g|png)$/i', '.webp', $src);
?>
<picture>
    <source srcset="<?php echo e($webp); ?>" type="image/webp">
    <img src="<?php echo e($src); ?>"
         alt="<?php echo e($alt); ?>"
         <?php if($class): ?> class="<?php echo e($class); ?>" <?php endif; ?>
         <?php if($width): ?> width="<?php echo e($width); ?>" <?php endif; ?>
         <?php if($height): ?> height="<?php echo e($height); ?>" <?php endif; ?>
         loading="<?php echo e($loading); ?>"
         decoding="<?php echo e($decoding); ?>"
         <?php if($fetchpriority): ?> fetchpriority="<?php echo e($fetchpriority); ?>" <?php endif; ?>
    >
</picture>
<?php /**PATH C:\Users\nikol\Documents\projects\cityee-laravel\resources\views/components/webp-img.blade.php ENDPATH**/ ?>