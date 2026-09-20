<x-frontend.layouts.app :seoTitle="'Services | ' . ($settings['site_name'] ?? 'Jinendra Panchal')">
    <x-frontend.page-header
        eyebrow="Services"
        title="Professional Services & Support"
        description="Professional assistance in accounting, audit, taxation and compliance — delivered with integrity and attention to detail."
    />

    <section class="bg-night py-16 md:py-20">
        <div class="container-app">
            @if ($services->isNotEmpty())
                <div class="grid grid-cols-1 gap-6 md:grid-cols-2 lg:grid-cols-3" data-reveal-stagger="90">
                    @foreach ($services as $service)
                        <div class="rounded-2xl border border-white/10 bg-night/5 p-6 shadow-lg backdrop-blur transition-all hover:-translate-y-1 hover:border-violet-300 hover:shadow-lg hv-sheen hv-icon" data-reveal="zoom">
                            <div class="mb-4 flex h-12 w-12 items-center justify-center rounded-xl bg-violet-500/15 text-violet-300 ring-1 ring-violet-500/30">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-6 w-6">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M11.42 15.17L17.25 21A2.652 2.652 0 0021 17.25l-5.877-5.877M11.42 15.17l2.496-3.03c.317-.384.74-.626 1.208-.766M11.42 15.17l-4.655 5.653a2.548 2.548 0 11-3.586-3.586l6.837-5.63m5.108-.233c.55-.164 1.163-.188 1.743-.14a4.5 4.5 0 004.486-6.336l-3.276 3.277a3.004 3.004 0 01-2.25-2.25l3.276-3.276a4.5 4.5 0 00-6.336 4.486c.091 1.076-.071 2.264-.904 2.95l-.102.085m-1.745 1.437L5.909 7.5H4.5L2.25 3.75l1.5-1.5L7.5 4.5v1.409l4.26 4.26m-1.745 1.437l1.745-1.437m6.615 8.206L15.75 15.75M4.867 19.125h.008v.008h-.008v-.008z" />
                                </svg>
                            </div>
                            <h2 class="text-base font-semibold text-white">{{ $service->title }}</h2>
                            <p class="mt-2 text-sm leading-relaxed text-slate-300">
                                {{ $service->short_description ?: $service->description }}
                            </p>
                            @if (!empty($service->description) && !empty($service->short_description) && $service->description !== $service->short_description)
                                <details class="mt-3">
                                    <summary class="cursor-pointer text-xs font-semibold text-violet-400 hover:text-white">Learn more</summary>
                                    <p class="mt-2 whitespace-pre-wrap text-sm leading-relaxed text-slate-300">{{ $service->description }}</p>
                                </details>
                            @endif
                        </div>
                    @endforeach
                </div>

                <div class="mt-12 rounded-2xl bg-night/5 p-6 text-center" data-reveal="fade">
                    <p class="text-sm text-slate-300">
                        All services are provided as professional assistance, support and preparation under appropriate professional supervision.
                    </p>
                    <a href="{{ route('contact') }}" class="mt-4 inline-block rounded-lg bg-gradient-to-r from-violet-500 to-violet-700 px-6 py-3 text-sm font-semibold text-white shadow-lg shadow-violet-700/30 transition-all hover:from-violet-400 hover:to-violet-600 hover:shadow-violet-500/40">
                        Discuss Your Requirement
                    </a>
                </div>
            @else
                <div class="rounded-2xl border border-white/10 bg-night/5 p-12 text-center">
                    <p class="text-sm text-slate-400">Service details are being updated. Please check back soon.</p>
                </div>
            @endif
        </div>
    </section>
</x-frontend.layouts.app>