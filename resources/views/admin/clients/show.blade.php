<x-admin.layouts.app :title="$client->name">
    <div class="mb-6 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
        <div>
            <a href="{{ route('admin.clients.index') }}" class="text-sm font-medium text-navy-700 hover:underline">← Back to Clients</a>
            <h1 class="mt-1 text-xl font-semibold text-navy-950">{{ $client->name }}</h1>
            <p class="text-sm text-slate-500">
                {{ $client->company ? $client->company . ' · ' : '' }}{{ $client->email ?? $client->phone ?? 'No contact details' }}
            </p>
        </div>
        <div class="flex flex-wrap gap-2">
            <a href="{{ route('admin.clients.invoice', $client) }}" class="inline-flex items-center gap-2 rounded-lg border border-green-200 bg-green-50 px-4 py-2 text-sm font-semibold text-green-800 shadow-sm hover:bg-green-100" title="Download invoice as PDF">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-4 w-4">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75V16.5M16.5 12L12 16.5m0 0L7.5 12m4.5 4.5V3" />
                </svg>
                Download Invoice
            </a>
            <a href="{{ route('admin.payments.create', ['client_id' => $client->id]) }}" class="rounded-lg border border-navy-200 bg-white px-4 py-2 text-sm font-semibold text-navy-800 shadow-sm hover:bg-navy-50">Record Payment</a>
            <a href="{{ route('admin.clients.edit', $client) }}" class="rounded-lg bg-navy-900 px-4 py-2 text-sm font-semibold text-white shadow-sm hover:bg-navy-800">Edit Client</a>
        </div>
    </div>

    <div class="grid grid-cols-2 gap-4 lg:grid-cols-4">
        <div class="rounded-xl bg-white p-5 shadow-sm ring-1 ring-slate-200">
            <p class="text-xs font-semibold uppercase tracking-wider text-slate-500">Works</p>
            <p class="mt-1 text-2xl font-semibold text-navy-950">{{ $totals['works'] }}</p>
        </div>
        <div class="rounded-xl bg-white p-5 shadow-sm ring-1 ring-slate-200">
            <p class="text-xs font-semibold uppercase tracking-wider text-slate-500">Total Amount</p>
            <p class="mt-1 text-2xl font-semibold text-navy-950">₹{{ number_format($totals['total_billed'], 2) }}</p>
        </div>
        <div class="rounded-xl bg-white p-5 shadow-sm ring-1 ring-slate-200">
            <p class="text-xs font-semibold uppercase tracking-wider text-slate-500">Received</p>
            <p class="mt-1 text-2xl font-semibold text-green-700">₹{{ number_format($totals['received'], 2) }}</p>
        </div>
        <div class="rounded-xl bg-white p-5 shadow-sm ring-1 ring-slate-200">
            <p class="text-xs font-semibold uppercase tracking-wider text-slate-500">Pending Amount</p>
            <p class="mt-1 text-2xl font-semibold {{ $totals['balance'] > 0 ? 'text-amber-700' : 'text-green-700' }}">₹{{ number_format($totals['balance'], 2) }}</p>
        </div>
    </div>

    <div class="mt-8 grid grid-cols-1 gap-6 xl:grid-cols-3">
        <div class="xl:col-span-2">
            <div class="rounded-xl bg-white p-6 shadow-sm ring-1 ring-slate-200">
                <h2 class="mb-4 text-base font-semibold text-navy-950">Work Done</h2>

                @if ($client->works->isEmpty())
                    <p class="py-6 text-center text-sm text-slate-500">No work recorded yet.</p>
                @else
                    <div class="space-y-3">
                        @foreach ($client->works as $work)
                            <div class="rounded-lg border border-slate-200 p-4">
                                <div class="flex flex-wrap items-start justify-between gap-2">
                                    <div>
                                        <p class="text-sm font-semibold text-slate-800">{{ $work->title }}</p>
                                        <p class="text-xs text-slate-500">
                                            {{ $work->work_date?->format('d M Y') ?? 'No date' }} ·
                                            <span class="font-medium">{{ $work->status_label }}</span>
                                        </p>
                                    </div>
                                    <div class="flex items-center gap-2">
                                        <span class="text-sm font-semibold text-navy-950">₹{{ number_format((float) $work->amount, 2) }}</span>
                                        <form method="POST" action="{{ route('admin.clients.works.destroy', [$client, $work]) }}" class="delete-form">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="rounded-lg p-1.5 text-slate-400 hover:bg-red-50 hover:text-red-600" title="Delete work">
                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-4 w-4">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                                                </svg>
                                            </button>
                                        </form>
                                    </div>
                                    @php
                                        $workReceived = (float) ($receivedByWork[$work->id] ?? 0);
                                        $workBalance = max(0, (float) $work->amount - $workReceived);
                                    @endphp
                                    <div class="mt-2 flex flex-wrap items-center gap-x-4 gap-y-1 border-t border-slate-100 pt-2 text-xs">
                                        <span class="text-slate-500">Received: <span class="font-medium text-green-700">₹{{ number_format($workReceived, 2) }}</span></span>
                                        <span class="text-slate-500">Pending: <span class="font-medium {{ $workBalance > 0 ? 'text-amber-700' : 'text-green-700' }}">₹{{ number_format($workBalance, 2) }}</span></span>
                                        <a href="{{ route('admin.payments.index', ['client_id' => $client->id]) }}" class="font-medium text-navy-700 hover:underline">Payment history →</a>
                                    </div>
                                </div>
                                @if ($work->description)
                                    <p class="mt-2 text-sm text-slate-600">{{ $work->description }}</p>
                                @endif
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>

            <div class="mt-6 rounded-xl bg-white p-6 shadow-sm ring-1 ring-slate-200">
                <h2 class="mb-4 text-base font-semibold text-navy-950">Payments</h2>
                @if ($client->payments->isEmpty())
                    <p class="py-6 text-center text-sm text-slate-500">No payments recorded yet.</p>
                @else
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-slate-200 text-sm">
                            <thead>
                                <tr class="text-left text-xs font-semibold uppercase tracking-wider text-slate-500">
                                    <th class="py-2 pr-4">Date</th>
                                    <th class="py-2 pr-4">Work</th>
                                    <th class="py-2 pr-4">Method</th>
                                    <th class="py-2 pr-4">Status</th>
                                    <th class="py-2 pr-4 text-right">Amount</th>
                                    <th class="py-2 text-right">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-100">
                                @foreach ($client->payments as $payment)
                                    <tr>
                                        <td class="py-2 pr-4 text-slate-600">{{ $payment->payment_date?->format('d M Y') }}</td>
                                        <td class="py-2 pr-4 text-slate-600">{{ $payment->work?->title ?? '—' }}</td>
                                        <td class="py-2 pr-4 text-slate-600">{{ $payment->method_label }}</td>
                                        <td class="py-2 pr-4">
                                            <span class="inline-flex rounded-full px-2 py-0.5 text-xs font-semibold {{ $payment->status === 'received' ? 'bg-green-50 text-green-700' : 'bg-amber-50 text-amber-700' }}">
                                                {{ ucfirst($payment->status) }}
                                            </span>
                                        </td>
                                        <td class="py-2 pr-4 text-right font-medium text-navy-950">₹{{ number_format((float) $payment->amount, 2) }}</td>
                                        <td class="py-2 text-right">
                                            <a href="{{ route('admin.payments.edit', $payment) }}" class="text-xs font-medium text-navy-700 hover:underline">Edit</a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
            </div>
        </div>

        <div class="space-y-6">
            <div class="rounded-xl bg-white p-6 shadow-sm ring-1 ring-slate-200">
                <h2 class="mb-4 text-base font-semibold text-navy-950">Add Work</h2>
                <form method="POST" action="{{ route('admin.clients.works.store', $client) }}" class="space-y-4">
                    @csrf
                    <x-admin.form-input name="title" label="What was done" required placeholder="E.g. GST return filing for Q1" />
                    <x-admin.form-textarea name="description" label="Details" rows="2" placeholder="Optional details" />
                    <div class="grid grid-cols-2 gap-3">
                        <x-admin.form-input name="work_date" label="When" type="date" />
                        <x-admin.form-input name="amount" label="Amount (₹)" type="number" placeholder="0.00" />
                    </div>
                    <x-admin.form-select name="status" label="Status" :options="$workStatuses" value="pending" required />
                    <button type="submit" class="w-full rounded-lg bg-navy-900 px-4 py-2.5 text-sm font-semibold text-white hover:bg-navy-800">Add Work</button>
                </form>
            </div>

            <div class="rounded-xl bg-white p-6 shadow-sm ring-1 ring-slate-200">
                <h2 class="mb-3 text-sm font-semibold uppercase tracking-wider text-slate-500">Client Details</h2>
                <dl class="space-y-3 text-sm">
                    <div>
                        <dt class="text-xs font-medium text-slate-400">Email</dt>
                        <dd class="mt-0.5 break-all text-slate-700">{{ $client->email ?? '—' }}</dd>
                    </div>
                    <div>
                        <dt class="text-xs font-medium text-slate-400">Phone</dt>
                        <dd class="mt-0.5 text-slate-700">{{ $client->phone ?? '—' }}</dd>
                    </div>
                    <div>
                        <dt class="text-xs font-medium text-slate-400">Location</dt>
                        <dd class="mt-0.5 text-slate-700">{{ $client->location ?? '—' }}</dd>
                    </div>
                    @if ($client->notes)
                        <div>
                            <dt class="text-xs font-medium text-slate-400">Notes</dt>
                            <dd class="mt-0.5 text-slate-700">{{ $client->notes }}</dd>
                        </div>
                    @endif
                </dl>
            </div>
        </div>
    </div>
</x-admin.layouts.app>
