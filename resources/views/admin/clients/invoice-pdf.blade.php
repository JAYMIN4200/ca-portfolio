<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Invoice {{ $invoiceNumber }}</title>
    <style>
        * { font-family: DejaVu Sans, sans-serif; }
        body { color: #1e293b; font-size: 12px; line-height: 1.5; }
        .header { border-bottom: 3px solid #14263d; padding-bottom: 16px; margin-bottom: 20px; overflow: hidden; }
        .brand { float: left; }
        .brand h1 { margin: 0; color: #14263d; font-size: 22px; }
        .brand p { margin: 2px 0 0; color: #64748b; font-size: 11px; }
        .invoice-title { float: right; text-align: right; }
        .invoice-title h2 { margin: 0; color: #14263d; font-size: 20px; }
        .invoice-title p { margin: 2px 0 0; color: #64748b; font-size: 11px; }
        .section { width: 100%; margin-bottom: 18px; }
        .section-title { color: #14263d; font-size: 12px; text-transform: uppercase; letter-spacing: .5px; margin-bottom: 6px; font-weight: bold; }
        .to-block { width: 48%; }
        .to-block p { margin: 1px 0; }
        .label { color: #64748b; font-size: 10px; text-transform: uppercase; }
        .value { color: #334155; }
        table { width: 100%; border-collapse: collapse; }
        th, td { border: 1px solid #cbd5e1; padding: 6px 8px; text-align: left; }
        th { background: #14263d; color: #fff; font-size: 10px; text-transform: uppercase; }
        tr:nth-child(even) td { background: #f8fafc; }
        .right { text-align: right; }
        .badge { font-size: 10px; }
        .totals { width: 100%; margin-top: 20px; }
        .totals td { border: none; padding: 4px 8px; }
        .totals .row-label { color: #64748b; font-size: 11px; text-align: right; }
        .totals .row-value { font-weight: bold; color: #14263d; text-align: right; font-size: 12px; }
        .totals .grand { font-size: 14px; }
        .foot { margin-top: 24px; border-top: 1px solid #e2e8f0; padding-top: 10px; color: #94a3b8; font-size: 10px; text-align: center; }
        .divider { height: 1px; background: #f1f5f9; margin: 14px 0; }
        .summary-box { border: 1px solid #e2e8f0; border-radius: 8px; padding: 10px 14px; margin-bottom: 16px; }
        .summary-box span { display: inline-block; margin-right: 22px; }
        .summary-box .lbl { color: #64748b; font-size: 10px; text-transform: uppercase; }
        .summary-box .val { font-weight: bold; color: #14263d; font-size: 13px; }
    </style>
</head>
<body>
    <div class="header">
        <div class="brand">
            <h1>{{ $business['name'] }}</h1>
            <p>{{ $business['email'] }}</p>
            <p>@if ($business['phone']){{ $business['phone'] }}@endif</p>
            <p>@if ($business['location']){{ $business['location'] }}@endif</p>
        </div>
        <div class="invoice-title">
            <h2>Invoice</h2>
            <p>{{ $invoiceNumber }}</p>
            <p>Date: {{ $generatedAt->format('d M Y') }}</p>
        </div>
    </div>

    <div class="section">
        <div class="section-title">Billed To</div>
        <table class="to-block">
            <tr>
                <td style="border:none; padding:0;"><span class="label">Client</span></td>
                <td style="border:none; padding:0; text-align:right;"><span class="value">{{ $client->name }}</span></td>
            </tr>
            @if ($client->company)
                <tr>
                    <td style="border:none; padding:0;"><span class="label">Company</span></td>
                    <td style="border:none; padding:0; text-align:right;"><span class="value">{{ $client->company }}</span></td>
                </tr>
            @endif
            @if ($client->email)
                <tr>
                    <td style="border:none; padding:0;"><span class="label">Email</span></td>
                    <td style="border:none; padding:0; text-align:right;"><span class="value">{{ $client->email }}</span></td>
                </tr>
            @endif
            @if ($client->phone)
                <tr>
                    <td style="border:none; padding:0;"><span class="label">Phone</span></td>
                    <td style="border:none; padding:0; text-align:right;"><span class="value">{{ $client->phone }}</span></td>
                </tr>
            @endif
            @if ($client->location)
                <tr>
                    <td style="border:none; padding:0;"><span class="label">Location</span></td>
                    <td style="border:none; padding:0; text-align:right;"><span class="value">{{ $client->location }}</span></td>
                </tr>
            @endif
        </table>
    </div>

    <div class="summary-box">
        <span>
            <span class="lbl">Total Amount</span><br>
            <span class="val">₹{{ number_format($totals['total_billed'], 2) }}</span>
        </span>
        <span>
            <span class="lbl">Received</span><br>
            <span class="val">₹{{ number_format($totals['received'], 2) }}</span>
        </span>
        <span>
            <span class="lbl">Pending Amount</span><br>
            <span class="val">₹{{ number_format($totals['balance'], 2) }}</span>
        </span>
    </div>

    <div class="section">
        <div class="section-title">Work &amp; Services</div>
        <table>
            <thead>
                <tr>
                    <th>Date</th>
                    <th>Work / Task</th>
                    <th>Status</th>
                    <th class="right">Amount</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($works as $work)
                    <tr>
                        <td>{{ $work->work_date?->format('d M Y') ?? '—' }}</td>
                        <td>
                            <strong>{{ $work->title }}</strong>
                            @if ($work->description)
                                <br><span style="color:#64748b; font-size:11px;">{{ $work->description }}</span>
                            @endif
                        </td>
                        <td class="badge">{{ $work->status_label }}</td>
                        <td class="right">₹{{ number_format((float) $work->amount, 2) }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" style="text-align:center;">No work recorded.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="section">
        <div class="section-title">Payments Received</div>
        <table>
            <thead>
                <tr>
                    <th>Date</th>
                    <th>Method</th>
                    <th>Status</th>
                    <th class="right">Amount</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($payments as $payment)
                    <tr>
                        <td>{{ $payment->payment_date?->format('d M Y') }}</td>
                        <td>{{ $payment->method_label }}</td>
                        <td class="badge">{{ ucfirst((string) $payment->status) }}</td>
                        <td class="right">₹{{ number_format((float) $payment->amount, 2) }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" style="text-align:center;">No payments received.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <table class="totals">
        <tr>
            <td class="row-label">Total Amount</td>
            <td class="row-value">₹{{ number_format($totals['total_billed'], 2) }}</td>
        </tr>
        <tr>
            <td class="row-label">Received</td>
            <td class="row-value" style="color:#15803d;">− ₹{{ number_format($totals['received'], 2) }}</td>
        </tr>
        <tr>
            <td class="row-label">Pending Amount</td>
            <td class="row-value grand" style="color:#b91c1c;">₹{{ number_format($totals['balance'], 2) }}</td>
        </tr>
    </table>

    <div class="foot">
        This invoice was generated on {{ $generatedAt->format('d M Y, h:i A') }} · Thank you for your business.
    </div>
</body>
</html>