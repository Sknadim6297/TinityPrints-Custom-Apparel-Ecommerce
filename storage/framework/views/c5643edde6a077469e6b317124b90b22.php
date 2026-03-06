<nav x-data="{ open: false, profileOpen: false }" class="sticky top-0 z-40 bg-white/90 dark:bg-gray-900/90 backdrop-blur border-b border-gray-200 dark:border-gray-700 shadow-sm">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center h-16">
            <div class="flex items-center">
                <!-- Logo -->
                <div class="shrink-0 flex items-center">
                    <a href="<?php echo e(route('admin.dashboard')); ?>" class="flex items-center">
                        <img src="<?php echo e(asset('frontend/assets/img/logo/logo.png')); ?>" alt="Tinnity" class="h-8 w-auto">
                    </a>
                </div>

                <!-- Navigation Links -->
                <div class="hidden md:flex md:space-x-1 lg:space-x-2 md:ms-10">
                    <a href="<?php echo e(route('admin.dashboard')); ?>" class="px-3 py-2 rounded-md text-sm font-medium transition-all duration-150
                        <?php if(request()->routeIs('admin.dashboard*')): ?>
                            bg-gray-100 dark:bg-gray-700 text-red-600 dark:text-red-400 shadow-sm
                        <?php else: ?>
                            text-gray-900 dark:text-gray-100 hover:text-red-600 dark:hover:text-red-400 hover:bg-gray-50 dark:hover:bg-gray-800
                        <?php endif; ?>">
                        Dashboard
                    </a>

                    <?php
                        $adminUnreadCount = \Illuminate\Support\Facades\Schema::hasTable('notifications')
                            ? auth()->guard('admin')->user()->unreadNotifications()->count()
                            : 0;
                    ?>
                    
                    <a href="<?php echo e(route('admin.products.index')); ?>" class="px-3 py-2 rounded-md text-sm font-medium transition-all duration-150
                        <?php if(request()->routeIs('admin.products.*')): ?>
                            bg-gray-100 dark:bg-gray-700 text-red-600 dark:text-red-400 shadow-sm
                        <?php else: ?>
                            text-gray-900 dark:text-gray-100 hover:text-red-600 dark:hover:text-red-400 hover:bg-gray-50 dark:hover:bg-gray-800
                        <?php endif; ?>">
                        Products
                    </a>
                    
                    <a href="<?php echo e(route('admin.design-approvals.index')); ?>" class="px-3 py-2 rounded-md text-sm font-medium transition-all duration-150
                        <?php if(request()->routeIs('admin.design-approvals.*')): ?>
                            bg-gray-100 dark:bg-gray-700 text-red-600 dark:text-red-400 shadow-sm
                        <?php else: ?>
                            text-gray-900 dark:text-gray-100 hover:text-red-600 dark:hover:text-red-400 hover:bg-gray-50 dark:hover:bg-gray-800
                        <?php endif; ?>">
                        Designs
                    </a>
                    
                    <a href="<?php echo e(route('admin.customers.index')); ?>" class="px-3 py-2 rounded-md text-sm font-medium transition-all duration-150
                        <?php if(request()->routeIs('admin.customers.*')): ?>
                            bg-gray-100 dark:bg-gray-700 text-red-600 dark:text-red-400 shadow-sm
                        <?php else: ?>
                            text-gray-900 dark:text-gray-100 hover:text-red-600 dark:hover:text-red-400 hover:bg-gray-50 dark:hover:bg-gray-800
                        <?php endif; ?>">
                        Customers
                    </a>
                    
                    <?php if(auth()->guard('admin')->user()->isOrderManager()): ?>
                        <a href="<?php echo e(route('admin.orders.index')); ?>" class="px-3 py-2 rounded-md text-sm font-medium transition-all duration-150
                            <?php if(request()->routeIs('admin.orders.*')): ?>
                                bg-gray-100 dark:bg-gray-700 text-red-600 dark:text-red-400 shadow-sm
                            <?php else: ?>
                                text-gray-900 dark:text-gray-100 hover:text-red-600 dark:hover:text-red-400 hover:bg-gray-50 dark:hover:bg-gray-800
                            <?php endif; ?>">
                            Orders
                        </a>
                        <a href="<?php echo e(route('admin.refunds.index')); ?>" class="px-3 py-2 rounded-md text-sm font-medium transition-all duration-150
                            <?php if(request()->routeIs('admin.refunds.*')): ?>
                                bg-gray-100 dark:bg-gray-700 text-red-600 dark:text-red-400 shadow-sm
                            <?php else: ?>
                                text-gray-900 dark:text-gray-100 hover:text-red-600 dark:hover:text-red-400 hover:bg-gray-50 dark:hover:bg-gray-800
                            <?php endif; ?>">
                            Refunds
                        </a>
                    <?php endif; ?>
                    
                    <?php if(auth()->guard('admin')->user()->isSuperAdmin()): ?>
                        <a href="<?php echo e(route('admin.coupons.index')); ?>" class="px-3 py-2 rounded-md text-sm font-medium transition-all duration-150
                            <?php if(request()->routeIs('admin.coupons.*')): ?>
                                bg-gray-100 dark:bg-gray-700 text-red-600 dark:text-red-400 shadow-sm
                            <?php else: ?>
                                text-gray-900 dark:text-gray-100 hover:text-red-600 dark:hover:text-red-400 hover:bg-gray-50 dark:hover:bg-gray-800
                            <?php endif; ?>">
                            Coupons
                        </a>
                        <a href="#" class="px-3 py-2 rounded-md text-sm font-medium transition-all duration-150 text-gray-900 dark:text-gray-100 hover:text-red-600 dark:hover:text-red-400 hover:bg-gray-50 dark:hover:bg-gray-800">
                            Settings
                        </a>
                    <?php endif; ?>

                    <a href="<?php echo e(route('admin.contacts.index')); ?>" class="px-3 py-2 rounded-md text-sm font-medium transition-all duration-150
                        <?php if(request()->routeIs('admin.contacts.*')): ?>bg-gray-100 dark:bg-gray-700 text-red-600 dark:text-red-400 shadow-sm
                            <?php else: ?>
                                text-gray-900 dark:text-gray-100 hover:text-red-600 dark:hover:text-red-400 hover:bg-gray-50 dark:hover:bg-gray-800
                        <?php endif; ?>">
                        Contacts
                    </a>
                </div>
            </div>

            <!-- Settings Dropdown & Dark Mode Toggle -->
            <div class="flex items-center space-x-2 sm:space-x-4">
                <!-- Notifications -->
                <a href="<?php echo e(route('admin.notifications.index')); ?>"
                   class="relative p-2 rounded-lg bg-gray-100 dark:bg-gray-700 text-gray-600 dark:text-gray-300 hover:bg-gray-200 dark:hover:bg-gray-600 transition-colors"
                   aria-label="Notifications">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6 6 0 10-12 0v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0a3 3 0 11-6 0h6z" />
                    </svg>
                    <?php if($adminUnreadCount > 0): ?>
                        <span class="absolute -top-1 -right-1 bg-red-600 text-white text-[10px] font-semibold rounded-full px-1.5 py-0.5">
                            <?php echo e($adminUnreadCount); ?>

                        </span>
                    <?php endif; ?>
                </a>

                <!-- Dark Mode Toggle -->
                <button onclick="toggleDarkMode()" 
                        type="button"
                        class="p-2 rounded-lg bg-gray-100 dark:bg-gray-700 text-gray-600 dark:text-gray-300 hover:bg-gray-200 dark:hover:bg-gray-600 transition-colors">
                    <!-- Moon icon (light mode) -->
                    <svg class="w-5 h-5 dark:hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z" />
                    </svg>
                    <!-- Sun icon (dark mode) -->
                    <svg class="w-5 h-5 hidden dark:block" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z" />
                    </svg>
                </button>

                <!-- Profile Dropdown -->
                <div class="relative" x-data="{ open: false }">
                    <button @click="open = !open" 
                            type="button"
                            class="flex items-center space-x-2 p-2 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors">
                        <div class="w-8 h-8 rounded-full bg-gradient-to-r from-yellow-400 to-red-500 flex items-center justify-center text-white font-semibold text-sm">
                            <?php echo e(substr(auth()->guard('admin')->user()->name, 0, 1)); ?>

                        </div>
                        <div class="hidden sm:block text-left">
                            <div class="text-sm font-medium text-gray-800 dark:text-gray-200"><?php echo e(auth()->guard('admin')->user()->name); ?></div>
                            <div class="text-xs text-gray-600 dark:text-gray-400"><?php echo e(ucfirst(str_replace('_', ' ', auth()->guard('admin')->user()->role))); ?></div>
                        </div>
                        <svg class="w-4 h-4 text-gray-600 dark:text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3" />
                        </svg>
                    </button>

                    <div x-show="open" @click.away="open = false" x-transition class="absolute right-0 mt-2 w-48 rounded-lg shadow-lg bg-white dark:bg-gray-700 ring-1 ring-black ring-opacity-5 py-1 z-50" style="display: none;">
                        <form method="POST" action="<?php echo e(route('admin.logout')); ?>">
                            <?php echo csrf_field(); ?>
                            <button type="submit" class="w-full text-left px-4 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-600 transition-colors">
                                <?php echo e(__('Log Out')); ?>

                            </button>
                        </form>
                    </div>
                </div>

                <!-- Hamburger Menu (Mobile) -->
                <button @click="open = ! open" 
                        type="button"
                        class="md:hidden inline-flex items-center justify-center p-2 rounded-md text-gray-600 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors">
                    <svg class="h-6 w-6" :class="{'hidden': open, 'block': !open}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                    <svg class="h-6 w-6" :class="{'block': open, 'hidden': !open}" fill="none" stroke="currentColor" viewBox="0 0 24 24" x-cloak>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Mobile Menu -->
    <div x-show="open" @click.away="open = false" x-transition class="md:hidden bg-white dark:bg-gray-800 border-t border-gray-200 dark:border-gray-700" style="display: none;">
        <div class="px-2 pt-2 pb-3 space-y-1">
            <a href="<?php echo e(route('admin.dashboard')); ?>" class="text-gray-900 dark:text-gray-100 block px-3 py-2 rounded-md text-base font-medium hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors">
                Dashboard
            </a>

            <a href="<?php echo e(route('admin.notifications.index')); ?>" class="text-gray-900 dark:text-gray-100 block px-3 py-2 rounded-md text-base font-medium hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors">
                Notifications
            </a>
            
            <a href="<?php echo e(route('admin.products.index')); ?>" class="text-gray-900 dark:text-gray-100 block px-3 py-2 rounded-md text-base font-medium hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors">
                Products
            </a>
            
            <a href="<?php echo e(route('admin.design-approvals.index')); ?>" class="text-gray-900 dark:text-gray-100 block px-3 py-2 rounded-md text-base font-medium hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors">
                Designs
            </a>
            
            <a href="<?php echo e(route('admin.customers.index')); ?>" class="text-gray-900 dark:text-gray-100 block px-3 py-2 rounded-md text-base font-medium hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors">
                Customers
            </a>
            
            <?php if(auth()->guard('admin')->user()->isOrderManager()): ?>
                <a href="<?php echo e(route('admin.orders.index')); ?>" class="text-gray-900 dark:text-gray-100 block px-3 py-2 rounded-md text-base font-medium hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors">
                    Orders
                </a>
                <a href="<?php echo e(route('admin.refunds.index')); ?>" class="text-gray-900 dark:text-gray-100 block px-3 py-2 rounded-md text-base font-medium hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors">
                    Refunds
                </a>
            <?php endif; ?>
            
            <?php if(auth()->guard('admin')->user()->isSuperAdmin()): ?>
                <a href="<?php echo e(route('admin.coupons.index')); ?>" class="text-gray-900 dark:text-gray-100 block px-3 py-2 rounded-md text-base font-medium hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors">
                    Coupons
                </a>
                <a href="#" class="text-gray-900 dark:text-gray-100 block px-3 py-2 rounded-md text-base font-medium hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors">
                    Settings
                </a>
            <?php endif; ?>

            <a href="<?php echo e(route('admin.contacts.index')); ?>" class="text-gray-900 dark:text-gray-100 block px-3 py-2 rounded-md text-base font-medium hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors">
                Contacts
            </a>
        </div>
    </div>
</nav>
<?php /**PATH C:\xampp\htdocs\Tinnity_ecom\resources\views/admin/layouts/admin-navigation.blade.php ENDPATH**/ ?>