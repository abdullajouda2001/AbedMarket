<?php

use App\Http\Controllers\Admin\CategoriesController;
use App\Http\Controllers\Admin\CustomerController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\OrderController as AdminOrderController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\TransactionController;
use App\Http\Controllers\Customer\CartController;
use App\Http\Controllers\CustomerDashboardController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\StoreController;
use App\Http\Controllers\Client\ClientController;
use App\Http\Controllers\Client\AuthController;
use Illuminate\Support\Facades\Route;

// --- المسارات العامة للمتجر ---
Route::get('/', [StoreController::class, 'index'])->name('home');

// المسارات المفصولة لمنع التداخل
Route::get('/product/{id}', [StoreController::class, 'show'])->name('product.show'); 
Route::get('/category/{id}', [StoreController::class, 'showCategoryProducts'])->name('category.show');

Route::get('/search', [StoreController::class, 'search'])->name('products.search.public');

// --- مسارات السلة والطلبات ---
Route::post('/cart/add', [CartController::class, 'addToCart'])->name('cart.add');
Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
Route::delete('/cart/remove/{id}', [CartController::class, 'remove'])->name('cart.remove');
Route::post('/checkout', [OrderController::class, 'checkout'])->name('checkout.store');
Route::get('/my-orders', [OrderController::class, 'index'])->name('orders.index');

// --- مسارات الإدارة (Admin) ---
Route::middleware(['auth', 'role:admin'])->prefix('admin')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');
    Route::resource('categories', CategoriesController::class);

    Route::get('/products/search', [ProductController::class, 'search'])->name('products.search');
    Route::resource('products', ProductController::class);
    
    Route::get('transactions', [TransactionController::class, 'index']);
    Route::resource('customer', CustomerController::class);

    Route::post('customer/{id}/invoice', [InvoiceController::class, 'store'])->name('invoice.store');
    Route::put('invoice/{id}', [InvoiceController::class, 'update'])->name('invoice.update');
    Route::delete('invoice/{id}', [InvoiceController::class, 'destroy'])->name('invoice.destroy');

    Route::post('customer/{id}/payment', [PaymentController::class, 'store'])->name('payment.store');
    Route::put('payment/{id}', [PaymentController::class, 'update'])->name('payment.update');
    Route::delete('payment/{id}', [PaymentController::class, 'destroy'])->name('payment.destroy');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    
    Route::get('/orders', [AdminOrderController::class, 'index'])->name('admin.orders.index');
    Route::get('/orders/{id}', [AdminOrderController::class, 'show'])->name('admin.orders.show');
    Route::post('/orders/{id}/status', [AdminOrderController::class, 'updateStatus'])->name('admin.orders.updateStatus');
    Route::delete('/orders/{id}', [AdminOrderController::class, 'destroy'])->name('admin.orders.destroy');
});

// --- مسارات العميل (Customer/Client) ---
Route::middleware(['auth', 'role:customer'])->group(function () {
    Route::get('/my-account', [CustomerDashboardController::class, 'index'])->name('customer.dashboard');
});

Route::middleware(['auth', 'role:customer'])->prefix('client')->name('client.')->group(function () {
    Route::get('/dashboard', [ClientController::class, 'index'])->name('dashboard');
    Route::get('/orders', [ClientController::class, 'indexOrders'])->name('orders');
    Route::get('/order/{id}', [ClientController::class, 'showOrder'])->name('order.show');
});

// مسارات تسجيل الدخول
Route::get('/client/login', [AuthController::class, 'showLoginForm'])->name('client.login');
Route::post('/client/login', [AuthController::class, 'login']);

require __DIR__.'/auth.php';