@php
    $start = $meeting->start_time ? \Illuminate\Support\Str::of($meeting->start_time)->substr(0, 5) : null;
@endphp
Thanks for your meeting request, {{ $meeting->name }}!

We've received your request and it's now awaiting confirmation. We'll review the requested slot and get back to you shortly with the confirmed details.

Subject: {{ $meeting->title }}
Requested date: {{ $meeting->meeting_date->format('D, M d, Y') }}
Requested time: {{ $start ? $start->toString() : 'Flexible' }}
Type: {{ $meeting->type_label }}

No action is needed from your side right now. We'll email you the confirmed date, time and joining details.

Warm regards,
{{ \App\Services\SettingsService::get('site_name', config('app.name')) }}
{{ \App\Services\SettingsService::get('contact_email') }}
{{ \App\Services\SettingsService::get('contact_phone') }}
