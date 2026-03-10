
<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag;

$__newAttributes = [];
$__propNames = \Illuminate\View\ComponentAttributeBag::extractPropNames((['locale']));

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

foreach (array_filter((['locale']), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
}

$__defined_vars = get_defined_vars();

foreach ($attributes->all() as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
}

unset($__defined_vars, $__key, $__value); ?>
<?php
    $f = config("cityee-v3.forms.{$locale}");
?>

<section class="v3-form-section" id="v3-form-calc" aria-labelledby="v3-form-calc-title">
    <div class="container">
        <h2 id="v3-form-calc-title" class="v3-section-title"><?php echo e($f['calc_title']); ?></h2>

        <form class="v3-form" data-v3-form="price-calculator" action="/contact/price-calculator" method="POST">
            <?php echo csrf_field(); ?>
            <input type="hidden" name="locale" value="<?php echo e($locale); ?>">

            <div class="v3-form__group">
                <label for="calc_address"><?php echo e($f['calc_address']); ?></label>
                <input type="text" id="calc_address" name="address" required class="v3-form__input">
            </div>

            <div class="v3-form__row">
                <div class="v3-form__group v3-form__group--half">
                    <label for="calc_area"><?php echo e($f['calc_area']); ?></label>
                    <input type="number" id="calc_area" name="area" min="1" class="v3-form__input">
                </div>
                <div class="v3-form__group v3-form__group--half">
                    <label for="calc_rooms"><?php echo e($f['calc_rooms']); ?></label>
                    <input type="number" id="calc_rooms" name="rooms" min="1" max="20" class="v3-form__input">
                </div>
            </div>

            <div class="v3-form__group">
                <label for="calc_floor"><?php echo e($f['calc_floor']); ?></label>
                <input type="text" id="calc_floor" name="floor" class="v3-form__input">
            </div>

            <div class="v3-form__group">
                <label for="calc_condition"><?php echo e($f['calc_condition']); ?></label>
                <select id="calc_condition" name="condition" class="v3-form__input">
                    <?php $__currentLoopData = $f['calc_conditions']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $cond): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option value="<?php echo e($cond); ?>"><?php echo e($cond); ?></option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
            </div>

            <div class="v3-form__group">
                <label for="calc_contact"><?php echo e($f['calc_contact']); ?></label>
                <input type="text" id="calc_contact" name="contact" required class="v3-form__input">
            </div>

            <button type="submit" class="v3-btn v3-btn--primary v3-btn--full"><?php echo e($f['calc_submit']); ?></button>

            <p class="v3-form__success" style="display:none;" role="status"><?php echo e($f['success_msg']); ?></p>
        </form>
    </div>
</section>
<?php /**PATH C:\Users\nikol\Documents\projects\cityee-laravel\resources\views/components/v3/form-calc.blade.php ENDPATH**/ ?>