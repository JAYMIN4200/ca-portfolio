<x-frontend.layouts.app :seoTitle="'About Me | ' . ($settings['site_name'] ?? 'Jinendra Panchal')">
    @php
        $handles = $profile?->socialHandles() ?? [];
        $handleIcons = [
            'instagram' => 'M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838a6.162 6.162 0 100 12.324 6.162 6.162 0 000-12.324zm0 10.162a4 4 0 110-8 4 4 0 010 8zm6.406-11.845a1.44 1.44 0 100 2.881 1.44 1.44 0 000-2.881z',
            'facebook' => 'M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z',
            'twitter' => 'M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z',
            'telegram' => 'M11.944 0A12 12 0 000 12a12 12 0 0012 12 12 12 0 0012-12A12 12 0 0012 0a12 12 0 00-.056 0zm4.962 7.224c.1-.002.321.023.465.14a.506.506 0 01.171.325c.016.093.036.306.02.472-.18 1.898-.962 6.502-1.36 8.627-.168.9-.499 1.201-.82 1.23-.696.065-1.225-.46-1.9-.902-1.056-.693-1.653-1.124-2.678-1.8-1.185-.78-.417-1.21.258-1.91.177-.184 3.247-2.977 3.307-3.23.007-.032.014-.15-.056-.212s-.174-.041-.249-.024c-.106.024-1.793 1.14-5.061 3.345-.48.33-.913.49-1.302.48-.428-.008-1.252-.241-1.865-.44-.752-.245-1.349-.374-1.297-.789.027-.216.325-.437.893-.663 3.498-1.524 5.83-2.529 6.998-3.014 3.332-1.386 4.025-1.627 4.476-1.635z',
            'linkedin' => 'M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433a2.062 2.062 0 01-2.063-2.065 2.064 2.064 0 112.063 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.225 0z',
            'github' => 'M12 .297c-6.63 0-12 5.373-12 12 0 5.303 3.438 9.8 8.205 11.385.6.113.82-.258.82-.577 0-.285-.01-1.04-.015-2.04-3.338.724-4.042-1.61-4.042-1.61C4.422 18.07 3.633 17.7 3.633 17.7c-1.087-.744.084-.729.084-.729 1.205.084 1.838 1.236 1.838 1.236 1.07 1.835 2.809 1.305 3.495.998.108-.776.417-1.305.76-1.605-2.665-.3-5.466-1.332-5.466-5.93 0-1.31.465-2.38 1.235-3.22-.135-.303-.54-1.523.105-3.176 0 0 1.005-.322 3.3 1.23.96-.267 1.98-.399 3-.405 1.02.006 2.04.138 3 .405 2.28-1.552 3.285-1.23 3.285-1.23.645 1.653.24 2.873.12 3.176.765.84 1.23 1.91 1.23 3.22 0 4.61-2.805 5.625-5.475 5.92.42.36.81 1.096.81 2.22 0 1.606-.015 2.896-.015 3.286 0 .315.21.69.825.57C20.565 22.092 24 17.592 24 12.297c0-6.627-5.373-12-12-12',
            'whatsapp' => 'M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z',
        ];
    @endphp
    <x-frontend.page-header
        eyebrow="About Me"
        title="The Professional Behind the Portfolio"
        description="{{ $profile?->short_intro ?? 'Aspiring Chartered Accountant pursuing CA Final with practical Articleship experience.' }}"
    />

    @if ($profile?->years_of_experience || $profile?->clients_count)
        <section class="border-b border-white/5 bg-ink">
            <div class="container-app grid grid-cols-2 gap-6 py-10 lg:grid-cols-4" data-reveal-stagger="100">
                @if ($profile?->years_of_experience)
                    <div class="text-center" data-reveal="down">
                        <p class="font-display text-3xl font-semibold text-white md:text-4xl"><span data-count-to="{{ $profile->years_of_experience }}" data-count-suffix="+">0+</span></p>
                        <p class="mt-1 text-sm font-medium text-slate-400">Years of Experience</p>
                    </div>
                @endif
                @if ($profile?->clients_count)
                    <div class="text-center" data-reveal="down">
                        <p class="font-display text-3xl font-semibold text-white md:text-4xl"><span data-count-to="{{ $profile->clients_count }}" data-count-suffix="+">0+</span></p>
                        <p class="mt-1 text-sm font-medium text-slate-400">Clients Served</p>
                    </div>
                @endif
                @if ($qualifications->isNotEmpty())
                    <div class="text-center" data-reveal="down">
                        <p class="font-display text-3xl font-semibold text-white md:text-4xl"><span data-count-to="{{ $qualifications->count() }}">0</span></p>
                        <p class="mt-1 text-sm font-medium text-slate-400">Qualifications</p>
                    </div>
                @endif
                <div class="text-center" data-reveal="down">
                    <p class="font-display text-3xl font-semibold text-white md:text-4xl"><span data-count-to="100" data-count-suffix="%">0%</span></p>
                    <p class="mt-1 text-sm font-medium text-slate-400">Commitment</p>
                </div>
            </div>
        </section>
    @endif

    <section class="bg-night py-16 md:py-20">
        <div class="container-app grid grid-cols-1 gap-12 lg:grid-cols-3">
            <div class="lg:col-span-2">
                <div class="space-y-6 text-base leading-relaxed text-slate-300">
                    @if (!empty($profile?->about_me))
                        @foreach (preg_split('/\n+/', $profile->about_me) as $paragraph)
                            <p>{{ $paragraph }}</p>
                        @endforeach
                    @else
                        <p>
                            As a CA Finalist with a strong foundation in Accounting, Audit and Taxation, I am currently pursuing
                            the CA Final examination while completing my Articleship — the practical training that forms the
                            heart of the Chartered Accountancy course.
                        </p>
                        <p>
                            Having cleared the CA Intermediate examination, I have built a comprehensive understanding of
                            financial accounting, auditing standards, taxation and corporate laws. My Articleship has given
                            me hands-on exposure to real-world financial processes and compliance requirements.
                        </p>
                    @endif
                </div>

                @if (!empty($profile?->career_objective))
                    <div class="mt-8 rounded-2xl border-l-4 border-violet-500 bg-night/5 p-6 backdrop-blur">
                        <p class="text-sm font-semibold uppercase tracking-wider text-violet-700">Career Objective</p>
                        <p class="mt-2 text-slate-300">{{ $profile->career_objective }}</p>
                    </div>
                @endif

                @if (!empty($settings['mission']) || !empty($settings['vision']))
                    <div class="mt-10 grid grid-cols-1 gap-6 sm:grid-cols-2" data-reveal-stagger="90">
                        @if (!empty($settings['mission']))
                            <div class="rounded-2xl border border-white/10 bg-night/5 p-6 shadow-lg backdrop-blur hv-lift" data-reveal="fade">
                                <span class="flex h-11 w-11 items-center justify-center rounded-xl bg-violet-500/15 text-violet-300 ring-1 ring-violet-500/30">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-5 w-5">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 12L3.269 3.126A59.768 59.768 0 0121.485 12 59.77 59.77 0 013.27 20.876L5.999 12zm0 0h7.5" />
                                    </svg>
                                </span>
                                <h2 class="mt-4 text-lg font-semibold text-white">Our Mission</h2>
                                <p class="mt-2 text-sm leading-relaxed text-slate-300">{{ $settings['mission'] }}</p>
                            </div>
                        @endif
                        @if (!empty($settings['vision']))
                            <div class="rounded-2xl border border-white/10 bg-night/5 p-6 shadow-lg backdrop-blur hv-lift" data-reveal="fade">
                                <span class="flex h-11 w-11 items-center justify-center rounded-xl bg-violet-500/15 text-violet-300 ring-1 ring-violet-500/30">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-5 w-5">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178zM15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                    </svg>
                                </span>
                                <h2 class="mt-4 text-lg font-semibold text-white">Our Vision</h2>
                                <p class="mt-2 text-sm leading-relaxed text-slate-300">{{ $settings['vision'] }}</p>
                            </div>
                        @endif
                    </div>
                @endif

                @if ($qualifications->isNotEmpty())
                    <div class="mt-10">
                        <h2 class="mb-6 text-2xl font-semibold text-white">My CA & Academic Journey</h2>
                        <div class="space-y-6" data-reveal-stagger="120">
                            @foreach ($qualifications as $qualification)
                                <div class="relative border-l-2 border-white/10 pl-6" data-reveal="left">
                                    <span class="absolute -left-[9px] top-1 h-4 w-4 rounded-full border-4 border-night bg-violet-500 shadow"></span>
                                    <p class="text-sm font-medium text-violet-600">{{ $qualification->status_label }}</p>
                                    <h3 class="text-lg font-semibold text-white">{{ $qualification->name }}</h3>
                                    @if ($qualification->institution)
                                        <p class="text-sm text-slate-300">{{ $qualification->institution }}</p>
                                    @endif
                                    @if ($qualification->start_year || $qualification->end_year)
                                        <p class="text-xs text-slate-400">
                                            @if ($qualification->start_year) {{ $qualification->start_year }} @endif
                                            @if ($qualification->start_year && $qualification->end_year) — @endif
                                            @if ($qualification->end_year) {{ $qualification->end_year }} @endif
                                        </p>
                                    @endif
                                    @if ($qualification->description)
                                        <p class="mt-2 text-sm leading-relaxed text-slate-300">{{ $qualification->description }}</p>
                                    @endif
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif
            </div>

            <aside class="space-y-6" data-reveal-stagger="120">
                <div class="rounded-2xl border border-white/10 bg-night/5 p-6 shadow-lg backdrop-blur hv-lift" data-reveal="fade">
                    @if (!empty($profile?->profile_photo))
                        <img src="{{ $profile->photo_url }}" alt="{{ $profile->user->name }}" class="mx-auto h-40 w-40 rounded-2xl object-cover">
                    @else
                        <div class="mx-auto flex h-40 w-40 items-center justify-center rounded-2xl bg-gradient-to-br from-violet-600 to-violet-800 font-display text-6xl font-bold text-white ring-1 ring-white/20">
                            {{ strtoupper(substr($profile?->user?->name ?? 'J', 0, 1)) }}
                        </div>
                    @endif
                    <h2 class="mt-4 text-center text-lg font-semibold text-white">{{ $profile?->user?->name }}</h2>
                    <p class="text-center text-sm text-slate-400">{{ $profile?->professional_title }}</p>
                    <a href="{{ route('contact') }}" class="mt-4 block rounded-lg bg-gradient-to-r from-violet-500 to-violet-700 px-4 py-2.5 text-center text-sm font-semibold text-white shadow-lg shadow-violet-700/30 transition-all hover:from-violet-400 hover:to-violet-600 hover:shadow-violet-500/40">
                        Get in Touch
                    </a>
                </div>

                <div class="rounded-2xl border border-white/10 bg-night/5 p-6 shadow-lg backdrop-blur hv-lift" data-reveal="fade">
                    <h3 class="mb-4 text-sm font-semibold uppercase tracking-wider text-slate-400">Professional Interests</h3>
                    <div class="flex flex-wrap gap-2">
                        @foreach (['Accounting', 'Audit', 'Taxation', 'GST', 'Income Tax', 'Financial Reporting', 'Corporate Compliance'] as $interest)
                            <span class="rounded-full border border-white/10 bg-night/10 px-3 py-1.5 text-xs font-medium text-slate-300">{{ $interest }}</span>
                        @endforeach
                    </div>
                </div>

                @if (!empty($profile?->phone) || !empty($profile?->location) || !empty($settings['contact_email']))
                    <div class="rounded-2xl border border-white/10 bg-night/5 p-6 shadow-lg backdrop-blur hv-lift" data-reveal="fade">
                        <h3 class="mb-4 text-sm font-semibold uppercase tracking-wider text-slate-400">Contact Details</h3>
                        <ul class="space-y-3 text-sm">
                            @if (!empty($settings['contact_email']))
                                <li class="flex items-start gap-3">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="mt-0.5 h-4 w-4 shrink-0 text-violet-600">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M21.75 6.75v10.5a2.25 2.25 0 01-2.25 2.25h-15a2.25 2.25 0 01-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25m19.5 0v.243a2.25 2.25 0 01-1.07 1.916l-7.5 4.615a2.25 2.25 0 01-2.36 0L3.32 8.91a2.25 2.25 0 01-1.07-1.916V6.75" />
                                    </svg>
                                    <span class="break-all">{{ $settings['contact_email'] }}</span>
                                </li>
                            @endif
                            @if (!empty($profile?->phone))
                                <li class="flex items-start gap-3">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="mt-0.5 h-4 w-4 shrink-0 text-violet-600">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 6.75c0 8.284 6.716 15 15 15h2.25a2.25 2.25 0 002.25-2.25v-1.372c0-.516-.351-.966-.852-1.091l-4.423-1.106c-.44-.11-.902.055-1.173.417l-.97 1.293c-.282.376-.769.542-1.21.38a12.035 12.035 0 01-7.143-7.143c-.162-.441.004-.928.38-1.21l1.293-.97c.363-.271.527-.734.417-1.173L6.963 3.102a1.125 1.125 0 00-1.091-.852H4.5A2.25 2.25 0 002.25 4.5v2.25z" />
                                    </svg>
                                    <span>{{ $profile->phone }}</span>
                                </li>
                            @endif
                            @if (!empty($profile?->location))
                                <li class="flex items-start gap-3">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="mt-0.5 h-4 w-4 shrink-0 text-violet-600">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 11-6 0 3 3 0 016 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1115 0z" />
                                    </svg>
                                    <span>{{ $profile->location }}</span>
                                </li>
                            @endif
                        </ul>
                    </div>
                @endif

                @if (!empty($handles))
                    <div class="rounded-2xl border border-white/10 bg-night/5 p-6 shadow-lg backdrop-blur hv-lift" data-reveal="fade">
                        <h3 class="mb-4 text-sm font-semibold uppercase tracking-wider text-slate-400">Find Me Online</h3>
                        <div class="grid grid-cols-3 gap-3">
                            @foreach ($handles as $key => $href)
                                <a href="{{ $href }}" target="_blank" rel="noopener noreferrer" aria-label="{{ ucfirst($key) }}"
                                    class="group flex flex-col items-center gap-1.5 rounded-xl border border-white/10 py-3 text-slate-300 transition-all hover:border-violet-400 hover:bg-violet-600 hover:text-white">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="h-5 w-5 text-violet-600 transition-colors group-hover:text-white">
                                        <path d="{{ $handleIcons[$key] ?? '' }}" />
                                    </svg>
                                    <span class="text-[10px] font-semibold uppercase tracking-wide">{{ $key }}</span>
                                </a>
                            @endforeach
                        </div>
                    </div>
                @endif

                <div class="rounded-2xl border border-white/10 bg-night/5 p-6 shadow-lg backdrop-blur hv-lift" data-reveal="fade">
                    <h3 class="mb-4 text-sm font-semibold uppercase tracking-wider text-slate-400">Future Career Goals</h3>
                    <p class="text-sm leading-relaxed text-slate-300">
                        To complete the CA Final examination, qualify as a Chartered Accountant, and continue developing
                        expertise in audit, taxation and financial advisory services while contributing significant value
                        to the profession and the organizations I serve.
                    </p>
                </div>
            </aside>
        </div>
    </section>

    @include('frontend.partials.why-choose-us')
</x-frontend.layouts.app>