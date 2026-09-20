<x-frontend.layouts.app :seoTitle="'Qualifications | ' . ($settings['site_name'] ?? 'Jinendra Panchal')">
    <x-frontend.page-header
        eyebrow="Qualifications"
        title="Educational & Professional Qualifications"
        description="A professional journey built on academic discipline, rigorous CA training, and continuous learning."
    />

    <section class="bg-night py-16 md:py-20">
        <div class="container-app max-w-4xl">
            <div class="space-y-8" data-reveal-stagger="140">
                @forelse ($qualifications as $index => $qualification)
                    <div class="relative flex flex-col gap-4 md:flex-row" data-reveal="left">
                        <div class="hidden w-40 shrink-0 text-right md:block">
                            <p class="text-sm font-medium text-slate-400">
                                @if ($qualification->start_year) {{ $qualification->start_year }} @endif
                                @if ($qualification->start_year && $qualification->end_year) — @endif
                                @if ($qualification->end_year) {{ $qualification->end_year }} @endif
                            </p>
                        </div>
                        <div class="relative flex-1 border-l-2 border-white/10 pb-8 pl-6 md:ml-0">
                            <span class="absolute -left-[9px] top-0 h-4 w-4 rounded-full border-4 border-night bg-violet-500 shadow"></span>
                            <div class="inline-flex rounded-full px-3 py-1 text-xs font-semibold
                                {{ $qualification->status === 'completed' ? 'bg-green-500/15 text-green-300' : '' }}
                                {{ $qualification->status === 'pursuing' ? 'bg-blue-500/15 text-blue-300' : '' }}
                                {{ $qualification->status === 'cleared' ? 'bg-emerald-500/15 text-emerald-300' : '' }}">
                                {{ $qualification->status_label }}
                            </div>
                            <h2 class="mt-2 text-xl font-semibold text-white">{{ $qualification->name }}</h2>
                            @if ($qualification->institution)
                                <p class="mt-1 text-sm font-medium text-slate-300">{{ $qualification->institution }}</p>
                            @endif
                            @if ($qualification->description)
                                <p class="mt-3 text-sm leading-relaxed text-slate-300">{{ $qualification->description }}</p>
                            @endif
                        </div>
                    </div>
                @empty
                    <div class="rounded-2xl border border-white/10 bg-night/5 p-12 text-center">
                        <p class="text-sm text-slate-400">Qualification details are being updated. Please check back soon.</p>
                    </div>
                @endforelse
            </div>
        </div>
    </section>
</x-frontend.layouts.app>