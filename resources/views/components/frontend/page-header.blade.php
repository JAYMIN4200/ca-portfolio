@props(['title', 'eyebrow' => null, 'description' => null])

<section class="relative overflow-hidden bg-night pt-36 pb-16 md:pt-44 md:pb-20">
    <div class="absolute inset-0 aurora-bg"></div>
    <div class="absolute inset-0 gst-grid"></div>
    <div class="absolute -top-24 -left-24 h-80 w-80 rounded-full bg-violet-600/20 blur-3xl"></div>
    <div class="absolute -right-24 -bottom-24 h-80 w-80 rounded-full bg-navy-500/20 blur-3xl"></div>
    <span aria-hidden="true" class="pointer-events-none absolute right-10 top-14 select-none font-display text-7xl font-extrabold text-white/5 animate-float">₹</span>
    <span aria-hidden="true" class="pointer-events-none absolute left-10 bottom-8 select-none font-display text-6xl font-extrabold text-white/5 animate-float-slow">%</span>

    <div class="container-app relative text-center">
        @if ($eyebrow)
            <p class="mb-3 inline-flex items-center gap-2 text-sm font-semibold uppercase tracking-widest text-violet-300">
                <span class="inline-block h-px w-6 bg-violet-400"></span>
                {{ $eyebrow }}
                <span class="inline-block h-px w-6 bg-violet-400"></span>
            </p>
        @endif
        <h1 class="font-display text-3xl font-bold text-white md:text-5xl">
            <span class="text-shine">{{ $title }}</span>
        </h1>
        @if ($description)
            <p class="mx-auto mt-4 max-w-2xl text-base text-slate-300">{{ $description }}</p>
        @endif
    </div>
</section>