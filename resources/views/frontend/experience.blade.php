<x-frontend.layouts.app :seoTitle="'Experience | ' . ($settings['site_name'] ?? 'Jinendra Panchal')">
    <x-frontend.page-header
        eyebrow="Experience"
        title="Articleship Experience"
        description="Practical training and hands-on professional experience gained under the guidance of experienced Chartered Accountants."
    />

    <section class="bg-night py-16 md:py-20">
        <div class="container-app max-w-4xl" data-reveal-stagger="140">
            @forelse ($experiences as $experience)
                <div class="relative mb-10 border-l-2 border-white/10 pl-6 md:pl-8" data-reveal="left">
                    <span class="absolute -left-[11px] top-1 h-5 w-5 rounded-full border-4 border-white bg-violet-500 shadow"></span>

                    <div class="rounded-2xl border border-white/10 bg-night/5 p-6 shadow-lg backdrop-blur md:p-8 hv-glow">
                        <div class="flex flex-wrap items-center gap-3">
                            @if ($experience->is_current)
                                <span class="inline-flex items-center gap-1.5 rounded-full bg-violet-100 px-3 py-1 text-xs font-semibold text-violet-800">
                                    <span class="h-1.5 w-1.5 animate-pulse rounded-full bg-violet-600"></span>
                                    Currently Working
                                </span>
                            @endif
                            <h2 class="text-xl font-semibold text-white">{{ $experience->role }}</h2>
                        </div>

                        @if ($experience->firm_name)
                            <p class="mt-1 text-sm font-semibold text-violet-700">{{ $experience->firm_name }}</p>
                        @endif

                        <p class="mt-2 flex flex-wrap items-center gap-x-2 gap-y-1 text-xs font-medium text-slate-400">
                            <span>{{ $experience->duration }}</span>
                            @if ($experience->location)
                                <span>·</span>
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="inline h-3.5 w-3.5">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 11-6 0 3 3 0 016 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1115 0z" />
                                </svg>
                                <span>{{ $experience->location }}</span>
                            @endif
                        </p>

                        @if ($experience->description)
                            <p class="mt-4 text-sm leading-relaxed text-slate-300">{{ $experience->description }}</p>
                        @endif

                        @if (!empty($experience->responsibilities))
                            <div class="mt-5">
                                <p class="text-xs font-semibold uppercase tracking-wider text-slate-400">Key Responsibilities</p>
                                <ul class="mt-3 grid grid-cols-1 gap-2 md:grid-cols-2">
                                    @foreach ($experience->responsibilities as $responsibility)
                                        <li class="flex items-start gap-2 text-sm text-slate-300">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="mt-0.5 h-4 w-4 shrink-0 text-violet-600">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5" />
                                            </svg>
                                            {{ $responsibility }}
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        @if (!empty($experience->skills_used))
                            <div class="mt-5 flex flex-wrap gap-2">
                                @foreach ($experience->skills_used as $skill)
                                    <span class="rounded-full border border-white/10 bg-white/10 px-3 py-1 text-xs font-medium text-slate-300">{{ $skill }}</span>
                                @endforeach
                            </div>
                        @endif
                    </div>
                </div>
            @empty
                <div class="rounded-2xl border border-white/10 bg-night/5 p-12 text-center">
                    <p class="text-sm text-slate-400">Articleship experience details are being updated. Please check back soon.</p>
                </div>
            @endforelse
        </div>
    </section>
</x-frontend.layouts.app>