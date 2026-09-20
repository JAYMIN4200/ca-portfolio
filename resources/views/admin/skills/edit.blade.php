<x-admin.layouts.app :title="'Edit'">
    <div class="w-full rounded-xl bg-white p-6 shadow-sm ring-1 ring-slate-200">
        <form method="POST" action="{{ route('admin.skills.update', $skill) }}">
            @csrf
            @method('PUT')

            <div class="space-y-4">
                <x-admin.form-select name="skill_category_id" label="Category" :options="$categories->pluck('name', 'id')->toArray()" :value="$skill->skill_category_id" placeholder="Select category" required />
                <x-admin.form-input name="name" label="Skill Name" :value="$skill->name" required placeholder="E.g. Tally, GST expertise" />
                <x-admin.form-textarea name="description" label="Description" :value="$skill->description" rows="3" placeholder="Describe this skill briefly..." />
                <div class="grid grid-cols-2 gap-4">
                    <x-admin.form-input name="proficiency" label="Proficiency (%)" type="number" min="0" max="100" :value="$skill->proficiency" placeholder="0-100" />
                    <x-admin.form-input name="icon" label="Icon Name" :value="$skill->icon" placeholder="E.g. calculator" help="Icon identifier from Heroicons set" />
                </div>
                <div class="grid grid-cols-2 gap-4">
                    <x-admin.form-input name="display_order" label="Display Order" type="number" :value="$skill->display_order" placeholder="0" />
                    <div class="pt-6">
                        <x-admin.form-checkbox name="is_active" label="Active" :checked="$skill->is_active" />
                    </div>
                </div>
            </div>

            <div class="mt-6 flex items-center gap-3 border-t border-slate-100 pt-5">
                <button type="submit" class="rounded-lg bg-navy-900 px-5 py-2.5 text-sm font-semibold text-white shadow-sm hover:bg-navy-800">Update Skill</button>
                <a href="{{ route('admin.skills.index') }}" class="btn-ghost rounded-lg px-4 py-2.5">Cancel</a>
            </div>
        </form>
    </div>
</x-admin.layouts.app>