<x-admin.layouts.app :title="'Edit Blog Post'">
    <div class="w-full rounded-xl bg-white p-6 shadow-sm ring-1 ring-slate-200">
        <form method="POST" action="{{ route('admin.blog-posts.update', $post) }}" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            @include('admin.blog-posts._form', ['post' => $post])
            <div class="mt-6 flex items-center gap-3 border-t border-slate-100 pt-5">
                <button type="submit" class="rounded-lg bg-navy-900 px-5 py-2.5 text-sm font-semibold text-white shadow-sm hover:bg-navy-800">Update Post</button>
                <a href="{{ route('admin.blog-posts.index') }}" class="btn-ghost rounded-lg px-4 py-2.5">Cancel</a>
            </div>
        </form>
    </div>
</x-admin.layouts.app>
