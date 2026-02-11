<?php

use App\Http\Controllers\Frontend\HomeController;
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

// Auth Routes
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

require __DIR__.'/auth.php';

