@extends('emails.layout')

@section('preheader', 'We received your meeting request — confirmation coming soon.')

@section('content')
    @php
        $start = $meeting->start_time ? \Illuminate\Support\Str::of($meeting->start_time)->substr(0, 5) : null;
    @endphp

    <h1 style="margin:0 0 14px;font-size:22px;line-height:1.3;color:#0f172a;">Thanks, {{ $meeting->name }}!</h1>

    <p style="margin:0 0 16px;font-size:15px;line-height:1.65;color:#475569;">
        We've received your meeting request and it's now awaiting confirmation.
        We'll review the requested slot and get back to you shortly with the confirmed details.
    </p>

    <table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="margin:0 0 20px;border:1px solid #e2e8f0;border-radius:10px;border-collapse:separate;">
        <tr>
            <td width="34%" style="padding:11px 14px;background-color:#f8fafc;border-bottom:1px solid #e2e8f0;font-size:11px;font-weight:600;letter-spacing:.8px;text-transform:uppercase;color:#94a3b8;border-top-left-radius:10px;">Subject</td>
            <td style="padding:11px 14px;border-bottom:1px solid #e2e8f0;font-size:14px;color:#1e293b;">{{ $meeting->title }}</td>
        </tr>
        <tr>
            <td style="padding:11px 14px;background-color:#f8fafc;border-bottom:1px solid #e2e8f0;font-size:11px;font-weight:600;letter-spacing:.8px;text-transform:uppercase;color:#94a3b8;">Requested date</td>
            <td style="padding:11px 14px;border-bottom:1px solid #e2e8f0;font-size:14px;color:#1e293b;">{{ $meeting->meeting_date->format('D, M d, Y') }}</td>
        </tr>
        <tr>
            <td style="padding:11px 14px;background-color:#f8fafc;border-bottom:1px solid #e2e8f0;font-size:11px;font-weight:600;letter-spacing:.8px;text-transform:uppercase;color:#94a3b8;">Requested time</td>
            <td style="padding:11px 14px;border-bottom:1px solid #e2e8f0;font-size:14px;color:#1e293b;">{{ $start ? $start->toString() : 'Flexible' }}</td>
        </tr>
        <tr>
            <td style="padding:11px 14px;background-color:#f8fafc;font-size:11px;font-weight:600;letter-spacing:.8px;text-transform:uppercase;color:#94a3b8;border-bottom-left-radius:10px;">Type</td>
            <td style="padding:11px 14px;font-size:14px;color:#1e293b;border-bottom-right-radius:10px;">{{ $meeting->type_label }}</td>
        </tr>
    </table>

    <p style="margin:0;font-size:15px;line-height:1.65;color:#475569;">
        No action is needed from your side right now. We'll send you the confirmed date, time and joining details by email.
    </p>

    <p style="margin:22px 0 0;font-size:15px;line-height:1.65;color:#475569;">
        Warm regards,<br>
        <strong style="color:#14263d;">{{ \App\Services\SettingsService::get('site_name', config('app.name')) }}</strong>
    </p>
@endsection
