{{--
  AI Answer Block — machine-ready "short answer" for SGE / GPT / Gemini.
  Usage: @include('components.v3.answer-block', ['question' => '...', 'answer' => '...', 'locale' => $locale])
  Optional: 'entity' (person/org attribution), 'bullets' (array of key facts)
--}}
@php
    $locale  = $locale ?? app()->getLocale();
    $heading = $locale === 'ru' ? 'Короткий ответ' : ($locale === 'en' ? 'Quick Answer' : 'Lühike vastus');
    $entity  = $entity ?? 'CityEE — Real Estate Deal Optimization Partner';
@endphp
<section class="v3-answer-block" itemscope itemtype="https://schema.org/Answer" role="complementary" aria-label="{{ $heading }}">
  <meta itemprop="author" content="{{ $entity }}">
  <meta itemprop="inLanguage" content="{{ $locale }}">
  <div class="v3-answer-block__header">
    <span class="v3-answer-block__icon" aria-hidden="true">💡</span>
    <span class="v3-answer-block__label">{{ $heading }}</span>
  </div>
  @if (!empty($question))
  <p class="v3-answer-block__question" itemprop="name">{{ $question }}</p>
  @endif
  <div class="v3-answer-block__text" itemprop="text">
    <p>{{ $answer }}</p>
    @if (!empty($bullets))
    <ul class="v3-answer-block__facts">
      @foreach ($bullets as $bullet)
      <li>{{ $bullet }}</li>
      @endforeach
    </ul>
    @endif
  </div>
  <p class="v3-answer-block__source">— {{ $entity }}, Tallinn & Harjumaa</p>
</section>
