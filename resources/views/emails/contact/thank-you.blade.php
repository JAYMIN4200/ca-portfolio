@extends('emails.layout')

@section('preheader', 'Thanks for your message — I will be in touch shortly.')

@section('content')
    <h1 style="margin:0 0 14px;font-size:22px;line-height:1.3;color:#0f172a;">Thank you, {{ $contactMessage->name }}!</h1>

    <p style="margin:0 0 16px;font-size:15px;line-height:1.65;color:#475569;">
        I've received your message and truly appreciate you taking the time to reach out.
        I'll review your inquiry and get back to you as soon as possible — usually within 1&ndash;2 business days.
    </p>

    <table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="margin:0 0 20px;border:1px solid #e2e8f0;border-radius:10px;border-collapse:separate;">
        <tr>
            <td width="34%" style="padding:11px 14px;background-color:#f8fafc;border-bottom:1px solid #e2e8f0;font-size:11px;font-weight:600;letter-spacing:.8px;text-transform:uppercase;color:#94a3b8;border-top-left-radius:10px;">Subject</td>
            <td style="padding:11px 14px;border-bottom:1px solid #e2e8f0;font-size:14px;color:#1e293b;">{{ $contactMessage->subject ?: 'General Inquiry' }}</td>
        </tr>
        <tr>
            <td width="34%" style="padding:11px 14px;background-color:#f8fafc;font-size:11px;font-weight:600;letter-spacing:.8px;text-transform:uppercase;color:#94a3b8;border-bottom-left-radius:10px;">Your message</td>
            <td style="padding:11px 14px;font-size:14px;color:#1e293b;border-bottom-right-radius:10px;">{{ $contactMessage->message }}</td>
        </tr>
    </table>

    <p style="margin:0 0 6px;font-size:15px;line-height:1.65;color:#475569;">
        If your matter is urgent, feel free to call directly — otherwise I'll be in touch by email soon.
    </p>

    <p style="margin:22px 0 0;font-size:15px;line-height:1.65;color:#475569;">
        Warm regards,<br>
        <strong style="color:#14263d;">{{ \App\Services\SettingsService::get('site_name', config('app.name')) }}</strong>
    </p>
@endsection
