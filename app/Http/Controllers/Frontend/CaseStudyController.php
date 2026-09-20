<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\CaseStudy;
use Illuminate\Http\Request;

class CaseStudyController extends Controller
{
    public function index(Request $request)
    {
        $categories = CaseStudy::active()->published()->distinct()->pluck('category')->filter()->values();
        $activeCategory = $request->query('category');

        $query = CaseStudy::active()->published()->ordered();

        if ($activeCategory) {
            $query->where('category', $activeCategory);
        }

        $caseStudies = $query->paginate(10)->withQueryString();

        if ($request->ajax()) {
            return response()->json([
                'html' => view('frontend.case-studies._list', compact('caseStudies', 'categories', 'activeCategory'))->render(),
            ]);
        }

        return view('frontend.case-studies.index', compact('caseStudies', 'categories', 'activeCategory'));
    }

    public function show(CaseStudy $caseStudy)
    {
        abort_unless($caseStudy->is_active, 404);

        $related = CaseStudy::active()->published()
            ->whereKeyNot($caseStudy->getKey())
            ->ordered()
            ->limit(3)
            ->get();

        return view('frontend.case-studies.show', compact('caseStudy', 'related'));
    }
}
