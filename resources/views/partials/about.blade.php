{{-- About CityEE section (reused on service pages and home) --}}
@php $ui = $ui ?? config('cityee.ui.' . ($locale ?? 'et')); @endphp

<div class="container">
  <article class="about{{ isset($isPage) && $isPage ? ' about--page' : '' }}">
    <h2 class="main-h2">{{ $ui['about_title'] }}</h2>
    <div class="row">
      <div class="col-xs-12">
        <img class="about__mobile-img" src="/assets/templates/offshors/img/about-foto-mobile.jpg" alt="{{ $ui['about_title'] }}">
      </div>
      <div class="col-sm-6 col-xs-12">
        <p>{{ $ui['about_p1'] }}</p>
        <p>{{ $ui['about_p2'] }}</p>
        <p>{{ $ui['about_p3'] }}</p>
      </div>
      <div class="col-sm-6 col-xs-12">
        <img class="about__desctop-img" src="/assets/templates/offshors/img/about-foto.jpg" alt="{{ $ui['about_title'] }}">
      </div>
    </div>
  </article>
</div>
