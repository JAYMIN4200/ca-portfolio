<x-admin.layouts.app :title="'Skills'">
    <div data-ajax-list="results">
        <div class="mb-6 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
            <form method="GET" action="{{ route('admin.skills.index') }}" class="flex w-full gap-2 sm:max-w-md">
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Search skills..."
                    class="block w-full rounded-lg border border-slate-300 px-3 py-2.5 text-sm text-slate-800 shadow-sm placeholder:text-slate-400 focus:border-navy-500 focus:ring-navy-500">
                <button type="submit" class="rounded-lg bg-navy-900 px-4 py-2.5 text-sm font-semibold text-white hover:bg-navy-800">Search</button>
                <button type="button" data-reset-filter class="rounded-lg border border-slate-300 bg-white px-4 py-2.5 text-sm font-semibold text-slate-600 shadow-sm transition-colors hover:bg-slate-50">Reset</button>
            </form>
            <div class="flex items-center gap-2">
                <a href="{{ route('admin.skill-categories.index') }}" class="inline-flex items-center justify-center gap-2 rounded-lg border border-navy-200 bg-white px-4 py-2.5 text-sm font-semibold text-navy-800 shadow-sm hover:bg-navy-50">
                    Manage Categories
                </a>
                <a href="{{ route('admin.skills.create') }}" class="inline-flex items-center justify-center gap-2 rounded-lg bg-navy-900 px-4 py-2.5 text-sm font-semibold text-white shadow-sm hover:bg-navy-800">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-4 w-4">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                    </svg>
                    Add Skill
                </a>
            </div>
        </div>

        <div id="results">
            @include('admin.skills._table')
        </div>
    </div>
</x-admin.layouts.app>