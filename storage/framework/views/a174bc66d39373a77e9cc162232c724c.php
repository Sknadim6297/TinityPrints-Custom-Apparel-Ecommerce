<?php $__env->startSection('content'); ?>
<div class="py-6 md:py-12">
    <div class="max-w-7xl mx-auto px-3 sm:px-6 lg:px-8">
        <!-- Page Header -->
        <div class="mb-6 md:mb-8">
            <h2 class="font-semibold text-2xl sm:text-3xl text-gray-800 dark:text-gray-200 leading-tight">
                <?php echo e(__('Admin Dashboard')); ?>

            </h2>
            <p class="text-xs sm:text-sm text-gray-600 dark:text-gray-400 mt-2">
                Welcome back, <span class="font-semibold text-gray-800 dark:text-gray-200"><?php echo e(auth()->guard('admin')->user()->name); ?></span>
            </p>
        </div>

        <!-- Statistics Grid -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-3 sm:gap-4 md:gap-6 mb-6 md:mb-8">
            <!-- Total Orders -->
            <div class="bg-gradient-to-br from-yellow-400 to-yellow-600 rounded-xl sm:rounded-2xl shadow-lg p-4 sm:p-6 text-white transform transition-all duration-300 hover:scale-105 hover:shadow-2xl">
                <div class="flex items-center justify-between">
                    <div class="flex-1">
                        <p class="text-yellow-100 text-xs sm:text-sm font-medium mb-1">Total Orders</p>
                        <p class="text-2xl sm:text-4xl font-bold"><?php echo e(number_format($stats['total_orders'])); ?></p>
                    </div>
                    <div class="bg-yellow-500 bg-opacity-30 rounded-full p-2 sm:p-4 flex-shrink-0">
                        <svg class="w-6 h-6 sm:w-8 sm:h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                        </svg>
                    </div>
                </div>
            </div>

            <!-- Pending Design Approvals -->
            <div class="bg-gradient-to-br from-red-400 to-red-600 rounded-xl sm:rounded-2xl shadow-lg p-4 sm:p-6 text-white transform transition-all duration-300 hover:scale-105 hover:shadow-2xl">
                <div class="flex items-center justify-between">
                    <div class="flex-1">
                        <p class="text-red-100 text-xs sm:text-sm font-medium mb-1">Pending Approvals</p>
                        <p class="text-2xl sm:text-4xl font-bold"><?php echo e(number_format($stats['pending_design_approvals'])); ?></p>
                    </div>
                    <div class="bg-red-500 bg-opacity-30 rounded-full p-2 sm:p-4 flex-shrink-0">
                        <svg class="w-6 h-6 sm:w-8 sm:h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                    </div>
                </div>
            </div>

            <!-- Pending Payments -->
            <div class="bg-gradient-to-br from-orange-400 to-orange-600 rounded-xl sm:rounded-2xl shadow-lg p-4 sm:p-6 text-white transform transition-all duration-300 hover:scale-105 hover:shadow-2xl">
                <div class="flex items-center justify-between">
                    <div class="flex-1">
                        <p class="text-orange-100 text-xs sm:text-sm font-medium mb-1">Pending Payments</p>
                        <p class="text-2xl sm:text-4xl font-bold"><?php echo e(number_format($stats['pending_payments'])); ?></p>
                    </div>
                    <div class="bg-orange-500 bg-opacity-30 rounded-full p-2 sm:p-4 flex-shrink-0">
                        <svg class="w-6 h-6 sm:w-8 sm:h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                </div>
            </div>

            <!-- Orders in Printing -->
            <div class="bg-gradient-to-br from-purple-400 to-purple-600 rounded-xl sm:rounded-2xl shadow-lg p-4 sm:p-6 text-white transform transition-all duration-300 hover:scale-105 hover:shadow-2xl">
                <div class="flex items-center justify-between">
                    <div class="flex-1">
                        <p class="text-purple-100 text-xs sm:text-sm font-medium mb-1">In Printing</p>
                        <p class="text-2xl sm:text-4xl font-bold"><?php echo e(number_format($stats['orders_in_printing'])); ?></p>
                    </div>
                    <div class="bg-purple-500 bg-opacity-30 rounded-full p-2 sm:p-4 flex-shrink-0">
                        <svg class="w-6 h-6 sm:w-8 sm:h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z" />
                        </svg>
                    </div>
                </div>
            </div>

            <!-- Shipped Orders -->
            <div class="bg-gradient-to-br from-green-400 to-green-600 rounded-xl sm:rounded-2xl shadow-lg p-4 sm:p-6 text-white transform transition-all duration-300 hover:scale-105 hover:shadow-2xl">
                <div class="flex items-center justify-between">
                    <div class="flex-1">
                        <p class="text-green-100 text-xs sm:text-sm font-medium mb-1">Shipped Orders</p>
                        <p class="text-2xl sm:text-4xl font-bold"><?php echo e(number_format($stats['shipped_orders'])); ?></p>
                    </div>
                    <div class="bg-green-500 bg-opacity-30 rounded-full p-2 sm:p-4 flex-shrink-0">
                        <svg class="w-6 h-6 sm:w-8 sm:h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4" />
                        </svg>
                    </div>
                </div>
            </div>

            <!-- Refund Requests -->
            <div class="bg-gradient-to-br from-pink-400 to-pink-600 rounded-xl sm:rounded-2xl shadow-lg p-4 sm:p-6 text-white transform transition-all duration-300 hover:scale-105 hover:shadow-2xl">
                <div class="flex items-center justify-between">
                    <div class="flex-1">
                        <p class="text-pink-100 text-xs sm:text-sm font-medium mb-1">Refund Requests</p>
                        <p class="text-2xl sm:text-4xl font-bold"><?php echo e(number_format($stats['refund_requests'])); ?></p>
                    </div>
                    <div class="bg-pink-500 bg-opacity-30 rounded-full p-2 sm:p-4 flex-shrink-0">
                        <svg class="w-6 h-6 sm:w-8 sm:h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h10a8 8 0 018 8v2M3 10l6 6m-6-6l6-6" />
                        </svg>
                    </div>
                </div>
            </div>

            <!-- Monthly Sales -->
            <div class="bg-gradient-to-br from-blue-400 to-blue-600 rounded-xl sm:rounded-2xl shadow-lg p-4 sm:p-6 text-white transform transition-all duration-300 hover:scale-105 hover:shadow-2xl">
                <div class="flex items-center justify-between">
                    <div class="flex-1">
                        <p class="text-blue-100 text-xs sm:text-sm font-medium mb-1">Monthly Sales</p>
                        <p class="text-2xl sm:text-4xl font-bold">₹<?php echo e(number_format($stats['monthly_sales'], 0)); ?></p>
                    </div>
                    <div class="bg-blue-500 bg-opacity-30 rounded-full p-2 sm:p-4 flex-shrink-0">
                        <svg class="w-6 h-6 sm:w-8 sm:h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6" />
                        </svg>
                    </div>
                </div>
            </div>

            <!-- Active Limited Editions -->
            <div class="bg-gradient-to-br from-indigo-400 to-indigo-600 rounded-xl sm:rounded-2xl shadow-lg p-4 sm:p-6 text-white transform transition-all duration-300 hover:scale-105 hover:shadow-2xl">
                <div class="flex items-center justify-between">
                    <div class="flex-1">
                        <p class="text-indigo-100 text-xs sm:text-sm font-medium mb-1">Limited Editions</p>
                        <p class="text-2xl sm:text-4xl font-bold"><?php echo e(number_format($stats['active_limited_editions'])); ?></p>
                    </div>
                    <div class="bg-indigo-500 bg-opacity-30 rounded-full p-2 sm:p-4 flex-shrink-0">
                        <svg class="w-6 h-6 sm:w-8 sm:h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z" />
                        </svg>
                    </div>
                </div>
            </div>
        </div>

        <!-- Monthly Sales Chart & Recent Activity -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-4 md:gap-6">
            <!-- Monthly Sales Chart -->
            <div class="lg:col-span-2 bg-white dark:bg-gray-800 rounded-xl sm:rounded-2xl shadow-lg p-4 sm:p-6 border border-gray-100 dark:border-gray-700">
                <h3 class="text-lg sm:text-xl font-bold text-gray-800 dark:text-gray-200 mb-4">Monthly Sales Overview</h3>
                <div class="h-48 sm:h-64">
                    <canvas id="salesChart"></canvas>
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="bg-white dark:bg-gray-800 rounded-xl sm:rounded-2xl shadow-lg p-4 sm:p-6 border border-gray-100 dark:border-gray-700">
                <h3 class="text-lg sm:text-xl font-bold text-gray-800 dark:text-gray-200 mb-4">Quick Actions</h3>
                <div class="space-y-2 sm:space-y-3">
                    <a href="<?php echo e(route('admin.customers.index')); ?>" class="block w-full bg-gradient-to-r from-cyan-400 to-cyan-600 text-white rounded-lg px-3 sm:px-4 py-2 sm:py-3 font-semibold text-sm sm:text-base hover:from-cyan-500 hover:to-cyan-700 transition-all duration-300 text-center shadow-md hover:shadow-lg">
                        Manage Customers
                    </a>

                    <a href="<?php echo e(route('admin.login-history.index')); ?>" class="block w-full bg-gradient-to-r from-slate-400 to-slate-600 text-white rounded-lg px-3 sm:px-4 py-2 sm:py-3 font-semibold text-sm sm:text-base hover:from-slate-500 hover:to-slate-700 transition-all duration-300 text-center shadow-md hover:shadow-lg">
                        Admin Login History
                    </a>
                    
                    <?php if(auth()->guard('admin')->user()->isOrderManager()): ?>
                        <a href="<?php echo e(route('admin.orders.index')); ?>" class="block w-full bg-gradient-to-r from-yellow-400 to-yellow-600 text-white rounded-lg px-3 sm:px-4 py-2 sm:py-3 font-semibold text-sm sm:text-base hover:from-yellow-500 hover:to-yellow-700 transition-all duration-300 text-center shadow-md hover:shadow-lg">
                            View Orders
                        </a>
                    <?php endif; ?>
                    
                    <?php if(auth()->guard('admin')->user()->isDesignApprover()): ?>
                        <a href="<?php echo e(route('admin.design-approvals.index')); ?>" class="block w-full bg-gradient-to-r from-red-400 to-red-600 text-white rounded-lg px-3 sm:px-4 py-2 sm:py-3 font-semibold text-sm sm:text-base hover:from-red-500 hover:to-red-700 transition-all duration-300 text-center shadow-md hover:shadow-lg">
                            Review Designs
                        </a>
                    <?php endif; ?>
                    
                    <a href="<?php echo e(route('admin.refunds.index')); ?>" class="block w-full bg-gradient-to-r from-orange-400 to-orange-600 text-white rounded-lg px-3 sm:px-4 py-2 sm:py-3 font-semibold text-sm sm:text-base hover:from-orange-500 hover:to-orange-700 transition-all duration-300 text-center shadow-md hover:shadow-lg">
                        Process Refunds
                    </a>
                    
                    <?php if(auth()->guard('admin')->user()->isSuperAdmin()): ?>
                        <a href="<?php echo e(route('admin.customers.index')); ?>" class="block w-full bg-gradient-to-r from-purple-400 to-purple-600 text-white rounded-lg px-3 sm:px-4 py-2 sm:py-3 font-semibold text-sm sm:text-base hover:from-purple-500 hover:to-purple-700 transition-all duration-300 text-center shadow-md hover:shadow-lg">
                            Manage Admins
                        </a>
                    <?php endif; ?>
                </div>

                <!-- Admin Info -->
                <div class="mt-4 sm:mt-6 pt-4 sm:pt-6 border-t border-gray-200 dark:border-gray-700">
                    <h4 class="text-xs sm:text-sm font-semibold text-gray-700 dark:text-gray-300 mb-3">Your Account</h4>
                    <div class="space-y-2 text-xs sm:text-sm">
                        <div class="flex justify-between">
                            <span class="text-gray-600 dark:text-gray-400">Role:</span>
                            <span class="font-semibold text-gray-800 dark:text-gray-200"><?php echo e(ucfirst(str_replace('_', ' ', auth()->guard('admin')->user()->role))); ?></span>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="text-gray-600 dark:text-gray-400">Email:</span>
                            <span class="font-semibold text-gray-800 dark:text-gray-200 text-xs truncate ml-2"><?php echo e(auth()->guard('admin')->user()->email); ?></span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600 dark:text-gray-400">Status:</span>
                            <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-semibold <?php echo e(auth()->guard('admin')->user()->is_active ? 'bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-200' : 'bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-200'); ?>">
                                <?php echo e(auth()->guard('admin')->user()->is_active ? 'Active' : 'Inactive'); ?>

                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php $__env->startPush('scripts'); ?>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const ctx = document.getElementById('salesChart');
        if (ctx) {
            const salesChart = new Chart(ctx, {
                type: 'line',
                data: {
                    labels: <?php echo json_encode($stats['monthly_chart_data']['labels'], 15, 512) ?>,
                    datasets: [{
                        label: 'Sales (₹)',
                        data: <?php echo json_encode($stats['monthly_chart_data']['data'], 15, 512) ?>,
                        borderColor: 'rgb(239, 68, 68)',
                        backgroundColor: 'rgba(239, 68, 68, 0.1)',
                        borderWidth: 2,
                        tension: 0.4,
                        fill: true,
                        pointRadius: 4,
                        pointBackgroundColor: 'rgb(239, 68, 68)',
                        pointBorderColor: '#fff',
                        pointBorderWidth: 2
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            display: true,
                            labels: {
                                color: 'rgb(107, 114, 128)',
                                font: {
                                    size: 12
                                }
                            }
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            grid: {
                                color: 'rgba(0, 0, 0, 0.05)',
                                drawBorder: false
                            },
                            ticks: {
                                color: 'rgb(107, 114, 128)'
                            }
                        },
                        x: {
                            grid: {
                                display: false,
                                drawBorder: false
                            },
                            ticks: {
                                color: 'rgb(107, 114, 128)'
                            }
                        }
                    }
                }
            });
        }
    });
</script>
<?php $__env->stopPush(); ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layouts.admin-app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\Tinnity_ecom\resources\views/admin/admin-dashboard.blade.php ENDPATH**/ ?>