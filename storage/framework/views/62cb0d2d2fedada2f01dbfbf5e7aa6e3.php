
<?php
    $microCopy = [
        'et' => [
            'sticky'  => 'Saada kuulutuse link — tasuta audit 24h jooksul',
            'btn'     => 'Soovin auditi',
            'inline'  => 'Kas teie kuulutus töötab? Saatke link ja saate 24h tagasiside.',
            'phone'   => 'Helista kohe',
            'wa'      => 'Kirjuta WhatsAppi',
        ],
        'ru' => [
            'sticky'  => 'Отправьте ссылку — бесплатный аудит за 24ч',
            'btn'     => 'Хочу аудит',
            'inline'  => 'Ваше объявление работает? Отправьте ссылку и получите разбор за 24ч.',
            'phone'   => 'Позвонить сейчас',
            'wa'      => 'Написать в WhatsApp',
        ],
        'en' => [
            'sticky'  => 'Send listing link — free audit within 24h',
            'btn'     => 'Get audit',
            'inline'  => 'Is your listing working? Send the link and get feedback within 24h.',
            'phone'   => 'Call now',
            'wa'      => 'WhatsApp us',
        ],
    ];
    $mc = $microCopy[$locale] ?? $microCopy['et'];
    $phone = config('cityee.company.phone', '+3725113411');
    $wa    = config('cityee.company.whatsapp', 'https://wa.me/3725113411');
?>


<section class="micro-cta-inline">
  <div class="container">
    <div class="micro-cta-box">
      <p><?php echo e($mc['inline']); ?></p>
      <div class="micro-cta-actions">
        <a href="#v3-form-audit" class="btn btn-primary"><?php echo e($mc['btn']); ?></a>
        <a href="tel:<?php echo e($phone); ?>" class="btn btn-outline" data-track-lead="phone"><?php echo e($mc['phone']); ?></a>
        <a href="<?php echo e($wa); ?>" target="_blank" rel="noopener" class="btn btn-outline btn--wa" data-track-lead="whatsapp"><?php echo e($mc['wa']); ?></a>
      </div>
    </div>
  </div>
</section>
<?php /**PATH C:\Users\nikol\Documents\projects\cityee-laravel\resources\views/partials/micro-conversion.blade.php ENDPATH**/ ?>