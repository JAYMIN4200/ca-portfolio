<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Term;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class TermController extends Controller
{
    public function index(Request $request)
    {
        $query = Term::ordered();

        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                    ->orWhere('content', 'like', "%{$search}%");
            });
        }

        $terms = $query->paginate(10)->withQueryString();

        if ($request->ajax()) {
            return response()->json([
                'html' => view('admin.terms._table', ['terms' => $terms])->render(),
            ]);
        }

        return view('admin.terms.index', [
            'title' => 'Terms & Conditions',
            'terms' => $terms,
        ]);
    }

    public function create()
    {
        return view('admin.terms.create', [
            'title' => 'Add Term Section',
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'content' => ['required', 'string'],
            'display_order' => ['nullable', 'integer', 'min:0'],
            'is_active' => ['nullable', 'boolean'],
        ]);

        $validated['slug'] = Str::slug($validated['title']);
        $validated['is_active'] = $request->boolean('is_active', true);
        $validated['display_order'] = $validated['display_order'] ?? 0;

        Term::create($validated);

        return redirect()
            ->route('admin.terms.index')
            ->with('status', 'Term section created successfully.');
    }

    public function edit(Term $term)
    {
        return view('admin.terms.edit', [
            'title' => 'Edit Term Section',
            'term' => $term,
        ]);
    }

    public function update(Request $request, Term $term)
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'content' => ['required', 'string'],
            'display_order' => ['nullable', 'integer', 'min:0'],
            'is_active' => ['nullable', 'boolean'],
        ]);

        $validated['slug'] = Str::slug($validated['title']);
        $validated['is_active'] = $request->boolean('is_active', true);
        $validated['display_order'] = $validated['display_order'] ?? 0;

        $term->update($validated);

        return redirect()
            ->route('admin.terms.index')
            ->with('status', 'Term section updated successfully.');
    }

    public function destroy(Term $term)
    {
        $term->delete();

        return back()->with('status', 'Term section deleted successfully.');
    }

    public function toggle(Term $term)
    {
        $term->update(['is_active' => ! $term->is_active]);

        return back()->with('status', 'Term section status updated.');
    }
}
