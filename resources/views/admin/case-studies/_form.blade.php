@php
    $caseStudy = $caseStudy ?? null;
@endphp

<div class="space-y-4">
    <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
        <x-admin.form-input name="title" label="Title" :value="$caseStudy?->title" required placeholder="E.g. Streamlining GST compliance" />
        <x-admin.form-input name="slug" label="Slug" :value="$caseStudy?->slug" help="Leave blank to auto-generate from the title." placeholder="streamlining-gst-compliance" />
    </div>
    <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
        <x-admin.form-input name="client_name" label="Client Name" :value="$caseStudy?->client_name" placeholder="E.g. Sharma Traders" />
        <x-admin.form-input name="category" label="Category" :value="$caseStudy?->category" placeholder="E.g. Taxation, Audit, Advisory" />
    </div>
    <x-admin.form-textarea name="summary" label="Summary" rows="2" :value="$caseStudy?->summary" placeholder="A short one-line summary shown on the listing." />
    <x-admin.form-textarea name="challenge" label="The Challenge" rows="3" :value="$caseStudy?->challenge" placeholder="What problem did the client face?" />
    <x-admin.form-textarea name="solution" label="Our Solution" rows="3" :value="$caseStudy?->solution" placeholder="How did you solve it?" />
    <x-admin.form-textarea name="results" label="The Results" rows="3" :value="$caseStudy?->results" placeholder="Measurable outcomes achieved." />
</div>

<div class="mt-6 grid grid-cols-1 gap-6 lg:grid-cols-2">
    <div>
        <x-admin.form-file name="image" label="Cover Image" accept="image/*" />
        @if ($caseStudy?->image_path)
            <div class="mt-3 flex items-center gap-3 rounded-lg border border-slate-200 bg-slate-50 p-2">
                <img src="{{ \Illuminate\Support\Facades\Storage::disk('public')->url($caseStudy->image_path) }}" alt="" class="h-16 w-16 rounded-lg object-cover">
                <x-admin.form-checkbox name="remove_image" label="Remove this image" />
            </div>
        @endif
    </div>
    <div class="space-y-4">
        <x-admin.form-input name="published_at" label="Published Date" type="date" :value="$caseStudy?->published_at?->format('Y-m-d')" />
        <x-admin.form-input name="display_order" label="Display Order" type="number" min="0" :value="$caseStudy?->display_order ?? 0" />
        <x-admin.form-checkbox name="is_active" label="Show on website" :checked="$caseStudy?->is_active ?? true" />
    </div>
</div>
