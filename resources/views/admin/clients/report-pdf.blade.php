<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Clients Report</title>
    <style>
        * { font-family: DejaVu Sans, sans-serif; }
        body { color: #1e293b; font-size: 12px; }
        h1 { color: #14263d; font-size: 20px; margin: 0 0 4px; }
        .muted { color: #64748b; margin: 0 0 16px; }
        table { width: 100%; border-collapse: collapse; }
        th, td { border: 1px solid #cbd5e1; padding: 6px 8px; text-align: left; }
        th { background: #14263d; color: #fff; font-size: 11px; text-transform: uppercase; }
        tr:nth-child(even) td { background: #f8fafc; }
        .right { text-align: right; }
        .badge { font-size: 10px; }
    </style>
</head>
<body>
    <h1>Clients Report</h1>
    <p class="muted">Generated on {{ $generatedAt->format('d M Y, h:i A') }} · {{ $clients->count() }} client(s)</p>

    <table>
        <thead>
            <tr>
                <th>Name</th>
                <th>Company</th>
                <th>Contact</th>
                <th class="right">Works</th>
                <th class="right">Total Amount</th>
                <th class="right">Received</th>
                <th class="right">Pending Amount</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($clients as $client)
                <tr>
                    <td>{{ $client->name }}</td>
                    <td>{{ $client->company ?? '—' }}</td>
                    <td>{{ $client->email ?? $client->phone ?? '—' }}</td>
                    <td class="right">{{ $client->works_count }}</td>
                    <td class="right">₹{{ number_format((float) $client->total_billed, 2) }}</td>
                    <td class="right">₹{{ number_format((float) $client->received_total, 2) }}</td>
                    <td class="right">₹{{ number_format((float) $client->balance, 2) }}</td>
                    <td class="badge">{{ $client->is_active ? 'Active' : 'Inactive' }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="8" style="text-align:center;">No clients found.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</body>
</html>
