<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Payments & Earnings Report</title>
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
        .badge { font-size: 10px; }
    </style>
</head>
<body>
    <h1>Payments & Earnings Report</h1>
    <p class="muted">Generated on {{ $generatedAt->format('d M Y, h:i A') }} · {{ $payments->count() }} payment(s)</p>

    <table class="summary">
        <tr>
            <td>
                <div class="label">Total Amount</div>
                <div class="value">₹{{ number_format($totals['billed'], 2) }}</div>
            </td>
            <td>
                <div class="label">Received</div>
                <div class="value">₹{{ number_format($totals['received'], 2) }}</div>
            </td>
            <td>
                <div class="label">Pending Amount</div>
                <div class="value">₹{{ number_format($totals['balance'], 2) }}</div>
            </td>
        </tr>
    </table>

    <table>
        <thead>
            <tr>
                <th>Date</th>
                <th>Client</th>
                <th>Work</th>
                <th class="right">Amount</th>
                <th>Method</th>
                <th>Status</th>
                <th>Reference</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($payments as $payment)
                <tr>
                    <td>{{ $payment->payment_date?->format('d M Y') }}</td>
                    <td>{{ $payment->client?->name ?? '—' }}</td>
                    <td>{{ $payment->work?->title ?? '—' }}</td>
                    <td class="right">₹{{ number_format((float) $payment->amount, 2) }}</td>
                    <td>{{ $payment->method_label }}</td>
                    <td class="badge">{{ ucfirst((string) $payment->status) }}</td>
                    <td>{{ $payment->reference ?? '—' }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="7" style="text-align:center;">No payments found.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</body>
</html>
