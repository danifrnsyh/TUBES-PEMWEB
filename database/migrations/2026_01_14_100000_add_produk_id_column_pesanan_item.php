<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Add produk_id column if it doesn't exist
        try {
            DB::statement('ALTER TABLE `pesanan_item` ADD COLUMN `produk_id` BIGINT UNSIGNED NULL AFTER `pesanan_id`');
        } catch (\Exception $e) {
            // Column might already exist, continue
        }

        // Try to add foreign key if not exists
        try {
            DB::statement('ALTER TABLE `pesanan_item` ADD CONSTRAINT `fk_pesanan_item_produk` FOREIGN KEY (`produk_id`) REFERENCES `produk`(`id`) ON DELETE RESTRICT');
        } catch (\Exception $e) {
            // FK might already exist, continue
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        try {
            DB::statement('ALTER TABLE `pesanan_item` DROP FOREIGN KEY `fk_pesanan_item_produk`');
        } catch (\Exception $e) {
            // FK might not exist
        }

        try {
            DB::statement('ALTER TABLE `pesanan_item` DROP COLUMN `produk_id`');
        } catch (\Exception $e) {
            // Column might not exist
        }
    }
};
