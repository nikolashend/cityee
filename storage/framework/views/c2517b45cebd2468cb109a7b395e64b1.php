


<?php $__env->startSection('title', $locale === 'ru' ? 'Разборы объектов и аудиты | CityEE' : ($locale === 'en' ? 'Property Audits & Case Studies | CityEE' : 'Kinnisvara auditid ja analüüsid | CityEE')); ?>
<?php $__env->startSection('description', $locale === 'ru' ? 'Реальные разборы объектов: аудит объявления на KV.ee, ценовой коридор, план продажи. 10+ лет опыта в Таллинне.' : ($locale === 'en' ? 'Real property case studies: KV.ee listing audit, price corridor, sales plan. 10+ years experience in Tallinn.' : 'Tegelikud kinnisvara analüüsid: KV.ee kuulutuse audit, hinnakoridor, müügiplaan. 10+ aastat kogemust Tallinnas.')); ?>
<?php $__env->startSection('logo_text', $ui['logo_text'] ?? ''); ?>
<?php $__env->startSection('footer_class', 'footer--page'); ?>

<?php $__env->startSection('lang_et_url', route('et.audits')); ?>
<?php $__env->startSection('lang_ru_url', route('ru.audits')); ?>
<?php $__env->startSection('lang_en_url', route('en.audits')); ?>

<?php $__env->startPush('jsonld'); ?>
<?php echo \App\Support\JsonLd::collectionPage(
    $locale === 'ru' ? 'Разборы CityEE' : ($locale === 'en' ? 'CityEE Audits' : 'CityEE Auditid'),
    \App\Support\SeoLinks::canonical('audits'),
    $locale === 'ru' ? 'Реальные разборы объектов недвижимости.' : ($locale === 'en' ? 'Real property audit case studies.' : 'Tegelikud kinnisvara analüüsid.')
); ?>

<?php if($audits->isNotEmpty()): ?>
<?php echo \App\Support\JsonLd::itemList($audits->map(fn($a) => ['url' => $a->url, 'name' => $a->title])->all()); ?>

<?php endif; ?>
<?php echo \App\Support\JsonLd::breadcrumbs([
    ['name' => $nav[0]['label'] ?? 'Home', 'url' => route("{$locale}.home")],
    ['name' => $locale === 'ru' ? 'Разборы' : ($locale === 'en' ? 'Audits' : 'Auditid')],
]); ?>

<?php echo \App\Support\Schema::speakable(url()->current()); ?>

<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>
<?php
    $typeLabels = [
        'listing_audit'  => $locale === 'ru' ? 'Аудит объявления' : ($locale === 'en' ? 'Listing Audit' : 'Kuulutuse audit'),
        'price_corridor' => $locale === 'ru' ? 'Ценовой коридор' : ($locale === 'en' ? 'Price Corridor' : 'Hinnakoridor'),
        'sales_plan'     => $locale === 'ru' ? 'План продажи' : ($locale === 'en' ? 'Sales Plan' : 'Müügiplaan'),
    ];
?>

<section class="guide-hero guide-hero--index audit-hero--index">
    <div class="container">
        <h1><?php echo e($locale === 'ru' ? 'Разборы объектов' : ($locale === 'en' ? 'Property Audits' : 'Kinnisvara auditid')); ?></h1>
        <p class="lead"><?php echo e($locale === 'ru' ? 'Реальные кейсы: аудит объявлений, ценовые коридоры, планы продажи — всё на основе данных Maa-amet и KV.ee' : ($locale === 'en' ? 'Real case studies: listing audits, price corridors, sales plans — all based on Maa-amet & KV.ee data' : 'Tegelikud juhtumid: kuulutuste auditid, hinnakoridorid, müügiplaanid — Maa-ameti ja KV.ee andmetel')); ?></p>
    </div>
</section>


<?php if($auditTypes->isNotEmpty()): ?>
<section class="guide-filters">
    <div class="container">
        <div class="guide-filter-pills">
            <a href="<?php echo e(route("{$locale}.audits")); ?>" class="guide-filter-pill <?php echo e(!$activeType ? 'active' : ''); ?>">
                <?php echo e($locale === 'ru' ? 'Все' : ($locale === 'en' ? 'All' : 'Kõik')); ?>

            </a>
            <?php $__currentLoopData = $auditTypes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $type): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <a href="<?php echo e(route("{$locale}.audits", ['type' => $type])); ?>" class="guide-filter-pill <?php echo e($activeType === $type ? 'active' : ''); ?>">
                    <?php echo e($typeLabels[$type] ?? ucfirst(str_replace('_', ' ', $type))); ?>

                </a>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
    </div>
</section>
<?php endif; ?>

<section class="section-padding" itemscope itemtype="https://schema.org/CollectionPage">
    <div class="container">
        <?php if($audits->isEmpty()): ?>
            <div class="text-center py-5">
                <p class="text-muted"><?php echo e($locale === 'ru' ? 'Разборы скоро появятся.' : ($locale === 'en' ? 'Audits coming soon.' : 'Auditid ilmuvad varsti.')); ?></p>
            </div>
        <?php else: ?>
            <div class="row g-4">
                <?php $__currentLoopData = $audits; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $audit): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="col-md-6 col-lg-4">
                        <article class="knowledge-card knowledge-card--audit" itemscope itemtype="https://schema.org/Article">
                            <a href="<?php echo e(route("{$locale}.audits.show", $audit->slug)); ?>" class="knowledge-card__link">
                                <?php if($audit->audit_type): ?>
                                    <span class="knowledge-card__cat knowledge-card__cat--audit"><?php echo e($typeLabels[$audit->audit_type] ?? ucfirst(str_replace('_', ' ', $audit->audit_type))); ?></span>
                                <?php endif; ?>
                                <h2 class="knowledge-card__title" itemprop="headline"><?php echo e($audit->title); ?></h2>
                                <?php if($audit->excerpt): ?>
                                    <p class="knowledge-card__desc" itemprop="description"><?php echo e(Str::limit($audit->excerpt, 140)); ?></p>
                                <?php endif; ?>
                                <div class="knowledge-card__meta">
                                    <meta itemprop="author" content="Aleksandr Primakov" />
                                    <meta itemprop="datePublished" content="<?php echo e($audit->published_at?->toDateString()); ?>" />
                                    <?php if($audit->reading_time_minutes): ?>
                                        <span><?php echo e($audit->reading_time_minutes); ?> <?php echo e($locale === 'ru' ? 'мин' : 'min'); ?></span>
                                    <?php endif; ?>
                                </div>
                                <span class="knowledge-card__cta"><?php echo e($locale === 'ru' ? 'Читать разбор →' : ($locale === 'en' ? 'Read audit →' : 'Loe auditi →')); ?></span>
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
        <h2><?php echo e($locale === 'ru' ? 'Хотите такой же разбор для вашего объекта?' : ($locale === 'en' ? 'Want the same audit for your property?' : 'Soovite sama auditi oma kinnisvarale?')); ?></h2>
        <p><?php echo e($locale === 'ru' ? 'Бесплатный анализ рынка и стратегия за 24 часа.' : ($locale === 'en' ? 'Free market analysis and strategy within 24 hours.' : 'Tasuta turuanalüüs ja strateegia 24 tunni jooksul.')); ?></p>
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
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\nikol\Documents\projects\cityee-laravel\resources\views/pages/audits/index.blade.php ENDPATH**/ ?>