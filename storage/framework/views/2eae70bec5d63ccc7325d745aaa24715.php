


<?php $__env->startSection('title', $t['meta_title'] ?? ''); ?>
<?php $__env->startSection('description', $t['meta_description'] ?? ''); ?>
<?php $__env->startSection('logo_text', $ui['logo_text'] ?? ''); ?>
<?php $__env->startSection('footer_class', 'footer--page'); ?>

<?php $__env->startSection('lang_et_url', route('et.contacts')); ?>
<?php $__env->startSection('lang_ru_url', route('ru.contacts')); ?>
<?php $__env->startSection('lang_en_url', route('en.contacts')); ?>

<?php $co = config('cityee.company'); ?>

<?php $__env->startPush('jsonld'); ?>
<?php echo \App\Support\JsonLd::contactPage($t); ?>

<?php echo \App\Support\JsonLd::breadcrumbs([
    ['name' => $nav[0]['label'] ?? 'Home', 'url' => route("{$locale}.home")],
    ['name' => $t['h1']],
]); ?>

<?php echo \App\Support\Schema::speakable(\App\Support\SeoLinks::canonical('contacts')); ?>

<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>

<div class="page-title page-title--map">
  <div class="container">
      <h1 class="page-title__name"><?php echo e($t['h1']); ?></h1>
  </div>
</div>


<div class="container">
  <div class="row">
    <div class="col-md-3 col-sm-3 text-center">
      <?php echo $__env->make('partials.sidebar-services', ['locale' => $locale, 'pageKey' => $pageKey], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
    </div>
    <div class="col-md-9 col-sm-9">
      <div class="content">
        <p><b class="pink"><?php echo e($t['office_label']); ?> </b><?php echo e($co['name']); ?></p>
        <p><b class="pink"><?php echo e($t['address_label']); ?> </b>Viru väljak 2, <?php echo e($co['city']); ?>, <?php echo e($co['postal_code']); ?></p>
        <p><b class="pink"><?php echo e($t['phone_label']); ?> </b><?php echo e($co['phone_display']); ?></p>
        <p><b class="pink"><?php echo e($t['app_phones']); ?> </b></p>
        <ul>
          <li><span class="pink">Viber: </span>+372 5113411</li>
          <li><span class="pink">Whatsapp: </span>+372 5113411</li>
          <li><span class="pink">Telegram: </span>+372 5113411</li>
        </ul>
        <p><b class="pink">WhatsApp: </b><a href="<?php echo e($co['whatsapp']); ?>" target="_blank" rel="noopener"><?php echo e($locale === 'en' ? 'Message on WhatsApp' : ($locale === 'ru' ? 'Написать в WhatsApp' : 'Kirjuta WhatsAppi')); ?></a></p>
        <p><b class="pink"><?php echo e($t['email_label']); ?> </b><a href="mailto:<?php echo e($co['email']); ?>"><?php echo e($co['email']); ?></a></p>
        <p><b class="pink">Facebook: </b><a href="<?php echo e($co['facebook']); ?>">facebook.com/cityee.ee</a></p>
        <p><b class="pink">Instagram: </b><a href="<?php echo e($co['instagram']); ?>">cityee_ee</a></p>

        <div style="margin:20px 0;">
          <a href="<?php echo e($co['whatsapp']); ?>" target="_blank" rel="noopener" class="btn" style="background:#25D366;border-color:#25D366;"><?php echo e($locale === 'ru' ? 'Написать в WhatsApp' : ($locale === 'en' ? 'Message on WhatsApp' : 'Kirjuta WhatsAppi')); ?></a>
          <a href="<?php echo e($co['telegram']); ?>" target="_blank" rel="noopener" class="btn" style="background:#0088cc;border-color:#0088cc;margin-left:8px;">Telegram</a>
        </div>

        <?php echo $__env->make('partials.ai-citation', ['locale' => $locale], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

        <h2><?php echo e($t['map_label']); ?></h2>

        <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2841.693973851092!2d24.74187045400807!3d59.43609556972047!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x469293621d944e45%3A0x531f7293499d42cd!2sViru%20t%C3%A4nav%202%2C%2010140%20Tallinn%2C%20Estonia!5e0!3m2!1sen!2sus!4v1594240713115!5m2!1sen!2sus" width="600" height="450" frameborder="0" style="border:0;" allowfullscreen="" aria-hidden="false" tabindex="0" loading="lazy"></iframe>

      </div>
    </div>
  </div>
</div>


<?php echo $__env->make('components.v3.form-audit', ['locale' => $locale], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
<?php echo $__env->make('components.v3.form-calc', ['locale' => $locale], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>


<?php echo $__env->make('components.v3.trust-agent', ['locale' => $locale], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>


<?php if(!empty($contactsFaq)): ?>
<?php echo $__env->make('partials.faq', ['faq' => $contactsFaq, 'faqTitle' => 'FAQ'], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
<?php endif; ?>


<?php echo $__env->make('components.v3.form-scripts', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

<?php echo $__env->make('partials.service-crosslinks', ['locale' => $locale, 'pageKey' => 'contacts'], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\nikol\Documents\projects\cityee-laravel\resources\views/pages/contacts.blade.php ENDPATH**/ ?>