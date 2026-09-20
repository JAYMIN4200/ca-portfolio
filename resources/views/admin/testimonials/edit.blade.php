<x-admin.layouts.app :title="'Edit Testimonial'">
    <div class="w-full rounded-xl bg-white p-6 shadow-sm ring-1 ring-slate-200">
        <form method="POST" action="{{ route('admin.testimonials.update', $testimonial) }}" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="space-y-4">
                @if ($testimonial->photo)
                    <div class="flex items-center gap-4 rounded-lg bg-slate-50 p-4">
                        <img src="{{ $testimonial->photo_url }}" alt="{{ $testimonial->name }}" class="h-14 w-14 rounded-full object-cover">
                        <div>
                            <p class="text-sm font-medium text-slate-700">Current photo</p>
                            <label class="mt-1 flex items-center gap-2 text-xs text-red-600">
                                <input type="checkbox" name="remove_photo" value="1" class="rounded border-slate-300 text-red-600 focus:ring-red-500">
                                Remove this photo
                            </label>
                        </div>
                    </div>
                @endif
                <div class="grid grid-cols-1 gap-4 sm:grid-cols-3">
                    <x-admin.form-input name="name" label="Client Name" :value="$testimonial->name" required placeholder="E.g. Ramesh Patel" />
                    <x-admin.form-input name="designation" label="Designation" :value="$testimonial->designation" placeholder="E.g. Proprietor" />
                    <x-admin.form-input name="company" label="Company" :value="$testimonial->company" placeholder="E.g. Shree Balaji Traders" />
                </div>
                <x-admin.form-textarea name="message" label="Testimonial" :value="$testimonial->message" rows="5" required placeholder="What did the client say about your work?" />
                <div class="grid grid-cols-2 gap-4">
                    <x-admin.form-input name="rating" label="Rating" type="number" min="1" max="5" :value="$testimonial->rating" placeholder="1-5" />
                    <x-admin.form-input name="display_order" label="Display Order" type="number" :value="$testimonial->display_order" placeholder="0" />
                </div>
                <x-admin.form-file name="photo" label="Replace Photo" accept="image/*" />
                <x-admin.form-checkbox name="is_active" label="Active" :checked="$testimonial->is_active" />
            </div>

            <div class="mt-6 flex items-center gap-3 border-t border-slate-100 pt-5">
                <button type="submit" class="rounded-lg bg-navy-900 px-5 py-2.5 text-sm font-semibold text-white shadow-sm hover:bg-navy-800">Update Testimonial</button>
                <a href="{{ route('admin.testimonials.index') }}" class="btn-ghost rounded-lg px-4 py-2.5">Cancel</a>
            </div>
        </form>
    </div>
</x-admin.layouts.app>