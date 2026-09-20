@php
    $categories = array_combine(\App\Models\Task::CATEGORIES, \App\Models\Task::CATEGORIES);
@endphp

<div class="w-full rounded-xl bg-white p-6 shadow-sm ring-1 ring-slate-200">
    <form method="POST" action="{{ $task->exists ? route('admin.tasks.update', $task) : route('admin.tasks.store') }}">
        @csrf
        @if ($task->exists)
            @method('PUT')
        @endif

        <div class="space-y-4">
            <x-admin.form-input name="title" label="Task Name" :value="$task->title" required placeholder="E.g. File GSTR-3B for September" />

            <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                <x-admin.form-select name="category" label="Category" :options="$categories" :value="$task->category" placeholder="Select category" />
                <x-admin.form-select name="priority" label="Priority" :options="\App\Models\Task::PRIORITIES" :value="$task->priority" required />
            </div>

            <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                <x-admin.form-select name="status" label="Status" :options="\App\Models\Task::STATUSES" :value="$task->status" required />
                <x-admin.form-input name="due_date" label="Deadline" type="date" :value="$task->due_date?->format('Y-m-d')" />
            </div>

            <x-admin.form-textarea name="description" label="Description" :value="$task->description" rows="5" placeholder="Add notes, checklists or the scope of this task..." />

            <x-admin.form-checkbox name="is_active" label="Active" :checked="$task->is_active || ! $task->exists" />
        </div>

        <div class="mt-6 flex items-center gap-3 border-t border-slate-100 pt-5">
            <button type="submit" class="rounded-lg bg-navy-900 px-5 py-2.5 text-sm font-semibold text-white shadow-sm hover:bg-navy-800">
                {{ $task->exists ? 'Update Task' : 'Create Task' }}
            </button>
            <a href="{{ route('admin.tasks.index') }}" class="btn-ghost rounded-lg px-4 py-2.5">Cancel</a>
        </div>
    </form>
</div>
