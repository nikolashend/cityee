


<?php $__env->startSection('title', $t['meta_title'] ?? ''); ?>
<?php $__env->startSection('description', $t['meta_description'] ?? ''); ?>
<?php $__env->startSection('logo_text', $ui['logo_text'] ?? ''); ?>
<?php $__env->startSection('footer_class', 'footer--page'); ?>

<?php $__env->startSection('lang_et_url', route('et.why')); ?>
<?php $__env->startSection('lang_ru_url', route('ru.why')); ?>
<?php $__env->startSection('lang_en_url', route('en.why')); ?>

<?php $__env->startPush('jsonld'); ?>
<?php echo \App\Support\JsonLd::webPage($t['h1'], \App\Support\SeoLinks::canonical('why'), $t['meta_description'] ?? ''); ?>

<?php echo \App\Support\JsonLd::breadcrumbs([
    ['name' => $nav[0]['label'] ?? 'Home', 'url' => route("{$locale}.home")],
    ['name' => $t['h1']],
]); ?>

<?php echo \App\Support\Schema::speakable(\App\Support\SeoLinks::canonical('why')); ?>

<script type="application/ld+json"><?php echo json_encode(\App\Support\Schema::personJsonLd(), JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT); ?></script>
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>

<div class="page-title" style="background: url(<?php echo e($t['hero_bg']); ?>) no-repeat; background-position: center top; background-size: cover;">
  <div class="container">
    <h1 class="page-title__name"><?php echo e($t['h1']); ?></h1>
    <p class="page-title__text"><?php echo e($t['hero_subtitle']); ?></p>
    <a href="<?php echo e(config('cityee.company.whatsapp')); ?>" target="_blank" class="btn">
      <?php echo e($locale === 'en' ? 'Contact via WhatsApp' : ($locale === 'ru' ? 'Написать в WhatsApp' : 'Kirjuta WhatsAppi')); ?>

    </a>
  </div>
</div>

<div class="container">
  <div class="row">
    <div class="col-md-3 col-sm-3 text-center">
      <?php echo $__env->make('partials.sidebar-services', ['locale' => $locale, 'pageKey' => $pageKey], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
    </div>
    <div class="col-md-9 col-sm-9">
      <div class="content">

        <?php echo $__env->make('partials.ai-summary', ['locale' => $locale], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

        <?php if($locale === 'et'): ?>
        <h2>Miks valida CityEE kinnisvaramaakler?</h2>
        <p>CityEE on kinnisvaratehingute optimeerimise partner Tallinnas ja Harjumaal. Meie eesmärk on aidata Teil saavutada parim tulemus kinnisvara müügil, ostmisel, üürile andmisel ja üürimisel.</p>

        <div class="possibilities">
          <ul>
            <li><strong>Minimaalne vahendustasu — ainult 2%</strong> ainuesinduslepingu korral</li>
            <li><strong>Kiire müügiaeg</strong> — keskmine korteri müügiaeg on 1–1,5 kuud</li>
            <li><strong>Tasuta kinnisvara hindamine</strong> ainuesinduslepingu sõlmimisel (vähemalt 3 kuuks)</li>
            <li><strong>Professionaalsed fotod ja reklaam</strong> — maksimaalne reklaampakett</li>
            <li><strong>Juriidiline konsultatsioon</strong> — kontrollime dokumentatsiooni ja kaitseme Teie huve</li>
            <li><strong>Koostöö teiste maakleritega</strong> — laiendame müügikanalit</li>
            <li><strong>Üle 120 000 kontakti</strong> reklaamivõrgustikus</li>
            <li><strong>Isiklik maakler</strong> — Aleksandr Primakov, kättesaadav 10:00–22:00</li>
          </ul>
        </div>

        <h2>Meie teenused</h2>
        <p>Pakume terviklikku kinnisvarateenust alates turuhinna analüüsist ja dokumentide kontrollimisest kuni notariaalse tehinguni.</p>
        <?php elseif($locale === 'ru'): ?>
        <h2>Почему выбирают маклера CityEE?</h2>
        <p>CityEE — партнер по оптимизации сделок с недвижимостью в Таллинне и Харьюмаа. Наша цель — помочь вам достичь лучшего результата при продаже, покупке, сдаче в аренду недвижимости.</p>

        <div class="possibilities">
          <ul>
            <li><strong>Минимальная комиссия — всего 2%</strong> при эксклюзивном договоре</li>
            <li><strong>Быстрая продажа</strong> — средний срок продажи квартиры 1–1,5 месяца</li>
            <li><strong>Бесплатная оценка недвижимости</strong> при заключении эксклюзивного договора (мин. 3 месяца)</li>
            <li><strong>Профессиональные фотографии и реклама</strong> — максимальный рекламный пакет</li>
            <li><strong>Юридическая консультация</strong> — проверяем документацию и защищаем ваши интересы</li>
            <li><strong>Сотрудничество с другими маклерами</strong> — расширяем каналы продаж</li>
            <li><strong>Более 120 000 контактов</strong> в рекламной сети</li>
            <li><strong>Персональный маклер</strong> — Александр Примаков, доступен 10:00–22:00</li>
          </ul>
        </div>

        <h2>Наши услуги</h2>
        <p>Предлагаем комплексную услугу в сфере недвижимости от анализа рыночной цены и проверки документов до нотариальной сделки.</p>
        <?php else: ?>
        <h2>Why choose CityEE?</h2>
        <p>CityEE is a real estate deal optimization partner in Tallinn and Harjumaa. Our goal is to help you achieve the best result when selling, buying, or renting property.</p>

        <div class="possibilities">
          <ul>
            <li><strong>Minimal commission — only 2%</strong> with an exclusive agreement</li>
            <li><strong>Fast selling time</strong> — average apartment selling time is 1–1.5 months</li>
            <li><strong>Free property valuation</strong> when signing an exclusive agreement (min. 3 months)</li>
            <li><strong>Professional photos and advertising</strong> — maximum advertising package</li>
            <li><strong>Legal consultation</strong> — we verify documentation and protect your interests</li>
            <li><strong>Cooperation with other brokers</strong> — expanding sales channels</li>
            <li><strong>Over 120,000 contacts</strong> in the advertising network</li>
            <li><strong>Personal broker</strong> — Aleksandr Primakov, available 10:00–22:00</li>
          </ul>
        </div>

        <h2>Our Services</h2>
        <p>We offer a comprehensive real estate service from market price analysis and document verification to notarial transactions.</p>
        <?php endif; ?>

        <div class="offers__bonus">
          <p>
            <?php if($locale === 'ru'): ?>
              Заключив с нами эксклюзивный договор, вы получите максимальный рекламный пакет с минимальной комиссией — <strong>ВСЕГО 2% от цены продажи!</strong>
            <?php elseif($locale === 'en'): ?>
              By signing an exclusive agreement, you get the maximum advertising package with minimal commission — <strong>ONLY 2% of the selling price!</strong>
            <?php else: ?>
              Sõlmides meiega ainuesinduslepingu, saate maksimaalse reklaamipaketi minimaalse vahendustasuga — <strong>AINULT 2% müügihinnast!</strong>
            <?php endif; ?>
          </p>
        </div>

        <h2 class="text-left"><?php echo e($ui['write_now'] ?? 'KIRJUTAGE MEILE KOHE!'); ?> </h2>
        <p class="text-left"><a href="" id="feedback1" class="btn"> <?php echo e($ui['send_inquiry'] ?? 'SAADA PÄRING'); ?></a></p>

        
        <h2>
          <?php if($locale === 'ru'): ?> Сравнение: Самостоятельно vs. Обычный маклер vs. CityEE
          <?php elseif($locale === 'en'): ?> Comparison: Private Sale vs. Traditional Agent vs. CityEE
          <?php else: ?> Võrdlus: Ise vs. Tavamaakler vs. CityEE
          <?php endif; ?>
        </h2>

        <?php
        $compRows = $locale === 'ru' ? [
            ['label' => 'Ценовой коридор (аналитика)', 'private' => 'cross', 'traditional' => 'warn', 'cityee' => 'check'],
            ['label' => 'Переговорная стратегия', 'private' => 'cross', 'traditional' => 'warn', 'cityee' => 'check'],
            ['label' => 'Профессиональные фото', 'private' => 'cross', 'traditional' => 'check', 'cityee' => 'check'],
            ['label' => 'Размещение на всех порталах', 'private' => 'warn', 'traditional' => 'check', 'cityee' => 'check'],
            ['label' => 'Юридическая проверка', 'private' => 'cross', 'traditional' => 'warn', 'cityee' => 'check'],
            ['label' => 'План продажи на 30-45 дней', 'private' => 'cross', 'traditional' => 'cross', 'cityee' => 'check'],
            ['label' => 'Комиссия', 'private' => '0%', 'traditional' => '3-5%', 'cityee' => '2%'],
            ['label' => 'Средний срок продажи', 'private' => '3-6 мес.', 'traditional' => '2-3 мес.', 'cityee' => '1-1.5 мес.'],
        ] : ($locale === 'en' ? [
            ['label' => 'Price corridor (analytics)', 'private' => 'cross', 'traditional' => 'warn', 'cityee' => 'check'],
            ['label' => 'Negotiation strategy', 'private' => 'cross', 'traditional' => 'warn', 'cityee' => 'check'],
            ['label' => 'Professional photography', 'private' => 'cross', 'traditional' => 'check', 'cityee' => 'check'],
            ['label' => 'All portals listing', 'private' => 'warn', 'traditional' => 'check', 'cityee' => 'check'],
            ['label' => 'Legal verification', 'private' => 'cross', 'traditional' => 'warn', 'cityee' => 'check'],
            ['label' => 'Sale plan for 30-45 days', 'private' => 'cross', 'traditional' => 'cross', 'cityee' => 'check'],
            ['label' => 'Commission', 'private' => '0%', 'traditional' => '3-5%', 'cityee' => '2%'],
            ['label' => 'Average selling time', 'private' => '3-6 mo.', 'traditional' => '2-3 mo.', 'cityee' => '1-1.5 mo.'],
        ] : [
            ['label' => 'Hinnakorridor (analüütika)', 'private' => 'cross', 'traditional' => 'warn', 'cityee' => 'check'],
            ['label' => 'Läbirääkimisstrateegia', 'private' => 'cross', 'traditional' => 'warn', 'cityee' => 'check'],
            ['label' => 'Professionaalsed fotod', 'private' => 'cross', 'traditional' => 'check', 'cityee' => 'check'],
            ['label' => 'Reklaam kõikidel portaalidel', 'private' => 'warn', 'traditional' => 'check', 'cityee' => 'check'],
            ['label' => 'Juriidiline kontroll', 'private' => 'cross', 'traditional' => 'warn', 'cityee' => 'check'],
            ['label' => 'Müügiplaan 30-45 päevaks', 'private' => 'cross', 'traditional' => 'cross', 'cityee' => 'check'],
            ['label' => 'Vahendustasu', 'private' => '0%', 'traditional' => '3-5%', 'cityee' => '2%'],
            ['label' => 'Keskmine müügiaeg', 'private' => '3-6 kuud', 'traditional' => '2-3 kuud', 'cityee' => '1-1,5 kuud'],
        ]);

        $compHeaders = $locale === 'ru'
            ? ['Критерий', 'Самостоятельно', 'Обычный маклер', 'CityEE']
            : ($locale === 'en'
                ? ['Criteria', 'Private Sale', 'Traditional Agent', 'CityEE']
                : ['Kriteerium', 'Ise', 'Tavamaakler', 'CityEE']);
        ?>

        <div class="table__wrapp">
          <table class="comparison-table">
            <thead>
              <tr>
                <?php $__currentLoopData = $compHeaders; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $h): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <th><?php echo e($h); ?></th>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
              </tr>
            </thead>
            <tbody>
              <?php $__currentLoopData = $compRows; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
              <tr>
                <td><?php echo e($row['label']); ?></td>
                <?php $__currentLoopData = ['private', 'traditional', 'cityee']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $col): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <td class="text-center">
                  <?php if($row[$col] === 'check'): ?>
                    <span class="comparison-check">✓</span>
                  <?php elseif($row[$col] === 'cross'): ?>
                    <span class="comparison-cross">✗</span>
                  <?php elseif($row[$col] === 'warn'): ?>
                    <span class="comparison-warn">~</span>
                  <?php else: ?>
                    <strong><?php echo e($row[$col]); ?></strong>
                  <?php endif; ?>
                </td>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
              </tr>
              <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </tbody>
          </table>
        </div>

        <?php echo $__env->make('partials.ai-citation', ['locale' => $locale], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

      </div>
    </div>
  </div>
</div>

<?php echo $__env->make('partials.advantages', ['ui' => $ui, 'isPage' => true], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

<?php echo $__env->make('partials.about', ['ui' => $ui, 'isPage' => true], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

<?php echo $__env->make('partials.service-crosslinks', ['locale' => $locale, 'pageKey' => 'why'], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\nikol\Documents\projects\cityee-laravel\resources\views/pages/why.blade.php ENDPATH**/ ?>