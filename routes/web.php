<?php

use App\Http\Controllers\Admin\ContactController;
use App\Http\Controllers\Frontend\HomeController;
use App\Http\Controllers\Frontend\CartController;
use App\Http\Controllers\Frontend\WishlistController;
use App\Http\Controllers\Frontend\ReviewController;
use App\Http\Controllers\Frontend\CheckoutController;
use App\Http\Controllers\Frontend\OrderController;
use App\Http\Controllers\Frontend\CustomDesignController;
use App\Http\Controllers\Frontend\StockAlertController;
use App\Http\Controllers\Frontend\DropdownController;
use App\Http\Controllers\Frontend\PaymentController;
use App\Http\Controllers\Frontend\BlogController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Route;

// Simple health check and Razorpay test (for debugging)
Route::get('/payment/test-razorpay', function () {
    try {
        $apiInstance = new \Razorpay\Api\Api('test_key', 'test_secret');
        return response()->json(['success' => true, 'message' => 'Razorpay SDK is properly loaded']);
    } catch (\Exception $e) {
        return response()->json([
            'success' => false,
            'error' => $e->getMessage(),
            'class_exists' => class_exists('Razorpay\Api\Api'),
            'file' => __FILE__,
        ], 500);
    }
});

// Frontend Routes
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/shop', [HomeController::class, 'shop'])->name('shop');
Route::get('/shop/{category}', [HomeController::class, 'shop'])->name('shop.category');
Route::get('/product/{id}', [HomeController::class, 'productDetails'])->name('product.details');
Route::get('/custom-design', [CustomDesignController::class, 'create'])->name('custom-design');
Route::middleware('auth')->group(function () {
    Route::post('/custom-design', [CustomDesignController::class, 'store'])->name('custom-design.store');
    Route::get('/custom-design/{design}', [CustomDesignController::class, 'show'])->name('custom-design.show');
    Route::match(['post', 'put'], '/custom-design/{design}', [CustomDesignController::class, 'update'])->name('custom-design.update');
    Route::get('/custom-design/{design}/download/{fileType}', [CustomDesignController::class, 'download'])
        ->whereIn('fileType', ['front', 'back'])
        ->name('custom-design.download');
    Route::get('/custom-design/{design}/checkout', [CustomDesignController::class, 'checkout'])
        ->name('custom-design.checkout');
    Route::post('/custom-design/{design}/payment', [CustomDesignController::class, 'processPayment'])
        ->name('custom-design.payment.process');
});
Route::get('/limited-edition', [HomeController::class, 'limitedEdition'])->name('limited-edition');
Route::get('/blog', [BlogController::class, 'index'])->name('blog.index');
Route::get('/blog/{slug}', [BlogController::class, 'show'])->name('blog.show');
Route::get('/about', [HomeController::class, 'about'])->name('about');
Route::get('/refund-policy', [HomeController::class, 'refundPolicy'])->name('refund-policy');
Route::get('/contact', [HomeController::class, 'contact'])->name('contact');
Route::post('/contact', [HomeController::class, 'contactSubmit'])->name('contact.submit');
Route::post('/contact-store', [ContactController::class, 'store'])->name('contact.store');

// API Routes for Dropdowns
Route::prefix('api')->group(function () {
    Route::get('/dropdowns/categories', [DropdownController::class, 'getCategories'])->name('api.dropdowns.categories');
    Route::get('/dropdowns/sleeve-types', [DropdownController::class, 'getSleeveTypes'])->name('api.dropdowns.sleeve-types');
    Route::get('/dropdowns/collection-types', [DropdownController::class, 'getCollectionTypes'])->name('api.dropdowns.collection-types');
    Route::get('/dropdowns/all', [DropdownController::class, 'getAllDropdowns'])->name('api.dropdowns.all');
});

// Cart Routes (Protected - requires authentication)
Route::middleware('auth')->group(function () {
    Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
    Route::post('/cart', [CartController::class, 'store'])->name('cart.store');
    Route::patch('/cart/{id}', [CartController::class, 'update'])->name('cart.update');
    Route::delete('/cart/{id}', [CartController::class, 'destroy'])->name('cart.destroy');
    Route::get('/cart/sidebar-items', [CartController::class, 'getSidebarItems'])->name('cart.sidebar-items');
    Route::post('/cart/apply-coupon', [CartController::class, 'applyCoupon'])->name('cart.apply-coupon');
    Route::get('/cart/available-coupons', [CartController::class, 'getAvailableCoupons'])->name('cart.available-coupons');
    Route::post('/cart/remove-coupon', [CartController::class, 'removeCoupon'])->name('cart.remove-coupon');
    Route::post('/products/{product}/stock-alert', [StockAlertController::class, 'store'])->name('products.stock-alert');
});

// Wishlist Routes (Protected - requires authentication)
Route::middleware('auth')->group(function () {
    Route::get('/wishlist', [WishlistController::class, 'index'])->name('wishlist.index');
    Route::post('/wishlist', [WishlistController::class, 'store'])->name('wishlist.store');
    Route::get('/wishlist/sidebar-items', [WishlistController::class, 'getSidebarItems'])->name('wishlist.sidebar-items');
    Route::delete('/wishlist/product/{productId}', [WishlistController::class, 'destroyByProduct'])->name('wishlist.destroy-by-product');
    Route::delete('/wishlist/{id}', [WishlistController::class, 'destroy'])->name('wishlist.destroy');
});

// Review Routes (Protected - requires authentication)
Route::post('/reviews', [ReviewController::class, 'store'])->middleware('auth')->name('reviews.store');

// Checkout Routes (authenticated users only)
Route::middleware('auth')->group(function () {
    Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout');
    Route::post('/checkout', [CheckoutController::class, 'store'])->name('checkout.store');
    Route::get('/order-success/{order}', [CheckoutController::class, 'success'])->name('order.success');
    
    // Payment Routes (Razorpay Integration)
    Route::post('/payment/create-razorpay-order/{order}', [PaymentController::class, 'createRazorpayOrder'])->name('payment.create-order');
    Route::post('/payment/callback', [PaymentController::class, 'handleCallback'])->name('payment.callback');
    Route::post('/payment/failure', [PaymentController::class, 'handleFailure'])->name('payment.failure');
    Route::get('/payment/success/{order}', [PaymentController::class, 'success'])->name('payment.success');
    Route::get('/payment/failed/{order}', [PaymentController::class, 'failure'])->name('payment.failure-page');
    Route::get('/payment/status/{order}', [PaymentController::class, 'getPaymentStatus'])->name('payment.status');
    Route::get('/payment/test-config', [PaymentController::class, 'testConfig'])->name('payment.test-config');
});

// Auth Routes - Redirect dashboard to home for regular users
Route::get('/dashboard', function () {
    return redirect('/');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    
    // User Orders Routes
    Route::get('/orders', [OrderController::class, 'index'])->name('orders');
    Route::get('/orders/{id}', [OrderController::class, 'show'])->name('order.details');
    Route::post('/orders/{order}/refund-request', [OrderController::class, 'requestRefund'])
        ->name('orders.refund.request');
    Route::patch('/refund-requests/{refund}/customer-response', [OrderController::class, 'respondRefundRequest'])
        ->whereNumber('refund')
        ->name('orders.refund.respond');
});

// Legacy auth URL aliases (login/register forms and JS may use /login, /register)
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthenticatedSessionController::class, 'create']);
    Route::post('/login', [AuthenticatedSessionController::class, 'store']);
    Route::get('/register', [RegisteredUserController::class, 'create']);
    Route::post('/register', [RegisteredUserController::class, 'store']);
});

Route::middleware('auth')->group(function () {
    Route::post('/logout', [AuthenticatedSessionController::class, 'destroy']);
});

require __DIR__.'/auth.php';

// Admin Seeder Route (for production use - remove after seeding)
Route::get('/seed-admin', function () {
    Artisan::call('db:seed', ['--class' => 'AdminSeeder']);
    return 'Admin data seeded successfully';
});

// Migration Route (for production use - remove after running)
Route::get('/migrate', function () {
    Artisan::call('migrate');
    return 'Migrations run successfully';
});

// Storage Link Route (for production use - remove after running)
Route::get('/storage-link', function () {
    Artisan::call('storage:link');
    return 'Storage link created successfully';
});

Route::get('/faq', function () {
    return view('frontend.faq');
})->name('faq');

Route::get('/return-policy', function () {
    return view('frontend.return-policy');
})->name('return.policy');

Route::get('/terms-and-conditions', function () {
    return view('frontend.terms-and-conditions');
})->name('terms');

Route::get('/privacy-policy', function () {
    return view('frontend.privacy-policy');
})->name('privacy');