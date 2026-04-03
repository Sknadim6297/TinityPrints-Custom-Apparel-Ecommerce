@extends('admin.layouts.admin-app')

@section('content')
<div class="py-6 md:py-12">
    <div class="max-w-4xl mx-auto px-3 sm:px-6 lg:px-8">
        <!-- Page Header -->
        <div class="mb-6 md:mb-8">
            <a href="{{ route('admin.products.index') }}" class="inline-flex items-center text-yellow-600 dark:text-yellow-400 hover:text-yellow-700 dark:hover:text-yellow-300 mb-4">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                </svg>
                Back to Products
            </a>
            <h2 class="font-semibold text-2xl sm:text-3xl text-gray-800 dark:text-gray-200">
                Add New Product
            </h2>
            <p class="text-xs sm:text-sm text-gray-600 dark:text-gray-400 mt-2">
                Create a new T-Shirt or Accessory product with colors and images
            </p>
        </div>

        <form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf

            <!-- Basic Information Section -->
            <div class="bg-white dark:bg-gray-800 rounded-xl sm:rounded-2xl shadow-lg p-4 sm:p-6 border border-gray-100 dark:border-gray-700">
                <h3 class="text-lg sm:text-xl font-bold text-gray-800 dark:text-gray-200 mb-4 flex items-center">
                    <svg class="w-6 h-6 mr-3 text-yellow-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    Basic Information
                </h3>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 sm:gap-6">
                    <!-- Product Name -->
                    <div class="sm:col-span-2">
                        <label for="name" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                            Product Name *
                        </label>
                        <input id="name" 
                               type="text" 
                               name="name" 
                               value="{{ old('name') }}"
                               required
                               class="w-full px-4 py-3 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:outline-none focus:ring-2 focus:ring-yellow-500 dark:focus:ring-yellow-400 transition-all duration-200"
                               placeholder="e.g., Classic White T-Shirt">
                        @error('name')
                            <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Description -->
                    <div class="sm:col-span-2">
                        <label for="description" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                            Product Story / Description
                        </label>
                        <textarea id="description" 
                                  name="description" 
                                  rows="4"
                                  class="w-full px-4 py-3 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:outline-none focus:ring-2 focus:ring-yellow-500 dark:focus:ring-yellow-400 transition-all duration-200"
                                  placeholder="Tell the story behind this product...">{{ old('description') }}</textarea>
                        @error('description')
                            <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Category -->
                    <div>
                        <label for="category_id" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                            Category *
                        </label>
                        <select id="category_id" 
                                name="category_id" 
                                required
                                class="w-full px-4 py-3 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:outline-none focus:ring-2 focus:ring-yellow-500 dark:focus:ring-yellow-400 transition-all duration-200">
                            <option value="">Select Category</option>
                        </select>
                        @error('category_id')
                            <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Sleeve Type -->
                    <div id="sleeve-type-field">
                        <label for="sleeve_type_id" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                            Sleeve Type *
                        </label>
                        <select id="sleeve_type_id" 
                                name="sleeve_type_id" 
                                required
                                class="w-full px-4 py-3 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:outline-none focus:ring-2 focus:ring-yellow-500 dark:focus:ring-yellow-400 transition-all duration-200">
                            <option value="">Select Sleeve Type</option>
                        </select>
                        @error('sleeve_type_id')
                            <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Collection Type / Fabric -->
                    <div id="collection-type-field">
                        <label for="collection_type_id" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                            Fabric
                        </label>
                        <select id="collection_type_id" 
                                name="collection_type_id"
                                class="w-full px-4 py-3 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:outline-none focus:ring-2 focus:ring-yellow-500 dark:focus:ring-yellow-400 transition-all duration-200">
                            <option value="">Select Fabric (Optional)</option>
                        </select>
                        @error('collection_type_id')
                            <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Fit Type -->
                    <div id="fit-type-field">
                        <label for="fit_type" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                            Fit Type *
                        </label>
                        <select id="fit_type" 
                                name="fit_type" 
                                required
                                class="w-full px-4 py-3 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:outline-none focus:ring-2 focus:ring-yellow-500 dark:focus:ring-yellow-400 transition-all duration-200">
                            <option value="">Select Fit Type</option>
                            <option value="regular" {{ old('fit_type') == 'regular' || old('fit_type') == 'normal' ? 'selected' : '' }}>Regular</option>
                            <option value="oversize" {{ old('fit_type') == 'oversize' || old('fit_type') == 'slight_oversize' ? 'selected' : '' }}>Oversize</option>
                        </select>
                        @error('fit_type')
                            <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- MRP -->
                    <div>
                        <label for="mrp" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                            MRP (₹) *
                        </label>
                        <input id="mrp" 
                               type="number" 
                               name="mrp" 
                               value="{{ old('mrp', old('base_price')) }}"
                               step="0.01"
                               min="0.01"
                               required
                               class="w-full px-4 py-3 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:outline-none focus:ring-2 focus:ring-yellow-500 dark:focus:ring-yellow-400 transition-all duration-200"
                               placeholder="1299.00">
                        @error('mrp')
                            <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Selling Price -->
                    <div>
                        <label for="selling_price" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                            Selling Price (₹) *
                        </label>
                        <input id="selling_price" 
                               type="number" 
                               name="selling_price" 
                               value="{{ old('selling_price', old('base_price')) }}"
                               step="0.01"
                               min="0.01"
                               required
                               class="w-full px-4 py-3 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:outline-none focus:ring-2 focus:ring-yellow-500 dark:focus:ring-yellow-400 transition-all duration-200"
                               placeholder="999.00">
                        @error('selling_price')
                            <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="product_weight_grams" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                            Product Weight (g) *
                        </label>
                        <input id="product_weight_grams"
                               type="number"
                               name="product_weight_grams"
                               value="{{ old('product_weight_grams') }}"
                               step="1"
                               min="1"
                               required
                               class="w-full px-4 py-3 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:outline-none focus:ring-2 focus:ring-yellow-500 dark:focus:ring-yellow-400 transition-all duration-200"
                               placeholder="250">
                        @error('product_weight_grams')
                            <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="discount_percentage" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                            Discount (%)
                        </label>
                        <input id="discount_percentage"
                               type="text"
                               value="0%"
                               readonly
                               class="w-full px-4 py-3 rounded-lg border border-gray-200 dark:border-gray-600 bg-gray-100 dark:bg-gray-800 text-gray-700 dark:text-gray-200 focus:outline-none">
                    </div>

                    <!-- Drop Month -->
                    <div>
                        <label for="drop_month" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                            Drop Month
                        </label>
                        <input id="drop_month" 
                               type="text" 
                               name="drop_month" 
                               value="{{ old('drop_month') }}"
                               class="w-full px-4 py-3 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:outline-none focus:ring-2 focus:ring-yellow-500 dark:focus:ring-yellow-400 transition-all duration-200"
                               placeholder="e.g., February 2026">
                        @error('drop_month')
                            <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Limited Edition -->
                    <div class="flex items-center">
                        <input id="is_limited_edition" 
                               type="checkbox" 
                               name="is_limited_edition" 
                               value="1"
                               {{ old('is_limited_edition') ? 'checked' : '' }}
                               class="w-4 h-4 rounded border-gray-300 dark:border-gray-600 text-red-600 focus:ring-red-500 dark:focus:ring-red-400 dark:bg-gray-700">
                        <label for="is_limited_edition" class="ml-2 block text-sm font-medium text-gray-700 dark:text-gray-300">
                            Mark as Limited Edition
                        </label>
                    </div>

                    <!-- Limited Edition Drop Controls -->
                    <div id="drop_control_container" class="sm:col-span-2" style="display: {{ old('is_limited_edition') ? 'block' : 'none' }}">
                        <div class="mt-2 p-4 rounded-xl border border-yellow-200 dark:border-gray-600 bg-yellow-50/60 dark:bg-gray-700/40">
                            <h4 class="text-sm font-bold text-gray-800 dark:text-gray-200 mb-4">Limited Edition Drop Control</h4>
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                <div class="sm:col-span-2">
                                    <label for="drop_name" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                                        Drop Name
                                    </label>
                                    <input id="drop_name"
                                           type="text"
                                           name="drop_name"
                                           value="{{ old('drop_name') }}"
                                           class="w-full px-4 py-3 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:outline-none focus:ring-2 focus:ring-yellow-500 dark:focus:ring-yellow-400 transition-all duration-200"
                                           placeholder="e.g., Midnight Bloom">
                                    @error('drop_name')
                                        <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div class="sm:col-span-2">
                                    <label for="drop_story" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                                        Drop Story / Theme
                                    </label>
                                    <textarea id="drop_story"
                                              name="drop_story"
                                              rows="3"
                                              class="w-full px-4 py-3 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:outline-none focus:ring-2 focus:ring-yellow-500 dark:focus:ring-yellow-400 transition-all duration-200"
                                              placeholder="Short story or theme for this drop...">{{ old('drop_story') }}</textarea>
                                    @error('drop_story')
                                        <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="drop_start_at" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                                        Drop Start Date
                                    </label>
                                    <input id="drop_start_at"
                                           type="datetime-local"
                                           name="drop_start_at"
                                           value="{{ old('drop_start_at') }}"
                                           class="w-full px-4 py-3 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:outline-none focus:ring-2 focus:ring-yellow-500 dark:focus:ring-yellow-400 transition-all duration-200">
                                    @error('drop_start_at')
                                        <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="drop_end_at" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                                        Drop End Date
                                    </label>
                                    <input id="drop_end_at"
                                           type="datetime-local"
                                           name="drop_end_at"
                                           value="{{ old('drop_end_at') }}"
                                           class="w-full px-4 py-3 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:outline-none focus:ring-2 focus:ring-yellow-500 dark:focus:ring-yellow-400 transition-all duration-200">
                                    @error('drop_end_at')
                                        <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="quantity_limit" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                                        Quantity Limit
                                    </label>
                                    <input id="quantity_limit"
                                           type="number"
                                           name="quantity_limit"
                                           value="{{ old('quantity_limit') }}"
                                           min="1"
                                           class="w-full px-4 py-3 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:outline-none focus:ring-2 focus:ring-yellow-500 dark:focus:ring-yellow-400 transition-all duration-200"
                                           placeholder="e.g., 500">
                                    @error('quantity_limit')
                                        <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div class="flex items-center">
                                    <input id="countdown_enabled"
                                           type="checkbox"
                                           name="countdown_enabled"
                                           value="1"
                                           {{ old('countdown_enabled') ? 'checked' : '' }}
                                           class="w-4 h-4 rounded border-gray-300 dark:border-gray-600 text-red-600 focus:ring-red-500 dark:focus:ring-red-400 dark:bg-gray-700">
                                    <label for="countdown_enabled" class="ml-2 block text-sm font-medium text-gray-700 dark:text-gray-300">
                                        Countdown Timer Activation
                                    </label>
                                </div>

                                <div class="flex items-center">
                                    <input id="auto_hide_out_of_stock"
                                           type="checkbox"
                                           name="auto_hide_out_of_stock"
                                           value="1"
                                           {{ old('auto_hide_out_of_stock') ? 'checked' : '' }}
                                           class="w-4 h-4 rounded border-gray-300 dark:border-gray-600 text-red-600 focus:ring-red-500 dark:focus:ring-red-400 dark:bg-gray-700">
                                    <label for="auto_hide_out_of_stock" class="ml-2 block text-sm font-medium text-gray-700 dark:text-gray-300">
                                        Auto Hide when stock = 0
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Sizes Section -->
            <div class="bg-white dark:bg-gray-800 rounded-xl sm:rounded-2xl shadow-lg p-4 sm:p-6 border border-gray-100 dark:border-gray-700">
                <h3 class="text-lg sm:text-xl font-bold text-gray-800 dark:text-gray-200 mb-4 flex items-center">
                    <svg class="w-6 h-6 mr-3 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21a4 4 0 01-4-4V5a2 2 0 012-2h4a2 2 0 012 2v12a4 4 0 01-4 4zm0 0h12a2 2 0 002-2v-4a2 2 0 00-2-2h-2.5a2 2 0 00-1 .267V5a2 2 0 10-4 0v.733A2 2 0 00 7 5" />
                    </svg>
                    Available Sizes
                </h3>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 sm:gap-4">
                    @foreach(['XS' => 'xs', 'S' => 's', 'M' => 'm', 'L' => 'l', 'XL' => 'xl', 'XXL' => 'xxl'] as $label => $value)
                        <div class="flex items-center gap-3 p-3 border-2 border-gray-200 dark:border-gray-600 rounded-lg hover:border-yellow-400 dark:hover:border-yellow-500 transition-colors duration-200 {{ in_array($value, old('sizes', [])) ? 'border-yellow-400 dark:border-yellow-500 bg-yellow-50 dark:bg-yellow-900/10' : '' }}">
                            <label class="flex items-center gap-2 cursor-pointer">
                                <input type="checkbox"
                                       name="sizes[]"
                                       value="{{ $value }}"
                                       {{ in_array($value, old('sizes', [])) ? 'checked' : '' }}
                                       class="w-4 h-4 rounded border-gray-300 dark:border-gray-600 text-yellow-600 focus:ring-yellow-500 dark:focus:ring-yellow-400 dark:bg-gray-700">
                                <span class="font-semibold text-gray-700 dark:text-gray-300">{{ $label }}</span>
                            </label>
                            <div class="ml-auto flex items-center gap-2">
                                <label for="size_stock_{{ $value }}" class="text-xs text-gray-600 dark:text-gray-400">Stock</label>
                                <input id="size_stock_{{ $value }}"
                                       type="number"
                                       name="size_stocks[{{ $value }}]"
                                       value="{{ old('size_stocks.' . $value, 0) }}"
                                       min="0"
                                       class="w-20 px-2 py-1 rounded-md border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:outline-none focus:ring-2 focus:ring-yellow-500 dark:focus:ring-yellow-400">
                            </div>
                        </div>
                    @endforeach
                </div>
                @error('sizes')
                    <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                @enderror
                @error('size_stocks')
                    <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                @enderror
            </div>

            <!-- Colors & Images Section -->
            <div class="bg-white dark:bg-gray-800 rounded-xl sm:rounded-2xl shadow-lg p-4 sm:p-6 border border-gray-100 dark:border-gray-700">
                <h3 class="text-lg sm:text-xl font-bold text-gray-800 dark:text-gray-200 mb-4 flex items-center">
                    <svg class="w-6 h-6 mr-3 text-purple-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                    </svg>
                    Colors & Images
                </h3>

                <div id="colors-container" class="space-y-4 sm:space-y-6">
                    <!-- Color 1 (template) -->
                    <div class="color-item bg-gray-50 dark:bg-gray-700/50 p-4 sm:p-6 rounded-lg border-2 border-dashed border-gray-300 dark:border-gray-600">
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 sm:gap-6">
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                                    Color Name *
                                </label>
                                <input type="text" 
                                       name="colors[0][name]" 
                                       class="w-full px-4 py-3 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:outline-none focus:ring-2 focus:ring-purple-500 dark:focus:ring-purple-400"
                                       placeholder="e.g., Classic White"
                                       required>
                            </div>

                            <div>
                                <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                                    Color Picker (Optional)
                                </label>
                                <input type="color" 
                                       name="colors[0][hex_code]" 
                                       value="#FFFFFF"
                                       class="w-full h-12 px-2 py-1 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-purple-500 dark:focus:ring-purple-400 cursor-pointer"
                                       title="Choose a color">
                            </div>

                            <div>
                                <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                                    Front Image
                                </label>
                                <input type="file" 
                                       name="colors[0][front_image]" 
                                       accept="image/*"
                                       class="w-full px-4 py-3 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:outline-none focus:ring-2 focus:ring-purple-500 dark:focus:ring-purple-400">
                                <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">Max 5MB. Recommended: 1000x1200px</p>
                            </div>

                            <div>
                                <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                                    Back Image
                                </label>
                                <input type="file" 
                                       name="colors[0][back_image]" 
                                       accept="image/*"
                                       class="w-full px-4 py-3 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:outline-none focus:ring-2 focus:ring-purple-500 dark:focus:ring-purple-400">
                                <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">Max 5MB. Recommended: 1000x1200px</p>
                            </div>

                            <div class="sm:col-span-2">
                                <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                                    Extra Images
                                </label>
                                    <input type="file"
                                        name="colors[0][extra_images][]"
                                        accept="image/*"
                                        multiple
                                        class="w-full px-4 py-3 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:outline-none focus:ring-2 focus:ring-purple-500 dark:focus:ring-purple-400 extra-images-input">
                                    <div class="extra-images-preview flex flex-wrap gap-2 mt-2"></div>
                                    <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">Upload multiple gallery images (optional). You can remove any image before submitting.</p>
                            </div>
                        </div>
                    </div>
                </div>

                <button type="button" 
                        id="add-color-btn"
                        class="mt-4 inline-flex items-center px-4 py-2 bg-purple-100 text-purple-700 dark:bg-purple-900/30 dark:text-purple-300 rounded-lg hover:bg-purple-200 dark:hover:bg-purple-900/50 transition-colors duration-200 font-medium text-sm">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                    </svg>
                    Add Color Option
                </button>
                @error('colors')
                    <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                @enderror
            </div>

            <!-- Form Actions -->
            <div class="flex flex-col sm:flex-row gap-3 sm:gap-4">
                <button type="submit" 
                        class="flex-1 bg-gradient-to-r from-yellow-400 to-yellow-600 hover:from-yellow-500 hover:to-yellow-700 text-white font-bold py-3 px-6 rounded-lg shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 transition-all duration-200 text-center">
                    <svg class="w-5 h-5 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                    </svg>
                    Create Product
                </button>

                <a href="{{ route('admin.products.index') }}" 
                   class="flex-1 bg-gray-200 dark:bg-gray-700 text-gray-800 dark:text-gray-200 hover:bg-gray-300 dark:hover:bg-gray-600 font-bold py-3 px-6 rounded-lg shadow-lg transition-all duration-200 text-center">
                    Cancel
                </a>
            </div>
        </form>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Toggle limited edition drop controls
    const limitedEditionCheckbox = document.getElementById('is_limited_edition');
    const dropControlContainer = document.getElementById('drop_control_container');
    const quantityLimitInput = document.getElementById('quantity_limit');

    if (limitedEditionCheckbox) {
        limitedEditionCheckbox.addEventListener('change', function() {
            if (this.checked) {
                dropControlContainer.style.display = 'block';
                if (quantityLimitInput) {
                    quantityLimitInput.required = true;
                }
            } else {
                dropControlContainer.style.display = 'none';
                if (quantityLimitInput) {
                    quantityLimitInput.required = false;
                }
            }
        });
    }

    // Add color function
    let colorIndex = 1;
    let isAddingColor = false;
    const addColorBtn = document.getElementById('add-color-btn');

    if (addColorBtn && addColorBtn.dataset.bound !== '1') {
        addColorBtn.dataset.bound = '1';
        addColorBtn.addEventListener('click', function() {
            if (isAddingColor) {
                return;
            }
            isAddingColor = true;

            const container = document.getElementById('colors-container');
            const template = container.firstElementChild.cloneNode(true);
        
            // Update all input names to use new index
            template.querySelectorAll('input').forEach(input => {
                const name = input.getAttribute('name');
                if (name) {
                    const newName = name.replace(/\[\d+\]/, `[${colorIndex}]`);
                    input.setAttribute('name', newName);
                    // Keep default color for color picker, clear others
                    if (input.type !== 'color') {
                        input.value = '';
                    }
                }
            });

            // Add remove button
            const removeBtn = document.createElement('button');
            removeBtn.type = 'button';
            removeBtn.className = 'mt-4 inline-flex items-center px-3 py-2 bg-red-100 text-red-700 dark:bg-red-900/30 dark:text-red-300 rounded-lg hover:bg-red-200 dark:hover:bg-red-900/50 transition-colors duration-200 font-medium text-sm';
            removeBtn.innerHTML = '<svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" /></svg> Remove Color';
            removeBtn.addEventListener('click', function(e) {
                e.preventDefault();
                template.remove();
            });

            template.appendChild(removeBtn);
            container.appendChild(template);
            colorIndex++;

            setTimeout(() => {
                isAddingColor = false;
            }, 100);
        });
    }

    function isAccessoriesCategory() {
        const categorySelect = document.getElementById('category_id');
        if (!categorySelect) {
            return false;
        }

        const selectedOption = categorySelect.options[categorySelect.selectedIndex];
        const text = (selectedOption?.textContent || '').toLowerCase();
        const slug = (selectedOption?.dataset?.slug || '').toLowerCase();

        return text.includes('accessor') || slug.includes('accessor');
    }

    function toggleCategoryDependentFields() {
        const isAccessories = isAccessoriesCategory();
        const sleeveField = document.getElementById('sleeve-type-field');
        const fitField = document.getElementById('fit-type-field');
        const collectionField = document.getElementById('collection-type-field');
        const sleeveInput = document.getElementById('sleeve_type_id');
        const fitInput = document.getElementById('fit_type');

        [sleeveField, fitField, collectionField].forEach((el) => {
            if (el) {
                el.style.display = isAccessories ? 'none' : '';
            }
        });

        if (sleeveInput) {
            sleeveInput.required = !isAccessories;
            if (isAccessories) {
                sleeveInput.value = '';
            }
        }

        if (fitInput) {
            fitInput.required = !isAccessories;
            if (isAccessories) {
                fitInput.value = 'regular';
            }
        }
    }

    const categorySelect = document.getElementById('category_id');
    if (categorySelect) {
        categorySelect.addEventListener('change', toggleCategoryDependentFields);
    }

    window.tinnityToggleCategoryDependentFields = toggleCategoryDependentFields;

    const mrpInput = document.getElementById('mrp');
    const sellingPriceInput = document.getElementById('selling_price');
    const discountInput = document.getElementById('discount_percentage');

    function updateDiscountPreview() {
        if (!mrpInput || !sellingPriceInput || !discountInput) {
            return;
        }

        const mrp = parseFloat(mrpInput.value);
        const selling = parseFloat(sellingPriceInput.value);

        if (!Number.isFinite(mrp) || mrp <= 0 || !Number.isFinite(selling) || selling >= mrp) {
            discountInput.value = '0%';
            return;
        }

        const discount = Math.round(((mrp - selling) / mrp) * 100);
        discountInput.value = `${Math.max(discount, 0)}%`;
    }

    if (mrpInput && sellingPriceInput) {
        mrpInput.addEventListener('input', updateDiscountPreview);
        sellingPriceInput.addEventListener('input', updateDiscountPreview);
        updateDiscountPreview();
    }
});

// Load dropdown options from API
document.addEventListener('DOMContentLoaded', function() {
    loadDropdownOptions();
});

function loadDropdownOptions() {
    fetch('{{ route("api.dropdowns.all") }}')
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                populateCategoryDropdown(data.data.categories);
                populateSleeveTypeDropdown(data.data.sleeveTypes);
                populateCollectionTypeDropdown(data.data.collectionTypes);
            }
        })
        .catch(error => console.error('Error loading dropdowns:', error));
}

function populateCategoryDropdown(categories) {
    const select = document.getElementById('category_id');
    const oldValue = '{{ old("category_id") }}';
    
    categories.forEach(category => {
        const option = document.createElement('option');
        option.value = category.id;
        option.textContent = category.name;
        option.dataset.slug = category.slug || '';
        if (oldValue == category.id) {
            option.selected = true;
        }
        select.appendChild(option);
    });

    if (typeof window.tinnityToggleCategoryDependentFields === 'function') {
        window.tinnityToggleCategoryDependentFields();
    }
}

function populateSleeveTypeDropdown(sleeveTypes) {
    const select = document.getElementById('sleeve_type_id');
    const oldValue = '{{ old("sleeve_type_id") }}';
    
    sleeveTypes.forEach(sleeveType => {
        const option = document.createElement('option');
        option.value = sleeveType.id;
        option.textContent = sleeveType.name;
        if (oldValue == sleeveType.id) {
            option.selected = true;
        }
        select.appendChild(option);
    });
}

function populateCollectionTypeDropdown(collectionTypes) {
    const select = document.getElementById('collection_type_id');
    const oldValue = '{{ old("collection_type_id") }}';
    
    collectionTypes.forEach(collectionType => {
        const option = document.createElement('option');
        option.value = collectionType.id;
        option.textContent = collectionType.name;
        if (oldValue == collectionType.id) {
            option.selected = true;
        }
        select.appendChild(option);
    });
}
// Extra Images Preview & Remove Functionality
document.addEventListener('DOMContentLoaded', function() {
    function handleExtraImagesInput(input) {
        const previewContainer = input.closest('div').querySelector('.extra-images-preview');
        input.addEventListener('change', function() {
            // Clear previous previews
            previewContainer.innerHTML = '';
            const files = Array.from(input.files);
            files.forEach((file, idx) => {
                const reader = new FileReader();
                reader.onload = function(e) {
                    const wrapper = document.createElement('div');
                    wrapper.className = 'relative inline-block';
                    wrapper.style.maxWidth = '100px';
                    wrapper.style.maxHeight = '100px';
                    wrapper.style.marginRight = '8px';
                    const img = document.createElement('img');
                    img.src = e.target.result;
                    img.className = 'rounded border border-gray-300 dark:border-gray-600';
                    img.style.maxWidth = '100px';
                    img.style.maxHeight = '100px';
                    img.style.display = 'block';
                    const removeBtn = document.createElement('button');
                    removeBtn.type = 'button';
                    removeBtn.innerHTML = '❌';
                    removeBtn.title = 'Remove image';
                    removeBtn.className = 'absolute top-0 right-0 bg-white bg-opacity-80 rounded-full px-1 text-red-600 hover:bg-red-100';
                    removeBtn.style.position = 'absolute';
                    removeBtn.style.top = '2px';
                    removeBtn.style.right = '2px';
                    removeBtn.addEventListener('click', function() {
                        // Remove this image from preview and from input.files
                        files.splice(idx, 1);
                        // Create a new DataTransfer to update input.files
                        const dt = new DataTransfer();
                        files.forEach(f => dt.items.add(f));
                        input.files = dt.files;
                        // Re-render previews
                        input.dispatchEvent(new Event('change'));
                    });
                    wrapper.appendChild(img);
                    wrapper.appendChild(removeBtn);
                    previewContainer.appendChild(wrapper);
                };
                reader.readAsDataURL(file);
            });
        });
    }
    document.querySelectorAll('.extra-images-input').forEach(input => {
        handleExtraImagesInput(input);
    });
});
</script>
@endsection
