@php
    $clientOptions = $clients->pluck('name', 'id')->all();
    $workOptions = $works->mapWithKeys(fn ($work) => [
        $work->id => ($work->client?->name ? $work->client->name . ' — ' : '') . $work->title,
    ])->all();
@endphp

<div class="space-y-4">
    <div data-payment-summary data-endpoint="{{ route('admin.payments.summary') }}">
        @if (! empty($summary))
            @include('admin.payments._summary-partial', ['summary' => $summary])
        @endif
    </div>

    <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
        <x-admin.form-select name="client_id" label="Client" :options="$clientOptions" :value="$payment?->client_id ?? $selectedClient ?? null" required placeholder="Select a client" data-summary-client />
        <x-admin.form-select name="client_work_id" label="Related Work" :options="$workOptions" :value="$payment?->client_work_id" placeholder="Optional — link to a work" data-summary-work />
    </div>
    <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
        <x-admin.form-input name="amount" label="Amount (₹)" type="number" step="0.01" min="0" :value="$payment?->amount" required placeholder="0.00" />
        <x-admin.form-input name="payment_date" label="Payment Date" type="date" :value="$payment?->payment_date?->format('Y-m-d') ?? now()->format('Y-m-d')" required />
    </div>
    <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
        <x-admin.form-select name="method" label="Payment Method" :options="$methods" :value="$payment?->method" placeholder="Select method" />
        <x-admin.form-select name="status" label="Status" :options="['received' => 'Received', 'pending' => 'Pending']" :value="$payment?->status ?? 'received'" required />
    </div>
    <x-admin.form-input name="reference" label="Reference / Invoice No." :value="$payment?->reference" placeholder="E.g. INV-2026-001" />
    <x-admin.form-textarea name="notes" label="Notes" rows="3" :value="$payment?->notes" placeholder="Optional notes about this payment." />
</div>
