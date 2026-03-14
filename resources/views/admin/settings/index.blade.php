@extends('admin.layouts.admin-app')

@section('content')
<div class="py-6 md:py-12">
    <div class="max-w-7xl mx-auto px-3 sm:px-6 lg:px-8">

        <!-- Page Header -->
        <div class="mb-6 md:mb-8">
            <h2 class="font-semibold text-2xl sm:text-3xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Manage Website') }}
            </h2>
            <p class="text-xs sm:text-sm text-gray-600 dark:text-gray-400 mt-2">
                Control and manage different sections of your website.
            </p>
        </div>

        <!-- Settings Grid -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 md:gap-6">

            <!-- Website General Settings -->
            <a href="{{ route('admin.home-settings.edit') }}" class="bg-gradient-to-br from-blue-400 to-blue-600 rounded-xl sm:rounded-2xl shadow-lg p-6 text-white transform transition-all duration-300 hover:scale-105 hover:shadow-2xl">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-blue-100 text-sm font-medium mb-1">Website</p>
                        <h3 class="text-xl font-bold">General Settings</h3>
                    </div>

                    <div class="bg-blue-500 bg-opacity-30 rounded-full p-3">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 6V4m0 2a4 4 0 110 8m0-8a4 4 0 100 8m0 8v-2m0 2a4 4 0 110-8m0 8a4 4 0 100-8"/>
                        </svg>
                    </div>
                </div>
            </a>

            <!-- Limited Edition Settings -->
            <a href="{{ route('admin.limited-edition-settings.edit') }}" class="bg-gradient-to-br from-rose-400 to-orange-500 rounded-xl sm:rounded-2xl shadow-lg p-6 text-white transform transition-all duration-300 hover:scale-105 hover:shadow-2xl">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-black text-sm font-medium mb-1">Limited Edition</p>
                        <h3 class="text-xl font-bold">Page Settings</h3>
                    </div>

                    <div class="bg-rose-500 bg-opacity-30 rounded-full p-3">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-2.21 0-4 1.79-4 4s1.79 4 4 4 4-1.79 4-4-1.79-4-4-4zm0-5l1.5 3h3.5l-2.75 2.25.9 3.75L12 10.9 8.85 12l.9-3.75L7 6h3.5L12 3z"/>
                        </svg>
                    </div>
                </div>
            </a>




            <!-- Contact Page Settings -->
            <a href="{{ route('admin.contact-settings.edit') }}" class="bg-gradient-to-br from-green-400 to-green-600 rounded-xl sm:rounded-2xl shadow-lg p-6 text-white transform transition-all duration-300 hover:scale-105 hover:shadow-2xl">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-green-100 text-sm font-medium mb-1">Contact Page</p>
                        <h3 class="text-xl font-bold">Contact Settings</h3>
                    </div>

                    <div class="bg-green-500 bg-opacity-30 rounded-full p-3">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M16 12H8m0 0l4-4m-4 4l4 4"/>
                        </svg>
                    </div>
                </div>
            </a>

            <!-- Testimonial Settings -->
            <a href="{{ route('admin.testimonials.index') }}" class="bg-gradient-to-br from-purple-400 to-purple-600 rounded-xl sm:rounded-2xl shadow-lg p-6 text-white transform transition-all duration-300 hover:scale-105 hover:shadow-2xl">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-indigo-100 text-sm font-medium mb-1">Testimonials</p>
                        <h3 class="text-xl font-bold">Manage Testimonials</h3>
                    </div>

                    <div class="bg-indigo-500 bg-opacity-30 rounded-full p-3">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-3-3v6" />
                        </svg>
                    </div>
                </div>
            </a>

            <!-- Blog Settings -->
            <a href="{{ route('admin.blog-posts.index') }}" class="bg-gradient-to-br from-sky-400 to-cyan-600 rounded-xl sm:rounded-2xl shadow-lg p-6 text-white transform transition-all duration-300 hover:scale-105 hover:shadow-2xl">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sky-100 text-sm font-medium mb-1">Blog</p>
                        <h3 class="text-xl font-bold">Manage Blog Posts</h3>
                    </div>

                    <div class="bg-cyan-500 bg-opacity-30 rounded-full p-3">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21H5a2 2 0 01-2-2V5a2 2 0 012-2h14a2 2 0 012 2v14a2 2 0 01-2 2zM7 7h10M7 11h10M7 15h6"/>
                        </svg>
                    </div>
                </div>
            </a>

            <!-- About Page Settings -->
            <a href="{{ route('admin.about.edit') }}" class="bg-gradient-to-br from-yellow-400 to-yellow-600 rounded-xl sm:rounded-2xl shadow-lg p-6 text-white transform transition-all duration-300 hover:scale-105 hover:shadow-2xl">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-yellow-100 text-sm font-medium mb-1">About Page</p>
                        <h3 class="text-xl font-bold">About Settings</h3>
                    </div>

                    <div class="bg-yellow-500 bg-opacity-30 rounded-full p-3">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M13 16h-1v-4h-1m1-4h.01"/>
                        </svg>
                    </div>
                </div>
            </a>

            <!-- Footer Settings -->
            <a href="#" class="bg-gradient-to-br from-indigo-400 to-indigo-600 rounded-xl sm:rounded-2xl shadow-lg p-6 text-white transform transition-all duration-300 hover:scale-105 hover:shadow-2xl">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-indigo-100 text-sm font-medium mb-1">Footer</p>
                        <h3 class="text-xl font-bold">Footer Settings</h3>
                    </div>

                    <div class="bg-indigo-500 bg-opacity-30 rounded-full p-3">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M5 13l4 4L19 7"/>
                        </svg>
                    </div>
                </div>
            </a>

        </div>
    </div>
</div>
@endsection