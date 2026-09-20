<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Assignment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AssignmentController extends Controller
{
    public function index(Request $request)
    {
        $query = Assignment::ordered();

        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                    ->orWhere('short_description', 'like', "%{$search}%")
                    ->orWhere('category', 'like', "%{$search}%");
            });
        }

        if ($request->filled('category')) {
            $query->where('category', $request->input('category'));
        }

        $assignments = $query->paginate(10)->withQueryString();
        $categories = Assignment::distinct()->pluck('category')->filter()->values();

        if ($request->ajax()) {
            return response()->json([
                'html' => view('admin.assignments._table', ['assignments' => $assignments])->render(),
            ]);
        }

        return view('admin.assignments.index', [
            'title' => 'Assignments',
            'assignments' => $assignments,
            'categories' => $categories,
        ]);
    }

    public function create()
    {
        return view('admin.assignments.create', [
            'title' => 'Add Assignment',
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'category' => ['nullable', 'string', 'max:100'],
            'short_description' => ['nullable', 'string', 'max:1000'],
            'description' => ['nullable', 'string'],
            'responsibilities' => ['nullable', 'array'],
            'responsibilities.*' => ['nullable', 'string', 'max:500'],
            'tools_used' => ['nullable', 'array'],
            'tools_used.*' => ['nullable', 'string', 'max:100'],
            'image' => ['nullable', 'image', 'mimes:jpeg,png,jpg,webp', 'max:3072'],
            'external_url' => ['nullable', 'url', 'max:255'],
            'display_order' => ['nullable', 'integer', 'min:0'],
            'is_active' => ['nullable', 'boolean'],
        ]);

        if ($request->hasFile('image')) {
            $validated['image_path'] = $request->file('image')->store('assignments', 'public');
        }

        $validated['is_active'] = $request->boolean('is_active', true);
        $validated['display_order'] = $validated['display_order'] ?? 0;
        $validated['responsibilities'] = array_values(array_filter($validated['responsibilities'] ?? [], fn ($r) => ! empty($r)));
        $validated['tools_used'] = array_values(array_filter($validated['tools_used'] ?? [], fn ($t) => ! empty($t)));

        Assignment::create($validated);

        return redirect()
            ->route('admin.assignments.index')
            ->with('status', 'Assignment created successfully.');
    }

    public function edit(Assignment $assignment)
    {
        return view('admin.assignments.edit', [
            'title' => 'Edit Assignment',
            'assignment' => $assignment,
        ]);
    }

    public function update(Request $request, Assignment $assignment)
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'category' => ['nullable', 'string', 'max:100'],
            'short_description' => ['nullable', 'string', 'max:1000'],
            'description' => ['nullable', 'string'],
            'responsibilities' => ['nullable', 'array'],
            'responsibilities.*' => ['nullable', 'string', 'max:500'],
            'tools_used' => ['nullable', 'array'],
            'tools_used.*' => ['nullable', 'string', 'max:100'],
            'image' => ['nullable', 'image', 'mimes:jpeg,png,jpg,webp', 'max:3072'],
            'remove_image' => ['nullable', 'boolean'],
            'external_url' => ['nullable', 'url', 'max:255'],
            'display_order' => ['nullable', 'integer', 'min:0'],
            'is_active' => ['nullable', 'boolean'],
        ]);

        if ($request->hasFile('image')) {
            if ($assignment->image_path) {
                Storage::disk('public')->delete($assignment->image_path);
            }
            $validated['image_path'] = $request->file('image')->store('assignments', 'public');
        }

        if ($request->boolean('remove_image') && ! $request->hasFile('image')) {
            if ($assignment->image_path) {
                Storage::disk('public')->delete($assignment->image_path);
            }
            $validated['image_path'] = null;
        }

        $validated['is_active'] = $request->boolean('is_active', true);
        $validated['display_order'] = $validated['display_order'] ?? 0;
        $validated['responsibilities'] = array_values(array_filter($validated['responsibilities'] ?? [], fn ($r) => ! empty($r)));
        $validated['tools_used'] = array_values(array_filter($validated['tools_used'] ?? [], fn ($t) => ! empty($t)));

        $assignment->update($validated);

        return redirect()
            ->route('admin.assignments.index')
            ->with('status', 'Assignment updated successfully.');
    }

    public function destroy(Assignment $assignment)
    {
        if ($assignment->image_path) {
            Storage::disk('public')->delete($assignment->image_path);
        }

        $assignment->delete();

        return back()->with('status', 'Assignment deleted successfully.');
    }

    public function toggle(Assignment $assignment)
    {
        $assignment->update(['is_active' => ! $assignment->is_active]);

        return back()->with('status', 'Assignment status updated.');
    }
}
