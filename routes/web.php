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
    // Buyer flows (only users with role 'buyer')
    Route::get('/produk/{produk}/buy', [PesananController::class, 'create'])->name('orders.create')->middleware('buyer');
    Route::post('/produk/{produk}/buy', [PesananController::class, 'store'])->name('orders.store')->middleware('buyer');
    Route::get('/my-orders', [PesananController::class, 'indexForBuyer'])->name('orders.buyer.index');
    Route::get('/orders/{order}', [PesananController::class, 'show'])->name('orders.show');

    // Pegawai (admin) area - seller role can manage products
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

// Debug routes (remove in production)
Route::get('/debug/user', function () {
    $user = auth()->user();
    if (!$user) {
        return response()->json(['message' => 'Not logged in'], 401);
    }
    
    return response()->json([
        'id' => $user->id,
        'name' => $user->name,
        'email' => $user->email,
        'role' => $user->role,
        'peran' => $user->peran,
        'is_buyer' => strtolower($user->role ?? 'buyer') === 'buyer',
    ]);
});

// AUTO-FIX Database route - accessible from browser
Route::get('/fix-database', function () {
    try {
        \Illuminate\Support\Facades\DB::statement('DROP TABLE IF EXISTS `pesanan_item`');
        
        \Illuminate\Support\Facades\DB::statement('
            CREATE TABLE `pesanan_item` (
              `id` bigint unsigned NOT NULL AUTO_INCREMENT,
              `pesanan_id` bigint unsigned NOT NULL,
              `produk_id` bigint unsigned,
              `nama_produk` varchar(255) NOT NULL,
              `sku` varchar(255) NOT NULL,
              `jumlah` int NOT NULL,
              `harga_unit` bigint NOT NULL,
              `subtotal` bigint NOT NULL,
              `metode` enum("Bayar Ditempat","Transfer") NOT NULL,
              `status` enum("pending","berhasil","gagal") NOT NULL DEFAULT "pending",
              `bukti` varchar(255),
              `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
              `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
              PRIMARY KEY (`id`),
              KEY `FK_pesanan_id_pesanan` (`pesanan_id`),
              KEY `FK_pesanan_item_produk` (`produk_id`),
              CONSTRAINT `FK_pesanan_id_pesanan` FOREIGN KEY (`pesanan_id`) REFERENCES `pesanan` (`id`) ON DELETE CASCADE,
              CONSTRAINT `FK_pesanan_item_produk` FOREIGN KEY (`produk_id`) REFERENCES `produk` (`id`) ON DELETE RESTRICT
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci
        ');
        
        $columns = \Illuminate\Support\Facades\DB::getSchemaBuilder()->getColumnListing('pesanan_item');
        
        return response()->json([
            'status' => 'success',
            'message' => 'Database fixed successfully!',
            'table' => 'pesanan_item',
            'columns' => $columns,
        ]);
    } catch (\Exception $e) {
        return response()->json([
            'status' => 'error',
            'message' => $e->getMessage(),
        ], 500);
    }
});

require __DIR__ . '/auth.php';
