<div>
    <div class="mb-4 flex items-center justify-between">
        <h2 class="text-base font-semibold text-navy-950">Task Calendar</h2>
        <div class="flex items-center gap-1">
            <button type="button" data-calendar-nav="prev" class="rounded-lg p-1.5 text-slate-500 hover:bg-slate-100 hover:text-navy-700" title="Previous month">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="h-4 w-4"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5L8.25 12l7.5-7.5" /></svg>
            </button>
            <span class="min-w-28 text-center text-sm font-semibold text-navy-900">{{ $calendarMonth->format('F Y') }}</span>
            <button type="button" data-calendar-nav="next" class="rounded-lg p-1.5 text-slate-500 hover:bg-slate-100 hover:text-navy-700" title="Next month">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="h-4 w-4"><path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5" /></svg>
            </button>
        </div>
    </div>

    <div class="grid grid-cols-7 gap-1 text-center text-[11px] font-semibold uppercase tracking-wider text-slate-400">
        @foreach (['Su', 'Mo', 'Tu', 'We', 'Th', 'Fr', 'Sa'] as $dayName)
            <div class="py-1.5">{{ $dayName }}</div>
        @endforeach
    </div>

    <div class="grid grid-cols-7 gap-1">
        @foreach ($calendarDays as $day)
            @php
                $isPast = $day['inMonth'] && $day['date']->isPast();
                $cellClasses = $day['isSelected']
                    ? 'border-navy-900 bg-navy-900 text-white'
                    : ($day['inMonth']
                        ? 'border-slate-200 bg-white text-slate-700 hover:border-navy-300 hover:bg-navy-50'
                        : 'border-transparent bg-slate-50/60 text-slate-300');
            @endphp
            <button type="button" data-calendar-day="{{ $day['date']->toDateString() }}" title="{{ $day['tasks']->count() }} task(s)"
                class="relative flex h-10 items-center justify-center rounded-lg border text-xs font-semibold transition-colors {{ $cellClasses }} {{ $day['isToday'] && ! $day['isSelected'] ? 'ring-2 ring-gold-500' : '' }}">
                {{ $day['date']->day }}
                @if ($day['tasks']->isNotEmpty())
                    <span class="absolute -right-0.5 -top-0.5 flex h-4 min-w-4 items-center justify-center rounded-full px-1 text-[9px] font-bold {{ $isPast ? 'bg-red-500 text-white' : ($day['isSelected'] ? 'bg-gold-500 text-navy-950' : 'bg-navy-900 text-white') }}">
                        {{ $day['tasks']->count() }}
                    </span>
                @endif
            </button>
        @endforeach
    </div>

    <p class="mt-3 text-xs text-slate-400">Click a date to filter tasks. Click it again to clear the filter.</p>
</div>
