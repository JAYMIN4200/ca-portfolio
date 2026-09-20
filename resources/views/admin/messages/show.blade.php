<x-admin.layouts.app :title="'Message'">
    <div class="w-full rounded-xl bg-white shadow-sm ring-1 ring-slate-200">
        <div class="border-b border-slate-200 px-6 py-4">
            <div class="flex items-start justify-between gap-4">
                <div>
                    <h2 class="text-lg font-semibold text-navy-950">{{ $message->subject ?? 'No Subject' }}</h2>
                    <p class="mt-1 text-sm text-slate-500">{{ $message->created_at->format('M d, Y \a\t h:i A') }}</p>
                </div>
                <form method="POST" action="{{ route('admin.messages.toggle-read', $message) }}">
                    @csrf
                    @method('PATCH')
                    <button type="submit" class="rounded-lg border border-slate-200 px-3 py-1.5 text-xs font-medium text-slate-600 hover:bg-slate-50">
                        Mark as {{ $message->is_read ? 'Unread' : 'Read' }}
                    </button>
                </form>
            </div>
        </div>
        <div class="space-y-6 px-6 py-6">
            <div class="grid grid-cols-1 gap-3 rounded-lg bg-slate-50 p-4 text-sm sm:grid-cols-2">
                <div>
                    <p class="text-xs font-medium uppercase tracking-wider text-slate-400">Name</p>
                    <p class="mt-0.5 font-medium text-slate-800">{{ $message->name }}</p>
                </div>
                <div>
                    <p class="text-xs font-medium uppercase tracking-wider text-slate-400">Email</p>
                    <p class="mt-0.5 font-medium text-slate-800">{{ $message->email }}</p>
                </div>
                @if ($message->phone)
                    <div>
                        <p class="text-xs font-medium uppercase tracking-wider text-slate-400">Phone</p>
                        <p class="mt-0.5 font-medium text-slate-800">{{ $message->phone }}</p>
                    </div>
                @endif
            </div>
            <div>
                <p class="mb-2 text-xs font-medium uppercase tracking-wider text-slate-400">Message</p>
                <p class="whitespace-pre-wrap text-sm leading-relaxed text-slate-700">{{ $message->message }}</p>
            </div>
        </div>
        <div class="flex items-center gap-3 border-t border-slate-200 px-6 py-4">
            <a href="mailto:{{ $message->email }}" class="rounded-lg bg-navy-900 px-4 py-2 text-sm font-semibold text-white shadow-sm hover:bg-navy-800">Reply by Email</a>
            <a href="{{ route('admin.messages.index') }}" class="btn-ghost rounded-lg px-4 py-2 text-sm">← Back to Messages</a>
            <form method="POST" action="{{ route('admin.messages.destroy', $message) }}" class="ml-auto delete-form">
                @csrf
                @method('DELETE')
                <button type="submit" class="rounded-lg border border-red-200 px-4 py-2 text-sm font-medium text-red-600 hover:bg-red-50">Delete</button>
            </form>
        </div>
    </div>
</x-admin.layouts.app>