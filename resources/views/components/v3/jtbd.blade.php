{{-- JTBD "For whom" block --}}
@props(['v3'])

<section class="v3-jtbd" aria-labelledby="v3-jtbd-title">
    <div class="container">
        <h2 id="v3-jtbd-title" class="v3-section-title">{{ $v3['jtbd_title'] }}</h2>
        <ul class="v3-jtbd__list">
            @foreach($v3['jtbd'] as $item)
            <li class="v3-jtbd__item">
                <span class="v3-jtbd__icon" aria-hidden="true">&#10148;</span>
                <span>{{ $item }}</span>
            </li>
            @endforeach
        </ul>
    </div>
</section>
