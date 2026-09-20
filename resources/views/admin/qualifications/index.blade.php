<x-admin.layouts.app :title="'Qualifications'">
    <div data-ajax-list="results">
        <div class="mb-6 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
            <form method="GET" action="{{ route('admin.qualifications.index') }}" class="flex w-full gap-2 sm:max-w-md">
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Search qualifications..."
                    class="block w-full rounded-lg border border-slate-300 px-3 py-2.5 text-sm text-slate-800 shadow-sm placeholder:text-slate-400 focus:border-navy-500 focus:ring-navy-500">
                <button type="submit" class="rounded-lg bg-navy-900 px-4 py-2.5 text-sm font-semibold text-white hover:bg-navy-800">Search</button>
                <button type="button" data-reset-filter class="rounded-lg border border-slate-300 bg-white px-4 py-2.5 text-sm font-semibold text-slate-600 shadow-sm transition-colors hover:bg-slate-50">Reset</button>
            </form>
            <a href="{{ route('admin.qualifications.create') }}" class="inline-flex items-center justify-center gap-2 rounded-lg bg-navy-900 px-4 py-2.5 text-sm font-semibold text-white shadow-sm hover:bg-navy-800">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-4 w-4">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                </svg>
                Add Qualification
            </a>
        </div>

        <div id="results">
            @include('admin.qualifications._table')
        </div>
    </div>
</x-admin.layouts.app>