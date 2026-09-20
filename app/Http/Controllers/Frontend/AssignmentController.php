<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Assignment;
use Illuminate\Http\Request;

class AssignmentController extends Controller
{
    public function index(Request $request)
    {
        $categories = Assignment::active()->distinct()->pluck('category')->filter()->values();
        $activeCategory = $request->query('category');
        $query = Assignment::active()->ordered();

        if ($activeCategory) {
            $query->where('category', $activeCategory);
        }

        $assignments = $query->paginate(10)->withQueryString();

        if ($request->ajax()) {
            return response()->json([
                'html' => view('frontend.assignments._list', compact('assignments', 'categories', 'activeCategory'))->render(),
            ]);
        }

        return view('frontend.assignments.index', compact('assignments', 'categories', 'activeCategory'));
    }

    public function show(Assignment $assignment)
    {
        abort_unless($assignment->is_active, 404);

        return view('frontend.assignments.show', compact('assignment'));
    }
}
