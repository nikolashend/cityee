
<?php
    $locale      = $locale ?? app()->getLocale();
    $navItems    = config("cityee.nav.{$locale}", []);
    $sidebarTitle = config("cityee.sidebar_title.{$locale}", 'Services');
?>

<div class="sidebar-menu">
    <strong class="sidebar-menu__title"><?php echo e($sidebarTitle); ?></strong>
    <ul class="sidebar-menu__list">
        <?php $__currentLoopData = $navItems; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $i => $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <?php
                $routeName = "{$locale}.{$item['route']}";
                $isFirst = $i === 0;
                $isLast  = $i === count($navItems) - 1;
                $isActive = Route::currentRouteName() === $routeName
                         || Route::currentRouteName() === "{$locale}." . ($pageKey ?? '');
                $classes = 'sidebar-menu__item';
                if ($isFirst) $classes .= ' first';
                if ($isLast)  $classes .= ' last';
                if ($item['route'] === ($pageKey ?? '')) $classes .= ' active';
            ?>
            <li class="<?php echo e($classes); ?>">
                <a href="<?php echo e(route($routeName)); ?>" title="<?php echo e($item['title']); ?>"><?php echo e($item['label']); ?></a>
            </li>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </ul>
</div>
<?php /**PATH C:\Users\nikol\Documents\projects\cityee-laravel\resources\views/partials/sidebar-services.blade.php ENDPATH**/ ?>