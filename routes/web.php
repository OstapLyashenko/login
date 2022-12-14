<?php

use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', [HomeController::class, 'index'])->name('home');


Route::delete(
    'ajax/images/{image}',
    \App\Http\Controllers\Ajax\RemoveImageController::class
)->middleware(['auth', 'admin'])->name('ajax.images.delete');

Route::get('/dashboard', function () {
    return view('dashboard', ['role' => 'Customer']);
})->middleware(['auth'])->name('dashboard');

Auth::routes();

Route::resource('categories', \App\Http\Controllers\CategoriesController::class)->only(['show', 'index']);
Route::resource('products', \App\Http\Controllers\ProductsController::class)->only(['show', 'index']);

Route::get('cart', [\App\Http\Controllers\CartController::class, 'index'])->name('cart');
Route::post('cart/{product}', [\App\Http\Controllers\CartController::class, 'add'])->name('cart.add');
Route::delete('cart', [\App\Http\Controllers\CartController::class, 'remove'])->name('cart.remove');
Route::post('cart/{product}/count', [\App\Http\Controllers\CartController::class, 'countUpdate'])->name('cart.count.update');

Route::name('admin.')->prefix('admin')->middleware(['auth', 'admin'])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard', ['role' => 'Admin']);
    })->name('dashboard');

    Route::resource('products', \App\Http\Controllers\Admin\ProductsController::class)->except(['show']);
});

Route::middleware('auth')->group(function () {
    Route::post('product/{product}/rating/add', [\App\Http\Controllers\ProductsController::class, 'addRating'])->name('product.rating.add');
});
Route::get('wishlist/{product}/add', [\App\Http\Controllers\WishListController::class, 'add'])->name('wishlist.add');
Route::delete('wishlist/{product}/delete', [\App\Http\Controllers\WishListController::class, 'delete'])->name('wishlist.delete');
Route::get('checkout', \App\Http\Controllers\CheckoutController::class)->name('checkout');
Route::post('order', \App\Http\Controllers\OrdersController::class)->name('order.create');

Route::name('account.')->prefix('account')->group(callback: function () {
    Route::get('/', [\App\Http\Controllers\Account\UsersController::class, 'index'])->name('index');
    Route::get('{user}/edit', [\App\Http\Controllers\Account\UsersController::class, 'edit'])
        ->name('edit')
        ->middleware('can:view,user');
    Route::put('{user}', [\App\Http\Controllers\Account\UsersController::class, 'update'])
        ->name('update')
        ->middleware('can:update,user');
    Route::get('wishlist', \App\Http\Controllers\Account\WishListController::class)->name('wishlist');
});
Route::prefix('paypal')->group(function () {
    Route::post('order/create', [\App\Http\Controllers\Payments\PaypalPaymentController::class, 'create']);
    Route::post('order/{orderId}/capture', [\App\Http\Controllers\Payments\PaypalPaymentController::class, 'capture']);
});

