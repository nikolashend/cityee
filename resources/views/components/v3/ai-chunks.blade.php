{{-- AI / SGE semantic chunks --}}
@props(['v3'])

@if(!empty($v3['ai_short']))
<section class="v3-ai-chunks" aria-labelledby="v3-ai-short-title" data-nosnippet>
    <div class="container">
        {{-- Quick answer --}}
        <div class="v3-ai-chunk" itemscope itemtype="https://schema.org/FAQPage">
            <h2 id="v3-ai-short-title" class="v3-ai-chunk__title">{{ $v3['ai_short_title'] }}</h2>
            <p class="v3-ai-chunk__text" itemprop="abstract">{{ $v3['ai_short'] }}</p>
        </div>

        {{-- Summary bullets --}}
        @if(!empty($v3['ai_bullets']))
        <div class="v3-ai-chunk">
            <h3 class="v3-ai-chunk__title">{{ $v3['ai_bullets_title'] }}</h3>
            <ul class="v3-ai-chunk__list">
                @foreach($v3['ai_bullets'] as $b)
                <li>{{ $b }}</li>
                @endforeach
            </ul>
        </div>
        @endif

        {{-- What to do now --}}
        @if(!empty($v3['ai_next']))
        <div class="v3-ai-chunk">
            <h3 class="v3-ai-chunk__title">{{ $v3['ai_next_title'] }}</h3>
            <ol class="v3-ai-chunk__list v3-ai-chunk__list--numbered">
                @foreach($v3['ai_next'] as $step)
                <li>{{ $step }}</li>
                @endforeach
            </ol>
        </div>
        @endif
    </div>
</section>
@endif
