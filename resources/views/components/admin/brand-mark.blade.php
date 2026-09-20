@props([
    'size' => 'h-9 w-9',
    'text' => 'text-lg',
    'rounded' => 'rounded-lg',
])

@php
    $brandName = \App\Services\SettingsService::get('site_name', config('app.name'));
    $siteFavicon = \App\Services\SettingsService::get('site_favicon');
    $brandText = \App\Services\SettingsService::get('logo_text') ?: $brandName;
    $brandLetter = strtoupper(substr($brandText, 0, 1));
@endphp

@if ($siteFavicon)
    <img src="{{ Storage::url($siteFavicon) }}" alt="{{ $brandName }}"
        class="{{ $size }} shrink-0 {{ $rounded }} bg-white/5 object-contain">
@else
    <div class="{{ $size }} flex shrink-0 items-center justify-center {{ $rounded }} bg-gradient-to-br from-gold-400 to-gold-600 font-serif {{ $text }} font-bold text-navy-950 shadow-lg shadow-gold-500/20">
        {{ $brandLetter }}
    </div>
@endif