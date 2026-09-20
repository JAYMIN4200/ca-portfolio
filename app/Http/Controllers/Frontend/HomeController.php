<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Assignment;
use App\Models\Experience;
use App\Models\Qualification;
use App\Models\Service;
use App\Models\SkillCategory;
use App\Models\Testimonial;
use App\Models\User;

class HomeController extends Controller
{
    public function index()
    {
        $user = User::where('is_admin', true)->first();
        $profile = $user?->profile;
        $skills = SkillCategory::with(['skills' => function ($q) {
            $q->active();
        }])->active()->ordered()->get();
        $experiences = Experience::active()->ordered()->limit(3)->get();
        $services = Service::active()->ordered()->get();
        $qualifications = Qualification::active()->ordered()->get();
        $assignments = Assignment::active()->ordered()->limit(6)->get();
        $testimonials = Testimonial::active()->ordered()->get();

        return view('frontend.home', compact(
            'profile',
            'skills',
            'experiences',
            'services',
            'qualifications',
            'assignments',
            'testimonials'
        ));
    }
}
