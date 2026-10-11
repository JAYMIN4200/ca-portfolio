@extends('emails.layout')

@section('preheader', 'A new reply to your inquiry from '.\App\Services\SettingsService::get('site_name', config('app.name')))

@section('content')
    @php
        $siteName = \App\Services\SettingsService::get('site_name', config('app.name'));
        $contactEmail = \App\Services\SettingsService::get('contact_email', config('mail.from.address'));
    @endphp

    <h1 style="margin:0 0 6px;font-size:22px;line-height:1.3;color:#0f172a;">New reply from {{ $siteName }}</h1>
    <p style="margin:0 0 20px;font-size:15px;line-height:1.65;color:#475569;">
        Hi {{ $contactMessage->name }}, you've received a reply regarding
        &ldquo;{{ $contactMessage->subject ?: 'your inquiry' }}&rdquo;.
    </p>

    <table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="margin:0 0 22px;">
        <tr>
            <td style="background-color:#f8fafc;border-left:4px solid #7c3aed;border-radius:6px;padding:18px 20px;font-size:15px;line-height:1.7;color:#1e293b;">
                {!! nl2br(e($reply->body)) !!}
            </td>
        </tr>
    </table>

    <p style="margin:0 0 10px;font-size:12px;font-weight:600;letter-spacing:1px;text-transform:uppercase;color:#94a3b8;">Your original message</p>
    <table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="margin:0 0 22px;border:1px solid #e2e8f0;border-radius:10px;border-collapse:separate;">
        <tr>
            <td style="padding:14px 16px;font-size:14px;line-height:1.65;color:#64748b;">
                {{ \Illuminate\Support\Str::limit($contactMessage->message, 500) }}
            </td>
        </tr>
    </table>

    <p style="margin:0 0 20px;font-size:15px;line-height:1.65;color:#475569;">
        You can simply reply to this email to continue the conversation.
    </p>

    @if ($contactEmail)
        <table role="presentation" cellpadding="0" cellspacing="0">
            <tr>
                <td style="background-color:#7c3aed;border-radius:8px;">
                    <a href="mailto:{{ $contactEmail }}?subject={{ rawurlencode('Re: '.($contactMessage->subject ?: 'Your Inquiry')) }}" style="display:inline-block;padding:12px 24px;font-size:14px;font-weight:600;color:#ffffff;text-decoration:none;">Reply by Email</a>
                </td>
            </tr>
        </table>
    @endif

    <p style="margin:22px 0 0;font-size:15px;line-height:1.65;color:#475569;">
        Best regards,<br>
        <strong style="color:#14263d;">{{ $siteName }}</strong>
    </p>
@endsection
