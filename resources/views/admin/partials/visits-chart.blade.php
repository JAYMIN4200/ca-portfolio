@php
    $labels = $visitLabels ?? [];
    $data = $visitData ?? [];
    $maxCount = max(1, ! empty($data) ? max($data) : 0);
@endphp

<div class="mt-6 flex min-h-44 flex-1 items-end gap-2 sm:gap-3">
    @forelse ($labels as $index => $label)
        @php
            $count = (int) ($data[$index] ?? 0);
            $barHeight = max(8, (int) round(($count / $maxCount) * 120));
        @endphp
        <div class="flex h-full flex-1 flex-col items-center justify-end gap-1.5">
            <span class="text-xs font-semibold text-navy-950">{{ $count }}</span>
            <div class="w-full max-w-12 rounded-t-lg bg-gradient-to-t from-navy-800 to-gold-500" style="height: {{ $barHeight }}px;" title="{{ $label }}: {{ $count }}"></div>
        </div>
    @empty
        <p class="w-full py-8 text-center text-sm text-slate-500">No visits data for the selected period.</p>
    @endforelse
</div>
@if (! empty($labels))
    <div class="mt-2 flex gap-2 sm:gap-3">
        @foreach ($labels as $label)
            <span class="flex-1 truncate text-center text-[10px] font-medium text-slate-400">{{ $label }}</span>
        @endforeach
    </div>
@endif
