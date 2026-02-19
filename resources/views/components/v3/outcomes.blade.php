{{-- Outcomes: "What you get" cards --}}
@props(['v3'])

<section class="v3-outcomes" aria-labelledby="v3-outcomes-title">
    <div class="container">
        <h2 id="v3-outcomes-title" class="v3-section-title">{{ $v3['outcomes_title'] }}</h2>
        <div class="v3-outcomes__grid">
            @foreach($v3['outcomes'] as $o)
            <article class="v3-outcomes__card">
                <span class="v3-outcomes__icon" aria-hidden="true">{{ $o['icon'] }}</span>
                <h3 class="v3-outcomes__card-title">{{ $o['title'] }}</h3>
                <p class="v3-outcomes__desc">{{ $o['desc'] }}</p>
            </article>
            @endforeach
        </div>
    </div>
</section>
