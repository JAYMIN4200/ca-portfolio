@props(['tabs' => [], 'title' => null])

@php
    $routeName = request()->route()?->getName() ?? '';

    $isActive = function (array $item) use ($routeName) {
        $bases = $item['matchers'] ?? [];
        $derived = preg_replace('/\.[^.]+$/', '', $item['route']);
        if (str_contains($derived, '.')) {
            $bases[] = $derived;
        }
        $bases[] = $item['route'];

        return collect($bases)->contains(function ($base) use ($routeName) {
            return $base !== '' && ($routeName === $base || str_starts_with($routeName, $base.'.'));
        });
    };
@endphp

@if (count($tabs) > 1)
    <div class="section-switch mb-5">
        <div class="section-switch-card">
            <div class="section-switch-track">
                @foreach ($tabs as $tab)
                    @php $active = $isActive($tab); @endphp
                    <a href="{{ route($tab['route']) }}" title="{{ $tab['label'] }}"
                        class="section-switch-item {{ $active ? 'is-active' : '' }}">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-4 w-4 shrink-0">
                            <path stroke-linecap="round" stroke-linejoin="round" d="{{ $tab['icon'] }}" />
                        </svg>
                        <span>{{ $tab['label'] }}</span>
                    </a>
                @endforeach
            </div>
            @if ($title)
                <span class="section-switch-title">{{ $title }}</span>
            @endif
        </div>
    </div>
@endif