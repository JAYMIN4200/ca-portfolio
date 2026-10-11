@extends('emails.layout')

@section('preheader', 'Reset your password — this secure link expires soon.')

@section('content')
    <h1 style="margin:0 0 14px;font-size:22px;line-height:1.3;color:#0f172a;">Reset your password</h1>

    <p style="margin:0 0 16px;font-size:15px;line-height:1.65;color:#475569;">
        Hi {{ $userName }}, we received a request to reset the password for your admin account.
        Click the button below to choose a new password.
    </p>

    <table role="presentation" cellpadding="0" cellspacing="0" style="margin:0 0 22px;">
        <tr>
            <td style="background-color:#7c3aed;border-radius:8px;">
                <a href="{{ $url }}" style="display:inline-block;padding:13px 28px;font-size:14px;font-weight:600;color:#ffffff;text-decoration:none;">Reset Password</a>
            </td>
        </tr>
    </table>

    <p style="margin:0 0 16px;font-size:14px;line-height:1.65;color:#475569;">
        This password reset link will expire in <strong style="color:#0f172a;">{{ $expireMinutes }} minutes</strong>.
    </p>

    <p style="margin:0 0 8px;font-size:12px;font-weight:600;letter-spacing:1px;text-transform:uppercase;color:#94a3b8;">Button not working?</p>
    <table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="margin:0 0 22px;border:1px solid #e2e8f0;border-radius:10px;border-collapse:separate;">
        <tr>
            <td style="padding:12px 16px;font-size:13px;line-height:1.6;color:#6d28d9;word-break:break-all;">
                <a href="{{ $url }}" style="color:#6d28d9;text-decoration:none;">{{ $url }}</a>
            </td>
        </tr>
    </table>

    <p style="margin:0;font-size:13px;line-height:1.65;color:#94a3b8;">
        If you did not request a password reset, no further action is required — your password will remain unchanged.
    </p>
@endsection
