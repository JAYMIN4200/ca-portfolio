<x-admin.layouts.app :title="'Add FAQ'">
    <div class="w-full rounded-xl bg-white p-6 shadow-sm ring-1 ring-slate-200">
        <form method="POST" action="{{ route('admin.faqs.store') }}">
            @csrf

            <div class="space-y-4">
                <x-admin.form-input name="question" label="Question" required placeholder="E.g. What services do you offer?" />
                <x-admin.form-textarea name="answer" label="Answer" rows="4" required placeholder="Write the answer here..." />
                <div class="grid grid-cols-2 gap-4">
                    <x-admin.form-input name="category" label="Category" placeholder="E.g. Services, Pricing, Process" help="Optional category used to group FAQs" />
                    <x-admin.form-input name="display_order" label="Display Order" type="number" value="0" placeholder="0" />
                </div>
                <x-admin.form-checkbox name="is_active" label="Active" :checked="true" />
            </div>

            <div class="mt-6 flex items-center gap-3 border-t border-slate-100 pt-5">
                <button type="submit" class="rounded-lg bg-navy-900 px-5 py-2.5 text-sm font-semibold text-white shadow-sm hover:bg-navy-800">Create FAQ</button>
                <a href="{{ route('admin.faqs.index') }}" class="btn-ghost rounded-lg px-4 py-2.5">Cancel</a>
            </div>
        </form>
    </div>
</x-admin.layouts.app>