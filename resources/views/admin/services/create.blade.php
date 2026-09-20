<x-admin.layouts.app :title="'Create'">
    <div class="w-full rounded-xl bg-white p-6 shadow-sm ring-1 ring-slate-200">
        <form method="POST" action="{{ route('admin.services.store') }}">
            @csrf

            <div class="space-y-4">
                <x-admin.form-input name="title" label="Service Title" required placeholder="E.g. Accounting & Bookkeeping" />
                <x-admin.form-input name="icon" label="Icon Name" placeholder="E.g. calculator" help="Icon identifier from Heroicons set" />
                <x-admin.form-textarea name="short_description" label="Short Description" rows="3" placeholder="Brief summary shown on service cards" help="Shown on cards and listing pages" />
                <x-admin.form-textarea name="description" label="Detailed Description" rows="6" placeholder="Full details of the service you offer..." help="Full description shown on the services page" />
                <div class="grid grid-cols-2 gap-4">
                    <x-admin.form-input name="display_order" label="Display Order" type="number" value="0" placeholder="0" />
                    <div class="pt-6">
                        <x-admin.form-checkbox name="is_active" label="Active" :checked="true" />
                    </div>
                </div>
            </div>

            <div class="mt-6 flex items-center gap-3 border-t border-slate-100 pt-5">
                <button type="submit" class="rounded-lg bg-navy-900 px-5 py-2.5 text-sm font-semibold text-white shadow-sm hover:bg-navy-800">Create Service</button>
                <a href="{{ route('admin.services.index') }}" class="btn-ghost rounded-lg px-4 py-2.5">Cancel</a>
            </div>
        </form>
    </div>
</x-admin.layouts.app>