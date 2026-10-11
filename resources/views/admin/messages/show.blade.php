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

            @if ($message->replies->isNotEmpty())
                <div class="space-y-3">
                    <p class="text-xs font-medium uppercase tracking-wider text-slate-400">Replies Sent ({{ $message->replies->count() }})</p>
                    @foreach ($message->replies as $reply)
                        <div class="rounded-lg border-l-4 border-violet-500 bg-slate-50 px-4 py-3">
                            <p class="whitespace-pre-wrap text-sm leading-relaxed text-slate-700">{{ $reply->body }}</p>
                            <p class="mt-2 text-xs text-slate-400">Sent {{ $reply->created_at->format('M d, Y \a\t h:i A') }}</p>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>

        <div class="border-t border-slate-200 px-6 py-6">
            <form method="POST" action="{{ route('admin.messages.reply', $message) }}" class="space-y-3">
                @csrf
                <label for="body" class="block text-sm font-semibold text-navy-950">Reply to {{ $message->name }}</label>
                <textarea name="body" id="body" rows="4" required placeholder="Type your reply — it will be emailed to {{ $message->email }}..."
                    class="block w-full rounded-lg border border-slate-300 px-3.5 py-2.5 text-sm text-slate-700 shadow-sm placeholder:text-slate-400 focus:border-navy-500 focus:ring-navy-500/30 {{ $errors->has('body') ? 'border-red-400' : '' }}">{{ old('body') }}</textarea>
                @error('body')<p class="text-xs text-red-600">{{ $message }}</p>@enderror
                <button type="submit" class="rounded-lg bg-navy-900 px-5 py-2.5 text-sm font-semibold text-white shadow-sm hover:bg-navy-800">Send Reply</button>
            </form>
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