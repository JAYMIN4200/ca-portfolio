@extends('emails.layout')

@section('preheader', 'New inquiry from '.$contactMessage->name)

@section('content')
    <h1 style="margin:0 0 6px;font-size:22px;line-height:1.3;color:#0f172a;">New Website Inquiry</h1>
    <p style="margin:0 0 20px;font-size:15px;line-height:1.65;color:#475569;">
        A new message has been submitted through the contact form on your website.
    </p>

    <table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="margin:0 0 22px;border:1px solid #e2e8f0;border-radius:10px;border-collapse:separate;">
        <tr>
            <td width="34%" style="padding:11px 14px;background-color:#f8fafc;border-bottom:1px solid #e2e8f0;font-size:11px;font-weight:600;letter-spacing:.8px;text-transform:uppercase;color:#94a3b8;border-top-left-radius:10px;">Name</td>
            <td style="padding:11px 14px;border-bottom:1px solid #e2e8f0;font-size:14px;color:#1e293b;">{{ $contactMessage->name }}</td>
        </tr>
        <tr>
            <td style="padding:11px 14px;background-color:#f8fafc;border-bottom:1px solid #e2e8f0;font-size:11px;font-weight:600;letter-spacing:.8px;text-transform:uppercase;color:#94a3b8;">Email</td>
            <td style="padding:11px 14px;border-bottom:1px solid #e2e8f0;font-size:14px;"><a href="mailto:{{ $contactMessage->email }}" style="color:#6d28d9;text-decoration:none;">{{ $contactMessage->email }}</a></td>
        </tr>
        <tr>
            <td style="padding:11px 14px;background-color:#f8fafc;border-bottom:1px solid #e2e8f0;font-size:11px;font-weight:600;letter-spacing:.8px;text-transform:uppercase;color:#94a3b8;">Phone</td>
            <td style="padding:11px 14px;border-bottom:1px solid #e2e8f0;font-size:14px;color:#1e293b;">{{ $contactMessage->phone ?: '—' }}</td>
        </tr>
        <tr>
            <td style="padding:11px 14px;background-color:#f8fafc;border-bottom:1px solid #e2e8f0;font-size:11px;font-weight:600;letter-spacing:.8px;text-transform:uppercase;color:#94a3b8;">Subject</td>
            <td style="padding:11px 14px;border-bottom:1px solid #e2e8f0;font-size:14px;color:#1e293b;">{{ $contactMessage->subject ?: 'General Inquiry' }}</td>
        </tr>
        <tr>
            <td style="padding:11px 14px;background-color:#f8fafc;border-bottom:1px solid #e2e8f0;font-size:11px;font-weight:600;letter-spacing:.8px;text-transform:uppercase;color:#94a3b8;">Received</td>
            <td style="padding:11px 14px;border-bottom:1px solid #e2e8f0;font-size:14px;color:#1e293b;">{{ $contactMessage->created_at->format('M d, Y \a\t h:i A') }}</td>
        </tr>
        <tr>
            <td style="padding:11px 14px;background-color:#f8fafc;font-size:11px;font-weight:600;letter-spacing:.8px;text-transform:uppercase;color:#94a3b8;vertical-align:top;border-bottom-left-radius:10px;">Message</td>
            <td style="padding:11px 14px;font-size:14px;line-height:1.6;color:#1e293b;border-bottom-right-radius:10px;">{!! nl2br(e($contactMessage->message)) !!}</td>
        </tr>
    </table>

    <table role="presentation" cellpadding="0" cellspacing="0">
        <tr>
            <td style="background-color:#7c3aed;border-radius:8px;">
                <a href="mailto:{{ $contactMessage->email }}?subject={{ rawurlencode('Re: '.($contactMessage->subject ?: 'Your Inquiry')) }}" style="display:inline-block;padding:12px 24px;font-size:14px;font-weight:600;color:#ffffff;text-decoration:none;">Reply to {{ $contactMessage->name }}</a>
            </td>
        </tr>
    </table>

    <p style="margin:22px 0 0;font-size:13px;line-height:1.6;color:#94a3b8;">
        Manage all inquiries from the admin panel under <strong>Messages</strong>.
    </p>
@endsection
