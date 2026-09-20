<x-admin.layouts.app :title="'Create'">
    <div class="w-full rounded-xl bg-white p-6 shadow-sm ring-1 ring-slate-200">
        <form method="POST" action="{{ route('admin.skills.store') }}">
            @csrf

            <div class="space-y-4">
                <x-admin.form-select name="skill_category_id" label="Category" :options="$categories->pluck('name', 'id')->toArray()" placeholder="Select category" required />
                <x-admin.form-input name="name" label="Skill Name" required placeholder="E.g. Bank Reconciliation" />
                <x-admin.form-textarea name="description" label="Description" rows="3" placeholder="Describe this skill briefly..." />
                <div class="grid grid-cols-2 gap-4">
                    <x-admin.form-input name="proficiency" label="Proficiency (%)" type="number" min="0" max="100" placeholder="0-100" />
                    <x-admin.form-input name="icon" label="Icon Name" placeholder="E.g. calculator" help="Icon identifier from Heroicons set" />
                </div>
                <div class="grid grid-cols-2 gap-4">
                    <x-admin.form-input name="display_order" label="Display Order" type="number" value="0" placeholder="0" />
                    <div class="pt-6">
                        <x-admin.form-checkbox name="is_active" label="Active" :checked="true" />
                    </div>
                </div>
            </div>

            <div class="mt-6 flex items-center gap-3 border-t border-slate-100 pt-5">
                <button type="submit" class="rounded-lg bg-navy-900 px-5 py-2.5 text-sm font-semibold text-white shadow-sm hover:bg-navy-800">Create Skill</button>
                <a href="{{ route('admin.skills.index') }}" class="btn-ghost rounded-lg px-4 py-2.5">Cancel</a>
            </div>
        </form>
    </div>
</x-admin.layouts.app>