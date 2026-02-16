{{-- Sidebar menu for service/contact pages --}}
@php
    $locale      = $locale ?? app()->getLocale();
    $navItems    = config("cityee.nav.{$locale}", []);
    $sidebarTitle = config("cityee.sidebar_title.{$locale}", 'Services');
@endphp

<div class="sidebar-menu">
    <strong class="sidebar-menu__title">{{ $sidebarTitle }}</strong>
    <ul class="sidebar-menu__list">
        @foreach ($navItems as $i => $item)
            @php
                $routeName = "{$locale}.{$item['route']}";
                $isFirst = $i === 0;
                $isLast  = $i === count($navItems) - 1;
                $isActive = Route::currentRouteName() === $routeName
                         || Route::currentRouteName() === "{$locale}." . ($pageKey ?? '');
                $classes = 'sidebar-menu__item';
                if ($isFirst) $classes .= ' first';
                if ($isLast)  $classes .= ' last';
                if ($item['route'] === ($pageKey ?? '')) $classes .= ' active';
            @endphp
            <li class="{{ $classes }}">
                <a href="{{ route($routeName) }}" title="{{ $item['title'] }}">{{ $item['label'] }}</a>
            </li>
        @endforeach
    </ul>
</div>
