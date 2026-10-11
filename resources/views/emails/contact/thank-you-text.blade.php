Thanks for reaching out, {{ $contactMessage->name }}!

I've received your message and will get back to you as soon as possible — usually within 1-2 business days.

Subject: {{ $contactMessage->subject ?: 'General Inquiry' }}
Your message:
{{ $contactMessage->message }}

If your matter is urgent, feel free to call directly.

Warm regards,
{{ \App\Services\SettingsService::get('site_name', config('app.name')) }}
{{ \App\Services\SettingsService::get('contact_email') }}
{{ \App\Services\SettingsService::get('contact_phone') }}
