<x-frontend.layouts.app :seoTitle="'Skills | ' . ($settings['site_name'] ?? 'Jinendra Panchal')">
    <x-frontend.page-header
        eyebrow="Skills & Expertise"
        title="Professional Skills"
        description="Core competencies developed through the CA curriculum and practical experience in accounting, audit and taxation."
    />

    <section class="bg-night py-16 md:py-20">
        <div class="container-app">
            @forelse ($categories as $category)
                <div class="{{ !$loop->first ? 'mt-16' : '' }}" data-reveal="fade">
                    <div class="mb-8 flex items-center gap-4">
                        <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-violet-500/15 text-violet-300 ring-1 ring-violet-500/30">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-6 w-6">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M11.42 15.17L17.25 21A2.652 2.652 0 0021 17.25l-5.877-5.877M11.42 15.17l2.496-3.03c.317-.384.74-.626 1.208-.766M11.42 15.17l-4.655 5.653a2.548 2.548 0 11-3.586-3.586l6.837-5.63m5.108-.233c.55-.164 1.163-.188 1.743-.14a4.5 4.5 0 004.486-6.336l-3.276 3.277a3.004 3.004 0 01-2.25-2.25l3.276-3.276a4.5 4.5 0 00-6.336 4.486c.091 1.076-.071 2.264-.904 2.95l-.102.085m-1.745 1.437L5.909 7.5H4.5L2.25 3.75l1.5-1.5L7.5 4.5v1.409l4.26 4.26m-1.745 1.437l1.745-1.437m6.615 8.206L15.75 15.75M4.867 19.125h.008v.008h-.008v-.008z" />
                            </svg>
                        </div>
                        <div>
                            <h2 class="text-2xl font-semibold text-white">{{ $category->name }}</h2>
                            @if ($category->skills->isEmpty())
                                <p class="text-sm text-slate-400">Skills will be listed here soon.</p>
                            @endif
                        </div>
                    </div>

                    @if ($category->skills->isNotEmpty())
                        <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-3" data-reveal-stagger="70">
                            @foreach ($category->skills as $skill)
                                <div class="rounded-xl border border-white/10 bg-night/5 p-5 shadow-sm transition-all hover:-translate-y-0.5 hover:shadow-md hv-pop" data-reveal="zoom">
                                    <div class="flex items-center justify-between">
                                        <p class="text-sm font-semibold text-slate-100">{{ $skill->name }}</p>
                                        @if ($skill->proficiency !== null)
                                            <span class="text-xs font-semibold text-violet-600">{{ $skill->proficiency }}%</span>
                                        @endif
                                    </div>
                                    @if ($skill->description)
                                        <p class="mt-1 text-xs text-slate-400">{{ $skill->description }}</p>
                                    @endif
                                    @if ($skill->proficiency !== null)
                                        <div class="mt-3 h-1.5 overflow-hidden rounded-full bg-white/10">
                                            <div class="h-full rounded-full bg-gradient-to-r from-navy-700 to-violet-500" style="width: {{ $skill->proficiency }}%"></div>
                                        </div>
                                    @endif
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            @empty
                <div class="rounded-2xl border border-white/10 bg-night/5 p-12 text-center">
                    <p class="text-sm text-slate-400">Skill details are being updated. Please check back soon.</p>
                </div>
            @endforelse
        </div>
    </section>
</x-frontend.layouts.app>