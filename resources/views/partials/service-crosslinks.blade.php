{{-- Internal cross-links between services and knowledge pages — improves crawl depth --}}
@php
    $locale = $locale ?? app()->getLocale();
    $currentPageKey = $pageKey ?? '';

    $services = [
        'sell' => [
            'et' => ['label' => 'Kinnisvara müük', 'desc' => 'Professionaalne kinnisvara vahendamine'],
            'ru' => ['label' => 'Продажа недвижимости', 'desc' => 'Профессиональное посредничество'],
            'en' => ['label' => 'Property Sale', 'desc' => 'Professional real estate brokerage'],
        ],
        'rent' => [
            'et' => ['label' => 'Kinnisvara üür', 'desc' => 'Abi üürilepingu koostamisel'],
            'ru' => ['label' => 'Аренда недвижимости', 'desc' => 'Помощь с арендным договором'],
            'en' => ['label' => 'Property Rental', 'desc' => 'Rental agreement assistance'],
        ],
        'consultation' => [
            'et' => ['label' => 'Konsultatsioon', 'desc' => 'Kinnisvaraalane nõustamine'],
            'ru' => ['label' => 'Консультация', 'desc' => 'Консультирование по недвижимости'],
            'en' => ['label' => 'Consultation', 'desc' => 'Real estate consulting'],
        ],
        'audit' => [
            'et' => ['label' => 'Kuulutuse audit', 'desc' => 'Objekti analüüs ja soovitused'],
            'ru' => ['label' => 'Аудит объявления', 'desc' => 'Анализ объекта и рекомендации'],
            'en' => ['label' => 'Listing Audit', 'desc' => 'Property analysis & recommendations'],
        ],
    ];

    $titleMap = [
        'et' => 'Vaata ka teisi teenuseid',
        'ru' => 'Смотрите также другие услуги',
        'en' => 'See also our other services',
    ];

    $guidesLabel = ['et' => 'Ekspertjuhised', 'ru' => 'Экспертные гиды', 'en' => 'Expert Guides'];
    $guidesDesc  = ['et' => 'Kasulikud artiklid kinnisvara teemal', 'ru' => 'Полезные статьи о недвижимости', 'en' => 'Useful articles about real estate'];
    $auditsLabel = ['et' => 'Kinnisvara auditid', 'ru' => 'Разборы объектов', 'en' => 'Property Audits'];
    $auditsDesc  = ['et' => 'Reaalsed analüüsid ja juhtumid', 'ru' => 'Реальные разборы и кейсы', 'en' => 'Real case studies and analyses'];
    $profileLabel = ['et' => 'Aleksandr Primakov', 'ru' => 'Александр Примаков', 'en' => 'Aleksandr Primakov'];
    $profileDesc  = ['et' => 'Maakler Tallinnas — 10+ aastat kogemust', 'ru' => 'Маклер в Таллинне — 10+ лет опыта', 'en' => 'Broker in Tallinn — 10+ years experience'];
    $comparisonLabel = ['et' => 'Müüa ise vs partner', 'ru' => 'Продать самому vs партнёр', 'en' => 'DIY vs Strategy Partner'];
    $comparisonDesc  = ['et' => 'Aus võrdlus: ise müümine vs CityEE', 'ru' => 'Честное сравнение: сам vs CityEE', 'en' => 'Honest comparison: DIY vs CityEE'];
@endphp

<section class="section-padding" style="background:#f9f9f9;">
  <div class="container">
    <h2 class="main-h2" style="font-size:22px;text-transform:none;margin-bottom:30px;">{{ $titleMap[$locale] ?? $titleMap['et'] }}</h2>
    <div class="row">
      @foreach ($services as $key => $svc)
        @if ($key !== $currentPageKey)
        <div class="col-md-3 col-sm-6 col-xs-12" style="margin-bottom:20px;">
          <a href="{{ route("{$locale}.{$key}") }}" style="display:block;background:#fff;padding:20px 15px;border-radius:8px;text-decoration:none;color:#333;box-shadow:0 2px 8px rgba(0,0,0,.06);height:100%;">
            <strong style="display:block;font-size:17px;color:#7b1f45;margin-bottom:6px;">{{ $svc[$locale]['label'] ?? $svc['et']['label'] }}</strong>
            <span style="font-size:14px;color:#666;">{{ $svc[$locale]['desc'] ?? $svc['et']['desc'] }}</span>
          </a>
        </div>
        @endif
      @endforeach
      <div class="col-md-3 col-sm-6 col-xs-12" style="margin-bottom:20px;">
        <a href="{{ route("{$locale}.guides") }}" style="display:block;background:#fff;padding:20px 15px;border-radius:8px;text-decoration:none;color:#333;box-shadow:0 2px 8px rgba(0,0,0,.06);height:100%;">
          <strong style="display:block;font-size:17px;color:#7b1f45;margin-bottom:6px;">{{ $guidesLabel[$locale] ?? $guidesLabel['et'] }}</strong>
          <span style="font-size:14px;color:#666;">{{ $guidesDesc[$locale] ?? $guidesDesc['et'] }}</span>
        </a>
      </div>
      <div class="col-md-3 col-sm-6 col-xs-12" style="margin-bottom:20px;">
        <a href="{{ route("{$locale}.audits") }}" style="display:block;background:#fff;padding:20px 15px;border-radius:8px;text-decoration:none;color:#333;box-shadow:0 2px 8px rgba(0,0,0,.06);height:100%;">
          <strong style="display:block;font-size:17px;color:#7b1f45;margin-bottom:6px;">{{ $auditsLabel[$locale] ?? $auditsLabel['et'] }}</strong>
          <span style="font-size:14px;color:#666;">{{ $auditsDesc[$locale] ?? $auditsDesc['et'] }}</span>
        </a>
      </div>
      @if($currentPageKey !== 'profile')
      <div class="col-md-3 col-sm-6 col-xs-12" style="margin-bottom:20px;">
        <a href="{{ route("{$locale}.profile") }}" style="display:block;background:#fff;padding:20px 15px;border-radius:8px;text-decoration:none;color:#333;box-shadow:0 2px 8px rgba(0,0,0,.06);height:100%;">
          <strong style="display:block;font-size:17px;color:#7b1f45;margin-bottom:6px;">{{ $profileLabel[$locale] ?? $profileLabel['et'] }}</strong>
          <span style="font-size:14px;color:#666;">{{ $profileDesc[$locale] ?? $profileDesc['et'] }}</span>
        </a>
      </div>
      @endif
      @if($currentPageKey !== 'comparison')
      <div class="col-md-3 col-sm-6 col-xs-12" style="margin-bottom:20px;">
        <a href="{{ route("{$locale}.comparison") }}" style="display:block;background:#fff;padding:20px 15px;border-radius:8px;text-decoration:none;color:#333;box-shadow:0 2px 8px rgba(0,0,0,.06);height:100%;">
          <strong style="display:block;font-size:17px;color:#7b1f45;margin-bottom:6px;">{{ $comparisonLabel[$locale] ?? $comparisonLabel['et'] }}</strong>
          <span style="font-size:14px;color:#666;">{{ $comparisonDesc[$locale] ?? $comparisonDesc['et'] }}</span>
        </a>
      </div>
      @endif
    </div>

    {{-- Phase 3 RU links — internal linking to new intent pages --}}
    @if($locale === 'ru')
    @php
        $phase3Links = [
            ['url' => '/ru/prodat-kvartiru-v-tallinne/', 'label' => 'Продать квартиру в Таллине'],
            ['url' => '/ru/makler-v-tallinne/', 'label' => 'Маклер в Таллине'],
            ['url' => '/ru/ocenka-kvartiry-v-tallinne/', 'label' => 'Оценка квартиры'],
            ['url' => '/ru/tallinn/', 'label' => 'Районы Таллина'],
            ['url' => '/ru/cases/', 'label' => 'Реальные кейсы'],
            ['url' => '/ru/agentstvo-nedvizhimosti-tallinn/', 'label' => 'Агентство недвижимости'],
        ];
    @endphp
    <div style="margin-top:1.5rem">
      <h3 style="font-size:1rem;margin-bottom:.75rem;color:#333">Ещё по теме</h3>
      <div style="display:flex;flex-wrap:wrap;gap:.6rem">
        @foreach($phase3Links as $p3)
        <a href="{{ $p3['url'] }}" style="display:inline-block;padding:.4rem .9rem;background:#fff;border-radius:6px;text-decoration:none;color:#1a1a2e;font-size:.88rem;box-shadow:0 1px 3px rgba(0,0,0,.07)">{{ $p3['label'] }}</a>
        @endforeach
      </div>
    </div>
    @endif
  </div>
</section>
