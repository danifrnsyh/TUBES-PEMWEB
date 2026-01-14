<?php
// Add sample data ke database
$host = 'localhost';
$db = 'tubespemweb_toko';
$user = 'root';
$pass = '';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$db;charset=utf8mb4", $user, $pass);
    
    echo "<pre>";
    echo "🔄 Adding sample data...\n\n";
    
    // 1. Insert kategori
    $pdo->exec("INSERT INTO kategori_produk (nama, slug, deskripsi, created_at, updated_at) VALUES 
    ('Meja', 'meja', 'Koleksi meja berkualitas', NOW(), NOW()),
    ('Kursi', 'kursi', 'Koleksi kursi ergonomis', NOW(), NOW()),
    ('Lemari', 'lemari', 'Koleksi lemari penyimpanan', NOW(), NOW()),
    ('Tempat Tidur', 'tempat-tidur', 'Koleksi tempat tidur nyaman', NOW(), NOW())");
    echo "✓ Added 4 categories\n";
    
    // 2. Insert users (pembeli & pegawai)
    $pwd = password_hash('password123', PASSWORD_BCRYPT);
    
    $pdo->exec("INSERT INTO users (nama, email, password, peran, telepon, alamat, created_at, updated_at) VALUES 
    ('Budi Santoso', 'pembeli1@test.com', '$pwd', 'Pembeli', 81234567890, 'Jakarta', NOW(), NOW()),
    ('Siti Aminah', 'pembeli2@test.com', '$pwd', 'Pembeli', 81234567891, 'Bandung', NOW(), NOW()),
    ('Ahmad Manager', 'pegawai@test.com', '$pwd', 'Pegawai', 82234567890, 'Jakarta', NOW(), NOW())");
    echo "✓ Added 3 users (2 pembeli, 1 pegawai)\n";
    
    // 3. Insert produk (20 items)
    $produk_data = [
        ['Meja Makan 6 Kursi Kayu Jati', 'TM001', 3500000, 15],
        ['Meja Ruang Tamu Minimalis', 'TM002', 2200000, 20],
        ['Meja Kerja Laptop Putih', 'TM003', 950000, 18],
        ['Meja Bar Counter', 'TM004', 1800000, 8],
        ['Kursi Kantor Ergonomis', 'KK001', 1200000, 25],
        ['Kursi Makan Kayu', 'KK002', 650000, 30],
        ['Kursi Gaming Pro', 'KK003', 2500000, 5],
        ['Kursi Ayun Santai', 'KK004', 1100000, 12],
        ['Lemari Pakaian 3 Pintu', 'LP001', 2800000, 6],
        ['Lemari Buku Tinggi', 'LP002', 1500000, 10],
        ['Lemari Dapur Minimalis', 'LP003', 2100000, 7],
        ['Lemari Hias Display', 'LP004', 1300000, 14],
        ['Tempat Tidur Queen Size', 'TT001', 4500000, 3],
        ['Tempat Tidur Single Besi', 'TT002', 1800000, 8],
        ['Sofa Ruang Keluarga L', 'SF001', 6200000, 2],
        ['Sofa 2 Seater Minimalis', 'SF002', 2800000, 6],
        ['Rak Buku 5 Tingkat', 'RB001', 900000, 22],
        ['Rak TV Minimalis', 'RB002', 1600000, 9],
        ['Cermin Dinding Besar', 'CD001', 750000, 16],
        ['Bufet Dapur Kayu', 'BD001', 3200000, 4],
    ];
    
    $stmt = $pdo->prepare("INSERT INTO produk 
        (penambah_id, kategori_id, nama, deskripsi, sku, harga, stok, berat_gram, dimensi, gambar_utama, status, created_at, updated_at) 
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, 'aktif', NOW(), NOW())");
    
    foreach ($produk_data as $p) {
        $stmt->execute([
            3,  // penambah_id (pegawai)
            rand(1, 4),  // kategori_id random
            $p[0],  // nama
            'Produk furniture berkualitas tinggi dengan desain modern',
            $p[1],  // sku
            $p[2],  // harga
            $p[3],  // stok
            5000,  // berat_gram
            '100x60x80',  // dimensi
            'https://via.placeholder.com/400x300?text=' . urlencode($p[0]),  // gambar
        ]);
    }
    echo "✓ Added 20 products\n";
    
    // Verify
    echo "\n=== VERIFICATION ===\n";
    $result = $pdo->query("SELECT COUNT(*) as cnt FROM produk WHERE status='aktif'");
    $row = $result->fetch(PDO::FETCH_ASSOC);
    echo "✓ Active produk: {$row['cnt']}\n";
    
    $result = $pdo->query("SELECT COUNT(*) as cnt FROM users WHERE peran='Pembeli'");
    $row = $result->fetch(PDO::FETCH_ASSOC);
    echo "✓ Pembeli users: {$row['cnt']}\n";
    
    echo "\n✅ DATABASE POPULATED!\n";
    echo "\n🔗 Next: http://127.0.0.1:8000/shop\n";
    echo "</pre>";
    
} catch (Exception $e) {
    echo "<pre>❌ Error: " . $e->getMessage() . "</pre>";
}
?>
