<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\WishlistController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\RecentViewController;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Response;

Route::get('/', function () {
    return view('welcome');
});
Route::get('/', [ProductController::class, 'index'])->name('home');
Route::get('/products', [ProductController::class, 'index'])->name('products.index');
Route::get('/products/{id}', [ProductController::class, 'show'])->name('products.show');
Route::get('/product-photo/{filename}', [ProductController::class, 'showPhoto'])->name('product.photo');
Route::get('/upload-images', function () {
    $files = glob(storage_path('app/public/products/*'));
    return response()->json(['files' => $files, 'count' => count($files)]);
});

Route::get('/product-photo/{filename}', function ($filename) {
    $path = 'products/' . $filename;
    if (!Storage::disk('public')->exists($path)) {
        abort(404);
    }
    $file = Storage::disk('public')->get($path);
    $type = Storage::disk('public')->mimeType($path);
    return Response::make($file, 200)->header("Content-Type", $type);
})->name('product.photo');

// ส่ง products ไปให้ dashboard
Route::get('/dashboard', function () {
    $products = \App\Models\Product::latest()->get();
    return view('dashboard', compact('products'));
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    // add profile index.blade
    Route::get('/profile', function () {
        return view('profile.index');
    })->name('profile.index');

    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::patch('/profile/photo/update', [UserController::class, 'updateProfilePhoto'])->name('profile.photo.update');
    Route::get('/profile/photo/{filename}', [UserController::class, 'showProfilePhoto'])->where('filename', '.*')->name('user.photo');

    // Cart
    Route::get('/carts', [CartController::class, 'index'])->name('carts.index');
    Route::post('/carts', [CartController::class, 'store'])->name('carts.store');
    Route::patch('/carts/{id}', [CartController::class, 'update'])->name('carts.update');
    Route::delete('/carts/{id}', [CartController::class, 'destroy'])->name('carts.destroy');

    // Orders
    Route::get('/orders/confirm', [OrderController::class, 'confirm'])->name('orders.confirm');
    Route::post('/orders/confirm', [OrderController::class, 'store'])->name('orders.confirm.store');
    Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');
    Route::get('/orders/{id}', [OrderController::class, 'show'])->name('orders.show');
    Route::post('/orders', [OrderController::class, 'store'])->name('orders.store');
    Route::post('/orders/now', [OrderController::class, 'storeNow'])->name('orders.storeNow');
    Route::patch('orders/{id}/pay', [OrderController::class, 'markAsPaid'])->name('orders.pay');
    Route::patch('orders/{id}/cancel', [OrderController::class, 'cancel'])->name('orders.cancel');
    Route::get('/orders/{id}/edit', [OrderController::class, 'edit'])->name('orders.edit');
    Route::patch('/orders/{id}', [OrderController::class, 'update'])->name('orders.update');

    // Payments
    Route::get('/payments', [PaymentController::class, 'index'])->name('payments.index');
    Route::get('/payments/create/{order_id}', [PaymentController::class, 'create'])->name('payments.create');
    Route::post('/payments', [PaymentController::class, 'store'])->name('payments.store');
    Route::get('/payments/{id}', [PaymentController::class, 'show'])->name('payments.show');

    // Wishlist
    Route::get('/wishlists', [WishlistController::class, 'index'])->name('wishlist.index');
    Route::post('/wishlists', [WishlistController::class, 'store'])->name('wishlist.store');
    Route::post('/wishlists/toggle', [WishlistController::class, 'toggle'])->name('wishlist.toggle');
    Route::delete('/wishlists/{wishlist}', [WishlistController::class, 'destroy'])->name('wishlist.destroy');

    // Recent Views
    Route::get('/recent-views', [RecentViewController::class, 'index'])->name('recentViews.index');

    // Request Seller
    Route::post('/profile/request-seller', function () {
        // อนาคตคุณสามารถเขียน Controller มารับค่าตรงนี้ได้ (เช่น บันทึกลงตาราง seller_requests)
        // สำหรับตอนนี้ ให้ redirect กลับมาพร้อมข้อความแจ้งเตือนสำเร็จ
        return back()->with('success', 'request has been sent! please wait for admin to approve your request');
    })->name('profile.requestSeller');
    });

Route::middleware(['auth', 'admin'])->prefix('admin')->group(function () {
    Route::get('/', [AdminController::class, 'index'])->name('admin.index');
    Route::get('/users', [AdminController::class, 'users'])->name('admin.users');
    Route::patch('/users/{id}/role', [AdminController::class, 'updateRole'])->name('admin.users.updateRole');
    Route::post('/admin/users/add-admin', [AdminController::class, 'storeAdmin'])->name('admin.users.storeAdmin');
    Route::delete('/users/{id}', [AdminController::class, 'destroy'])->name('admin.users.destroy');
    Route::get('/products', [AdminController::class, 'products'])->name('admin.products');
    Route::get('/products/{id}/edit', [ProductController::class, 'edit'])->name('products.edit');
    Route::patch('/products/{id}', [ProductController::class, 'update'])->name('products.update');
    Route::delete('/products/{id}', [AdminController::class, 'destroyProduct'])->name('admin.products.destroy');
    Route::get('/products/create', [ProductController::class, 'create'])->name('products.create');
    Route::post('/products', [ProductController::class, 'store'])->name('products.store');
    Route::get('/orders', [AdminController::class, 'orders'])->name('admin.orders');
    Route::patch('/orders/{id}/packing', [AdminController::class, 'markAsPacking'])->name('admin.orders.packing');
    Route::patch('/orders/{id}/delivering', [AdminController::class, 'markAsDelivering'])->name('admin.orders.delivering');
    Route::patch('/orders/{id}/complete', [AdminController::class, 'markAsComplete'])->name('admin.orders.complete');
    Route::patch('/orders/{id}/processing', [AdminController::class, 'markAsProcessing'])->name('admin.orders.processing');
    Route::patch('/orders/{id}/status', [AdminController::class, 'updateStatus'])->name('admin.orders.updateStatus');
});

require __DIR__.'/auth.php';