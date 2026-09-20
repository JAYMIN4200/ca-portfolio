<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Profile;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class ProfileController extends Controller
{
    public function edit()
    {
        $user = auth()->user()->load(['profile', 'qualifications', 'experiences']);
        $profile = $user->profile ?? new Profile;

        return view('admin.profile.edit', [
            'title' => 'Profile',
            'user' => $user,
            'profile' => $profile,
        ]);
    }

    public function update(Request $request)
    {
        $user = auth()->user();

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', Rule::unique('users')->ignore($user->id)],
            'professional_title' => ['nullable', 'string', 'max:255'],
            'short_intro' => ['nullable', 'string', 'max:1000'],
            'about_me' => ['nullable', 'string'],
            'career_objective' => ['nullable', 'string'],
            'years_of_experience' => ['nullable', 'integer', 'min:0', 'max:80'],
            'clients_count' => ['nullable', 'integer', 'min:0', 'max:100000'],
            'phone' => ['nullable', 'max:25', 'regex:/^\+?(?:[()\-\s]*\d){7,15}[()\-\s]*$/'],
            'location' => ['nullable', 'string', 'max:255'],
            'linkedin_username' => ['nullable', 'max:100', 'alpha_dash'],
            'instagram_url' => ['nullable', 'url', 'max:255'],
            'facebook_url' => ['nullable', 'url', 'max:255'],
            'twitter_url' => ['nullable', 'url', 'max:255'],
            'telegram_url' => ['nullable', 'url', 'max:255'],
            'github_url' => ['nullable', 'url', 'max:255'],
            'whatsapp_number' => ['nullable', 'max:25', 'regex:/^\+?(?:[()\-\s]*\d){7,15}[()\-\s]*$/'],
            'profile_photo' => ['nullable', 'image', 'mimes:jpeg,png,jpg,webp', 'max:2048'],
            'social_links' => ['nullable', 'array'],
            'social_links.*.label' => ['nullable', 'string', 'max:100'],
            'social_links.*.url' => ['nullable', 'url', 'max:255'],
        ]);

        // Update user fields
        $user->update([
            'name' => $validated['name'],
            'email' => $validated['email'],
        ]);

        $profile = $user->profile ?? new Profile(['user_id' => $user->id]);

        // Handle photo upload
        if ($request->hasFile('profile_photo')) {
            if ($profile->profile_photo) {
                Storage::disk('public')->delete($profile->profile_photo);
            }
            $validated['profile_photo'] = $request
                ->file('profile_photo')
                ->store('profile', 'public');
        } else {
            unset($validated['profile_photo']);
        }

        // Normalize social links
        $socialLinks = [];
        if ($request->filled('social_links')) {
            foreach (($request->input('social_links', []) ?? []) as $link) {
                if (! empty($link['label']) && ! empty($link['url'])) {
                    $socialLinks[] = $link;
                }
            }
        }
        $validated['social_links'] = $socialLinks;

        $profile->fill(array_intersect_key($validated, array_flip([
            'professional_title',
            'short_intro',
            'about_me',
            'career_objective',
            'years_of_experience',
            'clients_count',
            'phone',
            'location',
            'linkedin_username',
            'instagram_url',
            'facebook_url',
            'twitter_url',
            'telegram_url',
            'github_url',
            'whatsapp_number',
            'profile_photo',
            'social_links',
        ])));

        $profile->save();

        return redirect()
            ->route('admin.profile.edit')
            ->with('status', 'Profile updated successfully.');
    }
}
