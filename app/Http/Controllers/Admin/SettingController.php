<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use App\Services\SettingsService;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    public function index()
    {
        $settings = Setting::orderBy('group')->get()->groupBy('group');

        return view('admin.settings.index', [
            'title' => 'Settings',
            'groups' => $settings,
        ]);
    }

    public function update(Request $request)
    {
        $validated = $request->validate([
            // General
            'general.site_name' => ['nullable', 'string', 'max:255'],
            'general.site_title' => ['nullable', 'string', 'max:255'],
            'general.footer_text' => ['nullable', 'string', 'max:500'],
            'general.copyright' => ['nullable', 'string', 'max:500'],
            'general.logo_text' => ['nullable', 'string', 'max:50'],
            'general.site_favicon' => ['nullable', 'string', 'max:255'],

            // About
            'about.mission' => ['nullable', 'string', 'max:3000'],
            'about.vision' => ['nullable', 'string', 'max:3000'],

            // Home
            'home.why_choose_us' => ['nullable', 'string', 'max:5000'],

            // Contact
            'contact.contact_email' => ['nullable', 'email', 'max:255'],
            'contact.contact_phone' => ['nullable', 'max:25', 'regex:/^\+?(?:[()\-\s]*\d){7,15}[()\-\s]*$/'],
            'contact.contact_location' => ['nullable', 'string', 'max:500'],

            // Social

            // SEO
            'seo.seo_title' => ['nullable', 'string', 'max:255'],
            'seo.seo_description' => ['nullable', 'string', 'max:1000'],
            'seo.seo_keywords' => ['nullable', 'string', 'max:500'],
        ]);

        if ($request->hasFile('site_favicon')) {
            $path = $request->file('site_favicon')->store('favicon', 'public');
            $validated['general']['site_favicon'] = $path;
        }

        if ($request->hasFile('hero_image')) {
            $path = $request->file('hero_image')->store('hero', 'public');
            $validated['home']['hero_image'] = $path;
        }

        $grouped = [];
        foreach ($validated as $group => $values) {
            foreach ($values as $key => $value) {
                $grouped[$group][] = ['key' => $key, 'value' => $value];
            }
        }

        foreach ($grouped as $group => $entries) {
            foreach ($entries as $entry) {
                Setting::setValue($entry['key'], $entry['value'], $group);
            }
        }

        SettingsService::flushCache();

        return redirect()
            ->route('admin.settings.index')
            ->with('status', 'Settings updated successfully.');
    }
}
