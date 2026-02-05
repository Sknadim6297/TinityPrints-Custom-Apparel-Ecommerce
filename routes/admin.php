<?php

use App\Http\Controllers\Admin\Auth\AdminAuthenticatedSessionController;
use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Admin\ProductController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
|
| Here is where you can register admin routes for your application.
|
*/

// Admin Guest Routes (Not Authenticated)
Route::middleware('admin.guest')->prefix('admin')->name('admin.')->group(function () {
    Route::get('login', [AdminAuthenticatedSessionController::class, 'create'])
        ->name('login');
    
    Route::post('login', [AdminAuthenticatedSessionController::class, 'store']);
});

// Admin Authenticated Routes
Route::middleware('admin')->prefix('admin')->name('admin.')->group(function () {
    // Dashboard
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])
        ->name('dashboard');
    
    // Logout
    Route::post('logout', [AdminAuthenticatedSessionController::class, 'destroy'])
        ->name('logout');
    
    // Product Management
    Route::resource('products', ProductController::class);
    Route::post('products/{product}/colors', [ProductController::class, 'addColor'])
        ->name('products.addColor');
    Route::delete('colors/{color}', [ProductController::class, 'deleteColor'])
        ->name('colors.destroy');
    
    // Routes for Super Admin only
    Route::middleware('admin.role:super_admin')->group(function () {
        // Add super admin specific routes here
    });
    
    // Routes for Order Manager
    Route::middleware('admin.role:order_manager,super_admin')->group(function () {
        // Add order management routes here
    });
    
    // Routes for Design Approver
    Route::middleware('admin.role:design_approver,super_admin')->group(function () {
        // Add design approval routes here
    });
});
