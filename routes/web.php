<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProdukController;
use App\Http\Controllers\PesananController;
use App\Http\Controllers\PegawaiProdukController;
use App\Http\Controllers\AdminPesananController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\BarangController;
use App\Http\Controllers\PegawaiController;
use App\Http\Controllers\DashboardController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Landing / Auth
use App\Http\Controllers\AuthController;

Route::get('/', [AuthController::class, 'landing'])->name('home');
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register'])->name('register.post');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Public shop
Route::get('/shop', [ProdukController::class, 'index'])->name('shop.index');
Route::get('/produk/{produk}', [ProdukController::class, 'show'])->name('produk.show');

// Protected routes for authenticated users
Route::middleware(['auth'])->group(function () {
    // Buyer flows (only users with role 'pembeli')
    Route::get('/produk/{produk}/buy', [PesananController::class, 'create'])->name('orders.create')->middleware('buyer');
    Route::post('/produk/{produk}/buy', [PesananController::class, 'store'])->name('orders.store')->middleware('buyer');
    Route::get('/my-orders', [PesananController::class, 'indexForBuyer'])->name('orders.buyer.index');
    Route::get('/orders/{order}', [PesananController::class, 'show'])->name('orders.show');

    // Pegawai (admin) area - simple role gatixx`xng can be added later
    Route::prefix('pegawai')->group(function () {
        Route::get('/produk', [PegawaiProdukController::class, 'index'])->name('pegawai.produk.index');
        Route::get('/produk/create', [PegawaiProdukController::class, 'create'])->name('pegawai.produk.create');
        Route::post('/produk', [PegawaiProdukController::class, 'store'])->name('pegawai.produk.store');
        Route::get('/produk/{produk}/edit', [PegawaiProdukController::class, 'edit'])->name('pegawai.produk.edit');
        Route::put('/produk/{produk}', [PegawaiProdukController::class, 'update'])->name('pegawai.produk.update');
        Route::patch('/produk/{produk}/stock', [PegawaiProdukController::class, 'updateStock'])->name('pegawai.produk.update-stock');
        Route::delete('/produk/{produk}', [PegawaiProdukController::class, 'destroy'])->name('pegawai.produk.destroy');
        Route::post('/kategori', [PegawaiProdukController::class, 'storeKategori'])->name('pegawai.kategori.store');

        // Orders management
        Route::get('/orders', [AdminPesananController::class, 'index'])->name('pegawai.orders.index');
        Route::get('/orders/{order}', [AdminPesananController::class, 'show'])->name('pegawai.orders.show');
        Route::post('/orders/{order}/status', [AdminPesananController::class, 'updateStatus'])->name('pegawai.orders.updateStatus');
    });
});

// keep legacy endpoints if present
Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard.index');

require __DIR__ . '/auth.php';
