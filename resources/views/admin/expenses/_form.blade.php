@php
    $clientOptions = $clients->pluck('name', 'id')->all();
    $methods = collect(\App\Models\Payment::METHODS)
        ->map(fn ($label) => $label)
        ->all();
@endphp

<div class="space-y-4">
    <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
        <x-admin.form-select name="category" label="Category" :options="\App\Models\Expense::CATEGORIES" :value="$expense?->category" required placeholder="Select a category" data-conditional-select="custom-category-wrap" data-conditional-value="other" />
        <x-admin.form-select name="client_id" label="Client (optional)" :options="$clientOptions" :value="$expense?->client_id ?? $selectedClient ?? null" placeholder="Optional — link to a client" />
    </div>
    <div id="custom-category-wrap" data-conditional-wrap class="hidden">
        <x-admin.form-input name="custom_category" label="Custom Category" :value="$expense?->custom_category" placeholder="E.g. Client Lunch / Festival / Event" required />
    </div>
    <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
        <x-admin.form-input name="amount" label="Amount (₹)" type="number" step="0.01" min="0" :value="$expense?->amount" required placeholder="0.00" />
        <x-admin.form-input name="expense_date" label="Expense Date" type="date" :value="$expense?->expense_date?->format('Y-m-d') ?? now()->format('Y-m-d')" required />
    </div>
    <x-admin.form-input name="description" label="Description" :value="$expense?->description" placeholder="What was this expense for?" />
    <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
        <x-admin.form-select name="method" label="Payment Method" :options="$methods" :value="$expense?->method" placeholder="Select method" />
        <x-admin.form-input name="reference" label="Reference / Bill No." :value="$expense?->reference" placeholder="E.g. BILL-2026-001" />
    </div>
</div>