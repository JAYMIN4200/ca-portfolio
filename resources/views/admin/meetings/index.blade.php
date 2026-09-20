<x-admin.layouts.app :title="'Meetings'">
    <div data-ajax-list="results">
        <div class="mb-6 rounded-xl bg-white p-5 shadow-sm ring-1 ring-slate-200">
            <form method="GET" action="{{ route('admin.meetings.index') }}" class="grid grid-cols-1 gap-3 sm:grid-cols-2 lg:grid-cols-5">
                <input type="text" name="search" value="{{ $filters['search'] ?? '' }}" placeholder="Search name or title..."
                    class="rounded-lg border border-slate-300 px-3 py-2.5 text-sm text-slate-800 shadow-sm placeholder:text-slate-400 focus:border-navy-500 focus:ring-navy-500 lg:col-span-2">
                <select name="status" data-custom-select class="rounded-lg border border-slate-300 px-3 py-2.5 text-sm text-slate-800 shadow-sm focus:border-navy-500 focus:ring-navy-500">
                    <option value="">All Status</option>
                    @foreach ($statuses as $value => $label)
                        <option value="{{ $value }}" {{ ($filters['status'] ?? '') === $value ? 'selected' : '' }}>{{ $label }}</option>
                    @endforeach
                </select>
                <select name="month" data-custom-select class="rounded-lg border border-slate-300 px-3 py-2.5 text-sm text-slate-800 shadow-sm focus:border-navy-500 focus:ring-navy-500">
                    <option value="">All Months</option>
                    @foreach (range(1, 12) as $month)
                        <option value="{{ $month }}" {{ (string) ($filters['month'] ?? '') === (string) $month ? 'selected' : '' }}>{{ \Carbon\Carbon::create()->month($month)->format('F') }}</option>
                    @endforeach
                </select>
                <select name="year" data-custom-select class="rounded-lg border border-slate-300 px-3 py-2.5 text-sm text-slate-800 shadow-sm focus:border-navy-500 focus:ring-navy-500">
                    <option value="">All Years</option>
                    @foreach (range(now()->year, now()->year - 3) as $year)
                        <option value="{{ $year }}" {{ (string) ($filters['year'] ?? '') === (string) $year ? 'selected' : '' }}>{{ $year }}</option>
                    @endforeach
                </select>
            </form>
            <div class="mt-4 flex flex-wrap items-center justify-between gap-3 border-t border-slate-100 pt-4">
                <button type="button" data-reset-filter class="rounded-lg border border-slate-300 bg-white px-4 py-2.5 text-sm font-semibold text-slate-600 shadow-sm transition-colors hover:bg-slate-50">Reset filters</button>
                <a href="{{ route('admin.meetings.create') }}" class="inline-flex items-center justify-center gap-2 rounded-lg bg-navy-900 px-4 py-2.5 text-sm font-semibold text-white shadow-sm hover:bg-navy-800">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-4 w-4">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                    </svg>
                    Schedule Meeting
                </a>
            </div>
        </div>

        <div id="results">
            @include('admin.meetings._table')
        </div>
    </div>
</x-admin.layouts.app>
