<x-admin.layouts.app :title="'Messages'">
    <div data-ajax-list="results">
        <div class="mb-6">
            <form method="GET" action="{{ route('admin.messages.index') }}" class="flex flex-col gap-2 sm:flex-row sm:max-w-xl">
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Search messages..."
                    class="block w-full rounded-lg border border-slate-300 px-3 py-2.5 text-sm text-slate-800 shadow-sm placeholder:text-slate-400 focus:border-navy-500 focus:ring-navy-500">
                <select name="status" data-custom-select class="block w-full rounded-lg border border-slate-300 px-3 py-2.5 text-sm text-slate-800 shadow-sm focus:border-navy-500 focus:ring-navy-500">
                    <option value="">All Status</option>
                    <option value="unread" {{ request('status') === 'unread' ? 'selected' : '' }}>Unread</option>
                    <option value="read" {{ request('status') === 'read' ? 'selected' : '' }}>Read</option>
                </select>
                <button type="submit" class="rounded-lg bg-navy-900 px-4 py-2.5 text-sm font-semibold text-white hover:bg-navy-800">Filter</button>
                <button type="button" data-reset-filter class="rounded-lg border border-slate-300 bg-white px-4 py-2.5 text-sm font-semibold text-slate-600 shadow-sm transition-colors hover:bg-slate-50">Reset</button>
            </form>
        </div>

        <div id="results">
            @include('admin.messages._table')
        </div>
    </div>
</x-admin.layouts.app>