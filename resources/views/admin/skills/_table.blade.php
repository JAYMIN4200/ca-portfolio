<div class="overflow-hidden rounded-xl bg-white shadow-sm ring-1 ring-slate-200">
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-slate-200">
            <thead class="bg-slate-50">
                <tr>
                    <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider text-slate-500">Skill</th>
                    <th class="hidden px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider text-slate-500 sm:table-cell">Category</th>
                    <th class="hidden px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider text-slate-500 md:table-cell">Proficiency</th>
                    <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider text-slate-500">Order</th>
                    <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider text-slate-500">Active</th>
                    <th class="px-4 py-3 text-right text-xs font-semibold uppercase tracking-wider text-slate-500">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                @forelse ($skills as $skill)
                    <tr>
                        <td class="px-4 py-3">
                            <p class="text-sm font-medium text-slate-800">{{ $skill->name }}</p>
                            @if ($skill->description)
                                <p class="mt-0.5 line-clamp-1 max-w-xs text-xs text-slate-500">{{ $skill->description }}</p>
                            @endif
                        </td>
                        <td class="hidden px-4 py-3 text-sm text-slate-600 sm:table-cell">
                            <span class="rounded-full bg-navy-50 px-2 py-0.5 text-xs font-medium text-navy-700">{{ $skill->category?->name }}</span>
                        </td>
                        <td class="hidden px-4 py-3 md:table-cell">
                            @if ($skill->proficiency !== null)
                                <div class="flex items-center gap-2">
                                    <div class="h-1.5 w-24 overflow-hidden rounded-full bg-slate-100">
                                        <div class="h-full rounded-full bg-navy-700" style="width: {{ $skill->proficiency }}%"></div>
                                    </div>
                                    <span class="text-xs text-slate-500">{{ $skill->proficiency }}%</span>
                                </div>
                            @else
                                <span class="text-xs text-slate-400">—</span>
                            @endif
                        </td>
                        <td class="px-4 py-3 text-sm text-slate-600">{{ $skill->display_order }}</td>
                        <td class="px-4 py-3">
                            <form method="POST" action="{{ route('admin.skills.toggle', $skill) }}" data-no-spinner>
                                @csrf
                                @method('PATCH')
                                <button type="submit" class="no-spinner relative inline-flex h-5 w-9 items-center rounded-full transition-colors {{ $skill->is_active ? 'bg-green-500' : 'bg-slate-300' }}">
                                    <span class="inline-block h-3.5 w-3.5 transform rounded-full bg-white transition-transform {{ $skill->is_active ? 'translate-x-4.5' : 'translate-x-0.5' }}"></span>
                                </button>
                            </form>
                        </td>
                        <td class="px-4 py-3">
                            <div class="flex items-center justify-end gap-2">
                                <a href="{{ route('admin.skills.edit', $skill) }}" class="rounded-lg p-2 text-slate-500 hover:bg-slate-100 hover:text-navy-700" title="Edit">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-4 w-4">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10" />
                                    </svg>
                                </a>
                                <form method="POST" action="{{ route('admin.skills.destroy', $skill) }}" class="delete-form">
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
                    <x-admin.empty-state resource="skills" :colspan="6" message="No skills found." create-label="Add your first skill" :create-route="route('admin.skills.create')" />
                @endforelse
            </tbody>
        </table>
    </div>
    @if ($skills->hasPages())
        <div class="border-t border-slate-200 px-4 py-3">
            {{ $skills->links() }}
        </div>
    @endif
</div>