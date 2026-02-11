@extends('admin.layouts.admin-app')

@php
    use Illuminate\Support\Facades\Storage;
@endphp

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

        <!-- Product Segments -->
        <div class="mb-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div class="bg-gradient-to-r from-blue-500 to-blue-600 p-6 rounded-xl text-white shadow-lg">
                    <div class="flex items-center justify-between">
                        <div>
                            <h3 class="text-xl font-bold">T-Shirts</h3>
                            <p class="text-blue-100 mt-1">Premium collection</p>
                        </div>
                        <div class="text-right">
                            <div class="text-3xl font-bold">{{ $tshirtCount }}</div>
                            <div class="text-blue-100 text-sm">Products</div>
                        </div>
                    </div>
                    <a href="?category=t-shirt" class="inline-block mt-3 text-blue-100 hover:text-white text-sm underline">
                        View T-Shirts →
                    </a>
                </div>
                
                <div class="bg-gradient-to-r from-purple-500 to-purple-600 p-6 rounded-xl text-white shadow-lg">
                    <div class="flex items-center justify-between">
                        <div>
                            <h3 class="text-xl font-bold">Accessories (Bags)</h3>
                            <p class="text-purple-100 mt-1">Perfect companions</p>
                        </div>
                        <div class="text-right">
                            <div class="text-3xl font-bold">{{ $accessoriesCount }}</div>
                            <div class="text-purple-100 text-sm">Products</div>
                        </div>
                    </div>
                    <a href="?category=accessories" class="inline-block mt-3 text-purple-100 hover:text-white text-sm underline">
                        View Accessories →
                    </a>
                </div>
            </div>
        </div>

        <!-- Advanced Filters -->
        <div class="mb-6 bg-white dark:bg-gray-800 rounded-xl shadow-lg border border-gray-100 dark:border-gray-700 p-6">
            <h3 class="font-semibold text-lg text-gray-800 dark:text-gray-200 mb-4">Filters</h3>
            <form method="GET" class="space-y-4">
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-6 gap-4">
                    <!-- Category Filter -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Category</label>
                        <select name="category" class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-yellow-500 focus:border-transparent bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100">
                            <option value="">All Categories</option>
                            <option value="t-shirt" {{ request('category') == 't-shirt' ? 'selected' : '' }}>T-Shirts</option>
                            <option value="accessories" {{ request('category') == 'accessories' ? 'selected' : '' }}>Accessories</option>
                        </select>
                    </div>

                    <!-- Sleeve Type Filter -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Sleeve Type</label>
                        <select name="sleeve_type" class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-yellow-500 focus:border-transparent bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100">
                            <option value="">All Sleeves</option>
                            <option value="full" {{ request('sleeve_type') == 'full' ? 'selected' : '' }}>Full Sleeve</option>
                            <option value="half" {{ request('sleeve_type') == 'half' ? 'selected' : '' }}>Half Sleeve</option>
                        </select>
                    </div>

                    <!-- Size Filter -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Size</label>
                        <select name="size" class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-yellow-500 focus:border-transparent bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100">
                            <option value="">All Sizes</option>
                            @foreach(['M', 'L', 'XL'] as $size)
                                <option value="{{ strtolower($size) }}" {{ request('size') == strtolower($size) ? 'selected' : '' }}>{{ $size }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Color Filter -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Color</label>
                        <input type="text" name="color" value="{{ request('color') }}" placeholder="Search color..." 
                               class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-yellow-500 focus:border-transparent bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100">
                    </div>

                    <!-- Limited Edition Filter -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Edition</label>
                        <select name="limited_edition" class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-yellow-500 focus:border-transparent bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100">
                            <option value="">All Editions</option>
                            <option value="1" {{ request('limited_edition') === '1' ? 'selected' : '' }}>Limited Edition</option>
                            <option value="0" {{ request('limited_edition') === '0' ? 'selected' : '' }}>Regular</option>
                        </select>
                    </div>

                    <!-- Story/Theme Filter -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Story</label>
                        <select name="story" class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-yellow-500 focus:border-transparent bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100">
                            <option value="">All Products</option>
                            <option value="1" {{ request('story') === '1' ? 'selected' : '' }}>With Story</option>
                        </select>
                    </div>
                </div>
                
                <div class="flex items-center gap-3 pt-2">
                    <button type="submit" class="inline-flex items-center px-4 py-2 bg-yellow-500 hover:bg-yellow-600 text-white font-medium rounded-lg shadow transition-colors">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.207A1 1 0 013 6.5V4z" />
                        </svg>
                        Apply Filters
                    </button>
                    <a href="{{ route('admin.products.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-500 hover:bg-gray-600 text-white font-medium rounded-lg shadow transition-colors">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                        </svg>
                        Clear All
                    </a>
                </div>
            </form>
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

        <!-- Enhanced Product Cards -->
        @if($products->count() > 0)
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6 mb-8">
                @foreach($products as $product)
                    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg border border-gray-100 dark:border-gray-700 overflow-hidden hover:shadow-xl transition-all duration-300 group">
                        <!-- Product Image -->
                        <div class="relative overflow-hidden bg-gray-100 dark:bg-gray-700 aspect-square">
                            @if($product->colors->first() && $product->colors->first()->images->first())
                                <img src="{{ Storage::url($product->colors->first()->images->first()->image_path) }}" 
                                     alt="{{ $product->name }}" 
                                     class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                            @else
                                <div class="w-full h-full flex items-center justify-center text-gray-400 dark:text-gray-500">
                                    <svg class="w-16 h-16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                    </svg>
                                </div>
                            @endif

                            <!-- Quick View Button -->
                            <div class="absolute inset-0 bg-black bg-opacity-0 group-hover:bg-opacity-20 transition-all duration-300 flex items-center justify-center">
                                <a href="{{ route('admin.products.show', $product) }}" 
                                   class="bg-white text-gray-800 px-4 py-2 rounded-lg font-medium shadow-lg transform translate-y-4 opacity-0 group-hover:translate-y-0 group-hover:opacity-100 transition-all duration-300 hover:bg-gray-50">
                                    <svg class="w-4 h-4 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                    </svg>
                                    Quick View
                                </a>
                            </div>

                            <!-- Limited Edition Badge -->
                            @if($product->is_limited_edition)
                                <div class="absolute top-3 left-3">
                                    <span class="bg-red-500 text-white text-xs font-bold px-2 py-1 rounded-full shadow-lg">
                                        LIMITED
                                    </span>
                                </div>
                            @endif

                            <!-- Category Badge -->
                            <div class="absolute top-3 right-3">
                                <span class="bg-{{ $product->category == 't-shirt' ? 'blue' : 'purple' }}-500 text-white text-xs font-medium px-2 py-1 rounded-full shadow-lg">
                                    {{ $product->category == 't-shirt' ? 'T-Shirt' : 'Accessory' }}
                                </span>
                            </div>

                            <!-- Story Tag -->
                            @if($product->drop_story)
                                <div class="absolute bottom-3 left-3">
                                    <span class="bg-yellow-500 text-white text-xs font-medium px-2 py-1 rounded-full shadow-lg">
                                        📖 Story
                                    </span>
                                </div>
                            @endif
                        </div>

                        <!-- Product Info -->
                        <div class="p-4">
                            <div class="flex justify-between items-start mb-2">
                                <h3 class="font-semibold text-gray-900 dark:text-gray-100 text-lg group-hover:text-yellow-600 dark:group-hover:text-yellow-400 transition-colors">
                                    {{ $product->name }}
                                </h3>
                            </div>

                            <!-- Price -->
                            <div class="mb-3">
                                <span class="text-2xl font-bold text-gray-900 dark:text-gray-100">
                                    ${{ number_format($product->base_price, 2) }}
                                </span>
                            </div>

                            <!-- Product Details -->
                            <div class="space-y-2 mb-4">
                                @if($product->sleeve_type && $product->category == 't-shirt')
                                    <div class="flex items-center text-sm text-gray-600 dark:text-gray-400">
                                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z" />
                                        </svg>
                                        {{ ucfirst($product->sleeve_type) }} Sleeve
                                    </div>
                                @endif

                                @if($product->sizes->count() > 0)
                                    <div class="flex items-center text-sm text-gray-600 dark:text-gray-400">
                                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                                        </svg>
                                        Sizes: {{ $product->sizes->pluck('size')->map('strtoupper')->join(', ') }}
                                    </div>
                                @endif
                            </div>

                            <!-- Colors -->
                            @if($product->colors->count() > 0)
                                <div class="mb-4">
                                    <div class="flex items-center gap-2 flex-wrap">
                                        <span class="text-xs text-gray-500 dark:text-gray-400">Colors:</span>
                                        @foreach($product->colors->take(4) as $color)
                                            @php
                                                $hex = strtolower($color->hex_code ?? '#e5e7eb');
                                                $isWhite = in_array($hex, ['#fff', '#ffffff']);
                                            @endphp
                                            <div class="w-6 h-6 rounded-full border-2 border-gray-300 dark:border-gray-500 shadow-sm" 
                                                 style="background-color: {{ $hex }}; @if($isWhite) background-image: linear-gradient(45deg, #e5e7eb 25%, transparent 25%), linear-gradient(-45deg, #e5e7eb 25%, transparent 25%), linear-gradient(45deg, transparent 75%, #e5e7eb 75%), linear-gradient(-45deg, transparent 75%, #e5e7eb 75%); background-size: 8px 8px; background-position: 0 0, 0 4px, 4px -4px, -4px 0px; @endif"
                                                 title="{{ $color->color_name }}"></div>
                                        @endforeach
                                        @if($product->colors->count() > 4)
                                            <span class="text-xs text-gray-500 dark:text-gray-400">+{{ $product->colors->count() - 4 }}</span>
                                        @endif
                                    </div>
                                </div>
                            @endif

                            <!-- Action Buttons -->
                            <div class="flex items-center justify-between gap-2">
                                <div class="flex items-center gap-1">
                                    <a href="{{ route('admin.products.edit', $product) }}" 
                                       class="inline-flex items-center justify-center w-8 h-8 bg-yellow-100 text-yellow-700 dark:bg-yellow-900/30 dark:text-yellow-300 rounded-lg hover:bg-yellow-200 dark:hover:bg-yellow-900/50 transition-colors duration-200"
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
                                                class="inline-flex items-center justify-center w-8 h-8 bg-red-100 text-red-700 dark:bg-red-900/30 dark:text-red-300 rounded-lg hover:bg-red-200 dark:hover:bg-red-900/50 transition-colors duration-200"
                                                title="Delete">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                            </svg>
                                        </button>
                                    </form>
                                </div>

                                <!-- Stock Status -->
                                <div class="text-xs">
                                    @if($product->totalStock() > 0)
                                        <span class="text-green-600 dark:text-green-400 font-medium">In Stock ({{ $product->totalStock() }})</span>
                                    @else
                                        <span class="text-red-600 dark:text-red-400 font-medium">Out of Stock</span>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Pagination -->
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg border border-gray-100 dark:border-gray-700 px-6 py-4">
                {{ $products->links() }}
            </div>
        @else
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg border border-gray-100 dark:border-gray-700 p-12 text-center">
                <svg class="w-16 h-16 mx-auto text-gray-400 dark:text-gray-500 mb-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4" />
                </svg>
                <h3 class="text-xl font-semibold text-gray-700 dark:text-gray-300 mb-3">No Products Found</h3>
                @if(request()->hasAny(['category', 'sleeve_type', 'size', 'color', 'limited_edition', 'story']))
                    <p class="text-gray-500 dark:text-gray-400 mb-6">No products match your current filters. Try adjusting your search criteria.</p>
                    <a href="{{ route('admin.products.index') }}" 
                       class="inline-flex items-center bg-gray-500 hover:bg-gray-600 text-white font-medium py-2 px-4 rounded-lg transition-colors mr-3">
                        Clear Filters
                    </a>
                @else
                    <p class="text-gray-500 dark:text-gray-400 mb-6">Start by adding your first product to the catalog.</p>
                @endif
                <a href="{{ route('admin.products.create') }}" 
                   class="inline-flex items-center bg-gradient-to-r from-yellow-400 to-yellow-600 text-white font-semibold py-3 px-6 rounded-lg hover:from-yellow-500 hover:to-yellow-700 transition-all duration-200 shadow-lg">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                    </svg>
                    Add Product
                </a>
            </div>
        @endif
    </div>
</div>
@endsection
