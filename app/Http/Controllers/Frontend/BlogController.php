<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\BlogPost;
use Illuminate\Http\Request;

class BlogController extends Controller
{
    public function index(Request $request)
    {
        $categories = BlogPost::published()->distinct()->pluck('category')->filter()->values();
        $activeCategory = $request->query('category');

        $query = BlogPost::published()->ordered();

        if ($activeCategory) {
            $query->where('category', $activeCategory);
        }

        $posts = $query->paginate(10)->withQueryString();

        if ($request->ajax()) {
            return response()->json([
                'html' => view('frontend.blog._list', compact('posts', 'categories', 'activeCategory'))->render(),
            ]);
        }

        return view('frontend.blog.index', compact('posts', 'categories', 'activeCategory'));
    }

    public function show(BlogPost $blogPost)
    {
        abort_unless($blogPost->status === BlogPost::STATUS_PUBLISHED, 404);

        $blogPost->increment('views');

        $related = BlogPost::published()
            ->whereKeyNot($blogPost->getKey())
            ->ordered()
            ->limit(3)
            ->get();

        return view('frontend.blog.show', compact('blogPost', 'related'));
    }
}
