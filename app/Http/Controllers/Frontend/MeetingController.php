<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Meeting;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class MeetingController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255'],
            'phone' => ['nullable', 'max:25', 'regex:/^\+?(?:[()\-\s]*\d){7,15}[()\-\s]*$/'],
            'title' => ['required', 'string', 'max:255'],
            'meeting_date' => ['required', 'date', 'after_or_equal:today'],
            'start_time' => ['nullable', 'date_format:H:i'],
            'type' => ['required', Rule::in(array_keys(Meeting::TYPES))],
            'notes' => ['nullable', 'string', 'max:2000'],
        ]);

        $validated['user_id'] = User::where('is_admin', true)->value('id');
        $validated['status'] = 'pending';

        Meeting::create($validated);

        return redirect()
            ->route('contact')
            ->with('status', 'Your meeting request has been sent. We will confirm shortly.');
    }
}
