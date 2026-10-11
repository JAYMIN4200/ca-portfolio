@php
    $isCancelled = $meeting->status === 'cancelled';
    $isConfirmed = $meeting->status === 'confirmed';
    $start = $meeting->start_time ? \Illuminate\Support\Str::of($meeting->start_time)->substr(0, 5) : null;
    $end = $meeting->end_time ? \Illuminate\Support\Str::of($meeting->end_time)->substr(0, 5) : null;
    $slot = $start ? $start->toString().($end ? ' - '.$end->toString() : '') : 'To be confirmed';
    $joinUrl = \Illuminate\Support\Str::startsWith((string) $meeting->location, ['http://', 'https://']) ? $meeting->location : null;
@endphp
@if ($isCancelled)
Your Meeting Has Been Cancelled
@elseif ($isConfirmed)
Your Meeting Is Confirmed
@else
Your Meeting Has Been Updated
@endif

Greeting {{ $meeting->name }},

@if ($isCancelled)
We're sorry, but the following meeting has been cancelled. If this was unexpected or you'd like to reschedule, simply reply to this email and we'll arrange a new time.
@elseif ($isConfirmed)
Great news - your meeting has been confirmed. The details are below. Please make a note of the date and time.
@else
The details of your meeting have been updated. Please review the latest information below.
@endif

Subject: {{ $meeting->title }}
Date: {{ $meeting->meeting_date->format('l, M d, Y') }}
Time: {{ $slot }}
Type: {{ $meeting->type_label }}
@if ($meeting->location)
{{ $joinUrl ? 'Join link' : 'Location' }}: {{ $meeting->location }}
@endif
Status: {{ $meeting->status_label }}
@if ($meeting->notes)

Notes: {{ $meeting->notes }}
@endif

Warm regards,
{{ \App\Services\SettingsService::get('site_name', config('app.name')) }}
{{ \App\Services\SettingsService::get('contact_email') }}
{{ \App\Services\SettingsService::get('contact_phone') }}
