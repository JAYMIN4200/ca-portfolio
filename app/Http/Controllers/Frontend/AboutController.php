<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Qualification;
use App\Models\User;

class AboutController extends Controller
{
    public function index()
    {
        $user = User::where('is_admin', true)->first();
        $profile = $user?->profile;
        $qualifications = Qualification::active()->ordered()->get();

        return view('frontend.about', compact('profile', 'qualifications'));
    }
}
