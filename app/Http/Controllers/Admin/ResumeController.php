<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Profile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ResumeController extends Controller
{
    public function index()
    {
        $profile = auth()->user()->profile ?? new Profile;

        return view('admin.resume.index', [
            'title' => 'Resume',
            'profile' => $profile,
        ]);
    }

    public function upload(Request $request)
    {
        $validated = $request->validate([
            'resume' => ['required', 'file', 'mimes:pdf,doc,docx', 'max:5120'],
        ]);

        $user = auth()->user();
        $profile = $user->profile ?? $user->profile()->create();

        if ($profile->resume_path) {
            Storage::disk('public')->delete($profile->resume_path);
        }

        $path = $request->file('resume')->store('resumes', 'public');
        $profile->update(['resume_path' => $path]);

        return back()->with('status', 'Resume uploaded successfully.');
    }

    public function download()
    {
        $profile = auth()->user()->profile;

        if (! $profile || ! $profile->resume_path) {
            return back()->with('error', 'No resume uploaded yet.');
        }

        return Storage::disk('public')->download($profile->resume_path);
    }

    public function view()
    {
        $profile = auth()->user()->profile;

        if (! $profile || ! $profile->resume_path) {
            return back()->with('error', 'No resume uploaded yet.');
        }

        return Storage::disk('public')->response($profile->resume_path);
    }

    public function destroy()
    {
        $profile = auth()->user()->profile;

        if ($profile && $profile->resume_path) {
            Storage::disk('public')->delete($profile->resume_path);
            $profile->update(['resume_path' => null]);
        }

        return back()->with('status', 'Resume deleted successfully.');
    }
}
