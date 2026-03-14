<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\BlogPost;

class BlogController extends Controller
{
    public function index()
    {
        $posts = BlogPost::published()
            ->latest('published_at')
            ->latest('created_at')
            ->paginate(6);

        $recentPosts = BlogPost::published()
            ->latest('published_at')
            ->latest('created_at')
            ->limit(5)
            ->get();

        return view('frontend.blog.index', compact('posts', 'recentPosts'));
    }

    public function show(string $slug)
    {
        $post = BlogPost::published()
            ->where('slug', $slug)
            ->firstOrFail();

        $recentPosts = BlogPost::published()
            ->where('id', '!=', $post->id)
            ->latest('published_at')
            ->latest('created_at')
            ->limit(5)
            ->get();

        return view('frontend.blog.show', compact('post', 'recentPosts'));
    }
}
