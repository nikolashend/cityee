{{-- Zero-click quick answer block — direct answers for featured snippets / AI --}}
@php
    $zeroClick = config("cityee-intent.zero_click.{$locale}", []);
@endphp

@if(!empty($zeroClick))
<section class="zero-click-answers" itemscope itemtype="https://schema.org/FAQPage">
  <div class="container">
    <h2>{{ $locale === 'ru' ? 'Быстрые ответы' : ($locale === 'en' ? 'Quick Answers' : 'Kiired vastused') }}</h2>
    <div class="zero-click-grid">
      @foreach($zeroClick as $item)
      <div class="zero-click-card" itemscope itemprop="mainEntity" itemtype="https://schema.org/Question">
        <h3 itemprop="name">{{ $item['q'] }}</h3>
        <div itemscope itemprop="acceptedAnswer" itemtype="https://schema.org/Answer">
          <p itemprop="text">{{ $item['a'] }}</p>
        </div>
      </div>
      @endforeach
    </div>
  </div>
</section>
@endif
