
<?php
    $intentPages = [
        'no_calls'       => ['et' => 'Müüte ise, aga keegi ei helista?',         'ru' => 'Продаёте сами, но никто не звонит?',        'en' => 'Selling Yourself but No Calls?',        'icon' => '📞'],
        'no_offers'      => ['et' => 'Vaatamised on, aga pakkumisi pole?',       'ru' => 'Просмотры есть, но предложений нет?',        'en' => 'Viewings But No Offers?',                  'icon' => '👀'],
        'price_analysis' => ['et' => 'Kinnisvara hinnaanalüüs Tallinnas',        'ru' => 'Анализ цены недвижимости в Таллинне',        'en' => 'Property Price Analysis Tallinn',            'icon' => '💰'],
        'mistakes'       => ['et' => 'Vead kinnisvara müümisel',                 'ru' => 'Ошибки при продаже недвижимости',             'en' => 'Mistakes When Selling Property',             'icon' => '⚠️'],
        'sell_faster'    => ['et' => 'Kuidas müüa kiiremini?',                   'ru' => 'Как продать быстрее?',                        'en' => 'How to Sell Faster?',                        'icon' => '⚡'],
        'listing_audit'  => ['et' => 'Kuulutuse audit',                          'ru' => 'Аудит объявления',                            'en' => 'Listing Audit',                              'icon' => '🔍'],
        'comparison'     => ['et' => 'Müüa ise vs strateegiline partner',        'ru' => 'Продавать самому или через партнёра',          'en' => 'Sell Yourself vs Strategy Partner',          'icon' => '⚖️'],
    ];
    $sellLabel = ['et' => 'Kinnisvara müük', 'ru' => 'Продажа недвижимости', 'en' => 'Sell Property'];
?>

<section class="intent-crosslinks">
  <div class="container">
    <h2><?php echo e($locale === 'ru' ? 'Полезные материалы для собственников' : ($locale === 'en' ? 'Helpful Resources for Property Owners' : 'Kasulikud materjalid omanikele')); ?></h2>
    <div class="crosslinks-grid">
      
      <a href="<?php echo e(route("{$locale}.sell")); ?>" class="crosslink-card crosslink-card--primary">
        <span class="crosslink-card__icon">🏠</span>
        <span class="crosslink-card__title"><?php echo e($sellLabel[$locale] ?? $sellLabel['et']); ?></span>
      </a>

      <?php $__currentLoopData = $intentPages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $labels): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <?php if($key !== ($pageKey ?? '')): ?>
        <a href="<?php echo e(route("{$locale}.{$key}")); ?>" class="crosslink-card">
          <span class="crosslink-card__icon"><?php echo e($labels['icon'] ?? ''); ?></span>
          <span class="crosslink-card__title"><?php echo e($labels[$locale] ?? $labels['et']); ?></span>
        </a>
        <?php endif; ?>
      <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </div>
  </div>
</section>
<?php /**PATH C:\Users\nikol\Documents\projects\cityee-laravel\resources\views/partials/intent-crosslinks.blade.php ENDPATH**/ ?>