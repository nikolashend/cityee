{{-- Advantages section (reused on service pages and home) --}}
@php $ui = $ui ?? config('cityee.ui.' . ($locale ?? 'et')); @endphp

<section class="advantages{{ isset($isPage) && $isPage ? ' advantages--page' : '' }}">
  <div class="container">
    <h2 class="advantages__title">{{ $ui['advantages_title'] ?? 'Meiega koostöö eelised' }}</h2>
    <ul class="advantages__list">
      <li class="advantages__item">
        <div class="advantages__img advantages__img--speed"></div>
        <p class="advantages__text">{{ $ui['adv_speed'] }}</p>
      </li>
      <li class="advantages__item">
        <div class="advantages__img advantages__img--availability"></div>
        <p class="advantages__text">{{ $ui['adv_quality'] }}</p>
      </li>
      <li class="advantages__item">
        <div class="advantages__img advantages__img--confidentiality"></div>
        <p class="advantages__text">{{ $ui['adv_confid'] }}</p>
      </li>
      <li class="advantages__item">
        <div class="advantages__img advantages__img--reliability"></div>
        <p class="advantages__text">{{ $ui['adv_reliable'] }}</p>
      </li>
    </ul>
  </div>
</section>
