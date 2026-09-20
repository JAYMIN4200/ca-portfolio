<x-admin.layouts.app :title="'Edit Meeting'">
    <div class="w-full rounded-xl bg-white p-6 shadow-sm ring-1 ring-slate-200">
        <form method="POST" action="{{ route('admin.meetings.update', $meeting) }}">
            @csrf
            @method('PUT')
            @include('admin.meetings._form', ['meeting' => $meeting])
            <div class="mt-6 flex items-center gap-3 border-t border-slate-100 pt-5">
                <button type="submit" class="rounded-lg bg-navy-900 px-5 py-2.5 text-sm font-semibold text-white shadow-sm hover:bg-navy-800">Update Meeting</button>
                <a href="{{ route('admin.meetings.index') }}" class="btn-ghost rounded-lg px-4 py-2.5">Cancel</a>
            </div>
        </form>
    </div>
</x-admin.layouts.app>
