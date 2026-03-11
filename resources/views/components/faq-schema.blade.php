{{--
  FAQ Schema — единый JSON-LD компонент для FAQPage.
  Принимает массив вопросов в формате ['q'=>..,'a'=>..] или ['question'=>..,'answer'=>..].

  Использование:
    <x-faq-schema :items="$faq" />

  Для страниц с несколькими блоками вопросов — объединить в один массив:
    <x-faq-schema :items="array_merge($aiFaq, $mainFaq)" />
--}}
@props(['items' => []])

@php
    // Ensure items is always an array (guard against double-encoded JSON)
    if (is_string($items)) {
        $items = json_decode($items, true) ?: [];
    }
    if (!is_array($items)) {
        $items = [];
    }
@endphp

@if(count($items))
<script type="application/ld+json">
{!! json_encode([
    '@context'   => 'https://schema.org',
    '@type'      => 'FAQPage',
    'mainEntity' => collect($items)->map(fn($item) => [
        '@type'          => 'Question',
        'name'           => $item['q'] ?? $item['question'] ?? '',
        'acceptedAnswer' => [
            '@type' => 'Answer',
            'text'  => strip_tags($item['a'] ?? $item['answer'] ?? ''),
        ],
    ])->values()->all(),
], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT) !!}
</script>
@endif
