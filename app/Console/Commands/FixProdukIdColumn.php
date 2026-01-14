<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class FixProdukIdColumn extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'fix:pesanan-item-table {--recreate : Drop and recreate table}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Fix pesanan_item table structure - add missing columns or recreate';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('=== Fixing pesanan_item Table ===\n');

        if (!Schema::hasTable('pesanan_item')) {
            $this->error('✗ Table pesanan_item does not exist!');
            return 1;
        }

        $this->info('✓ Table pesanan_item exists');

        // Get current columns
        $currentColumns = DB::getSchemaBuilder()->getColumnListing('pesanan_item');
        $requiredColumns = ['id', 'pesanan_id', 'produk_id', 'nama_produk', 'sku', 'jumlah', 'harga_unit', 'subtotal', 'metode', 'status', 'bukti', 'created_at', 'updated_at'];

        $missingColumns = array_diff($requiredColumns, $currentColumns);

        if (empty($missingColumns) && !$this->option('recreate')) {
            $this->info('✓ All required columns exist');
            $this->listColumns($currentColumns);
            return 0;
        }

        if ($this->option('recreate')) {
            $this->info('Dropping and recreating table...');
            try {
                DB::statement('DROP TABLE IF EXISTS `pesanan_item`');
                $this->createTable();
                $this->info('✓ Table recreated successfully!');
                return 0;
            } catch (\Exception $e) {
                $this->error('✗ Error recreating table: ' . $e->getMessage());
                return 1;
            }
        }

        // Try to add missing columns
        if (!empty($missingColumns)) {
            $this->warn('Missing columns: ' . implode(', ', $missingColumns));
            $this->info('Adding missing columns...');

            foreach ($missingColumns as $col) {
                try {
                    $this->addColumn($col);
                    $this->info("✓ Added column: $col");
                } catch (\Exception $e) {
                    $this->error("✗ Failed to add $col: " . $e->getMessage());
                }
            }
        }

        // List final structure
        $this->info('\n✓ Final table structure:');
        $finalColumns = DB::getSchemaBuilder()->getColumnListing('pesanan_item');
        $this->listColumns($finalColumns);

        return 0;
    }

    private function addColumn($column)
    {
        switch ($column) {
            case 'produk_id':
                DB::statement('ALTER TABLE `pesanan_item` ADD COLUMN `produk_id` BIGINT UNSIGNED NULL AFTER `pesanan_id`');
                break;
            case 'nama_produk':
                DB::statement('ALTER TABLE `pesanan_item` ADD COLUMN `nama_produk` VARCHAR(255) NOT NULL AFTER `produk_id`');
                break;
            case 'sku':
                DB::statement('ALTER TABLE `pesanan_item` ADD COLUMN `sku` VARCHAR(255) NOT NULL AFTER `nama_produk`');
                break;
            case 'bukti':
                DB::statement('ALTER TABLE `pesanan_item` ADD COLUMN `bukti` VARCHAR(255) NULL AFTER `status`');
                break;
        }
    }

    private function createTable()
    {
        DB::statement('
            CREATE TABLE `pesanan_item` (
              `id` bigint unsigned NOT NULL AUTO_INCREMENT,
              `pesanan_id` bigint unsigned NOT NULL,
              `produk_id` bigint unsigned DEFAULT NULL,
              `nama_produk` varchar(255) NOT NULL,
              `sku` varchar(255) NOT NULL,
              `jumlah` int NOT NULL,
              `harga_unit` bigint NOT NULL,
              `subtotal` bigint NOT NULL,
              `metode` enum(\'Bayar Ditempat\',\'Transfer\') CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
              `status` enum(\'pending\',\'berhasil\',\'gagal\') NOT NULL DEFAULT \'pending\',
              `bukti` varchar(255) DEFAULT NULL,
              `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
              `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
              PRIMARY KEY (`id`),
              KEY `FK_pesanan_id_pesanan` (`pesanan_id`),
              KEY `FK_pesanan_item_produk` (`produk_id`),
              CONSTRAINT `FK_pesanan_id_pesanan` FOREIGN KEY (`pesanan_id`) REFERENCES `pesanan` (`id`) ON DELETE CASCADE,
              CONSTRAINT `FK_pesanan_item_produk` FOREIGN KEY (`produk_id`) REFERENCES `produk` (`id`) ON DELETE RESTRICT
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci
        ');
    }

    private function listColumns($columns)
    {
        foreach ($columns as $col) {
            $this->line("  - $col");
        }
    }
}

