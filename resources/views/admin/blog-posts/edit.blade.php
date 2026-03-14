@extends('admin.layouts.admin-app')

@section('content')
<div class="py-6 md:py-12">
    <div class="max-w-4xl mx-auto px-3 sm:px-6 lg:px-8">
        <h2 class="font-semibold text-2xl text-gray-800 dark:text-gray-200 mb-6">Edit Blog Post</h2>

        @if($errors->any())
            <div class="mb-6 p-4 bg-red-50 border border-red-200 rounded-lg text-red-700">
                <ul class="list-disc pl-5 space-y-1">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('admin.blog-posts.update', $blogPost) }}" enctype="multipart/form-data" class="bg-white dark:bg-gray-800 rounded-xl shadow-lg border border-gray-100 dark:border-gray-700 p-6 space-y-5">
            @csrf
            @method('PATCH')

            <div>
                <label class="block mb-2 text-sm font-medium text-gray-700 dark:text-gray-300">Title *</label>
                <input type="text" name="title" value="{{ old('title', $blogPost->title) }}" required class="w-full px-4 py-3 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100">
            </div>

            <div>
                <label class="block mb-2 text-sm font-medium text-gray-700 dark:text-gray-300">Slug</label>
                <input type="text" name="slug" value="{{ old('slug', $blogPost->slug) }}" class="w-full px-4 py-3 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100">
            </div>

            <div>
                <label class="block mb-2 text-sm font-medium text-gray-700 dark:text-gray-300">Author Name</label>
                <input type="text" name="author_name" value="{{ old('author_name', $blogPost->author_name) }}" class="w-full px-4 py-3 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100">
            </div>

            <div>
                <label class="block mb-2 text-sm font-medium text-gray-700 dark:text-gray-300">Excerpt</label>
                <textarea name="excerpt" rows="3" class="w-full px-4 py-3 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100">{{ old('excerpt', $blogPost->excerpt) }}</textarea>
            </div>

            <div>
                <label class="block mb-2 text-sm font-medium text-gray-700 dark:text-gray-300">Content *</label>
                <textarea name="content" rows="12" required class="w-full px-4 py-3 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100">{{ old('content', $blogPost->content) }}</textarea>
            </div>

            <div>
                <label class="block mb-2 text-sm font-medium text-gray-700 dark:text-gray-300">Featured Image</label>
                <input type="file" name="featured_image" class="w-full px-4 py-3 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100">
                @if($blogPost->featured_image)
                    <div class="mt-3">
                        <img src="{{ Storage::url($blogPost->featured_image) }}" alt="Current blog image" class="w-36 rounded-lg border border-gray-200 dark:border-gray-600">
                    </div>
                @endif
            </div>

            <div>
                <label class="block mb-2 text-sm font-medium text-gray-700 dark:text-gray-300">Publish Date & Time</label>
                <input type="datetime-local" name="published_at" value="{{ old('published_at', optional($blogPost->published_at)->format('Y-m-d\TH:i')) }}" class="w-full px-4 py-3 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100">
            </div>

            <div>
                <label class="inline-flex items-center text-sm text-gray-700 dark:text-gray-300">
                    <input type="checkbox" name="is_active" value="1" {{ old('is_active', $blogPost->is_active) ? 'checked' : '' }} class="mr-2">
                    Active (visible on frontend)
                </label>
            </div>

            <div class="flex items-center gap-3">
                <button type="submit" class="px-6 py-2 bg-yellow-500 text-white rounded-lg hover:bg-yellow-600 transition-colors">Update Post</button>
                <a href="{{ route('admin.blog-posts.index') }}" class="px-6 py-2 bg-gray-500 text-white rounded-lg hover:bg-gray-600 transition-colors">Cancel</a>
            </div>
        </form>
    </div>
</div>
@endsection
