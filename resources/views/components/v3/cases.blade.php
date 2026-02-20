{{-- Case studies block --}}
@props(['v3', 'company'])
@php
    $wa = config('cityee-v3.social_links.whatsapp_audit', 'https://wa.me/+37258829892');
@endphp

@if(!empty($v3['cases']))
<section class="v3-cases" aria-labelledby="v3-cases-title">
    <div class="container">
        <h2 id="v3-cases-title" class="v3-section-title">{{ $v3['cases_title'] }}</h2>

        <div class="v3-cases__grid">
            @foreach($v3['cases'] as $c)
            <article class="v3-cases__card">
                <p class="v3-cases__type"><strong>{{ $c['type'] }}</strong></p>
                <p class="v3-cases__problem">{{ $c['problem'] }}</p>
                <ul class="v3-cases__actions">
                    @foreach($c['actions'] as $a)
                    <li>{{ $a }}</li>
                    @endforeach
                </ul>
                <p class="v3-cases__result"><strong>&#10003;</strong> {{ $c['result'] }}</p>
            </article>
            @endforeach
        </div>

        @if(!empty($v3['cases_cta']))
        <div class="v3-cases__cta-row">
            <a href="" id="feedback-cases" class="v3-btn v3-btn--primary">
                {{ $v3['cases_cta'] }}
            </a>
        </div>
        @endif
    </div>
</section>
@endif
