<?php

use App\Livewire\Cart;
use App\Livewire\Checkout;
use App\Livewire\HomePage;
use App\Livewire\ProductCatalog;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;

Route::get('/', HomePage::class)->name('home');
Route::get('/products', ProductCatalog::class)->name('product-catalog');
Route::get('/product/{product:slug}', [ProductController::class, 'show'])->name('product');
Route::get('/cart', Cart::class)->name('cart');
Route::get('/checkout', Checkout::class)->name('checkout');
Route::view('/order-confirmed', 'pages.order-confirmed')->name('order-confirmed');
Route::view('/page', 'pages.page')->name('page');
