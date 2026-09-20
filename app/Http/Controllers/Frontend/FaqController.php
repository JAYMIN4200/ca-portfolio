<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Faq;

class FaqController extends Controller
{
    public function index()
    {
        $faqs = Faq::active()->ordered()->get();

        if ($faqs->isEmpty()) {
            abort(404);
        }

        return view('frontend.faqs', compact('faqs'));
    }
}
