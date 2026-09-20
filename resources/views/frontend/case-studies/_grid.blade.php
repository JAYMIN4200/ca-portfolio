@if ($caseStudies->isNotEmpty())
    <div class="grid grid-cols-1 gap-6 md:grid-cols-2 lg:grid-cols-3" data-reveal-stagger="80">
        @foreach ($caseStudies as $caseStudy)
            <a href="{{ route('case-studies.show', $caseStudy) }}" class="group overflow-hidden rounded-2xl border border-white/10 bg-night/5 shadow-lg backdrop-blur transition-all hover:-translate-y-1 hover:shadow-lg hv-lift" data-reveal="zoom">
                @if (!empty($caseStudy->image_path))
                    <div class="aspect-video overflow-hidden">
                        <img src="{{ $caseStudy->image_url }}" alt="{{ $caseStudy->title }}" class="h-full w-full object-cover transition-transform duration-300 group-hover:scale-105">
                    </div>
                @else
                    <div class="flex aspect-video items-center justify-center bg-gradient-to-br from-navy-900 to-navy-800">
                        <span class="rounded-xl bg-violet-500/15 px-4 py-2 text-sm font-semibold text-violet-400">{{ $caseStudy->category ?? 'Case Study' }}</span>
                    </div>
                @endif
                <div class="p-6">
                    <span class="text-xs font-semibold uppercase tracking-wider text-violet-600">{{ $caseStudy->category ?? 'Case Study' }}</span>
                    <h2 class="mt-2 text-base font-semibold text-white transition-colors group-hover:text-violet-400">{{ $caseStudy->title }}</h2>
                    @if ($caseStudy->client_name)
                        <p class="mt-1 text-xs font-medium text-slate-400">{{ $caseStudy->client_name }}</p>
                    @endif
                    <p class="mt-2 line-clamp-2 text-sm text-slate-300">{{ $caseStudy->summary }}</p>
                </div>
            </a>
        @endforeach
    </div>

    @if ($caseStudies->hasPages())
        <div class="mt-10">
            {{ $caseStudies->links() }}
        </div>
    @endif
@else
    <div class="rounded-2xl border border-white/10 bg-night/5 p-12 text-center">
        <p class="text-sm text-slate-400">
            {{ $activeCategory ? 'No case studies found in this category yet.' : 'Case studies are being added. Please check back soon.' }}
        </p>
    </div>
@endif
