<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Qualification;
use Illuminate\Http\Request;

class QualificationController extends Controller
{
    public function index(Request $request)
    {
        $query = Qualification::with('user')->ordered();

        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('institution', 'like', "%{$search}%");
            });
        }

        $qualifications = $query->paginate(10)->withQueryString();

        if ($request->ajax()) {
            return response()->json([
                'html' => view('admin.qualifications._table', ['qualifications' => $qualifications])->render(),
            ]);
        }

        return view('admin.qualifications.index', [
            'title' => 'Qualifications',
            'qualifications' => $qualifications,
        ]);
    }

    public function create()
    {
        return view('admin.qualifications.create', [
            'title' => 'Add Qualification',
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'institution' => ['nullable', 'string', 'max:255'],
            'status' => ['required', 'in:completed,pursuing,cleared'],
            'start_year' => ['nullable', 'integer', 'min:1950', 'max:'.(date('Y') + 10)],
            'end_year' => ['nullable', 'integer', 'min:1950', 'max:'.(date('Y') + 10)],
            'description' => ['nullable', 'string', 'max:2000'],
            'display_order' => ['nullable', 'integer', 'min:0'],
            'is_active' => ['nullable', 'boolean'],
        ]);

        $validated['user_id'] = auth()->id();
        $validated['is_active'] = $request->boolean('is_active', true);
        $validated['display_order'] = $validated['display_order'] ?? 0;

        Qualification::create($validated);

        return redirect()
            ->route('admin.qualifications.index')
            ->with('status', 'Qualification created successfully.');
    }

    public function edit(Qualification $qualification)
    {
        return view('admin.qualifications.edit', [
            'title' => 'Edit Qualification',
            'qualification' => $qualification,
        ]);
    }

    public function update(Request $request, Qualification $qualification)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'institution' => ['nullable', 'string', 'max:255'],
            'status' => ['required', 'in:completed,pursuing,cleared'],
            'start_year' => ['nullable', 'integer', 'min:1950', 'max:'.(date('Y') + 10)],
            'end_year' => ['nullable', 'integer', 'min:1950', 'max:'.(date('Y') + 10)],
            'description' => ['nullable', 'string', 'max:2000'],
            'display_order' => ['nullable', 'integer', 'min:0'],
            'is_active' => ['nullable', 'boolean'],
        ]);

        $validated['is_active'] = $request->boolean('is_active', true);
        $validated['display_order'] = $validated['display_order'] ?? 0;

        $qualification->update($validated);

        return redirect()
            ->route('admin.qualifications.index')
            ->with('status', 'Qualification updated successfully.');
    }

    public function destroy(Qualification $qualification)
    {
        $qualification->delete();

        return redirect()
            ->route('admin.qualifications.index')
            ->with('status', 'Qualification deleted successfully.');
    }

    public function toggle(Qualification $qualification)
    {
        $qualification->update(['is_active' => ! $qualification->is_active]);

        return back()->with('status', 'Qualification status updated.');
    }
}
