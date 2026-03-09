@extends('admin.layouts.admin-app')

@section('content')
<div class="py-6 md:py-12">
    <div class="max-w-7xl mx-auto px-3 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center mb-6">
            <h2 class="font-semibold text-2xl text-gray-800 dark:text-gray-200">Testimonials</h2>
            <a href="{{ route('admin.testimonials.create') }}" class="px-4 py-2 bg-blue-600 text-white rounded">New Testimonial</a>
        </div>

        @if(session('success'))
            <div class="mb-4 text-green-600">{{ session('success') }}</div>
        @endif

        <table class="min-w-full bg-white">
            <thead>
                <tr>
                    <th class="px-4 py-2 border">#</th>
                    <th class="px-4 py-2 border">Author</th>
                    <th class="px-4 py-2 border">Position</th>
                    <th class="px-4 py-2 border">Active</th>
                    <th class="px-4 py-2 border">Order</th>
                    <th class="px-4 py-2 border">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($testimonials as $testimonial)
                    <tr>
                        <td class="px-4 py-2 border">{{ $testimonial->id }}</td>
                        <td class="px-4 py-2 border">{{ $testimonial->author_name }}</td>
                        <td class="px-4 py-2 border">{{ $testimonial->author_desc }}</td>
                        <td class="px-4 py-2 border">{{ $testimonial->is_active ? 'Yes' : 'No' }}</td>
                        <td class="px-4 py-2 border">{{ $testimonial->sort_order }}</td>
                        <td class="px-4 py-2 border">
                            <a href="{{ route('admin.testimonials.edit', $testimonial) }}" class="text-blue-600">Edit</a>
                            <form method="POST" action="{{ route('admin.testimonials.destroy', $testimonial) }}" class="inline-block" onsubmit="return confirm('Delete this testimonial?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 ml-2">Delete</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <div class="mt-4">
            {{ $testimonials->links() }}
        </div>
    </div>
</div>
@endsection
