<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Expenses Report</title>
    <style>
        * { font-family: DejaVu Sans, sans-serif; }
        body { color: #1e293b; font-size: 12px; }
        h1 { color: #14263d; font-size: 20px; margin: 0 0 4px; }
        .muted { color: #64748b; margin: 0 0 16px; }
        .summary { width: 100%; margin-bottom: 16px; border-collapse: collapse; }
        .summary td { border: 1px solid #cbd5e1; padding: 8px; width: 33.33%; }
        .summary .label { color: #64748b; font-size: 10px; text-transform: uppercase; }
        .summary .value { font-size: 16px; font-weight: bold; color: #14263d; }
        table { width: 100%; border-collapse: collapse; }
        th, td { border: 1px solid #cbd5e1; padding: 6px 8px; text-align: left; }
        th { background: #14263d; color: #fff; font-size: 11px; text-transform: uppercase; }
        tr:nth-child(even) td { background: #f8fafc; }
        .right { text-align: right; }
    </style>
</head>
<body>
    <h1>Expenses Report</h1>
    <p class="muted">Generated on {{ $generatedAt->format('d M Y, h:i A') }} · {{ $expenses->count() }} expense(s)</p>

    <table class="summary">
        <tr>
            <td>
                <div class="label">Total Expenses</div>
                <div class="value">₹{{ number_format($totals['total'], 2) }}</div>
            </td>
            <td>
                <div class="label">This Month</div>
                <div class="value">₹{{ number_format($totals['this_month'], 2) }}</div>
            </td>
            <td>
                <div class="label">Entries</div>
                <div class="value">{{ number_format($totals['count']) }}</div>
            </td>
        </tr>
    </table>

    <table>
        <thead>
            <tr>
                <th>Date</th>
                <th>Category</th>
                <th>Description</th>
                <th>Client</th>
                <th class="right">Amount</th>
                <th>Method</th>
                <th>Reference</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($expenses as $expense)
                <tr>
                    <td>{{ $expense->expense_date?->format('d M Y') }}</td>
                    <td>{{ $expense->category_label }}</td>
                    <td>{{ $expense->description ?? '—' }}</td>
                    <td>{{ $expense->client?->name ?? '—' }}</td>
                    <td class="right">₹{{ number_format((float) $expense->amount, 2) }}</td>
                    <td>{{ $expense->method ?? '—' }}</td>
                    <td>{{ $expense->reference ?? '—' }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="7" style="text-align:center;">No expenses found.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</body>
</html>