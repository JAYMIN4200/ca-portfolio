<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Qualification;

class QualificationController extends Controller
{
    public function index()
    {
        $qualifications = Qualification::active()->ordered()->get();

        return view('frontend.qualifications', compact('qualifications'));
    }
}
