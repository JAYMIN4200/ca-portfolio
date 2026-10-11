@extends('emails.layout')

@section('preheader', 'New meeting request from '.$meeting->name)

@section('content')
    @php
        $start = $meeting->start_time ? \Illuminate\Support\Str::of($meeting->start_time)->substr(0, 5) : null;
        $end = $meeting->end_time ? \Illuminate\Support\Str::of($meeting->end_time)->substr(0, 5) : null;
        $slot = $start ? $start->toString().($end ? ' – '.$end->toString() : '') : 'Not specified';
    @endphp

    <h1 style="margin:0 0 6px;font-size:22px;line-height:1.3;color:#0f172a;">New Meeting Request</h1>
    <p style="margin:0 0 20px;font-size:15px;line-height:1.65;color:#475569;">
        A visitor has requested a meeting through your website.
    </p>

    <table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="margin:0 0 22px;border:1px solid #e2e8f0;border-radius:10px;border-collapse:separate;">
        <tr>
            <td width="34%" style="padding:11px 14px;background-color:#f8fafc;border-bottom:1px solid #e2e8f0;font-size:11px;font-weight:600;letter-spacing:.8px;text-transform:uppercase;color:#94a3b8;border-top-left-radius:10px;">Name</td>
            <td style="padding:11px 14px;border-bottom:1px solid #e2e8f0;font-size:14px;color:#1e293b;">{{ $meeting->name }}</td>
        </tr>
        <tr>
            <td style="padding:11px 14px;background-color:#f8fafc;border-bottom:1px solid #e2e8f0;font-size:11px;font-weight:600;letter-spacing:.8px;text-transform:uppercase;color:#94a3b8;">Email</td>
            <td style="padding:11px 14px;border-bottom:1px solid #e2e8f0;font-size:14px;"><a href="mailto:{{ $meeting->email }}" style="color:#6d28d9;text-decoration:none;">{{ $meeting->email ?: '—' }}</a></td>
        </tr>
        <tr>
            <td style="padding:11px 14px;background-color:#f8fafc;border-bottom:1px solid #e2e8f0;font-size:11px;font-weight:600;letter-spacing:.8px;text-transform:uppercase;color:#94a3b8;">Phone</td>
            <td style="padding:11px 14px;border-bottom:1px solid #e2e8f0;font-size:14px;color:#1e293b;">{{ $meeting->phone ?: '—' }}</td>
        </tr>
        <tr>
            <td style="padding:11px 14px;background-color:#f8fafc;border-bottom:1px solid #e2e8f0;font-size:11px;font-weight:600;letter-spacing:.8px;text-transform:uppercase;color:#94a3b8;">Subject</td>
            <td style="padding:11px 14px;border-bottom:1px solid #e2e8f0;font-size:14px;color:#1e293b;">{{ $meeting->title }}</td>
        </tr>
        <tr>
            <td style="padding:11px 14px;background-color:#f8fafc;border-bottom:1px solid #e2e8f0;font-size:11px;font-weight:600;letter-spacing:.8px;text-transform:uppercase;color:#94a3b8;">Date</td>
            <td style="padding:11px 14px;border-bottom:1px solid #e2e8f0;font-size:14px;color:#1e293b;">{{ $meeting->meeting_date->format('D, M d, Y') }}</td>
        </tr>
        <tr>
            <td style="padding:11px 14px;background-color:#f8fafc;border-bottom:1px solid #e2e8f0;font-size:11px;font-weight:600;letter-spacing:.8px;text-transform:uppercase;color:#94a3b8;">Time</td>
            <td style="padding:11px 14px;border-bottom:1px solid #e2e8f0;font-size:14px;color:#1e293b;">{{ $slot }}</td>
        </tr>
        <tr>
            <td style="padding:11px 14px;background-color:#f8fafc;{{ $meeting->notes ? 'border-bottom:1px solid #e2e8f0;' : '' }}font-size:11px;font-weight:600;letter-spacing:.8px;text-transform:uppercase;color:#94a3b8;{{ $meeting->notes ? '' : 'border-bottom-left-radius:10px;' }}">Type</td>
            <td style="padding:11px 14px;{{ $meeting->notes ? 'border-bottom:1px solid #e2e8f0;' : '' }}font-size:14px;color:#1e293b;{{ $meeting->notes ? '' : 'border-bottom-right-radius:10px;' }}">{{ $meeting->type_label }}</td>
        </tr>
        @if ($meeting->notes)
            <tr>
                <td style="padding:11px 14px;background-color:#f8fafc;font-size:11px;font-weight:600;letter-spacing:.8px;text-transform:uppercase;color:#94a3b8;vertical-align:top;border-bottom-left-radius:10px;">Notes</td>
                <td style="padding:11px 14px;font-size:14px;line-height:1.6;color:#1e293b;border-bottom-right-radius:10px;">{!! nl2br(e($meeting->notes)) !!}</td>
            </tr>
        @endif
    </table>

    <table role="presentation" cellpadding="0" cellspacing="0">
        <tr>
            <td style="background-color:#7c3aed;border-radius:8px;">
                <a href="{{ route('admin.meetings.index') }}" style="display:inline-block;padding:12px 24px;font-size:14px;font-weight:600;color:#ffffff;text-decoration:none;">Open in Admin Panel</a>
            </td>
        </tr>
    </table>

    <p style="margin:22px 0 0;font-size:13px;line-height:1.6;color:#94a3b8;">
        Confirm the date and time from the admin panel — the client will be notified automatically.
    </p>
@endsection
