<?php

use App\Http\Controllers\Frontend\HomeController;
use App\Http\Controllers\Frontend\CartController;
use App\Http\Controllers\Frontend\WishlistController;
use App\Http\Controllers\Frontend\ReviewController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

// Frontend Routes
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/shop', [HomeController::class, 'shop'])->name('shop');
Route::get('/shop/{category}', [HomeController::class, 'shop'])->name('shop.category');
Route::get('/product/{id}', [HomeController::class, 'productDetails'])->name('product.details');
Route::get('/custom-design', [HomeController::class, 'customDesign'])->name('custom-design');
Route::get('/limited-edition', [HomeController::class, 'limitedEdition'])->name('limited-edition');
Route::get('/about', [HomeController::class, 'about'])->name('about');
Route::get('/refund-policy', [HomeController::class, 'refundPolicy'])->name('refund-policy');
Route::get('/contact', [HomeController::class, 'contact'])->name('contact');
Route::post('/contact', [HomeController::class, 'contactSubmit'])->name('contact.submit');
Route::post('/contact-store', [ContactController::class, 'store'])->name('contact.store');

// Cart Routes
Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
Route::post('/cart', [CartController::class, 'store'])->name('cart.store');
Route::patch('/cart/{id}', [CartController::class, 'update'])->name('cart.update');
Route::delete('/cart/{id}', [CartController::class, 'destroy'])->name('cart.destroy');

// Wishlist Routes
Route::get('/wishlist', [WishlistController::class, 'index'])->name('wishlist.index');
Route::post('/wishlist', [WishlistController::class, 'store'])->name('wishlist.store');
Route::delete('/wishlist/{id}', [WishlistController::class, 'destroy'])->name('wishlist.destroy');

// Review Routes
Route::post('/reviews', [ReviewController::class, 'store'])->name('reviews.store');

// Checkout Route (placeholder view)
Route::get('/checkout', function () {
    return view('frontend.checkout');
})->name('checkout');

// Auth Routes - Redirect dashboard to home for regular users
Route::get('/dashboard', function () {
    return redirect('/');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::get('/orders', function () {
        return view('frontend.orders');
    })->name('orders');
});

require __DIR__.'/auth.php';

// Admin Seeder Route (for production use - remove after seeding)
Route::get('/seed-admin', function () {
    \Artisan::call('db:seed', ['--class' => 'AdminSeeder']);
    return 'Admin data seeded successfully';
});

// Migration Route (for production use - remove after running)
Route::get('/migrate', function () {
    \Artisan::call('migrate');
    return 'Migrations run successfully';
});

// Storage Link Route (for production use - remove after running)
Route::get('/storage-link', function () {
    \Artisan::call('storage:link');
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