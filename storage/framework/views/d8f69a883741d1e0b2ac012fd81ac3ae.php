

<?php $__env->startSection('content'); ?>
<div class="py-6 md:py-12">
    <div class="max-w-5xl mx-auto px-3 sm:px-6 lg:px-8">
        <!-- Page Header -->
        <div class="mb-6 md:mb-8 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 sm:gap-4">
            <div>
                <a href="<?php echo e(route('admin.products.index')); ?>" class="inline-flex items-center text-yellow-600 dark:text-yellow-400 hover:text-yellow-700 dark:hover:text-yellow-300 mb-2">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                    </svg>
                    Back to Products
                </a>
                <h2 class="font-semibold text-2xl sm:text-3xl text-gray-800 dark:text-gray-200">
                    <?php echo e($product->name); ?>

                </h2>
            </div>
            <div class="flex gap-2 sm:gap-3">
                <a href="<?php echo e(route('admin.products.edit', $product)); ?>" 
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
                            <p class="font-semibold text-gray-900 dark:text-gray-100 mt-1"><?php echo e(ucfirst($product->category)); ?></p>
                        </div>
                        <div>
                            <p class="text-xs sm:text-sm text-gray-600 dark:text-gray-400">Price</p>
                            <p class="font-semibold text-gray-900 dark:text-gray-100 text-lg mt-1">$<?php echo e(number_format($product->base_price, 2)); ?></p>
                        </div>
                        <div>
                            <p class="text-xs sm:text-sm text-gray-600 dark:text-gray-400">Sleeve Type</p>
                            <p class="font-semibold text-gray-900 dark:text-gray-100 mt-1"><?php echo e(ucfirst(str_replace('_', ' ', $product->sleeve_type))); ?></p>
                        </div>
                        <div>
                            <p class="text-xs sm:text-sm text-gray-600 dark:text-gray-400">Fit Type</p>
                            <p class="font-semibold text-gray-900 dark:text-gray-100 mt-1"><?php echo e(ucfirst(str_replace('_', ' ', $product->fit_type))); ?></p>
                        </div>
                        <div>
                            <p class="text-xs sm:text-sm text-gray-600 dark:text-gray-400">Edition Type</p>
                            <div class="mt-1">
                                <?php if($product->is_limited_edition): ?>
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-200">
                                        Limited Edition
                                    </span>
                                <?php else: ?>
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-300">
                                        Regular
                                    </span>
                                <?php endif; ?>
                            </div>
                        </div>
                        <?php if($product->drop_month): ?>
                            <div>
                                <p class="text-xs sm:text-sm text-gray-600 dark:text-gray-400">Drop Month</p>
                                <p class="font-semibold text-gray-900 dark:text-gray-100 mt-1"><?php echo e($product->drop_month); ?></p>
                            </div>
                        <?php endif; ?>
                        <?php if($product->drop_name): ?>
                            <div>
                                <p class="text-xs sm:text-sm text-gray-600 dark:text-gray-400">Drop Name</p>
                                <p class="font-semibold text-gray-900 dark:text-gray-100 mt-1"><?php echo e($product->drop_name); ?></p>
                            </div>
                        <?php endif; ?>
                        <?php if($product->drop_start_at): ?>
                            <div>
                                <p class="text-xs sm:text-sm text-gray-600 dark:text-gray-400">Drop Start Date</p>
                                <p class="font-semibold text-gray-900 dark:text-gray-100 mt-1"><?php echo e($product->drop_start_at->format('M d, Y H:i')); ?></p>
                            </div>
                        <?php endif; ?>
                        <?php if($product->drop_end_at): ?>
                            <div>
                                <p class="text-xs sm:text-sm text-gray-600 dark:text-gray-400">Drop End Date</p>
                                <p class="font-semibold text-gray-900 dark:text-gray-100 mt-1"><?php echo e($product->drop_end_at->format('M d, Y H:i')); ?></p>
                            </div>
                        <?php endif; ?>
                        <?php if($product->quantity_limit): ?>
                            <div>
                                <p class="text-xs sm:text-sm text-gray-600 dark:text-gray-400">Quantity Limit</p>
                                <p class="font-semibold text-gray-900 dark:text-gray-100 mt-1"><?php echo e($product->quantity_limit); ?></p>
                            </div>
                        <?php endif; ?>
                    </div>

                    <?php if($product->description): ?>
                        <div class="mt-4 sm:mt-6 pt-4 sm:pt-6 border-t border-gray-200 dark:border-gray-700">
                            <p class="text-xs sm:text-sm text-gray-600 dark:text-gray-400">Product Story</p>
                            <p class="text-gray-900 dark:text-gray-100 mt-2 leading-relaxed"><?php echo e($product->description); ?></p>
                        </div>
                    <?php endif; ?>

                    <?php if($product->is_limited_edition && $product->drop_story): ?>
                        <div class="mt-4 sm:mt-6 pt-4 sm:pt-6 border-t border-gray-200 dark:border-gray-700">
                            <p class="text-xs sm:text-sm text-gray-600 dark:text-gray-400">Drop Story / Theme</p>
                            <p class="text-gray-900 dark:text-gray-100 mt-2 leading-relaxed"><?php echo e($product->drop_story); ?></p>
                        </div>
                    <?php endif; ?>
                </div>

                <!-- Available Sizes -->
                <div class="bg-white dark:bg-gray-800 rounded-xl sm:rounded-2xl shadow-lg p-4 sm:p-6 border border-gray-100 dark:border-gray-700">
                    <h3 class="text-lg font-bold text-gray-800 dark:text-gray-200 mb-4">Available Sizes</h3>
                    
                    <div class="grid grid-cols-3 sm:grid-cols-4 gap-2 sm:gap-3">
                        <?php $__currentLoopData = $product->sizes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $size): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <div class="bg-gradient-to-br from-yellow-50 to-red-50 dark:from-gray-700 dark:to-gray-700 p-2 sm:p-3 rounded-lg text-center border border-gray-200 dark:border-gray-600">
                                <p class="font-bold text-gray-800 dark:text-gray-200"><?php echo e(strtoupper($size->size)); ?></p>
                                <p class="text-xs text-gray-600 dark:text-gray-400 mt-1"><?php echo e($size->stock_quantity); ?> in stock</p>
                            </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                </div>

                <!-- Colors Section -->
                <div class="bg-white dark:bg-gray-800 rounded-xl sm:rounded-2xl shadow-lg p-4 sm:p-6 border border-gray-100 dark:border-gray-700">
                    <h3 class="text-lg font-bold text-gray-800 dark:text-gray-200 mb-4">Product Colors</h3>
                    
                    <?php if($product->colors->count() > 0): ?>
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 sm:gap-6">
                            <?php $__currentLoopData = $product->colors; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $color): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <div class="border border-gray-200 dark:border-gray-600 rounded-lg p-4 hover:shadow-lg transition-shadow duration-200">
                                    <div class="flex items-start justify-between mb-3">
                                        <div>
                                            <p class="font-semibold text-gray-900 dark:text-gray-100"><?php echo e($color->color_name); ?></p>
                                            <?php if($color->hex_code): ?>
                                                <div class="flex items-center gap-2 mt-2">
                                                    <div class="w-6 h-6 rounded border border-gray-300" style="background-color: <?php echo e($color->hex_code); ?>"></div>
                                                    <p class="text-xs text-gray-600 dark:text-gray-400"><?php echo e($color->hex_code); ?></p>
                                                </div>
                                            <?php endif; ?>
                                        </div>
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium <?php echo e($color->is_active ? 'bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-200' : 'bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-300'); ?>">
                                            <?php echo e($color->is_active ? 'Active' : 'Inactive'); ?>

                                        </span>
                                    </div>

                                    <!-- Color Images -->
                                    <?php if($color->images->count() > 0): ?>
                                        <div class="grid grid-cols-2 gap-2 mt-4">
                                            <?php $__currentLoopData = $color->images; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $image): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <div>
                                                    <p class="text-xs text-gray-600 dark:text-gray-400 mb-2 font-medium"><?php echo e(ucfirst($image->image_type)); ?> View</p>
                                                    <img src="<?php echo e(Storage::url($image->image_path)); ?>" 
                                                         alt="<?php echo e($color->color_name); ?> <?php echo e($image->image_type); ?>"
                                                         class="w-full h-32 object-cover rounded-lg border border-gray-200 dark:border-gray-600">
                                                </div>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </div>
                    <?php else: ?>
                        <p class="text-gray-600 dark:text-gray-400">No colors added yet.</p>
                    <?php endif; ?>
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
                            <p class="font-mono text-sm text-gray-900 dark:text-gray-100 mt-1">#<?php echo e($product->id); ?></p>
                        </div>
                        <div>
                            <p class="text-xs text-gray-600 dark:text-gray-400">Created By</p>
                            <p class="text-sm text-gray-900 dark:text-gray-100 mt-1"><?php echo e($product->admin?->name ?? 'System'); ?></p>
                        </div>
                        <div>
                            <p class="text-xs text-gray-600 dark:text-gray-400">Created At</p>
                            <p class="text-sm text-gray-900 dark:text-gray-100 mt-1"><?php echo e($product->created_at->format('M d, Y H:i')); ?></p>
                        </div>
                        <div>
                            <p class="text-xs text-gray-600 dark:text-gray-400">Last Updated</p>
                            <p class="text-sm text-gray-900 dark:text-gray-100 mt-1"><?php echo e($product->updated_at->format('M d, Y H:i')); ?></p>
                        </div>
                    </div>
                </div>

                <!-- Stats Card -->
                <div class="bg-gradient-to-br from-yellow-50 to-red-50 dark:from-gray-700 dark:to-gray-700 rounded-xl sm:rounded-2xl shadow-lg p-4 sm:p-6 border border-yellow-200 dark:border-gray-600">
                    <h3 class="text-lg font-bold text-gray-800 dark:text-gray-200 mb-4">Quick Stats</h3>
                    
                    <div class="space-y-3">
                        <div class="flex justify-between items-center">
                            <p class="text-sm text-gray-600 dark:text-gray-400">Total Colors</p>
                            <p class="text-2xl font-bold text-gray-900 dark:text-gray-100"><?php echo e($product->colors->count()); ?></p>
                        </div>
                        <div class="flex justify-between items-center">
                            <p class="text-sm text-gray-600 dark:text-gray-400">Available Sizes</p>
                            <p class="text-2xl font-bold text-gray-900 dark:text-gray-100"><?php echo e($product->sizes->count()); ?></p>
                        </div>
                        <?php if($product->is_limited_edition && $product->stock_limit): ?>
                            <div class="flex justify-between items-center pt-3 border-t border-yellow-200 dark:border-gray-600">
                                <p class="text-sm text-gray-600 dark:text-gray-400">Stock Limit</p>
                                <p class="text-2xl font-bold text-red-600 dark:text-red-400"><?php echo e($product->stock_limit); ?></p>
                            </div>
                        <?php endif; ?>
                        <?php if($product->is_limited_edition && $product->quantity_limit): ?>
                            <div class="flex justify-between items-center pt-3 border-t border-yellow-200 dark:border-gray-600">
                                <p class="text-sm text-gray-600 dark:text-gray-400">Quantity Limit</p>
                                <p class="text-2xl font-bold text-red-600 dark:text-red-400"><?php echo e($product->quantity_limit); ?></p>
                            </div>
                        <?php endif; ?>
                        <?php if($product->is_limited_edition): ?>
                            <div class="flex justify-between items-center pt-3 border-t border-yellow-200 dark:border-gray-600">
                                <p class="text-sm text-gray-600 dark:text-gray-400">Countdown Timer</p>
                                <p class="text-sm font-semibold <?php echo e($product->countdown_enabled ? 'text-green-600 dark:text-green-400' : 'text-gray-600 dark:text-gray-400'); ?>">
                                    <?php echo e($product->countdown_enabled ? 'Enabled' : 'Disabled'); ?>

                                </p>
                            </div>
                            <div class="flex justify-between items-center pt-3 border-t border-yellow-200 dark:border-gray-600">
                                <p class="text-sm text-gray-600 dark:text-gray-400">Auto Hide (Stock = 0)</p>
                                <p class="text-sm font-semibold <?php echo e($product->auto_hide_out_of_stock ? 'text-green-600 dark:text-green-400' : 'text-gray-600 dark:text-gray-400'); ?>">
                                    <?php echo e($product->auto_hide_out_of_stock ? 'Enabled' : 'Disabled'); ?>

                                </p>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>

                <!-- Actions -->
                <div class="flex flex-col gap-3">
                    <form action="<?php echo e(route('admin.products.destroy', $product)); ?>" method="POST" onsubmit="return confirm('Are you sure?')">
                        <?php echo csrf_field(); ?>
                        <?php echo method_field('DELETE'); ?>
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
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layouts.admin-app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\Tinnity_ecom\resources\views/admin/products/show.blade.php ENDPATH**/ ?>