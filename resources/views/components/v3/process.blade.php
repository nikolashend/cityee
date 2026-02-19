{{-- Process: step-by-step "How we work" --}}
@props(['v3'])

<section class="v3-process" aria-labelledby="v3-process-title">
    <div class="container">
        <h2 id="v3-process-title" class="v3-section-title">{{ $v3['process_title'] }}</h2>
        <ol class="v3-process__steps">
            @foreach($v3['process'] as $s)
            <li class="v3-process__step">
                <span class="v3-process__num" aria-hidden="true">{{ $s['step'] }}</span>
                <div class="v3-process__body">
                    <h3 class="v3-process__step-title">{{ $s['title'] }}</h3>
                    <p class="v3-process__desc">{{ $s['desc'] }}</p>
                </div>
            </li>
            @endforeach
        </ol>
    </div>
</section>
