<x-admin.layouts.app :title="'Create'">
    <div class="w-full rounded-xl bg-white p-6 shadow-sm ring-1 ring-slate-200">
        <form method="POST" action="{{ route('admin.qualifications.store') }}">
            @csrf

            <div class="space-y-4">
                <x-admin.form-input name="name" label="Qualification Name" required placeholder="E.g. CA Intermediate" />
                <x-admin.form-input name="institution" label="Institution" placeholder="E.g. Institute of Chartered Accountants of India" />
                <x-admin.form-select name="status" label="Status" :options="['cleared' => 'Cleared', 'pursuing' => 'Pursuing', 'completed' => 'Completed']" placeholder="Select status" required />
                <div class="grid grid-cols-2 gap-4">
                    <x-admin.form-input name="start_year" label="Start Year" type="number" placeholder="E.g. 2020" />
                    <x-admin.form-input name="end_year" label="Completion Year" type="number" placeholder="E.g. 2023" />
                </div>
                <x-admin.form-textarea name="description" label="Description" rows="4" placeholder="Any additional details about this qualification..." />
                <div class="grid grid-cols-2 gap-4">
                    <x-admin.form-input name="display_order" label="Display Order" type="number" value="0" placeholder="0" />
                    <div class="pt-6">
                        <x-admin.form-checkbox name="is_active" label="Active" :checked="true" />
                    </div>
                </div>
            </div>

            <div class="mt-6 flex items-center gap-3 border-t border-slate-100 pt-5">
                <button type="submit" class="rounded-lg bg-navy-900 px-5 py-2.5 text-sm font-semibold text-white shadow-sm hover:bg-navy-800">Create Qualification</button>
                <a href="{{ route('admin.qualifications.index') }}" class="btn-ghost rounded-lg px-4 py-2.5">Cancel</a>
            </div>
        </form>
    </div>
</x-admin.layouts.app>