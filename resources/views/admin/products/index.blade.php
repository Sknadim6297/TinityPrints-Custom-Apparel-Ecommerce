@extends('admin.layouts.admin-app')

@section('content')
<div class="py-6 md:py-12">
    <div class="max-w-7xl mx-auto px-3 sm:px-6 lg:px-8">
        <!-- Page Header -->
        <div class="mb-6 md:mb-8 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 sm:gap-4">
            <div>
                <h2 class="font-semibold text-2xl sm:text-3xl text-gray-800 dark:text-gray-200">
                    Product Management
                </h2>
                <p class="text-xs sm:text-sm text-gray-600 dark:text-gray-400 mt-1">
                    Manage T-Shirt & Accessory Products
                </p>
            </div>
            <a href="{{ route('admin.products.create') }}" 
               class="inline-flex items-center justify-center bg-gradient-to-r from-yellow-400 to-yellow-600 hover:from-yellow-500 hover:to-yellow-700 text-white font-semibold py-2 sm:py-3 px-4 sm:px-6 rounded-lg shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 transition-all duration-200 text-sm sm:text-base">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                </svg>
                Add Product
            </a>
        </div>

        <!-- Success Message -->
        @if (session('success'))
            <div class="mb-6 p-4 bg-green-50 dark:bg-green-900/20 border-l-4 border-green-500 text-green-700 dark:text-green-300 rounded-lg">
                <div class="flex items-center">
                    <svg class="w-5 h-5 mr-3 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                    </svg>
                    <span class="text-sm font-medium">{{ session('success') }}</span>
                </div>
            </div>
        @endif

        <!-- Products Table -->
        <div class="bg-white dark:bg-gray-800 rounded-xl sm:rounded-2xl shadow-lg overflow-hidden border border-gray-100 dark:border-gray-700">
            @if($products->count() > 0)
                <div class="overflow-x-auto">
                    <table class="w-full text-sm">
                        <thead>
                            <tr class="bg-gradient-to-r from-yellow-100 to-red-100 dark:from-gray-800 dark:to-gray-800 border-b border-gray-200 dark:border-gray-600">
                                <th class="px-3 sm:px-6 py-3 sm:py-4 text-left font-semibold text-gray-900 dark:text-gray-100">Product Name</th>
                                <th class="px-3 sm:px-6 py-3 sm:py-4 text-left font-semibold text-gray-900 dark:text-gray-100">Category</th>
                                <th class="px-3 sm:px-6 py-3 sm:py-4 text-left font-semibold text-gray-900 dark:text-gray-100">Price</th>
                                <th class="px-3 sm:px-6 py-3 sm:py-4 text-left font-semibold text-gray-900 dark:text-gray-100">Edition</th>
                                <th class="px-3 sm:px-6 py-3 sm:py-4 text-left font-semibold text-gray-900 dark:text-gray-100">Colors</th>
                                <th class="px-3 sm:px-6 py-3 sm:py-4 text-center font-semibold text-gray-900 dark:text-gray-100">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100 dark:divide-gray-700">
                            @foreach($products as $product)
                                <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-colors duration-150">
                                    <td class="px-3 sm:px-6 py-3 sm:py-4">
                                        <div class="font-semibold text-gray-900 dark:text-gray-100">{{ $product->name }}</div>
                                        <div class="text-xs text-gray-500 dark:text-gray-400 mt-1">{{ Str::limit($product->description, 40) }}</div>
                                    </td>
                                    <td class="px-3 sm:px-6 py-3 sm:py-4">
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800 dark:bg-blue-900/30 dark:text-blue-200">
                                            {{ ucfirst($product->category) }}
                                        </span>
                                    </td>
                                    <td class="px-3 sm:px-6 py-3 sm:py-4 text-gray-900 dark:text-gray-100 font-semibold">
                                        ${{ number_format($product->base_price, 2) }}
                                    </td>
                                    <td class="px-3 sm:px-6 py-3 sm:py-4">
                                        @if($product->is_limited_edition)
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-200">
                                                Limited
                                            </span>
                                        @else
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-300">
                                                Regular
                                            </span>
                                        @endif
                                    </td>
                                    <td class="px-3 sm:px-6 py-3 sm:py-4">
                                        <div class="flex items-center gap-1">
                                            @foreach($product->colors->take(3) as $color)
                                                @php
                                                    $hex = strtolower($color->hex_code ?? '#e5e7eb');
                                                    $isWhite = in_array($hex, ['#fff', '#ffffff']);
                                                @endphp
                                                <div class="w-6 h-6 sm:w-8 sm:h-8 rounded-full border-2 border-gray-400 dark:border-gray-600 shadow-sm" 
                                                     style="background-color: {{ $hex }}; @if($isWhite) background-image: linear-gradient(45deg, #e5e7eb 25%, transparent 25%), linear-gradient(-45deg, #e5e7eb 25%, transparent 25%), linear-gradient(45deg, transparent 75%, #e5e7eb 75%), linear-gradient(-45deg, transparent 75%, #e5e7eb 75%); background-size: 8px 8px; background-position: 0 0, 0 4px, 4px -4px, -4px 0px; @endif"
                                                     title="{{ $color->color_name }}"></div>
                                            @endforeach
                                            @if($product->colors->count() > 3)
                                                <span class="text-xs text-gray-500 dark:text-gray-400 ml-1">+{{ $product->colors->count() - 3 }}</span>
                                            @endif
                                        </div>
                                    </td>
                                    <td class="px-3 sm:px-6 py-3 sm:py-4 text-center">
                                        <div class="flex items-center justify-center gap-1 sm:gap-2">
                                            <a href="{{ route('admin.products.show', $product) }}" 
                                               class="inline-flex items-center justify-center w-8 h-8 sm:w-10 sm:h-10 bg-blue-100 text-blue-700 dark:bg-blue-900/30 dark:text-blue-300 rounded-lg hover:bg-blue-200 dark:hover:bg-blue-900/50 transition-colors duration-200"
                                               title="View">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                                </svg>
                                            </a>
                                            <a href="{{ route('admin.products.edit', $product) }}" 
                                               class="inline-flex items-center justify-center w-8 h-8 sm:w-10 sm:h-10 bg-yellow-100 text-yellow-700 dark:bg-yellow-900/30 dark:text-yellow-300 rounded-lg hover:bg-yellow-200 dark:hover:bg-yellow-900/50 transition-colors duration-200"
                                               title="Edit">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                                </svg>
                                            </a>
                                            <form action="{{ route('admin.products.destroy', $product) }}" method="POST" class="inline" 
                                                  onsubmit="return confirm('Are you sure you want to delete this product?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" 
                                                        class="inline-flex items-center justify-center w-8 h-8 sm:w-10 sm:h-10 bg-red-100 text-red-700 dark:bg-red-900/30 dark:text-red-300 rounded-lg hover:bg-red-200 dark:hover:bg-red-900/50 transition-colors duration-200"
                                                        title="Delete">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                    </svg>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                <div class="px-3 sm:px-6 py-4 bg-gray-100 dark:bg-gray-800 border-t border-gray-200 dark:border-gray-600 text-gray-700 dark:text-gray-200">
                    {{ $products->links() }}
                </div>
            @else
                <div class="px-6 py-12 text-center">
                    <svg class="w-8 h-8 mx-auto text-gray-400 dark:text-gray-500 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4" />
                    </svg>
                    <h3 class="text-lg font-semibold text-gray-700 dark:text-gray-300 mb-2">No Products Found</h3>
                    <p class="text-gray-500 dark:text-gray-400 mb-6">Start by adding your first product to the catalog.</p>
                    <a href="{{ route('admin.products.create') }}" 
                       class="inline-flex items-center bg-gradient-to-r from-yellow-400 to-yellow-600 text-white font-semibold py-2 px-4 rounded-lg hover:from-yellow-500 hover:to-yellow-700 transition-all duration-200">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                        </svg>
                        Add First Product
                    </a>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
