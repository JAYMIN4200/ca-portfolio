<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Experience;
use Illuminate\Http\Request;

class ExperienceController extends Controller
{
    public function index(Request $request)
    {
        $query = Experience::with('user')->ordered();

        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('role', 'like', "%{$search}%")
                    ->orWhere('firm_name', 'like', "%{$search}%")
                    ->orWhere('location', 'like', "%{$search}%");
            });
        }

        $experiences = $query->paginate(10)->withQueryString();

        if ($request->ajax()) {
            return response()->json([
                'html' => view('admin.experiences._table', ['experiences' => $experiences])->render(),
            ]);
        }

        return view('admin.experiences.index', [
            'title' => 'Experience',
            'experiences' => $experiences,
        ]);
    }

    public function create()
    {
        return view('admin.experiences.create', [
            'title' => 'Add Experience',
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'firm_name' => ['nullable', 'string', 'max:255'],
            'role' => ['required', 'string', 'max:255'],
            'location' => ['nullable', 'string', 'max:255'],
            'start_date' => ['required', 'date', 'before_or_equal:today'],
            'end_date' => ['nullable', 'date', 'after_or_equal:start_date'],
            'is_current' => ['nullable', 'boolean'],
            'description' => ['nullable', 'string', 'max:4000'],
            'responsibilities' => ['nullable', 'array'],
            'responsibilities.*' => ['nullable', 'string', 'max:500'],
            'skills_used' => ['nullable', 'array'],
            'skills_used.*' => ['nullable', 'string', 'max:100'],
            'display_order' => ['nullable', 'integer', 'min:0'],
            'is_active' => ['nullable', 'boolean'],
        ]);

        $isCurrent = $request->boolean('is_current', false);

        if ($isCurrent) {
            $validated['end_date'] = null;
            Experience::where('user_id', auth()->id())->where('is_current', true)->update(['is_current' => false]);
        }

        $validated['user_id'] = auth()->id();
        $validated['is_current'] = $isCurrent;
        $validated['is_active'] = $request->boolean('is_active', true);
        $validated['display_order'] = $validated['display_order'] ?? 0;
        $validated['responsibilities'] = array_values(array_filter($validated['responsibilities'] ?? [], fn ($r) => ! empty($r)));
        $validated['skills_used'] = array_values(array_filter($validated['skills_used'] ?? [], fn ($s) => ! empty($s)));

        Experience::create($validated);

        return redirect()
            ->route('admin.experiences.index')
            ->with('status', 'Experience added successfully.');
    }

    public function edit(Experience $experience)
    {
        return view('admin.experiences.edit', [
            'title' => 'Edit Experience',
            'experience' => $experience,
        ]);
    }

    public function update(Request $request, Experience $experience)
    {
        $validated = $request->validate([
            'firm_name' => ['nullable', 'string', 'max:255'],
            'role' => ['required', 'string', 'max:255'],
            'location' => ['nullable', 'string', 'max:255'],
            'start_date' => ['required', 'date', 'before_or_equal:today'],
            'end_date' => ['nullable', 'date', 'after_or_equal:start_date'],
            'is_current' => ['nullable', 'boolean'],
            'description' => ['nullable', 'string', 'max:4000'],
            'responsibilities' => ['nullable', 'array'],
            'responsibilities.*' => ['nullable', 'string', 'max:500'],
            'skills_used' => ['nullable', 'array'],
            'skills_used.*' => ['nullable', 'string', 'max:100'],
            'display_order' => ['nullable', 'integer', 'min:0'],
            'is_active' => ['nullable', 'boolean'],
        ]);

        $isCurrent = $request->boolean('is_current', false);

        if ($isCurrent) {
            $validated['end_date'] = null;
            Experience::where('user_id', auth()->id())
                ->where('id', '!=', $experience->id)
                ->where('is_current', true)
                ->update(['is_current' => false]);
        }

        $validated['is_current'] = $isCurrent;
        $validated['is_active'] = $request->boolean('is_active', true);
        $validated['display_order'] = $validated['display_order'] ?? 0;
        $validated['responsibilities'] = array_values(array_filter($validated['responsibilities'] ?? [], fn ($r) => ! empty($r)));
        $validated['skills_used'] = array_values(array_filter($validated['skills_used'] ?? [], fn ($s) => ! empty($s)));

        $experience->update($validated);

        return redirect()
            ->route('admin.experiences.index')
            ->with('status', 'Experience updated successfully.');
    }

    public function destroy(Experience $experience)
    {
        $experience->delete();

        return back()->with('status', 'Experience deleted successfully.');
    }

    public function toggle(Experience $experience)
    {
        $experience->update(['is_active' => ! $experience->is_active]);

        return back()->with('status', 'Experience status updated.');
    }
}
