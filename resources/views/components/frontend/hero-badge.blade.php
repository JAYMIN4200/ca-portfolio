@props([
    'title' => null,
    'label' => null,
    'position' => '-right-3 -top-3',
    'animation' => 'animate-float',
])

@if (filled($title) || filled($label))
    <div {{ $attributes->merge(['class' => "absolute {$position} hero-badge {$animation}"]) }}>
        <span class="hero-badge-ring" aria-hidden="true"></span>
        @if (filled($title))
            <p class="hero-badge-title">{{ $title }}</p>
        @endif
        @if (filled($label))
            <p class="hero-badge-label">{{ $label }}</p>
        @endif
    </div>
@endif
