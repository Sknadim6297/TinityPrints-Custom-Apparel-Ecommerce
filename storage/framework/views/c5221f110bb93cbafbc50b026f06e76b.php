<?php $__env->startSection('content'); ?>
<div class="py-6 md:py-12">
    <div class="max-w-6xl mx-auto px-3 sm:px-6 lg:px-8">
        <div class="mb-6 md:mb-8">
            <h2 class="font-semibold text-2xl sm:text-3xl text-gray-800 dark:text-gray-200">Refund Management</h2>
            <p class="text-xs sm:text-sm text-gray-600 dark:text-gray-400 mt-2">
                Customer → Admin → Return → Refund completion workflow.
            </p>
        </div>

        <?php if(session('success')): ?>
            <div class="mb-6 p-4 rounded-lg bg-green-50 dark:bg-green-900/20 border border-green-200 dark:border-green-800 text-green-700 dark:text-green-300">
                <?php echo e(session('success')); ?>

            </div>
        <?php endif; ?>

        <?php if($errors->any()): ?>
            <div class="mb-6 p-4 rounded-lg bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800 text-red-700 dark:text-red-300">
                <?php echo e($errors->first()); ?>

            </div>
        <?php endif; ?>

        <?php if($refunds->count() === 0): ?>
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg p-6 border border-gray-100 dark:border-gray-700 text-gray-600 dark:text-gray-300">
                No refund requests found.
            </div>
        <?php else: ?>
            <div class="space-y-4">
                <?php $__currentLoopData = $refunds; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $refund): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg p-4 sm:p-6 border border-gray-100 dark:border-gray-700">
                        <div class="flex flex-col lg:flex-row lg:items-start gap-4">
                            <div class="lg:w-60">
                                <div class="p-4 rounded-lg bg-gray-50 dark:bg-gray-700/40 border border-gray-200 dark:border-gray-600">
                                    <p class="text-xs text-gray-500 dark:text-gray-400">Ticket ID</p>
                                    <p class="text-lg font-bold text-gray-900 dark:text-gray-100"><?php echo e($refund->ticket_id ?? ('RFD-#' . $refund->id)); ?></p>
                                    <p class="text-xs text-gray-500 dark:text-gray-400 mt-3">Status</p>
                                    <p class="text-sm font-semibold text-gray-900 dark:text-gray-100"><?php echo e(ucwords(str_replace('_', ' ', $refund->status))); ?></p>
                                </div>
                            </div>

                            <div class="flex-1 grid grid-cols-1 sm:grid-cols-2 gap-3">
                                <div>
                                    <p class="text-xs text-gray-500 dark:text-gray-400">Order</p>
                                    <p class="font-semibold text-gray-900 dark:text-gray-100"><?php echo e($refund->order?->order_number ?? 'N/A'); ?></p>
                                </div>
                                <div>
                                    <p class="text-xs text-gray-500 dark:text-gray-400">Customer</p>
                                    <p class="font-semibold text-gray-900 dark:text-gray-100"><?php echo e($refund->order?->customer_name ?? 'N/A'); ?></p>
                                </div>
                                <div>
                                    <p class="text-xs text-gray-500 dark:text-gray-400">Email</p>
                                    <p class="font-semibold text-gray-900 dark:text-gray-100"><?php echo e($refund->order?->email ?? 'N/A'); ?></p>
                                </div>
                                <div>
                                    <p class="text-xs text-gray-500 dark:text-gray-400">Order Status</p>
                                    <p class="font-semibold text-gray-900 dark:text-gray-100">
                                        <?php echo e($refund->order?->order_status ? ucwords(str_replace('_', ' ', $refund->order->order_status)) : 'N/A'); ?>

                                    </p>
                                </div>
                                <div>
                                    <p class="text-xs text-gray-500 dark:text-gray-400">Product Type</p>
                                    <p class="font-semibold text-gray-900 dark:text-gray-100"><?php echo e(ucwords($refund->product_type ?? 'normal')); ?></p>
                                </div>
                                <div>
                                    <p class="text-xs text-gray-500 dark:text-gray-400">Delivery Date</p>
                                    <p class="font-semibold text-gray-900 dark:text-gray-100"><?php echo e($refund->delivery_date ? $refund->delivery_date->format('M d, Y H:i') : 'N/A'); ?></p>
                                </div>
                                <div class="sm:col-span-2">
                                    <p class="text-xs text-gray-500 dark:text-gray-400">Refund Reason & Description</p>
                                    <p class="font-semibold text-gray-900 dark:text-gray-100"><?php echo e($refund->reason); ?></p>
                                    <?php if($refund->description): ?>
                                        <p class="text-sm text-gray-600 dark:text-gray-300 mt-1"><?php echo e($refund->description); ?></p>
                                    <?php endif; ?>
                                </div>
                                <div>
                                    <p class="text-xs text-gray-500 dark:text-gray-400">Evidence</p>
                                    <?php
                                        $evidencePath = $refund->evidence_path ?? $refund->proof_path;
                                    ?>
                                    <?php if($evidencePath): ?>
                                        <a href="<?php echo e(asset('storage/' . ltrim($evidencePath, '/'))); ?>" target="_blank" class="text-sm font-semibold text-blue-600 hover:text-blue-700">View Uploaded File</a>
                                    <?php else: ?>
                                        <p class="text-sm font-semibold text-gray-600 dark:text-gray-300">No evidence</p>
                                    <?php endif; ?>
                                </div>
                                <div>
                                    <p class="text-xs text-gray-500 dark:text-gray-400">Requested</p>
                                    <p class="font-semibold text-gray-900 dark:text-gray-100"><?php echo e($refund->created_at->format('M d, Y')); ?></p>
                                </div>
                                <div>
                                    <p class="text-xs text-gray-500 dark:text-gray-400">Return Mode</p>
                                    <p class="font-semibold text-gray-900 dark:text-gray-100"><?php echo e($refund->return_mode ? ucwords(str_replace('_', ' ', $refund->return_mode)) : 'N/A'); ?></p>
                                </div>
                                <div>
                                    <p class="text-xs text-gray-500 dark:text-gray-400">Refund Method</p>
                                    <p class="font-semibold text-gray-900 dark:text-gray-100"><?php echo e($refund->refund_method ? ucwords(str_replace('_', ' ', $refund->refund_method)) : 'N/A'); ?></p>
                                </div>
                                <div>
                                    <p class="text-xs text-gray-500 dark:text-gray-400">Refund Amount</p>
                                    <p class="font-semibold text-gray-900 dark:text-gray-100"><?php echo e($refund->refund_amount ? '₹' . number_format($refund->refund_amount, 2) : 'N/A'); ?></p>
                                </div>
                                <?php if($refund->admin_note): ?>
                                    <div class="sm:col-span-2">
                                        <p class="text-xs text-gray-500 dark:text-gray-400">Admin Note</p>
                                        <p class="font-semibold text-gray-900 dark:text-gray-100"><?php echo e($refund->admin_note); ?></p>
                                    </div>
                                <?php endif; ?>
                                <?php if($refund->customer_response): ?>
                                    <div class="sm:col-span-2">
                                        <p class="text-xs text-gray-500 dark:text-gray-400">Customer Response</p>
                                        <p class="font-semibold text-gray-900 dark:text-gray-100"><?php echo e($refund->customer_response); ?></p>
                                    </div>
                                <?php endif; ?>
                                <div>
                                    <p class="text-xs text-gray-500 dark:text-gray-400">Notified</p>
                                    <p class="font-semibold text-gray-900 dark:text-gray-100"><?php echo e($refund->notified_at ? $refund->notified_at->format('M d, Y H:i') : 'No'); ?></p>
                                </div>
                            </div>
                        </div>

                        <form method="POST" action="<?php echo e(route('admin.refunds.status', $refund)); ?>" class="mt-4 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-3">
                            <?php echo csrf_field(); ?>
                            <?php echo method_field('PATCH'); ?>
                            <div>
                                <label class="block text-xs font-semibold text-gray-600 dark:text-gray-300 mb-1">Stage Status</label>
                                <select name="status" class="w-full px-3 py-2 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100">
                                    <?php $__currentLoopData = ['refund_requested', 'under_review', 'refund_approved', 'refund_rejected', 'pending_customer_response', 'return_in_process', 'product_received', 'refund_completed']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $status): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($status); ?>" <?php echo e($refund->status === $status ? 'selected' : ''); ?>>
                                            <?php echo e(ucwords(str_replace('_', ' ', $status))); ?>

                                        </option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                            </div>
                            <div class="sm:col-span-2">
                                <label class="block text-xs font-semibold text-gray-600 dark:text-gray-300 mb-1">Admin Note (required for rejection / more info)</label>
                                <input type="text" name="admin_note" value="<?php echo e($refund->admin_note); ?>"
                                       class="w-full px-3 py-2 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100">
                            </div>
                            <div class="sm:col-span-2 lg:col-span-1 flex items-end">
                                <button type="submit" class="w-full px-4 py-2 bg-yellow-500 hover:bg-yellow-600 text-white rounded-lg font-semibold text-sm">
                                    Update Status
                                </button>
                            </div>
                        </form>

                        <div class="mt-4 grid grid-cols-1 lg:grid-cols-3 gap-3">
                            <form method="POST" action="<?php echo e(route('admin.refunds.approve', $refund)); ?>" class="p-3 rounded-lg border border-gray-200 dark:border-gray-600">
                                <?php echo csrf_field(); ?>
                                <?php echo method_field('PATCH'); ?>
                                <input type="text" name="admin_note" placeholder="Approval note (optional)" class="mb-2 w-full px-3 py-2 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 text-sm">
                                <button type="submit" class="w-full px-4 py-2 rounded-lg font-semibold text-sm border border-emerald-600 bg-emerald-600 hover:bg-emerald-700 text-white">
                                    Approve
                                </button>
                            </form>

                            <form method="POST" action="<?php echo e(route('admin.refunds.reject', $refund)); ?>" class="p-3 rounded-lg border border-gray-200 dark:border-gray-600">
                                <?php echo csrf_field(); ?>
                                <?php echo method_field('PATCH'); ?>
                                <input type="text" name="admin_note" required placeholder="Rejection reason" class="mb-2 w-full px-3 py-2 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 text-sm">
                                <button type="submit" class="w-full px-4 py-2 rounded-lg font-semibold text-sm border border-rose-600 bg-rose-600 hover:bg-rose-700 text-white">
                                    Reject
                                </button>
                            </form>

                            <form method="POST" action="<?php echo e(route('admin.refunds.status', $refund)); ?>" class="p-3 rounded-lg border border-gray-200 dark:border-gray-600">
                                <?php echo csrf_field(); ?>
                                <?php echo method_field('PATCH'); ?>
                                <input type="hidden" name="status" value="pending_customer_response">
                                <input type="text" name="admin_note" required placeholder="Ask customer for more info" class="mb-2 w-full px-3 py-2 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 text-sm">
                                <button type="submit" class="w-full px-4 py-2 rounded-lg font-semibold text-sm border border-indigo-600 bg-indigo-600 hover:bg-indigo-700 text-white">
                                    Ask More Info
                                </button>
                            </form>
                        </div>

                        <div class="mt-4 grid grid-cols-1 lg:grid-cols-3 gap-3">
                            <form method="POST" action="<?php echo e(route('admin.refunds.return-mode', $refund)); ?>" class="p-3 rounded-lg border border-gray-200 dark:border-gray-600">
                                <?php echo csrf_field(); ?>
                                <?php echo method_field('PATCH'); ?>
                                <select name="return_mode" class="mb-2 w-full px-3 py-2 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 text-sm" required>
                                    <option value="pickup_required">Pickup Required</option>
                                    <option value="self_return">Customer Self Return</option>
                                </select>
                                <button type="submit" class="w-full px-4 py-2 rounded-lg font-semibold text-sm border border-sky-600 bg-sky-600 hover:bg-sky-700 text-white">
                                    Start Return Process
                                </button>
                            </form>

                            <form method="POST" action="<?php echo e(route('admin.refunds.product-received', $refund)); ?>" class="p-3 rounded-lg border border-gray-200 dark:border-gray-600">
                                <?php echo csrf_field(); ?>
                                <?php echo method_field('PATCH'); ?>
                                <input type="text" name="admin_note" placeholder="Receipt note (optional)" class="mb-2 w-full px-3 py-2 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 text-sm">
                                <button type="submit" class="w-full px-4 py-2 rounded-lg font-semibold text-sm border border-purple-600 bg-purple-600 hover:bg-purple-700 text-white">
                                    Mark Product Received
                                </button>
                            </form>

                            <form method="POST" action="<?php echo e(route('admin.refunds.complete', $refund)); ?>" class="p-3 rounded-lg border border-gray-200 dark:border-gray-600">
                                <?php echo csrf_field(); ?>
                                <?php echo method_field('PATCH'); ?>
                                <select name="refund_method" class="mb-2 w-full px-3 py-2 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 text-sm" required>
                                    <option value="original_payment_gateway">Original Payment Gateway</option>
                                    <option value="wallet_refund">Wallet Refund</option>
                                    <option value="manual_transfer">Manual Transfer</option>
                                </select>
                                <input type="number" step="0.01" min="0" name="refund_amount" value="<?php echo e($refund->refund_amount ?? $refund->order?->total_amount); ?>" required class="mb-2 w-full px-3 py-2 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 text-sm" placeholder="Refund amount">
                                <input type="text" name="admin_note" placeholder="Completion note (optional)" class="mb-2 w-full px-3 py-2 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 text-sm">
                                <button type="submit" class="w-full px-4 py-2 rounded-lg font-semibold text-sm border border-blue-600 bg-blue-600 hover:bg-blue-700 text-white">
                                    Complete Refund
                                </button>
                            </form>
                        </div>

                        <div class="mt-3">
                            <form method="POST" action="<?php echo e(route('admin.refunds.notify', $refund)); ?>" class="w-full sm:w-auto">
                                <?php echo csrf_field(); ?>
                                <?php echo method_field('PATCH'); ?>
                                <button type="submit" class="px-4 py-2 rounded-lg font-semibold text-sm border border-slate-600 bg-slate-600 hover:bg-slate-700 text-white">
                                    Re-send Customer Notification
                                </button>
                            </form>
                        </div>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>

            <div class="mt-6">
                <?php echo e($refunds->links()); ?>

            </div>
        <?php endif; ?>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layouts.admin-app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\Tinnity_ecom\resources\views/admin/refunds/index.blade.php ENDPATH**/ ?>