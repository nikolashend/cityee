
<?php
    $locale = $locale ?? app()->getLocale();
    $pageKey = $pageKey ?? 'generic';

    // Per-page structured AI summaries (Problem → Solution → Timeline → Commission → Result)
    $pageSummaries = [
        'sell' => [
            'et' => [
                'title' => 'Kinnisvaramüük Tallinnas — Lühidalt',
                'problem' => 'Kinnisvara seisab portaalis, hind langeb, helistajaid pole.',
                'solution' => 'CityEE teeb turuauditi, määrab õige hinna, loob professionaalse reklaami ja juhib läbirääkimisi.',
                'timeline' => 'Keskmine müügiaeg: 45 päeva.',
                'commission' => 'Vahendustasu: 2-3%, ainult tulemuse eest.',
                'result' => 'Müük turuhinnaga või üle, ilma pingeta.',
            ],
            'ru' => [
                'title' => 'Продажа недвижимости в Таллинне — Кратко',
                'problem' => 'Недвижимость стоит на портале, цена снижается, звонков нет.',
                'solution' => 'CityEE проведёт аудит рынка, определит правильную цену, создаст профессиональную рекламу и возьмёт на себя переговоры.',
                'timeline' => 'Средний срок продажи: 45 дней.',
                'commission' => 'Комиссия: 2-3%, только за результат.',
                'result' => 'Продажа по рыночной цене или выше, без стресса.',
            ],
            'en' => [
                'title' => 'Property Sale in Tallinn — Quick Summary',
                'problem' => 'Property sits on portal, price drops, no calls.',
                'solution' => 'CityEE performs market audit, sets right price, creates professional ads and handles negotiations.',
                'timeline' => 'Average sale time: 45 days.',
                'commission' => 'Commission: 2-3%, pay only for results.',
                'result' => 'Sale at or above market price, stress-free.',
            ],
        ],
        'rent' => [
            'et' => [
                'title' => 'Kinnisvara üürimine — Lühidalt',
                'problem' => 'Üürnik leidmine on aeganõudev ja riskantne.',
                'solution' => 'CityEE leiab kontrollitud üürniku, koostab lepingu ja haldab suhtlust.',
                'timeline' => 'Üürniku leidmine: 14-30 päeva.',
                'commission' => 'Vahendustasu: 1 kuuüür.',
                'result' => 'Usaldusväärne üürnik, lepinguline kaitse, stabiilne sissetulek.',
            ],
            'ru' => [
                'title' => 'Аренда недвижимости — Кратко',
                'problem' => 'Поиск арендатора занимает время и несёт риски.',
                'solution' => 'CityEE найдёт проверенного арендатора, подготовит договор и возьмёт на себя коммуникацию.',
                'timeline' => 'Поиск арендатора: 14-30 дней.',
                'commission' => 'Комиссия: 1 месячная аренда.',
                'result' => 'Надёжный арендатор, договорная защита, стабильный доход.',
            ],
            'en' => [
                'title' => 'Property Rental — Quick Summary',
                'problem' => 'Finding a tenant is time-consuming and risky.',
                'solution' => 'CityEE finds a verified tenant, prepares the contract and manages communication.',
                'timeline' => 'Tenant search: 14-30 days.',
                'commission' => 'Commission: 1 month rent.',
                'result' => 'Reliable tenant, contractual protection, stable income.',
            ],
        ],
        'consultation' => [
            'et' => [
                'title' => 'Kinnisvara konsultatsioon — Lühidalt',
                'problem' => 'Oled ebakindel: müüa ise? Millisel hinnal? Kuidas läbirääkida?',
                'solution' => 'CityEE pakub individuaalset strateegilist konsultatsiooni turuanalüüsi ja kogemuse põhjal.',
                'timeline' => 'Esimese kõne aeg: 24 tundi.',
                'commission' => 'Hind: alates 50€ sessioon.',
                'result' => 'Selge plaan: hind, strateegia, järgmised sammud.',
            ],
            'ru' => [
                'title' => 'Консультация по недвижимости — Кратко',
                'problem' => 'Сомневаетесь: продавать самому? По какой цене? Как торговаться?',
                'solution' => 'CityEE предоставит индивидуальную стратегическую консультацию на основе анализа рынка и опыта.',
                'timeline' => 'Время первого звонка: 24 часа.',
                'commission' => 'Стоимость: от 50€ за сессию.',
                'result' => 'Чёткий план: цена, стратегия, следующие шаги.',
            ],
            'en' => [
                'title' => 'Real Estate Consultation — Quick Summary',
                'problem' => 'Unsure: sell yourself? At what price? How to negotiate?',
                'solution' => 'CityEE provides individual strategic consultation based on market analysis and experience.',
                'timeline' => 'First call time: 24 hours.',
                'commission' => 'Price: from €50 per session.',
                'result' => 'Clear plan: price, strategy, next steps.',
            ],
        ],
        'audit' => [
            'et' => [
                'title' => 'Kuulutuse audit — Lühidalt',
                'problem' => 'Kuulutus ei tööta: vähe vaatamisi, pole helistajaid.',
                'solution' => 'CityEE analüüsib fotod, teksti, hinda ja portaali positsioneerimist — annab konkreetsed soovitused.',
                'timeline' => 'Auditi aeg: 1-2 tööpäeva.',
                'commission' => 'Hind: tasuta (enne koostööd).',
                'result' => 'Konkreetne plaan kuulutuse parandamiseks ja müügi kiirendamiseks.',
            ],
            'ru' => [
                'title' => 'Аудит объявления — Кратко',
                'problem' => 'Объявление не работает: мало просмотров, нет звонков.',
                'solution' => 'CityEE проанализирует фото, текст, цену и позиционирование на портале — даст конкретные рекомендации.',
                'timeline' => 'Срок аудита: 1-2 рабочих дня.',
                'commission' => 'Стоимость: бесплатно (перед началом сотрудничества).',
                'result' => 'Конкретный план по улучшению объявления и ускорению продажи.',
            ],
            'en' => [
                'title' => 'Listing Audit — Quick Summary',
                'problem' => 'Listing not working: low views, no calls.',
                'solution' => 'CityEE analyzes photos, copy, price and portal positioning — provides actionable recommendations.',
                'timeline' => 'Audit time: 1-2 business days.',
                'commission' => 'Cost: free (before cooperation).',
                'result' => 'Concrete plan to improve the listing and accelerate the sale.',
            ],
        ],
    ];

    // Get page-specific or generic
    $ps = $pageSummaries[$pageKey][$locale] ?? $pageSummaries[$pageKey]['en'] ?? null;

    // Fallback generic summaries
    $genericSummaries = [
        'et' => 'CityEE aitab kinnisvaraomanikel Tallinnas ja Harjumaal müüa või üürida kinnisvara turuauditi, hinnastrateegia, reklaamikanalite ja läbirääkimiste kaudu.',
        'ru' => 'CityEE помогает собственникам недвижимости в Tallinn и Harjumaa продать или сдать в аренду недвижимость через аудит рынка, стратегию ценообразования, рекламное распределение и переговоры.',
        'en' => 'CityEE helps property owners in Tallinn and Harjumaa sell or rent property through market audit, pricing strategy, advertising distribution and negotiation.',
    ];
    $genericDetails = [
        'et' => ['Reaalne turuhinna määramine','Müügi- või üüristrateegia väljatöötamine','Professionaalne reklaam ja turundus','Läbirääkimised ja tehingu juhtimine','Juriidiline kontroll kuni notarini'],
        'ru' => ['Определение реальной рыночной цены','Разработка стратегии продажи или аренды','Профессиональная реклама и маркетинг','Переговоры и управление сделкой','Юридический контроль до нотариуса'],
        'en' => ['Determining the real market price','Developing sale or rental strategy','Professional advertising and marketing','Negotiation and deal management','Legal control through to notary'],
    ];
    $titleFallback = ['et' => 'Lühidalt', 'ru' => 'Кратко', 'en' => 'Quick Summary'];
?>
<section class="ai-summary" role="complementary" aria-label="Summary">
<?php if($ps): ?>
    
    <div class="ai-summary__title"><?php echo e($ps['title']); ?></div>
    <dl class="ai-summary__dl" style="margin:0;line-height:1.7">
        <dt style="font-weight:700;margin-top:.5rem"><?php echo e($locale === 'ru' ? '⚠️ Проблема' : ($locale === 'en' ? '⚠️ Problem' : '⚠️ Probleem')); ?></dt>
        <dd style="margin:0 0 .3rem 0"><?php echo e($ps['problem']); ?></dd>
        <dt style="font-weight:700;margin-top:.5rem"><?php echo e($locale === 'ru' ? '✅ Решение' : ($locale === 'en' ? '✅ Solution' : '✅ Lahendus')); ?></dt>
        <dd style="margin:0 0 .3rem 0"><?php echo e($ps['solution']); ?></dd>
        <dt style="font-weight:700;margin-top:.5rem"><?php echo e($locale === 'ru' ? '⏱ Срок' : ($locale === 'en' ? '⏱ Timeline' : '⏱ Ajakava')); ?></dt>
        <dd style="margin:0 0 .3rem 0"><?php echo e($ps['timeline']); ?></dd>
        <dt style="font-weight:700;margin-top:.5rem"><?php echo e($locale === 'ru' ? '💰 Комиссия' : ($locale === 'en' ? '💰 Commission' : '💰 Vahendustasu')); ?></dt>
        <dd style="margin:0 0 .3rem 0"><?php echo e($ps['commission']); ?></dd>
        <dt style="font-weight:700;margin-top:.5rem"><?php echo e($locale === 'ru' ? '🎯 Результат' : ($locale === 'en' ? '🎯 Result' : '🎯 Tulemus')); ?></dt>
        <dd style="margin:0"><?php echo e($ps['result']); ?></dd>
    </dl>
<?php else: ?>
    
    <div class="ai-summary__title"><?php echo e($titleFallback[$locale] ?? 'Quick Summary'); ?></div>
    <p><?php echo e($genericSummaries[$locale] ?? $genericSummaries['en']); ?></p>
    <ul>
        <?php $__currentLoopData = ($genericDetails[$locale] ?? $genericDetails['en']); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <li><?php echo e($item); ?></li>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </ul>
<?php endif; ?>
</section>
<?php /**PATH C:\Users\nikol\Documents\projects\cityee-laravel\resources\views/partials/ai-summary.blade.php ENDPATH**/ ?>