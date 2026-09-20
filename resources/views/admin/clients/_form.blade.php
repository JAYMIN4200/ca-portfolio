@php
    $client = $client ?? null;
@endphp

<div class="space-y-4">
    <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
        <x-admin.form-input name="name" label="Client Name" :value="$client?->name" required placeholder="E.g. Rajesh Sharma" />
        <x-admin.form-input name="company" label="Company / Firm" :value="$client?->company" placeholder="E.g. Sharma Traders Pvt Ltd" />
        <x-admin.form-input name="email" label="Email" type="email" :value="$client?->email" placeholder="client@example.com" />
        <x-admin.form-input name="phone" label="Phone" :value="$client?->phone" placeholder="+91 98765 43210" />
    </div>
    <x-admin.form-input name="location" label="Location" :value="$client?->location" placeholder="City, State" />
    <x-admin.form-textarea name="notes" label="Notes" rows="3" :value="$client?->notes" placeholder="Any background or context about this client." />
    <div class="grid grid-cols-2 gap-4">
        <x-admin.form-input name="display_order" label="Display Order" type="number" min="0" :value="$client?->display_order ?? 0" placeholder="0" />
        <div class="pt-6">
            <x-admin.form-checkbox name="is_active" label="Active" :checked="$client?->is_active ?? true" />
        </div>
    </div>
</div>
