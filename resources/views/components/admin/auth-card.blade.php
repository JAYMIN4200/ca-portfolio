@props([
    'heading' => '',
    'subtitle' => '',
])

@php
    $siteName = \App\Services\SettingsService::get('site_name', config('app.name'));
@endphp

{{-- Single, self-contained dark-glass card for all auth screens, so
     login, forgot and reset all share one consistent design. --}}
<div class="w-full max-w-md">
    <div class="relative overflow-hidden rounded-3xl bg-night/75 px-6 py-8 shadow-2xl shadow-black/60 ring-1 ring-white/10 backdrop-blur-xl sm:px-8">
        <div aria-hidden="true" class="pointer-events-none absolute inset-x-0 top-0 h-px bg-gradient-to-r from-transparent via-gold-400/80 to-transparent"></div>
        <div aria-hidden="true" class="pointer-events-none absolute -right-20 -top-20 h-48 w-48 rounded-full bg-violet-600/20 blur-3xl"></div>

        <div class="relative flex flex-col items-center gap-3 text-center">
            <x-admin.brand-mark size="h-14 w-14" text="text-2xl" rounded="rounded-2xl" />
            <div>
                <p class="font-display text-xl font-semibold text-white">Admin Panel</p>
                <p class="text-sm text-slate-400">{{ $siteName }}</p>
            </div>
        </div>

        <div aria-hidden="true" class="relative mx-auto mt-6 h-px w-24 bg-gradient-to-r from-transparent via-gold-400/40 to-transparent"></div>

        <div class="relative mt-6">
            <h1 class="text-center font-display text-2xl font-bold text-white">{{ $heading }}</h1>
            <p class="mt-1 text-center text-sm text-slate-400">{{ $subtitle }}</p>
        </div>

        <div class="relative mt-7">
            {{ $slot }}
        </div>
    </div>
</div>