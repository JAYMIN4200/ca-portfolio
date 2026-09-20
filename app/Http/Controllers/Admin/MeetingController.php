<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Client;
use App\Models\Meeting;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class MeetingController extends Controller
{
    public function index(Request $request)
    {
        $query = Meeting::query()->with('client')->ordered();

        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('title', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%");
            });
        }

        if ($request->filled('status')) {
            $query->where('status', $request->input('status'));
        }

        if ($request->filled('month')) {
            $query->whereMonth('meeting_date', $request->integer('month'));
        }

        if ($request->filled('year')) {
            $query->whereYear('meeting_date', $request->integer('year'));
        }

        $meetings = $query->paginate(10)->withQueryString();

        if ($request->ajax()) {
            return response()->json([
                'html' => view('admin.meetings._table', [
                    'meetings' => $meetings,
                    'statuses' => Meeting::STATUSES,
                ])->render(),
            ]);
        }

        return view('admin.meetings.index', [
            'title' => 'Meetings',
            'meetings' => $meetings,
            'clients' => Client::ordered()->get(),
            'statuses' => Meeting::STATUSES,
            'types' => Meeting::TYPES,
            'filters' => $request->only(['search', 'status', 'month', 'year']),
        ]);
    }

    public function create(Request $request)
    {
        return view('admin.meetings.create', [
            'title' => 'Schedule Meeting',
            'clients' => Client::ordered()->get(),
            'statuses' => Meeting::STATUSES,
            'types' => Meeting::TYPES,
            'selectedDate' => $request->query('date'),
            'selectedClient' => $request->integer('client_id') ?: null,
        ]);
    }

    public function store(Request $request)
    {
        Meeting::create($this->validateMeeting($request));

        return redirect()
            ->route('admin.meetings.index')
            ->with('status', 'Meeting scheduled successfully.');
    }

    public function edit(Meeting $meeting)
    {
        return view('admin.meetings.edit', [
            'title' => 'Edit Meeting',
            'meeting' => $meeting,
            'clients' => Client::ordered()->get(),
            'statuses' => Meeting::STATUSES,
            'types' => Meeting::TYPES,
        ]);
    }

    public function update(Request $request, Meeting $meeting)
    {
        $meeting->update($this->validateMeeting($request));

        return redirect()
            ->route('admin.meetings.index')
            ->with('status', 'Meeting updated successfully.');
    }

    public function destroy(Meeting $meeting)
    {
        $meeting->delete();

        return back()->with('status', 'Meeting deleted successfully.');
    }

    public function updateStatus(Request $request, Meeting $meeting)
    {
        $validated = $request->validate([
            'status' => ['required', Rule::in(array_keys(Meeting::STATUSES))],
        ]);

        $meeting->update($validated);

        return back()->with('status', 'Meeting status updated.');
    }

    /**
     * @return array<string, mixed>
     */
    private function validateMeeting(Request $request): array
    {
        return $request->validate([
            'client_id' => ['nullable', 'exists:clients,id'],
            'name' => ['required', 'string', 'max:255'],
            'email' => ['nullable', 'email', 'max:255'],
            'phone' => ['nullable', 'max:25', 'regex:/^\+?(?:[()\-\s]*\d){7,15}[()\-\s]*$/'],
            'title' => ['required', 'string', 'max:255'],
            'meeting_date' => ['required', 'date'],
            'start_time' => ['nullable', 'date_format:H:i'],
            'end_time' => ['nullable', 'date_format:H:i', 'after:start_time'],
            'type' => ['required', Rule::in(array_keys(Meeting::TYPES))],
            'location' => ['nullable', 'string', 'max:255'],
            'status' => ['required', Rule::in(array_keys(Meeting::STATUSES))],
            'notes' => ['nullable', 'string', 'max:4000'],
        ]);
    }
}
