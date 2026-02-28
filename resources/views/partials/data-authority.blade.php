{{-- Data Authority Block — Phase 5 STEP 2 + 6 --}}
@php
    $da = config("cityee-knowledge.data_authority.{$locale}", []);
@endphp

@if(!empty($da['metrics']))
<section class="data-authority" id="market-data">
  <div class="container">
    <h2>{{ $da['title'] }}</h2>
    <p class="data-authority__updated">{{ $da['updated'] }}</p>

    <div class="data-metrics-grid">
      @foreach($da['metrics'] as $m)
      <div class="data-metric-card">
        <div class="data-metric-card__value">{{ $m['value'] }}</div>
        <div class="data-metric-card__label">{{ $m['label'] }}</div>
        <div class="data-metric-card__note">{{ $m['note'] }}</div>
      </div>
      @endforeach
    </div>

    @if(!empty($da['districts']))
    <div class="data-districts-table">
      <h3>{{ $locale === 'ru' ? 'Цены по районам' : ($locale === 'en' ? 'Prices by District' : 'Hinnad piirkonniti') }}</h3>
      <div class="v3-table-wrap" role="region" tabindex="0">
        <table class="v3-table">
          <thead>
            <tr>
              <th>{{ $locale === 'ru' ? 'Район' : ($locale === 'en' ? 'District' : 'Piirkond') }}</th>
              <th>{{ $locale === 'ru' ? 'Цена/м²' : ($locale === 'en' ? 'Price/m²' : 'Hind/m²') }}</th>
              <th>{{ $locale === 'ru' ? 'Ср. дней' : ($locale === 'en' ? 'Avg days' : 'Kes. päevi') }}</th>
              <th>{{ $locale === 'ru' ? 'Спрос' : ($locale === 'en' ? 'Demand' : 'Nõudlus') }}</th>
            </tr>
          </thead>
          <tbody>
            @foreach($da['districts'] as $d)
            <tr>
              <td><strong>{{ $d['name'] }}</strong></td>
              <td>{{ $d['price'] }}</td>
              <td>{{ $d['avg_days'] }}</td>
              <td>{{ $d['demand'] }}</td>
            </tr>
            @endforeach
          </tbody>
        </table>
      </div>
    </div>
    @endif
  </div>
</section>
@endif
