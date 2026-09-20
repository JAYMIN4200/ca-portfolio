<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\ContactMessage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;

class ContactController extends Controller
{
    public function index()
    {
        return view('frontend.contact');
    }

    public function store(Request $request)
    {
        $this->ensureNotRateLimited($request);

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255'],
            'phone' => ['required', 'max:25', 'regex:/^\+?(?:[()\-\s]*\d){7,15}[()\-\s]*$/'],
            'subject' => ['required', 'string', 'max:255'],
            'subject_other' => ['nullable', 'required_if:subject,Other', 'string', 'max:255'],
            'message' => ['required', 'string', 'min:10', 'max:5000'],
        ]);

        if ($validated['subject'] === 'Other') {
            $validated['subject'] = $validated['subject_other'];
        }

        unset($validated['subject_other']);

        ContactMessage::create($validated);

        return back()->with('status', 'Your message has been sent successfully. I will get back to you soon.');
    }

    protected function ensureNotRateLimited(Request $request): void
    {
        $key = 'contact:'.($request->ip() ?? 'unknown');
        $executed = RateLimiter::attempt($key, 3, fn () => true, 60);

        if (! $executed) {
            abort(429, 'Too many messages. Please try again later.');
        }
    }
}
