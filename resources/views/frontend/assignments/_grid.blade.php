@if ($assignments->isNotEmpty())
    <div class="grid grid-cols-1 gap-6 md:grid-cols-2 lg:grid-cols-3" data-reveal-stagger="80">
        @foreach ($assignments as $assignment)
            <a href="{{ route('assignments.show', $assignment) }}" class="group overflow-hidden rounded-2xl border border-white/10 bg-night/5 shadow-lg backdrop-blur transition-all hover:-translate-y-1 hover:shadow-lg hv-lift" data-reveal="zoom">
                @if (!empty($assignment->image_path))
                    <div class="aspect-video overflow-hidden">
                        <img src="{{ $assignment->image_url }}" alt="{{ $assignment->title }}" class="h-full w-full object-cover transition-transform duration-300 group-hover:scale-105">
                    </div>
                @else
                    <div class="flex aspect-video items-center justify-center bg-gradient-to-br from-navy-900 to-navy-800">
                        <span class="rounded-xl bg-violet-500/15 px-4 py-2 text-sm font-semibold text-violet-400">{{ $assignment->category ?? 'Professional Assignment' }}</span>
                    </div>
                @endif
                <div class="p-6">
                    <span class="text-xs font-semibold uppercase tracking-wider text-violet-600">{{ $assignment->category ?? 'Professional Work' }}</span>
                    <h2 class="mt-2 text-base font-semibold text-white transition-colors group-hover:text-violet-400">{{ $assignment->title }}</h2>
                    <p class="mt-2 line-clamp-2 text-sm text-slate-300">{{ $assignment->short_description }}</p>
                </div>
            </a>
        @endforeach
    </div>

    @if ($assignments->hasPages())
        <div class="mt-10">
            {{ $assignments->links() }}
        </div>
    @endif
@else
    <div class="rounded-2xl border border-white/10 bg-night/5 p-12 text-center">
        <p class="text-sm text-slate-400">
            {{ $activeCategory ? 'No assignments found in this category yet.' : 'Assignments are being added. Please check back soon.' }}
        </p>
    </div>
@endif