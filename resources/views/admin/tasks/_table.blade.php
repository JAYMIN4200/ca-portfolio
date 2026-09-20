@php
    $statusStyles = [
        'pending' => 'bg-slate-100 text-slate-700',
        'in_progress' => 'bg-blue-100 text-blue-700',
        'done' => 'bg-green-100 text-green-700',
        'hold' => 'bg-amber-100 text-amber-700',
    ];
    $priorityStyles = [
        'low' => 'bg-slate-100 text-slate-600',
        'medium' => 'bg-amber-100 text-amber-700',
        'high' => 'bg-red-100 text-red-700',
    ];
@endphp

<div class="overflow-hidden rounded-xl bg-white shadow-sm ring-1 ring-slate-200">
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-slate-200">
            <thead class="bg-slate-50">
                <tr>
                    <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider text-slate-500">Task</th>
                    <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider text-slate-500">Priority</th>
                    <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider text-slate-500">Status</th>
                    <th class="hidden px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider text-slate-500 sm:table-cell">Due Date</th>
                    <th class="hidden px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider text-slate-500 lg:table-cell">Active</th>
                    <th class="px-4 py-3 text-right text-xs font-semibold uppercase tracking-wider text-slate-500">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                @forelse ($tasks as $task)
                    <tr>
                        <td class="px-4 py-3">
                            <p class="text-sm font-medium text-slate-800">{{ $task->title }}</p>
                            <div class="mt-1 flex flex-wrap items-center gap-2">
                                @if ($task->category)
                                    <span class="rounded-full bg-navy-50 px-2 py-0.5 text-xs font-medium text-navy-700">{{ $task->category }}</span>
                                @endif
                                @if (! $task->is_active)
                                    <span class="rounded-full bg-slate-100 px-2 py-0.5 text-xs font-medium text-slate-500">Inactive</span>
                                @endif
                                @if ($task->is_overdue)
                                    <span class="rounded-full bg-red-100 px-2 py-0.5 text-xs font-semibold text-red-700">Overdue</span>
                                @endif
                            </div>
                        </td>
                        <td class="px-4 py-3">
                            <span class="rounded-full px-2 py-0.5 text-xs font-semibold {{ $priorityStyles[$task->priority] ?? 'bg-slate-100 text-slate-600' }}">{{ $task->priority_label }}</span>
                        </td>
                        <td class="px-4 py-3">
                            <form method="POST" action="{{ route('admin.tasks.status', $task) }}">
                                @csrf
                                @method('PATCH')
                                <select name="status" onchange="this.form.submit()" data-custom-select
                                    class="w-max max-w-full rounded-lg border border-slate-300 py-1 pl-2 pr-7 text-xs font-medium text-slate-700 shadow-sm focus:border-navy-500 focus:ring-navy-500 {{ $statusStyles[$task->status] ?? '' }}">
                                    @foreach (\App\Models\Task::STATUSES as $value => $label)
                                        <option value="{{ $value }}" {{ $task->status === $value ? 'selected' : '' }}>{{ $label }}</option>
                                    @endforeach
                                </select>
                            </form>
                        </td>
                        <td class="hidden px-4 py-3 sm:table-cell">
                            @if ($task->due_date)
                                <span class="text-sm {{ $task->is_overdue ? 'font-semibold text-red-600' : 'text-slate-600' }}">{{ $task->due_date->format('d M Y') }}</span>
                            @else
                                <span class="text-sm text-slate-400">—</span>
                            @endif
                        </td>
                        <td class="hidden px-4 py-3 lg:table-cell">
                            <form method="POST" action="{{ route('admin.tasks.toggle', $task) }}" data-no-spinner>
                                @csrf
                                @method('PATCH')
                                <button type="submit" class="no-spinner relative inline-flex h-5 w-9 items-center rounded-full transition-colors {{ $task->is_active ? 'bg-green-500' : 'bg-slate-300' }}">
                                    <span class="inline-block h-3.5 w-3.5 transform rounded-full bg-white transition-transform {{ $task->is_active ? 'translate-x-4.5' : 'translate-x-0.5' }}"></span>
                                </button>
                            </form>
                        </td>
                        <td class="px-4 py-3">
                            <div class="flex items-center justify-end gap-2">
                                <a href="{{ route('admin.tasks.edit', $task) }}" class="rounded-lg p-2 text-slate-500 hover:bg-slate-100 hover:text-navy-700" title="Edit">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-4 w-4">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10" />
                                    </svg>
                                </a>
                                <form method="POST" action="{{ route('admin.tasks.destroy', $task) }}" class="delete-form">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="rounded-lg p-2 text-slate-500 hover:bg-red-50 hover:text-red-600" title="Delete">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-4 w-4">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0" />
                                        </svg>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <x-admin.empty-state resource="tasks" :colspan="6" message="No tasks found." create-label="Add your first task" :create-route="route('admin.tasks.create')" />
                @endforelse
            </tbody>
        </table>
    </div>
    @if ($tasks->hasPages())
        <div class="border-t border-slate-200 px-4 py-3">
            {{ $tasks->links() }}
        </div>
    @endif
</div>
