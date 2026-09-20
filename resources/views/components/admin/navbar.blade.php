@props(['unreadMessages' => 0, 'counts' => []])

@php
    $user = auth()->user();
    $profile = $user?->profile;
    $firstName = head(preg_split('/\s+/', trim($user?->name ?? 'Admin')));
    $routeName = request()->route()?->getName();
    $pageTitle = $title ?? \App\Http\Helpers\AdminPageTitle::for($routeName);
    $pageCount = $counts[$routeName] ?? null;
    $lastLogin = $user?->last_login_at;
@endphp

<header class="sticky top-0 z-30 flex h-16 items-center gap-3 border-b border-slate-200 bg-white/90 px-4 backdrop-blur-md sm:px-6 lg:px-8">
    <button id="sidebarToggle" class="rounded-lg p-2 text-slate-600 transition-colors hover:bg-slate-100 hover:text-navy-900 lg:hidden" aria-label="Open sidebar">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-6 w-6">
            <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" />
        </svg>
    </button>

    {{-- Welcome + page title --}}
    <div class="min-w-0 flex-1">
        <p class="truncate text-[11px] font-semibold uppercase tracking-wider text-gold-600">
            Welcome, {{ $firstName }}
        </p>
        <h1 class="truncate text-lg font-semibold leading-tight text-navy-950">
            {{ $pageTitle }}@if (! is_null($pageCount)) <span class="font-normal text-slate-400">({{ $pageCount }})</span>@endif
        </h1>
    </div>

    {{-- Theme toggle --}}
    <button type="button" data-theme-toggle aria-label="Toggle light / dark theme" class="rounded-lg p-2 text-slate-600 transition-colors hover:bg-slate-100 hover:text-navy-900">
        <svg data-icon-dark xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-5 w-5">
            <path stroke-linecap="round" stroke-linejoin="round" d="M12 3v2.25m6.364.386l-1.591 1.591M21 12h-2.25m-.386 6.364l-1.591-1.591M12 18.75V21m-4.773-4.227l-1.591 1.591M5.25 12H3m4.227-4.773L5.636 5.636M15.75 12a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0z" />
        </svg>
        <svg data-icon-light class="hidden h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" d="M21.752 15.002A9.718 9.718 0 0118 15.75c-5.385 0-9.75-4.365-9.75-9.75 0-1.33.266-2.597.748-3.752A9.753 9.753 0 003 11.25C3 16.635 7.365 21 12.75 21a9.753 9.753 0 009.002-5.998z" />
        </svg>
    </button>

    {{-- Messages --}}
    <a href="{{ route('admin.messages.index') }}" title="Messages" class="relative rounded-lg p-2 text-slate-600 transition-colors hover:bg-slate-100 hover:text-navy-900">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-5 w-5">
            <path stroke-linecap="round" stroke-linejoin="round" d="M21.75 6.75v10.5a2.25 2.25 0 01-2.25 2.25h-15a2.25 2.25 0 01-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25m19.5 0v.243a2.25 2.25 0 01-1.07 1.916l-7.5 4.615a2.25 2.25 0 01-2.36 0L3.32 8.91a2.25 2.25 0 01-1.07-1.916V6.75" />
        </svg>
        @if ($unreadMessages > 0)
            <span class="absolute -right-0.5 -top-0.5 flex h-4 min-w-4 items-center justify-center rounded-full bg-slate-100 px-1 text-[10px] font-semibold text-slate-600 ring-1 ring-slate-200">{{ $unreadMessages }}</span>
        @endif
    </a>

    {{-- User dropdown --}}
    <div class="relative">
        <button id="userDropdownBtn" class="flex items-center gap-2.5 rounded-xl border border-slate-200 bg-white py-1.5 pl-1.5 pr-3 shadow-sm transition-all hover:shadow-md hover:border-navy-200">
            @if (!empty($profile?->profile_photo))
                <img src="{{ $profile->photo_url }}" alt="{{ $user?->name }}" class="h-8 w-8 rounded-lg object-cover ring-1 ring-slate-200">
            @else
                <span class="flex h-8 w-8 items-center justify-center rounded-lg bg-gradient-to-br from-navy-800 to-navy-950 text-sm font-bold text-gold-400">{{ strtoupper(substr($user?->name ?? 'C', 0, 1)) }}</span>
            @endif
            <span class="hidden min-w-0 max-w-[9rem] text-left md:block">
                <span class="block truncate text-sm font-semibold leading-tight text-slate-800">{{ $user?->name }}</span>
            </span>
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-4 w-4 shrink-0 text-slate-400 transition-transform" id="dropdownChevron">
                <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5" />
            </svg>
        </button>

        <div id="userDropdownMenu" data-open="false" class="dropdown-menu absolute right-0 z-40 mt-2 w-64 overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-xl">
            <div class="border-b border-slate-100 bg-gradient-to-br from-navy-900 to-navy-950 px-5 py-4">
                <p class="truncate text-sm font-medium text-white">{{ $user?->email }}</p>
                <div class="mt-3 flex items-center justify-between rounded-lg bg-white/5 px-3 py-2">
                    <span class="text-[11px] text-slate-300">Last Login</span>
                    <span class="text-[11px] font-medium text-gold-400">{{ $lastLogin ? $lastLogin->format('d M Y, h:i A') : '—' }}</span>
                </div>
            </div>

            <nav class="p-1.5">
                <a href="{{ route('admin.profile.edit') }}" class="flex items-center gap-3 rounded-lg px-3 py-2.5 text-sm font-medium text-slate-700 transition-colors hover:bg-slate-50 hover:text-navy-900">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-5 w-5 text-slate-400">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z" />
                    </svg>
                    My Profile
                </a>

                <div class="my-1.5 border-t border-slate-100"></div>

                <form method="POST" action="{{ route('admin.logout') }}" class="logout-form">
                    @csrf
                    <button type="submit" class="flex w-full items-center gap-3 rounded-lg px-3 py-2.5 text-sm font-medium text-red-600 transition-colors hover:bg-red-50">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-5 w-5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 9V5.25A2.25 2.25 0 0013.5 3h-6a2.25 2.25 0 00-2.25 2.25v13.5A2.25 2.25 0 007.5 21h6a2.25 2.25 0 002.25-2.25V15m3 0l3-3m0 0l-3-3m3 3H9" />
                        </svg>
                        Logout
                    </button>
                </form>
            </nav>
        </div>
    </div>
</header>