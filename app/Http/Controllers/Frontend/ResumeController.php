<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\StreamedResponse;

class ResumeController extends Controller
{
    public function view()
    {
        $profile = User::where('is_admin', true)->first()?->profile;

        if (! $profile || ! $profile->resume_path || ! Storage::disk('public')->exists($profile->resume_path)) {
            abort(404);
        }

        return view('frontend.resume', compact('profile'));
    }

    public function download(): StreamedResponse
    {
        $profile = User::where('is_admin', true)->first()?->profile;

        if (! $profile || ! $profile->resume_path || ! Storage::disk('public')->exists($profile->resume_path)) {
            abort(404);
        }

        return Storage::disk('public')->download($profile->resume_path);
    }
}
