<x-admin.layouts.app :title="'Add Testimonial'">
    <div class="w-full rounded-xl bg-white p-6 shadow-sm ring-1 ring-slate-200">
        <form method="POST" action="{{ route('admin.testimonials.store') }}" enctype="multipart/form-data">
            @csrf

            <div class="space-y-4">
                <div class="grid grid-cols-1 gap-4 sm:grid-cols-3">
                    <x-admin.form-input name="name" label="Client Name" required placeholder="E.g. Ramesh Patel" />
                    <x-admin.form-input name="designation" label="Designation" placeholder="E.g. Proprietor" />
                    <x-admin.form-input name="company" label="Company" placeholder="E.g. Shree Balaji Traders" />
                </div>
                <x-admin.form-textarea name="message" label="Testimonial" rows="5" required placeholder="What did the client say about your work?" />
                <div class="grid grid-cols-2 gap-4">
                    <x-admin.form-input name="rating" label="Rating" type="number" min="1" max="5" value="" placeholder="1-5" />
                    <x-admin.form-input name="display_order" label="Display Order" type="number" value="0" placeholder="0" />
                </div>
                <x-admin.form-file name="photo" label="Client Photo" accept="image/*" help="JPEG, PNG or WebP up to 2MB" />
                <x-admin.form-checkbox name="is_active" label="Active" :checked="true" />
            </div>

            <div class="mt-6 flex items-center gap-3 border-t border-slate-100 pt-5">
                <button type="submit" class="rounded-lg bg-navy-900 px-5 py-2.5 text-sm font-semibold text-white shadow-sm hover:bg-navy-800">Create Testimonial</button>
                <a href="{{ route('admin.testimonials.index') }}" class="btn-ghost rounded-lg px-4 py-2.5">Cancel</a>
            </div>
        </form>
    </div>
</x-admin.layouts.app>