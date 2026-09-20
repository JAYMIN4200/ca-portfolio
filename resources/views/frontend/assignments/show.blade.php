<x-frontend.layouts.app :seoTitle="$assignment->title . ' | ' . ($settings['site_name'] ?? 'Jinendra Panchal')">
    <x-frontend.page-header
        eyebrow="{{ $assignment->category ?? 'Professional Assignment' }}"
        title="{{ $assignment->title }}"
    />

    <section class="bg-night py-16 md:py-20">
        <div class="container-app grid grid-cols-1 gap-10 lg:grid-cols-3">
            <div class="space-y-6 lg:col-span-2">
                @if (!empty($assignment->image_path))
                    <div class="overflow-hidden rounded-2xl shadow-lg" data-reveal="zoom">
                        <img src="{{ $assignment->image_url }}" alt="{{ $assignment->title }}" class="w-full object-cover">
                    </div>
                @endif

                @if (!empty($assignment->description))
                    <div data-reveal="left">
                        <h2 class="mb-4 text-xl font-semibold text-white">Overview</h2>
                        <div class="space-y-4 whitespace-pre-wrap text-base leading-relaxed text-slate-300">{{ $assignment->description }}</div>
                    </div>
                @endif

                @if (!empty($assignment->responsibilities))
                    <div data-reveal="left">
                        <h2 class="mb-4 text-xl font-semibold text-white">Key Responsibilities</h2>
                        <ul class="space-y-3">
                            @foreach ($assignment->responsibilities as $responsibility)
                                <li class="flex items-start gap-3 text-slate-300">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="mt-0.5 h-5 w-5 shrink-0 text-violet-600">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5" />
                                    </svg>
                                    {{ $responsibility }}
                                </li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                @if (!empty($assignment->tools_used))
                    <div data-reveal="left">
                        <h2 class="mb-4 text-xl font-semibold text-white">Tools & Software Used</h2>
                        <div class="flex flex-wrap gap-2">
                            @foreach ($assignment->tools_used as $tool)
                                <span class="rounded-full border border-white/10 bg-white/10 px-4 py-1.5 text-sm font-medium text-slate-300">{{ $tool }}</span>
                            @endforeach
                        </div>
                    </div>
                @endif
            </div>

            <aside class="space-y-6">
                <div class="rounded-2xl border border-white/10 bg-night/5 p-6 hv-glow" data-reveal="right">
                    <h3 class="mb-4 text-sm font-semibold uppercase tracking-wider text-slate-400">Assignment Details</h3>
                    <dl class="space-y-3 text-sm">
                        <div>
                            <dt class="text-xs font-medium text-slate-400">Category</dt>
                            <dd class="mt-0.5 font-medium text-slate-100">{{ $assignment->category ?? 'Professional Work' }}</dd>
                        </div>
                        <div>
                            <dt class="text-xs font-medium text-slate-400">Short Description</dt>
                            <dd class="mt-0.5 text-slate-300">{{ $assignment->short_description }}</dd>
                        </div>
                    </dl>

                    @if (!empty($assignment->external_url))
                        <a href="{{ $assignment->external_url }}" target="_blank" rel="noopener noreferrer"
                            class="mt-5 inline-flex w-full items-center justify-center gap-2 rounded-lg bg-gradient-to-r from-violet-500 to-violet-700 px-4 py-2.5 text-sm font-semibold text-white shadow-lg shadow-violet-700/30 transition-all hover:from-violet-400 hover:to-violet-600 hover:shadow-violet-500/40">
                            View External Link
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-4 w-4">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 6H5.25A2.25 2.25 0 003 8.25v10.5A2.25 2.25 0 005.25 21h10.5A2.25 2.25 0 0018 18.75V10.5m-10.5 6L21 3m0 0h-5.25M21 3v5.25" />
                            </svg>
                        </a>
                    @endif
                </div>

                <div class="rounded-2xl border border-white/10 bg-night/5 p-6 shadow-lg backdrop-blur hv-glow" data-reveal="right">
                    <h3 class="mb-3 text-sm font-semibold uppercase tracking-wider text-slate-400">Need Similar Help?</h3>
                    <p class="text-sm text-slate-300">Have a similar professional requirement? Let's discuss how I can assist.</p>
                    <a href="{{ route('contact') }}" class="mt-4 block rounded-lg bg-violet-600 px-4 py-2.5 text-center text-sm font-semibold text-white transition-colors hover:bg-violet-500">
                        Get in Touch
                    </a>
                </div>
            </aside>
        </div>
    </section>
</x-frontend.layouts.app>