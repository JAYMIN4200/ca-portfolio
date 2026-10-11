@php
    $siteName = \App\Services\SettingsService::get('site_name', config('app.name'));
    $contactEmail = \App\Services\SettingsService::get('contact_email', config('mail.from.address'));
@endphp
New reply from {{ $siteName }}

Hi {{ $contactMessage->name }}, you've received a reply regarding "{{ $contactMessage->subject ?: 'your inquiry' }}".

{{ $reply->body }}

--- Your original message ---
{{ \Illuminate\Support\Str::limit($contactMessage->message, 500) }}
---

You can simply reply to this email to continue the conversation.

Best regards,
{{ $siteName }}
{{ $contactEmail }}
