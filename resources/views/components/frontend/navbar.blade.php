@props(['settings' => [], 'profile' => null])

@php
    $navItems = [
        ['label' => 'Home', 'route' => 'home'],
        ['label' => 'About', 'route' => 'about'],
        ['label' => 'Qualifications', 'route' => 'qualifications'],
        ['label' => 'Skills', 'route' => 'skills'],
        ['label' => 'Experience', 'route' => 'experience'],
        ['label' => 'Services', 'route' => 'services'],
        ['label' => 'Assignments', 'route' => 'assignments'],
        ['label' => 'Contact', 'route' => 'contact'],
    ];
@endphp

<div class="fixed inset-x-0 top-0 z-50">
    {{-- Main nav --}}
    <header class="border-b border-white/10 bg-night/85 backdrop-blur-md">
        <div class="container-app flex h-16 items-center justify-between">
            <a href="{{ route('home') }}" class="flex items-center gap-3">
                <x-frontend.brand-mark size="h-9 w-9" text="text-lg" rounded="rounded-lg" />
                <div class="leading-tight">
                    <p class="text-sm font-display font-semibold text-white">{{ $settings['site_name'] ?? 'Jinendra Panchal' }}</p>
                    <p class="hidden text-[11px] font-medium tracking-wide text-violet-400 sm:block">
                        {{ $settings['site_title'] ?? $profile?->professional_title ?? 'CA Finalist · Taxation' }}
                    </p>
                </div>
            </a>

            <nav class="hidden items-center gap-1 xl:flex">
                @foreach ($navItems as $item)
                    <a href="{{ route($item['route']) }}"
                        class="rounded-lg px-3 py-2 text-sm font-medium transition-colors {{ request()->routeIs($item['route']) || request()->routeIs($item['route'] . '.*') ? 'bg-violet-500/15 text-violet-300' : 'text-slate-300 hover:text-white' }}">
                        {{ $item['label'] }}
                    </a>
                @endforeach
            </nav>

            <div class="flex items-center gap-3">
                <button type="button" data-theme-toggle aria-label="Toggle light / dark theme"
                    class="rounded-lg border border-white/10 bg-white/5 p-2 text-slate-300 transition-all duration-300 hover:border-violet-400/50 hover:bg-white/10 hover:text-violet-300">
                    <svg data-icon-dark xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-5 w-5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 3v2.25m6.364.386l-1.591 1.591M21 12h-2.25m-.386 6.364l-1.591-1.591M12 18.75V21m-4.773-4.227l-1.591 1.591M5.25 12H3m4.227-4.773L5.636 5.636M15.75 12a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0z" />
                    </svg>
                    <svg data-icon-light class="hidden h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M21.752 15.002A9.718 9.718 0 0118 15.75c-5.385 0-9.75-4.365-9.75-9.75 0-1.33.266-2.597.748-3.752A9.753 9.753 0 003 11.25C3 16.635 7.365 21 12.75 21a9.753 9.753 0 009.002-5.998z" />
                    </svg>
                </button>
                <a href="{{ route('contact') }}" class="hidden rounded-lg bg-gradient-to-r from-violet-500 to-violet-700 px-4 py-2 text-sm font-semibold text-white shadow-lg shadow-violet-700/30 transition-all hover:from-violet-400 hover:to-violet-600 md:block">
                    Get in Touch
                </a>
                <button id="mobileMenuBtn" class="rounded-lg p-2 text-white xl:hidden" aria-label="Open menu">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-6 w-6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" />
                    </svg>
                </button>
            </div>
        </div>

        <div id="mobileMenu" class="hidden border-t border-white/10 bg-night xl:hidden">
            <nav class="container-app space-y-1 py-4">
                @foreach ($navItems as $item)
                    <a href="{{ route($item['route']) }}"
                        class="block rounded-lg px-3 py-2.5 text-sm font-medium transition-colors {{ request()->routeIs($item['route']) || request()->routeIs($item['route'] . '.*') ? 'bg-violet-500/15 text-violet-300' : 'text-slate-300 hover:bg-white/5 hover:text-white' }}">
                        {{ $item['label'] }}
                    </a>
                @endforeach
                <a href="{{ route('contact') }}" class="mt-2 block rounded-lg bg-gradient-to-r from-violet-500 to-violet-700 px-3 py-2.5 text-center text-sm font-semibold text-white">
                    Get in Touch
                </a>
                <button type="button" data-theme-toggle aria-label="Toggle light / dark theme"
                    class="mt-2 flex w-full items-center justify-center gap-2 rounded-lg border border-white/10 bg-white/5 px-3 py-2.5 text-sm font-medium text-slate-300 transition-colors hover:border-violet-400/50 hover:text-violet-300">
                    <svg data-icon-dark xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-5 w-5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 3v2.25m6.364.386l-1.591 1.591M21 12h-2.25m-.386 6.364l-1.591-1.591M12 18.75V21m-4.773-4.227l-1.591 1.591M5.25 12H3m4.227-4.773L5.636 5.636M15.75 12a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0z" />
                    </svg>
                    <svg data-icon-light class="hidden h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M21.752 15.002A9.718 9.718 0 0118 15.75c-5.385 0-9.75-4.365-9.75-9.75 0-1.33.266-2.597.748-3.752A9.753 9.753 0 003 11.25C3 16.635 7.365 21 12.75 21a9.753 9.753 0 009.002-5.998z" />
                    </svg>
                    Switch theme
                </button>
            </nav>
        </div>
    </header>
</div>