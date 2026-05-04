<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\ShopController;
use App\Http\Controllers\CartController;
use Illuminate\Support\Facades\Route;

// Auth Routes (Manual - Laravel 11)
Route::get('/login', function() { return view('auth.login'); })->name('login');
Route::get('/register', function() { return view('auth.register'); })->name('register');
Route::get('/password/reset', function() { return view('auth.login'); })->name('password.request');

// Homepage
Route::get('/', [HomeController::class, 'index'])->name('home');

// Shop
Route::get('/shop', [ShopController::class, 'index'])->name('shop.index');
Route::get('/shop/{slug}', [ShopController::class, 'show'])->name('shop.show');

// Cart
Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
Route::post('/cart/add', [CartController::class, 'add'])->name('cart.add');
Route::post('/cart/update', [CartController::class, 'update'])->name('cart.update');
Route::post('/cart/destroy', [CartController::class, 'destroy'])->name('cart.destroy');
Route::post('/cart/coupon', function() {
    return redirect()->back()->with('error', 'Coupon feature coming soon!');
})->name('cart.coupon');

// Checkout (placeholder)
Route::get('/checkout', function() {
    return view('checkout.index');
})->name('checkout.index');

// Wishlist
Route::get('/wishlist', [App\Http\Controllers\WishlistController::class, 'index'])->name('wishlist.index');
Route::post('/wishlist/add', [App\Http\Controllers\WishlistController::class, 'add'])->name('wishlist.add');
Route::post('/wishlist/remove', [App\Http\Controllers\WishlistController::class, 'remove'])->name('wishlist.remove');
Route::post('/wishlist/toggle', [App\Http\Controllers\WishlistController::class, 'toggle'])->name('wishlist.toggle');

// Reviews
Route::post('/products/{product}/reviews', [App\Http\Controllers\ReviewController::class, 'store'])->name('reviews.store');

// Static Pages
Route::get('/about', [App\Http\Controllers\PageController::class, 'about'])->name('about');
Route::get('/contact', [App\Http\Controllers\PageController::class, 'contact'])->name('contact');
Route::post('/contact', [App\Http\Controllers\PageController::class, 'contactSubmit'])->name('contact.submit');
Route::get('/faq', [App\Http\Controllers\PageController::class, 'faq'])->name('faq');
Route::get('/shipping-policy', [App\Http\Controllers\PageController::class, 'shipping'])->name('shipping');
Route::get('/returns-policy', [App\Http\Controllers\PageController::class, 'returns'])->name('returns');
Route::get('/privacy-policy', [App\Http\Controllers\PageController::class, 'privacy'])->name('privacy');
Route::get('/terms-conditions', [App\Http\Controllers\PageController::class, 'terms'])->name('terms');
