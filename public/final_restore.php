<?php
// COMPLETE RESTORE EVERYTHING
$host = 'localhost';
$db = 'tubespemweb_toko';
$user = 'root';
$pass = '';

try {
    echo "<pre style='font-size: 12px; line-height: 1.5;'>";
    echo "╔═══════════════════════════════════════════════════════╗\n";
    echo "║        COMPLETE DATABASE RESTORE - ALL DATA          ║\n";
    echo "╚═══════════════════════════════════════════════════════╝\n\n";
    
    // Root connection
    $pdo = new PDO("mysql:host=$host;charset=utf8mb4", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    // Drop and recreate
    echo "Step 1: Dropping old database...\n";
    $pdo->exec("DROP DATABASE IF EXISTS `tubespemweb_toko`");
    echo "✓ Done\n\n";
    
    echo "Step 2: Creating database...\n";
    $pdo->exec("CREATE DATABASE `tubespemweb_toko` CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci");
    echo "✓ Done\n\n";
    
    // Connect to database
    $pdo = new PDO("mysql:host=$host;dbname=$db;charset=utf8mb4", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    // Create tables
    echo "Step 3: Creating tables...\n";
    
    $pdo->exec("CREATE TABLE `users` (
      `id` bigint unsigned NOT NULL AUTO_INCREMENT,
      `nama` varchar(255) NOT NULL,
      `email` varchar(255) NOT NULL UNIQUE,
      `password` varchar(255) NOT NULL,
      `peran` enum('Pegawai','Pembeli') NOT NULL DEFAULT 'Pembeli',
      `telepon` varchar(20) DEFAULT NULL,
      `alamat` text,
      `email_terverifikasi_pada` timestamp NULL DEFAULT NULL,
      `remember_token` varchar(100) DEFAULT NULL,
      `created_at` timestamp NULL DEFAULT NULL,
      `updated_at` timestamp NULL DEFAULT NULL,
      PRIMARY KEY (`id`)
    ) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci");
    echo "✓ users\n";
    
    $pdo->exec("CREATE TABLE `kategori_produk` (
      `id` bigint unsigned NOT NULL AUTO_INCREMENT,
      `nama` varchar(150) NOT NULL,
      `slug` varchar(150) NOT NULL UNIQUE,
      `deskripsi` varchar(250) NOT NULL,
      `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
      `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
      PRIMARY KEY (`id`)
    ) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci");
    echo "✓ kategori_produk\n";
    
    $pdo->exec("CREATE TABLE `produk` (
      `id` bigint unsigned NOT NULL AUTO_INCREMENT,
      `penambah_id` bigint unsigned NOT NULL,
      `kategori_id` bigint unsigned NOT NULL,
      `nama` varchar(255) NOT NULL,
      `deskripsi` varchar(255) NOT NULL,
      `sku` varchar(255) NOT NULL,
      `harga` bigint NOT NULL,
      `stok` int NOT NULL,
      `berat_gram` int NOT NULL,
      `dimensi` varchar(100) NOT NULL,
      `gambar_utama` varchar(255) NOT NULL,
      `status` enum('aktif','nonaktif','habis') NOT NULL DEFAULT 'aktif',
      `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
      `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
      PRIMARY KEY (`id`),
      UNIQUE KEY `uk_sku` (`sku`),
      KEY `kategori_id` (`kategori_id`),
      KEY `penambah_id` (`penambah_id`),
      CONSTRAINT `produk_ibfk_1` FOREIGN KEY (`kategori_id`) REFERENCES `kategori_produk` (`id`),
      CONSTRAINT `produk_ibfk_2` FOREIGN KEY (`penambah_id`) REFERENCES `users` (`id`)
    ) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci");
    echo "✓ produk\n";
    
    $pdo->exec("CREATE TABLE `pesanan` (
      `id` bigint unsigned NOT NULL AUTO_INCREMENT,
      `nomor_invoice` varchar(120) NOT NULL,
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
      UNIQUE KEY `uk_nomor_invoice` (`nomor_invoice`),
      KEY `pembeli_id` (`pembeli_id`),
      CONSTRAINT `pesanan_ibfk_1` FOREIGN KEY (`pembeli_id`) REFERENCES `users` (`id`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci");
    echo "✓ pesanan\n";
    
    $pdo->exec("CREATE TABLE `pesanan_item` (
      `id` bigint unsigned NOT NULL AUTO_INCREMENT,
      `pesanan_id` bigint unsigned NOT NULL,
      `produk_id` bigint unsigned NOT NULL,
      `nama_produk` varchar(255) NOT NULL,
      `sku` varchar(255) NOT NULL,
      `jumlah` int NOT NULL,
      `harga_unit` bigint NOT NULL,
      `subtotal` bigint NOT NULL,
      `metode` enum('Bayar Ditempat','Transfer') NOT NULL,
      `status` enum('pending','berhasil','gagal') NOT NULL DEFAULT 'pending',
      `bukti` varchar(255) DEFAULT NULL,
      `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
      `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
      PRIMARY KEY (`id`),
      KEY `pesanan_id` (`pesanan_id`),
      KEY `produk_id` (`produk_id`),
      CONSTRAINT `pesanan_item_ibfk_1` FOREIGN KEY (`pesanan_id`) REFERENCES `pesanan` (`id`) ON DELETE CASCADE,
      CONSTRAINT `pesanan_item_ibfk_2` FOREIGN KEY (`produk_id`) REFERENCES `produk` (`id`) ON DELETE CASCADE
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci");
    echo "✓ pesanan_item\n";
    
    $pdo->exec("CREATE TABLE `pengiriman` (
      `id` bigint unsigned NOT NULL AUTO_INCREMENT,
      `pesanan_id` bigint unsigned NOT NULL,
      `ekspedisi` varchar(255) NOT NULL,
      `nomor_resi` varchar(255) NOT NULL,
      `status` enum('menunggu','dalam_perjalanan','sampai') NOT NULL DEFAULT 'menunggu',
      `ongkir` bigint NOT NULL,
      `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
      `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
      PRIMARY KEY (`id`),
      KEY `pesanan_id` (`pesanan_id`),
      CONSTRAINT `pengiriman_ibfk_1` FOREIGN KEY (`pesanan_id`) REFERENCES `pesanan` (`id`) ON DELETE CASCADE
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci");
    echo "✓ pengiriman\n";
    
    $pdo->exec("CREATE TABLE `pegawai_profiles` (
      `id` bigint unsigned NOT NULL AUTO_INCREMENT,
      `user_id` bigint unsigned NOT NULL,
      `nip` varchar(50) NOT NULL,
      `jabatan` varchar(50) NOT NULL,
      `note` varchar(50) NOT NULL,
      `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
      `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
      PRIMARY KEY (`id`),
      KEY `user_id` (`user_id`),
      CONSTRAINT `pegawai_profiles_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci");
    echo "✓ pegawai_profiles\n";
    
    $pdo->exec("CREATE TABLE `produk_gambar` (
      `id` bigint unsigned NOT NULL AUTO_INCREMENT,
      `produk_id` bigint unsigned NOT NULL,
      `path` varchar(255) NOT NULL,
      `urutan` int NOT NULL DEFAULT 0,
      `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
      PRIMARY KEY (`id`),
      KEY `produk_id` (`produk_id`),
      CONSTRAINT `produk_gambar_ibfk_1` FOREIGN KEY (`produk_id`) REFERENCES `produk` (`id`) ON DELETE CASCADE
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci");
    echo "✓ produk_gambar\n\n";
    
    // Insert data
    echo "Step 4: Inserting data...\n";
    
    // Users
    $pwd = password_hash('password123', PASSWORD_BCRYPT);
    $pdo->exec("INSERT INTO users (id, nama, email, password, peran, telepon, alamat, created_at, updated_at) VALUES 
    (1, 'Pegawai', 'pegawai@test.com', '$pwd', 'Pegawai', '082234567890', 'Jakarta', NOW(), NOW()),
    (2, 'Pembeli', 'pembeli@test.com', '$pwd', 'Pembeli', '081234567890', 'Jakarta', NOW(), NOW())");
    echo "✓ 2 users (1 Pegawai, 1 Pembeli)\n";
    
    // Kategori
    $pdo->exec("INSERT INTO kategori_produk (id, nama, slug, deskripsi) VALUES 
    (1, 'Meja', 'meja', 'Koleksi meja berkualitas tinggi'),
    (2, 'Kursi', 'kursi', 'Koleksi kursi ergonomis dan nyaman'),
    (3, 'Lemari', 'lemari', 'Koleksi lemari penyimpanan modern'),
    (4, 'Tempat Tidur', 'tempat-tidur', 'Koleksi tempat tidur berkualitas')");
    echo "✓ 4 kategori produk\n";
    
    // Produk
    $produks = [
        ['Meja Makan 6 Kursi Kayu Jati', 'MJ-001', 3500000, 15, 1],
        ['Meja Ruang Tamu Minimalis', 'MJ-002', 2200000, 20, 1],
        ['Meja Kerja Laptop Putih', 'MJ-003', 950000, 18, 1],
        ['Meja Bar Counter Tinggi', 'MJ-004', 1800000, 8, 1],
        ['Kursi Kantor Ergonomis', 'KR-001', 1200000, 25, 2],
        ['Kursi Makan Kayu Natural', 'KR-002', 650000, 30, 2],
        ['Kursi Gaming Pro RGB', 'KR-003', 2500000, 5, 2],
        ['Kursi Ayun Santai Rotan', 'KR-004', 1100000, 12, 2],
        ['Lemari Pakaian 3 Pintu', 'LM-001', 2800000, 6, 3],
        ['Lemari Buku Tinggi Terbuka', 'LM-002', 1500000, 10, 3],
        ['Lemari Dapur Minimalis Putih', 'LM-003', 2100000, 7, 3],
        ['Lemari Hias Display Kaca', 'LM-004', 1300000, 14, 3],
        ['Tempat Tidur Queen Size', 'TT-001', 4500000, 3, 4],
        ['Tempat Tidur Single Besi', 'TT-002', 1800000, 8, 4],
        ['Sofa Ruang Keluarga L-Shaped', 'SF-001', 6200000, 2, 1],
        ['Sofa 2 Seater Minimalis Abu', 'SF-002', 2800000, 6, 1],
        ['Rak Buku 5 Tingkat Kayu', 'RK-001', 900000, 22, 3],
        ['Rak TV Minimalis Mewah', 'RK-002', 1600000, 9, 3],
        ['Cermin Dinding Besar Ukir', 'CD-001', 750000, 16, 2],
        ['Bufet Dapur Kayu Jati', 'BF-001', 3200000, 4, 1],
    ];
    
    $stmt = $pdo->prepare("INSERT INTO produk 
        (penambah_id, kategori_id, nama, deskripsi, sku, harga, stok, berat_gram, dimensi, gambar_utama, status) 
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, 'aktif')");
    
    foreach ($produks as $i => $p) {
        $stmt->execute([
            1, $p[4], $p[0], 'Produk furniture berkualitas tinggi dengan desain modern dan nyaman',
            $p[1], $p[2], $p[3], 5000, '100x60x80',
            'https://via.placeholder.com/400x300?text=' . urlencode($p[0])
        ]);
    }
    echo "✓ 20 produk furniture\n\n";
    
    // Verify
    echo "Step 5: Verification...\n";
    
    $r = $pdo->query("SELECT COUNT(*) as cnt FROM users")->fetch()['cnt'];
    echo "✓ Users: $r\n";
    
    $r = $pdo->query("SELECT COUNT(*) as cnt FROM kategori_produk")->fetch()['cnt'];
    echo "✓ Kategori: $r\n";
    
    $r = $pdo->query("SELECT COUNT(*) as cnt FROM produk WHERE status='aktif'")->fetch()['cnt'];
    echo "✓ Produk aktif: $r\n";
    
    $r = $pdo->query("SELECT COUNT(*) as cnt FROM pesanan_item")->fetch()['cnt'];
    echo "✓ Pesanan_item table: ready\n";
    
    echo "\n╔═══════════════════════════════════════════════════════╗\n";
    echo "║         ✅ COMPLETE RESTORE SUCCESSFUL             ║\n";
    echo "╚═══════════════════════════════════════════════════════╝\n";
    
    echo "\n📝 Test Login:\n";
    echo "  Pegawai: pegawai@test.com / password123\n";
    echo "  Pembeli: pembeli@test.com / password123\n";
    
    echo "\n🔗 Open: http://127.0.0.1:8000/shop\n";
    
    echo "</pre>";
    
} catch (Exception $e) {
    echo "<pre style='color:red; background:#fff0f0; padding:15px;'>❌ ERROR:\n" . $e->getMessage() . "</pre>";
}
?>
