<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" data-theme-default="dark" data-theme-scope="admin" data-theme-session="{{ session('theme_admin') }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        @php
            $siteName = \App\Services\SettingsService::get('site_name', config('app.name'));
            $favicon = \App\Services\SettingsService::get('site_favicon');
            $faviconLetter = strtoupper(substr(\App\Services\SettingsService::get('logo_text', 'CA'), 0, 1));
        @endphp
        <title>{{ isset($title) ? $title . ' | ' . $siteName : $siteName }}</title>
        @if ($favicon)
            <link rel="icon" type="image/png" href="{{ Storage::url($favicon) }}">
        @else
            <link rel="icon" href="data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 100 100'%3E%3Crect width='100' height='100' rx='22' fill='%2314263d'/%3E%3Ctext x='50' y='68' font-size='52' text-anchor='middle' font-family='Georgia' fill='%23d9ac40'%3E{{ $faviconLetter }}%3C/text%3E%3C/svg%3E">
        @endif
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="relative min-h-screen overflow-x-hidden bg-gradient-to-br from-navy-950 via-violet-950 to-night font-sans text-slate-200 antialiased">
        @if (session('toast'))
            <div data-toast='{{ json_encode(session('toast')) }}' class="hidden"></div>
        @endif

        @if (session('status'))
            <div class="fixed inset-x-0 top-4 z-50 mx-auto w-full max-w-sm px-4">
                <div role="alert" data-auto-hide class="flex items-start gap-3 rounded-lg border border-green-200 bg-white/95 px-4 py-3 text-sm text-green-800 shadow-lg backdrop-blur">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="mt-0.5 h-5 w-5 shrink-0">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <p>{{ session('status') }}</p>
                </div>
            </div>
        @endif

        @if (session('error'))
            <div class="fixed inset-x-0 top-4 z-50 mx-auto w-full max-w-sm px-4">
                <div role="alert" data-auto-hide class="flex items-start gap-3 rounded-lg border border-red-200 bg-white/95 px-4 py-3 text-sm text-red-800 shadow-lg backdrop-blur">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="mt-0.5 h-5 w-5 shrink-0">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m9-.75a9 9 0 11-18 0 9 9 0 0118 0zm-9 3.75h.008v.008H12v-.008z" />
                    </svg>
                    <p>{{ session('error') }}</p>
                </div>
            </div>
        @endif
        <x-admin.auth-backdrop />

        <div class="relative z-10">
            {{ $slot }}
        </div>
    </body>
</html>