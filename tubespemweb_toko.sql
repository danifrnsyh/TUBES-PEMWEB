-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Server version:               8.0.30 - MySQL Community Server - GPL
-- Server OS:                    Win64
-- HeidiSQL Version:             12.11.0.7065
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


-- Dumping database structure for tubespemweb_toko
CREATE DATABASE IF NOT EXISTS `tubespemweb_toko` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci */ /*!80016 DEFAULT ENCRYPTION='N' */;
USE `tubespemweb_toko`;

-- Dumping structure for table tubespemweb_toko.kategori_produk
CREATE TABLE IF NOT EXISTS `kategori_produk` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `nama` varchar(150) NOT NULL,
  `slug` varchar(150) NOT NULL UNIQUE,
  `deskripsi` varchar(250) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UK_slug` (`slug`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Data exporting was unselected.

-- Dumping structure for table tubespemweb_toko.pegawai_profiles
CREATE TABLE IF NOT EXISTS `pegawai_profiles` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint unsigned NOT NULL,
  `nip` varchar(50) NOT NULL,
  `jabatan` varchar(50) NOT NULL,
  `note` varchar(50) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `FK__users` (`user_id`),
  CONSTRAINT `FK__users` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Data exporting was unselected.

-- Dumping structure for table tubespemweb_toko.pengiriman
CREATE TABLE IF NOT EXISTS `pengiriman` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `pesanan_id` bigint unsigned NOT NULL,
  `ekspedisi` varchar(255) NOT NULL,
  `nomor_resi` varchar(255) NOT NULL,
  `status` enum('menunggu','dalam_perjalanan','sampai') NOT NULL DEFAULT 'menunggu',
  `ongkir` bigint NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `FK_pengiriman_pesanan` (`pesanan_id`),
  CONSTRAINT `FK_pengiriman_pesanan` FOREIGN KEY (`pesanan_id`) REFERENCES `pesanan` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Data exporting was unselected.

-- Dumping structure for table tubespemweb_toko.pesanan
CREATE TABLE IF NOT EXISTS `pesanan` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `nomor_invoice` varchar(120) NOT NULL UNIQUE,
  `pembeli_id` bigint unsigned NOT NULL,
  `total` bigint NOT NULL,
  `status` enum('pending','dibayar','dikirim','selesai','dibatalkan') NOT NULL,
  `catatan` varchar(150) NOT NULL,
  `alamat_kirim` varchar(150) NOT NULL,
  `ongkir` bigint NOT NULL DEFAULT 0,
  `metode_pembayaran` enum('Bayar Ditempat','Transfer') NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UK_nomor_invoice` (`nomor_invoice`),
  KEY `FK_pesanan_users` (`pembeli_id`),
  CONSTRAINT `FK_pesanan_users` FOREIGN KEY (`pembeli_id`) REFERENCES `users` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Data exporting was unselected.

-- Dumping structure for table tubespemweb_toko.pesanan_item
CREATE TABLE IF NOT EXISTS `pesanan_item` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `pesanan_id` bigint unsigned NOT NULL,
  `produk_id` bigint unsigned NOT NULL,
  `nama_produk` varchar(255) NOT NULL,
  `sku` varchar(255) NOT NULL,
  `jumlah` int NOT NULL,
  `harga_unit` bigint NOT NULL,
  `subtotal` bigint NOT NULL,
  `metode` enum('Bayar Ditempat','Transfer') CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `status` enum('pending','berhasil','gagal') NOT NULL DEFAULT 'pending',
  `bukti` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `FK_pesanan_id_pesanan` (`pesanan_id`),
  KEY `FK_pesanan_item_produk` (`produk_id`),
  CONSTRAINT `FK_pesanan_id_pesanan` FOREIGN KEY (`pesanan_id`) REFERENCES `pesanan` (`id`) ON DELETE CASCADE,
  CONSTRAINT `FK_pesanan_item_produk` FOREIGN KEY (`produk_id`) REFERENCES `produk` (`id`) ON DELETE RESTRICT
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Data exporting was unselected.

-- Dumping structure for table tubespemweb_toko.produk
CREATE TABLE IF NOT EXISTS `produk` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `penambah_id` bigint unsigned NOT NULL,
  `kategori_id` bigint unsigned NOT NULL,
  `nama` varchar(255) NOT NULL,
  `deskripsi` varchar(255) NOT NULL,
  `sku` varchar(255) NOT NULL UNIQUE,
  `harga` bigint NOT NULL,
  `stok` int NOT NULL,
  `berat_gram` int NOT NULL,
  `dimensi` varchar(100) NOT NULL,
  `gambar_utama` varchar(255) NOT NULL,
  `status` enum('aktif','nonaktif','habis') NOT NULL DEFAULT 'aktif',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UK_sku` (`sku`),
  KEY `FK_produk_kategori_produk` (`kategori_id`),
  KEY `FK_produk_users` (`penambah_id`),
  CONSTRAINT `FK_produk_kategori_produk` FOREIGN KEY (`kategori_id`) REFERENCES `kategori_produk` (`id`),
  CONSTRAINT `FK_produk_users` FOREIGN KEY (`penambah_id`) REFERENCES `users` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Data exporting was unselected.

-- Dumping structure for table tubespemweb_toko.produk_gambar
CREATE TABLE IF NOT EXISTS `produk_gambar` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `produk_id` bigint unsigned NOT NULL,
  `path` varchar(255) NOT NULL,
  `urutan` int NOT NULL DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `FK_produk_gambar_produk` (`produk_id`),
  CONSTRAINT `FK_produk_gambar_produk` FOREIGN KEY (`produk_id`) REFERENCES `produk` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Data exporting was unselected.

-- Dumping structure for table tubespemweb_toko.users
CREATE TABLE IF NOT EXISTS `users` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `nama` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `peran` enum('Pegawai','Pembeli') CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL DEFAULT 'Pembeli',
  `telepon` int DEFAULT NULL,
  `alamat` text,
  `email_terverifikasi_pada` timestamp NULL DEFAULT NULL,
  `remember_token` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Data exporting was unselected.

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;

buat seluruh isi folder ini menjadi folder website profesional untuk website furnitur (toko kebutuhan rumah seperti meja, kasur, sofa dll). disini ada 2 pov yaitu buyer dan pegawai. buyer bisa membeli dan memesan (ketika dipesan ada bon transaksi). pov pegawai bisa crud, menambah, menghapus produkm, mengubah stok, melihat pesanan yang sudah dipesan pembeli dll. buat  semuanya dengan template file php sebelumnya dan menggunakan database sebelumnya