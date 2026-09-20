<x-admin.layouts.app :title="'Add Section'">
    <div class="w-full rounded-xl bg-white p-6 shadow-sm ring-1 ring-slate-200">
        <form method="POST" action="{{ route('admin.terms.store') }}">
            @csrf

            <div class="space-y-4">
                <x-admin.form-input name="title" label="Section Title" required placeholder="E.g. Introduction" />
                <x-admin.form-textarea name="content" label="Content" rows="10" required placeholder="Write the terms content here..." help="Plain text or simple HTML is supported" />
                <div class="grid grid-cols-2 gap-4">
                    <x-admin.form-input name="display_order" label="Display Order" type="number" value="0" placeholder="0" />
                    <div class="pt-6">
                        <x-admin.form-checkbox name="is_active" label="Active" :checked="true" />
                    </div>
                </div>
            </div>

            <div class="mt-6 flex items-center gap-3 border-t border-slate-100 pt-5">
                <button type="submit" class="rounded-lg bg-navy-900 px-5 py-2.5 text-sm font-semibold text-white shadow-sm hover:bg-navy-800">Create Section</button>
                <a href="{{ route('admin.terms.index') }}" class="btn-ghost rounded-lg px-4 py-2.5">Cancel</a>
            </div>
        </form>
    </div>
</x-admin.layouts.app>