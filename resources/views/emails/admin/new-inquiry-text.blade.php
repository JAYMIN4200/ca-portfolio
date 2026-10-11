New Website Inquiry

A new message has been submitted through the contact form on your website.

Name: {{ $contactMessage->name }}
Email: {{ $contactMessage->email }}
Phone: {{ $contactMessage->phone ?: '-' }}
Subject: {{ $contactMessage->subject ?: 'General Inquiry' }}
Received: {{ $contactMessage->created_at->format('M d, Y h:i A') }}

Message:
{{ $contactMessage->message }}

Reply directly to: {{ $contactMessage->email }}
Manage all inquiries from the admin panel under Messages.
