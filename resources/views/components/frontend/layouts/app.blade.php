<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" data-theme-default="dark" data-theme-scope="frontend" data-theme-session="{{ session('theme_frontend') }}">
    <head>
        @props(['seoTitle' => null, 'seoDescription' => null])
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <meta name="theme-endpoint" content="{{ route('theme.update') }}">
        <script>!function(){var d=document.documentElement,k='ca_theme_'+(d.getAttribute('data-theme-scope')||'frontend'),t=null;try{t=localStorage.getItem(k)}catch(e){}d.setAttribute('data-theme',t||d.getAttribute('data-theme-session')||d.getAttribute('data-theme-default')||'dark')}();</script>
        @if (!empty($seoTitle))
            <title>{{ $seoTitle }}</title>
        @else
            <title>{{ $settings['seo_title'] ?? $settings['site_title'] ?? config('app.name') }}</title>
        @endif
        @php
            $metaDescription = $seoDescription ?: ($settings['seo_description'] ?? null);
        @endphp
        @if (!empty($metaDescription))
            <meta name="description" content="{{ $metaDescription }}">
        @endif
        @if (!empty($settings['seo_keywords']))
            <meta name="keywords" content="{{ $settings['seo_keywords'] }}">
        @endif
        @php
            $favicon = $settings['site_favicon'] ?? null;
            $faviconLetter = strtoupper(substr($settings['logo_text'] ?? 'CA', 0, 1));
        @endphp
        @if ($favicon)
            <link rel="icon" type="image/png" href="{{ asset('storage/' . $favicon) }}">
        @else
            <link rel="icon" href="data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 100 100'%3E%3Crect width='100' height='100' rx='22' fill='%230b1020'/%3E%3Cpath d='M62 22H32' stroke='%238b5cf6' stroke-width='10' stroke-linecap='round'/%3E%3Cpath d='M42 22v52m0 0h4a11 11 0 0011-11V57a11 11 0 00-11-11' fill='none' stroke='%238b5cf6' stroke-width='10' stroke-linecap='round'/%3E%3C/svg%3E">
        @endif
        <link rel="canonical" href="{{ url()->current() }}">

        @php $ogImage = $profile?->og_image ?: $profile?->profile_photo; @endphp
        @if (!empty($ogImage))
            <meta property="og:image" content="{{ asset('storage/' . $ogImage) }}">
        @endif
        <meta property="og:title" content="{{ $seoTitle ?? $settings['seo_title'] ?? $settings['site_title'] ?? config('app.name') }}">
        <meta property="og:description" content="{{ $metaDescription ?? '' }}">
        <meta property="og:type" content="website">
        <meta property="og:url" content="{{ url()->current() }}">
        <meta name="twitter:card" content="summary">
        <meta name="twitter:title" content="{{ $seoTitle ?? $settings['seo_title'] ?? $settings['site_title'] ?? config('app.name') }}">
        <meta name="twitter:description" content="{{ $metaDescription ?? '' }}">

        @vite(['resources/css/app.css', 'resources/js/app.js'])

        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Instrument+Sans:wght@400;500;600;700&family=Sora:wght@600;700;800&display=swap" rel="stylesheet">
    </head>
    <body class="bg-night font-sans text-slate-300 antialiased">
        <x-frontend.navbar :settings="$settings" :profile="$profile" />

        <main>
            {{ $slot }}
        </main>

        <x-frontend.footer :settings="$settings" :profile="$profile" />

        <button id="backToTop" type="button" aria-label="Back to top"
            class="fixed right-5 bottom-5 z-40 flex h-11 w-11 items-center justify-center rounded-full bg-gradient-to-br from-violet-600 to-violet-800 text-white shadow-lg shadow-violet-600/30 opacity-0 transition-all hover:from-violet-500 hover:to-violet-700 pointer-events-none md:right-8 md:bottom-8">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="h-5 w-5">
                <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 15.75l7.5-7.5 7.5 7.5" />
            </svg>
        </button>
    </body>
</html>