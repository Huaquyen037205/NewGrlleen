<?php

use App\Http\Controllers\PageController;
use App\Http\Controllers\MostViewController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ListController;
use App\Http\Controllers\AdminUserController;
use App\Http\Controllers\PaymentController;
use App\Http\Middleware\CheckAdmin;
use Illuminate\Support\Facades\Route;

Route::get('/', [PageController::class, 'home'])->name('home');
Route::get('/category/{id}', [PageController::class, 'category'])->name('category');
Route::get('/search', [MostViewController::class, 'search'])->name('search');
Route::get('/detail/{id}', [ProductController::class, 'detail'])->name('detail');
Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
Route::post('/cart', [CartController::class, 'add'])->name('cart.add');
Route::post('/cart/update', [CartController::class, 'update'])->name('cart.update');
Route::post('/cart/remove', [CartController::class, 'remove'])->name('cart.remove');
Route::get('/contact', [PageController::class, 'contact'])->name('contact');

Route::middleware('auth')->group(function () {
    Route::get('/payment/success', [PaymentController::class, 'paymentSuccess'])->name('payment.success');
    Route::post('/cart/buy-now', [CartController::class, 'buyNow'])->name('cart.buyNow');
    Route::get('/payment', [PaymentController::class, 'payment'])->name('payment');
    Route::post('/payment', [PaymentController::class, 'CodPay'])->name('payment.cod');
    Route::get('/payment/vnpay', [PaymentController::class, 'createVnPay'])->name('payment.vnpay');
    Route::get('/payment/vnpay/callback', [PaymentController::class, 'vnpayCallback'])->name('payment.vnpay.callback');

    Route::get('/address', [PageController::class, 'address'])->name('address');
    Route::post('/profile/address/add', [PageController::class, 'newAddress'])->name('profile.address.add');
    Route::post('/profile/address/default/{id}', [PageController::class, 'setDefaultAddress'])->name('profile.address.default');
    Route::get('/profile/orders', [PaymentController::class, 'orderList'])->name('profile.order');
    Route::get('/profile/order/{id}', [PaymentController::class, 'orderDetail'])->name('profile.order.detail');
    Route::get('/profile/account', [PageController::class, 'account'])->name('profile.infoAccount');
    Route::put('/profile/account/update/{id}', [AdminUserController::class, 'updateUser'])->name('profile.infoAccount.update');
});


// login log out
Route::get('/register', function () {
    return view('auth.register');
})->name('register');
Route::post('/register', [AuthController::class, 'register'])->name('register.post');

Route::get('/login', function () {
    return view('auth.login');
})->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');

Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::get('/forgot-password', [AuthController::class, 'showForgotPasswordForm'])->name('password.request');
Route::post('/forgot-password', [AuthController::class, 'sendResetLink'])->name('password.email');
Route::get('/reset-password/{token}', [AuthController::class, 'showResetForm'])->name('password.reset');
Route::post('/reset-password', [AuthController::class, 'resetPassword'])->name('password.update');

//admin
Route::get('admin/login', [AdminController::class, 'showLoginForm'])->name('manager.loginAdmin');
Route::post('admin/login', [AdminController::class, 'loginAdmin'])->name('manager.login.post');

Route::prefix('admin')->middleware(CheckAdmin::class)->group(function () {
    Route::get('/', [AdminController::class, 'dashboard'])->name('admin.dashboard');
    Route::get('/dashboard', [ListController::class, 'dashboard'])->name('admin.dashboard');
    Route::get('/dashboard/search', [ListController::class, 'search'])->name('dashboard.search');
    Route::get('/dashboard/fillCategory', [ListController::class, 'fillCategories'])->name('dashboard.fillCategory');

    Route::get('/user', [AdminController::class, 'user'])->name('admin.user');
    Route::get('/user/list', [ListController::class, 'dashboardUser'])->name('admin.user');
    Route::put('/edit/role/{id}', [ListController::class, 'editRoleUser'])->name('admin.user.role');
    Route::put('/edit/active/{id}', [ListController::class, 'editActiveUser'])->name('admin.user.active');

    Route::get('/products/list', [ListController::class, 'dashboardProduct'])->name('admin.products.list');
    Route::post('/add/product', [ListController::class, 'addProduct'])->name('admin.product.store');
    Route::get('/search/product', [ListController::class, 'searchProduct'])->name('admin.product.search');
    Route::put('/edit/product/{id}', [ListController::class, 'editProduct'])->name('admin.product.edit');
    Route::get('/product/detail/{id}', [ListController::class, 'productDetail'])->name('admin.productDetail');

    Route::post('/add/variant', [ListController::class, 'addVariant'])->name('variants.store');
    Route::put('/edit/variant/{id}', [ListController::class, 'editVariant'])->name('variants.update');

    Route::get('/category/list', [ListController::class, 'categoryDasboard'])->name('admin.category.list');
    Route::post('/add/category', [ListController::class, 'addCategory'])->name('admin.category.store');
    Route::post('/edit/category/{id}', [ListController::class, 'editCategory'])->name('admin.category.edit');
    Route::post('/edit/category/status/{id}', [ListController::class, 'editCategoryStatus'])->name('admin.category.status');

    Route::get('/orders/list', [ListController::class, 'orderDasboard'])->name('admin.order');
    Route::get('/orders/detail/{id}', [ListController::class, 'orderDetail'])->name('admin.orderDetail');
    Route::put('/orders/update-status/{id}', [ListController::class, 'editOrderStatus'])->name('admin.orders.updateStatus');
});


