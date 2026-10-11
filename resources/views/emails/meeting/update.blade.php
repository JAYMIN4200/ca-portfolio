@extends('emails.layout')

@php
    $isCancelled = $meeting->status === 'cancelled';
    $isConfirmed = $meeting->status === 'confirmed';
    $start = $meeting->start_time ? \Illuminate\Support\Str::of($meeting->start_time)->substr(0, 5) : null;
    $end = $meeting->end_time ? \Illuminate\Support\Str::of($meeting->end_time)->substr(0, 5) : null;
    $slot = $start ? $start->toString().($end ? ' – '.$end->toString() : '') : 'To be confirmed';
    $joinUrl = \Illuminate\Support\Str::startsWith((string) $meeting->location, ['http://', 'https://']) ? $meeting->location : null;
@endphp

@section('preheader', $isCancelled ? 'Your meeting has been cancelled.' : 'Your meeting details are confirmed.')

@section('content')
    @if ($isCancelled)
        <h1 style="margin:0 0 14px;font-size:22px;line-height:1.3;color:#b91c1c;">Your meeting has been cancelled</h1>
        <p style="margin:0 0 20px;font-size:15px;line-height:1.65;color:#475569;">
            We're sorry, but the following meeting has been cancelled. If this was unexpected or you'd like to reschedule,
            simply reply to this email and we'll arrange a new time.
        </p>
    @elseif ($isConfirmed)
        <h1 style="margin:0 0 14px;font-size:22px;line-height:1.3;color:#15803d;">Your meeting is confirmed</h1>
        <p style="margin:0 0 20px;font-size:15px;line-height:1.65;color:#475569;">
            Great news — your meeting has been confirmed. The details are below. Please make a note of the date and time.
        </p>
    @else
        <h1 style="margin:0 0 14px;font-size:22px;line-height:1.3;color:#0f172a;">Your meeting has been updated</h1>
        <p style="margin:0 0 20px;font-size:15px;line-height:1.65;color:#475569;">
            The details of your meeting have been updated. Please review the latest information below.
        </p>
    @endif

    <table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="margin:0 0 22px;border:1px solid #e2e8f0;border-radius:10px;border-collapse:separate;">
        <tr>
            <td width="34%" style="padding:11px 14px;background-color:#f8fafc;border-bottom:1px solid #e2e8f0;font-size:11px;font-weight:600;letter-spacing:.8px;text-transform:uppercase;color:#94a3b8;border-top-left-radius:10px;">Subject</td>
            <td style="padding:11px 14px;border-bottom:1px solid #e2e8f0;font-size:14px;color:#1e293b;">{{ $meeting->title }}</td>
        </tr>
        <tr>
            <td style="padding:11px 14px;background-color:#f8fafc;border-bottom:1px solid #e2e8f0;font-size:11px;font-weight:600;letter-spacing:.8px;text-transform:uppercase;color:#94a3b8;">Date</td>
            <td style="padding:11px 14px;border-bottom:1px solid #e2e8f0;font-size:14px;color:#1e293b;">{{ $meeting->meeting_date->format('l, M d, Y') }}</td>
        </tr>
        <tr>
            <td style="padding:11px 14px;background-color:#f8fafc;border-bottom:1px solid #e2e8f0;font-size:11px;font-weight:600;letter-spacing:.8px;text-transform:uppercase;color:#94a3b8;">Time</td>
            <td style="padding:11px 14px;border-bottom:1px solid #e2e8f0;font-size:14px;color:#1e293b;">{{ $slot }}</td>
        </tr>
        <tr>
            <td style="padding:11px 14px;background-color:#f8fafc;border-bottom:1px solid #e2e8f0;font-size:11px;font-weight:600;letter-spacing:.8px;text-transform:uppercase;color:#94a3b8;">Type</td>
            <td style="padding:11px 14px;border-bottom:1px solid #e2e8f0;font-size:14px;color:#1e293b;">{{ $meeting->type_label }}</td>
        </tr>
        @if ($meeting->location)
            <tr>
                <td style="padding:11px 14px;background-color:#f8fafc;border-bottom:1px solid #e2e8f0;font-size:11px;font-weight:600;letter-spacing:.8px;text-transform:uppercase;color:#94a3b8;{{ $meeting->notes ? '' : 'border-bottom-left-radius:10px;' }}">{{ $joinUrl ? 'Join link' : 'Location' }}</td>
                <td style="padding:11px 14px;border-bottom:1px solid #e2e8f0;font-size:14px;color:#1e293b;{{ $meeting->notes ? '' : 'border-bottom-right-radius:10px;' }}">
                    @if ($joinUrl)
                        <a href="{{ $joinUrl }}" style="color:#6d28d9;text-decoration:none;word-break:break-all;">{{ $joinUrl }}</a>
                    @else
                        {{ $meeting->location }}
                    @endif
                </td>
            </tr>
        @endif
        <tr>
            <td style="padding:11px 14px;background-color:#f8fafc;font-size:11px;font-weight:600;letter-spacing:.8px;text-transform:uppercase;color:#94a3b8;vertical-align:top;border-bottom-left-radius:10px;">Status</td>
            <td style="padding:11px 14px;font-size:14px;font-weight:600;color:{{ $isCancelled ? '#b91c1c' : ($isConfirmed ? '#15803d' : '#6d28d9') }};border-bottom-right-radius:10px;">{{ $meeting->status_label }}</td>
        </tr>
    </table>

    @if ($joinUrl && ! $isCancelled)
        <table role="presentation" cellpadding="0" cellspacing="0">
            <tr>
                <td style="background-color:#7c3aed;border-radius:8px;">
                    <a href="{{ $joinUrl }}" style="display:inline-block;padding:12px 24px;font-size:14px;font-weight:600;color:#ffffff;text-decoration:none;">Join Meeting</a>
                </td>
            </tr>
        </table>
    @endif

    @if ($meeting->notes)
        <p style="margin:22px 0 0;font-size:15px;line-height:1.65;color:#475569;">
            <strong style="color:#0f172a;">Notes:</strong> {!! nl2br(e($meeting->notes)) !!}
        </p>
    @endif

    <p style="margin:22px 0 0;font-size:15px;line-height:1.65;color:#475569;">
        Warm regards,<br>
        <strong style="color:#14263d;">{{ \App\Services\SettingsService::get('site_name', config('app.name')) }}</strong>
    </p>
@endsection
