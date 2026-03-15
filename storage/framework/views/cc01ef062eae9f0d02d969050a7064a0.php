
<?php
    $guideKeys = [
        'guide_sell_tallinn', 'guide_rent', 'guide_pricing',
        'guide_negotiation', 'guide_staging', 'guide_market_2026', 'guide_mistakes',
    ];
    $icons = ['📖', '🔑', '💰', '🤝', '🏠', '📊', '⚠️'];
    $currentGuideKey = $currentGuideKey ?? '';
?>

<section class="knowledge-crosslinks">
  <div class="container">
    <h2><?php echo e($locale === 'ru' ? 'Другие руководства' : ($locale === 'en' ? 'More Guides' : 'Teised juhendid')); ?></h2>
    <div class="crosslinks-grid">
      <?php $__currentLoopData = $guideKeys; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $i => $gk): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <?php if($gk !== $currentGuideKey): ?>
        <?php
            $gc = config("cityee-knowledge.{$gk}", []);
            $gl = $gc[$locale] ?? $gc['en'] ?? [];
            $slugField = match($locale) { 'ru' => 'slug_ru', 'en' => 'slug_en', default => 'slug' };
            $slug = $gc[$slugField] ?? '';
        ?>
        <?php if(!empty($gl['h1'])): ?>
        <a href="<?php echo e(route("{$locale}.pillar", $slug)); ?>" class="crosslink-card">
          <span class="crosslink-card__icon"><?php echo e($icons[$i] ?? '📄'); ?></span>
          <span class="crosslink-card__title"><?php echo e($gl['h1']); ?></span>
        </a>
        <?php endif; ?>
        <?php endif; ?>
      <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

      
      <a href="<?php echo e(route("{$locale}.cases")); ?>" class="crosslink-card crosslink-card--primary">
        <span class="crosslink-card__icon">🏆</span>
        <span class="crosslink-card__title"><?php echo e($locale === 'ru' ? 'Кейсы CityEE' : ($locale === 'en' ? 'CityEE Cases' : 'CityEE juhtumid')); ?></span>
      </a>
    </div>
  </div>
</section>
<?php /**PATH C:\Users\nikol\Documents\projects\cityee-laravel\resources\views/partials/knowledge-crosslinks.blade.php ENDPATH**/ ?>