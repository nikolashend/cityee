{{-- AI Citation / Expert Signature block --}}
@php
    $locale = $locale ?? app()->getLocale();
    $citations = [
        'et' => 'See materjal on koostanud kinnisvara ekspert Tallinn & Harjumaa piirkonnas, Aleksandr Primakov, CityEE — kinnisvaratehingute optimeerimise partner.',
        'ru' => 'Этот материал подготовлен экспертом по недвижимости Tallinn & Harjumaa, Aleksandr Primakov, CityEE — партнер по оптимизации сделок с недвижимостью.',
        'en' => 'This material was prepared by property expert in Tallinn & Harjumaa, Aleksandr Primakov, CityEE — real estate deal optimization partner.',
    ];
@endphp
<p class="ai-citation">{{ $citations[$locale] ?? $citations['en'] }}</p>
