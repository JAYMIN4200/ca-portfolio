@php
    $meeting = $meeting ?? null;
    $clientOptions = $clients->pluck('name', 'id')->all();
@endphp

<div class="space-y-4">
    <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
        <x-admin.form-select name="client_id" label="Linked Client" :options="$clientOptions" :value="$meeting?->client_id ?? $selectedClient ?? null" placeholder="Optional — link to a client" />
        <x-admin.form-input name="title" label="Meeting Title" :value="$meeting?->title" required placeholder="E.g. Tax filing consultation" />
    </div>
    <div class="grid grid-cols-1 gap-4 sm:grid-cols-3">
        <x-admin.form-input name="name" label="Name" :value="$meeting?->name" required placeholder="Person's name" />
        <x-admin.form-input name="email" label="Email" type="email" :value="$meeting?->email" placeholder="person@example.com" />
        <x-admin.form-input name="phone" label="Phone" :value="$meeting?->phone" placeholder="+91 98765 43210" />
    </div>
    <div class="grid grid-cols-1 gap-4 sm:grid-cols-3">
        <x-admin.form-input name="meeting_date" label="Date" type="date" :value="$meeting?->meeting_date?->format('Y-m-d') ?? $selectedDate" required />
        <x-admin.form-input name="start_time" label="Start Time" type="time" :value="$meeting?->start_time ? \Illuminate\Support\Str::of($meeting->start_time)->substr(0, 5) : null" />
        <x-admin.form-input name="end_time" label="End Time" type="time" :value="$meeting?->end_time ? \Illuminate\Support\Str::of($meeting->end_time)->substr(0, 5) : null" />
    </div>
    <div class="grid grid-cols-1 gap-4 sm:grid-cols-3">
        <x-admin.form-select name="type" label="Meeting Type" :options="$types" :value="$meeting?->type ?? 'in_person'" required />
        <x-admin.form-select name="status" label="Status" :options="$statuses" :value="$meeting?->status ?? 'pending'" required />
        <x-admin.form-input name="location" label="Location / Link" :value="$meeting?->location" placeholder="Office or meeting link" />
    </div>
    <x-admin.form-textarea name="notes" label="Notes" rows="3" :value="$meeting?->notes" placeholder="Agenda or preparation notes." />
</div>
