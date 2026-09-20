@props(['groups' => []])

@php
    $user = auth()->user();
    $settings = \App\Services\SettingsService::all();
    $brandTitle = $settings['site_name'] ?? config('app.name');
    $routeName = request()->route()?->getName() ?? '';

    $isItemActive = function (array $item) use ($routeName) {
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

    $isGroupActive = function (array $group) use ($isItemActive) {
        return collect($group['items'])->contains(fn ($item) => $isItemActive($item));
    };
@endphp

<aside id="sidebar" class="fixed inset-y-0 left-0 z-40 flex w-64 -translate-x-full flex-col bg-navy-950 lg:translate-x-0">
    {{-- Brand --}}
    <div class="flex h-16 shrink-0 items-center border-b border-white/10 px-4">
        <a href="{{ route('admin.dashboard') }}" class="sidebar-brand flex min-w-0 flex-1 items-center gap-3">
            <x-admin.brand-mark />
            <div class="sidebar-brand-text min-w-0 leading-tight">
                <p class="truncate text-sm font-semibold text-white">{{ $brandTitle }}</p>
                <p class="truncate text-xs text-slate-400">Admin Panel</p>
            </div>
        </a>
        <div class="sidebar-brand-actions flex shrink-0 items-center">
            <button type="button" id="sidebarCollapseBtn" title="Collapse sidebar"
                class="hidden rounded-lg p-2 text-slate-400 transition-colors hover:bg-white/5 hover:text-white lg:block">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-5 w-5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M21 16.811c0 .864-.933 1.406-1.683.977l-7.108-4.061a1.125 1.125 0 010-1.954l7.108-4.061A1.125 1.125 0 0121 8.689v8.122zM11.25 16.811c0 .864-.933 1.406-1.683.977l-7.108-4.061a1.125 1.125 0 010-1.954l7.108-4.061a1.125 1.125 0 011.683.977v8.122z" />
                </svg>
            </button>
            <button id="sidebarClose" class="rounded-lg p-2 text-slate-400 hover:text-white lg:hidden">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-6 w-6">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>
    </div>

    {{-- Nav --}}
    <nav class="flex-1 overflow-y-auto overflow-x-hidden px-3 py-4">
        @foreach ($groups as $group)
            @if (count($group['items']) === 1)
                @php
                    $item = $group['items'][0];
                    $active = $isItemActive($item);
                @endphp
                <a href="{{ route($item['route']) }}" title="{{ $item['label'] }}"
                    class="{{ $active ? 'bg-gradient-to-r from-gold-500/20 to-transparent text-white ring-1 ring-inset ring-gold-500/30' : 'text-slate-400 hover:bg-white/5 hover:text-white' }} sidebar-link mb-1 flex items-center gap-3 rounded-lg px-3 py-2.5 text-sm font-medium transition-colors">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-5 w-5 shrink-0">
                        <path stroke-linecap="round" stroke-linejoin="round" d="{{ $item['icon'] }}" />
                    </svg>
                    <span class="sidebar-label min-w-0 flex-1 whitespace-nowrap">
                        {{ $item['label'] }}
                    </span>
                </a>
            @else
                @php $groupActive = $isGroupActive($group); @endphp
                <div class="sidebar-group mb-1" data-sidebar-group {{ $groupActive ? 'data-expanded' : '' }}>
                    <button type="button" data-sidebar-group-toggle
                        title="{{ $group['label'] }}"
                        class="{{ $groupActive ? 'bg-white/10 text-white' : 'text-slate-400 hover:bg-white/5 hover:text-white' }} sidebar-link flex w-full items-center gap-3 rounded-lg px-3 py-2.5 text-sm font-medium transition-colors">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-5 w-5 shrink-0">
                            <path stroke-linecap="round" stroke-linejoin="round" d="{{ $group['icon'] ?? $group['items'][0]['icon'] }}" />
                        </svg>
                        <span class="sidebar-label min-w-0 flex-1 whitespace-nowrap text-left">{{ $group['label'] }}</span>
                        <svg data-sidebar-group-chevron xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="sidebar-group-chevron h-4 w-4 shrink-0 transition-transform duration-200">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5" />
                        </svg>
                    </button>
                    <div data-sidebar-group-items class="sidebar-group-items ml-4 mt-1 space-y-1 border-l border-white/10 pl-2 {{ $groupActive ? '' : 'hidden' }}">
                        @foreach ($group['items'] as $item)
                            @php $active = $isItemActive($item); @endphp
                            <a href="{{ route($item['route']) }}" title="{{ $item['label'] }}"
                                class="{{ $active ? 'bg-gradient-to-r from-gold-500/20 to-transparent text-white ring-1 ring-inset ring-gold-500/30' : 'text-slate-400 hover:bg-white/5 hover:text-white' }} sidebar-link flex items-center gap-3 rounded-lg px-3 py-2.5 text-sm font-medium transition-colors">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-5 w-5 shrink-0">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="{{ $item['icon'] ?? $group['icon'] }}" />
                                </svg>
                                <span class="sidebar-label min-w-0 flex-1 whitespace-nowrap">
                                    {{ $item['label'] }}
                                </span>
                            </a>
                        @endforeach
                    </div>
                </div>
            @endif
        @endforeach
    </nav>

    {{-- Footer actions --}}
    <div class="shrink-0 space-y-1 border-t border-white/10 p-3">
        <a href="{{ route('home') }}" target="_blank" title="View Website"
            class="sidebar-link flex items-center gap-3 rounded-lg px-3 py-2.5 text-sm font-medium text-slate-400 transition-colors hover:bg-white/5 hover:text-white">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-5 w-5 shrink-0">
                <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 6H5.25A2.25 2.25 0 003 8.25v10.5A2.25 2.25 0 005.25 21h10.5A2.25 2.25 0 0018 18.75V10.5m-10.5 6L21 3m0 0h-5.25M21 3v5.25" />
            </svg>
            <span class="sidebar-label whitespace-nowrap">View Website</span>
        </a>
        <form method="POST" action="{{ route('admin.logout') }}" class="logout-form">
            @csrf
            <button type="submit" title="Logout"
                class="sidebar-link flex w-full items-center gap-3 rounded-lg px-3 py-2.5 text-sm font-medium text-slate-400 transition-colors hover:bg-red-500/10 hover:text-red-400">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-5 w-5 shrink-0">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 9V5.25A2.25 2.25 0 0013.5 3h-6a2.25 2.25 0 00-2.25 2.25v13.5A2.25 2.25 0 007.5 21h6a2.25 2.25 0 002.25-2.25V15m3 0l3-3m0 0l-3-3m3 3H9" />
                </svg>
                <span class="sidebar-label whitespace-nowrap">Logout</span>
            </button>
        </form>
    </div>
</aside>