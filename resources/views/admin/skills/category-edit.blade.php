<x-admin.layouts.app :title="'Edit'">
    <div class="w-full rounded-xl bg-white p-6 shadow-sm ring-1 ring-slate-200">
        <form method="POST" action="{{ route('admin.skill-categories.update', $category) }}">
            @csrf
            @method('PUT')

            <div class="space-y-4">
                <x-admin.form-input name="name" label="Category Name" :value="$category->name" required placeholder="E.g. Accounting & Taxation" />
                <x-admin.form-input name="icon" label="Icon Name" :value="$category->icon" />
                <div class="grid grid-cols-2 gap-4">
                    <x-admin.form-input name="display_order" label="Display Order" type="number" :value="$category->display_order" />
                    <div class="pt-6">
                        <x-admin.form-checkbox name="is_active" label="Active" :checked="$category->is_active" />
                    </div>
                </div>
            </div>

            <div class="mt-6 flex items-center gap-3 border-t border-slate-100 pt-5">
                <button type="submit" class="rounded-lg bg-navy-900 px-5 py-2.5 text-sm font-semibold text-white shadow-sm hover:bg-navy-800">Update Category</button>
                <a href="{{ route('admin.skill-categories.index') }}" class="btn-ghost rounded-lg px-4 py-2.5">Cancel</a>
            </div>
        </form>
    </div>
</x-admin.layouts.app>