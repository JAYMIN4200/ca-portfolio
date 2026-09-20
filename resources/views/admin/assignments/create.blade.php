<x-admin.layouts.app :title="'Create'">
    <div class="w-full rounded-xl bg-white p-6 shadow-sm ring-1 ring-slate-200">
        <form method="POST" action="{{ route('admin.assignments.store') }}" enctype="multipart/form-data">
            @csrf

            <div class="space-y-4">
                <x-admin.form-input name="title" label="Assignment Title" required placeholder="E.g. Statutory Audit of a Manufacturing Company" />
                <x-admin.form-input name="category" label="Category" placeholder="E.g. Audit, GST, Income Tax, Accounting" />
                <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                    <x-admin.form-file name="image" label="Cover Image" accept="image/png,image/jpeg,image/webp" />
                    <x-admin.form-input name="external_url" label="External URL" placeholder="https://..." help="Optional public link" />
                </div>
                <x-admin.form-textarea name="short_description" label="Short Description" rows="3" placeholder="Brief summary shown on assignment cards" />
                <x-admin.form-textarea name="description" label="Detailed Description" rows="6" placeholder="Detailed overview of the assignment..." />

                <div>
                    <label class="mb-1.5 block text-sm font-medium text-slate-700">Responsibilities</label>
                    <div id="responsibilitiesWrapper" class="space-y-2">
                        <div class="flex gap-2">
                            <input type="text" name="responsibilities[]" placeholder="E.g. Preparation of audit documentation"
                                class="block w-full rounded-lg border border-slate-300 px-3 py-2 text-sm text-slate-800 shadow-sm placeholder:text-slate-400 focus:border-navy-500 focus:ring-navy-500">
                            <button type="button" class="remove-item rounded-lg border border-slate-200 px-3 text-slate-500 hover:bg-slate-50">Ã—</button>
                        </div>
                    </div>
                    <button type="button" data-target="responsibilitiesWrapper" class="add-list-item mt-2 text-sm font-medium text-navy-700 hover:underline">+ Add responsibility</button>
                </div>

                <div>
                    <label class="mb-1.5 block text-sm font-medium text-slate-700">Tools Used</label>
                    <div id="toolsWrapper" class="space-y-2">
                        <div class="flex gap-2">
                            <input type="text" name="tools_used[]" placeholder="E.g. Tally, MS Excel"
                                class="block w-full rounded-lg border border-slate-300 px-3 py-2 text-sm text-slate-800 shadow-sm placeholder:text-slate-400 focus:border-navy-500 focus:ring-navy-500">
                            <button type="button" class="remove-item rounded-lg border border-slate-200 px-3 text-slate-500 hover:bg-slate-50">Ã—</button>
                        </div>
                    </div>
                    <button type="button" data-target="toolsWrapper" class="add-list-item mt-2 text-sm font-medium text-navy-700 hover:underline">+ Add tool</button>
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <x-admin.form-input name="display_order" label="Display Order" type="number" value="0" placeholder="0" />
                    <div class="pt-6">
                        <x-admin.form-checkbox name="is_active" label="Active" :checked="true" />
                    </div>
                </div>
            </div>

            <div class="mt-6 flex items-center gap-3 border-t border-slate-100 pt-5">
                <button type="submit" class="rounded-lg bg-navy-900 px-5 py-2.5 text-sm font-semibold text-white shadow-sm hover:bg-navy-800">Create Assignment</button>
                <a href="{{ route('admin.assignments.index') }}" class="btn-ghost rounded-lg px-4 py-2.5">Cancel</a>
            </div>
        </form>
    </div>

    @push('scripts')
    <script>
        document.querySelectorAll('.add-list-item').forEach(button => {
            button.addEventListener('click', () => {
                const wrapper = document.getElementById(button.dataset.target);
                const row = document.createElement('div');
                row.className = 'flex gap-2';
                row.innerHTML = `<input type="text" name="` + (wrapper.id === 'responsibilitiesWrapper' ? 'responsibilities[]' : 'tools_used[]') + `" placeholder=""
                    class="block w-full rounded-lg border border-slate-300 px-3 py-2 text-sm text-slate-800 shadow-sm placeholder:text-slate-400 focus:border-navy-500 focus:ring-navy-500">
                    <button type="button" class="remove-item rounded-lg border border-slate-200 px-3 text-slate-500 hover:bg-slate-50">Ã—</button>`;
                wrapper.appendChild(row);
            });
        });
        document.querySelectorAll('#responsibilitiesWrapper, #toolsWrapper').forEach(wrapper => {
            wrapper.addEventListener('click', e => {
                if (e.target.classList.contains('remove-item')) e.target.closest('.flex').remove();
            });
        });
    </script>
    @endpush
</x-admin.layouts.app>