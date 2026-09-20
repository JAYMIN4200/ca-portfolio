<div class="rounded-xl border border-navy-100 bg-navy-50/50 p-4" data-summary-box>
    <div class="flex flex-wrap items-center justify-between gap-2">
        <p class="text-sm font-semibold text-navy-950">{{ $summary['name'] }}</p>
        <span class="rounded-full bg-navy-100 px-2.5 py-0.5 text-xs font-semibold text-navy-800">Payment Summary</span>
    </div>

    <div class="mt-3 grid grid-cols-2 gap-3 sm:grid-cols-3">
        <div class="rounded-lg bg-white p-3 ring-1 ring-slate-200">
            <p class="text-xs font-medium text-slate-500">Total Amount</p>
            <p class="mt-0.5 text-sm font-semibold text-navy-950" data-summary-field="total_billed">₹{{ number_format($summary['total_billed'], 2) }}</p>
        </div>
        <div class="rounded-lg bg-white p-3 ring-1 ring-slate-200">
            <p class="text-xs font-medium text-slate-500">Received</p>
            <p class="mt-0.5 text-sm font-semibold text-green-700" data-summary-field="received">₹{{ number_format($summary['received'], 2) }}</p>
        </div>
        <div class="rounded-lg bg-white p-3 ring-1 ring-slate-200">
            <p class="text-xs font-medium text-slate-500">Pending Amount</p>
            <p class="mt-0.5 text-sm font-semibold {{ $summary['balance'] > 0 ? 'text-red-600' : 'text-green-700' }}" data-summary-field="balance">₹{{ number_format($summary['balance'], 2) }}</p>
        </div>
    </div>

    @if ($summary['work'])
        <div class="mt-3 flex flex-wrap items-center gap-x-4 gap-y-1 rounded-lg bg-white p-3 text-xs ring-1 ring-slate-200">
            <span class="font-semibold text-slate-700">{{ $summary['work']['title'] }}</span>
            <span class="text-slate-500">Work Total: <span class="font-medium text-navy-950">₹{{ number_format($summary['work']['amount'], 2) }}</span></span>
            <span class="text-slate-500">Work Received: <span class="font-medium text-green-700">₹{{ number_format($summary['work']['received'], 2) }}</span></span>
            <span class="text-slate-500">Work Pending: <span class="font-medium {{ $summary['work']['balance'] > 0 ? 'text-red-600' : 'text-green-700' }}">₹{{ number_format($summary['work']['balance'], 2) }}</span></span>
        </div>
    @endif

    @if (! empty($summary['history']))
        <div class="mt-3">
            <p class="text-xs font-semibold uppercase tracking-wider text-slate-500">Recent Payments</p>
            <div class="mt-1.5 overflow-hidden rounded-lg bg-white ring-1 ring-slate-200">
                <table class="min-w-full divide-y divide-slate-100 text-sm">
                    <tbody class="divide-y divide-slate-100" data-summary-history>
                        @foreach ($summary['history'] as $payment)
                            <tr>
                                <td class="px-3 py-2 text-xs text-slate-600">{{ $payment['date'] }}</td>
                                <td class="px-3 py-2 text-xs text-slate-600">{{ $payment['method'] }}</td>
                                <td class="px-3 py-2 text-right text-xs font-medium text-navy-950">₹{{ number_format($payment['amount'], 2) }}</td>
                                <td class="px-3 py-2 text-right">
                                    <span class="inline-flex rounded-full px-2 py-0.5 text-[10px] font-semibold {{ $payment['status'] === 'received' ? 'bg-green-50 text-green-700' : 'bg-amber-50 text-amber-700' }}">
                                        {{ ucfirst($payment['status']) }}
                                    </span>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    @endif
</div>