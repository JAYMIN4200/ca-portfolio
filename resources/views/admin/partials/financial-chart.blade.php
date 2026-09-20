@php
    $chartExpenses = $financialExpenses ?? [];
    $chartPayments = $financialPayments ?? [];
    $chartLabels = $financialLabels ?? [];
    $chartType = $financialType ?? 'overlay';
    $showExpenses = in_array($chartType, ['overlay', 'expenses'], true);
    $showPayments = in_array($chartType, ['overlay', 'payments'], true);
    $chartMax = max(1, max((float) (max($chartExpenses) ?? 0), (float) (max($chartPayments) ?? 0)));
@endphp

<div class="relative">
    <div class="flex h-56 items-end gap-2 sm:gap-3">
        @forelse ($chartLabels as $index => $label)
            @php
                $expenseBar = (float) ($chartExpenses[$index] ?? 0);
                $paymentBar = (float) ($chartPayments[$index] ?? 0);
                $expenseHeight = max(4, round(($expenseBar / $chartMax) * 208));
                $paymentHeight = max(4, round(($paymentBar / $chartMax) * 208));
            @endphp
            <div class="flex flex-1 flex-col items-center gap-2">
                <div class="flex h-44 w-full items-end justify-center gap-1">
                    @if ($showExpenses)
                        <div class="w-full max-w-4 rounded-t-md bg-amber-500/80" style="height: {{ $expenseHeight }}px;" title="Expense: ₹{{ number_format($expenseBar, 2) }}"></div>
                    @endif
                    @if ($showPayments)
                        <div class="w-full max-w-4 rounded-t-md bg-navy-700/80" style="height: {{ $paymentHeight }}px;" title="Payment: ₹{{ number_format($paymentBar, 2) }}"></div>
                    @endif
                </div>
                <span class="truncate text-[10px] font-medium text-slate-400">{{ $label }}</span>
            </div>
        @empty
            <p class="py-8 text-center text-sm text-slate-500">No data for the selected period.</p>
        @endforelse
    </div>
</div>

<div class="mt-3 flex items-center gap-4 text-xs text-slate-600">
    @if ($showExpenses)
        <span class="inline-flex items-center gap-1.5"><span class="h-2.5 w-2.5 rounded-sm bg-amber-500/80"></span> Expenses</span>
    @endif
    @if ($showPayments)
        <span class="inline-flex items-center gap-1.5"><span class="h-2.5 w-2.5 rounded-sm bg-navy-700/80"></span> Payments</span>
    @endif
</div>