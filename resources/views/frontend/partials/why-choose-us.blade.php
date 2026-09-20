@php
    $reasons = collect(explode("\n", (string) ($settings['why_choose_us'] ?? '')))
        ->map(fn ($line) => trim($line))
        ->filter()
        ->map(function ($line) {
            $parts = array_map('trim', explode('|', $line, 2));

            return [
                'title' => $parts[0],
                'description' => $parts[1] ?? '',
            ];
        })
        ->filter(fn ($reason) => $reason['title'] !== '')
        ->take(6)
        ->values();
@endphp

@if ($reasons->isNotEmpty())
    <section class="bg-ink py-16 md:py-20">
        <div class="container-app">
            <div class="mx-auto max-w-2xl text-center" data-reveal="fade">
                <p class="text-sm font-semibold uppercase tracking-widest text-violet-600">Why Choose Us</p>
                <h2 class="mt-3 text-2xl font-semibold text-white md:text-3xl">Built on Trust, Delivered with Precision</h2>
                <p class="mt-4 text-base text-slate-300">A few reasons clients rely on us for their accounting, audit and taxation needs.</p>
            </div>

            <div class="mt-12 grid grid-cols-1 gap-6 md:grid-cols-2 lg:grid-cols-3" data-reveal-stagger="90">
                @foreach ($reasons as $reason)
                    <div class="rounded-2xl border border-white/10 bg-night/5 p-6 shadow-lg backdrop-blur transition-all duration-300 hover:-translate-y-1 hover:border-violet-400/50 hover:bg-night/10 hover:shadow-2xl hover:shadow-violet-900/40 hv-glow" data-reveal="zoom">
                        <span class="flex h-11 w-11 items-center justify-center rounded-xl bg-violet-500/15 text-violet-300 ring-1 ring-violet-500/30">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="h-5 w-5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5" />
                            </svg>
                        </span>
                        <h3 class="mt-4 text-base font-semibold text-white">{{ $reason['title'] }}</h3>
                        @if ($reason['description'] !== '')
                            <p class="mt-2 text-sm leading-relaxed text-slate-300">{{ $reason['description'] }}</p>
                        @endif
                    </div>
                @endforeach
            </div>
        </div>
    </section>
@endif
