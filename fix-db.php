<?php
/**
 * Quick Database Fix Script
 * Put this file in public folder dan akses: http://127.0.0.1:8000/fix-db.php
 * 
 * Atau jalankan: php fix-db.php
 */

// Load Laravel
require __DIR__ . '/vendor/autoload.php';
$app = require __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(\Illuminate\Contracts\Http\Kernel::class);

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

echo "=== Database Fix Script ===\n\n";

try {
    echo "[1/3] Checking database connection... ";
    DB::connection()->getPdo();
    echo "✓\n";

    echo "[2/3] Checking pesanan_item table... ";
    if (!Schema::hasTable('pesanan_item')) {
        echo "✗ TABLE NOT FOUND\n";
        exit(1);
    }
    echo "✓\n";

    echo "[3/3] Checking produk_id column... ";
    if (Schema::hasColumn('pesanan_item', 'produk_id')) {
        echo "✓ Column already exists\n";
    } else {
        echo "✗ Missing, adding now... ";
        DB::statement('ALTER TABLE `pesanan_item` ADD COLUMN `produk_id` BIGINT UNSIGNED NULL AFTER `pesanan_id`');
        
        if (Schema::hasColumn('pesanan_item', 'produk_id')) {
            echo "✓\n";
        } else {
            echo "✗ Failed to add\n";
            exit(1);
        }
    }

    echo "\n=== SUCCESS ===\n";
    echo "All checks passed! Column produk_id is ready.\n";
    echo "\nColumns in pesanan_item:\n";
    
    $columns = DB::getSchemaBuilder()->getColumnListing('pesanan_item');
    foreach ($columns as $col) {
        echo "  - $col\n";
    }

    exit(0);
} catch (\Exception $e) {
    echo "\n✗ ERROR: " . $e->getMessage() . "\n";
    exit(1);
}
