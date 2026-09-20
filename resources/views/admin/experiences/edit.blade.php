<x-admin.layouts.app :title="'Edit'">
    <div class="w-full rounded-xl bg-white p-6 shadow-sm ring-1 ring-slate-200">
        <form method="POST" action="{{ route('admin.experiences.update', $experience) }}">
            @csrf
            @method('PUT')

            <div class="space-y-4">
                <x-admin.form-input name="role" label="Role / Designation" :value="$experience->role" required placeholder="E.g. Article Assistant" />
                <x-admin.form-input name="firm_name" label="Firm Name" :value="$experience->firm_name" placeholder="E.g. ABC & Associates" />
                <x-admin.form-input name="location" label="Location" :value="$experience->location" placeholder="E.g. Indore, MP" />
                <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                    <x-admin.form-input name="start_date" label="Start Date" type="date" :value="$experience->start_date?->format('Y-m-d')" required placeholder="YYYY-MM-DD" />
                    <x-admin.form-input name="end_date" label="End Date" type="date" :value="$experience->end_date?->format('Y-m-d')" placeholder="YYYY-MM-DD" help="Leave blank if currently working" />
                </div>
                <x-admin.form-checkbox name="is_current" label="Currently working here" :checked="$experience->is_current" />
                <x-admin.form-textarea name="description" label="Description" :value="$experience->description" rows="4" placeholder="Describe your role and key achievements..." />

                <div>
                    <label class="mb-1.5 block text-sm font-medium text-slate-700">Responsibilities</label>
                    <div id="responsibilitiesWrapper" class="space-y-2">
                        @forelse (($experience->responsibilities ?? []) ?: [null] as $responsibility)
                        <div class="flex gap-2">
                            <input type="text" name="responsibilities[]" value="{{ $responsibility }}"
                                class="block w-full rounded-lg border border-slate-300 px-3 py-2 text-sm text-slate-800 shadow-sm placeholder:text-slate-400 focus:border-navy-500 focus:ring-navy-500">
                            <button type="button" class="remove-item rounded-lg border border-slate-200 px-3 text-slate-500 hover:bg-slate-50">Ã—</button>
                        </div>
                        @empty
                        <div class="flex gap-2">
                            <input type="text" name="responsibilities[]" placeholder="E.g. Preparation of financial statements"
                                class="block w-full rounded-lg border border-slate-300 px-3 py-2 text-sm text-slate-800 shadow-sm placeholder:text-slate-400 focus:border-navy-500 focus:ring-navy-500">
                            <button type="button" class="remove-item rounded-lg border border-slate-200 px-3 text-slate-500 hover:bg-slate-50">Ã—</button>
                        </div>
                        @endforelse
                    </div>
                    <button type="button" data-target="responsibilitiesWrapper" class="add-list-item mt-2 text-sm font-medium text-navy-700 hover:underline">+ Add responsibility</button>
                </div>

                <div>
                    <label class="mb-1.5 block text-sm font-medium text-slate-700">Skills Used</label>
                    <div id="skillsUsedWrapper" class="space-y-2">
                        @forelse (($experience->skills_used ?? []) ?: [null] as $skill)
                        <div class="flex gap-2">
                            <input type="text" name="skills_used[]" value="{{ $skill }}"
                                class="block w-full rounded-lg border border-slate-300 px-3 py-2 text-sm text-slate-800 shadow-sm placeholder:text-slate-400 focus:border-navy-500 focus:ring-navy-500">
                            <button type="button" class="remove-item rounded-lg border border-slate-200 px-3 text-slate-500 hover:bg-slate-50">Ã—</button>
                        </div>
                        @empty
                        <div class="flex gap-2">
                            <input type="text" name="skills_used[]" placeholder="E.g. Tally, MS Excel"
                                class="block w-full rounded-lg border border-slate-300 px-3 py-2 text-sm text-slate-800 shadow-sm placeholder:text-slate-400 focus:border-navy-500 focus:ring-navy-500">
                            <button type="button" class="remove-item rounded-lg border border-slate-200 px-3 text-slate-500 hover:bg-slate-50">Ã—</button>
                        </div>
                        @endforelse
                    </div>
                    <button type="button" data-target="skillsUsedWrapper" class="add-list-item mt-2 text-sm font-medium text-navy-700 hover:underline">+ Add skill</button>
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <x-admin.form-input name="display_order" label="Display Order" type="number" :value="$experience->display_order" placeholder="0" />
                    <div class="pt-6">
                        <x-admin.form-checkbox name="is_active" label="Active" :checked="$experience->is_active" />
                    </div>
                </div>
            </div>

            <div class="mt-6 flex items-center gap-3 border-t border-slate-100 pt-5">
                <button type="submit" class="rounded-lg bg-navy-900 px-5 py-2.5 text-sm font-semibold text-white shadow-sm hover:bg-navy-800">Update Experience</button>
                <a href="{{ route('admin.experiences.index') }}" class="btn-ghost rounded-lg px-4 py-2.5">Cancel</a>
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
                row.innerHTML = `<input type="text" name="` + (wrapper.id === 'responsibilitiesWrapper' ? 'responsibilities[]' : 'skills_used[]') + `" placeholder=""
                    class="block w-full rounded-lg border border-slate-300 px-3 py-2 text-sm text-slate-800 shadow-sm placeholder:text-slate-400 focus:border-navy-500 focus:ring-navy-500">
                    <button type="button" class="remove-item rounded-lg border border-slate-200 px-3 text-slate-500 hover:bg-slate-50">Ã—</button>`;
                wrapper.appendChild(row);
            });
        });
        document.querySelectorAll('#responsibilitiesWrapper, #skillsUsedWrapper').forEach(wrapper => {
            wrapper.addEventListener('click', e => {
                if (e.target.classList.contains('remove-item')) e.target.closest('.flex').remove();
            });
        });
    </script>
    @endpush
</x-admin.layouts.app>