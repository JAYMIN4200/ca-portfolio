<x-frontend.layouts.app :seoTitle="'Terms & Conditions | ' . ($settings['site_name'] ?? 'Jinendra Panchal')">
    <x-frontend.page-header
        eyebrow="Legal"
        title="Terms & Conditions"
        description="Please read these terms carefully before using this website."
    />

    <section class="bg-night py-16 md:py-20">
        <div class="container-app max-w-3xl">
            <div class="space-y-10">
                @foreach ($terms as $term)
                    <div id="{{ $term->slug }}" class="scroll-mt-24" data-reveal>
                        <h2 class="flex items-center gap-3 text-lg font-semibold text-white">
                            <span class="flex h-9 w-9 shrink-0 items-center justify-center rounded-lg bg-gradient-to-br from-violet-500 to-violet-700 text-sm font-bold text-white">
                                {{ $loop->iteration }}
                            </span>
                            {{ $term->title }}
                        </h2>
                        <div class="mt-4 pl-12">
                            <div class="prose-sm max-w-none text-sm leading-relaxed text-slate-300">{!! $term->content !!}</div>
                        </div>
                    </div>
                @endforeach
            </div>

            <p class="mt-12 border-t border-white/10 pt-6 text-xs text-slate-400" data-reveal>
                Last updated: {{ now()->format('F j, Y') }}. For questions about these terms, please
                <a href="{{ route('contact') }}" class="font-medium text-violet-400 hover:underline">contact me</a>.
            </p>
        </div>
    </section>
</x-frontend.layouts.app>