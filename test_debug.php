<?php

require_once __DIR__ . '/vendor/autoload.php';
require_once __DIR__ . '/bootstrap/app.php';

$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(\Illuminate\Contracts\Http\Kernel::class);

use App\Models\User;
use App\Models\Produk;
use Illuminate\Support\Facades\Auth;

// Get current user if logged in
$user = auth()->user();
if ($user) {
    echo "Current User:\n";
    echo "ID: {$user->id}\n";
    echo "Name: {$user->name}\n";
    echo "Email: {$user->email}\n";
    echo "Role: {$user->role}\n";
    echo "Peran: {$user->peran}\n\n";
} else {
    echo "Not logged in\n\n";
}

// Get all users
echo "All Users:\n";
$users = User::select('id', 'name', 'email', 'role', 'peran')->limit(5)->get();
foreach ($users as $u) {
    echo "- ID: {$u->id}, Name: {$u->name}, Email: {$u->email}, Role: {$u->role}, Peran: {$u->peran}\n";
}

echo "\nAll Products:\n";
$products = Produk::select('id', 'nama', 'sku', 'harga', 'stok', 'status')->limit(5)->get();
foreach ($products as $p) {
    echo "- ID: {$p->id}, Nama: {$p->nama}, SKU: {$p->sku}, Harga: {$p->harga}, Stok: {$p->stok}, Status: {$p->status}\n";
}
