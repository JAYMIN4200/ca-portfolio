@php
    $activeStatus = request('status', 'all');
    $tabs = ['all' => 'All'] + \App\Models\Task::STATUSES;
    $statusStyles = [
        'pending' => 'bg-slate-100 text-slate-700',
        'in_progress' => 'bg-blue-100 text-blue-700',
        'done' => 'bg-green-100 text-green-700',
        'hold' => 'bg-amber-100 text-amber-700',
    ];
    $priorityStyles = [
        'low' => 'bg-slate-100 text-slate-600',
        'medium' => 'bg-amber-100 text-amber-700',
        'high' => 'bg-red-100 text-red-700',
    ];
@endphp

<x-admin.layouts.app :title="'My Tasks'">
    <div data-ajax-list="results">
        <div class="mb-6 flex flex-col gap-3 lg:flex-row lg:items-center lg:justify-between">
            <form method="GET" action="{{ route('admin.tasks.index') }}" class="flex w-full flex-col gap-2 sm:flex-row sm:max-w-3xl">
                <input type="hidden" name="status" value="{{ $activeStatus }}">
                <input type="hidden" name="date" value="{{ request('date') }}">

                <input type="text" name="search" value="{{ request('search') }}" placeholder="Search tasks..."
                    class="block w-full rounded-lg border border-slate-300 px-3 py-2.5 text-sm text-slate-800 shadow-sm placeholder:text-slate-400 focus:border-navy-500 focus:ring-navy-500">
                <select name="priority" data-custom-select class="block w-full rounded-lg border border-slate-300 px-3 py-2.5 text-sm text-slate-800 shadow-sm focus:border-navy-500 focus:ring-navy-500 sm:w-44">
                    <option value="">All Priorities</option>
                    @foreach (\App\Models\Task::PRIORITIES as $value => $label)
                        <option value="{{ $value }}" {{ request('priority') === $value ? 'selected' : '' }}>{{ $label }}</option>
                    @endforeach
                </select>
                <select name="category" data-custom-select class="block w-full rounded-lg border border-slate-300 px-3 py-2.5 text-sm text-slate-800 shadow-sm focus:border-navy-500 focus:ring-navy-500 sm:w-56">
                    <option value="">All Categories</option>
                    @foreach ($categories as $cat)
                        <option value="{{ $cat }}" {{ request('category') === $cat ? 'selected' : '' }}>{{ $cat }}</option>
                    @endforeach
                </select>
                <button type="submit" class="rounded-lg bg-navy-900 px-4 py-2.5 text-sm font-semibold text-white hover:bg-navy-800">Filter</button>
                <button type="button" data-reset-filter class="rounded-lg border border-slate-300 bg-white px-4 py-2.5 text-sm font-semibold text-slate-600 shadow-sm transition-colors hover:bg-slate-50">Reset</button>
            </form>

            <a href="{{ route('admin.tasks.create') }}" class="inline-flex items-center justify-center gap-2 rounded-lg bg-navy-900 px-4 py-2.5 text-sm font-semibold text-white shadow-sm hover:bg-navy-800">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-4 w-4">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                </svg>
                Add Task
            </a>
        </div>

        <div class="mb-4 flex flex-wrap items-center gap-2" data-task-tabs>
            @foreach ($tabs as $key => $label)
                @php $isActive = $activeStatus === $key; @endphp
                <button type="button" data-task-status="{{ $key }}"
                    class="inline-flex items-center gap-2 rounded-full px-4 py-1.5 text-sm font-medium transition-colors {{ $isActive ? 'bg-navy-900 text-white shadow-sm' : 'bg-white text-slate-600 ring-1 ring-slate-200 hover:bg-slate-50' }}">
                    {{ $label }}
                    <span class="rounded-full px-1.5 py-0.5 text-[11px] font-bold {{ $isActive ? 'bg-white/20 text-white' : 'bg-slate-100 text-slate-600' }}">{{ $counts[$key] ?? 0 }}</span>
                </button>
            @endforeach

            <span id="taskDateChip" class="{{ request('date') ? '' : 'hidden' }} ml-auto inline-flex items-center gap-2 rounded-full bg-navy-50 px-3 py-1.5 text-xs font-medium text-navy-800">
                <span>Due on <span id="taskDateLabel">{{ request('date') }}</span></span>
                <button type="button" data-task-date-clear class="text-navy-500 hover:text-navy-900" aria-label="Clear date filter">&times;</button>
            </span>
        </div>

        <div class="grid grid-cols-1 gap-6 xl:grid-cols-3">
            <div class="xl:col-span-2">
                <div id="results">
                    @include('admin.tasks._table')
                </div>
            </div>

            <div class="xl:col-span-1">
                <div data-task-calendar data-endpoint="{{ route('admin.tasks.calendar') }}" data-month="{{ $calendarMonth->format('Y-m') }}"
                    class="rounded-xl bg-white p-5 shadow-sm ring-1 ring-slate-200">
                    <div id="taskCalendarPanel">
                        @include('admin.tasks._calendar')
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-admin.layouts.app>
