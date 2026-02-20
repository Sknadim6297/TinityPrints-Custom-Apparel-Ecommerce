<?php

use App\Http\Controllers\Admin\Auth\AdminAuthenticatedSessionController;
use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Admin\CustomerController;
use App\Http\Controllers\Admin\AdminNotificationController;
use App\Http\Controllers\Admin\CouponController;
use App\Http\Controllers\Admin\DesignApprovalController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\RefundController;
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

    // Customers
    Route::middleware('admin.access')->group(function () {
        Route::resource('customers', CustomerController::class);
        Route::get('customers/{customer}/history', [CustomerController::class, 'history'])
            ->name('customers.history');
    });
    
    // Logout
    Route::post('logout', [AdminAuthenticatedSessionController::class, 'destroy'])
        ->name('logout');

    // Notifications
    Route::get('notifications', [AdminNotificationController::class, 'index'])
        ->name('notifications.index');
    Route::patch('notifications/read-all', [AdminNotificationController::class, 'markAllRead'])
        ->name('notifications.read-all');
    Route::patch('notifications/{notification}/read', [AdminNotificationController::class, 'markRead'])
        ->name('notifications.read');

    // Admin Login History
    Route::get('login-history', [\App\Http\Controllers\Admin\AdminLoginHistoryController::class, 'index'])
        ->name('login-history.index');
    
    // Product Management
    Route::resource('products', ProductController::class);
    Route::post('products/{product}/colors', [ProductController::class, 'addColor'])
        ->name('products.addColor');
    Route::delete('colors/{color}', [ProductController::class, 'deleteColor'])
        ->name('colors.destroy');
    
    // Routes for Super Admin only
    Route::middleware('admin.role:super_admin')->group(function () {
        Route::get('coupons', [CouponController::class, 'index'])
            ->name('coupons.index');
        Route::post('coupons', [CouponController::class, 'store'])
            ->name('coupons.store');
        Route::get('coupons/{coupon}/edit', [CouponController::class, 'edit'])
            ->name('coupons.edit');
        Route::patch('coupons/{coupon}', [CouponController::class, 'update'])
            ->name('coupons.update');
        Route::delete('coupons/{coupon}', [CouponController::class, 'destroy'])
            ->name('coupons.destroy');
        Route::patch('coupons/{coupon}/toggle', [CouponController::class, 'toggle'])
            ->name('coupons.toggle');
    });
    
    // Routes for Order Manager
    Route::middleware('admin.role:order_manager,super_admin')->group(function () {
        Route::get('orders', [OrderController::class, 'index'])
            ->name('orders.index');
        Route::patch('orders/{order}', [OrderController::class, 'update'])
            ->name('orders.update');
        Route::get('refunds', [RefundController::class, 'index'])
            ->name('refunds.index');
        Route::patch('refunds/{refund}/approve', [RefundController::class, 'approve'])
            ->name('refunds.approve');
        Route::patch('refunds/{refund}/reject', [RefundController::class, 'reject'])
            ->name('refunds.reject');
        Route::patch('refunds/{refund}/status', [RefundController::class, 'updateStatus'])
            ->name('refunds.status');
        Route::patch('refunds/{refund}/paid', [RefundController::class, 'markPaid'])
            ->name('refunds.paid');
        Route::patch('refunds/{refund}/notify', [RefundController::class, 'notify'])
            ->name('refunds.notify');
    });
    
    // Routes for Design Approver
    Route::middleware('admin.role:design_approver,super_admin')->group(function () {
        Route::get('design-approvals', [DesignApprovalController::class, 'index'])
            ->name('design-approvals.index');
        Route::post('design-approvals/{designRequest}/approve', [DesignApprovalController::class, 'approve'])
            ->name('design-approvals.approve');
        Route::post('design-approvals/{designRequest}/reject', [DesignApprovalController::class, 'reject'])
            ->name('design-approvals.reject');
        Route::post('design-approvals/{designRequest}/request-changes', [DesignApprovalController::class, 'requestChanges'])
            ->name('design-approvals.request-changes');
        Route::patch('design-approvals/{designRequest}/checks', [DesignApprovalController::class, 'updateChecks'])
            ->name('design-approvals.update-checks');
        Route::post('design-approvals/{designRequest}/file', [DesignApprovalController::class, 'updateFile'])
            ->name('design-approvals.update-file');
        Route::post('design-approvals/{designRequest}/lock', [DesignApprovalController::class, 'toggleLock'])
            ->name('design-approvals.toggle-lock');
    });
});
