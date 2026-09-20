@props(['eyebrow' => null, 'title' => null, 'description' => null, 'align' => 'center'])

<div class="mx-auto mb-12 max-w-2xl {{ $align === 'left' ? 'md:mx-0 text-left' : 'text-center' }}" data-reveal>
    @if ($eyebrow)
        <p class="mb-3 inline-flex items-center gap-2 text-sm font-semibold uppercase tracking-widest text-violet-300">
            <span class="inline-block h-px w-6 bg-gradient-to-r from-violet-400 to-violet-600"></span>
            {{ $eyebrow }}
            @if ($align === 'center')
                <span class="inline-block h-px w-6 bg-gradient-to-r from-violet-600 to-violet-400"></span>
            @endif
        </p>
    @endif
    @if ($title)
        <h2 class="font-display text-3xl font-bold text-white md:text-4xl">
            <span class="text-shine">{{ $title }}</span>
        </h2>
    @endif
    @if ($description)
        <p class="mt-4 text-base leading-relaxed text-slate-400">{{ $description }}</p>
    @endif
</div>