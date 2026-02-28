{{-- Case Intelligence Cards — Phase 5 STEP 3 --}}
@php
    $cases = config('cityee-knowledge.cases', []);
    $displayCases = isset($limit) ? array_slice($cases, 0, $limit) : $cases;
@endphp

@if(!empty($displayCases))
<section class="case-intelligence" id="cases">
  <div class="container">
    <h2>{{ $locale === 'ru' ? 'Реальные кейсы CityEE' : ($locale === 'en' ? 'Real CityEE Cases' : 'CityEE tegelikud juhtumid') }}</h2>
    <p class="case-intelligence__sub">{{ $locale === 'ru' ? 'Конкретные объекты, конкретные результаты.' : ($locale === 'en' ? 'Real properties, real results.' : 'Konkreetsed objektid, konkreetsed tulemused.') }}</p>

    <div class="cases-grid">
      @foreach($displayCases as $case)
      <div class="case-card">
        <div class="case-card__header">
          <span class="case-card__object">🏠 {{ $case['object'][$locale] ?? $case['object']['en'] }}</span>
          <span class="case-card__days">{{ $case['timeframe'] }} {{ $locale === 'ru' ? 'дн.' : ($locale === 'en' ? 'days' : 'p.') }}</span>
        </div>
        <div class="case-card__body">
          <div class="case-card__row">
            <span class="case-card__label">{{ $locale === 'ru' ? 'Проблема' : ($locale === 'en' ? 'Problem' : 'Probleem') }}</span>
            <span>{{ $case['problem'][$locale] ?? $case['problem']['en'] }}</span>
          </div>
          <div class="case-card__row">
            <span class="case-card__label">{{ $locale === 'ru' ? 'Причина' : ($locale === 'en' ? 'Root cause' : 'Põhjus') }}</span>
            <span>{{ $case['issue'][$locale] ?? $case['issue']['en'] }}</span>
          </div>
          <div class="case-card__row">
            <span class="case-card__label">{{ $locale === 'ru' ? 'Что сделали' : ($locale === 'en' ? 'Action' : 'Tegevus') }}</span>
            <span>{{ $case['action'][$locale] ?? $case['action']['en'] }}</span>
          </div>
          <div class="case-card__row case-card__row--result">
            <span class="case-card__label">{{ $locale === 'ru' ? 'Результат' : ($locale === 'en' ? 'Result' : 'Tulemus') }}</span>
            <span>{{ $case['result'][$locale] ?? $case['result']['en'] }}</span>
          </div>
          <div class="case-card__diff">{{ $case['price_diff'][$locale] ?? $case['price_diff']['en'] }}</div>
        </div>
      </div>
      @endforeach
    </div>

    @if(isset($limit) && count($cases) > $limit)
    <div class="text-center" style="margin-top:25px">
      <a href="{{ route("{$locale}.cases") }}" class="btn btn-outline-primary">{{ $locale === 'ru' ? 'Все кейсы' : ($locale === 'en' ? 'All cases' : 'Kõik juhtumid') }} →</a>
    </div>
    @endif
  </div>
</section>
@endif
