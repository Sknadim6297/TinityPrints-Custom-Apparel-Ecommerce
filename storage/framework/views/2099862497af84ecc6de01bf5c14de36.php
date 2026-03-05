<!DOCTYPE html>
<html lang="<?php echo e(str_replace('_', '-', app()->getLocale())); ?>" id="htmlElement">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">

        <title><?php echo e(config('app.name', 'Laravel')); ?> - Admin Panel</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        <?php echo app('Illuminate\Foundation\Vite')(['resources/css/app.css', 'resources/js/app.js']); ?>
        
        <script>
            // Initialize dark mode IMMEDIATELY to prevent flash
            (function() {
                const html = document.documentElement;
                const storedDarkMode = localStorage.getItem('adminDarkMode');
                
                if (storedDarkMode === 'true') {
                    html.classList.add('dark');
                } else if (storedDarkMode === 'false') {
                    html.classList.remove('dark');
                } else {
                    // Use system preference if not set
                    if (window.matchMedia('(prefers-color-scheme: dark)').matches) {
                        html.classList.add('dark');
                        localStorage.setItem('adminDarkMode', 'true');
                    } else {
                        localStorage.setItem('adminDarkMode', 'false');
                    }
                }
            })();
            
            // Global toggle function
            function toggleDarkMode() {
                const html = document.documentElement;
                const isDark = html.classList.contains('dark');
                
                if (isDark) {
                    html.classList.remove('dark');
                    localStorage.setItem('adminDarkMode', 'false');
                } else {
                    html.classList.add('dark');
                    localStorage.setItem('adminDarkMode', 'true');
                }
            }
        </script>
    </head>
    <body class="font-sans antialiased bg-gray-50 dark:bg-gray-900 transition-colors duration-200">
        <div class="min-h-screen">
            <?php echo $__env->make('admin.layouts.admin-navigation', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

            <!-- Page Content -->
            <main class="transition-colors duration-200">
                <?php echo $__env->yieldContent('content'); ?>
            </main>
        </div>
        
        <?php echo $__env->yieldPushContent('scripts'); ?>
        
        <style>
            [x-cloak] { display: none !important; }
            html, body { transition: background-color 0.2s ease, color 0.2s ease; }
        </style>
    </body>
</html>
<?php /**PATH C:\xampp\htdocs\Tinnity_ecom\resources\views/admin/layouts/admin-app.blade.php ENDPATH**/ ?>