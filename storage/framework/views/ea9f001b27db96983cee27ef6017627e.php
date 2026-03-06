

<?php $__env->startSection('content'); ?>
<div class="py-6 md:py-12">
    <div class="max-w-6xl mx-auto px-3 sm:px-6 lg:px-8">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 mb-6 md:mb-8">
            <div>
                <h2 class="font-semibold text-2xl sm:text-3xl text-gray-800 dark:text-gray-200">Notifications</h2>
                <p class="text-xs sm:text-sm text-gray-600 dark:text-gray-400 mt-2">
                    All admin alerts for orders, payments, designs, and refunds.
                </p>
            </div>
            <form method="POST" action="<?php echo e(route('admin.notifications.read-all')); ?>">
                <?php echo csrf_field(); ?>
                <?php echo method_field('PATCH'); ?>
                <button type="submit" class="px-4 py-2 bg-gray-700 hover:bg-gray-800 text-white rounded-lg font-semibold text-sm">
                    Mark All Read
                </button>
            </form>
        </div>

        <?php if(session('success')): ?>
            <div class="mb-6 p-4 rounded-lg bg-green-50 dark:bg-green-900/20 border border-green-200 dark:border-green-800 text-green-700 dark:text-green-300">
                <?php echo e(session('success')); ?>

            </div>
        <?php endif; ?>

        <?php if($notifications->count() === 0): ?>
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg p-6 border border-gray-100 dark:border-gray-700 text-gray-600 dark:text-gray-300">
                No notifications yet.
            </div>
        <?php else: ?>
            <div class="space-y-3">
                <?php $__currentLoopData = $notifications; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $notification): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <?php
                        $data = $notification->data;
                        $isUnread = is_null($notification->read_at);
                    ?>
                    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg p-4 border border-gray-100 dark:border-gray-700">
                        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
                            <div class="flex-1">
                                <div class="flex items-center gap-2">
                                    <h3 class="font-semibold text-gray-900 dark:text-gray-100">
                                        <?php echo e($data['title'] ?? 'Notification'); ?>

                                    </h3>
                                    <?php if($isUnread): ?>
                                        <span class="px-2 py-0.5 text-xs font-semibold rounded-full bg-yellow-100 text-yellow-800 dark:bg-yellow-900/30 dark:text-yellow-200">Unread</span>
                                    <?php endif; ?>
                                </div>
                                <p class="text-sm text-gray-700 dark:text-gray-300 mt-1">
                                    <?php echo e($data['message'] ?? ''); ?>

                                </p>
                                <p class="text-xs text-gray-500 dark:text-gray-400 mt-2">
                                    <?php echo e($notification->created_at->format('M d, Y h:i A')); ?>

                                </p>
                            </div>
                            <div class="flex flex-col sm:flex-row gap-2">
                                <?php if(!empty($data['action_url'])): ?>
                                    <a href="<?php echo e($data['action_url']); ?>" class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg font-semibold text-sm text-center">
                                        <?php echo e($data['action_text'] ?? 'View'); ?>

                                    </a>
                                <?php endif; ?>
                                <form method="POST" action="<?php echo e(route('admin.notifications.read', $notification->id)); ?>">
                                    <?php echo csrf_field(); ?>
                                    <?php echo method_field('PATCH'); ?>
                                    <button type="submit" class="px-4 py-2 bg-gray-600 hover:bg-gray-700 text-white rounded-lg font-semibold text-sm">
                                        Mark Read
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>

            <?php if(method_exists($notifications, 'links')): ?>
                <div class="mt-6">
                    <?php echo e($notifications->links()); ?>

                </div>
            <?php endif; ?>
        <?php endif; ?>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layouts.admin-app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\Tinnity_ecom\resources\views/admin/notifications/index.blade.php ENDPATH**/ ?>