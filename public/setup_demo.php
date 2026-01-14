<?php
// Clean database dan buat 10 produk demo
$host = 'localhost';
$db = 'tubespemweb_toko';
$user = 'root';
$pass = '';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$db;charset=utf8mb4", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    echo "<pre>";
    echo "🔄 Cleaning database...\n\n";
    
    // Disable foreign key checks
    $pdo->exec("SET FOREIGN_KEY_CHECKS = 0");
    
    // Truncate tables
    $tables = ['pesanan_item', 'pesanan', 'pengiriman', 'produk_gambar', 'produk', 'kategori_produk', 'pegawai_profiles', 'users'];
    foreach ($tables as $table) {
        try {
            $pdo->exec("TRUNCATE TABLE `$table`");
            echo "✓ Truncated $table\n";
        } catch (Exception $e) {}
    }
    
    $pdo->exec("SET FOREIGN_KEY_CHECKS = 1");
    
    echo "\n🔄 Creating demo data...\n\n";
    
    // Create 1 kategori
    $pdo->exec("INSERT INTO `kategori_produk` (`nama`, `slug`, `deskripsi`, `created_at`, `updated_at`) 
               VALUES ('Furniture Rumah', 'furniture-rumah', 'Koleksi furniture berkualitas untuk rumah Anda', NOW(), NOW())");
    echo "✓ Created category: Furniture Rumah\n";
    
    // Create 2 test users
    $password = password_hash('password123', PASSWORD_BCRYPT);
    
    $pdo->exec("INSERT INTO `users` (`nama`, `email`, `password`, `peran`, `telepon`, `alamat`, `created_at`, `updated_at`) 
               VALUES 
               ('Pembeli Test', 'pembeli@test.com', '$password', 'Pembeli', 081234567890, 'Jakarta', NOW(), NOW()),
               ('Pegawai Test', 'pegawai@test.com', '$password', 'Pegawai', 082234567890, 'Jakarta', NOW(), NOW())");
    echo "✓ Created 2 test users (pembeli@test.com, pegawai@test.com)\n";
    
    // Create 10 furniture products
    $produks = [
        ['nama' => 'Meja Ruang Tamu Minimalis', 'sku' => 'MRT001', 'harga' => 1500000, 'stok' => 15],
        ['nama' => 'Kursi Kantor Ergonomis', 'sku' => 'KKE001', 'harga' => 1200000, 'stok' => 20],
        ['nama' => 'Lemari Pakaian 3 Pintu', 'sku' => 'LPP001', 'harga' => 2500000, 'stok' => 8],
        ['nama' => 'Tempat Tidur Queen Size', 'sku' => 'TTQ001', 'harga' => 3500000, 'stok' => 5],
        ['nama' => 'Sofa Ruang Keluarga L-Shaped', 'sku' => 'SRK001', 'harga' => 5000000, 'stok' => 3],
        ['nama' => 'Meja Makan 6 Kursi', 'sku' => 'MMK001', 'harga' => 3200000, 'stok' => 6],
        ['nama' => 'Rak Buku Minimalis', 'sku' => 'RBM001', 'harga' => 800000, 'stok' => 25],
        ['nama' => 'Bufet Dapur Kayu Jati', 'sku' => 'BDK001', 'harga' => 2800000, 'stok' => 4],
        ['nama' => 'Cermin Dinding Ukir', 'sku' => 'CDU001', 'harga' => 600000, 'stok' => 30],
        ['nama' => 'Meja Kerja Laptop', 'sku' => 'MKL001', 'harga' => 900000, 'stok' => 18],
    ];
    
    $stmt = $pdo->prepare("INSERT INTO `produk` 
                          (`penambah_id`, `kategori_id`, `nama`, `deskripsi`, `sku`, `harga`, `stok`, `berat_gram`, `dimensi`, `gambar_utama`, `status`, `created_at`, `updated_at`)
                          VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, 'aktif', NOW(), NOW())");
    
    foreach ($produks as $p) {
        $stmt->execute([
            2,  // penambah_id (pegawai)
            1,  // kategori_id
            $p['nama'],
            'Produk furniture berkualitas tinggi',
            $p['sku'],
            $p['harga'],
            $p['stok'],
            5000,  // berat_gram
            '100x60x80',  // dimensi
            'https://via.placeholder.com/400x300?text=' . urlencode($p['nama']),  // gambar_utama
        ]);
        echo "✓ Created: {$p['nama']}\n";
    }
    
    echo "\n✅ DATABASE READY!\n";
    echo "\nTest Credentials:\n";
    echo "  Pembeli: pembeli@test.com / password123\n";
    echo "  Pegawai: pegawai@test.com / password123\n";
    echo "</pre>";
    
} catch (Exception $e) {
    echo "<pre>❌ Error: " . $e->getMessage() . "</pre>";
}
?>
