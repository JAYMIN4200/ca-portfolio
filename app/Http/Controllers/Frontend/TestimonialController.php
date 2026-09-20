<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Testimonial;

class TestimonialController extends Controller
{
    public function index()
    {
        $testimonials = Testimonial::active()->ordered()->get();

        if ($testimonials->isEmpty()) {
            abort(404);
        }

        return view('frontend.testimonials', compact('testimonials'));
    }
}
