@php
    $siteName = \App\Services\SettingsService::get('site_name', config('app.name'));
    $logoText = \App\Services\SettingsService::get('logo_text', 'JP');
    $favicon = \App\Services\SettingsService::get('site_favicon');
    $logoUrl = null;

    if ($favicon) {
        // Only render an <img> when the file truly exists and can be embedded
        // inline (CID), so a broken or missing image never reaches an inbox.
        // In every other case we fall back to the text badge below.
        $optimizedPath = \App\Services\BrandImageOptimizer::forEmail($favicon);

        if ($optimizedPath && isset($message) && method_exists($message, 'embed')) {
            $logoUrl = $message->embed($optimizedPath);
        }
    }

    $tagline = \App\Services\SettingsService::get('footer_text', 'Accounting, Audit & Taxation');
    $contactEmail = \App\Services\SettingsService::get('contact_email', config('mail.from.address'));
    $contactPhone = \App\Services\SettingsService::get('contact_phone');
    $contactLocation = \App\Services\SettingsService::get('contact_location');
@endphp
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="x-apple-disable-message-reformatting">
    <title>{{ $siteName }}</title>
</head>
<body style="margin:0;padding:0;background-color:#f1f5f9;font-family:'Segoe UI',Roboto,Helvetica,Arial,sans-serif;color:#334155;">
    <div style="display:none;font-size:1px;line-height:1px;max-height:0;max-width:0;opacity:0;overflow:hidden;">@yield('preheader')</div>

    <table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="background-color:#f1f5f9;">
        <tr>
            <td align="center" style="padding:28px 12px;">
                <table role="presentation" width="600" cellpadding="0" cellspacing="0" style="width:100%;max-width:600px;background-color:#ffffff;border:1px solid #e2e8f0;border-radius:14px;overflow:hidden;">

                    <tr>
                        <td style="background-color:#14263d;padding:26px 32px;">
                            <table role="presentation" width="100%" cellpadding="0" cellspacing="0">
                                <tr>
                                    <td width="56" style="vertical-align:middle;">
                                        @if ($logoUrl)
                                            <img src="{{ $logoUrl }}" alt="{{ $siteName }}" width="44" height="44" style="display:block;width:44px;height:44px;border:0;border-radius:10px;object-fit:cover;">
                                        @else
                                            <span style="display:inline-block;width:44px;height:44px;line-height:44px;text-align:center;background-color:#c9a84c;border-radius:10px;color:#14263d;font-weight:700;font-size:18px;font-family:Georgia,'Times New Roman',serif;">{{ $logoText }}</span>
                                        @endif
                                    </td>
                                    <td style="vertical-align:middle;">
                                        <div style="color:#ffffff;font-size:17px;font-weight:600;line-height:1.3;">{{ $siteName }}</div>
                                        <div style="color:#c9a84c;font-size:11px;letter-spacing:1.5px;text-transform:uppercase;margin-top:2px;">{{ $tagline }}</div>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    <tr>
                        <td style="height:4px;line-height:4px;font-size:0;background-color:#c9a84c;">&nbsp;</td>
                    </tr>

                    <tr>
                        <td style="padding:32px;">
                            @yield('content')
                        </td>
                    </tr>

                    <tr>
                        <td style="background-color:#f8fafc;border-top:1px solid #e2e8f0;padding:22px 32px;">
                            <p style="margin:0 0 6px;font-size:12px;font-weight:600;letter-spacing:1px;text-transform:uppercase;color:#94a3b8;">Get in touch</p>
                            @if ($contactEmail)
                                <p style="margin:0 0 3px;font-size:13px;color:#64748b;">Email: <a href="mailto:{{ $contactEmail }}" style="color:#6d28d9;text-decoration:none;">{{ $contactEmail }}</a></p>
                            @endif
                            @if ($contactPhone)
                                <p style="margin:0 0 3px;font-size:13px;color:#64748b;">Phone: {{ $contactPhone }}</p>
                            @endif
                            @if ($contactLocation)
                                <p style="margin:0 0 3px;font-size:13px;color:#64748b;">{{ $contactLocation }}</p>
                            @endif
                            <p style="margin:14px 0 0;font-size:12px;color:#94a3b8;">&copy; {{ now()->year }} {{ $siteName }}. All rights reserved.</p>
                        </td>
                    </tr>

                </table>
            </td>
        </tr>
    </table>
</body>
</html>
