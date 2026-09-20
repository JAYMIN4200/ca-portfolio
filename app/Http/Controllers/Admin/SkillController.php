<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Skill;
use App\Models\SkillCategory;
use Illuminate\Http\Request;

class SkillController extends Controller
{
    public function index(Request $request)
    {
        $query = Skill::with('category')->ordered();

        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('description', 'like', "%{$search}%");
            });
        }

        if ($request->filled('category')) {
            $query->where('skill_category_id', $request->input('category'));
        }

        $skills = $query->paginate(10)->withQueryString();
        $categories = SkillCategory::ordered()->get();

        if ($request->ajax()) {
            return response()->json([
                'html' => view('admin.skills._table', ['skills' => $skills])->render(),
            ]);
        }

        return view('admin.skills.index', [
            'title' => 'Skills',
            'skills' => $skills,
            'categories' => $categories,
        ]);
    }

    public function create()
    {
        $categories = SkillCategory::ordered()->get();

        return view('admin.skills.create', [
            'title' => 'Add Skill',
            'categories' => $categories,
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'skill_category_id' => ['required', 'exists:skill_categories,id'],
            'name' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string', 'max:2000'],
            'proficiency' => ['nullable', 'integer', 'between:0,100'],
            'icon' => ['nullable', 'string', 'max:255'],
            'display_order' => ['nullable', 'integer', 'min:0'],
            'is_active' => ['nullable', 'boolean'],
        ]);

        $validated['is_active'] = $request->boolean('is_active', true);
        $validated['display_order'] = $validated['display_order'] ?? 0;

        Skill::create($validated);

        return redirect()
            ->route('admin.skills.index')
            ->with('status', 'Skill created successfully.');
    }

    public function edit(Skill $skill)
    {
        $categories = SkillCategory::ordered()->get();

        return view('admin.skills.edit', [
            'title' => 'Edit Skill',
            'skill' => $skill,
            'categories' => $categories,
        ]);
    }

    public function update(Request $request, Skill $skill)
    {
        $validated = $request->validate([
            'skill_category_id' => ['required', 'exists:skill_categories,id'],
            'name' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string', 'max:2000'],
            'proficiency' => ['nullable', 'integer', 'between:0,100'],
            'icon' => ['nullable', 'string', 'max:255'],
            'display_order' => ['nullable', 'integer', 'min:0'],
            'is_active' => ['nullable', 'boolean'],
        ]);

        $validated['is_active'] = $request->boolean('is_active', true);
        $validated['display_order'] = $validated['display_order'] ?? 0;

        $skill->update($validated);

        return redirect()
            ->route('admin.skills.index')
            ->with('status', 'Skill updated successfully.');
    }

    public function destroy(Skill $skill)
    {
        $skill->delete();

        return back()->with('status', 'Skill deleted successfully.');
    }

    public function toggle(Skill $skill)
    {
        $skill->update(['is_active' => ! $skill->is_active]);

        return back()->with('status', 'Skill status updated.');
    }
}
