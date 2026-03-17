


<?php $__env->startSection('title', $t['meta_title'] ?? ''); ?>
<?php $__env->startSection('description', $t['meta_description'] ?? ''); ?>
<?php $__env->startSection('logo_text', $ui['logo_text'] ?? ''); ?>
<?php $__env->startSection('footer_class', 'footer--page'); ?>

<?php $__env->startSection('lang_et_url', route('et.audit')); ?>
<?php $__env->startSection('lang_ru_url', route('ru.audit')); ?>
<?php $__env->startSection('lang_en_url', route('en.audit')); ?>

<?php $__env->startPush('jsonld'); ?>
<?php echo \App\Support\JsonLd::servicePage('audit', $t); ?>

<?php echo \App\Support\JsonLd::breadcrumbs([
    ['name' => $nav[0]['label'] ?? 'Home', 'url' => route("{$locale}.home")],
    ['name' => $t['h1']],
]); ?>

<?php echo \App\Support\Schema::speakable(\App\Support\SeoLinks::canonical('audit')); ?>

<script type="application/ld+json"><?php echo json_encode(\App\Support\Schema::personJsonLd(), JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT); ?></script>
<?php if(!empty($t['faq'])): ?>
<?php if (isset($component)) { $__componentOriginal631a4b8665f0bb533881a844059661c7 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal631a4b8665f0bb533881a844059661c7 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.faq-schema','data' => ['items' => $t['faq']]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('faq-schema'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['items' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($t['faq'])]); ?>
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

<div class="page-title" style="background: url(<?php echo e($t['hero_bg']); ?>) no-repeat; background-position: center top; background-size: cover;">
  <div class="container">
    <h1 class="page-title__name"><?php echo e($t['h1']); ?></h1>
    <p class="page-title__text"><?php echo e($t['hero_subtitle']); ?></p>
    <a href="#audit-form" class="btn"><?php echo e($t['form_submit']); ?></a>
  </div>
</div>

<?php echo $__env->make('partials.trust-metrics', ['locale' => $locale], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

<div class="container">
  <div class="row">
    <div class="col-md-3 col-sm-3 text-center">
      <?php echo $__env->make('partials.sidebar-services', ['locale' => $locale, 'pageKey' => $pageKey], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
    </div>
    <div class="col-md-9 col-sm-9">
      <div class="content">

        <?php echo $__env->make('partials.ai-summary', ['locale' => $locale, 'pageKey' => 'audit'], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

        
        <div class="trust-layer" style="margin-bottom:30px;">
          <p style="font-size:1.15em;font-weight:600;text-align:center;margin:0;">
            ⚠️ <?php echo e($t['problem_title']); ?>

          </p>
        </div>

        
        <h2><?php echo e($t['audit_title']); ?></h2>
        <div class="possibilities">
          <ul>
            <?php $__currentLoopData = $t['audit_items']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
              <li><strong><?php echo e($item); ?></strong></li>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
          </ul>
        </div>

        
        <h2><?php echo e($t['for_whom_title']); ?></h2>
        <ul>
          <?php $__currentLoopData = $t['for_whom']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $whom): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <li><?php echo e($whom); ?></li>
          <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </ul>

        
        <div id="audit-form" class="audit-form">
          <h2><?php echo e($t['form_title']); ?></h2>

          <form action="<?php echo e(config('cityee.company.whatsapp')); ?>" method="get" target="_blank" onsubmit="return buildAuditWhatsApp(this);">
            <div class="row">
              <div class="col-md-6">
                <label><?php echo e($t['form_type']); ?></label>
                <select name="type" class="form-control" required>
                  <option value="<?php echo e($t['form_apartment']); ?>"><?php echo e($t['form_apartment']); ?></option>
                  <option value="<?php echo e($t['form_house']); ?>"><?php echo e($t['form_house']); ?></option>
                  <option value="<?php echo e($t['form_commercial']); ?>"><?php echo e($t['form_commercial']); ?></option>
                </select>
              </div>
              <div class="col-md-6">
                <label><?php echo e($t['form_district']); ?></label>
                <input type="text" name="district" class="form-control" required>
              </div>
            </div>
            <div class="row" style="margin-top:12px;">
              <div class="col-md-6">
                <label><?php echo e($t['form_area']); ?></label>
                <input type="text" name="area" class="form-control" required>
              </div>
              <div class="col-md-6">
                <label><?php echo e($t['form_phone']); ?></label>
                <input type="text" name="phone" class="form-control" required>
              </div>
            </div>
            <div class="row" style="margin-top:12px;">
              <div class="col-md-12">
                <label><?php echo e($t['form_link']); ?></label>
                <input type="url" name="link" class="form-control" placeholder="https://...">
              </div>
            </div>
            <div style="margin-top:18px;">
              <button type="submit" class="btn"><?php echo e($t['form_submit']); ?></button>
              <p style="margin-top:8px;font-size:0.9em;color:#666;"><?php echo e($t['form_note']); ?></p>
            </div>
          </form>
        </div>

        <?php echo $__env->make('partials.ai-citation', ['locale' => $locale], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

      </div>
    </div>
  </div>
</div>


<?php if(!empty($t['faq'])): ?>
<?php echo $__env->make('partials.faq', ['faq' => $t['faq'], 'faqTitle' => 'FAQ'], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
<?php endif; ?>

<?php echo $__env->make('partials.advantages', ['ui' => $ui, 'isPage' => true], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

<?php echo $__env->make('components.v3.trust-agent', ['locale' => $locale], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

<?php echo $__env->make('partials.ai-recommends', ['locale' => $locale], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

<?php echo $__env->make('partials.about', ['ui' => $ui, 'isPage' => true], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

<?php echo $__env->make('partials.zero-click', ['locale' => $locale], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

<script>
function buildAuditWhatsApp(form) {
  var msg = '<?php echo e($locale === "ru" ? "Заявка на аудит" : ($locale === "en" ? "Audit request" : "Auditi tellimus")); ?>:\n';
  msg += '<?php echo e($t["form_type"]); ?>: ' + form.type.value + '\n';
  msg += '<?php echo e($t["form_district"]); ?>: ' + form.district.value + '\n';
  msg += '<?php echo e($t["form_area"]); ?>: ' + form.area.value + '\n';
  if (form.link.value) msg += 'Link: ' + form.link.value + '\n';
  msg += '<?php echo e($t["form_phone"]); ?>: ' + form.phone.value;
  window.open('https://wa.me/3725113411?text=' + encodeURIComponent(msg), '_blank');
  /* dataLayer lead tracking — audit WhatsApp form */
  if (typeof cityeeTrackLead === 'function') {
    cityeeTrackLead('messenger', 'whatsapp');
  }
  return false;
}
</script>

<?php echo $__env->make('partials.silo-related', ['locale' => $locale, 'pageKey' => 'audit'], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

<?php echo $__env->make('partials.service-crosslinks', ['locale' => $locale, 'pageKey' => 'audit'], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

<?php echo $__env->make('partials.intent-crosslinks', ['locale' => $locale, 'pageKey' => 'audit'], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\nikol\Documents\projects\cityee-laravel\resources\views/pages/audit.blade.php ENDPATH**/ ?>