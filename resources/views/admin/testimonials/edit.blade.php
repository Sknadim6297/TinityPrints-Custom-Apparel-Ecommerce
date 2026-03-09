@extends('admin.layouts.admin-app')

@section('content')
<div class="py-6 md:py-12">
    <div class="max-w-3xl mx-auto px-3 sm:px-6 lg:px-8">
        <h2 class="font-semibold text-2xl text-gray-800 dark:text-gray-200 mb-6">Edit Testimonial</h2>

        @if($errors->any())
            <div class="mb-4 text-red-600">
                <ul class="list-disc pl-5">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('admin.testimonials.update', $testimonial) }}" enctype="multipart/form-data">
            @csrf
            @method('PATCH')

            <div class="mb-4">
                <label class="block font-medium">Author Name</label>
                <input type="text" name="author_name" value="{{ old('author_name', $testimonial->author_name) }}" class="form-control w-full" required>
            </div>

            <div class="mb-4">
                <label class="block font-medium">Author Description</label>
                <input type="text" name="author_desc" value="{{ old('author_desc', $testimonial->author_desc) }}" class="form-control w-full">
            </div>

            <div class="mb-4">
                <label class="block font-medium">Content</label>
                <textarea name="content" rows="4" class="form-control w-full" required>{{ old('content', $testimonial->content) }}</textarea>
            </div>

            <div class="mb-4">
                <label class="block font-medium">Image</label>
                @if($testimonial->image_path)
                    <div class="mb-2">
                        <img src="{{ Storage::url($testimonial->image_path) }}" alt="" class="h-20">
                    </div>
                @endif
                <input type="file" name="image" class="form-control w-full">
            </div>

            <div class="mb-4">
                <label><input type="checkbox" name="is_active" value="1" {{ old('is_active', $testimonial->is_active) ? 'checked' : '' }}> Active</label>
            </div>

            <div class="mb-4">
                <label class="block font-medium">Sort Order</label>
                <input type="number" name="sort_order" value="{{ old('sort_order', $testimonial->sort_order) }}" class="form-control w-full">
            </div>

            <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded">Update</button>
        </form>
    </div>
</div>
@endsection
