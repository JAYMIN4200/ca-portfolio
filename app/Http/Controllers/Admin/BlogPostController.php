<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BlogPost;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class BlogPostController extends Controller
{
    public function index(Request $request)
    {
        $query = BlogPost::query()->ordered();

        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                    ->orWhere('excerpt', 'like', "%{$search}%")
                    ->orWhere('category', 'like', "%{$search}%");
            });
        }

        if ($request->filled('status')) {
            $query->where('status', $request->input('status'));
        }

        $posts = $query->paginate(10)->withQueryString();

        if ($request->ajax()) {
            return response()->json([
                'html' => view('admin.blog-posts._table', ['posts' => $posts])->render(),
            ]);
        }

        return view('admin.blog-posts.index', [
            'title' => 'Blog',
            'posts' => $posts,
        ]);
    }

    public function create()
    {
        return view('admin.blog-posts.create', [
            'title' => 'Add Blog Post',
        ]);
    }

    public function store(Request $request)
    {
        $validated = $this->validatePost($request);

        $validated['user_id'] = auth()->id();
        $validated['slug'] = $this->uniqueSlug($validated['slug'] ?? $validated['title']);
        $validated['tags'] = $this->parseTags($request->input('tags'));
        $validated['is_featured'] = $request->boolean('is_featured');
        $validated['published_at'] = $this->resolvePublishedAt($validated);

        if ($request->hasFile('cover')) {
            $validated['cover_image'] = $request->file('cover')->store('blog', 'public');
        }

        BlogPost::create($validated);

        return redirect()
            ->route('admin.blog-posts.index')
            ->with('status', 'Blog post created successfully.');
    }

    public function edit(BlogPost $blogPost)
    {
        return view('admin.blog-posts.edit', [
            'title' => 'Edit Blog Post',
            'post' => $blogPost,
        ]);
    }

    public function update(Request $request, BlogPost $blogPost)
    {
        $validated = $this->validatePost($request);

        $validated['slug'] = $this->uniqueSlug($validated['slug'] ?? $validated['title'], $blogPost);
        $validated['tags'] = $this->parseTags($request->input('tags'));
        $validated['is_featured'] = $request->boolean('is_featured');
        $validated['published_at'] = $this->resolvePublishedAt($validated, $blogPost);

        if ($request->hasFile('cover')) {
            if ($blogPost->cover_image) {
                Storage::disk('public')->delete($blogPost->cover_image);
            }
            $validated['cover_image'] = $request->file('cover')->store('blog', 'public');
        }

        if ($request->boolean('remove_cover') && ! $request->hasFile('cover')) {
            if ($blogPost->cover_image) {
                Storage::disk('public')->delete($blogPost->cover_image);
            }
            $validated['cover_image'] = null;
        }

        $blogPost->update($validated);

        return redirect()
            ->route('admin.blog-posts.index')
            ->with('status', 'Blog post updated successfully.');
    }

    public function destroy(BlogPost $blogPost)
    {
        if ($blogPost->cover_image) {
            Storage::disk('public')->delete($blogPost->cover_image);
        }

        $blogPost->delete();

        return back()->with('status', 'Blog post deleted successfully.');
    }

    /**
     * @return array<string, mixed>
     */
    private function validatePost(Request $request): array
    {
        return $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'slug' => ['nullable', 'string', 'max:255'],
            'excerpt' => ['nullable', 'string', 'max:1000'],
            'content' => ['nullable', 'string'],
            'cover' => ['nullable', 'image', 'mimes:jpeg,png,jpg,webp', 'max:3072'],
            'remove_cover' => ['nullable', 'boolean'],
            'category' => ['nullable', 'string', 'max:100'],
            'tags' => ['nullable', 'string', 'max:500'],
            'status' => ['required', Rule::in([BlogPost::STATUS_DRAFT, BlogPost::STATUS_PUBLISHED])],
            'is_featured' => ['nullable', 'boolean'],
            'published_at' => ['nullable', 'date'],
        ]);
    }

    /**
     * @param  array<string, mixed>  $validated
     */
    private function resolvePublishedAt(array $validated, ?BlogPost $existing = null): mixed
    {
        if (! empty($validated['published_at'])) {
            return $validated['published_at'];
        }

        if (($validated['status'] ?? null) === BlogPost::STATUS_PUBLISHED) {
            return $existing?->published_at ?? now();
        }

        return null;
    }

    /**
     * @return array<int, string>
     */
    private function parseTags(?string $tags): array
    {
        if (! $tags) {
            return [];
        }

        return collect(explode(',', $tags))
            ->map(fn ($tag) => trim($tag))
            ->filter()
            ->unique()
            ->values()
            ->all();
    }

    private function uniqueSlug(string $source, ?BlogPost $ignore = null): string
    {
        $base = Str::slug($source) ?: 'blog-post';
        $slug = $base;
        $suffix = 2;

        while (BlogPost::where('slug', $slug)
            ->when($ignore, fn ($query) => $query->whereKeyNot($ignore->getKey()))
            ->exists()) {
            $slug = $base.'-'.$suffix++;
        }

        return $slug;
    }
}
