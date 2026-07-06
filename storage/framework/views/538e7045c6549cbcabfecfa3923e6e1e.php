
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

<section class="v3-form-section" id="v3-form-audit" aria-labelledby="v3-form-audit-title">
    <div class="container">
        <h2 id="v3-form-audit-title" class="v3-section-title"><?php echo e($f['audit_title']); ?></h2>

        <form class="v3-form" data-v3-form="audit-request" action="/contact/audit-request" method="POST">
            <?php echo csrf_field(); ?>
            <input type="hidden" name="locale" value="<?php echo e($locale); ?>">

            <div class="v3-form__group">
                <label for="audit_link"><?php echo e($f['audit_link']); ?></label>
                <input type="url" id="audit_link" name="link" placeholder="https://" class="v3-form__input">
            </div>

            <div class="v3-form__group">
                <label for="audit_district"><?php echo e($f['audit_district']); ?></label>
                <input type="text" id="audit_district" name="district" class="v3-form__input">
            </div>

            <div class="v3-form__row">
                <div class="v3-form__group v3-form__group--half">
                    <label for="audit_type"><?php echo e($f['audit_type']); ?></label>
                    <select id="audit_type" name="type" class="v3-form__input">
                        <option value="apartment"><?php echo e($f['type_apartment']); ?></option>
                        <option value="house"><?php echo e($f['type_house']); ?></option>
                        <option value="commercial"><?php echo e($f['type_commercial']); ?></option>
                    </select>
                </div>
                <div class="v3-form__group v3-form__group--half">
                    <label for="audit_goal"><?php echo e($f['audit_goal']); ?></label>
                    <select id="audit_goal" name="goal" class="v3-form__input">
                        <option value="sell"><?php echo e($f['goal_sell']); ?></option>
                        <option value="rent"><?php echo e($f['goal_rent']); ?></option>
                    </select>
                </div>
            </div>

            <div class="v3-form__group">
                <label for="audit_contact"><?php echo e($f['audit_contact']); ?></label>
                <input type="text" id="audit_contact" name="contact" required class="v3-form__input">
            </div>

            <div class="v3-form__group">
                <label for="audit_lang"><?php echo e($f['audit_lang']); ?></label>
                <select id="audit_lang" name="language" class="v3-form__input">
                    <option value="et"><?php echo e($f['lang_et']); ?></option>
                    <option value="ru" <?php if($locale==='ru'): ?> selected <?php endif; ?>><?php echo e($f['lang_ru']); ?></option>
                    <option value="en" <?php if($locale==='en'): ?> selected <?php endif; ?>><?php echo e($f['lang_en']); ?></option>
                </select>
            </div>

            <button type="submit" class="v3-btn v3-btn--primary v3-btn--full"><?php echo e($f['audit_submit']); ?></button>

            <p class="v3-form__success" style="display:none;" role="status"><?php echo e($f['success_msg']); ?></p>
        </form>
    </div>
</section>
<?php /**PATH C:\Users\nikol\Documents\projects\cityee-laravel\resources\views/components/v3/form-audit.blade.php ENDPATH**/ ?>