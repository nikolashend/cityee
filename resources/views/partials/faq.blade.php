{{-- FAQ Accordion with JSON-LD structured data --}}
@if (!empty($faq))
<section class="faq-section" itemscope itemtype="https://schema.org/FAQPage">
  <div class="container">
    <h2 class="main-h2">{{ $faqTitle ?? 'FAQ' }}</h2>
    <div class="faq-list">
      @foreach ($faq as $i => $item)
        <div class="faq-item" itemscope itemprop="mainEntity" itemtype="https://schema.org/Question">
          <div class="faq-question" role="button" tabindex="0" aria-expanded="false" onclick="this.parentElement.classList.toggle('active');this.setAttribute('aria-expanded',this.parentElement.classList.contains('active'))">
            <h3 itemprop="name" style="font-size:inherit;margin:0;font-weight:inherit;">{{ $item['q'] }}</h3>
          </div>
          <div class="faq-answer" itemscope itemprop="acceptedAnswer" itemtype="https://schema.org/Answer">
            <p itemprop="text">{{ $item['a'] }}</p>
          </div>
        </div>
      @endforeach
    </div>
  </div>
</section>
@endif
