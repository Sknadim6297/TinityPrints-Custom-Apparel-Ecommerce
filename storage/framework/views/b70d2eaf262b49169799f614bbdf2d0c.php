<?php $__env->startSection('content'); ?>
<div class="py-6 md:py-12">
    <div class="max-w-6xl mx-auto px-3 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="mb-6 flex items-center justify-between">
            <div>
                <h2 class="font-semibold text-2xl sm:text-3xl text-gray-800 dark:text-gray-200">Design Request Details</h2>
                <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">Request #<?php echo e($designRequest->id); ?></p>
            </div>
            <a href="<?php echo e(route('admin.design-approvals.index')); ?>" class="px-4 py-2 bg-gray-600 hover:bg-gray-700 text-white rounded-lg text-sm transition-colors">
                <i class="fal fa-arrow-left mr-2"></i>Back to Requests
            </a>
        </div>

        <?php if(session('success')): ?>
            <div class="mb-6 p-4 rounded-lg bg-green-50 dark:bg-green-900/20 border border-green-200 dark:border-green-800 text-green-700 dark:text-green-300">
                <?php echo e(session('success')); ?>

            </div>
        <?php endif; ?>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Left Column - Design Details -->
            <div class="lg:col-span-2 space-y-6">
                <!-- Status Card -->
                <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg p-6 border border-gray-100 dark:border-gray-700">
                    <h3 class="text-lg font-bold text-gray-900 dark:text-gray-100 mb-4">Request Status</h3>
                    <div class="flex flex-wrap gap-2">
                        <?php
                            $statusColors = [
                                'approved' => 'bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-300',
                                'pending' => 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900/30 dark:text-yellow-300',
                                'rejected' => 'bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-300',
                                'changes_requested' => 'bg-orange-100 text-orange-800 dark:bg-orange-900/30 dark:text-orange-300',
                            ];
                            $statusColor = $statusColors[$designRequest->status] ?? 'bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-300';
                        ?>
                        <span class="px-4 py-2 rounded-lg text-sm font-semibold <?php echo e($statusColor); ?>">
                            <?php echo e(ucwords(str_replace('_', ' ', $designRequest->status))); ?>

                        </span>
                        <?php if($designRequest->payment_unlocked): ?>
                            <span class="px-4 py-2 rounded-lg text-sm font-semibold bg-green-50 text-green-700 dark:bg-green-900/20 dark:text-green-400">
                                Payment Unlocked
                            </span>
                        <?php endif; ?>
                        <span class="px-4 py-2 rounded-lg text-sm text-gray-600 dark:text-gray-400">
                            <i class="fal fa-calendar mr-1"></i><?php echo e($designRequest->created_at->format('M d, Y \a\t h:i A')); ?>

                        </span>
                    </div>
                </div>

                <!-- Design Files Card -->
                <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg p-6 border border-gray-100 dark:border-gray-700">
                    <h3 class="text-lg font-bold text-gray-900 dark:text-gray-100 mb-4">
                        <i class="fal fa-images mr-2 text-purple-500"></i>Design Files
                    </h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <?php
                            $frontPath = $designRequest->front_design_file ?: $designRequest->design_file_path;
                            $backPath = $designRequest->back_design_file;
                            $frontExt = $frontPath ? strtolower(pathinfo($frontPath, PATHINFO_EXTENSION)) : null;
                            $backExt = $backPath ? strtolower(pathinfo($backPath, PATHINFO_EXTENSION)) : null;
                            $frontIsImage = in_array($frontExt, ['png', 'jpg', 'jpeg', 'webp']);
                            $backIsImage = in_array($backExt, ['png', 'jpg', 'jpeg', 'webp']);
                        ?>

                        <!-- Front Design -->
                        <div>
                            <p class="text-sm text-gray-600 dark:text-gray-400 mb-3 font-semibold">
                                Front Design <?php echo e($designRequest->front_label ? ': ' . $designRequest->front_label : ''); ?>

                            </p>
                            <?php if($frontPath): ?>
                                <?php if($frontIsImage): ?>
                                    <img src="<?php echo e(Storage::url($frontPath)); ?>" alt="Front Design" class="w-full h-64 object-contain bg-gray-100 dark:bg-gray-700 rounded-lg border-2 border-gray-200 dark:border-gray-600 p-2">
                                <?php else: ?>
                                    <div class="w-full h-64 flex items-center justify-center bg-gray-100 dark:bg-gray-700 rounded-lg border-2 border-gray-200 dark:border-gray-600">
                                        <div class="text-center">
                                            <i class="fal fa-file-alt text-5xl text-gray-400 mb-3"></i>
                                            <p class="text-sm font-semibold text-gray-600 dark:text-gray-300"><?php echo e(strtoupper($frontExt)); ?> File</p>
                                        </div>
                                    </div>
                                <?php endif; ?>
                                <a href="<?php echo e(route('admin.design-approvals.download', [$designRequest, 'front'])); ?>" 
                                   class="mt-3 w-full flex items-center justify-center gap-2 px-4 py-2 bg-yellow-500 hover:bg-yellow-600 text-white rounded-lg font-semibold text-sm transition-colors">
                                    <i class="fal fa-download"></i>
                                    Download Front Design
                                </a>
                            <?php else: ?>
                                <div class="w-full h-64 flex items-center justify-center bg-gray-50 dark:bg-gray-700/40 rounded-lg border-2 border-dashed border-gray-300 dark:border-gray-600">
                                    <p class="text-sm text-gray-500 dark:text-gray-400">No front design uploaded</p>
                                </div>
                            <?php endif; ?>
                        </div>

                        <!-- Back Design -->
                        <div>
                            <p class="text-sm text-gray-600 dark:text-gray-400 mb-3 font-semibold">
                                Back Design <?php echo e($designRequest->back_label ? ': ' . $designRequest->back_label : ''); ?>

                            </p>
                            <?php if($backPath): ?>
                                <?php if($backIsImage): ?>
                                    <img src="<?php echo e(Storage::url($backPath)); ?>" alt="Back Design" class="w-full h-64 object-contain bg-gray-100 dark:bg-gray-700 rounded-lg border-2 border-gray-200 dark:border-gray-600 p-2">
                                <?php else: ?>
                                    <div class="w-full h-64 flex items-center justify-center bg-gray-100 dark:bg-gray-700 rounded-lg border-2 border-gray-200 dark:border-gray-600">
                                        <div class="text-center">
                                            <i class="fal fa-file-alt text-5xl text-gray-400 mb-3"></i>
                                            <p class="text-sm font-semibold text-gray-600 dark:text-gray-300"><?php echo e(strtoupper($backExt)); ?> File</p>
                                        </div>
                                    </div>
                                <?php endif; ?>
                                <a href="<?php echo e(route('admin.design-approvals.download', [$designRequest, 'back'])); ?>" 
                                   class="mt-3 w-full flex items-center justify-center gap-2 px-4 py-2 bg-yellow-500 hover:bg-yellow-600 text-white rounded-lg font-semibold text-sm transition-colors">
                                    <i class="fal fa-download"></i>
                                    Download Back Design
                                </a>
                            <?php else: ?>
                                <div class="w-full h-64 flex items-center justify-center bg-gray-50 dark:bg-gray-700/40 rounded-lg border-2 border-dashed border-gray-300 dark:border-gray-600">
                                    <p class="text-sm text-gray-500 dark:text-gray-400">No back design uploaded</p>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>

                <!-- Design Specifications Card -->
                <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg p-6 border border-gray-100 dark:border-gray-700">
                    <h3 class="text-lg font-bold text-gray-900 dark:text-gray-100 mb-4">
                        <i class="fal fa-cog mr-2 text-blue-500"></i>Design Specifications
                    </h3>
                    <div class="grid grid-cols-2 md:grid-cols-3 gap-4">
                        <div>
                            <span class="text-sm text-gray-500 dark:text-gray-400">Size:</span>
                            <p class="font-semibold text-gray-900 dark:text-gray-100"><?php echo e($designRequest->selected_size); ?></p>
                        </div>
                        <?php if($designRequest->color): ?>
                            <div>
                                <span class="text-sm text-gray-500 dark:text-gray-400">Color:</span>
                                <p class="font-semibold text-gray-900 dark:text-gray-100"><?php echo e($designRequest->color); ?></p>
                            </div>
                        <?php endif; ?>
                        <?php if($designRequest->sleeve_type): ?>
                            <div>
                                <span class="text-sm text-gray-500 dark:text-gray-400">Sleeve Type:</span>
                                <p class="font-semibold text-gray-900 dark:text-gray-100"><?php echo e(ucwords($designRequest->sleeve_type)); ?></p>
                            </div>
                        <?php endif; ?>
                        <?php if($designRequest->file_format): ?>
                            <div>
                                <span class="text-sm text-gray-500 dark:text-gray-400">File Format:</span>
                                <p class="font-semibold text-gray-900 dark:text-gray-100"><?php echo e(strtoupper($designRequest->file_format)); ?></p>
                            </div>
                        <?php endif; ?>
                        <?php if($designRequest->dpi): ?>
                            <div>
                                <span class="text-sm text-gray-500 dark:text-gray-400">DPI:</span>
                                <p class="font-semibold text-gray-900 dark:text-gray-100"><?php echo e($designRequest->dpi); ?></p>
                            </div>
                        <?php endif; ?>
                        <?php if($designRequest->print_width && $designRequest->print_height): ?>
                            <div>
                                <span class="text-sm text-gray-500 dark:text-gray-400">Print Dimensions:</span>
                                <p class="font-semibold text-gray-900 dark:text-gray-100">
                                    <?php echo e($designRequest->print_width); ?> × <?php echo e($designRequest->print_height); ?> <?php echo e($designRequest->print_unit ?? 'px'); ?>

                                </p>
                            </div>
                        <?php endif; ?>
                    </div>

                    <?php if($designRequest->notes): ?>
                        <div class="mt-4 pt-4 border-t border-gray-200 dark:border-gray-700">
                            <p class="text-sm text-gray-500 dark:text-gray-400 mb-2">Customer Notes:</p>
                            <p class="text-gray-900 dark:text-gray-100 leading-relaxed"><?php echo e($designRequest->notes); ?></p>
                        </div>
                    <?php endif; ?>

                    <?php if($designRequest->admin_remark): ?>
                        <div class="mt-4 p-4 bg-blue-50 dark:bg-blue-900/20 rounded-lg border border-blue-200 dark:border-blue-800">
                            <p class="text-sm text-gray-600 dark:text-gray-400 mb-2 font-semibold">Admin Remarks:</p>
                            <p class="text-gray-900 dark:text-gray-100"><?php echo e($designRequest->admin_remark); ?></p>
                        </div>
                    <?php endif; ?>

                    <?php if($designRequest->price): ?>
                        <div class="mt-4 pt-4 border-t border-gray-200 dark:border-gray-700">
                            <div class="flex justify-between items-center">
                                <span class="text-lg font-semibold text-gray-700 dark:text-gray-300">Approved Price:</span>
                                <span class="text-2xl font-bold text-green-600 dark:text-green-400">₹<?php echo e(number_format($designRequest->price, 2)); ?></span>
                            </div>
                        </div>
                    <?php endif; ?>
                </div>

                <!-- Approval Actions Card -->
                <?php if($designRequest->status === 'pending' || $designRequest->status === 'changes_requested'): ?>
                    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg p-6 border border-gray-100 dark:border-gray-700">
                        <h3 class="text-lg font-bold text-gray-900 dark:text-gray-100 mb-4">
                            <i class="fal fa-check-circle mr-2 text-green-500"></i>Review Actions
                        </h3>
                        <div class="space-y-4">
                            <!-- Approve Form -->
                            <form method="POST" action="<?php echo e(route('admin.design-approvals.approve', $designRequest)); ?>" class="p-4 bg-green-50 dark:bg-green-900/20 rounded-lg border border-green-200 dark:border-green-800">
                                <?php echo csrf_field(); ?>
                                <h4 class="font-semibold text-green-800 dark:text-green-300 mb-3">Approve Design</h4>
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                                    <div>
                                        <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Price (₹) *</label>
                                        <input type="number" name="price" step="0.01" min="1" required
                                               class="w-full px-3 py-2 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100">
                                    </div>
                                    <div>
                                        <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Remarks (Optional)</label>
                                        <input type="text" name="remarks"
                                               class="w-full px-3 py-2 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100">
                                    </div>
                                </div>
                                <button type="submit" class="mt-3 w-full px-6 py-2.5 bg-green-600 hover:bg-green-700 text-white rounded-lg font-semibold transition-colors">
                                    <i class="fal fa-check mr-2"></i>Approve & Unlock Payment
                                </button>
                            </form>

                            <!-- Request Changes Form -->
                            <form method="POST" action="<?php echo e(route('admin.design-approvals.request-changes', $designRequest)); ?>" class="p-4 bg-orange-50 dark:bg-orange-900/20 rounded-lg border border-orange-200 dark:border-orange-800">
                                <?php echo csrf_field(); ?>
                                <h4 class="font-semibold text-orange-800 dark:text-orange-300 mb-3">Request Changes</h4>
                                <div>
                                    <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Requested Changes *</label>
                                    <textarea name="remarks" rows="3" required
                                              class="w-full px-3 py-2 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100"></textarea>
                                </div>
                                <button type="submit" class="mt-3 w-full px-6 py-2.5 bg-orange-600 hover:bg-orange-700 text-white rounded-lg font-semibold transition-colors">
                                    <i class="fal fa-edit mr-2"></i>Request Changes
                                </button>
                            </form>

                            <!-- Reject Form -->
                            <form method="POST" action="<?php echo e(route('admin.design-approvals.reject', $designRequest)); ?>" class="p-4 bg-red-50 dark:bg-red-900/20 rounded-lg border border-red-200 dark:border-red-800">
                                <?php echo csrf_field(); ?>
                                <h4 class="font-semibold text-red-800 dark:text-red-300 mb-3">Reject Design</h4>
                                <div>
                                    <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Rejection Reason *</label>
                                    <textarea name="remarks" rows="3" required
                                              class="w-full px-3 py-2 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100"></textarea>
                                </div>
                                <button type="submit" class="mt-3 w-full px-6 py-2.5 bg-red-600 hover:bg-red-700 text-white rounded-lg font-semibold transition-colors">
                                    <i class="fal fa-times mr-2"></i>Reject Design
                                </button>
                            </form>
                        </div>
                    </div>
                <?php endif; ?>
            </div>

            <!-- Right Column - Customer Info -->
            <div class="space-y-6">
                <!-- Customer Details Card -->
                <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg p-6 border border-gray-100 dark:border-gray-700">
                    <h3 class="text-lg font-bold text-gray-900 dark:text-gray-100 mb-4">
                        <i class="fal fa-user mr-2 text-blue-500"></i>Customer Details
                    </h3>
                    <div class="space-y-3">
                        <div>
                            <span class="text-sm text-gray-500 dark:text-gray-400">Name:</span>
                            <p class="font-semibold text-gray-900 dark:text-gray-100"><?php echo e($designRequest->customer_name); ?></p>
                        </div>
                        <div>
                            <span class="text-sm text-gray-500 dark:text-gray-400">Phone:</span>
                            <p class="font-semibold text-gray-900 dark:text-gray-100"><?php echo e($designRequest->phone); ?></p>
                        </div>
                        <div>
                            <span class="text-sm text-gray-500 dark:text-gray-400">Email:</span>
                            <p class="font-semibold text-gray-900 dark:text-gray-100"><?php echo e($designRequest->email); ?></p>
                        </div>
                    </div>
                </div>

                <!-- Review History Card -->
                <?php if($designRequest->reviewed_by): ?>
                    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg p-6 border border-gray-100 dark:border-gray-700">
                        <h3 class="text-lg font-bold text-gray-900 dark:text-gray-100 mb-4">
                            <i class="fal fa-history mr-2 text-purple-500"></i>Review History
                        </h3>
                        <div class="space-y-3">
                            <div>
                                <span class="text-sm text-gray-500 dark:text-gray-400">Reviewed By:</span>
                                <p class="font-semibold text-gray-900 dark:text-gray-100">
                                    <?php echo e($designRequest->admin ? $designRequest->admin->name : 'Unknown Admin'); ?>

                                </p>
                            </div>
                            <?php if($designRequest->reviewed_at): ?>
                                <div>
                                    <span class="text-sm text-gray-500 dark:text-gray-400">Reviewed At:</span>
                                    <p class="font-semibold text-gray-900 dark:text-gray-100">
                                        <?php echo e($designRequest->reviewed_at->format('M d, Y \a\t h:i A')); ?>

                                    </p>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                <?php endif; ?>

                <!-- Related Order Card -->
                <?php if($designRequest->order): ?>
                    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg p-6 border border-gray-100 dark:border-gray-700">
                        <h3 class="text-lg font-bold text-gray-900 dark:text-gray-100 mb-4">
                            <i class="fal fa-shopping-cart mr-2 text-green-500"></i>Related Order
                        </h3>
                        <div class="space-y-3">
                            <div>
                                <span class="text-sm text-gray-500 dark:text-gray-400">Order Number:</span>
                                <p class="font-semibold text-gray-900 dark:text-gray-100">#<?php echo e($designRequest->order->order_number); ?></p>
                            </div>
                            <a href="<?php echo e(route('admin.orders.show', $designRequest->order)); ?>" 
                               class="inline-flex items-center gap-2 text-blue-600 hover:text-blue-800 dark:text-blue-400 dark:hover:text-blue-300 font-semibold">
                                <i class="fal fa-external-link"></i>
                                View Order Details
                            </a>
                        </div>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layouts.admin-app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\Tinnity_ecom\resources\views\admin\design-approvals\show.blade.php ENDPATH**/ ?>