<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\SkillCategory;

class SkillController extends Controller
{
    public function index()
    {
        $categories = SkillCategory::with(['skills' => function ($q) {
            $q->active();
        }])->active()->ordered()->get();

        return view('frontend.skills', compact('categories'));
    }
}
