<?php
// COMPLETE RESTORE - Database + Data + Fix
$host = 'localhost';
$db = 'tubespemweb_toko';
$user = 'root';
$pass = '';

try {
    echo "<pre style='font-size: 13px; line-height: 1.6;'>";
    echo "╔════════════════════════════════════════════════════╗\n";
    echo "║     COMPLETE DATABASE RESTORE & POPULATION        ║\n";
    echo "╚════════════════════════════════════════════════════╝\n\n";
    
    // Connect root
    $pdo = new PDO("mysql:host=$host;charset=utf8mb4", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    // Step 1: Drop old database
    echo "Step 1: Preparing database...\n";
    $pdo->exec("DROP DATABASE IF EXISTS `tubespemweb_toko`");
    echo "  ✓ Dropped old database\n";
    
    // Step 2: Create database
    $pdo->exec("CREATE DATABASE `tubespemweb_toko` CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci");
    echo "  ✓ Created new database\n\n";
    
    // Connect to database
    $pdo = new PDO("mysql:host=$host;dbname=$db;charset=utf8mb4", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    // Step 3: Create tables
    echo "Step 2: Creating tables...\n";
    
    $pdo->exec("CREATE TABLE `users` (
      `id` bigint unsigned NOT NULL AUTO_INCREMENT,
      `nama` varchar(255) NOT NULL,
      `email` varchar(255) NOT NULL UNIQUE,
      `password` varchar(255) NOT NULL,
      `peran` enum('Pegawai','Pembeli') NOT NULL DEFAULT 'Pembeli',
      `telepon` int DEFAULT NULL,
      `alamat` text,
      `email_terverifikasi_pada` timestamp NULL DEFAULT NULL,
      `remember_token` varchar(100) DEFAULT NULL,
      `created_at` timestamp NULL DEFAULT NULL,
      `updated_at` timestamp NULL DEFAULT NULL,
      PRIMARY KEY (`id`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci");
    echo "  ✓ users table\n";
    
    $pdo->exec("CREATE TABLE `kategori_produk` (
      `id` bigint unsigned NOT NULL AUTO_INCREMENT,
      `nama` varchar(150) NOT NULL,
      `slug` varchar(150) NOT NULL UNIQUE,
      `deskripsi` varchar(250) NOT NULL,
      `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
      `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
      PRIMARY KEY (`id`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci");
    echo "  ✓ kategori_produk table\n";
    
    $pdo->exec("CREATE TABLE `produk` (
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
      KEY `kategori_id` (`kategori_id`),
      KEY `penambah_id` (`penambah_id`),
      CONSTRAINT `produk_kategori` FOREIGN KEY (`kategori_id`) REFERENCES `kategori_produk` (`id`),
      CONSTRAINT `produk_penambah` FOREIGN KEY (`penambah_id`) REFERENCES `users` (`id`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci");
    echo "  ✓ produk table\n";
    
    $pdo->exec("CREATE TABLE `pesanan` (
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
      KEY `pembeli_id` (`pembeli_id`),
      CONSTRAINT `pesanan_pembeli` FOREIGN KEY (`pembeli_id`) REFERENCES `users` (`id`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci");
    echo "  ✓ pesanan table\n";
    
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
      CONSTRAINT `pesanan_item_pesanan` FOREIGN KEY (`pesanan_id`) REFERENCES `pesanan` (`id`) ON DELETE CASCADE,
      CONSTRAINT `pesanan_item_produk` FOREIGN KEY (`produk_id`) REFERENCES `produk` (`id`) ON DELETE CASCADE
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci");
    echo "  ✓ pesanan_item table\n";
    
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
      CONSTRAINT `pengiriman_pesanan` FOREIGN KEY (`pesanan_id`) REFERENCES `pesanan` (`id`) ON DELETE CASCADE
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci");
    echo "  ✓ pengiriman table\n\n";
    
    // Step 4: Insert data
    echo "Step 3: Populating data...\n";
    
    $pwd = password_hash('password123', PASSWORD_BCRYPT);
    
    // Users
    $pdo->exec("INSERT INTO users (nama, email, password, peran, telepon, alamat, created_at, updated_at) VALUES 
    ('Budi Santoso', 'pembeli1@test.com', '$pwd', 'Pembeli', 81234567890, 'Jakarta', NOW(), NOW()),
    ('Siti Aminah', 'pembeli2@test.com', '$pwd', 'Pembeli', 81234567891, 'Bandung', NOW(), NOW()),
    ('Ahmad Manager', 'pegawai@test.com', '$pwd', 'Pegawai', 82234567890, 'Jakarta', NOW(), NOW())");
    echo "  ✓ 3 users (2 pembeli, 1 pegawai)\n";
    
    // Kategori
    $pdo->exec("INSERT INTO kategori_produk (nama, slug, deskripsi) VALUES 
    ('Meja', 'meja', 'Koleksi meja berkualitas'),
    ('Kursi', 'kursi', 'Koleksi kursi ergonomis'),
    ('Lemari', 'lemari', 'Koleksi lemari penyimpanan'),
    ('Tempat Tidur', 'tempat-tidur', 'Koleksi tempat tidur nyaman')");
    echo "  ✓ 4 categories\n";
    
    // Produk
    $produks = [
        ['Meja Makan 6 Kursi Kayu Jati', 'MJ001', 3500000, 15, 1],
        ['Meja Ruang Tamu Minimalis', 'MJ002', 2200000, 20, 1],
        ['Meja Kerja Laptop Putih', 'MJ003', 950000, 18, 1],
        ['Meja Bar Counter', 'MJ004', 1800000, 8, 1],
        ['Kursi Kantor Ergonomis', 'KR001', 1200000, 25, 2],
        ['Kursi Makan Kayu', 'KR002', 650000, 30, 2],
        ['Kursi Gaming Pro', 'KR003', 2500000, 5, 2],
        ['Kursi Ayun Santai', 'KR004', 1100000, 12, 2],
        ['Lemari Pakaian 3 Pintu', 'LM001', 2800000, 6, 3],
        ['Lemari Buku Tinggi', 'LM002', 1500000, 10, 3],
        ['Lemari Dapur Minimalis', 'LM003', 2100000, 7, 3],
        ['Lemari Hias Display', 'LM004', 1300000, 14, 3],
        ['Tempat Tidur Queen Size', 'TT001', 4500000, 3, 4],
        ['Tempat Tidur Single Besi', 'TT002', 1800000, 8, 4],
        ['Sofa Ruang Keluarga L', 'SF001', 6200000, 2, 1],
        ['Sofa 2 Seater Minimalis', 'SF002', 2800000, 6, 1],
        ['Rak Buku 5 Tingkat', 'RK001', 900000, 22, 3],
        ['Rak TV Minimalis', 'RK002', 1600000, 9, 3],
        ['Cermin Dinding Besar', 'CR001', 750000, 16, 2],
        ['Bufet Dapur Kayu', 'BF001', 3200000, 4, 1],
    ];
    
    $stmt = $pdo->prepare("INSERT INTO produk (penambah_id, kategori_id, nama, deskripsi, sku, harga, stok, berat_gram, dimensi, gambar_utama, status) 
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, 'aktif')");
    
    foreach ($produks as $p) {
        $stmt->execute([
            3, $p[4], $p[0], 'Produk furniture berkualitas tinggi', $p[1], $p[2], $p[3], 5000, '100x60x80',
            'https://via.placeholder.com/400x300?text=' . urlencode($p[0])
        ]);
    }
    echo "  ✓ 20 products\n\n";
    
    // Verify
    echo "Step 4: Verification...\n";
    $result = $pdo->query("SELECT COUNT(*) as cnt FROM produk WHERE status='aktif'");
    $cnt = $result->fetch(PDO::FETCH_ASSOC)['cnt'];
    echo "  ✓ Active products: $cnt\n";
    
    $result = $pdo->query("SELECT COUNT(*) as cnt FROM users WHERE peran='Pembeli'");
    $cnt = $result->fetch(PDO::FETCH_ASSOC)['cnt'];
    echo "  ✓ Pembeli users: $cnt\n";
    
    $result = $pdo->query("SELECT COUNT(*) as cnt FROM pesanan_item");
    $cnt = $result->fetch(PDO::FETCH_ASSOC)['cnt'];
    echo "  ✓ Pesanan items table ready\n";
    
    echo "\n╔════════════════════════════════════════════════════╗\n";
    echo "║           ✅ DATABASE COMPLETE & READY            ║\n";
    echo "╚════════════════════════════════════════════════════╝\n";
    
    echo "\n📝 Test Credentials:\n";
    echo "  Pembeli: pembeli1@test.com / password123\n";
    echo "  Pegawai: pegawai@test.com / password123\n";
    
    echo "\n🔗 Next Steps:\n";
    echo "  1. http://127.0.0.1:8000/shop (browse products)\n";
    echo "  2. http://127.0.0.1:8000/login (login pembeli)\n";
    echo "  3. Pilih produk → Click 'Lihat Detail' → Click 'Mulai Belanja'\n";
    
    echo "</pre>";
    
} catch (Exception $e) {
    echo "<pre style='color:red;'>❌ ERROR:\n" . $e->getMessage() . "\n\n" . $e->getTraceAsString() . "</pre>";
}
?>
