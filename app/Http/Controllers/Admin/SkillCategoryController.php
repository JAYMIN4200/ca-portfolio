<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SkillCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class SkillCategoryController extends Controller
{
    public function index()
    {
        $categories = SkillCategory::withCount('skills')->ordered()->get();

        return view('admin.skills.categories', [
            'title' => 'Skill Categories',
            'categories' => $categories,
        ]);
    }

    public function create()
    {
        return view('admin.skills.category-create', [
            'title' => 'Add Skill Category',
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'icon' => ['nullable', 'string', 'max:255'],
            'display_order' => ['nullable', 'integer', 'min:0'],
            'is_active' => ['nullable', 'boolean'],
        ]);

        $validated['slug'] = Str::slug($validated['name']);
        $validated['is_active'] = $request->boolean('is_active', true);
        $validated['display_order'] = $validated['display_order'] ?? 0;

        SkillCategory::create($validated);

        return redirect()
            ->route('admin.skill-categories.index')
            ->with('status', 'Skill category created successfully.');
    }

    public function edit(SkillCategory $skillCategory)
    {
        return view('admin.skills.category-edit', [
            'title' => 'Edit Skill Category',
            'category' => $skillCategory,
        ]);
    }

    public function update(Request $request, SkillCategory $skillCategory)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'icon' => ['nullable', 'string', 'max:255'],
            'display_order' => ['nullable', 'integer', 'min:0'],
            'is_active' => ['nullable', 'boolean'],
        ]);

        $validated['is_active'] = $request->boolean('is_active', true);
        $validated['display_order'] = $validated['display_order'] ?? 0;

        if ($skillCategory->name !== $validated['name']) {
            $validated['slug'] = Str::slug($validated['name']);
        }

        $skillCategory->update($validated);

        return redirect()
            ->route('admin.skill-categories.index')
            ->with('status', 'Skill category updated successfully.');
    }

    public function destroy(SkillCategory $skillCategory)
    {
        if ($skillCategory->skills()->count() > 0) {
            return back()->with('error', 'Cannot delete a category that contains skills. Move or delete its skills first.');
        }

        $skillCategory->delete();

        return back()->with('status', 'Skill category deleted successfully.');
    }
}
