<x-frontend.layouts.app :seoTitle="'FAQs | ' . ($settings['site_name'] ?? 'Jinendra Panchal')">
    <x-frontend.page-header
        eyebrow="Help Center"
        title="Frequently Asked Questions"
        description="Answers to the questions I'm asked most often. Can't find what you need? Get in touch."
    />

    <section class="bg-night py-16 md:py-20">
        <div class="container-app max-w-4xl">
            @php $grouped = $faqs->groupBy('category'); @endphp

            @if ($grouped->count() > 1)
                <div class="mb-10 flex flex-wrap justify-center gap-2" data-reveal="fade">
                    @foreach ($grouped->keys() as $index => $category)
                        <a href="#faq-{{ str($category)->slug() }}" class="rounded-full border border-white/10 px-4 py-1.5 text-sm font-medium text-slate-300 transition-colors hover:border-violet-400 hover:bg-violet-500/10 hover:text-violet-200">
                            {{ $category }}
                        </a>
                    @endforeach
                </div>
            @endif

            <div class="space-y-12">
                @foreach ($grouped as $category => $items)
                    <div id="faq-{{ str($category)->slug() }}" class="scroll-mt-24">
                        @if ($category)
                            <h2 class="mb-5 text-lg font-semibold text-white">{{ $category }}</h2>
                        @endif
                        <div class="space-y-3" data-reveal-stagger="70">
                            @foreach ($items as $faq)
                                <details class="group overflow-hidden rounded-2xl border border-white/10 bg-night/5 shadow-lg backdrop-blur hv-glow" data-reveal="fade">
                                    <summary class="flex cursor-pointer list-none items-center justify-between gap-4 px-5 py-4 text-sm font-semibold text-white [&::-webkit-details-marker]:hidden">
                                        {{ $faq->question }}
                                        <span class="flex h-8 w-8 shrink-0 items-center justify-center rounded-full bg-white/10 text-slate-300 transition-transform group-open:rotate-45">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="h-4 w-4">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                                            </svg>
                                        </span>
                                    </summary>
                                    <div class="border-t border-white/10 px-5 pt-4 pb-5">
                                        <p class="text-sm leading-relaxed text-slate-300">{{ $faq->answer }}</p>
                                    </div>
                                </details>
                            @endforeach
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="mt-12 rounded-2xl bg-gradient-to-br from-violet-950/60 to-navy-950 p-8 text-center text-white ring-1 ring-violet-500/20" data-reveal="zoom">
                <h2 class="text-lg font-semibold">Still have questions?</h2>
                <p class="mx-auto mt-2 max-w-md text-sm text-slate-300">
                    If you couldn't find an answer, send me a message and I'll get back to you within 24 hours.
                </p>
                <a href="{{ route('contact') }}" class="mt-5 inline-flex items-center gap-2 rounded-lg bg-violet-600 px-6 py-2.5 text-sm font-semibold text-white transition-colors hover:bg-violet-500">
                    Contact Me
                </a>
            </div>
        </div>
    </section>
</x-frontend.layouts.app>