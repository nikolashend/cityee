{{-- About CityEE section (reused on service pages and home) --}}
@php $ui = $ui ?? config('cityee.ui.' . ($locale ?? 'et')); @endphp

<div class="container">
  <article class="about{{ isset($isPage) && $isPage ? ' about--page' : '' }}">
    <h2 class="main-h2">{{ $ui['about_title'] }}</h2>
    <div class="row">
      <div class="col-xs-12">
        <img class="about__mobile-img" src="/assets/templates/offshors/img/about-foto-mobile.jpg" alt="{{ $ui['about_title'] }}" loading="lazy" width="600" height="400">
      </div>
      <div class="col-sm-6 col-xs-12">
        <p>{{ $ui['about_p1'] }}</p>
        <p>{{ $ui['about_p2'] }}</p>
        <p>{{ $ui['about_p3'] }}</p>
      </div>
      <div class="col-sm-6 col-xs-12">
        <img class="about__desctop-img" src="/assets/templates/offshors/img/about-foto.jpg" alt="{{ $ui['about_title'] }}" loading="lazy" width="555" height="740">
      </div>
    </div>
  </article>
</div>
