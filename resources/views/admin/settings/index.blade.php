<x-admin.layouts.app :title="'Settings'">
    @php
        $g = function (string $group, string $key, ?string $default = null) use ($groups) {
            return $groups->get($group)?->firstWhere('key', $key)?->value ?? $default;
        };
    @endphp

    <form method="POST" action="{{ route('admin.settings.update') }}" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="space-y-6">
            <div class="rounded-xl bg-white p-6 shadow-sm ring-1 ring-slate-200">
                <h2 class="mb-4 text-base font-semibold text-navy-950">General</h2>
                <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                    <x-admin.form-input name="general[site_name]" label="Website Name" value="{{ $g('general', 'site_name', config('app.name')) }}" placeholder="E.g. Jinendra Panchal" />
                    <x-admin.form-input name="general[site_title]" label="Website Title" value="{{ $g('general', 'site_title') }}" placeholder="E.g. CA Finalist | Accounting, Audit & Taxation" />
                    <x-admin.form-input name="general[footer_text]" label="Footer Text" value="{{ $g('general', 'footer_text') }}" placeholder="Short tagline shown in the website footer" />
                    <x-admin.form-input name="general[copyright]" label="Copyright" value="{{ $g('general', 'copyright') }}" placeholder="© 2026 Jinendra Panchal. All rights reserved." />
                </div>
            </div>

            <div class="rounded-xl bg-white p-6 shadow-sm ring-1 ring-slate-200">
                <h2 class="mb-4 text-base font-semibold text-navy-950">Appearance</h2>
                @php
                    $faviconPath = $g('general', 'site_favicon');
                    $logoText = $g('general', 'logo_text') ?: 'JP';
                @endphp
                <div class="grid grid-cols-1 gap-6 sm:grid-cols-3">
                    <div class="sm:col-span-1">
                        <x-admin.form-input name="general[logo_text]" label="Brand / Logo Text" value="{{ $logoText }}" placeholder="E.g. CA or JP" help="Shown as the initials/logo in the admin sidebar and favicon fallback." />
                    </div>
                    <div class="sm:col-span-2">
                        <div class="flex items-start gap-4">
                            <div class="flex shrink-0 items-center justify-center">
                                @if ($faviconPath)
                                    <img src="{{ Storage::url($faviconPath) }}" alt="Favicon" class="h-16 w-16 rounded-xl border border-slate-200 object-cover shadow-sm">
                                @else
                                    <span class="flex h-16 w-16 items-center justify-center rounded-xl bg-navy-950 font-serif text-2xl font-bold text-gold-400 shadow-sm">
                                        {{ strtoupper(substr($logoText, 0, 1)) }}
                                    </span>
                                @endif
                            </div>
                            <div class="flex-1">
                                <label class="mb-1.5 block text-sm font-medium text-slate-700">Favicon</label>
                                <x-admin.form-file name="site_favicon" label="Upload favicon (32x32 recommended)" accept="image/png,image/x-icon,image/webp,image/svg+xml" />
                                <p class="mt-1 text-xs text-slate-500">Shown in the browser tab on both the website and admin panel. Replaces the auto-generated letter favicon.</p>
                                @if ($faviconPath)
                                    <p class="mt-1 text-xs text-slate-400">Current: {{ $faviconPath }} — uploading a new one replaces it.</p>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="rounded-xl bg-white p-6 shadow-sm ring-1 ring-slate-200">
                <h2 class="mb-4 text-base font-semibold text-navy-950">Mission & Vision</h2>
                <div class="space-y-4">
                    <x-admin.form-textarea name="about[mission]" label="Mission" rows="3" value="{{ $g('about', 'mission') }}" placeholder="What is the purpose and mission of the practice?" />
                    <x-admin.form-textarea name="about[vision]" label="Vision" rows="3" value="{{ $g('about', 'vision') }}" placeholder="What long-term vision guides the work?" />
                </div>
            </div>

            <div class="rounded-xl bg-white p-6 shadow-sm ring-1 ring-slate-200">
                <h2 class="mb-4 text-base font-semibold text-navy-950">Why Choose Us</h2>
                <x-admin.form-textarea
                    name="home[why_choose_us]"
                    label="Reasons"
                    rows="6"
                    value="{{ $g('home', 'why_choose_us') }}"
                    placeholder="Experienced Team | Qualified professionals with hands-on industry experience.&#10;Personalised Service | Tailored solutions for every client."
                    help="One reason per line in the format: Title | Description. Up to 6 lines are shown on the website." />
            </div>

            <div class="rounded-xl bg-white p-6 shadow-sm ring-1 ring-slate-200">
                <h2 class="mb-4 text-base font-semibold text-navy-950">Home Hero Image</h2>
                @php
                    $heroPath = $g('home', 'hero_image');
                @endphp
                <div class="flex items-start gap-4">
                    <div class="flex shrink-0 items-center justify-center">
                        @if ($heroPath)
                            <img src="{{ Storage::url($heroPath) }}" alt="Home Hero" class="h-20 w-28 rounded-xl border border-slate-200 object-cover shadow-sm">
                        @else
                            <span class="flex h-20 w-28 items-center justify-center rounded-xl bg-navy-950 text-xs font-semibold text-gold-400 shadow-sm">Default SVG</span>
                        @endif
                    </div>
                    <div class="flex-1">
                        <x-admin.form-file name="hero_image" label="Upload hero image" accept="image/png,image/jpeg,image/webp" />
                        <p class="mt-1 text-xs text-slate-500">Shown on the right side of the home page hero, next to the name. Wide portrait crop recommended (e.g. 800x1000). If left empty, the default GST illustration is used.</p>
                        @if ($heroPath)
                            <p class="mt-1 text-xs text-slate-400">Current: {{ $heroPath }} — uploading a new one replaces it.</p>
                        @endif
                    </div>
                </div>
            </div>

            <div class="rounded-xl bg-white p-6 shadow-sm ring-1 ring-slate-200">
                <h2 class="mb-4 text-base font-semibold text-navy-950">Contact Information</h2>
                <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                    <x-admin.form-input name="contact[contact_email]" label="Contact Email" type="email" value="{{ $g('contact', 'contact_email') }}" placeholder="you@example.com" />
                    <x-admin.form-input name="contact[contact_phone]" label="Contact Phone" value="{{ $g('contact', 'contact_phone') }}" placeholder="+91 98765 43210" />
                    <x-admin.form-input name="contact[contact_location]" label="Contact Location" value="{{ $g('contact', 'contact_location') }}" placeholder="City, State, Country" />
                </div>
            </div>

            <div class="rounded-xl bg-white p-6 shadow-sm ring-1 ring-slate-200">
                <h2 class="mb-4 text-base font-semibold text-navy-950">SEO</h2>
                <div class="space-y-4">
                    <x-admin.form-input name="seo[seo_title]" label="SEO Title" value="{{ $g('seo', 'seo_title') }}" placeholder="Page title shown in search engines" />
                    <x-admin.form-textarea name="seo[seo_description]" label="Meta Description" rows="3" value="{{ $g('seo', 'seo_description') }}" placeholder="Short description for search engine results" />
                    <x-admin.form-input name="seo[seo_keywords]" label="SEO Keywords" value="{{ $g('seo', 'seo_keywords') }}" placeholder="keyword1, keyword2, keyword3" />
                </div>
            </div>
        </div>

        <div class="mt-6">
            <button type="submit" class="rounded-lg bg-navy-900 px-6 py-2.5 text-sm font-semibold text-white shadow-sm hover:bg-navy-800">
                Save Settings
            </button>
        </div>
    </form>
</x-admin.layouts.app>