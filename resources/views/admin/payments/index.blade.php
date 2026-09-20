<x-admin.layouts.app :title="'Payments & Earnings'">
    <div data-ajax-list="results">
        <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-3">
            <div class="rounded-xl bg-white p-5 shadow-sm ring-1 ring-slate-200">
                <p class="text-xs font-semibold uppercase tracking-wider text-slate-500">Total Amount</p>
                <p class="mt-1 text-2xl font-semibold text-navy-950">₹{{ number_format($totals['billed'], 2) }}</p>
            </div>
            <div class="rounded-xl bg-white p-5 shadow-sm ring-1 ring-slate-200">
                <p class="text-xs font-semibold uppercase tracking-wider text-slate-500">Received</p>
                <p class="mt-1 text-2xl font-semibold text-green-700">₹{{ number_format($totals['received'], 2) }}</p>
            </div>
            <div class="rounded-xl bg-white p-5 shadow-sm ring-1 ring-slate-200">
                <p class="text-xs font-semibold uppercase tracking-wider text-slate-500">Pending Amount</p>
                <p class="mt-1 text-2xl font-semibold {{ $totals['balance'] > 0 ? 'text-red-600' : 'text-green-700' }}">₹{{ number_format($totals['balance'], 2) }}</p>
            </div>
        </div>

        <div class="my-6 rounded-xl bg-white p-5 shadow-sm ring-1 ring-slate-200">
            <form method="GET" action="{{ route('admin.payments.index') }}" class="grid grid-cols-1 gap-3 sm:grid-cols-2 lg:grid-cols-6">
                <input type="text" name="search" value="{{ $filters['search'] ?? '' }}" placeholder="Search reference or client..."
                    class="rounded-lg border border-slate-300 px-3 py-2.5 text-sm text-slate-800 shadow-sm placeholder:text-slate-400 focus:border-navy-500 focus:ring-navy-500 lg:col-span-2">
                <select name="client_id" data-custom-select class="rounded-lg border border-slate-300 px-3 py-2.5 text-sm text-slate-800 shadow-sm focus:border-navy-500 focus:ring-navy-500">
                    <option value="">All Clients</option>
                    @foreach ($clients as $client)
                        <option value="{{ $client->id }}" {{ (string) ($filters['client_id'] ?? '') === (string) $client->id ? 'selected' : '' }}>{{ $client->name }}</option>
                    @endforeach
                </select>
                <select name="status" data-custom-select class="rounded-lg border border-slate-300 px-3 py-2.5 text-sm text-slate-800 shadow-sm focus:border-navy-500 focus:ring-navy-500">
                    <option value="">All Status</option>
                    <option value="received" {{ ($filters['status'] ?? '') === 'received' ? 'selected' : '' }}>Received</option>
                    <option value="pending" {{ ($filters['status'] ?? '') === 'pending' ? 'selected' : '' }}>Pending</option>
                </select>
                <select name="month" data-custom-select class="rounded-lg border border-slate-300 px-3 py-2.5 text-sm text-slate-800 shadow-sm focus:border-navy-500 focus:ring-navy-500">
                    <option value="">All Months</option>
                    @foreach (range(1, 12) as $month)
                        <option value="{{ $month }}" {{ (string) ($filters['month'] ?? '') === (string) $month ? 'selected' : '' }}>{{ \Carbon\Carbon::create()->month($month)->format('F') }}</option>
                    @endforeach
                </select>
                <select name="year" data-custom-select class="rounded-lg border border-slate-300 px-3 py-2.5 text-sm text-slate-800 shadow-sm focus:border-navy-500 focus:ring-navy-500">
                    <option value="">All Years</option>
                    @foreach (range(now()->year, now()->year - 6) as $year)
                        <option value="{{ $year }}" {{ (string) ($filters['year'] ?? '') === (string) $year ? 'selected' : '' }}>{{ $year }}</option>
                    @endforeach
                </select>
            </form>

            <div class="mt-4 flex flex-wrap items-center justify-between gap-3 border-t border-slate-100 pt-4">
                <div class="flex items-center gap-2">
                    <button type="button" data-reset-filter class="rounded-lg border border-slate-300 bg-white px-4 py-2.5 text-sm font-semibold text-slate-600 shadow-sm transition-colors hover:bg-slate-50">Reset filters</button>
                </div>
                <div class="flex flex-wrap items-center gap-2">
                    <div class="flex items-center overflow-hidden rounded-lg border border-navy-200 bg-white shadow-sm">
                        <a href="{{ route('admin.payments.export', ['format' => 'csv'] + request()->query()) }}" class="px-3 py-2 text-sm font-semibold text-navy-800 hover:bg-navy-50">CSV</a>
                        <span class="h-4 w-px bg-slate-200"></span>
                        <a href="{{ route('admin.payments.export', ['format' => 'xlsx'] + request()->query()) }}" class="px-3 py-2 text-sm font-semibold text-navy-800 hover:bg-navy-50">Excel</a>
                        <span class="h-4 w-px bg-slate-200"></span>
                        <a href="{{ route('admin.payments.export', ['format' => 'pdf'] + request()->query()) }}" class="px-3 py-2 text-sm font-semibold text-navy-800 hover:bg-navy-50">PDF</a>
                    </div>
                    <a href="{{ route('admin.payments.create') }}" class="inline-flex items-center justify-center gap-2 rounded-lg bg-navy-900 px-4 py-2.5 text-sm font-semibold text-white shadow-sm hover:bg-navy-800">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-4 w-4">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                        </svg>
                        Record Payment
                    </a>
                </div>
            </div>
        </div>

        <div id="results">
            @include('admin.payments._table')
        </div>
    </div>
</x-admin.layouts.app>
