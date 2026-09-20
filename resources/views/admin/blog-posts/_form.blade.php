@php
    $post = $post ?? null;
@endphp

<div class="space-y-4">
    <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
        <x-admin.form-input name="title" label="Title" :value="$post?->title" required placeholder="E.g. 5 tax tips for small businesses" />
        <x-admin.form-input name="slug" label="Slug" :value="$post?->slug" help="Leave blank to auto-generate from the title." placeholder="5-tax-tips-for-small-businesses" />
    </div>
    <x-admin.form-textarea name="excerpt" label="Excerpt" rows="2" :value="$post?->excerpt" placeholder="A short summary shown on the blog listing." />
    <x-admin.form-textarea name="content" label="Content" rows="12" :value="$post?->content" placeholder="Write the full post content here..." />
</div>

<div class="mt-6 grid grid-cols-1 gap-6 lg:grid-cols-2">
    <div>
        <x-admin.form-file name="cover" label="Cover Image" accept="image/*" />
        @if ($post?->cover_image)
            <div class="mt-3 flex items-center gap-3 rounded-lg border border-slate-200 bg-slate-50 p-2">
                <img src="{{ \Illuminate\Support\Facades\Storage::disk('public')->url($post->cover_image) }}" alt="" class="h-16 w-16 rounded-lg object-cover">
                <x-admin.form-checkbox name="remove_cover" label="Remove this image" />
            </div>
        @endif
    </div>
    <div class="space-y-4">
        <div class="grid grid-cols-2 gap-4">
            <x-admin.form-input name="category" label="Category" :value="$post?->category" placeholder="E.g. Taxation" />
            <x-admin.form-select name="status" label="Status" :options="['draft' => 'Draft', 'published' => 'Published']" :value="$post?->status ?? 'draft'" required />
        </div>
        <x-admin.form-input name="tags" label="Tags" :value="$post?->tags ? implode(', ', $post->tags) : null" help="Comma separated, e.g. gst, compliance, sme" placeholder="gst, compliance, sme" />
        <x-admin.form-input name="published_at" label="Published Date" type="date" :value="$post?->published_at?->format('Y-m-d')" />
        <x-admin.form-checkbox name="is_featured" label="Feature this post" :checked="$post?->is_featured ?? false" />
    </div>
</div>
