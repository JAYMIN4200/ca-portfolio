<x-admin.layouts.app :title="'Blog'">
    <div data-ajax-list="results">
        <div class="mb-6 flex flex-col gap-3 lg:flex-row lg:items-center lg:justify-between">
            <form method="GET" action="{{ route('admin.blog-posts.index') }}" class="flex w-full flex-col gap-2 sm:flex-row sm:max-w-lg">
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Search posts..."
                    class="block w-full rounded-lg border border-slate-300 px-3 py-2.5 text-sm text-slate-800 shadow-sm placeholder:text-slate-400 focus:border-navy-500 focus:ring-navy-500">
                <select name="status" data-custom-select class="rounded-lg border border-slate-300 px-3 py-2.5 text-sm text-slate-800 shadow-sm focus:border-navy-500 focus:ring-navy-500">
                    <option value="">All Status</option>
                    <option value="draft" {{ request('status') === 'draft' ? 'selected' : '' }}>Draft</option>
                    <option value="published" {{ request('status') === 'published' ? 'selected' : '' }}>Published</option>
                </select>
                <button type="submit" class="rounded-lg bg-navy-900 px-4 py-2.5 text-sm font-semibold text-white hover:bg-navy-800">Filter</button>
                <button type="button" data-reset-filter class="rounded-lg border border-slate-300 bg-white px-4 py-2.5 text-sm font-semibold text-slate-600 shadow-sm transition-colors hover:bg-slate-50">Reset</button>
            </form>
            <a href="{{ route('admin.blog-posts.create') }}" class="inline-flex items-center justify-center gap-2 rounded-lg bg-navy-900 px-4 py-2.5 text-sm font-semibold text-white shadow-sm hover:bg-navy-800">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-4 w-4">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                </svg>
                Add Post
            </a>
        </div>

        <div id="results">
            @include('admin.blog-posts._table')
        </div>
    </div>
</x-admin.layouts.app>
