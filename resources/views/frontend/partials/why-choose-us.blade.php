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

            <x-frontend.grid :items="$reasons->count()" class="mt-12" data-reveal-stagger="90">
                @foreach ($reasons as $reason)
                    <div class="group relative overflow-hidden rounded-2xl border border-white/10 bg-night/5 p-6 shadow-lg backdrop-blur transition-all duration-300 hover:border-violet-400/60 hover:shadow-2xl hover:shadow-violet-600/25" data-reveal="zoom">
                        <div class="pointer-events-none absolute inset-0 bg-[radial-gradient(circle_at_top_left,rgba(139,92,246,0.28),transparent_60%)] opacity-0 transition-opacity duration-300 group-hover:opacity-100"></div>
                        <div class="pointer-events-none absolute -right-10 -top-10 h-28 w-28 rounded-full bg-violet-500/10 blur-2xl transition-all duration-500 group-hover:scale-150 group-hover:bg-violet-500/25"></div>
                        <span class="relative flex h-11 w-11 items-center justify-center rounded-xl bg-violet-500/15 text-violet-300 ring-1 ring-violet-500/30 transition-all duration-300 group-hover:scale-110 group-hover:bg-violet-500/25 group-hover:ring-violet-400/50">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="h-5 w-5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5" />
                            </svg>
                        </span>
                        <h3 class="relative mt-4 text-base font-semibold text-white transition-colors duration-300 group-hover:text-violet-300">{{ $reason['title'] }}</h3>
                        @if ($reason['description'] !== '')
                            <p class="relative mt-2 text-sm leading-relaxed text-slate-300">{{ $reason['description'] }}</p>
                        @endif
                    </div>
                @endforeach
            </x-frontend.grid>
        </div>
    </section>
@endif
