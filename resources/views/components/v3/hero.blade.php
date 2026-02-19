{{-- Hero v3: Intent-first hero with H1, subtitle, 2 CTAs, trust bullets --}}
@props(['v3', 'company'])
@php
    $wa = $company['social']['whatsapp'] ?? 'https://wa.me/3725113411';
@endphp

<section class="v3-hero" itemscope itemtype="https://schema.org/Service">
    <div class="v3-hero__inner container">
        <h1 class="v3-hero__h1" itemprop="name">{{ $v3['hero_h1'] }}</h1>
        <p class="v3-hero__sub" itemprop="description">{{ $v3['hero_sub'] }}</p>

        <div class="v3-hero__ctas">
            <a href="#v3-form-audit" class="v3-btn v3-btn--primary">{{ $v3['hero_cta1'] }}</a>
            <a href="{{ $wa }}" target="_blank" rel="noopener" class="v3-btn v3-btn--whatsapp">
                <i class="fa fa-whatsapp"></i> {{ $v3['hero_cta2'] }}
            </a>
        </div>

        @if(!empty($v3['hero_trust']))
        <ul class="v3-hero__trust" aria-label="Trust bullets">
            @foreach($v3['hero_trust'] as $bullet)
            <li><span class="v3-hero__check">&#10003;</span> {{ $bullet }}</li>
            @endforeach
        </ul>
        @endif
    </div>
</section>
