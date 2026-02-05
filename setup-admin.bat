@echo off
echo ========================================
echo Tinnity Admin Panel Setup
echo ========================================
echo.

echo Step 1: Running migrations...
php artisan migrate
if errorlevel 1 (
    echo Error: Migration failed!
    pause
    exit /b 1
)
echo ✓ Migrations completed successfully
echo.

echo Step 2: Seeding admin accounts...
php artisan db:seed --class=AdminSeeder
if errorlevel 1 (
    echo Error: Seeding failed!
    pause
    exit /b 1
)
echo ✓ Admin accounts created successfully
echo.

echo Step 3: Clearing cache...
php artisan route:clear
php artisan config:clear
php artisan view:clear
echo ✓ Cache cleared successfully
echo.

echo ========================================
echo Setup Complete!
echo ========================================
echo.
echo Default Admin Credentials:
echo ---------------------------
echo Super Admin:
echo   Email: admin@tinnity.com
echo   Password: password
echo.
echo Order Manager:
echo   Email: orders@tinnity.com
echo   Password: password
echo.
echo Design Approver:
echo   Email: design@tinnity.com
echo   Password: password
echo.
echo Admin Login URL: /admin/login
echo.
echo ⚠️  IMPORTANT: Change these passwords in production!
echo ========================================
echo.
pause
