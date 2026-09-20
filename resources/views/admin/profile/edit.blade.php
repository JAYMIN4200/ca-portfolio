<x-admin.layouts.app :title="'Profile'">
    <form method="POST" action="{{ route('admin.profile.update') }}" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="grid grid-cols-1 gap-6 lg:grid-cols-3">
            {{-- Left column --}}
            <div class="space-y-6">
                <div class="rounded-2xl bg-white p-6 shadow-sm ring-1 ring-slate-200">
                    <h2 class="mb-4 text-base font-semibold text-navy-950">Profile Photo</h2>
                    <div class="flex flex-col items-center gap-4">
                        <div id="photoPreview">
                            @if ($profile->profile_photo)
                                <img src="{{ $profile->photo_url }}" alt="Profile photo" class="h-32 w-32 rounded-2xl object-cover ring-4 ring-gold-500/20">
                            @else
                                <div class="flex h-32 w-32 items-center justify-center rounded-2xl bg-gradient-to-br from-navy-800 to-navy-950 text-5xl font-semibold text-gold-400 ring-4 ring-gold-500/20">
                                    {{ strtoupper(substr($user->name, 0, 1)) }}
                                </div>
                            @endif
                        </div>
                        <div class="w-full">
                            <x-admin.form-file name="profile_photo" label="Upload Photo" accept="image/png,image/jpeg,image/webp" />
                            <p class="mt-1 text-xs text-slate-500">JPG, PNG or WebP. Max 2MB.</p>
                        </div>
                    </div>
                </div>

                <div class="rounded-2xl bg-white p-6 shadow-sm ring-1 ring-slate-200">
                    <h2 class="mb-4 text-base font-semibold text-navy-950">Account Details</h2>
                    <div class="space-y-4">
                        <x-admin.form-input name="name" label="Full Name" :value="$user->name" required placeholder="Enter your full name" />
                        <x-admin.form-input name="email" label="Email Address" type="email" :value="$user->email" required placeholder="you@example.com" />
                    </div>
                </div>

                <div class="rounded-2xl bg-white p-6 shadow-sm ring-1 ring-slate-200">
                    <h2 class="mb-4 text-base font-semibold text-navy-950">Contact Information</h2>
                    <div class="grid grid-cols-1 gap-4">
                        <x-admin.form-input name="phone" label="Phone" :value="$profile->phone" placeholder="+91 98765 43210" />
                        <x-admin.form-input name="location" label="Location" :value="$profile->location" placeholder="City, State, Country" />
                    </div>
                </div>
            </div>

            {{-- Right column --}}
            <div class="space-y-6 lg:col-span-2">
                <div class="rounded-2xl bg-white p-6 shadow-sm ring-1 ring-slate-200">
                    <h2 class="mb-4 text-base font-semibold text-navy-950">Professional Information</h2>
                    <div class="space-y-4">
                        <x-admin.form-input name="professional_title" label="Professional Title" :value="$profile->professional_title" placeholder="CA Finalist | Accounting, Audit & Taxation Professional" help="E.g. CA Finalist | Accounting, Audit & Taxation Professional" />
                        <x-admin.form-textarea name="short_intro" label="Short Introduction" :value="$profile->short_intro" rows="3" placeholder="A one-line professional summary shown on the website hero section" />
                        <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                            <x-admin.form-input name="years_of_experience" label="Years of Experience" type="number" min="0" max="60" :value="$profile->years_of_experience" placeholder="E.g. 5" help="Shown as a stat on the website." />
                            <x-admin.form-input name="clients_count" label="Clients Served" type="number" min="0" :value="$profile->clients_count" placeholder="E.g. 120" help="Shown as a stat on the website." />
                        </div>
                        <x-admin.form-textarea name="about_me" label="About Me" :value="$profile->about_me" rows="8" placeholder="Write a short bio about your professional background..." />
                        <x-admin.form-textarea name="career_objective" label="Career Objective" :value="$profile->career_objective" rows="4" placeholder="Your career objective statement" />
                    </div>
                </div>

                <div class="rounded-2xl bg-white p-6 shadow-sm ring-1 ring-slate-200">
                    <h2 class="mb-4 text-base font-semibold text-navy-950">Social Media Handles</h2>
                    <p class="mb-4 text-sm text-slate-500">Add your social media links so visitors can reach out on their favourite platform.</p>
                    <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                        <x-admin.form-input name="linkedin_username" label="LinkedIn" :value="$profile->linkedin_username" placeholder="username (e.g. jinendra2002)" help="Just the username, not the full URL" />
                        <x-admin.form-input name="instagram_url" label="Instagram" type="url" :value="$profile->instagram_url" placeholder="https://instagram.com/username" />
                        <x-admin.form-input name="facebook_url" label="Facebook" type="url" :value="$profile->facebook_url" placeholder="https://facebook.com/username" />
                        <x-admin.form-input name="twitter_url" label="Twitter / X" type="url" :value="$profile->twitter_url" placeholder="https://twitter.com/username" />
                        <x-admin.form-input name="telegram_url" label="Telegram" type="url" :value="$profile->telegram_url" placeholder="https://t.me/username" />
                        <x-admin.form-input name="github_url" label="GitHub" type="url" :value="$profile->github_url" placeholder="https://github.com/username" />
                        <x-admin.form-input name="whatsapp_number" label="WhatsApp Number" :value="$profile->whatsapp_number" placeholder="+91 98765 43210" help="Full international number, e.g. +91..." />
                    </div>
                </div>

                <div class="rounded-2xl bg-white p-6 shadow-sm ring-1 ring-slate-200">
                    <h2 class="mb-4 text-base font-semibold text-navy-950">SEO Settings</h2>
                    <div class="space-y-4">
                        <x-admin.form-input name="seo_title" label="SEO Title" :value="$profile->seo_title" placeholder="Page title shown in search engines" />
                        <x-admin.form-textarea name="seo_description" label="Meta Description" :value="$profile->seo_description" rows="3" placeholder="Short description for search engine results" />
                        <x-admin.form-input name="seo_keywords" label="SEO Keywords" :value="$profile->seo_keywords" placeholder="keyword1, keyword2, keyword3" help="Comma separated keywords" />
                    </div>
                </div>

                <div class="flex items-center gap-3 rounded-2xl bg-white p-6 shadow-sm ring-1 ring-slate-200">
                    <button type="submit" class="rounded-lg bg-gradient-to-r from-navy-900 to-navy-700 px-8 py-2.5 text-sm font-semibold text-white shadow-lg shadow-navy-900/20 transition-all hover:from-navy-800 hover:to-navy-600 focus:outline-none focus:ring-2 focus:ring-navy-500 focus:ring-offset-2">
                        Save Changes
                    </button>
                    <a href="{{ route('admin.dashboard') }}" class="btn-ghost rounded-lg px-4 py-2.5">Cancel</a>
                </div>
            </div>
        </div>
    </form>

    @push('scripts')
    <script>
        const fileInput = document.querySelector('input[name="profile_photo"]');
        const photoPreview = document.getElementById('photoPreview');
        if (fileInput && photoPreview) {
            fileInput.addEventListener('change', function () {
                const file = this.files[0];
                if (!file) return;
                const reader = new FileReader();
                reader.onload = function (e) {
                    photoPreview.innerHTML = `<img src="${e.target.result}" alt="Profile photo preview" class="h-32 w-32 rounded-2xl object-cover ring-4 ring-gold-500/20">`;
                };
                reader.readAsDataURL(file);
            });
        }
    </script>
    @endpush
</x-admin.layouts.app>