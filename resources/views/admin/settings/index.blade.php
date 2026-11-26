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
                    <x-admin.form-input name="general[site_name]" label="Website Name" :value="$g('general', 'site_name', config('app.name'))" placeholder="E.g. Jinendra Panchal" />
                    <x-admin.form-input name="general[site_title]" label="Website Title" :value="$g('general', 'site_title')" placeholder="E.g. Chartered Accountant | Accounting, Audit & Taxation" />
                    <x-admin.form-input name="general[footer_text]" label="Footer Text" :value="$g('general', 'footer_text')" placeholder="Short tagline shown in the website footer" help="Shown as the tagline in the website footer only when the profile's Short Intro is empty. If a Short Intro is set, that is used instead." />
                    <x-admin.form-input name="general[copyright]" label="Copyright" :value="$g('general', 'copyright')" placeholder="© 2026 Jinendra Panchal. All rights reserved." />
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
                        <x-admin.form-input name="general[logo_text]" label="Brand / Logo Text" :value="$logoText" placeholder="E.g. CA or JP" help="Shown as the initials/logo in the admin sidebar and favicon fallback." />
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
                                <x-admin.form-file name="site_favicon" label="Upload favicon" accept="image/png,image/x-icon,image/webp,image/svg+xml" help="Recommended: 512x512px PNG (square) for sharp display. Min 32x32px." />
                                <p class="mt-1 text-xs text-slate-500">Shown in the browser tab on both the website and admin panel. Replaces the auto-generated letter favicon.</p>
                                @if ($faviconPath)
                                    <p class="mt-1 text-xs text-slate-400">Current: {{ $faviconPath }} — uploading a new one replaces it.</p>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
                <div class="mt-5 border-t border-slate-200 pt-5">
                    <x-admin.form-toggle name="general[theme_toggle_enabled]"
                        label="Show theme switcher"
                        help="When enabled, the light / dark theme button is shown in the website and admin navigation bars."
                        :checked="$g('general', 'theme_toggle_enabled', '1') === '1'" />
                </div>
            </div>
            <div class="rounded-xl bg-white p-6 shadow-sm ring-1 ring-slate-200">
                <h2 class="mb-4 text-base font-semibold text-navy-950">Mission & Vision</h2>
                <div class="space-y-4">
                    <x-admin.form-textarea name="about[mission]" label="Mission" rows="3" :value="$g('about', 'mission')" placeholder="What is the purpose and mission of the practice?" help="Shown in the 'Our Mission' card on the About page. Leave blank to hide the card." />
                    <x-admin.form-textarea name="about[vision]" label="Vision" rows="3" :value="$g('about', 'vision')" placeholder="What long-term vision guides the work?" help="Shown in the 'Our Vision' card on the About page. Leave blank to hide the card." />
                </div>
            </div>

            <div class="rounded-xl bg-white p-6 shadow-sm ring-1 ring-slate-200">
                <h2 class="mb-4 text-base font-semibold text-navy-950">Why Choose Us</h2>
                <x-admin.form-textarea
                    name="home[why_choose_us]"
                    label="Reasons"
                    rows="6"
                    :value="$g('home', 'why_choose_us')"
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
                        <x-admin.form-file name="hero_image" label="Upload hero image" accept="image/png,image/jpeg,image/webp" help="Recommended: 800x1000px (4:5 portrait). JPG, PNG or WebP." />
                        <p class="mt-1 text-xs text-slate-500">Shown on the right side of the home page hero, next to the name. Wide portrait crop recommended (e.g. 800x1000). If left empty, the default GST illustration is used.</p>
                        @if ($heroPath)
                            <p class="mt-1 text-xs text-slate-400">Current: {{ $heroPath }} — uploading a new one replaces it.</p>
                        @endif
                    </div>
                </div>
            </div>

            <div class="rounded-xl bg-white p-6 shadow-sm ring-1 ring-slate-200">
                <h2 class="mb-1 text-base font-semibold text-navy-950">Home Hero Badges</h2>
                <p class="mb-4 text-xs text-slate-500">Four badges shown on the corners of the home page hero image. Uncheck "Show" to hide a badge, or leave the title and label blank to hide it too.</p>
                <div class="space-y-4">
                    @php
                        $badgeMeta = [
                            1 => ['corner' => 'Top right', 'title' => 'GST', 'label' => 'Expert'],
                            2 => ['corner' => 'Bottom left', 'title' => '₹', 'label' => 'Tax Planning'],
                            3 => ['corner' => 'Top left', 'title' => 'ITR', 'label' => 'Income Tax'],
                            4 => ['corner' => 'Bottom right', 'title' => 'Audit', 'label' => 'Compliance'],
                        ];
                    @endphp
                    @foreach ($badgeMeta as $index => $meta)
                        <div class="grid grid-cols-1 items-end gap-3 rounded-lg border border-slate-200 p-4 sm:grid-cols-12">
                            <div class="sm:col-span-3">
                                <p class="text-sm font-medium text-slate-700">Badge {{ $index }} <span class="text-xs font-normal text-slate-400">({{ $meta['corner'] }})</span></p>
                                <div class="mt-2">
                                    <x-admin.form-checkbox name="home[hero_badge_{{ $index }}_enabled]" label="Show" :checked="$g('home', 'hero_badge_'.$index.'_enabled', '1') === '1'" />
                                </div>
                            </div>
                            <div class="sm:col-span-4">
                                <x-admin.form-input name="home[hero_badge_{{ $index }}_title]" label="Title" :value="$g('home', 'hero_badge_'.$index.'_title', $meta['title'])" :placeholder="$meta['title']" />
                            </div>
                            <div class="sm:col-span-5">
                                <x-admin.form-input name="home[hero_badge_{{ $index }}_label]" label="Label" :value="$g('home', 'hero_badge_'.$index.'_label', $meta['label'])" :placeholder="$meta['label']" />
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            <div class="rounded-xl bg-white p-6 shadow-sm ring-1 ring-slate-200">
                <h2 class="mb-4 text-base font-semibold text-navy-950">Contact Information</h2>
                <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-3">
                    <x-admin.form-input name="contact[contact_email]" label="Contact Email" type="email" :value="$g('contact', 'contact_email')" placeholder="you@example.com" />
                    <x-admin.form-input name="contact[contact_phone]" label="Contact Phone" :value="$g('contact', 'contact_phone')" placeholder="+91 98765 43210" />
                    <x-admin.form-input name="contact[contact_location]" label="Contact Location" :value="$g('contact', 'contact_location')" placeholder="City, State, Country" />
                </div>
            </div>

            <div class="rounded-xl bg-white p-6 shadow-sm ring-1 ring-slate-200">
                <h2 class="mb-4 text-base font-semibold text-navy-950">Security</h2>
                <div class="grid grid-cols-1 items-start gap-4 sm:grid-cols-2">
                    <div>
                        <p class="text-sm font-medium text-slate-700">Auto Logout (minutes)</p>
                        <p class="mt-1 text-xs text-slate-500">Admin is signed out automatically after this many idle minutes. Leave empty for the default of 15 minutes.</p>
                    </div>
                    <div>
                        <x-admin.form-input name="security[auto_logout_minutes]" type="number" min="1" max="1440" :value="$g('security', 'auto_logout_minutes', '15')" placeholder="15" help="Between 1 and 1440 minutes (24 hours)." />
                    </div>
                </div>
            </div>

            <div class="rounded-xl bg-white p-6 shadow-sm ring-1 ring-slate-200">
                <h2 class="mb-4 text-base font-semibold text-navy-950">SEO</h2>
                <div class="space-y-4">
                    <x-admin.form-input name="seo[seo_title]" label="SEO Title" :value="$g('seo', 'seo_title')" placeholder="Page title shown in search engines" />
                    <x-admin.form-textarea name="seo[seo_description]" label="Meta Description" rows="3" :value="$g('seo', 'seo_description')" placeholder="Short description for search engine results" />
                    <x-admin.form-input name="seo[seo_keywords]" label="SEO Keywords" :value="$g('seo', 'seo_keywords')" placeholder="keyword1, keyword2, keyword3" />
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
