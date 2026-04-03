@extends('admin.layouts.admin-app')

@section('content')
<div class="py-6 md:py-12">
    <div class="max-w-5xl mx-auto px-3 sm:px-6 lg:px-8">
        <!-- Page Header -->
        <div class="mb-6 md:mb-8 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 sm:gap-4">
            <div>
                <a href="{{ route('admin.products.index') }}" class="inline-flex items-center text-yellow-600 dark:text-yellow-400 hover:text-yellow-700 dark:hover:text-yellow-300 mb-2">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                    </svg>
                    Back to Products
                </a>
                <h2 class="font-semibold text-2xl sm:text-3xl text-gray-800 dark:text-gray-200">
                    {{ $product->name }}
                </h2>
            </div>
            <div class="flex gap-2 sm:gap-3">
                <a href="{{ route('admin.products.edit', $product) }}" 
                   class="inline-flex items-center bg-yellow-400 hover:bg-yellow-500 text-white font-semibold py-2 sm:py-3 px-4 sm:px-6 rounded-lg shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 transition-all duration-200 text-sm sm:text-base">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                    </svg>
                    Edit
                </a>
            </div>
        </div>

        <!-- Product Details Grid -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-4 md:gap-6">
            <!-- Main Details -->
            <div class="lg:col-span-2 space-y-4 md:space-y-6">
                <!-- Basic Info -->
                <div class="bg-white dark:bg-gray-800 rounded-xl sm:rounded-2xl shadow-lg p-4 sm:p-6 border border-gray-100 dark:border-gray-700">
                    <h3 class="text-lg font-bold text-gray-800 dark:text-gray-200 mb-4">Product Information</h3>
                    
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 sm:gap-6">
                        <div>
                            <p class="text-xs sm:text-sm text-gray-600 dark:text-gray-400">Category</p>
                            <p class="font-semibold text-gray-900 dark:text-gray-100 mt-1">{{ $product->category?->name ?? 'Uncategorized' }}</p>
                        </div>
                        <div>
                            <p class="text-xs sm:text-sm text-gray-600 dark:text-gray-400">Price</p>
                            <p class="font-semibold text-gray-900 dark:text-gray-100 text-lg mt-1">₹{{ number_format($product->base_price, 2) }}</p>
                        </div>
                        <div>
                            <p class="text-xs sm:text-sm text-gray-600 dark:text-gray-400">Weight</p>
                            <p class="font-semibold text-gray-900 dark:text-gray-100 mt-1">{{ $product->product_weight_grams ?? 250 }} g</p>
                        </div>
                        <div>
                            <p class="text-xs sm:text-sm text-gray-600 dark:text-gray-400">Sleeve Type</p>
                            <p class="font-semibold text-gray-900 dark:text-gray-100 mt-1">{{ $product->sleeveType?->name ?? 'N/A' }}</p>
                        </div>
                        <div>
                            <p class="text-xs sm:text-sm text-gray-600 dark:text-gray-400">Collection Type</p>
                            <p class="font-semibold text-gray-900 dark:text-gray-100 mt-1">{{ $product->collectionType?->name ?? 'N/A' }}</p>
                        </div>
                        <div>
                            <p class="text-xs sm:text-sm text-gray-600 dark:text-gray-400">Fit Type</p>
                            <p class="font-semibold text-gray-900 dark:text-gray-100 mt-1">
                                @php
                                    $fitDisplay = $product->fit_type;
                                    if ($fitDisplay === 'normal') $fitDisplay = 'regular';
                                    if ($fitDisplay === 'slight_oversize') $fitDisplay = 'oversize';
                                @endphp
                                {{ ucfirst(str_replace('_', ' ', $fitDisplay)) }}
                            </p>
                        </div>
                        <div>
                            <p class="text-xs sm:text-sm text-gray-600 dark:text-gray-400">Edition Type</p>
                            <div class="mt-1">
                                @if($product->is_limited_edition)
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-200">
                                        Limited Edition
                                    </span>
                                @else
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-300">
                                        Regular
                                    </span>
                                @endif
                            </div>
                        </div>
                        @if($product->drop_month)
                            <div>
                                <p class="text-xs sm:text-sm text-gray-600 dark:text-gray-400">Drop Month</p>
                                <p class="font-semibold text-gray-900 dark:text-gray-100 mt-1">{{ $product->drop_month }}</p>
                            </div>
                        @endif
                        @if($product->drop_name)
                            <div>
                                <p class="text-xs sm:text-sm text-gray-600 dark:text-gray-400">Drop Name</p>
                                <p class="font-semibold text-gray-900 dark:text-gray-100 mt-1">{{ $product->drop_name }}</p>
                            </div>
                        @endif
                        @if($product->drop_start_at)
                            <div>
                                <p class="text-xs sm:text-sm text-gray-600 dark:text-gray-400">Drop Start Date</p>
                                <p class="font-semibold text-gray-900 dark:text-gray-100 mt-1">{{ $product->drop_start_at->format('M d, Y H:i') }}</p>
                            </div>
                        @endif
                        @if($product->drop_end_at)
                            <div>
                                <p class="text-xs sm:text-sm text-gray-600 dark:text-gray-400">Drop End Date</p>
                                <p class="font-semibold text-gray-900 dark:text-gray-100 mt-1">{{ $product->drop_end_at->format('M d, Y H:i') }}</p>
                            </div>
                        @endif
                        @if($product->quantity_limit)
                            <div>
                                <p class="text-xs sm:text-sm text-gray-600 dark:text-gray-400">Quantity Limit</p>
                                <p class="font-semibold text-gray-900 dark:text-gray-100 mt-1">{{ $product->quantity_limit }}</p>
                            </div>
                        @endif
                    </div>

                    @if($product->description)
                        <div class="mt-4 sm:mt-6 pt-4 sm:pt-6 border-t border-gray-200 dark:border-gray-700">
                            <p class="text-xs sm:text-sm text-gray-600 dark:text-gray-400">Product Story</p>
                            <p class="text-gray-900 dark:text-gray-100 mt-2 leading-relaxed">{{ $product->description }}</p>
                        </div>
                    @endif

                    @if($product->is_limited_edition && $product->drop_story)
                        <div class="mt-4 sm:mt-6 pt-4 sm:pt-6 border-t border-gray-200 dark:border-gray-700">
                            <p class="text-xs sm:text-sm text-gray-600 dark:text-gray-400">Drop Story / Theme</p>
                            <p class="text-gray-900 dark:text-gray-100 mt-2 leading-relaxed">{{ $product->drop_story }}</p>
                        </div>
                    @endif
                </div>

                <!-- Available Sizes -->
                <div class="bg-white dark:bg-gray-800 rounded-xl sm:rounded-2xl shadow-lg p-4 sm:p-6 border border-gray-100 dark:border-gray-700">
                    <h3 class="text-lg font-bold text-gray-800 dark:text-gray-200 mb-4">Available Sizes</h3>
                    
                    <div class="grid grid-cols-3 sm:grid-cols-4 gap-2 sm:gap-3">
                        @foreach($product->sizes as $size)
                            <div class="bg-gradient-to-br from-yellow-50 to-red-50 dark:from-gray-700 dark:to-gray-700 p-2 sm:p-3 rounded-lg text-center border border-gray-200 dark:border-gray-600">
                                <p class="font-bold text-gray-800 dark:text-gray-200">{{ strtoupper($size->size) }}</p>
                                <p class="text-xs text-gray-600 dark:text-gray-400 mt-1">{{ $size->stock_quantity }} in stock</p>
                            </div>
                        @endforeach
                    </div>
                </div>

                <!-- Colors Section -->
                <div class="bg-white dark:bg-gray-800 rounded-xl sm:rounded-2xl shadow-lg p-4 sm:p-6 border border-gray-100 dark:border-gray-700">
                    <h3 class="text-lg font-bold text-gray-800 dark:text-gray-200 mb-4">Product Colors</h3>
                    
                    @if($product->colors->count() > 0)
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 sm:gap-6">
                            @foreach($product->colors as $color)
                                <div class="border border-gray-200 dark:border-gray-600 rounded-lg p-4 hover:shadow-lg transition-shadow duration-200">
                                    <div class="flex items-start justify-between mb-3">
                                        <div>
                                            <p class="font-semibold text-gray-900 dark:text-gray-100">{{ $color->color_name }}</p>
                                            @if($color->hex_code)
                                                <div class="flex items-center gap-2 mt-2">
                                                    <div class="w-6 h-6 rounded border border-gray-300" style="background-color: {{ $color->hex_code }}"></div>
                                                    <p class="text-xs text-gray-600 dark:text-gray-400">{{ $color->hex_code }}</p>
                                                </div>
                                            @endif
                                        </div>
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $color->is_active ? 'bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-200' : 'bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-300' }}">
                                            {{ $color->is_active ? 'Active' : 'Inactive' }}
                                        </span>
                                    </div>

                                    <!-- Color Images -->
                                    @if($color->images->count() > 0)
                                        <div class="grid grid-cols-2 gap-2 mt-4">
                                            @foreach($color->images as $image)
                                                <div>
                                                    <p class="text-xs text-gray-600 dark:text-gray-400 mb-2 font-medium">{{ ucfirst($image->image_type) }} View</p>
                                                    <img src="{{ Storage::url($image->image_path) }}" 
                                                         alt="{{ $color->color_name }} {{ $image->image_type }}"
                                                         class="w-full h-32 object-cover rounded-lg border border-gray-200 dark:border-gray-600">
                                                </div>
                                            @endforeach
                                        </div>
                                    @endif
                                </div>
                            @endforeach
                        </div>
                    @else
                        <p class="text-gray-600 dark:text-gray-400">No colors added yet.</p>
                    @endif
                </div>
            </div>

            <!-- Sidebar -->
            <div class="space-y-4 md:space-y-6">
                <!-- Meta Info -->
                <div class="bg-white dark:bg-gray-800 rounded-xl sm:rounded-2xl shadow-lg p-4 sm:p-6 border border-gray-100 dark:border-gray-700">
                    <h3 class="text-lg font-bold text-gray-800 dark:text-gray-200 mb-4">Product Meta</h3>
                    
                    <div class="space-y-3">
                        <div>
                            <p class="text-xs text-gray-600 dark:text-gray-400">Product ID</p>
                            <p class="font-mono text-sm text-gray-900 dark:text-gray-100 mt-1">#{{ $product->id }}</p>
                        </div>
                        <div>
                            <p class="text-xs text-gray-600 dark:text-gray-400">Created By</p>
                            <p class="text-sm text-gray-900 dark:text-gray-100 mt-1">{{ $product->admin?->name ?? 'System' }}</p>
                        </div>
                        <div>
                            <p class="text-xs text-gray-600 dark:text-gray-400">Created At</p>
                            <p class="text-sm text-gray-900 dark:text-gray-100 mt-1">{{ $product->created_at->format('M d, Y H:i') }}</p>
                        </div>
                        <div>
                            <p class="text-xs text-gray-600 dark:text-gray-400">Last Updated</p>
                            <p class="text-sm text-gray-900 dark:text-gray-100 mt-1">{{ $product->updated_at->format('M d, Y H:i') }}</p>
                        </div>
                    </div>
                </div>

                <!-- Stats Card -->
                <div class="bg-gradient-to-br from-yellow-50 to-red-50 dark:from-gray-700 dark:to-gray-700 rounded-xl sm:rounded-2xl shadow-lg p-4 sm:p-6 border border-yellow-200 dark:border-gray-600">
                    <h3 class="text-lg font-bold text-gray-800 dark:text-gray-200 mb-4">Quick Stats</h3>
                    
                    <div class="space-y-3">
                        <div class="flex justify-between items-center">
                            <p class="text-sm text-gray-600 dark:text-gray-400">Total Colors</p>
                            <p class="text-2xl font-bold text-gray-900 dark:text-gray-100">{{ $product->colors->count() }}</p>
                        </div>
                        <div class="flex justify-between items-center">
                            <p class="text-sm text-gray-600 dark:text-gray-400">Available Sizes</p>
                            <p class="text-2xl font-bold text-gray-900 dark:text-gray-100">{{ $product->sizes->count() }}</p>
                        </div>
                        @if($product->is_limited_edition && $product->stock_limit)
                            <div class="flex justify-between items-center pt-3 border-t border-yellow-200 dark:border-gray-600">
                                <p class="text-sm text-gray-600 dark:text-gray-400">Stock Limit</p>
                                <p class="text-2xl font-bold text-red-600 dark:text-red-400">{{ $product->stock_limit }}</p>
                            </div>
                        @endif
                        @if($product->is_limited_edition && $product->quantity_limit)
                            <div class="flex justify-between items-center pt-3 border-t border-yellow-200 dark:border-gray-600">
                                <p class="text-sm text-gray-600 dark:text-gray-400">Quantity Limit</p>
                                <p class="text-2xl font-bold text-red-600 dark:text-red-400">{{ $product->quantity_limit }}</p>
                            </div>
                        @endif
                        @if($product->is_limited_edition)
                            <div class="flex justify-between items-center pt-3 border-t border-yellow-200 dark:border-gray-600">
                                <p class="text-sm text-gray-600 dark:text-gray-400">Countdown Timer</p>
                                <p class="text-sm font-semibold {{ $product->countdown_enabled ? 'text-green-600 dark:text-green-400' : 'text-gray-600 dark:text-gray-400' }}">
                                    {{ $product->countdown_enabled ? 'Enabled' : 'Disabled' }}
                                </p>
                            </div>
                            <div class="flex justify-between items-center pt-3 border-t border-yellow-200 dark:border-gray-600">
                                <p class="text-sm text-gray-600 dark:text-gray-400">Auto Hide (Stock = 0)</p>
                                <p class="text-sm font-semibold {{ $product->auto_hide_out_of_stock ? 'text-green-600 dark:text-green-400' : 'text-gray-600 dark:text-gray-400' }}">
                                    {{ $product->auto_hide_out_of_stock ? 'Enabled' : 'Disabled' }}
                                </p>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Actions -->
                <div class="flex flex-col gap-3">
                    <form action="{{ route('admin.products.destroy', $product) }}" method="POST" onsubmit="return confirm('Are you sure?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" 
                                class="w-full bg-red-100 hover:bg-red-200 text-red-700 dark:bg-red-900/30 dark:hover:bg-red-900/50 dark:text-red-300 font-semibold py-2 sm:py-3 px-4 sm:px-6 rounded-lg transition-all duration-200 text-sm sm:text-base">
                            <svg class="w-5 h-5 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                            </svg>
                            Delete Product
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
