

<?php $__env->startSection('content'); ?>
<div class="py-6 md:py-12">
    <div class="max-w-4xl mx-auto px-3 sm:px-6 lg:px-8">
        <!-- Page Header -->
        <div class="mb-6 md:mb-8">
            <a href="<?php echo e(route('admin.products.index')); ?>" class="inline-flex items-center text-yellow-600 dark:text-yellow-400 hover:text-yellow-700 dark:hover:text-yellow-300 mb-4">
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

        <form action="<?php echo e(route('admin.products.store')); ?>" method="POST" enctype="multipart/form-data" class="space-y-6">
            <?php echo csrf_field(); ?>

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
                               value="<?php echo e(old('name')); ?>"
                               required
                               class="w-full px-4 py-3 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:outline-none focus:ring-2 focus:ring-yellow-500 dark:focus:ring-yellow-400 transition-all duration-200"
                               placeholder="e.g., Classic White T-Shirt">
                        <?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <p class="mt-2 text-sm text-red-600 dark:text-red-400"><?php echo e($message); ?></p>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
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
                                  placeholder="Tell the story behind this product..."><?php echo e(old('description')); ?></textarea>
                        <?php $__errorArgs = ['description'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <p class="mt-2 text-sm text-red-600 dark:text-red-400"><?php echo e($message); ?></p>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>

                    <!-- Category -->
                    <div>
                        <label for="category" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                            Category *
                        </label>
                        <select id="category" 
                                name="category" 
                                required
                                class="w-full px-4 py-3 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:outline-none focus:ring-2 focus:ring-yellow-500 dark:focus:ring-yellow-400 transition-all duration-200">
                            <option value="">Select Category</option>
                            <option value="t-shirt" <?php echo e(old('category') == 't-shirt' ? 'selected' : ''); ?>>T-Shirt</option>
                            <option value="accessories" <?php echo e(old('category') == 'accessories' ? 'selected' : ''); ?>>Accessories</option>
                        </select>
                        <?php $__errorArgs = ['category'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <p class="mt-2 text-sm text-red-600 dark:text-red-400"><?php echo e($message); ?></p>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>

                    <!-- Sleeve Type -->
                    <div>
                        <label for="sleeve_type" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                            Sleeve Type *
                        </label>
                        <select id="sleeve_type" 
                                name="sleeve_type" 
                                required
                                class="w-full px-4 py-3 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:outline-none focus:ring-2 focus:ring-yellow-500 dark:focus:ring-yellow-400 transition-all duration-200">
                            <option value="">Select Sleeve Type</option>
                            <option value="full" <?php echo e(old('sleeve_type') == 'full' ? 'selected' : ''); ?>>Full Sleeve</option>
                            <option value="half" <?php echo e(old('sleeve_type') == 'half' ? 'selected' : ''); ?>>Half Sleeve</option>
                        </select>
                        <?php $__errorArgs = ['sleeve_type'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <p class="mt-2 text-sm text-red-600 dark:text-red-400"><?php echo e($message); ?></p>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>

                    <!-- Fit Type -->
                    <div>
                        <label for="fit_type" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                            Fit Type *
                        </label>
                        <select id="fit_type" 
                                name="fit_type" 
                                required
                                class="w-full px-4 py-3 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:outline-none focus:ring-2 focus:ring-yellow-500 dark:focus:ring-yellow-400 transition-all duration-200">
                            <option value="">Select Fit Type</option>
                            <option value="normal" <?php echo e(old('fit_type') == 'normal' ? 'selected' : ''); ?>>Normal</option>
                            <option value="slight_oversize" <?php echo e(old('fit_type') == 'slight_oversize' ? 'selected' : ''); ?>>Slight Oversize</option>
                        </select>
                        <?php $__errorArgs = ['fit_type'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <p class="mt-2 text-sm text-red-600 dark:text-red-400"><?php echo e($message); ?></p>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>

                    <!-- Base Price -->
                    <div>
                        <label for="base_price" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                            Base Price ($) *
                        </label>
                        <input id="base_price" 
                               type="number" 
                               name="base_price" 
                               value="<?php echo e(old('base_price')); ?>"
                               step="0.01"
                               min="0.01"
                               required
                               class="w-full px-4 py-3 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:outline-none focus:ring-2 focus:ring-yellow-500 dark:focus:ring-yellow-400 transition-all duration-200"
                               placeholder="29.99">
                        <?php $__errorArgs = ['base_price'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <p class="mt-2 text-sm text-red-600 dark:text-red-400"><?php echo e($message); ?></p>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>

                    <!-- Drop Month -->
                    <div>
                        <label for="drop_month" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                            Drop Month
                        </label>
                        <input id="drop_month" 
                               type="text" 
                               name="drop_month" 
                               value="<?php echo e(old('drop_month')); ?>"
                               class="w-full px-4 py-3 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:outline-none focus:ring-2 focus:ring-yellow-500 dark:focus:ring-yellow-400 transition-all duration-200"
                               placeholder="e.g., February 2026">
                        <?php $__errorArgs = ['drop_month'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <p class="mt-2 text-sm text-red-600 dark:text-red-400"><?php echo e($message); ?></p>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>

                    <!-- Limited Edition -->
                    <div class="flex items-center">
                        <input id="is_limited_edition" 
                               type="checkbox" 
                               name="is_limited_edition" 
                               value="1"
                               <?php echo e(old('is_limited_edition') ? 'checked' : ''); ?>

                               class="w-4 h-4 rounded border-gray-300 dark:border-gray-600 text-red-600 focus:ring-red-500 dark:focus:ring-red-400 dark:bg-gray-700">
                        <label for="is_limited_edition" class="ml-2 block text-sm font-medium text-gray-700 dark:text-gray-300">
                            Mark as Limited Edition
                        </label>
                    </div>

                    <!-- Limited Edition Drop Controls -->
                    <div id="drop_control_container" class="sm:col-span-2" style="display: <?php echo e(old('is_limited_edition') ? 'block' : 'none'); ?>">
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
                                           value="<?php echo e(old('drop_name')); ?>"
                                           class="w-full px-4 py-3 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:outline-none focus:ring-2 focus:ring-yellow-500 dark:focus:ring-yellow-400 transition-all duration-200"
                                           placeholder="e.g., Midnight Bloom">
                                    <?php $__errorArgs = ['drop_name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                        <p class="mt-2 text-sm text-red-600 dark:text-red-400"><?php echo e($message); ?></p>
                                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                </div>

                                <div class="sm:col-span-2">
                                    <label for="drop_story" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                                        Drop Story / Theme
                                    </label>
                                    <textarea id="drop_story"
                                              name="drop_story"
                                              rows="3"
                                              class="w-full px-4 py-3 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:outline-none focus:ring-2 focus:ring-yellow-500 dark:focus:ring-yellow-400 transition-all duration-200"
                                              placeholder="Short story or theme for this drop..."><?php echo e(old('drop_story')); ?></textarea>
                                    <?php $__errorArgs = ['drop_story'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                        <p class="mt-2 text-sm text-red-600 dark:text-red-400"><?php echo e($message); ?></p>
                                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                </div>

                                <div>
                                    <label for="drop_start_at" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                                        Drop Start Date
                                    </label>
                                    <input id="drop_start_at"
                                           type="datetime-local"
                                           name="drop_start_at"
                                           value="<?php echo e(old('drop_start_at')); ?>"
                                           class="w-full px-4 py-3 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:outline-none focus:ring-2 focus:ring-yellow-500 dark:focus:ring-yellow-400 transition-all duration-200">
                                    <?php $__errorArgs = ['drop_start_at'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                        <p class="mt-2 text-sm text-red-600 dark:text-red-400"><?php echo e($message); ?></p>
                                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                </div>

                                <div>
                                    <label for="drop_end_at" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                                        Drop End Date
                                    </label>
                                    <input id="drop_end_at"
                                           type="datetime-local"
                                           name="drop_end_at"
                                           value="<?php echo e(old('drop_end_at')); ?>"
                                           class="w-full px-4 py-3 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:outline-none focus:ring-2 focus:ring-yellow-500 dark:focus:ring-yellow-400 transition-all duration-200">
                                    <?php $__errorArgs = ['drop_end_at'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                        <p class="mt-2 text-sm text-red-600 dark:text-red-400"><?php echo e($message); ?></p>
                                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                </div>

                                <div>
                                    <label for="quantity_limit" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                                        Quantity Limit
                                    </label>
                                    <input id="quantity_limit"
                                           type="number"
                                           name="quantity_limit"
                                           value="<?php echo e(old('quantity_limit')); ?>"
                                           min="1"
                                           class="w-full px-4 py-3 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:outline-none focus:ring-2 focus:ring-yellow-500 dark:focus:ring-yellow-400 transition-all duration-200"
                                           placeholder="e.g., 500">
                                    <?php $__errorArgs = ['quantity_limit'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                        <p class="mt-2 text-sm text-red-600 dark:text-red-400"><?php echo e($message); ?></p>
                                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                </div>

                                <div class="flex items-center">
                                    <input id="countdown_enabled"
                                           type="checkbox"
                                           name="countdown_enabled"
                                           value="1"
                                           <?php echo e(old('countdown_enabled') ? 'checked' : ''); ?>

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
                                           <?php echo e(old('auto_hide_out_of_stock') ? 'checked' : ''); ?>

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
                    <?php $__currentLoopData = ['XS' => 'xs', 'S' => 's', 'M' => 'm', 'L' => 'l', 'XL' => 'xl', 'XXL' => 'xxl']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $label => $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="flex items-center gap-3 p-3 border-2 border-gray-200 dark:border-gray-600 rounded-lg hover:border-yellow-400 dark:hover:border-yellow-500 transition-colors duration-200 <?php echo e(in_array($value, old('sizes', [])) ? 'border-yellow-400 dark:border-yellow-500 bg-yellow-50 dark:bg-yellow-900/10' : ''); ?>">
                            <label class="flex items-center gap-2 cursor-pointer">
                                <input type="checkbox"
                                       name="sizes[]"
                                       value="<?php echo e($value); ?>"
                                       <?php echo e(in_array($value, old('sizes', [])) ? 'checked' : ''); ?>

                                       class="w-4 h-4 rounded border-gray-300 dark:border-gray-600 text-yellow-600 focus:ring-yellow-500 dark:focus:ring-yellow-400 dark:bg-gray-700">
                                <span class="font-semibold text-gray-700 dark:text-gray-300"><?php echo e($label); ?></span>
                            </label>
                            <div class="ml-auto flex items-center gap-2">
                                <label for="size_stock_<?php echo e($value); ?>" class="text-xs text-gray-600 dark:text-gray-400">Stock</label>
                                <input id="size_stock_<?php echo e($value); ?>"
                                       type="number"
                                       name="size_stocks[<?php echo e($value); ?>]"
                                       value="<?php echo e(old('size_stocks.' . $value, 0)); ?>"
                                       min="0"
                                       class="w-20 px-2 py-1 rounded-md border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:outline-none focus:ring-2 focus:ring-yellow-500 dark:focus:ring-yellow-400">
                            </div>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
                <?php $__errorArgs = ['sizes'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                    <p class="mt-2 text-sm text-red-600 dark:text-red-400"><?php echo e($message); ?></p>
                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                <?php $__errorArgs = ['size_stocks'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                    <p class="mt-2 text-sm text-red-600 dark:text-red-400"><?php echo e($message); ?></p>
                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
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
                                    Hex Code (Optional)
                                </label>
                                <input type="text" 
                                       name="colors[0][hex_code]" 
                                       class="w-full px-4 py-3 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:outline-none focus:ring-2 focus:ring-purple-500 dark:focus:ring-purple-400"
                                       placeholder="#FFFFFF">
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
                <?php $__errorArgs = ['colors'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                    <p class="mt-2 text-sm text-red-600 dark:text-red-400"><?php echo e($message); ?></p>
                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
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

                <a href="<?php echo e(route('admin.products.index')); ?>" 
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
    document.getElementById('add-color-btn').addEventListener('click', function() {
        const container = document.getElementById('colors-container');
        const template = container.firstElementChild.cloneNode(true);
        
        // Update all input names to use new index
        template.querySelectorAll('input').forEach(input => {
            const name = input.getAttribute('name');
            if (name) {
                const newName = name.replace(/\[\d+\]/, `[${colorIndex}]`);
                input.setAttribute('name', newName);
                input.value = '';
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
    });
});
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layouts.admin-app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\Tinnity_ecom\resources\views/admin/products/create.blade.php ENDPATH**/ ?>