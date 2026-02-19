{{--
  UiAccordion — Unified FAQ / collapsible accordion (ЭТАП 6)
  Usage:
    <x-ui-accordion :items="$faq" :schema="true" id="service-faq" />
  Each item: ['q' => 'Question text', 'a' => 'Answer text']
--}}
@props([
    'items'  => [],
    'schema' => false,          // add FAQPage Schema.org
    'id'     => 'faq-section',
])

@if (count($items))
<div class="ui-accordion" id="{{ $id }}"
    @if($schema) itemscope itemtype="https://schema.org/FAQPage" @endif
>
    @foreach ($items as $i => $item)
    <div class="ui-accordion__item"
        @if($schema) itemscope itemprop="mainEntity" itemtype="https://schema.org/Question" @endif
    >
        <button
            class="ui-accordion__trigger"
            type="button"
            aria-expanded="false"
            aria-controls="{{ $id }}-panel-{{ $i }}"
            onclick="this.parentElement.classList.toggle('open');this.setAttribute('aria-expanded',this.parentElement.classList.contains('open'))"
        >
            <h3 class="ui-accordion__title" @if($schema) itemprop="name" @endif>{{ $item['q'] }}</h3>
            <span class="ui-accordion__chevron" aria-hidden="true">
                <svg width="16" height="16" viewBox="0 0 16 16" fill="none"><path d="M4 6l4 4 4-4" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
            </span>
        </button>
        <div
            class="ui-accordion__panel"
            id="{{ $id }}-panel-{{ $i }}"
            role="region"
            @if($schema) itemscope itemprop="acceptedAnswer" itemtype="https://schema.org/Answer" @endif
        >
            <div class="ui-accordion__content" @if($schema) itemprop="text" @endif>
                {!! $item['a'] !!}
            </div>
        </div>
    </div>
    @endforeach
</div>
@endif
