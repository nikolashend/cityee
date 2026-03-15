


<?php $__env->startSection('title', $locale === 'ru' ? 'Гиды по недвижимости в Таллинне — продажа, аренда, оценка | CityEE' : ($locale === 'en' ? 'Real Estate Guides Tallinn — Selling, Rental, Pricing | CityEE' : 'Kinnisvarajuhised Tallinn — müük, üür, hindamine | CityEE')); ?>
<?php $__env->startSection('description', $locale === 'ru' ? 'Экспертные гиды CityEE: пошаговые инструкции по продаже, аренде и оценке недвижимости в Таллинне. 10+ лет опыта, 300+ сделок. Практические советы от Александра Примакова.' : ($locale === 'en' ? 'CityEE expert guides: step-by-step instructions for selling, renting and pricing real estate in Tallinn. 10+ years, 300+ deals. Practical advice from Aleksandr Primakov.' : 'CityEE ekspertjuhised: samm-sammult juhendid kinnisvara müügiks, üürimiseks ja hindamiseks Tallinnas. 10+ aastat kogemust, 300+ tehingut.')); ?>
<?php $__env->startSection('logo_text', $ui['logo_text'] ?? ''); ?>
<?php $__env->startSection('footer_class', 'footer--page'); ?>

<?php $__env->startSection('lang_et_url', route('et.guides')); ?>
<?php $__env->startSection('lang_ru_url', route('ru.guides')); ?>
<?php $__env->startSection('lang_en_url', route('en.guides')); ?>

<?php $__env->startPush('jsonld'); ?>
<?php echo \App\Support\JsonLd::webPage(
    $locale === 'ru' ? 'Гиды CityEE' : ($locale === 'en' ? 'CityEE Guides' : 'CityEE Juhised'),
    \App\Support\SeoLinks::canonical('guides'),
    $locale === 'ru' ? 'Экспертные гиды по недвижимости.' : ($locale === 'en' ? 'Expert real estate guides.' : 'Ekspert kinnisvarajuhised.')
); ?>

<?php echo \App\Support\JsonLd::breadcrumbs([
    ['name' => $nav[0]['label'] ?? 'Home', 'url' => route("{$locale}.home")],
    ['name' => $locale === 'ru' ? 'Гиды' : ($locale === 'en' ? 'Guides' : 'Juhised')],
]); ?>

<?php echo \App\Support\Schema::speakable(url()->current()); ?>

<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>
<?php
    $categoryLabels = [
        'sell'      => $locale === 'ru' ? 'Продажа' : ($locale === 'en' ? 'Selling' : 'Müük'),
        'rent'      => $locale === 'ru' ? 'Аренда' : ($locale === 'en' ? 'Rental' : 'Üür'),
        'pricing'   => $locale === 'ru' ? 'Цены' : ($locale === 'en' ? 'Pricing' : 'Hinnad'),
        'legal'     => $locale === 'ru' ? 'Юридика' : ($locale === 'en' ? 'Legal' : 'Juriidika'),
        'marketing' => $locale === 'ru' ? 'Маркетинг' : ($locale === 'en' ? 'Marketing' : 'Turundus'),
    ];
?>

<section class="guide-hero guide-hero--index">
    <div class="container">
        <h1><?php echo e($locale === 'ru' ? 'Гиды по недвижимости' : ($locale === 'en' ? 'Real Estate Guides' : 'Kinnisvarajuhised')); ?></h1>
        <p class="lead"><?php echo e($locale === 'ru' ? 'Экспертные материалы от Александра Примакова — 10+ лет опыта, 300+ сделок в Таллинне и Харьюмаа' : ($locale === 'en' ? 'Expert materials from Aleksandr Primakov — 10+ years experience, 300+ deals in Tallinn & Harjumaa' : 'Ekspertmaterjalid Aleksandr Primakovilt — 10+ aastat kogemust, 300+ tehingut Tallinnas ja Harjumaal')); ?></p>
    </div>
</section>


<?php if($categories->isNotEmpty()): ?>
<section class="guide-filters">
    <div class="container">
        <div class="guide-filter-pills">
            <a href="<?php echo e(route("{$locale}.guides")); ?>" class="guide-filter-pill <?php echo e(!$activeCategory ? 'active' : ''); ?>">
                <?php echo e($locale === 'ru' ? 'Все' : ($locale === 'en' ? 'All' : 'Kõik')); ?>

            </a>
            <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $cat): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <a href="<?php echo e(route("{$locale}.guides", ['category' => $cat])); ?>" class="guide-filter-pill <?php echo e($activeCategory === $cat ? 'active' : ''); ?>">
                    <?php echo e($categoryLabels[$cat] ?? ucfirst($cat)); ?>

                </a>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
    </div>
</section>
<?php endif; ?>

<section class="section-padding" itemscope itemtype="https://schema.org/CollectionPage">
    <div class="container">
        <?php if($guides->isEmpty()): ?>
            <div class="text-center py-5">
                <p class="text-muted"><?php echo e($locale === 'ru' ? 'Гиды скоро появятся.' : ($locale === 'en' ? 'Guides coming soon.' : 'Juhised ilmuvad varsti.')); ?></p>
            </div>
        <?php else: ?>
            <div class="row g-4">
                <?php $__currentLoopData = $guides; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $guide): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="col-md-6 col-lg-4">
                        <article class="knowledge-card" itemscope itemtype="https://schema.org/Article">
                            <a href="<?php echo e(route("{$locale}.guides.show", $guide->slug)); ?>" class="knowledge-card__link">
                                <?php if($guide->category): ?>
                                    <span class="knowledge-card__cat"><?php echo e($categoryLabels[$guide->category] ?? ucfirst($guide->category)); ?></span>
                                <?php endif; ?>
                                <h2 class="knowledge-card__title" itemprop="headline"><?php echo e($guide->title); ?></h2>
                                <?php if($guide->excerpt): ?>
                                    <p class="knowledge-card__desc" itemprop="description"><?php echo e(Str::limit($guide->excerpt, 140)); ?></p>
                                <?php endif; ?>
                                <div class="knowledge-card__meta">
                                    <meta itemprop="author" content="Aleksandr Primakov" />
                                    <meta itemprop="datePublished" content="<?php echo e($guide->published_at?->toDateString()); ?>" />
                                    <?php if($guide->reading_time_minutes): ?>
                                        <span><?php echo e($guide->reading_time_minutes); ?> <?php echo e($locale === 'ru' ? 'мин' : 'min'); ?></span>
                                    <?php endif; ?>
                                </div>
                                <span class="knowledge-card__cta"><?php echo e($locale === 'ru' ? 'Читать →' : ($locale === 'en' ? 'Read →' : 'Loe →')); ?></span>
                            </a>
                        </article>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
        <?php endif; ?>
    </div>
</section>


<section class="section-padding guide-cta-section">
    <div class="container text-center">
        <h2><?php echo e($locale === 'ru' ? 'Не нашли ответ?' : ($locale === 'en' ? 'Didn\'t find your answer?' : 'Ei leidnud vastust?')); ?></h2>
        <p><?php echo e($locale === 'ru' ? 'Задайте вопрос напрямую — ответим за 30 минут.' : ($locale === 'en' ? 'Ask directly — we respond within 30 minutes.' : 'Küsige otse — vastame 30 minuti jooksul.')); ?></p>
        <div class="guide-cta-buttons">
            <a href="<?php echo e(config('cityee.company.whatsapp')); ?>" target="_blank" rel="noopener" class="intent-btn intent-btn--primary">
                <i class="fa fa-whatsapp"></i> WhatsApp
            </a>
            <a href="https://t.me/cityee_tallinn" target="_blank" rel="noopener" class="intent-btn intent-btn--accent">
                <i class="fa fa-telegram"></i> Telegram
            </a>
        </div>
    </div>
</section>

<?php echo $__env->make('partials.service-crosslinks', ['locale' => $locale, 'pageKey' => 'guides'], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\nikol\Documents\projects\cityee-laravel\resources\views/pages/guides/index.blade.php ENDPATH**/ ?>