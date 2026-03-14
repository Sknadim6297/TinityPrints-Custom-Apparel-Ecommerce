@extends('admin.layouts.admin-app')

@section('content')
<div class="py-6 md:py-12">
    <div class="max-w-7xl mx-auto px-3 sm:px-6 lg:px-8">
        <div class="mb-6 md:mb-8 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <h2 class="font-semibold text-2xl sm:text-3xl text-gray-800 dark:text-gray-200">Blog Posts</h2>
                <p class="text-xs sm:text-sm text-gray-600 dark:text-gray-400 mt-2">Create and manage frontend blog content.</p>
            </div>
            <a href="{{ route('admin.blog-posts.create') }}" class="inline-flex items-center justify-center px-4 py-2 bg-yellow-500 text-white rounded-lg hover:bg-yellow-600 transition-colors duration-200">
                + Add Blog Post
            </a>
        </div>

        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg p-4 sm:p-6 border border-gray-100 dark:border-gray-700 mb-6">
            <form method="GET" action="{{ route('admin.blog-posts.index') }}" class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                <div class="sm:col-span-2">
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Search title, excerpt, content, author..."
                           class="w-full px-4 py-3 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:outline-none focus:ring-2 focus:ring-yellow-500">
                </div>
                <div>
                    <select name="status" class="w-full px-4 py-3 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100">
                        <option value="">All status</option>
                        <option value="active" {{ request('status') === 'active' ? 'selected' : '' }}>Active</option>
                        <option value="inactive" {{ request('status') === 'inactive' ? 'selected' : '' }}>Inactive</option>
                    </select>
                </div>
                <div class="sm:col-span-3 flex gap-3">
                    <button type="submit" class="px-6 py-2 bg-yellow-500 text-white rounded-lg hover:bg-yellow-600 transition-colors duration-200">Filter</button>
                    <a href="{{ route('admin.blog-posts.index') }}" class="px-6 py-2 bg-gray-500 text-white rounded-lg hover:bg-gray-600 transition-colors duration-200">Clear</a>
                </div>
            </form>
        </div>

        @if(session('success'))
            <div class="mb-6 p-4 bg-green-50 dark:bg-green-900/20 border border-green-200 dark:border-green-800 rounded-lg text-green-800 dark:text-green-200">
                {{ session('success') }}
            </div>
        @endif

        @if($posts->count() > 0)
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg border border-gray-100 dark:border-gray-700 overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead>
                            <tr class="bg-gray-50 dark:bg-gray-700 border-b border-gray-200 dark:border-gray-600">
                                <th class="px-6 py-4 text-left text-sm font-semibold text-gray-700 dark:text-gray-300">Title</th>
                                <th class="px-6 py-4 text-left text-sm font-semibold text-gray-700 dark:text-gray-300">Author</th>
                                <th class="px-6 py-4 text-left text-sm font-semibold text-gray-700 dark:text-gray-300">Published</th>
                                <th class="px-6 py-4 text-left text-sm font-semibold text-gray-700 dark:text-gray-300">Status</th>
                                <th class="px-6 py-4 text-left text-sm font-semibold text-gray-700 dark:text-gray-300">Created By</th>
                                <th class="px-6 py-4 text-center text-sm font-semibold text-gray-700 dark:text-gray-300">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200 dark:divide-gray-600">
                            @foreach($posts as $post)
                                <tr class="hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors duration-150">
                                    <td class="px-6 py-4">
                                        <div class="text-sm font-medium text-gray-900 dark:text-gray-100">{{ $post->title }}</div>
                                        <div class="text-xs text-gray-500 dark:text-gray-400">/{{ $post->slug }}</div>
                                    </td>
                                    <td class="px-6 py-4 text-sm text-gray-700 dark:text-gray-300">{{ $post->author_name ?: 'Admin' }}</td>
                                    <td class="px-6 py-4 text-sm text-gray-700 dark:text-gray-300">{{ optional($post->published_at)->format('M d, Y h:i A') ?: 'Immediate' }}</td>
                                    <td class="px-6 py-4 text-sm">
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium {{ $post->is_active ? 'bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-300' : 'bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-300' }}">
                                            {{ $post->is_active ? 'Active' : 'Inactive' }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 text-sm text-gray-700 dark:text-gray-300">{{ $post->admin?->name ?? 'System' }}</td>
                                    <td class="px-6 py-4">
                                        <div class="flex items-center justify-center gap-3">
                                            <a href="{{ route('blog.show', $post->slug) }}" target="_blank" class="text-blue-600 hover:text-blue-700 text-sm">View</a>
                                            <a href="{{ route('admin.blog-posts.edit', $post) }}" class="text-yellow-600 hover:text-yellow-700 text-sm">Edit</a>
                                            <form action="{{ route('admin.blog-posts.destroy', $post) }}" method="POST" onsubmit="return confirm('Delete this blog post?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-red-600 hover:text-red-700 text-sm">Delete</button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="px-6 py-4 border-t border-gray-200 dark:border-gray-600">
                    {{ $posts->links() }}
                </div>
            </div>
        @else
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg border border-gray-100 dark:border-gray-700 text-center py-12">
                <h3 class="text-sm font-medium text-gray-900 dark:text-gray-100">No blog posts found</h3>
                <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Start by creating your first post.</p>
            </div>
        @endif
    </div>
</div>
@endsection
