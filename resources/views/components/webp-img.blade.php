@props(['src', 'alt' => '', 'class' => '', 'width' => null, 'height' => null, 'loading' => 'lazy', 'decoding' => 'async', 'fetchpriority' => null])
@php
    $webp = preg_replace('/\.(jpe?g|png)$/i', '.webp', $src);
@endphp
<picture>
    <source srcset="{{ $webp }}" type="image/webp">
    <img src="{{ $src }}"
         alt="{{ $alt }}"
         @if($class) class="{{ $class }}" @endif
         @if($width) width="{{ $width }}" @endif
         @if($height) height="{{ $height }}" @endif
         loading="{{ $loading }}"
         decoding="{{ $decoding }}"
         @if($fetchpriority) fetchpriority="{{ $fetchpriority }}" @endif
    >
</picture>
