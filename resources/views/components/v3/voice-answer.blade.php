{{--
  Voice Search Q&A Block — optimized for voice assistants and AI Overview.
  40–60 word answers. Uses QAPage schema pattern.
  Usage: @include('components.v3.voice-answer', ['items' => [...], 'locale' => $locale])
  Each item: ['q' => '...', 'a' => '...']
--}}
@php
    $locale = $locale ?? app()->getLocale();
    $title  = $locale === 'ru' ? 'Частые вопросы (голосовой поиск)' : ($locale === 'en' ? 'Voice Search Q&A' : 'Häälotsingu KKK');
@endphp
@if (!empty($items))
<section class="v3-voice-qa" aria-label="{{ $title }}">
  <h2 class="v3-section-title">{{ $title }}</h2>
  <div class="v3-voice-qa__list">
    @foreach ($items as $item)
    <div class="v3-voice-qa__item" itemscope itemtype="https://schema.org/Question">
      <h3 class="v3-voice-qa__question" itemprop="name">{{ $item['q'] }}</h3>
      <div class="v3-voice-qa__answer" itemscope itemtype="https://schema.org/Answer" itemprop="acceptedAnswer">
        <p itemprop="text">{{ $item['a'] }}</p>
      </div>
    </div>
    @endforeach
  </div>
</section>
@endif
