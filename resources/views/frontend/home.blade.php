<x-frontend.layouts.app :seoTitle="$settings['seo_title'] ?? 'Jinendra Panchal | CA Finalist'">
    {{-- Hero --}}
    <section class="relative overflow-hidden bg-night pt-24 lg:pt-0">
        <div class="absolute inset-0 aurora-bg"></div>
        <div class="absolute inset-0 gst-grid"></div>
        <span aria-hidden="true" class="pointer-events-none absolute left-[8%] top-24 select-none font-display text-6xl font-extrabold text-white/5 animate-float">₹</span>
        <span aria-hidden="true" class="pointer-events-none absolute right-[10%] top-40 select-none font-display text-4xl font-extrabold text-white/5 animate-float-slow">₹</span>
        <span aria-hidden="true" class="pointer-events-none absolute left-[16%] bottom-32 select-none font-display text-7xl font-extrabold text-violet-500/10 animate-float-slow">%</span>
        <span aria-hidden="true" class="pointer-events-none absolute right-[20%] bottom-24 select-none font-display text-5xl font-extrabold text-white/5 animate-float">₹</span>
        <div class="absolute -top-40 -right-40 h-96 w-96 rounded-full bg-violet-600/20 blur-3xl"></div>
        <div class="absolute -bottom-40 -left-40 h-96 w-96 rounded-full bg-navy-500/20 blur-3xl"></div>

        <div class="container-app relative flex min-h-screen flex-col items-center justify-center py-16 lg:flex-row lg:gap-16">
            <div class="max-w-2xl text-center lg:text-left" data-reveal="fade">
                <p class="mb-4 mt-12 inline-flex items-center gap-2 rounded-full border border-violet-400/30 bg-violet-500/10 px-4 py-1.5 text-sm font-medium text-violet-300">
                    <span class="h-2 w-2 animate-pulse rounded-full bg-violet-400"></span>
                    {{ $profile?->career_objective ? 'Open to professional opportunities' : 'Currently pursuing CA Final' }}
                </p>
                <h1 class="font-display text-4xl font-bold leading-tight text-white md:text-5xl lg:text-6xl">
                    {{ $profile?->user?->name ?? 'Jinendra Panchal' }}
                </h1>
                <p class="mt-3 font-display text-xl font-semibold text-transparent md:text-2xl">
                    <span class="bg-gradient-to-r from-violet-300 via-violet-400 to-violet-200 bg-clip-text text-transparent">
                        {{ $profile?->professional_title ?? 'CA Finalist | Accounting, Audit & Taxation Professional' }}
                    </span>
                </p>
                <p class="mt-6 max-w-xl text-base leading-relaxed text-slate-300 md:text-lg">
                    {{ $profile?->short_intro ?? 'Aspiring Chartered Accountant with a strong foundation in accounting, audit, and taxation. Currently pursuing CA Final while gaining practical experience through Articleship.' }}
                </p>

                <div class="mt-8 flex flex-wrap justify-center gap-3 lg:justify-start">
                    <a href="{{ route('experience') }}" class="rounded-lg bg-gradient-to-r from-violet-500 to-violet-700 px-6 py-3 text-sm font-semibold text-white shadow-lg shadow-violet-700/30 transition-all hover:-translate-y-0.5 hover:from-violet-400 hover:to-violet-600">
                        View Experience
                    </a>
                    <a href="{{ route('contact') }}" class="rounded-lg border border-white/20 bg-night/5 px-6 py-3 text-sm font-semibold text-white backdrop-blur transition-all hover:bg-night/10">
                        Contact Me
                    </a>
                </div>

                @if ($profile?->years_of_experience || $profile?->clients_count)
                    <div class="mt-10 grid max-w-md grid-cols-2 gap-4">
                        @if ($profile?->years_of_experience)
                            <div class="rounded-xl border border-violet-400/20 bg-violet-500/5 px-5 py-3 text-center backdrop-blur transition-all hover:border-violet-400/40 lg:text-left">
                                <p class="font-display text-2xl font-bold text-violet-300">
                                    <span data-count-to="{{ $profile->years_of_experience }}" data-count-suffix="+">0+</span>
                                </p>
                                <p class="text-xs font-medium text-slate-400">Years of Experience</p>
                            </div>
                        @endif
                        @if ($profile?->clients_count)
                            <div class="rounded-xl border border-violet-400/20 bg-violet-500/5 px-5 py-3 text-center backdrop-blur transition-all hover:border-violet-400/40 lg:text-left">
                                <p class="font-display text-2xl font-bold text-violet-300">
                                    <span data-count-to="{{ $profile->clients_count }}" data-count-suffix="+">0+</span>
                                </p>
                                <p class="text-xs font-medium text-slate-400">Clients Served</p>
                            </div>
                        @endif
                    </div>
                @endif
            </div>

            <div class="mt-12 lg:mt-0" data-reveal="zoom">
                <div class="relative">
                    <div class="absolute -inset-4 rounded-3xl bg-gradient-to-br from-violet-500/30 to-navy-500/20 blur-lg"></div>
                    <div class="relative overflow-hidden rounded-3xl border border-violet-400/20 shadow-2xl">
                        @php $heroPath = $settings['hero_image'] ?? null; @endphp
                        @if ($heroPath)
                            <img src="{{ Storage::url($heroPath) }}" alt="{{ $profile?->user?->name ?? 'Portfolio' }}" class="h-80 w-full object-cover md:h-96">
                        @else
                            <img src="{{ asset('images/gst-hero.svg') }}" alt="GST & Tax Illustration" class="h-80 w-full object-cover md:h-96">
                        @endif
                    </div>

                    <div class="absolute -right-3 -top-3 rounded-2xl border border-violet-400/30 bg-night/90 px-4 py-2.5 text-center shadow-xl backdrop-blur animate-float">
                        <p class="bg-gradient-to-r from-violet-300 to-violet-500 bg-clip-text font-display text-2xl font-bold text-transparent">GST</p>
                        <p class="text-[10px] font-medium uppercase tracking-wider text-slate-400">Expert</p>
                    </div>
                    <div class="absolute -bottom-4 -left-3 rounded-2xl border border-white/10 bg-night/90 px-4 py-2.5 text-center shadow-xl backdrop-blur animate-float-slow">
                        <p class="font-display text-2xl font-bold text-violet-400">₹</p>
                        <p class="text-[10px] font-medium uppercase tracking-wider text-slate-400">Tax Planning</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- Resume strip --}}
    @if (!empty($profile?->resume_path))
        <section class="border-b border-white/5 bg-ink">
            <div class="container-app flex flex-col items-center justify-between gap-4 py-6 sm:flex-row">
                <div class="flex items-center gap-4 text-center sm:text-left">
                    <div class="flex h-12 w-12 shrink-0 items-center justify-center rounded-xl bg-violet-50 text-violet-600">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-6 w-6">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m6.75 12l-3-3m0 0l-3 3m3-3v6m-1.5-15H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z" />
                        </svg>
                    </div>
                    <div>
                        <p class="text-sm font-display font-semibold text-white">My Professional Resume</p>
                        <p class="text-xs text-slate-400">Download a copy of my latest resume.</p>
                    </div>
                </div>
                <div class="flex flex-wrap justify-center gap-3">
                    <a href="{{ route('resume.download') }}" class="inline-flex items-center gap-2 rounded-lg bg-gradient-to-r from-navy-900 to-navy-700 px-5 py-2.5 text-sm font-semibold text-white transition-all hover:from-navy-800 hover:to-navy-600 hover:shadow-lg hover:shadow-navy-900/20">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-4 w-4">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75V16.5M16.5 12L12 16.5m0 0L7.5 12m4.5 4.5V3" />
                        </svg>
                        Download Resume
                    </a>
                </div>
            </div>
        </section>
    @endif

    {{-- Qualification highlights --}}
    @if ($qualifications->isNotEmpty())
        <section class="bg-night py-16 md:py-20">
            <div class="container-app">
                <x-frontend.section-heading
                    eyebrow="Qualifications"
                    title="Professional Qualification"
                    description="Strong academic foundation built through the Chartered Accountancy journey and commerce studies."
                />
                <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-4" data-reveal-stagger="90">
                    @foreach ($qualifications as $qualification)
                        <div class="group relative overflow-hidden rounded-2xl border border-white/10 bg-night/5 p-6 shadow-lg backdrop-blur transition-all duration-300 hover:-translate-y-1 hover:border-violet-400/50 hover:bg-night/10 hover:shadow-2xl hover:shadow-violet-900/40 hv-pop" data-reveal="zoom">
                            <div class="absolute -right-6 -top-6 h-20 w-20 rounded-full bg-violet-500/10 transition-all group-hover:scale-125"></div>
                            <div class="mb-4 flex h-12 w-12 items-center justify-center rounded-xl bg-gradient-to-br from-violet-600 to-violet-800 text-white shadow-lg shadow-violet-600/20">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-6 w-6">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M4.26 10.147a60.438 60.438 0 00-.491 6.347A48.62 48.62 0 0112 20.904a48.62 48.62 0 018.232-4.41 60.46 60.46 0 00-.491-6.347m-15.482 0a50.636 50.636 0 00-2.658-.813A59.906 59.906 0 0112 3.493a59.903 59.903 0 0110.399 5.84c-.896.248-1.783.52-2.658.814m-15.482 0A50.717 50.717 0 0112 13.489a50.702 50.702 0 017.74-3.342M6.75 15a.75.75 0 100-1.5.75.75 0 000 1.5zm0 0v-3.675A55.378 55.378 0 0112 8.443m-7.007 11.55A5.981 5.981 0 006.75 15.75v-1.5" />
                                </svg>
                            </div>
                            <h3 class="font-display text-base font-semibold text-white">{{ $qualification->name }}</h3>
                            @if ($qualification->institution)
                                <p class="mt-1 text-xs text-slate-400">{{ $qualification->institution }}</p>
                            @endif
                            <span class="mt-3 inline-flex rounded-full px-3 py-1 text-xs font-semibold
                                {{ $qualification->status === 'completed' ? 'bg-green-500/15 text-green-300' : '' }}
                                {{ $qualification->status === 'pursuing' ? 'bg-blue-500/15 text-blue-300' : '' }}
                                {{ $qualification->status === 'cleared' ? 'bg-emerald-500/15 text-emerald-300' : '' }}">
                                {{ $qualification->status_label }}
                            </span>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>
    @endif

    {{-- About preview --}}
    @if (!empty($profile?->about_me) || !empty($profile?->career_objective))
        <section class="bg-ink py-16 md:py-20">
            <div class="container-app grid grid-cols-1 items-center gap-12 lg:grid-cols-2">
                <div data-reveal="left">
                    <x-frontend.section-heading eyebrow="About Me" title="A Journey Toward Chartered Accountancy" align="left" description="{{ $profile?->professional_title ?? 'CA Finalist | Accounting, Audit & Taxation' }}" />
                    <div class="space-y-4 text-base leading-relaxed text-slate-300">
                        @if (!empty($profile?->about_me))
                            @php $aboutParagraphs = preg_split('/\n+/', $profile->about_me); @endphp
                            @foreach (array_slice($aboutParagraphs, 0, 2) as $paragraph)
                                <p>{{ $paragraph }}</p>
                            @endforeach
                        @endif
                        @if (!empty($profile?->career_objective))
                            <div class="rounded-xl border-l-4 border-violet-500 bg-night p-5 shadow-sm">
                                <p class="text-sm font-display font-semibold uppercase tracking-wider text-violet-700">Career Objective</p>
                                <p class="mt-1 text-slate-300">{{ $profile->career_objective }}</p>
                            </div>
                        @endif
                    </div>
                    <a href="{{ route('about') }}" class="mt-6 inline-flex items-center gap-2 text-sm font-semibold text-violet-700 hover:text-violet-900">
                        Read More About Me
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-4 w-4">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3" />
                        </svg>
                    </a>
                </div>

                <div class="grid grid-cols-2 gap-4" data-reveal-stagger="100">
                    @foreach ($qualifications->take(4) as $qualification)
                        <div class="rounded-xl border border-white/10 bg-night/5 p-5 text-center shadow-lg backdrop-blur transition-all duration-300 hover:-translate-y-1 hover:border-violet-400/50 hover:bg-night/10 hover:shadow-2xl hover:shadow-violet-900/40 hv-pop" data-reveal="zoom">
                            <p class="text-3xl font-semibold text-violet-600">
                                {{ $qualification->status === 'completed' ? '✓' : ($qualification->status === 'cleared' ? '★' : '◉') }}
                            </p>
                            <p class="mt-1 text-sm font-medium text-slate-300">{{ $qualification->name }}</p>
                            <p class="text-xs text-slate-400">{{ $qualification->status_label }}</p>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>
    @endif

    @include('frontend.partials.why-choose-us')

    {{-- Areas of expertise --}}
    @if ($skills->isNotEmpty())
        <section class="bg-night py-16 md:py-20">
            <div class="container-app">
                <x-frontend.section-heading
                    eyebrow="Expertise"
                    title="Areas of Expertise"
                    description="Professional skills developed through the CA curriculum and hands-on Articleship experience."
                />
                <div class="grid grid-cols-1 gap-6 md:grid-cols-2 lg:grid-cols-3" data-reveal-stagger="90">
                    @foreach ($skills as $category)
                        <div class="rounded-2xl border border-white/10 bg-night/5 p-6 shadow-lg backdrop-blur transition-all duration-300 hover:-translate-y-1 hover:border-violet-400/50 hover:bg-night/10 hover:shadow-2xl hover:shadow-violet-900/40 hv-tilt" data-reveal="right">
                            <h3 class="flex items-center gap-3 font-display text-base font-semibold text-white">
                                <span class="flex h-10 w-10 items-center justify-center rounded-lg bg-violet-100 text-violet-700">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-5 w-5">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M11.42 15.17L17.25 21A2.652 2.652 0 0021 17.25l-5.877-5.877M11.42 15.17l2.496-3.03c.317-.384.74-.626 1.208-.766M11.42 15.17l-4.655 5.653a2.548 2.548 0 11-3.586-3.586l6.837-5.63m5.108-.233c.55-.164 1.163-.188 1.743-.14a4.5 4.5 0 004.486-6.336l-3.276 3.277a3.004 3.004 0 01-2.25-2.25l3.276-3.276a4.5 4.5 0 00-6.336 4.486c.091 1.076-.071 2.264-.904 2.95l-.102.085m-1.745 1.437L5.909 7.5H4.5L2.25 3.75l1.5-1.5L7.5 4.5v1.409l4.26 4.26m-1.745 1.437l1.745-1.437m6.615 8.206L15.75 15.75M4.867 19.125h.008v.008h-.008v-.008z" />
                                    </svg>
                                </span>
                                {{ $category->name }}
                            </h3>
                            <ul class="mt-4 space-y-2">
                                @forelse ($category->skills->take(5) as $skill)
                                    <li class="flex items-center gap-2 text-sm text-slate-300">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="h-4 w-4 shrink-0 text-violet-600">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5" />
                                        </svg>
                                        {{ $skill->name }}
                                    </li>
                                @empty
                                    <li class="text-sm text-slate-400">Skills will appear here once added.</li>
                                @endforelse
                            </ul>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>
    @endif

    {{-- Services --}}
    @if ($services->isNotEmpty())
        <section class="relative overflow-hidden bg-night py-16 md:py-24">
            <div class="absolute inset-0 aurora-bg"></div>
            <div class="absolute inset-0 gst-grid"></div>
            <span aria-hidden="true" class="pointer-events-none absolute -left-8 top-10 select-none font-display text-8xl font-extrabold text-white/5 animate-float">₹</span>
            <span aria-hidden="true" class="pointer-events-none absolute right-10 bottom-10 select-none font-display text-6xl font-extrabold text-white/5 animate-float-slow">%</span>
            <div class="container-app relative">
                <div class="mx-auto mb-12 max-w-2xl text-center" data-reveal="fade">
                    <p class="mb-3 inline-flex items-center gap-2 text-sm font-semibold uppercase tracking-widest text-violet-300">
                        <span class="inline-block h-px w-6 bg-violet-400"></span>
                        Services
                        <span class="inline-block h-px w-6 bg-violet-400"></span>
                    </p>
                    <h2 class="font-display text-3xl font-bold text-white md:text-4xl"><span class="text-shine">Professional Services</span></h2>
                    <p class="mt-4 text-base leading-relaxed text-slate-300">Expert assistance and support across core finance, taxation and compliance domains.</p>
                </div>
                <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-3" data-reveal-stagger="90">
                    @foreach ($services as $service)
                        <div class="group relative overflow-hidden rounded-2xl border border-white/10 bg-night/5 p-6 backdrop-blur transition-all hover:-translate-y-1 hover:border-violet-400/40 hover:bg-night/10 hover:shadow-xl hover:shadow-violet-600/10 hv-sheen hv-icon" data-reveal="zoom">
                            <div class="absolute -right-8 -top-8 h-24 w-24 rounded-full bg-violet-500/10 blur-2xl transition-all group-hover:scale-150"></div>
                            <div class="mb-4 flex h-12 w-12 items-center justify-center rounded-xl bg-gradient-to-br from-violet-500 to-violet-700 text-white shadow-lg shadow-violet-600/30">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-6 w-6">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="@php
                                        $icons = [
                                            'calculator' => 'M15.75 15.75V18m-7.5-6.75h.008v.008H8.25v-.008zm0 2.25h.008v.008H8.25V13.5zm0 2.25h.008v.008H8.25v-.008zm0 2.25h.008v.008H8.25V18zm2.498-6.75h.007v.008h-.007v-.008zm0 2.25h.007v.008h-.007V13.5zm0 2.25h.007v.008h-.007v-.008zm0 2.25h.007v.008h-.007V18zm2.504-6.75h.008v.008h-.008v-.008zm0 2.25h.008v.008h-.008V13.5zm0 2.25h.008v.008h-.008v-.008zm0 2.25h.008v.008h-.008V18zm2.498-6.75h.008v.008h-.008v-.008zm0 2.25h.008v.008h-.008V13.5zM8.25 6h7.5v2.25h-7.5V6zM12 2.25c-1.892 0-3.758.11-5.593.322C5.307 2.7 4.5 3.65 4.5 4.757V19.5a2.25 2.25 0 002.25 2.25h10.5a2.25 2.25 0 002.25-2.25V4.757c0-1.108-.806-2.057-1.907-2.185A48.507 48.507 0 0012 2.25z',
                                            'clipboard-document-check' => 'M11.35 3.836c-.065.21-.1.433-.1.664 0 .414.336.75.75.75h4.5a.75.75 0 00.75-.75 2.25 2.25 0 00-.1-.664m-5.8 0A2.251 2.251 0 0113.5 2.25H15c1.012 0 1.867.668 2.15 1.586m-5.8 0c-.376.023-.75.05-1.124.08C9.095 4.01 8.25 4.973 8.25 6.108V8.25m8.9-4.414c.376.023.75.05 1.124.08 1.131.094 1.976 1.057 1.976 2.192V16.5A2.25 2.25 0 0118 18.75h-2.25m-7.5-10.5H4.875c-.621 0-1.125.504-1.125 1.125v11.25c0 .621.504 1.125 1.125 1.125h9.75c.621 0 1.125-.504 1.125-1.125V18.75m-7.5-10.5h6.375c.621 0 1.125.504 1.125 1.125v9.375m-4.5-7.875h.008v.008h-.008v-.008zm0 2.25h.008v.008h-.008v-.008zm0 2.25h.008v.008h-.008v-.008z',
                                            'document-text' => 'M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z',
                                            'receipt-percent' => 'M9 14.25l6-6m4.5-3.493V21.75l-3.75-1.5-3.75 1.5-3.75-1.5-3.75 1.5V4.757c0-1.108.806-2.057 1.907-2.185a48.507 48.507 0 0111.186 0c1.1.128 1.907 1.077 1.907 2.185zM9.75 9h.008v.008H9.75V9zm.375 0a.375.375 0 11-.75 0 .375.375 0 01.75 0zm4.125 4.5h.008v.008h-.008V13.5zm.375 0a.375.375 0 11-.75 0 .375.375 0 01.75 0z',
                                            'currency-rupee' => 'M15 8.25H9m6 3H9m3.75-3.75c.033.994.608 3.75 1.875 3.75L15.75 15M9 8.25H6.75m8.25 0a4.5 4.5 0 01-1.5 8.25M9 8.25H6.75L9 3.75H13.5M12 21a9 9 0 100-18 9 9 0 000 18z',
                                            'chart-bar' => 'M3 13.125C3 12.504 3.504 12 4.125 12h2.25c.621 0 1.125.504 1.125 1.125v6.75C7.5 20.496 6.996 21 6.375 21h-2.25A1.125 1.125 0 013 19.875v-6.75zM9.75 8.625c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125v11.25c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 01-1.125-1.125V8.625zM16.5 4.125c0-.621.504-1.125 1.125-1.125h2.25C20.496 3 21 3.504 21 4.125v15.75c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 01-1.125-1.125V4.125z',
                                        ];
                                        echo $icons[$service->icon] ?? 'M9.813 15.904L9 18.75l-.813-2.846a4.5 4.5 0 00-3.09-3.09L2.25 12l2.846-.813a4.5 4.5 0 003.09-3.09L9 5.25l.813 2.846a4.5 4.5 0 003.09 3.09L15.75 12l-2.846.813a4.5 4.5 0 00-3.09 3.09z';
                                    @endphp" />
                                </svg>
                            </div>
                            <h3 class="font-display text-base font-semibold text-white">{{ $service->title }}</h3>
                            <p class="mt-2 text-sm leading-relaxed text-slate-300">{{ $service->short_description }}</p>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>
    @endif

    {{-- Professional assignments preview --}}
    @if ($assignments->isNotEmpty())
        <section class="bg-ink py-16 md:py-20">
            <div class="container-app">
                <x-frontend.section-heading
                    eyebrow="Portfolio"
                    title="Professional Assignments"
                    description="A selection of professional work and assignments undertaken, showcased without revealing confidential client information."
                />
                <div class="grid grid-cols-1 gap-6 md:grid-cols-2 lg:grid-cols-3" data-reveal-stagger="90">
                    @foreach ($assignments as $assignment)
                        <a href="{{ route('assignments.show', $assignment) }}" class="group overflow-hidden rounded-2xl border border-white/10 bg-night/5 shadow-lg backdrop-blur transition-all duration-300 hover:-translate-y-1 hover:border-violet-400/50 hover:bg-night/10 hover:shadow-2xl hover:shadow-violet-900/40 hv-tilt" data-reveal="left">
                            @if (!empty($assignment->image_path))
                                <div class="aspect-video overflow-hidden">
                                    <img src="{{ $assignment->image_url }}" alt="{{ $assignment->title }}" class="h-full w-full object-cover transition-transform duration-300 group-hover:scale-105">
                                </div>
                            @else
                                <div class="flex aspect-video items-center justify-center bg-gradient-to-br from-navy-900 to-violet-900">
                                    <span class="rounded-xl bg-violet-500/15 px-4 py-2 text-sm font-semibold text-violet-300">{{ $assignment->category ?? 'Professional Assignment' }}</span>
                                </div>
                            @endif
                            <div class="p-6">
                                <span class="text-xs font-semibold uppercase tracking-wider text-violet-600">{{ $assignment->category ?? 'Professional Work' }}</span>
                                <h3 class="mt-2 font-display text-base font-semibold text-white transition-colors group-hover:text-violet-700">{{ $assignment->title }}</h3>
                                <p class="mt-2 line-clamp-2 text-sm text-slate-300">{{ $assignment->short_description }}</p>
                            </div>
                        </a>
                    @endforeach
                </div>
                <div class="mt-10 text-center" data-reveal="fade">
                    <a href="{{ route('assignments') }}" class="inline-flex items-center gap-2 rounded-lg border border-white/25 px-6 py-3 text-sm font-semibold text-white transition-all hover:border-violet-400 hover:bg-violet-500/10 hover:text-violet-200">
                        View All Assignments
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-4 w-4">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3" />
                        </svg>
                    </a>
                </div>
            </div>
        </section>
    @endif

    {{-- Testimonials preview --}}
    @if ($testimonials->isNotEmpty())
        <section class="bg-night py-16 md:py-20">
            <div class="container-app">
                <x-frontend.section-heading
                    eyebrow="Testimonials"
                    title="What People Say"
                    description="Kind words from clients and professionals I've worked with."
                />

                <div class="relative mx-auto mt-12 max-w-3xl" data-carousel>
                    <div class="overflow-hidden rounded-2xl">
                        <div class="flex transition-transform duration-500 ease-out" data-carousel-track>
                            @foreach ($testimonials as $testimonial)
                                <div class="w-full shrink-0 px-1">
                                    <div class="flex h-full flex-col items-center justify-between gap-6 rounded-2xl border border-white/10 bg-night/5 px-6 py-10 text-center md:px-12 hv-lift" data-reveal="zoom">
                                        <div>
                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="mx-auto h-8 w-8 text-violet-400">
                                                <path d="M4.583 17.321C3.553 16.227 3 15 3 13.011c0-3.5 2.457-6.637 6.03-8.188l.893 1.378c-3.335 1.804-3.987 4.145-4.247 5.621.537-.278 1.24-.375 1.929-.311 1.804.167 3.226 1.648 3.226 3.489a3.5 3.5 0 01-3.5 3.5c-1.073 0-2.099-.49-2.748-1.179zm10 0C13.553 16.227 13 15 13 13.011c0-3.5 2.457-6.637 6.03-8.188l.893 1.378c-3.335 1.804-3.987 4.145-4.247 5.621.537-.278 1.24-.375 1.929-.311 1.804.167 3.226 1.648 3.226 3.489a3.5 3.5 0 01-3.5 3.5c-1.073 0-2.099-.49-2.748-1.179z" />
                                            </svg>
                                            <div class="mt-4 flex items-center justify-center gap-1 text-violet-500">
                                                @for ($i = 1; $i <= 5; $i++)
                                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" class="h-4 w-4 {{ $i <= ($testimonial->rating ?? 0) ? 'fill-current' : 'fill-slate-200' }}">
                                                        <path d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.196-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z" />
                                                    </svg>
                                                @endfor
                                            </div>
                                            <p class="mx-auto mt-4 max-w-2xl text-base leading-relaxed text-slate-300 md:text-lg">"{{ $testimonial->message }}"</p>
                                        </div>
                                        <div class="flex items-center gap-3 border-t border-white/10 pt-5">
                                            @if ($testimonial->photo)
                                                <img src="{{ $testimonial->photo_url }}" alt="{{ $testimonial->name }}" class="h-11 w-11 shrink-0 rounded-full object-cover">
                                            @else
                                                <span class="flex h-11 w-11 shrink-0 items-center justify-center rounded-full bg-gradient-to-br from-violet-600 to-violet-800 text-sm font-bold text-white">
                                                    {{ strtoupper(substr($testimonial->name, 0, 1)) }}
                                                </span>
                                            @endif
                                            <div class="text-left">
                                                <p class="text-sm font-semibold text-white">{{ $testimonial->name }}</p>
                                                @if ($testimonial->designation || $testimonial->company)
                                                    <p class="text-xs text-slate-400">{{ $testimonial->designation }}@if ($testimonial->designation && $testimonial->company), @endif{{ $testimonial->company }}</p>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <button type="button" data-carousel-prev aria-label="Previous testimonial"
                        class="absolute top-1/2 -left-3 flex h-11 w-11 -translate-y-1/2 items-center justify-center rounded-full bg-gradient-to-br from-violet-600 to-violet-800 text-white shadow-lg transition-all hover:from-violet-500 hover:to-violet-700 disabled:cursor-not-allowed disabled:opacity-35 md:-left-5">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="h-5 w-5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5L8.25 12l7.5-7.5" />
                        </svg>
                    </button>
                    <button type="button" data-carousel-next aria-label="Next testimonial"
                        class="absolute top-1/2 -right-3 flex h-11 w-11 -translate-y-1/2 items-center justify-center rounded-full bg-gradient-to-br from-violet-600 to-violet-800 text-white shadow-lg transition-all hover:from-violet-500 hover:to-violet-700 disabled:cursor-not-allowed disabled:opacity-35 md:-right-5">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="h-5 w-5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5" />
                        </svg>
                    </button>
                </div>

                <div class="mt-10 text-center" data-reveal="fade">
                    <a href="{{ route('testimonials') }}" class="inline-flex items-center gap-2 text-sm font-semibold text-violet-700 hover:text-violet-900">
                        View All Testimonials
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-4 w-4">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3" />
                        </svg>
                    </a>
                </div>
            </div>
        </section>
    @endif

    {{-- Contact preview --}}
    <section class="bg-night py-16 md:py-20">
        <div class="container-app">
            <x-frontend.section-heading
                eyebrow="Contact"
                title="Let's Stay Connected"
                description="Feel free to reach out for professional discussions, collaboration, or opportunities."
            />
            <div class="grid grid-cols-1 gap-6 md:grid-cols-3" data-reveal-stagger="90">
                @if (!empty($settings['contact_email']))
                    <a href="mailto:{{ $settings['contact_email'] }}" class="rounded-2xl border border-white/10 bg-night/5 p-6 text-center shadow-lg backdrop-blur transition-all duration-300 hover:-translate-y-1 hover:border-violet-400/50 hover:bg-night/10 hover:shadow-2xl hover:shadow-violet-900/40 hv-lift" data-reveal="left">
                        <div class="mx-auto mb-4 flex h-12 w-12 items-center justify-center rounded-xl bg-violet-50 text-violet-700">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-6 w-6">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M21.75 6.75v10.5a2.25 2.25 0 01-2.25 2.25h-15a2.25 2.25 0 01-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25m19.5 0v.243a2.25 2.25 0 01-1.07 1.916l-7.5 4.615a2.25 2.25 0 01-2.36 0L3.32 8.91a2.25 2.25 0 01-1.07-1.916V6.75" />
                            </svg>
                        </div>
                        <p class="text-sm font-display font-semibold uppercase tracking-wider text-slate-400">Email</p>
                        <p class="mt-1 break-all text-sm text-slate-100">{{ $settings['contact_email'] }}</p>
                    </a>
                @endif
                @if (!empty($settings['contact_phone']))
                    <a href="tel:{{ preg_replace('/[^0-9+]/', '', $settings['contact_phone']) }}" class="rounded-2xl border border-white/10 bg-night/5 p-6 text-center shadow-lg backdrop-blur transition-all duration-300 hover:-translate-y-1 hover:border-violet-400/50 hover:bg-night/10 hover:shadow-2xl hover:shadow-violet-900/40 hv-glow" data-reveal="right">
                        <div class="mx-auto mb-4 flex h-12 w-12 items-center justify-center rounded-xl bg-violet-50 text-violet-700">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-6 w-6">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 6.75c0 8.284 6.716 15 15 15h2.25a2.25 2.25 0 002.25-2.25v-1.372c0-.516-.351-.966-.852-1.091l-4.423-1.106c-.44-.11-.902.055-1.173.417l-.97 1.293c-.282.376-.769.542-1.21.38a12.035 12.035 0 01-7.143-7.143c-.162-.441.004-.928.38-1.21l1.293-.97c.363-.271.527-.734.417-1.173L6.963 3.102a1.125 1.125 0 00-1.091-.852H4.5A2.25 2.25 0 002.25 4.5v2.25z" />
                            </svg>
                        </div>
                        <p class="text-sm font-display font-semibold uppercase tracking-wider text-slate-400">Phone</p>
                        <p class="mt-1 text-sm text-slate-100">{{ $settings['contact_phone'] }}</p>
                    </a>
                @endif
                @if (!empty($settings['contact_location']))
                    <div class="rounded-2xl border border-white/10 bg-night/5 p-6 text-center shadow-lg backdrop-blur transition-all duration-300 hover:-translate-y-1 hover:border-violet-400/50 hover:bg-night/10 hover:shadow-2xl hover:shadow-violet-900/40 hv-pop" data-reveal="zoom">
                        <div class="mx-auto mb-4 flex h-12 w-12 items-center justify-center rounded-xl bg-violet-50 text-violet-700">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-6 w-6">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 11-6 0 3 3 0 016 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1115 0z" />
                            </svg>
                        </div>
                        <p class="text-sm font-display font-semibold uppercase tracking-wider text-slate-400">Location</p>
                        <p class="mt-1 text-sm text-slate-100">{{ $settings['contact_location'] }}</p>
                    </div>
                @endif
            </div>
        </div>
    </section>
</x-frontend.layouts.app>