<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\CartController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ShopController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\WishlistController;
use App\Http\Middleware\AuthAdmin;

// Route::get('/', function () {
//     return view('welcome');
// });

Auth::routes();

Route::get('/', [HomeController::class, 'index'])->name('home.index');
Route::get('/shop', [ShopController::class, 'index'])->name('shop.index');
Route::get('/shop/{product_slug}', [ShopController::class, 'product_details'])->name('shop.product_details');

// add to cart
Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
Route::post('/cart/add', [CartController::class, 'add_to_cart'])->name('cart.add');
Route::put('/cart/increase_quantity/{rowId}', [CartController::class, 'increase_cart_quantity'])->name('cart.qty.increase');
Route::put('/cart/decrease_quantity/{rowId}', [CartController::class, 'decrease_cart_quantity'])->name('cart.qty.decrease');
Route::delete('/cart/delete/item/{rowId}', [CartController::class, 'remove_item'])->name('cart.delete.item');
Route::delete('/cart/clear', [CartController::class, 'empty_cart'])->name('cart.empty');

// add wishlish
Route::post('/wishlist/add', [WishlistController::class, 'add_to_wishlist'])->name('wishlist.add');

Route::middleware('auth')->group(function(){
    Route::get('/account_dashboard', [UserController::class, 'index'])->name('user.index');
});

Route::middleware('auth', AuthAdmin::class)->group(function(){
    Route::get('/admin', [AdminController::class, 'index'])->name('admin.index');

    // brand
    Route::get('/admin/brand', [AdminController::class, 'brands'])->name('admin.brands');
    Route::get('/admin/brand/add', [AdminController::class, 'add_brand'])->name('admin.brand_add');
    Route::post('/admin/brand/store', [AdminController::class, 'brand_store'])->name('admin.brand_store');
    Route::get('/admin/brand/edit/{id}', [AdminController::class, 'brand_edit'])->name('admin.brand_edit');
    Route::put('/admin/brand/update', [AdminController::class, 'brand_update'])->name('admin.brand_update');
    Route::delete('/admin/brand/delete/{id}', [AdminController::class, 'brand_delete'])->name('admin.brand_delete');

    // categories
    Route::get('/admin/categories', [AdminController::class, 'categories'])->name('admin.categories');
    Route::get('/admin/category_add', [AdminController::class, 'category_add'])->name('admin.category_add');
    Route::post('/admin/category_store', [AdminController::class, 'category_store'])->name('admin.category_store');
    Route::get('/admin/category_edit/{id}', [AdminController::class, 'category_edit'])->name('admin.category_edit');
    Route::put('/admin/category/update', [AdminController::class, 'category_update'])->name('admin.category_update');
    Route::delete('/admin/category/delete/{id}', [AdminController::class, 'category_delete'])->name('admin.category_delete');

    // prodcu
    Route::get('/admin/products', [AdminController::class, 'products'])->name('admin.products');
    Route::get('/admin/product/add', [AdminController::class, 'product_add'])->name('admin.product_add');
    Route::post('/admin/product/store', [AdminController::class, 'product_store'])->name('admin.product_store');
    Route::get('/admin/product/edit/{id}', [AdminController::class, 'product_edit'])->name('admin.product_edit');
    Route::put('/admin/product/update', [AdminController::class, 'product_update'])->name('admin.product_update');
    Route::delete('/admin/product/delete/{id}', [AdminController::class, 'product_delete'])->name('admin.product_delete');
});