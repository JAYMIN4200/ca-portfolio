<x-frontend.layouts.app :seoTitle="$caseStudy->title . ' | ' . ($settings['site_name'] ?? 'Jinendra Panchal')" :seoDescription="$caseStudy->summary">
    <x-frontend.page-header
        eyebrow="{{ $caseStudy->category ?? 'Case Study' }}"
        title="{{ $caseStudy->title }}"
        :description="$caseStudy->summary"
    />

    <section class="bg-night py-16 md:py-20">
        <div class="container-app grid grid-cols-1 gap-10 lg:grid-cols-3">
            <div class="space-y-8 lg:col-span-2">
                @if (!empty($caseStudy->image_path))
                    <div class="overflow-hidden rounded-2xl shadow-lg" data-reveal="zoom">
                        <img src="{{ $caseStudy->image_url }}" alt="{{ $caseStudy->title }}" class="w-full object-cover">
                    </div>
                @endif

                @foreach (['Challenge' => $caseStudy->challenge, 'Solution' => $caseStudy->solution, 'Results' => $caseStudy->results] as $heading => $body)
                    @if (!empty($body))
                        <div data-reveal="left">
                            <h2 class="mb-4 text-xl font-semibold text-white">The {{ $heading }}</h2>
                            <div class="space-y-4 whitespace-pre-wrap text-base leading-relaxed text-slate-300">{{ $body }}</div>
                        </div>
                    @endif
                @endforeach
            </div>

            <aside class="space-y-6">
                <div class="rounded-2xl border border-white/10 bg-night/5 p-6 hv-glow" data-reveal="right">
                    <h3 class="mb-4 text-sm font-semibold uppercase tracking-wider text-slate-400">Engagement Details</h3>
                    <dl class="space-y-3 text-sm">
                        <div>
                            <dt class="text-xs font-medium text-slate-400">Category</dt>
                            <dd class="mt-0.5 font-medium text-slate-100">{{ $caseStudy->category ?? 'Case Study' }}</dd>
                        </div>
                        @if ($caseStudy->client_name)
                            <div>
                                <dt class="text-xs font-medium text-slate-400">Client</dt>
                                <dd class="mt-0.5 font-medium text-slate-100">{{ $caseStudy->client_name }}</dd>
                            </div>
                        @endif
                        @if ($caseStudy->published_at)
                            <div>
                                <dt class="text-xs font-medium text-slate-400">Published</dt>
                                <dd class="mt-0.5 text-slate-300">{{ $caseStudy->published_at->format('F Y') }}</dd>
                            </div>
                        @endif
                    </dl>
                </div>

                <div class="rounded-2xl border border-white/10 bg-night/5 p-6 shadow-lg backdrop-blur hv-glow" data-reveal="right">
                    <h3 class="mb-3 text-sm font-semibold uppercase tracking-wider text-slate-400">Have a Similar Challenge?</h3>
                    <p class="text-sm text-slate-300">Let's discuss how we can deliver the same level of results for your business.</p>
                    <a href="{{ route('contact') }}" class="mt-4 block rounded-lg bg-violet-600 px-4 py-2.5 text-center text-sm font-semibold text-white transition-colors hover:bg-violet-500">
                        Get in Touch
                    </a>
                </div>
            </aside>
        </div>
    </section>

    @if ($related->isNotEmpty())
        <section class="bg-night/5 py-16 md:py-20">
            <div class="container-app">
                <h2 class="mb-8 text-2xl font-semibold text-white">More Case Studies</h2>
                <div class="grid grid-cols-1 gap-6 md:grid-cols-3" data-reveal-stagger="80">
                    @foreach ($related as $item)
                        <a href="{{ route('case-studies.show', $item) }}" class="group overflow-hidden rounded-2xl border border-white/10 bg-night/5 shadow-lg backdrop-blur transition-all hover:-translate-y-1 hover:shadow-lg hv-lift" data-reveal="zoom">
                            @if (!empty($item->image_path))
                                <div class="aspect-video overflow-hidden">
                                    <img src="{{ $item->image_url }}" alt="{{ $item->title }}" class="h-full w-full object-cover transition-transform duration-300 group-hover:scale-105">
                                </div>
                            @else
                                <div class="flex aspect-video items-center justify-center bg-gradient-to-br from-navy-900 to-navy-800">
                                    <span class="rounded-xl bg-violet-500/15 px-4 py-2 text-sm font-semibold text-violet-400">{{ $item->category ?? 'Case Study' }}</span>
                                </div>
                            @endif
                            <div class="p-6">
                                <span class="text-xs font-semibold uppercase tracking-wider text-violet-600">{{ $item->category ?? 'Case Study' }}</span>
                                <h3 class="mt-2 text-base font-semibold text-white transition-colors group-hover:text-violet-400">{{ $item->title }}</h3>
                                <p class="mt-2 line-clamp-2 text-sm text-slate-300">{{ $item->summary }}</p>
                            </div>
                        </a>
                    @endforeach
                </div>
            </div>
        </section>
    @endif
</x-frontend.layouts.app>
