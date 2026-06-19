<?php


use App\Http\Controllers\Admin\CategoriesController;
use App\Http\Controllers\Admin\CustomerController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\OrderController as AdminOrderController; // اسم مستعار
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\TransactionController;
use App\Http\Controllers\Customer\CartController;
use App\Http\Controllers\Customer\OrderController as CustomerOrderController; // اسم مستعار
use App\Http\Controllers\CustomerDashboardController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\ProfileController; // أضفتها لأنها كانت ناقصة في الـ use
use App\Http\Controllers\StoreController;
use Illuminate\Support\Facades\Route;

// مسارات الإدارة
Route::middleware(['auth'])->prefix('admin')->group(function () {
Route::resource('categories',CategoriesController::class);  
Route::get('/dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');
    Route::resource('products', ProductController::class);
    Route::get('/admin/products/search', [ProductController::class, 'search'])->name('products.search');
    Route::resource('orders', AdminOrderController::class); // استخدم الاسم المستعار
    Route::get('transactions', [TransactionController::class, 'index']);
  Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    //  Route::get('customers',[CustomerController::class,'index'])->name('customer.index');
//    Route::resource('customer', CustomerController::class);
// Route::resource('customer', CustomerController::class)->names([
//     'index'   => 'customers.index',
//     'create'  => 'customers.create',
//     'store'   => 'customers.store',
//     'edit'    => 'customers.edit',
//     'update'  => 'customers.update',
//     'destroy' => 'customers.destroy',
// ]);
Route::get('customer', [CustomerController::class, 'index'])->name('customer.index');
    Route::get('customer/create', [CustomerController::class, 'create'])->name('customer.create');
    Route::post('customer', [CustomerController::class, 'store'])->name('customer.store');
    
    // روابط التعديل الجديدة
    Route::get('customer/{id}/edit', [CustomerController::class, 'edit'])->name('customer.edit');
    Route::put('customer/{id}', [CustomerController::class, 'update'])->name('customer.update');
  Route::get('customer/{id}', [CustomerController::class, 'show'])->name('customer.show');  
    // رابط الحذف
    Route::delete('customer/{id}', [CustomerController::class, 'destroy'])->name('customer.destroy');});
Route::get('/', [StoreController::class, 'index'])->name('home');
Route::post('customer/{id}/invoice', [InvoiceController::class, 'store'])->name('invoice.store');
// أضف هذا المسار بجانب مسار الفاتورة
Route::post('customer/{id}/payment', [PaymentController::class, 'store'])->name('payment.store');
// // 2. واجهة الزبون (تحتاج تسجيل دخول فقط)
Route::middleware(['auth'])->group(function () {
    Route::get('/my-account', [CustomerDashboardController::class, 'index'])->name('customer.dashboard');
});
// مسارات الزبون
// Route::middleware(['auth'])->prefix('customer')->group(function () {
//     Route::get('/profile', [ProfileController::class, 'index']);
//     Route::get('/orders', [CustomerOrderController::class, 'index']); // استخدم الاسم المستعار
//     Route::post('/cart/add', [CartController::class, 'store']);
// });
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// Route::view('admin/')
require __DIR__.'/auth.php';
