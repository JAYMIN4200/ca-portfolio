<x-admin.layouts.app :title="'Dashboard'">
    <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-4">
        @php
            $cards = [
                ['label' => 'Clients', 'value' => $stats['clients'], 'countable' => true, 'icon' => 'M18 18.72a9.094 9.094 0 003.741-.479 3 3 0 00-4.682-2.72m.94 3.198l.001.031c0 .225-.012.447-.037.666A11.944 11.944 0 0112 21c-2.17 0-4.207-.576-5.963-1.584A6.062 6.062 0 016 18.719m12 0a5.971 5.971 0 00-.941-3.197m0 0A5.995 5.995 0 0012 12.75a5.995 5.995 0 00-5.058 2.772m0 0a3 3 0 00-4.681 2.72 8.986 8.986 0 003.74.477m.94-3.197a5.971 5.971 0 00-.94 3.197M15 6.75a3 3 0 11-6 0 3 3 0 016 0zm6 3a2.25 2.25 0 11-4.5 0 2.25 2.25 0 014.5 0zm-13.5 0a2.25 2.25 0 11-4.5 0 2.25 2.25 0 014.5 0z', 'color' => 'blue'],
                ['label' => 'Upcoming Meetings', 'value' => $stats['meetings_upcoming'], 'countable' => true, 'icon' => 'M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 11.25v7.5m-9-6h.008v.008H12v-.008zM12 15h.008v.008H12V15zm0 2.25h.008v.008H12v-.008zM9.75 15h.008v.008H9.75V15zm0 2.25h.008v.008H9.75v-.008zM7.5 15h.008v.008H7.5V15zm0 2.25h.008v.008H7.5v-.008zm6.75-4.5h.008v.008h-.008v-.008zm0 2.25h.008v.008h-.008V15zm0 2.25h.008v.008h-.008v-.008zm2.25-4.5h.008v.008H16.5v-.008zm0 2.25h.008v.008H16.5V15z', 'color' => 'purple'],
                ['label' => 'Total Amount', 'value' => '₹' . number_format($stats['total_billed'], 2), 'icon' => 'M20.25 6.375c0 2.278-3.694 4.125-8.25 4.125S3.75 8.653 3.75 6.375m16.5 0c0-2.278-3.694-4.125-8.25-4.125S3.75 4.097 3.75 6.375m16.5 0v11.25c0 2.278-3.694 4.125-8.25 4.125s-8.25-1.847-8.25-4.125V6.375m16.5 5.625c0 2.278-3.694 4.125-8.25 4.125s-8.25-1.847-8.25-4.125', 'color' => 'navy'],
                ['label' => 'Received', 'value' => '₹' . number_format($stats['received_total'], 2), 'icon' => 'M2.25 18.75a60.07 60.07 0 0115.797 2.101c.727.198 1.453-.342 1.453-1.096V18.75M3.75 4.5v.75A.75.75 0 013 6h-.75m0 0v-.375c0-.621.504-1.125 1.125-1.125H20.25M2.25 6v9m18-10.5v.75c0 .414.336.75.75.75h.75m-1.5-1.5h.375c.621 0 1.125.504 1.125 1.125v9.75c0 .621-.504 1.125-1.125 1.125h-.375m1.5-1.5H21a.75.75 0 00-.75.75v.75m0 0H3.75m0 0h-.375a1.125 1.125 0 01-1.125-1.125V15m1.5 1.5v-.75A.75.75 0 003 15h-.75M15 10.5a3 3 0 11-6 0 3 3 0 016 0zm3 0h.008v.008H18V10.5zm-12 0h.008v.008H6V10.5z', 'color' => 'green'],
                ['label' => 'Pending Amount', 'value' => '₹' . number_format($stats['pending_amount'], 2), 'icon' => 'M12 6v12m-3-2.818l.879.659c1.171.879 3.07.879 4.242 0 1.172-.879 1.172-2.303 0-3.182C13.536 12.219 12.768 12 12 12c-.725 0-1.45-.22-2.003-.659-1.106-.879-1.106-2.303 0-3.182s2.9-.879 4.006 0l.415.33M21 12a9 9 0 11-18 0 9 9 0 0118 0z', 'color' => 'amber'],
                ['label' => 'Messages', 'value' => $stats['messages'], 'countable' => true, 'icon' => 'M21.75 6.75v10.5a2.25 2.25 0 01-2.25 2.25h-15a2.25 2.25 0 01-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25m19.5 0v.243a2.25 2.25 0 01-1.07 1.916l-7.5 4.615a2.25 2.25 0 01-2.36 0L3.32 8.91a2.25 2.25 0 01-1.07-1.916V6.75', 'color' => 'cyan'],
                ['label' => 'Unread Messages', 'value' => $stats['unread_messages'], 'countable' => true, 'icon' => 'M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z', 'color' => 'amber'],
                ['label' => 'Visits Today', 'value' => $stats['visits_today'], 'countable' => true, 'icon' => 'M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178zM15 12a3 3 0 11-6 0 3 3 0 016 0z', 'color' => 'navy'],
                ['label' => 'Total Visits', 'value' => $stats['visits_total'], 'countable' => true, 'icon' => 'M15 19.128a9.38 9.38 0 002.625.372 9.337 9.337 0 004.121-.952 4.125 4.125 0 00-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 018.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0111.964-3.07M12 6.375a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zm8.25 2.25a2.625 2.625 0 11-5.25 0 2.625 2.625 0 015.25 0z', 'color' => 'gold'],
            ];
        @endphp

        @foreach ($cards as $card)
            <x-admin.stat-card :label="$card['label']" :value="$card['value']" :icon="$card['icon']" :color="$card['color']" />
        @endforeach
    </div>

    <div class="mt-8 grid grid-cols-1 gap-6 lg:grid-cols-3">
        <div class="flex h-full flex-col rounded-xl bg-white p-6 shadow-sm ring-1 ring-slate-200 lg:col-span-2">
            <h2 class="text-base font-semibold text-navy-950">Visits — last 7 days</h2>
            @php $maxCount = max(1, $trendData->max()); @endphp
            <div class="mt-6 flex flex-1 items-end gap-2 sm:gap-3">
                @foreach ($trendData as $index => $count)
                    @php $barHeight = max(8, round(($count / $maxCount) * 120)); @endphp
                    <div class="flex h-full flex-1 flex-col items-center justify-end gap-1.5">
                        <span class="text-xs font-semibold text-navy-950">{{ $count }}</span>
                        <div class="w-full max-w-12 rounded-t-lg bg-gradient-to-t from-navy-800 to-gold-500" style="height: {{ $barHeight }}px;"></div>
                    </div>
                @endforeach
            </div>
            <div class="mt-2 flex gap-2 sm:gap-3">
                @foreach ($trendLabels as $label)
                    <span class="flex-1 truncate text-center text-[10px] font-medium text-slate-400">{{ $label }}</span>
                @endforeach
            </div>
        </div>

        <div class="rounded-xl bg-white p-6 shadow-sm ring-1 ring-slate-200">
            <h2 class="text-base font-semibold text-navy-950">Recent Visitors</h2>
            @if ($recentVisits->isEmpty())
                <p class="py-8 text-center text-sm text-slate-500">No visits yet — visit the public site to see activity.</p>
            @else
                <ul class="mt-2 divide-y divide-slate-100">
                    @foreach ($recentVisits as $visit)
                        <li class="flex items-center gap-3 py-2.5">
                            <span class="flex h-8 w-8 shrink-0 items-center justify-center rounded-lg bg-navy-50 text-navy-700">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-4 w-4">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 21h19.5m-18-18v18m10.5-18v18m6-13.5V21M6.75 6.75h.75m-.75 3h.75m-.75 3h.75m3-6h.75m-.75 3h.75m-.75 3h.75M6.75 21v-3.375c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21M3 3h12m-.75 4.5H21m-3.75 3.75h.008v.008h-.008v-.008zm0 3h.008v.008h-.008v-.008zm0 3h.008v.008h-.008v-.008z" />
                                </svg>
                            </span>
                            <div class="min-w-0 flex-1">
                                <p class="truncate text-sm font-medium text-slate-800">{{ $visit->ip_address ?? 'Unknown' }}</p>
                                <p class="truncate text-xs text-slate-500">{{ parse_url($visit->url ?? '/', PHP_URL_PATH) }} · {{ $visit->created_at->diffForHumans() }}</p>
                            </div>
                        </li>
                    @endforeach
                </ul>
            @endif
        </div>
    </div>

    <div class="mt-8 rounded-xl bg-white p-6 shadow-sm ring-1 ring-slate-200"
        data-financial-chart
        data-endpoint="{{ route('admin.dashboard.financials') }}"
        data-period="{{ $financialPeriod ?? 'week' }}"
        data-type="{{ $financialType ?? 'overlay' }}">
        <div class="mb-4 flex flex-wrap items-center justify-between gap-4">
            <h2 class="text-base font-semibold text-navy-950">Expenses vs Payments</h2>
            <div class="flex flex-wrap items-center gap-2">
                <div class="inline-flex rounded-lg bg-slate-100 p-1">
                    @foreach (['week' => 'Week', 'month' => 'Month', 'year' => 'Year'] as $value => $label)
                        <button type="button" data-financial-period="{{ $value }}"
                            class="rounded-md px-3 py-1.5 text-sm font-medium transition {{ ($financialPeriod ?? 'week') === $value ? 'bg-white text-navy-900 shadow-sm' : 'text-slate-600 hover:text-navy-800' }}">
                            {{ $label }}
                        </button>
                    @endforeach
                </div>
                <select data-financial-type data-custom-select class="w-48 rounded-lg border border-slate-300 px-3 py-2.5 text-sm text-slate-800 shadow-sm focus:border-navy-500 focus:ring-navy-500">
                    @foreach (['overlay' => 'Expenses & Payments', 'expenses' => 'Expenses only', 'payments' => 'Payments only'] as $value => $label)
                        <option value="{{ $value }}" {{ ($financialType ?? 'overlay') === $value ? 'selected' : '' }}>{{ $label }}</option>
                    @endforeach
                </select>
            </div>
        </div>

        <div id="financialChartPanel">
            @include('admin.partials.financial-chart', [
                'financialLabels' => $financialLabels ?? [],
                'financialExpenses' => $financialExpenses ?? [],
                'financialPayments' => $financialPayments ?? [],
                'financialType' => $financialType ?? 'overlay',
            ])
        </div>
    </div>

    <div class="mt-8 grid grid-cols-1 gap-6 xl:grid-cols-3">
        <div class="rounded-xl bg-white p-6 shadow-sm ring-1 ring-slate-200 xl:col-span-2"
            data-meeting-calendar data-endpoint="{{ route('admin.dashboard.calendar') }}" data-month="{{ $calendarMonth->format('Y-m') }}">
            <div id="meetingCalendarPanel">
                @include('admin.partials.meeting-calendar')
            </div>
        </div>

        <div class="rounded-xl bg-white p-6 shadow-sm ring-1 ring-slate-200">
            <div class="mb-4 flex items-center justify-between">
                <h2 class="text-base font-semibold text-navy-950">Upcoming Meetings</h2>
                <a href="{{ route('admin.meetings.index') }}" class="text-sm font-medium text-navy-700 hover:text-navy-900">View all</a>
            </div>
            @if ($upcomingMeetings->isEmpty())
                <p class="py-8 text-center text-sm text-slate-500">No upcoming meetings.</p>
            @else
                <ul class="divide-y divide-slate-100">
                    @foreach ($upcomingMeetings as $meeting)
                        <li class="flex items-center gap-3 py-3">
                            <div class="flex h-11 w-11 shrink-0 flex-col items-center justify-center rounded-lg bg-navy-50 text-navy-800">
                                <span class="text-[10px] font-semibold uppercase">{{ $meeting->meeting_date->format('M') }}</span>
                                <span class="text-sm font-bold leading-none">{{ $meeting->meeting_date->format('d') }}</span>
                            </div>
                            <div class="min-w-0 flex-1">
                                <p class="truncate text-sm font-medium text-slate-800">{{ $meeting->title }}</p>
                                <p class="truncate text-xs text-slate-500">
                                    {{ $meeting->name }}
                                    · {{ $meeting->start_time ? \Illuminate\Support\Str::of($meeting->start_time)->substr(0, 5) : $meeting->type_label }}
                                </p>
                            </div>
                            <a href="{{ route('admin.meetings.edit', $meeting) }}" class="text-xs font-medium text-navy-700 hover:text-navy-900">Edit →</a>
                        </li>
                    @endforeach
                </ul>
            @endif
        </div>
    </div>

    <div class="mt-8 grid grid-cols-1 gap-6 lg:grid-cols-2">
        <div class="rounded-xl bg-white p-6 shadow-sm ring-1 ring-slate-200">
            <div class="mb-4 flex items-center justify-between">
                <h2 class="text-base font-semibold text-navy-950">Recent Messages</h2>
                <a href="{{ route('admin.messages.index') }}" class="text-sm font-medium text-navy-700 hover:text-navy-900">View all</a>
            </div>
            @if ($recentMessages->isEmpty())
                <p class="py-8 text-center text-sm text-slate-500">No messages yet.</p>
            @else
                <ul class="divide-y divide-slate-100">
                    @foreach ($recentMessages as $message)
                        <li class="flex items-center gap-4 py-3">
                            <div class="min-w-0 flex-1">
                                <p class="truncate text-sm font-medium text-slate-800">
                                    @if (!$message->is_read)
                                        <span class="mr-2 inline-block h-2 w-2 rounded-full bg-red-500"></span>
                                    @endif
                                    {{ $message->name }}
                                </p>
                                <p class="truncate text-xs text-slate-500">{{ $message->subject ?? 'No subject' }} · {{ $message->created_at->diffForHumans() }}</p>
                            </div>
                            <a href="{{ route('admin.messages.show', $message) }}" class="text-xs font-medium text-navy-700 hover:text-navy-900">View →</a>
                        </li>
                    @endforeach
                </ul>
            @endif
        </div>

        <div class="rounded-xl bg-white p-6 shadow-sm ring-1 ring-slate-200">
            <div class="mb-4 flex items-center justify-between">
                <h2 class="text-base font-semibold text-navy-950">Recent Assignments</h2>
                <a href="{{ route('admin.assignments.index') }}" class="text-sm font-medium text-navy-700 hover:text-navy-900">View all</a>
            </div>
            @if ($recentlyCreated['assignments']->isEmpty())
                <p class="py-8 text-center text-sm text-slate-500">No assignments yet.</p>
            @else
                <ul class="divide-y divide-slate-100">
                    @foreach ($recentlyCreated['assignments'] as $assignment)
                        <li class="flex items-center justify-between gap-4 py-3">
                            <div class="min-w-0">
                                <p class="truncate text-sm font-medium text-slate-800">{{ $assignment->title }}</p>
                                <p class="truncate text-xs text-slate-500">{{ $assignment->category ?? 'Uncategorized' }} · {{ $assignment->created_at->diffForHumans() }}</p>
                            </div>
                            <span class="rounded-full bg-slate-100 px-2 py-0.5 text-xs font-medium {{ $assignment->is_active ? 'text-green-700' : 'text-slate-500' }}">
                                {{ $assignment->is_active ? 'Active' : 'Inactive' }}
                            </span>
                        </li>
                    @endforeach
                </ul>
            @endif
        </div>
    </div>
</x-admin.layouts.app>