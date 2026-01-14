<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class DatabaseFixServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        try {
            // Ensure pesanan_item table exists with proper structure
            if (!Schema::hasTable('pesanan_item')) {
                $this->createPesananItemTable();
            } else {
                // Check and add missing columns
                $this->fixMissingColumns();
            }
        } catch (\Exception $e) {
            // Silently fail - will try again on next request
        }
    }

    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    private function createPesananItemTable()
    {
        DB::statement('
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
    }

    private function fixMissingColumns()
    {
        $requiredColumns = ['nama_produk', 'sku', 'jumlah', 'harga_unit', 'subtotal', 'metode'];
        $currentColumns = DB::getSchemaBuilder()->getColumnListing('pesanan_item');

        foreach ($requiredColumns as $col) {
            if (!in_array($col, $currentColumns)) {
                try {
                    $this->addColumn($col);
                } catch (\Exception $e) {
                    // Column might already exist or other issue
                }
            }
        }
    }

    private function addColumn($column)
    {
        switch ($column) {
            case 'nama_produk':
                DB::statement('ALTER TABLE `pesanan_item` ADD COLUMN `nama_produk` VARCHAR(255) NOT NULL');
                break;
            case 'sku':
                DB::statement('ALTER TABLE `pesanan_item` ADD COLUMN `sku` VARCHAR(255) NOT NULL');
                break;
            case 'jumlah':
                DB::statement('ALTER TABLE `pesanan_item` ADD COLUMN `jumlah` INT NOT NULL');
                break;
            case 'harga_unit':
                DB::statement('ALTER TABLE `pesanan_item` ADD COLUMN `harga_unit` BIGINT NOT NULL');
                break;
            case 'subtotal':
                DB::statement('ALTER TABLE `pesanan_item` ADD COLUMN `subtotal` BIGINT NOT NULL');
                break;
            case 'metode':
                DB::statement('ALTER TABLE `pesanan_item` ADD COLUMN `metode` ENUM("Bayar Ditempat","Transfer") NOT NULL');
                break;
        }
    }
}

