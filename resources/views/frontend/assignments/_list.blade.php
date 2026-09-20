@if ($categories->isNotEmpty())
    <div class="mb-10 flex flex-wrap justify-center gap-2" data-reveal="fade">
        <a href="{{ route('assignments') }}"
            class="js-ajax-link rounded-full px-4 py-2 text-sm font-medium transition-colors {{ !$activeCategory ? 'bg-violet-600 text-white shadow-md shadow-violet-700/40' : 'bg-white/10 text-slate-300 hover:bg-white/20 hover:text-white' }}">
            All
        </a>
        @foreach ($categories as $category)
            <a href="{{ route('assignments', ['category' => $category]) }}"
                class="js-ajax-link rounded-full px-4 py-2 text-sm font-medium transition-colors {{ $activeCategory === $category ? 'bg-violet-600 text-white shadow-md shadow-violet-700/40' : 'bg-white/10 text-slate-300 hover:bg-white/20 hover:text-white' }}">
                {{ $category }}
            </a>
        @endforeach
    </div>
@endif

@include('frontend.assignments._grid')
