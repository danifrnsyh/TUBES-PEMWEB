-- Drop and recreate pesanan_item table with correct structure

USE `tubespemweb_toko`;

-- Drop existing table
DROP TABLE IF EXISTS `pesanan_item`;

-- Create new table with all required columns
CREATE TABLE `pesanan_item` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `pesanan_id` bigint unsigned NOT NULL,
  `produk_id` bigint unsigned DEFAULT NULL,
  `nama_produk` varchar(255) NOT NULL,
  `sku` varchar(255) NOT NULL,
  `jumlah` int NOT NULL,
  `harga_unit` bigint NOT NULL,
  `subtotal` bigint NOT NULL,
  `metode` enum('Bayar Ditempat','Transfer') CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `status` enum('pending','berhasil','gagal') NOT NULL DEFAULT 'pending',
  `bukti` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `FK_pesanan_id_pesanan` (`pesanan_id`),
  KEY `FK_pesanan_item_produk` (`produk_id`),
  CONSTRAINT `FK_pesanan_id_pesanan` FOREIGN KEY (`pesanan_id`) REFERENCES `pesanan` (`id`) ON DELETE CASCADE,
  CONSTRAINT `FK_pesanan_item_produk` FOREIGN KEY (`produk_id`) REFERENCES `produk` (`id`) ON DELETE RESTRICT
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Verify table creation
SHOW COLUMNS FROM `pesanan_item`;
