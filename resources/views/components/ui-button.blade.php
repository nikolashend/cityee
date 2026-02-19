{{--
  UiButton — Unified button component (ЭТАП 6)
  Usage:
    <x-ui-button href="#form" variant="primary">Get Audit</x-ui-button>
    <x-ui-button href="https://wa.me/..." variant="whatsapp" target="_blank">WhatsApp</x-ui-button>
    <x-ui-button variant="accent" type="submit">Send</x-ui-button>
    <x-ui-button variant="outline" full>Full width</x-ui-button>
--}}
@props([
    'variant' => 'primary',   // primary | whatsapp | accent | outline | ghost
    'href'    => null,
    'full'    => false,
    'size'    => 'md',         // sm | md | lg
    'icon'    => null,          // optional icon slot name
])

@php
    $tag   = $href ? 'a' : 'button';
    $base  = 'ui-btn';
    $cls   = "{$base} ui-btn--{$variant}";
    if ($full) $cls .= ' ui-btn--full';
    if ($size !== 'md') $cls .= " ui-btn--{$size}";
@endphp

<{{ $tag }}
    @if($href) href="{{ $href }}" @endif
    {{ $attributes->merge(['class' => $cls]) }}
>
    @if($icon)<span class="ui-btn__icon">{!! $icon !!}</span>@endif
    {{ $slot }}
</{{ $tag }}>
