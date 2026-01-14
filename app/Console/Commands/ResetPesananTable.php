<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class ResetPesananTable extends Command
{
    protected $signature = 'reset:pesanan-tables';
    protected $description = 'Drop and recreate pesanan and pesanan_item tables from scratch';

    public function handle()
    {
        $this->warn('⚠️  This will DELETE all pesanan data! Continue? (yes/no)');
        if (!$this->confirm('Do you want to continue?')) {
            $this->info('Cancelled.');
            return 0;
        }

        try {
            $this->info('Dropping foreign keys and tables...');
            
            // Drop pesanan_item first (has FK to pesanan)
            DB::statement('DROP TABLE IF EXISTS `pesanan_item`');
            $this->info('✓ Dropped pesanan_item');

            // Drop pesanan
            DB::statement('DROP TABLE IF EXISTS `pesanan`');
            $this->info('✓ Dropped pesanan');

            // Create pesanan table
            $this->info('Creating pesanan table...');
            DB::statement('
                CREATE TABLE `pesanan` (
                  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
                  `nomor_invoice` varchar(120) NOT NULL UNIQUE,
                  `pembeli_id` bigint unsigned NOT NULL,
                  `total` bigint NOT NULL,
                  `status` enum("pending","dibayar","dikirim","selesai","dibatalkan") NOT NULL DEFAULT "pending",
                  `catatan` varchar(255) DEFAULT NULL,
                  `alamat_kirim` varchar(255) NOT NULL,
                  `ongkir` bigint NOT NULL DEFAULT 0,
                  `metode_pembayaran` enum("Bayar Ditempat","Transfer") NOT NULL,
                  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
                  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
                  PRIMARY KEY (`id`),
                  UNIQUE KEY `UK_nomor_invoice` (`nomor_invoice`),
                  KEY `FK_pesanan_users` (`pembeli_id`),
                  CONSTRAINT `FK_pesanan_users` FOREIGN KEY (`pembeli_id`) REFERENCES `users` (`id`)
                ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci
            ');
            $this->info('✓ Created pesanan');

            // Create pesanan_item table
            $this->info('Creating pesanan_item table...');
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
            $this->info('✓ Created pesanan_item');

            // Verify
            $this->info('\n✓✓✓ SUCCESS! ✓✓✓');
            $this->info('\nPesanan table columns:');
            $this->listColumns('pesanan');
            
            $this->info('\nPesanan_item table columns:');
            $this->listColumns('pesanan_item');

            return 0;
        } catch (\Exception $e) {
            $this->error('✗ ERROR: ' . $e->getMessage());
            return 1;
        }
    }

    private function listColumns($table)
    {
        $columns = DB::getSchemaBuilder()->getColumnListing($table);
        foreach ($columns as $col) {
            $this->line("  ✓ $col");
        }
    }
}
