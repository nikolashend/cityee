


<?php $__env->startSection('title', $audit->og_title ?: ($audit->meta_title ?: $audit->title . ' | CityEE')); ?>
<?php $__env->startSection('description', $audit->og_description ?: ($audit->meta_description ?: $audit->excerpt)); ?>
<?php $__env->startSection('logo_text', $ui['logo_text'] ?? ''); ?>
<?php $__env->startSection('footer_class', 'footer--page'); ?>

<?php if($alternates->has('et')): ?>
<?php $__env->startSection('lang_et_url', route('et.audits.show', $audit->slug)); ?>
<?php endif; ?>
<?php if($alternates->has('ru')): ?>
<?php $__env->startSection('lang_ru_url', route('ru.audits.show', $audit->slug)); ?>
<?php endif; ?>
<?php if($alternates->has('en')): ?>
<?php $__env->startSection('lang_en_url', route('en.audits.show', $audit->slug)); ?>
<?php endif; ?>

<?php $__env->startPush('jsonld'); ?>
<?php echo \App\Support\JsonLd::article(
    $audit->title,
    $audit->url,
    $audit->meta_description ?: $audit->excerpt ?: '',
    $audit->published_at?->toIso8601String() ?? now()->toIso8601String(),
    $audit->updated_at?->toIso8601String() ?? now()->toIso8601String()
); ?>

<?php echo \App\Support\JsonLd::breadcrumbs([
    ['name' => $nav[0]['label'] ?? 'Home', 'url' => route("{$locale}.home")],
    ['name' => $locale === 'ru' ? 'Разборы' : ($locale === 'en' ? 'Audits' : 'Auditid'), 'url' => route("{$locale}.audits")],
    ['name' => $audit->title],
]); ?>

<?php echo \App\Support\Schema::speakable($audit->url); ?>

<?php
    $blocks = $audit->content_blocks ?? [];
    $faqItems = $audit->faq_json ?? $blocks['faq'] ?? [];
?>
<?php if(!empty($faqItems)): ?>
<?php if (isset($component)) { $__componentOriginal631a4b8665f0bb533881a844059661c7 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal631a4b8665f0bb533881a844059661c7 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.faq-schema','data' => ['items' => $faqItems]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('faq-schema'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['items' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($faqItems)]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal631a4b8665f0bb533881a844059661c7)): ?>
<?php $attributes = $__attributesOriginal631a4b8665f0bb533881a844059661c7; ?>
<?php unset($__attributesOriginal631a4b8665f0bb533881a844059661c7); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal631a4b8665f0bb533881a844059661c7)): ?>
<?php $component = $__componentOriginal631a4b8665f0bb533881a844059661c7; ?>
<?php unset($__componentOriginal631a4b8665f0bb533881a844059661c7); ?>
<?php endif; ?>
<?php endif; ?>
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>
<?php
    $blocks = $audit->content_blocks ?? [];
    $faqItems = $audit->faq_json ?? $blocks['faq'] ?? [];
    $aiSummary = $audit->ai_summary;
    $keyTakeaways = $audit->key_takeaways ?? [];
?>


<section class="guide-hero audit-hero" itemscope itemtype="https://schema.org/Article">
    <meta itemprop="about" content="Real estate audit — <?php echo e($audit->title); ?>" />
    <meta itemprop="inLanguage" content="<?php echo e($locale); ?>" />
    <meta itemprop="datePublished" content="<?php echo e($audit->published_at?->toIso8601String()); ?>" />
    <meta itemprop="dateModified" content="<?php echo e($audit->updated_at?->toIso8601String()); ?>" />
    <div itemprop="author" itemscope itemtype="https://schema.org/Person">
        <meta itemprop="name" content="Aleksandr Primakov" />
        <meta itemprop="jobTitle" content="Real Estate Deal Optimization Partner" />
        <meta itemprop="url" content="https://cityee.ee/" />
    </div>
    <div itemprop="publisher" itemscope itemtype="https://schema.org/Organization">
        <meta itemprop="name" content="CityEE" />
        <meta itemprop="url" content="https://cityee.ee" />
    </div>
    <div class="container">
        <nav class="guide-breadcrumb" aria-label="breadcrumb">
            <ol>
                <li><a href="<?php echo e(route("{$locale}.home")); ?>"><?php echo e($nav[0]['label'] ?? 'Home'); ?></a></li>
                <li><a href="<?php echo e(route("{$locale}.audits")); ?>"><?php echo e($locale === 'ru' ? 'Разборы' : ($locale === 'en' ? 'Audits' : 'Auditid')); ?></a></li>
                <li aria-current="page"><?php echo e(Str::limit($audit->title, 60)); ?></li>
            </ol>
        </nav>

        <h1 itemprop="headline"><?php echo e($audit->title); ?></h1>

        
        <div class="guide-meta">
            <span class="guide-meta__author"><?php echo e($audit->author_name ?? 'Aleksandr Primakov'); ?></span>
            <?php if($audit->reading_time_minutes): ?>
                <span class="guide-meta__divider">·</span>
                <span class="guide-meta__reading"><?php echo e($audit->reading_time_minutes); ?> <?php echo e($locale === 'ru' ? 'мин чтения' : ($locale === 'en' ? 'min read' : 'min lugemist')); ?></span>
            <?php endif; ?>
            <?php if($audit->published_at): ?>
                <span class="guide-meta__divider">·</span>
                <time class="guide-meta__date" datetime="<?php echo e($audit->published_at->toIso8601String()); ?>"><?php echo e($audit->published_at->format('d.m.Y')); ?></time>
            <?php endif; ?>
        </div>

        
        <div class="guide-hero__ctas">
            <a href="<?php echo e(config('cityee.company.whatsapp')); ?>?text=<?php echo e(urlencode($locale === 'ru' ? 'Здравствуйте! Прочитал разбор «'.$audit->title.'». Хочу заказать такой же для моего объекта.' : ($locale === 'en' ? 'Hello! I read the audit "'.$audit->title.'". I want to order the same for my property.' : 'Tere! Lugesin auditi «'.$audit->title.'». Soovin sama oma kinnisvarale.'))); ?>" target="_blank" rel="noopener" class="intent-btn intent-btn--primary">
                <i class="fa fa-whatsapp"></i> <?php echo e($locale === 'ru' ? 'Заказать в WhatsApp' : ($locale === 'en' ? 'Order via WhatsApp' : 'Telli WhatsAppis')); ?>

            </a>
            <a href="https://t.me/cityee_tallinn" target="_blank" rel="noopener" class="intent-btn intent-btn--secondary intent-btn--dark">
                <i class="fa fa-telegram"></i> <?php echo e($locale === 'ru' ? 'Написать в Telegram' : ($locale === 'en' ? 'Message on Telegram' : 'Kirjuta Telegramis')); ?>

            </a>
        </div>

        
        <div class="guide-eeat-bar">
            <span class="eeat-badge">✅ <?php echo e($locale === 'ru' ? '10+ лет опыта' : ($locale === 'en' ? '10+ years experience' : '10+ aastat kogemust')); ?></span>
            <span class="eeat-badge">✅ <?php echo e($locale === 'ru' ? '300+ сделок' : ($locale === 'en' ? '300+ deals' : '300+ tehingut')); ?></span>
            <span class="eeat-badge">✅ <?php echo e($locale === 'ru' ? 'Данные Maa-amet + KV.ee' : ($locale === 'en' ? 'Maa-amet + KV.ee data' : 'Maa-ameti + KV.ee andmed')); ?></span>
        </div>
    </div>
</section>


<?php if($aiSummary): ?>
<section class="guide-ai-summary">
    <div class="container">
        <div class="ai-summary-box" data-ai-chunk="summary">
            <div class="ai-summary-box__icon">🤖</div>
            <div class="ai-summary-box__content">
                <h2 class="ai-summary-box__title"><?php echo e($locale === 'ru' ? 'AI-резюме разбора' : ($locale === 'en' ? 'AI Audit Summary' : 'AI auditi kokkuvõte')); ?></h2>
                <p><?php echo e($aiSummary); ?></p>
            </div>
        </div>
    </div>
</section>
<?php endif; ?>


<?php if(!empty($keyTakeaways)): ?>
<section class="guide-takeaways-section">
    <div class="container">
        <div class="guide-takeaways-box" data-ai-chunk="takeaways">
            <h2><?php echo e($locale === 'ru' ? '📋 Ключевые выводы' : ($locale === 'en' ? '📋 Key Takeaways' : '📋 Peamised järeldused')); ?></h2>
            <ul class="guide-takeaways">
                <?php $__currentLoopData = $keyTakeaways; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $takeaway): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <li><?php echo e($takeaway); ?></li>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </ul>
        </div>
    </div>
</section>
<?php endif; ?>


<?php if(!empty($blocks['summary'])): ?>
    <section class="section-padding bg-white">
        <div class="container">
            <div class="audit-summary" itemprop="text" data-ai-chunk="overview">
                <?php echo $blocks['summary']; ?>

            </div>
        </div>
    </section>
<?php endif; ?>


<?php if(!empty($blocks['market_data'])): ?>
    <section class="section-padding bg-light">
        <div class="container">
            <h2><?php echo e($locale === 'ru' ? '📊 Рыночные данные' : ($locale === 'en' ? '📊 Market Data' : '📊 Turuandmed')); ?></h2>
            <div class="audit-market-data" data-ai-chunk="market-data">
                <?php echo $blocks['market_data']; ?>

            </div>
        </div>
    </section>
<?php endif; ?>


<?php if(!empty($blocks['sections'])): ?>
    <?php $__currentLoopData = $blocks['sections']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $i => $section): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <section class="section-padding <?php echo e($i % 2 === 0 ? 'bg-white' : 'bg-light'); ?>">
            <div class="container">
                <?php if(!empty($section['heading'])): ?>
                    <h2><?php echo e($section['heading']); ?></h2>
                <?php endif; ?>
                <?php if(!empty($section['snippet'])): ?>
                    <div class="guide-snippet-answer" data-ai-chunk="section-<?php echo e($i); ?>">
                        <p><?php echo e($section['snippet']); ?></p>
                    </div>
                <?php endif; ?>
                <?php if(!empty($section['body'])): ?>
                    <div class="audit-section__body">
                        <?php echo $section['body']; ?>

                    </div>
                <?php endif; ?>
            </div>
        </section>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
<?php endif; ?>


<?php if(!empty($faqItems)): ?>
    <section class="section-padding faq-section">
        <div class="container">
            <h2><?php echo e($locale === 'ru' ? 'Часто задаваемые вопросы' : ($locale === 'en' ? 'Frequently Asked Questions' : 'Korduma kippuvad küsimused')); ?></h2>
            <div class="faq-list">
                <?php $__currentLoopData = $faqItems; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $faq): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="faq-item">
                        <div class="faq-question" role="button" tabindex="0" aria-expanded="false" onclick="this.parentElement.classList.toggle('active');this.setAttribute('aria-expanded',this.parentElement.classList.contains('active'))"><?php echo e($faq['question']); ?></div>
                        <div class="faq-answer">
                            <div><?php echo $faq['answer']; ?></div>
                        </div>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
        </div>
    </section>
<?php endif; ?>


<?php if(($relatedGuides && $relatedGuides->isNotEmpty()) || ($relatedAudits && $relatedAudits->isNotEmpty())): ?>
<section class="section-padding bg-light guide-internal-links">
    <div class="container">
        <h2><?php echo e($locale === 'ru' ? '📖 Читайте также' : ($locale === 'en' ? '📖 Related Reading' : '📖 Loe ka')); ?></h2>
        <div class="internal-links-grid">
            <?php if($relatedGuides && $relatedGuides->isNotEmpty()): ?>
                <?php $__currentLoopData = $relatedGuides; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $rg): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <a href="<?php echo e(route("{$locale}.guides.show", $rg->slug)); ?>" class="internal-link-card">
                        <span class="internal-link-card__type"><?php echo e($locale === 'ru' ? 'Гид' : ($locale === 'en' ? 'Guide' : 'Juhis')); ?></span>
                        <span class="internal-link-card__title"><?php echo e($rg->title); ?></span>
                        <?php if($rg->excerpt): ?><span class="internal-link-card__desc"><?php echo e(Str::limit($rg->excerpt, 100)); ?></span><?php endif; ?>
                    </a>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            <?php endif; ?>
            <?php if($relatedAudits && $relatedAudits->isNotEmpty()): ?>
                <?php $__currentLoopData = $relatedAudits; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $ra): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <a href="<?php echo e(route("{$locale}.audits.show", $ra->slug)); ?>" class="internal-link-card">
                        <span class="internal-link-card__type"><?php echo e($locale === 'ru' ? 'Разбор' : ($locale === 'en' ? 'Audit' : 'Audit')); ?></span>
                        <span class="internal-link-card__title"><?php echo e($ra->title); ?></span>
                        <?php if($ra->excerpt): ?><span class="internal-link-card__desc"><?php echo e(Str::limit($ra->excerpt, 100)); ?></span><?php endif; ?>
                    </a>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            <?php endif; ?>
        </div>
    </div>
</section>
<?php endif; ?>


<section class="section-padding guide-cta-section">
    <div class="container text-center">
        <h2><?php echo e($blocks['cta']['heading'] ?? ($locale === 'ru' ? 'Закажите такой же разбор для вашего объекта' : ($locale === 'en' ? 'Order the same audit for your property' : 'Telli sama audit oma kinnisvarale'))); ?></h2>
        <p><?php echo e($blocks['cta']['text'] ?? ($locale === 'ru' ? 'Бесплатный анализ рынка и стратегия за 24 часа — без обязательств.' : ($locale === 'en' ? 'Free market analysis and strategy within 24 hours — no obligation.' : 'Tasuta turuanalüüs ja strateegia 24 tunni jooksul — kohustuseta.'))); ?></p>
        <div class="guide-cta-buttons">
            <a href="<?php echo e(config('cityee.company.whatsapp')); ?>" target="_blank" rel="noopener" class="intent-btn intent-btn--primary">
                <i class="fa fa-whatsapp"></i> <?php echo e($locale === 'ru' ? 'WhatsApp' : 'WhatsApp'); ?>

            </a>
            <a href="https://t.me/cityee_tallinn" target="_blank" rel="noopener" class="intent-btn intent-btn--accent">
                <i class="fa fa-telegram"></i> <?php echo e($locale === 'ru' ? 'Telegram' : 'Telegram'); ?>

            </a>
            <a href="<?php echo e(route("{$locale}.consultation")); ?>" class="intent-btn intent-btn--secondary intent-btn--dark">
                <?php echo e($locale === 'ru' ? 'Консультация' : ($locale === 'en' ? 'Consultation' : 'Konsultatsioon')); ?>

            </a>
        </div>
    </div>
</section>


<div class="container guide-geo-line">
    <p><small><?php echo e($locale === 'ru' ? '📍 CityEE — Таллинн, Харьюмаа, Эстония. Viru väljak 2, Tallinn 10111.' : ($locale === 'en' ? '📍 CityEE — Tallinn, Harjumaa, Estonia. Viru väljak 2, Tallinn 10111.' : '📍 CityEE — Tallinn, Harjumaa, Eesti. Viru väljak 2, Tallinn 10111.')); ?></small></p>
</div>

<?php echo $__env->make('partials.service-crosslinks', ['locale' => $locale, 'pageKey' => 'audits'], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\nikol\Documents\projects\cityee-laravel\resources\views/pages/audits/show.blade.php ENDPATH**/ ?>