@if ($posts->isNotEmpty())
    <div class="grid grid-cols-1 gap-6 md:grid-cols-2 lg:grid-cols-3" data-reveal-stagger="80">
        @foreach ($posts as $post)
            <a href="{{ route('blog.show', $post) }}" class="group flex flex-col overflow-hidden rounded-2xl border border-white/10 bg-night/5 shadow-lg backdrop-blur transition-all hover:-translate-y-1 hover:shadow-lg hv-lift" data-reveal="zoom">
                @if (!empty($post->cover_image))
                    <div class="aspect-video overflow-hidden">
                        <img src="{{ $post->cover_url }}" alt="{{ $post->title }}" class="h-full w-full object-cover transition-transform duration-300 group-hover:scale-105">
                    </div>
                @else
                    <div class="flex aspect-video items-center justify-center bg-gradient-to-br from-navy-900 to-navy-800">
                        <span class="rounded-xl bg-violet-500/15 px-4 py-2 text-sm font-semibold text-violet-400">{{ $post->category ?? 'Article' }}</span>
                    </div>
                @endif
                <div class="flex flex-1 flex-col p-6">
                    <div class="flex items-center gap-3 text-xs text-slate-400">
                        <span class="font-semibold uppercase tracking-wider text-violet-600">{{ $post->category ?? 'Article' }}</span>
                        @if ($post->published_at)
                            <span>·</span>
                            <span>{{ $post->published_at->format('d M Y') }}</span>
                        @endif
                    </div>
                    <h2 class="mt-2 text-base font-semibold text-white transition-colors group-hover:text-violet-400">{{ $post->title }}</h2>
                    <p class="mt-2 line-clamp-3 flex-1 text-sm text-slate-300">{{ $post->excerpt }}</p>
                    <span class="mt-4 text-xs font-semibold text-violet-400">{{ $post->reading_time }} min read</span>
                </div>
            </a>
        @endforeach
    </div>

    @if ($posts->hasPages())
        <div class="mt-10">
            {{ $posts->links() }}
        </div>
    @endif
@else
    <div class="rounded-2xl border border-white/10 bg-night/5 p-12 text-center">
        <p class="text-sm text-slate-400">
            {{ $activeCategory ? 'No posts found in this category yet.' : 'Articles are on the way. Please check back soon.' }}
        </p>
    </div>
@endif
