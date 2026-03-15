
<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag;

$__newAttributes = [];
$__propNames = \Illuminate\View\ComponentAttributeBag::extractPropNames((['items' => []]));

foreach ($attributes->all() as $__key => $__value) {
    if (in_array($__key, $__propNames)) {
        $$__key = $$__key ?? $__value;
    } else {
        $__newAttributes[$__key] = $__value;
    }
}

$attributes = new \Illuminate\View\ComponentAttributeBag($__newAttributes);

unset($__propNames);
unset($__newAttributes);

foreach (array_filter((['items' => []]), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
}

$__defined_vars = get_defined_vars();

foreach ($attributes->all() as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
}

unset($__defined_vars, $__key, $__value); ?>

<?php
    // Ensure items is always an array (guard against double-encoded JSON)
    if (is_string($items)) {
        $items = json_decode($items, true) ?: [];
    }
    if (!is_array($items)) {
        $items = [];
    }
?>

<?php if(count($items)): ?>
<script type="application/ld+json">
<?php echo json_encode([
    '<?php $__contextArgs = [];
if (context()->has($__contextArgs[0])) :
if (isset($value)) { $__contextPrevious[] = $value; }
$value = context()->get($__contextArgs[0]); ?>'   => 'https://schema.org',
    '@type'      => 'FAQPage',
    'mainEntity' => collect($items)->map(fn($item) => [
        '@type'          => 'Question',
        'name'           => $item['q'] ?? $item['question'] ?? '',
        'acceptedAnswer' => [
            '@type' => 'Answer',
            'text'  => strip_tags($item['a'] ?? $item['answer'] ?? ''),
        ],
    ])->values()->all(),
], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT); ?>

</script>
<?php endif; ?>
<?php /**PATH C:\Users\nikol\Documents\projects\cityee-laravel\resources\views/components/faq-schema.blade.php ENDPATH**/ ?>