<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Term;

class TermController extends Controller
{
    public function index()
    {
        $terms = Term::active()->ordered()->get();

        if ($terms->isEmpty()) {
            abort(404);
        }

        return view('frontend.terms', compact('terms'));
    }
}
