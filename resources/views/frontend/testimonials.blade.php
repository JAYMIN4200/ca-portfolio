<x-frontend.layouts.app :seoTitle="'Testimonials | ' . ($settings['site_name'] ?? 'Jinendra Panchal')">
    <x-frontend.page-header
        eyebrow="Social Proof"
        title="What Clients Say"
        description="Feedback from clients and professionals I've had the pleasure of working with."
    />

    <section class="bg-ink py-16 md:py-20">
        <div class="container-app">
            <div class="grid grid-cols-1 gap-6 md:grid-cols-2 lg:grid-cols-3" data-reveal-stagger="90">
                @foreach ($testimonials as $testimonial)
                    <div class="flex flex-col justify-between gap-6 rounded-2xl border border-white/10 bg-night/5 p-6 shadow-lg backdrop-blur hv-lift" data-reveal="zoom">
                        <div>
                            <div class="flex items-center gap-1 text-violet-500">
                                @for ($i = 1; $i <= 5; $i++)
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" class="h-4 w-4 {{ $i <= ($testimonial->rating ?? 0) ? 'fill-current' : 'fill-slate-200' }}">
                                        <path d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.196-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z" />
                                    </svg>
                                @endfor
                            </div>
                            <p class="mt-4 text-sm leading-relaxed text-slate-300">"{{ $testimonial->message }}"</p>
                        </div>
                        <div class="flex items-center gap-3 border-t border-white/10 pt-5">
                            @if ($testimonial->photo)
                                <img src="{{ $testimonial->photo_url }}" alt="{{ $testimonial->name }}" class="h-11 w-11 shrink-0 rounded-full object-cover">
                            @else
                                <span class="flex h-11 w-11 shrink-0 items-center justify-center rounded-full bg-gradient-to-br from-violet-500 to-violet-700 text-sm font-bold text-white">
                                    {{ strtoupper(substr($testimonial->name, 0, 1)) }}
                                </span>
                            @endif
                            <div>
                                <p class="text-sm font-semibold text-white">{{ $testimonial->name }}</p>
                                @if ($testimonial->designation || $testimonial->company)
                                    <p class="text-xs text-slate-400">
                                        {{ $testimonial->designation }}@if ($testimonial->designation && $testimonial->company), @endif{{ $testimonial->company }}
                                    </p>
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>
</x-frontend.layouts.app>