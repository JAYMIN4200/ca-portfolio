@props([
    'items' => 0,
    'max' => 3,
    'gap' => 'gap-6',
])

@php
    $items = (int) $items;
    $max = max(1, (int) $max);

    $columns = match (true) {
        $items <= 1 => 'max-w-2xl mx-auto grid-cols-1',
        $items === 2 => 'max-w-4xl mx-auto grid-cols-1 sm:grid-cols-2',
        $max === 2 => 'grid-cols-1 sm:grid-cols-2',
        $items === 3 => 'grid-cols-1 sm:grid-cols-2 lg:grid-cols-3',
        $items === 4 && $max >= 4 => 'grid-cols-1 sm:grid-cols-2 lg:grid-cols-4',
        $items === 4 => 'grid-cols-1 sm:grid-cols-2',
        $items === 5 && $max >= 4 => 'grid-cols-1 sm:grid-cols-2 lg:grid-cols-3',
        $max === 4 => 'grid-cols-1 sm:grid-cols-2 lg:grid-cols-4',
        default => 'grid-cols-1 sm:grid-cols-2 lg:grid-cols-3',
    };
@endphp

<div {{ $attributes->merge(['class' => "grid {$gap} {$columns}"]) }}>
    {{ $slot }}
</div>
