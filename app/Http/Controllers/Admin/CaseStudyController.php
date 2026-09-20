<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CaseStudy;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class CaseStudyController extends Controller
{
    public function index(Request $request)
    {
        $query = CaseStudy::query()->ordered();

        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                    ->orWhere('client_name', 'like', "%{$search}%")
                    ->orWhere('category', 'like', "%{$search}%");
            });
        }

        $caseStudies = $query->paginate(10)->withQueryString();

        if ($request->ajax()) {
            return response()->json([
                'html' => view('admin.case-studies._table', ['caseStudies' => $caseStudies])->render(),
            ]);
        }

        return view('admin.case-studies.index', [
            'title' => 'Case Studies',
            'caseStudies' => $caseStudies,
        ]);
    }

    public function create()
    {
        return view('admin.case-studies.create', [
            'title' => 'Add Case Study',
        ]);
    }

    public function store(Request $request)
    {
        $validated = $this->validateCaseStudy($request);

        $validated['user_id'] = auth()->id();
        $validated['slug'] = $this->uniqueSlug($validated['slug'] ?? $validated['title']);
        $validated['is_active'] = $request->boolean('is_active', true);
        $validated['display_order'] = $validated['display_order'] ?? 0;

        if ($request->hasFile('image')) {
            $validated['image_path'] = $request->file('image')->store('case-studies', 'public');
        }

        CaseStudy::create($validated);

        return redirect()
            ->route('admin.case-studies.index')
            ->with('status', 'Case study created successfully.');
    }

    public function edit(CaseStudy $caseStudy)
    {
        return view('admin.case-studies.edit', [
            'title' => 'Edit Case Study',
            'caseStudy' => $caseStudy,
        ]);
    }

    public function update(Request $request, CaseStudy $caseStudy)
    {
        $validated = $this->validateCaseStudy($request);

        $validated['slug'] = $this->uniqueSlug($validated['slug'] ?? $validated['title'], $caseStudy);
        $validated['is_active'] = $request->boolean('is_active', true);
        $validated['display_order'] = $validated['display_order'] ?? 0;

        if ($request->hasFile('image')) {
            if ($caseStudy->image_path) {
                Storage::disk('public')->delete($caseStudy->image_path);
            }
            $validated['image_path'] = $request->file('image')->store('case-studies', 'public');
        }

        if ($request->boolean('remove_image') && ! $request->hasFile('image')) {
            if ($caseStudy->image_path) {
                Storage::disk('public')->delete($caseStudy->image_path);
            }
            $validated['image_path'] = null;
        }

        $caseStudy->update($validated);

        return redirect()
            ->route('admin.case-studies.index')
            ->with('status', 'Case study updated successfully.');
    }

    public function destroy(CaseStudy $caseStudy)
    {
        if ($caseStudy->image_path) {
            Storage::disk('public')->delete($caseStudy->image_path);
        }

        $caseStudy->delete();

        return back()->with('status', 'Case study deleted successfully.');
    }

    public function toggle(CaseStudy $caseStudy)
    {
        $caseStudy->update(['is_active' => ! $caseStudy->is_active]);

        return back()->with('status', 'Case study status updated.');
    }

    /**
     * @return array<string, mixed>
     */
    private function validateCaseStudy(Request $request): array
    {
        return $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'slug' => ['nullable', 'string', 'max:255'],
            'client_name' => ['nullable', 'string', 'max:255'],
            'category' => ['nullable', 'string', 'max:100'],
            'summary' => ['nullable', 'string', 'max:1000'],
            'challenge' => ['nullable', 'string'],
            'solution' => ['nullable', 'string'],
            'results' => ['nullable', 'string'],
            'image' => ['nullable', 'image', 'mimes:jpeg,png,jpg,webp', 'max:3072'],
            'remove_image' => ['nullable', 'boolean'],
            'published_at' => ['nullable', 'date'],
            'display_order' => ['nullable', 'integer', 'min:0'],
            'is_active' => ['nullable', 'boolean'],
        ]);
    }

    private function uniqueSlug(string $source, ?CaseStudy $ignore = null): string
    {
        $base = Str::slug($source) ?: 'case-study';
        $slug = $base;
        $suffix = 2;

        while (CaseStudy::where('slug', $slug)
            ->when($ignore, fn ($query) => $query->whereKeyNot($ignore->getKey()))
            ->exists()) {
            $slug = $base.'-'.$suffix++;
        }

        return $slug;
    }
}
