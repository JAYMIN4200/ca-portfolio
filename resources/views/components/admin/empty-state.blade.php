@props([
    'resource' => 'records',
    'message' => null,
    'createLabel' => null,
    'createRoute' => null,
    'colspan' => 6,
])

@php
    $filtersActive = collect(request()->query())
        ->except(['page', '_token'])
        ->reject(fn ($value) => $value === '' || $value === null || $value === [])
        ->isNotEmpty();
@endphp

<tr>
    <td colspan="{{ $colspan }}" class="px-4 py-12 text-center text-sm text-slate-500">
        @if ($filtersActive)
            <span>No {{ $resource }} match your filters.</span>
            <a href="{{ url()->current() }}" class="ml-1 font-medium text-navy-700 hover:underline">Clear filters →</a>
        @else
            {{ $message ?? ('No ' . $resource . ' found.') }}
            @if ($createLabel && $createRoute)
                <a href="{{ $createRoute }}" class="ml-1 font-medium text-navy-700 hover:underline">{{ $createLabel }} →</a>
            @endif
        @endif
    </td>
</tr>