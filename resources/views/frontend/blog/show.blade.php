<x-frontend.layouts.app :seoTitle="$blogPost->title . ' | ' . ($settings['site_name'] ?? 'Jinendra Panchal')" :seoDescription="$blogPost->excerpt">
    <x-frontend.page-header
        eyebrow="{{ $blogPost->category ?? 'Article' }}"
        title="{{ $blogPost->title }}"
    />

    <section class="bg-night py-16 md:py-20">
        <div class="container-app grid grid-cols-1 gap-10 lg:grid-cols-3">
            <article class="space-y-8 lg:col-span-2">
                @if (!empty($blogPost->cover_image))
                    <div class="overflow-hidden rounded-2xl shadow-lg" data-reveal="zoom">
                        <img src="{{ $blogPost->cover_url }}" alt="{{ $blogPost->title }}" class="w-full object-cover">
                    </div>
                @endif

                <div class="flex flex-wrap items-center gap-4 text-sm text-slate-400" data-reveal="fade">
                    @if ($blogPost->published_at)
                        <span>{{ $blogPost->published_at->format('d M Y') }}</span>
                    @endif
                    <span>{{ $blogPost->reading_time }} min read</span>
                    <span>{{ number_format($blogPost->views) }} views</span>
                </div>

                @if (!empty($blogPost->excerpt))
                    <p class="text-lg leading-relaxed text-slate-300" data-reveal="left">{{ $blogPost->excerpt }}</p>
                @endif

                @if (!empty($blogPost->content))
                    <div class="space-y-4 text-base leading-relaxed whitespace-pre-wrap text-slate-300" data-reveal="fade">{!! nl2br(e($blogPost->content)) !!}</div>
                @endif

                @if (!empty($blogPost->tags))
                    <div class="flex flex-wrap gap-2 border-t border-white/10 pt-6" data-reveal="left">
                        @foreach ($blogPost->tags as $tag)
                            <span class="rounded-full border border-white/10 bg-white/10 px-3 py-1 text-xs font-medium text-slate-300">#{{ $tag }}</span>
                        @endforeach
                    </div>
                @endif
            </article>

            <aside class="space-y-6">
                <div class="rounded-2xl border border-white/10 bg-night/5 p-6 shadow-lg backdrop-blur hv-glow" data-reveal="right">
                    <h3 class="mb-3 text-sm font-semibold uppercase tracking-wider text-slate-400">Need Advice?</h3>
                    <p class="text-sm text-slate-300">Have a question about this topic? Book a consultation and let's talk it through.</p>
                    <a href="{{ route('contact') }}" class="mt-4 block rounded-lg bg-violet-600 px-4 py-2.5 text-center text-sm font-semibold text-white transition-colors hover:bg-violet-500">
                        Get in Touch
                    </a>
                </div>
            </aside>
        </div>
    </section>

    @if ($related->isNotEmpty())
        <section class="bg-night/5 py-16 md:py-20">
            <div class="container-app">
                <h2 class="mb-8 text-2xl font-semibold text-white">More From the Blog</h2>
                <div class="grid grid-cols-1 gap-6 md:grid-cols-3" data-reveal-stagger="80">
                    @foreach ($related as $item)
                        <a href="{{ route('blog.show', $item) }}" class="group overflow-hidden rounded-2xl border border-white/10 bg-night/5 shadow-lg backdrop-blur transition-all hover:-translate-y-1 hover:shadow-lg hv-lift" data-reveal="zoom">
                            @if (!empty($item->cover_image))
                                <div class="aspect-video overflow-hidden">
                                    <img src="{{ $item->cover_url }}" alt="{{ $item->title }}" class="h-full w-full object-cover transition-transform duration-300 group-hover:scale-105">
                                </div>
                            @else
                                <div class="flex aspect-video items-center justify-center bg-gradient-to-br from-navy-900 to-navy-800">
                                    <span class="rounded-xl bg-violet-500/15 px-4 py-2 text-sm font-semibold text-violet-400">{{ $item->category ?? 'Article' }}</span>
                                </div>
                            @endif
                            <div class="p-6">
                                <span class="text-xs font-semibold uppercase tracking-wider text-violet-600">{{ $item->category ?? 'Article' }}</span>
                                <h3 class="mt-2 text-base font-semibold text-white transition-colors group-hover:text-violet-400">{{ $item->title }}</h3>
                                <p class="mt-2 line-clamp-2 text-sm text-slate-300">{{ $item->excerpt }}</p>
                            </div>
                        </a>
                    @endforeach
                </div>
            </div>
        </section>
    @endif
</x-frontend.layouts.app>
