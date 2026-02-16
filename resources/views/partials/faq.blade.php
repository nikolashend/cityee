{{-- FAQ section with FAQ Schema markup --}}
@if (!empty($faq))
<section class="faq-section">
  <div class="container">
    <h2 class="main-h2">{{ $faqTitle ?? 'FAQ' }}</h2>
    <div class="faq-list">
      @foreach ($faq as $item)
        <div class="faq-item" itemscope itemprop="mainEntity" itemtype="https://schema.org/Question">
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
