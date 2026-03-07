    

<?php $__env->startSection('content'); ?>
<div class="py-6 md:py-12">
    <div class="max-w-6xl mx-auto px-3 sm:px-6 lg:px-8">
        <!-- Page Header -->
        <div class="mb-6 md:mb-8 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 sm:gap-4">
            <div>
                <h2 class="font-semibold text-2xl sm:text-3xl text-gray-800 dark:text-gray-200">
                    Admin Login History
                </h2>
                <p class="text-xs sm:text-sm text-gray-600 dark:text-gray-400 mt-1">
                    Track and monitor admin access logs
                </p>
            </div>
        </div>

        <?php if(session('success')): ?>
            <div class="mb-6 p-4 rounded-lg bg-green-50 dark:bg-green-900/20 border border-green-200 dark:border-green-800 text-green-700 dark:text-green-300">
                <?php echo e(session('success')); ?>

            </div>
        <?php endif; ?>

        <!-- Search Box -->
        <div class="mb-6 bg-white dark:bg-gray-800 rounded-xl shadow-lg p-4 sm:p-6 border border-gray-100 dark:border-gray-700">
            <form method="GET" action="<?php echo e(route('admin.login-history.index')); ?>" class="flex flex-col sm:flex-row gap-3">
                <div class="flex-1">
                    <input 
                        type="text" 
                        name="search" 
                        placeholder="Search by name, email, or IP address..."
                        value="<?php echo e($search ?? ''); ?>"
                        class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 placeholder-gray-500 dark:placeholder-gray-400 text-sm"
                    >
                </div>
                <button type="submit" class="px-4 py-2 bg-blue-500 hover:bg-blue-600 text-white rounded-lg transition-colors text-sm font-medium whitespace-nowrap">
                    <svg class="w-5 h-5 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                    Search
                </button>
                <?php if($search): ?>
                    <a href="<?php echo e(route('admin.login-history.index')); ?>" class="px-4 py-2 bg-gray-300 hover:bg-gray-400 dark:bg-gray-600 dark:hover:bg-gray-700 text-gray-800 dark:text-gray-100 rounded-lg transition-colors text-sm font-medium whitespace-nowrap">
                        Clear
                    </a>
                <?php endif; ?>
            </form>
        </div>

        <?php if($histories->count() > 0): ?>
            <!-- Login History Table -->
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg border border-gray-100 dark:border-gray-700 overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead>
                            <tr class="bg-gray-50 dark:bg-gray-700 border-b border-gray-200 dark:border-gray-600">
                                <th class="px-4 sm:px-6 py-3 text-left text-xs sm:text-sm font-semibold text-gray-700 dark:text-gray-300">User</th>
                                <th class="px-4 sm:px-6 py-3 text-left text-xs sm:text-sm font-semibold text-gray-700 dark:text-gray-300">IP Address</th>
                                <th class="px-4 sm:px-6 py-3 text-left text-xs sm:text-sm font-semibold text-gray-700 dark:text-gray-300">Device</th>
                                <th class="px-4 sm:px-6 py-3 text-left text-xs sm:text-sm font-semibold text-gray-700 dark:text-gray-300">Login Time</th>
                                <th class="px-4 sm:px-6 py-3 text-left text-xs sm:text-sm font-semibold text-gray-700 dark:text-gray-300">Logout Time</th>
                                <th class="px-4 sm:px-6 py-3 text-left text-xs sm:text-sm font-semibold text-gray-700 dark:text-gray-300">Duration</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $__currentLoopData = $histories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $h): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr class="border-b border-gray-200 dark:border-gray-600 hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-colors">
                                    <td class="px-4 sm:px-6 py-4 text-sm">
                                        <?php if($h->user): ?>
                                            <a href="<?php echo e(route('admin.customers.show', $h->user)); ?>" class="text-blue-600 dark:text-blue-400 hover:underline font-medium">
                                                <?php echo e($h->user->name); ?>

                                            </a>
                                            <p class="text-xs text-gray-600 dark:text-gray-400 mt-1"><?php echo e($h->user->email); ?></p>
                                        <?php else: ?>
                                            <span class="text-gray-500 dark:text-gray-500 italic">User deleted</span>
                                        <?php endif; ?>
                                    </td>
                                    <td class="px-4 sm:px-6 py-4 text-sm">
                                        <code class="px-2.5 py-1.5 rounded bg-gray-100 dark:bg-gray-700 text-gray-900 dark:text-gray-100 text-xs font-mono">
                                            <?php echo e($h->ip_address); ?>

                                        </code>
                                    </td>
                                    <td class="px-4 sm:px-6 py-4 text-sm text-gray-700 dark:text-gray-300">
                                        <?php echo e($h->device ?? '—'); ?>

                                    </td>
                                    <td class="px-4 sm:px-6 py-4 text-sm">
                                        <p class="font-semibold text-gray-900 dark:text-gray-100"><?php echo e($h->login_time?->format('M d, Y')); ?></p>
                                        <p class="text-xs text-gray-600 dark:text-gray-400"><?php echo e($h->login_time?->format('h:i A')); ?></p>
                                    </td>
                                    <td class="px-4 sm:px-6 py-4 text-sm">
                                        <?php if($h->logout_time): ?>
                                            <p class="font-semibold text-gray-900 dark:text-gray-100"><?php echo e($h->logout_time?->format('M d, Y')); ?></p>
                                            <p class="text-xs text-gray-600 dark:text-gray-400"><?php echo e($h->logout_time?->format('h:i A')); ?></p>
                                        <?php else: ?>
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 dark:bg-green-900/30 text-green-800 dark:text-green-400">
                                                Active
                                            </span>
                                        <?php endif; ?>
                                    </td>
                                    <td class="px-4 sm:px-6 py-4 text-sm font-medium text-gray-900 dark:text-gray-100">
                                        <?php if($h->login_time && $h->logout_time): ?>
                                            <?php
                                                $secs = $h->logout_time->diffInSeconds($h->login_time);
                                                $hours = intdiv($secs, 3600);
                                                $mins = intdiv($secs % 3600, 60);
                                                $s = $secs % 60;
                                            ?>
                                            <?php if($hours > 0): ?>
                                                <?php echo e($hours); ?>h <?php echo e($mins); ?>m <?php echo e($s); ?>s
                                            <?php elseif($mins > 0): ?>
                                                <?php echo e($mins); ?>m <?php echo e($s); ?>s
                                            <?php else: ?>
                                                <?php echo e($s); ?>s
                                            <?php endif; ?>
                                        <?php else: ?>
                                            <span class="text-gray-500 dark:text-gray-500">—</span>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                <?php if($histories->hasPages()): ?>
                    <div class="border-t border-gray-200 dark:border-gray-600 px-4 sm:px-6 py-4">
                        <div class="flex justify-center">
                            <?php echo e($histories->links('pagination::tailwind')); ?>

                        </div>
                    </div>
                <?php endif; ?>
            </div>
        <?php else: ?>
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg border border-gray-100 dark:border-gray-700 p-8 text-center">
                <svg class="w-12 h-12 mx-auto text-gray-400 dark:text-gray-500 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <h3 class="text-lg font-semibold text-gray-700 dark:text-gray-300 mb-2">No login history found</h3>
                <p class="text-gray-600 dark:text-gray-400">No admin login records match your search criteria.</p>
            </div>
        <?php endif; ?>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layouts.admin-app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\Tinnity_ecom\resources\views\admin\login-history\index.blade.php ENDPATH**/ ?>