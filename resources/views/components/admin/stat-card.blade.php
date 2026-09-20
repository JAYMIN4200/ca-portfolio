@props(['label', 'value', 'icon', 'color' => 'blue', 'countable' => false])

@php
    $colors = [
        'blue' => 'bg-blue-50 text-blue-600',
        'green' => 'bg-green-50 text-green-600',
        'purple' => 'bg-purple-50 text-purple-600',
        'gold' => 'bg-amber-50 text-gold-600',
        'red' => 'bg-red-50 text-red-600',
        'cyan' => 'bg-cyan-50 text-cyan-600',
        'amber' => 'bg-amber-50 text-amber-600',
        'navy' => 'bg-navy-50 text-navy-700',
    ];
@endphp

<div class="rounded-xl bg-white p-5 shadow-sm ring-1 ring-slate-200">
    <div class="flex items-center gap-4">
        <div class="flex h-11 w-11 shrink-0 items-center justify-center rounded-lg {{ $colors[$color] ?? $colors['blue'] }}">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-5 w-5">
                <path stroke-linecap="round" stroke-linejoin="round" d="{{ $icon }}" />
            </svg>
        </div>
        <div class="min-w-0">
            <p class="text-sm font-medium text-slate-500">{{ $label }}</p>
            @if ($countable)
                <p class="text-2xl font-semibold text-navy-950"><span data-count-to="{{ $value }}">{{ $value }}</span></p>
            @else
                <p class="text-2xl font-semibold text-navy-950">{{ $value }}</p>
            @endif
        </div>
    </div>
</div>