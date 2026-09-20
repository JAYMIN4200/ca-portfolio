<div class="overflow-hidden rounded-xl bg-white shadow-sm ring-1 ring-slate-200">
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-slate-200">
            <thead class="bg-slate-50">
                <tr>
                    <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider text-slate-500">From</th>
                    <th class="hidden px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider text-slate-500 md:table-cell">Subject</th>
                    <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider text-slate-500">Received</th>
                    <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider text-slate-500">Status</th>
                    <th class="px-4 py-3 text-right text-xs font-semibold uppercase tracking-wider text-slate-500">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                @forelse ($messages as $message)
                    <tr class="{{ $message->is_read ? '' : 'bg-gold-50/30' }}">
                        <td class="px-4 py-3">
                            <p class="text-sm font-medium text-slate-800">
                                @if (!$message->is_read)
                                    <span class="mr-1.5 inline-block h-2 w-2 rounded-full bg-red-500"></span>
                                @endif
                                {{ $message->name }}
                            </p>
                            <p class="text-xs text-slate-500">{{ $message->email }}</p>
                        </td>
                        <td class="hidden max-w-xs px-4 py-3 text-sm text-slate-600 md:table-cell">
                            <p class="truncate">{{ $message->subject ?? 'No subject' }}</p>
                        </td>
                        <td class="px-4 py-3 text-sm text-slate-500">{{ $message->created_at->format('M d, Y') }}<span class="hidden lg:inline"> · {{ $message->created_at->format('h:i A') }}</span></td>
                        <td class="px-4 py-3">
                            <span class="inline-flex rounded-full px-2 py-0.5 text-xs font-medium {{ $message->is_read ? 'bg-slate-100 text-slate-600' : 'bg-red-50 text-red-700' }}">
                                {{ $message->is_read ? 'Read' : 'Unread' }}
                            </span>
                        </td>
                        <td class="px-4 py-3">
                            <div class="flex items-center justify-end gap-2">
                                <a href="{{ route('admin.messages.show', $message) }}" class="rounded-lg px-3 py-1.5 text-xs font-medium text-navy-700 hover:bg-slate-100">View</a>
                                <form method="POST" action="{{ route('admin.messages.destroy', $message) }}" class="delete-form">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="rounded-lg p-1.5 text-slate-500 hover:bg-red-50 hover:text-red-600" title="Delete">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-4 w-4">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0" />
                                        </svg>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <x-admin.empty-state resource="messages" :colspan="5" message="No messages found." />
                @endforelse
            </tbody>
        </table>
    </div>
    @if ($messages->hasPages())
        <div class="border-t border-slate-200 px-4 py-3">
            {{ $messages->links() }}
        </div>
    @endif
</div>