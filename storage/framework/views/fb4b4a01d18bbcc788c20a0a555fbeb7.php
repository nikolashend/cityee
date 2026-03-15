
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
    $cfg   = config("cityee-v3.agent_trust.{$locale}");
    $links = config('cityee-v3.social_links');
    $agent = config('cityee.agent');
    $photo = $agent['photo'] ?? '/assets/templates/offshors/img/ap1.png';
?>

<section class="v3-trust-agent" aria-label="<?php echo e($cfg['name']); ?>">
    <div class="container">
        <div class="v3-trust-agent__inner">
            <div class="v3-trust-agent__photo-col">
                <img src="<?php echo e($photo); ?>" alt="<?php echo e($cfg['name']); ?>" class="v3-trust-agent__img" width="240" height="300" loading="lazy">
            </div>
            <div class="v3-trust-agent__info">
                <h2 class="v3-trust-agent__name"><?php echo e($cfg['name']); ?></h2>
                <p class="v3-trust-agent__role"><?php echo e($cfg['role']); ?></p>
                <p class="v3-trust-agent__location"><i class="fa fa-map-marker" aria-hidden="true"></i> <?php echo e($cfg['location']); ?></p>

                <ul class="v3-trust-agent__points">
                    <?php $__currentLoopData = $cfg['points']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $pt): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <li><span class="v3-trust-agent__check">&#10003;</span> <?php echo e($pt); ?></li>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </ul>

                <div class="v3-trust-agent__socials">
                    <a href="<?php echo e($links['linkedin']); ?>" target="_blank" rel="noopener" aria-label="LinkedIn" title="LinkedIn"><i class="fa fa-linkedin"></i></a>
                    <a href="<?php echo e($links['instagram']); ?>" target="_blank" rel="noopener" aria-label="Instagram" title="Instagram"><i class="fa fa-instagram"></i></a>
                    <a href="<?php echo e($links['facebook']); ?>" target="_blank" rel="noopener" aria-label="Facebook" title="Facebook"><i class="fa fa-facebook"></i></a>
                    <a href="<?php echo e($links['tg_channel']); ?>" target="_blank" rel="noopener" aria-label="Telegram" title="Telegram"><i class="fa fa-telegram"></i></a>
                    <a href="<?php echo e($links['whatsapp_audit']); ?>" target="_blank" rel="noopener" aria-label="WhatsApp" title="WhatsApp"><i class="fa fa-whatsapp"></i></a>
                </div>
            </div>
        </div>
    </div>
</section>
<?php /**PATH C:\Users\nikol\Documents\projects\cityee-laravel\resources\views/components/v3/trust-agent.blade.php ENDPATH**/ ?>