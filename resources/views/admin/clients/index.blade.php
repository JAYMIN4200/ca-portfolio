<x-admin.layouts.app :title="'Clients'">
    <div data-ajax-list="results">
        <div class="mb-6 flex flex-col gap-3 lg:flex-row lg:items-center lg:justify-between">
            <form method="GET" action="{{ route('admin.clients.index') }}" class="flex w-full flex-wrap items-center gap-2 sm:max-w-2xl">
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Search clients..."
                    class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm text-slate-800 shadow-sm placeholder:text-slate-400 focus:border-navy-500 focus:ring-navy-500 sm:w-64">
                <select name="client_id" data-custom-select
                    class="w-52 rounded-lg border border-slate-300 px-3 py-2 text-sm text-slate-800 shadow-sm focus:border-navy-500 focus:ring-navy-500">
                    <option value="">All Clients</option>
                    @foreach ($clientsDropdown as $clientOption)
                        <option value="{{ $clientOption->id }}" {{ request('client_id') == $clientOption->id ? 'selected' : '' }}>{{ $clientOption->name }}</option>
                    @endforeach
                </select>
                <button type="submit" class="rounded-lg bg-navy-900 px-3 py-2 text-sm font-semibold text-white hover:bg-navy-800">Search</button>
                <button type="button" data-reset-filter class="rounded-lg border border-slate-300 bg-white px-3 py-2 text-sm font-semibold text-slate-600 shadow-sm transition-colors hover:bg-slate-50">Reset</button>
            </form>
            <div class="flex flex-wrap items-center gap-2">
                <div class="flex items-center overflow-hidden rounded-lg border border-navy-200 bg-white shadow-sm">
                    <a href="{{ route('admin.clients.export', ['format' => 'csv'] + request()->query()) }}" class="px-3 py-2 text-sm font-semibold text-navy-800 hover:bg-navy-50">CSV</a>
                    <span class="h-4 w-px bg-slate-200"></span>
                    <a href="{{ route('admin.clients.export', ['format' => 'xlsx'] + request()->query()) }}" class="px-3 py-2 text-sm font-semibold text-navy-800 hover:bg-navy-50">Excel</a>
                    <span class="h-4 w-px bg-slate-200"></span>
                    <a href="{{ route('admin.clients.export', ['format' => 'pdf'] + request()->query()) }}" class="px-3 py-2 text-sm font-semibold text-navy-800 hover:bg-navy-50">PDF</a>
                </div>
                <a href="{{ route('admin.clients.create') }}" class="inline-flex items-center justify-center gap-2 rounded-lg bg-navy-900 px-4 py-2 text-sm font-semibold text-white shadow-sm hover:bg-navy-800">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-4 w-4">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                    </svg>
                    Add Client
                </a>
            </div>
        </div>

        <div id="results">
            @include('admin.clients._table')
        </div>
    </div>
</x-admin.layouts.app>
