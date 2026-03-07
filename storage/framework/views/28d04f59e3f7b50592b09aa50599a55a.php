

<?php $__env->startSection('content'); ?>
<div class="py-6 md:py-12">
    <div class="max-w-6xl mx-auto px-3 sm:px-6 lg:px-8">
        <!-- Page Header -->
        <div class="mb-6 md:mb-8 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 sm:gap-4">
            <div>
                <h2 class="font-semibold text-2xl sm:text-3xl text-gray-800 dark:text-gray-200">
                    Login History
                </h2>
                <p class="text-xs sm:text-sm text-gray-600 dark:text-gray-400 mt-1">
                    <?php echo e($customer->name); ?>

                </p>
            </div>
            <div class="flex gap-2">
                <a href="<?php echo e(route('admin.customers.show', $customer)); ?>" 
                   class="inline-flex items-center bg-gray-400 hover:bg-gray-500 text-white font-semibold py-2 px-4 rounded-lg transition-colors">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                    </svg>
                    Back
                </a>
                <a href="<?php echo e(route('admin.customers.index')); ?>" 
                   class="inline-flex items-center bg-gray-400 hover:bg-gray-500 text-white font-semibold py-2 px-4 rounded-lg transition-colors">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.856-1.487M15 10a3 3 0 11-6 0 3 3 0 016 0zM6 20a9 9 0 0118 0v2h2v-2a11 11 0 00-20 0v2h2z" />
                    </svg>
                    All Customers
                </a>
            </div>
        </div>

        <!-- Customer Info Cards -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
            <!-- Customer Name -->
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg border border-gray-100 dark:border-gray-700 p-4">
                <p class="text-xs text-gray-600 dark:text-gray-400 uppercase font-semibold mb-1">Customer</p>
                <p class="text-lg font-semibold text-gray-900 dark:text-gray-100"><?php echo e($customer->name); ?></p>
                <p class="text-xs text-gray-500 dark:text-gray-400 mt-2">
                    <a href="mailto:<?php echo e($customer->email); ?>" class="text-blue-600 dark:text-blue-400 hover:underline"><?php echo e($customer->email); ?></a>
                </p>
            </div>

            <!-- Total Logins -->
            <div class="bg-gradient-to-br from-blue-500 to-blue-600 rounded-xl shadow-lg p-4 text-white">
                <p class="text-xs opacity-90 uppercase font-semibold mb-1">Total Logins</p>
                <p class="text-3xl font-bold"><?php echo e($loginHistory->total()); ?></p>
            </div>

            <!-- Last Login -->
            <div class="bg-gradient-to-br from-green-500 to-green-600 rounded-xl shadow-lg p-4 text-white">
                <p class="text-xs opacity-90 uppercase font-semibold mb-1">Last Login</p>
                <?php if($loginHistory->isNotEmpty()): ?>
                    <p class="text-sm font-bold"><?php echo e($loginHistory->first()->login_time->diffForHumans()); ?></p>
                    <p class="text-xs opacity-75 mt-1"><?php echo e($loginHistory->first()->login_time->format('M d, Y h:i A')); ?></p>
                <?php else: ?>
                    <p class="text-sm font-bold">Never</p>
                <?php endif; ?>
            </div>

            <!-- Member Since -->
            <div class="bg-gradient-to-br from-purple-500 to-purple-600 rounded-xl shadow-lg p-4 text-white">
                <p class="text-xs opacity-90 uppercase font-semibold mb-1">Member Since</p>
                <p class="text-lg font-bold"><?php echo e($customer->created_at->format('M d, Y')); ?></p>
                <p class="text-xs opacity-75 mt-1"><?php echo e(now()->diffInDays($customer->created_at)); ?> days ago</p>
            </div>
        </div>

        <!-- Login History Table -->
        <?php if($loginHistory->count() > 0): ?>
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg border border-gray-100 dark:border-gray-700 overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead>
                            <tr class="bg-gray-50 dark:bg-gray-700 border-b border-gray-200 dark:border-gray-600">
                                <th class="px-4 sm:px-6 py-3 text-left text-xs sm:text-sm font-semibold text-gray-700 dark:text-gray-300">Login Time</th>
                                <th class="px-4 sm:px-6 py-3 text-left text-xs sm:text-sm font-semibold text-gray-700 dark:text-gray-300">Logout Time</th>
                                <th class="px-4 sm:px-6 py-3 text-left text-xs sm:text-sm font-semibold text-gray-700 dark:text-gray-300">Duration</th>
                                <th class="px-4 sm:px-6 py-3 text-left text-xs sm:text-sm font-semibold text-gray-700 dark:text-gray-300">IP Address</th>
                                <th class="px-4 sm:px-6 py-3 text-left text-xs sm:text-sm font-semibold text-gray-700 dark:text-gray-300">Device</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $__currentLoopData = $loginHistory; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $history): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr class="border-b border-gray-200 dark:border-gray-600 hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-colors">
                                    <td class="px-4 sm:px-6 py-4 text-sm">
                                        <p class="font-semibold text-gray-900 dark:text-gray-100"><?php echo e($history->login_time->format('M d, Y')); ?></p>
                                        <p class="text-xs text-gray-600 dark:text-gray-400"><?php echo e($history->login_time->format('h:i A')); ?></p>
                                        <p class="text-xs text-gray-500 dark:text-gray-500 mt-1"><?php echo e($history->login_time->diffForHumans()); ?></p>
                                    </td>
                                    <td class="px-4 sm:px-6 py-4 text-sm">
                                        <?php if($history->logout_time): ?>
                                            <p class="font-semibold text-gray-900 dark:text-gray-100"><?php echo e($history->logout_time->format('M d, Y')); ?></p>
                                            <p class="text-xs text-gray-600 dark:text-gray-400"><?php echo e($history->logout_time->format('h:i A')); ?></p>
                                            <p class="text-xs text-gray-500 dark:text-gray-500 mt-1"><?php echo e($history->logout_time->diffForHumans()); ?></p>
                                        <?php else: ?>
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 dark:bg-green-900/30 text-green-800 dark:text-green-400">
                                                Active Now
                                            </span>
                                        <?php endif; ?>
                                    </td>
                                    <td class="px-4 sm:px-6 py-4 text-sm">
                                        <?php if($history->login_time && $history->logout_time): ?>
                                            <?php
                                                $seconds = $history->logout_time->diffInSeconds($history->login_time);
                                                $hours = intdiv($seconds, 3600);
                                                $minutes = intdiv($seconds % 3600, 60);
                                                $secs = $seconds % 60;
                                            ?>
                                            <p class="font-medium text-gray-900 dark:text-gray-100">
                                                <?php if($hours > 0): ?>
                                                    <?php echo e($hours); ?>h <?php echo e($minutes); ?>m
                                                <?php else: ?>
                                                    <?php echo e($minutes); ?>m <?php echo e($secs); ?>s
                                                <?php endif; ?>
                                            </p>
                                        <?php else: ?>
                                            <p class="text-gray-500 dark:text-gray-500">—</p>
                                        <?php endif; ?>
                                    </td>
                                    <td class="px-4 sm:px-6 py-4 text-sm">
                                        <code class="px-2.5 py-1.5 rounded bg-gray-100 dark:bg-gray-700 text-gray-900 dark:text-gray-100 text-xs font-mono">
                                            <?php echo e($history->ip_address); ?>

                                        </code>
                                    </td>
                                    <td class="px-4 sm:px-6 py-4 text-sm">
                                        <?php if($history->device): ?>
                                            <p class="text-gray-900 dark:text-gray-100"><?php echo e($history->device); ?></p>
                                        <?php else: ?>
                                            <p class="text-gray-500 dark:text-gray-500">Not recorded</p>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                <?php if($loginHistory->hasPages()): ?>
                    <div class="border-t border-gray-200 dark:border-gray-600 px-4 sm:px-6 py-4">
                        <div class="flex justify-center">
                            <?php echo e($loginHistory->links('pagination::tailwind')); ?>

                        </div>
                    </div>
                <?php endif; ?>
            </div>
        <?php else: ?>
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg border border-gray-100 dark:border-gray-700 p-8 text-center">
                <svg class="w-12 h-12 mx-auto text-gray-400 dark:text-gray-500 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <h3 class="text-lg font-semibold text-gray-700 dark:text-gray-300 mb-2">No login history</h3>
                <p class="text-gray-600 dark:text-gray-400">This customer hasn't logged in yet or their login history has been cleared.</p>
            </div>
        <?php endif; ?>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layouts.admin-app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\Tinnity_ecom\resources\views\admin\customers\history.blade.php ENDPATH**/ ?>