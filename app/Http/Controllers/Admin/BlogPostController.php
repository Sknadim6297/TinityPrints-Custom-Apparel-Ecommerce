<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BlogPost;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class BlogPostController extends Controller
{
    public function index(Request $request)
    {
        $query = BlogPost::query()->with('admin');

        if ($request->filled('search')) {
            $search = trim($request->string('search'));
            $query->where(function ($innerQuery) use ($search) {
                $innerQuery->where('title', 'like', "%{$search}%")
                    ->orWhere('excerpt', 'like', "%{$search}%")
                    ->orWhere('content', 'like', "%{$search}%")
                    ->orWhere('author_name', 'like', "%{$search}%");
            });
        }

        if ($request->filled('status')) {
            if ($request->status === 'active') {
                $query->where('is_active', true);
            }

            if ($request->status === 'inactive') {
                $query->where('is_active', false);
            }
        }

        $posts = $query->orderByDesc('published_at')
            ->orderByDesc('created_at')
            ->paginate(15)
            ->withQueryString();

        return view('admin.blog-posts.index', compact('posts'));
    }

    public function create()
    {
        return view('admin.blog-posts.create');
    }

    public function store(Request $request)
    {
        $validated = $this->validateRequest($request);

        $post = new BlogPost();
        $post->title = $validated['title'];
        $post->slug = $validated['slug'] ?? null;
        $post->excerpt = $validated['excerpt'] ?? null;
        $post->content = $validated['content'];
        $post->author_name = $validated['author_name'] ?? auth()->guard('admin')->user()->name;
        $post->is_active = $validated['is_active'] ?? false;
        $post->published_at = $validated['published_at'] ?? now();
        $post->created_by = auth()->guard('admin')->id();

        if ($request->hasFile('featured_image')) {
            $post->featured_image = $request->file('featured_image')->store('blog-posts', 'public');
        }

        $post->save();

        return redirect()->route('admin.blog-posts.index')
            ->with('success', 'Blog post created successfully.');
    }

    public function edit(BlogPost $blogPost)
    {
        return view('admin.blog-posts.edit', compact('blogPost'));
    }

    public function update(Request $request, BlogPost $blogPost)
    {
        $validated = $this->validateRequest($request, $blogPost);

        $blogPost->title = $validated['title'];
        $blogPost->slug = $validated['slug'] ?? $blogPost->slug;
        $blogPost->excerpt = $validated['excerpt'] ?? null;
        $blogPost->content = $validated['content'];
        $blogPost->author_name = $validated['author_name'] ?? auth()->guard('admin')->user()->name;
        $blogPost->is_active = $validated['is_active'] ?? false;
        $blogPost->published_at = $validated['published_at'] ?? now();

        if ($request->hasFile('featured_image')) {
            if ($blogPost->featured_image) {
                Storage::disk('public')->delete($blogPost->featured_image);
            }

            $blogPost->featured_image = $request->file('featured_image')->store('blog-posts', 'public');
        }

        $blogPost->save();

        return redirect()->route('admin.blog-posts.index')
            ->with('success', 'Blog post updated successfully.');
    }

    public function destroy(BlogPost $blogPost)
    {
        if ($blogPost->featured_image) {
            Storage::disk('public')->delete($blogPost->featured_image);
        }

        $blogPost->delete();

        return redirect()->route('admin.blog-posts.index')
            ->with('success', 'Blog post deleted successfully.');
    }

    protected function validateRequest(Request $request, ?BlogPost $blogPost = null): array
    {
        return $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'slug' => [
                'nullable',
                'string',
                'max:255',
                Rule::unique('blog_posts', 'slug')->ignore($blogPost?->id),
            ],
            'excerpt' => ['nullable', 'string', 'max:1000'],
            'content' => ['required', 'string'],
            'author_name' => ['nullable', 'string', 'max:255'],
            'featured_image' => ['nullable', 'image', 'max:5120'],
            'published_at' => ['nullable', 'date'],
            'is_active' => ['nullable', 'boolean'],
        ]);
    }
}
