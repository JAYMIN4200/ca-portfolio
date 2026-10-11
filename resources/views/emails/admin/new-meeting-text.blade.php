@php
    $start = $meeting->start_time ? \Illuminate\Support\Str::of($meeting->start_time)->substr(0, 5) : null;
    $end = $meeting->end_time ? \Illuminate\Support\Str::of($meeting->end_time)->substr(0, 5) : null;
    $slot = $start ? $start->toString().($end ? ' - '.$end->toString() : '') : 'Not specified';
@endphp
New Meeting Request

A visitor has requested a meeting through your website.

Name: {{ $meeting->name }}
Email: {{ $meeting->email ?: '-' }}
Phone: {{ $meeting->phone ?: '-' }}
Subject: {{ $meeting->title }}
Date: {{ $meeting->meeting_date->format('D, M d, Y') }}
Time: {{ $slot }}
Type: {{ $meeting->type_label }}
@if ($meeting->notes)

Notes:
{{ $meeting->notes }}
@endif

Open the admin panel to confirm the meeting:
{{ route('admin.meetings.index') }}

The client will be notified automatically once you confirm.
