<?php
// COMPREHENSIVE DEBUG
$host = 'localhost';
$db = 'tubespemweb_toko';
$user = 'root';
$pass = '';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$db;charset=utf8mb4", $user, $pass);
    
    echo "<pre style='background:#f0f0f0; padding:20px; font-size:14px;'>";
    echo "╔════════════════════════════════════════════╗\n";
    echo "║        COMPREHENSIVE DATABASE DEBUG        ║\n";
    echo "╚════════════════════════════════════════════╝\n\n";
    
    // 1. Check pesanan_item table exists
    echo "1️⃣  PESANAN_ITEM TABLE CHECK:\n";
    try {
        $result = $pdo->query("SELECT COUNT(*) as cnt FROM pesanan_item");
        $row = $result->fetch(PDO::FETCH_ASSOC);
        echo "   ✓ Table exists | Rows: {$row['cnt']}\n";
    } catch (Exception $e) {
        echo "   ❌ Table missing!\n";
    }
    
    // 2. Check produk count
    echo "\n2️⃣  PRODUK COUNT:\n";
    $result = $pdo->query("SELECT COUNT(*) as cnt FROM produk");
    $row = $result->fetch(PDO::FETCH_ASSOC);
    echo "   Total: {$row['cnt']} produk\n";
    
    $result = $pdo->query("SELECT COUNT(*) as cnt FROM produk WHERE status='aktif'");
    $row = $result->fetch(PDO::FETCH_ASSOC);
    echo "   Active (status='aktif'): {$row['cnt']} produk\n";
    
    // 3. List ALL produk
    echo "\n3️⃣  SEMUA PRODUK DI DATABASE:\n";
    $result = $pdo->query("SELECT id, nama, sku, harga, stok, status FROM produk LIMIT 20");
    $all_produks = $result->fetchAll(PDO::FETCH_ASSOC);
    
    if (empty($all_produks)) {
        echo "   ❌❌❌ TIDAK ADA PRODUK SAMA SEKALI! ❌❌❌\n";
        echo "   Jalankan setup_demo.php sekarang!\n";
    } else {
        echo "   Ditemukan " . count($all_produks) . " produk:\n";
        foreach ($all_produks as $i => $p) {
            $status_ok = ($p['status'] === 'aktif') ? '✓' : '✗';
            echo "   $status_ok [{$p['id']}] {$p['nama']} | SKU:{$p['sku']} | Rp " . number_format($p['harga'], 0, ',', '.') . " | Stok:{$p['stok']} | Status:{$p['status']}\n";
        }
    }
    
    // 4. Check kategori_produk
    echo "\n4️⃣  KATEGORI PRODUK:\n";
    $result = $pdo->query("SELECT id, nama FROM kategori_produk");
    $kategoris = $result->fetchAll(PDO::FETCH_ASSOC);
    if (empty($kategoris)) {
        echo "   ❌ Tidak ada kategori\n";
    } else {
        foreach ($kategoris as $k) {
            echo "   [{$k['id']}] {$k['nama']}\n";
        }
    }
    
    // 5. Check users
    echo "\n5️⃣  TEST USERS:\n";
    $result = $pdo->query("SELECT id, nama, email, peran FROM users LIMIT 5");
    $users = $result->fetchAll(PDO::FETCH_ASSOC);
    if (empty($users)) {
        echo "   ❌ Tidak ada users\n";
    } else {
        foreach ($users as $u) {
            echo "   [{$u['id']}] {$u['nama']} ({$u['email']}) - {$u['peran']}\n";
        }
    }
    
    echo "\n╔════════════════════════════════════════════╗\n";
    
    if (empty($all_produks)) {
        echo "║  ⚠️  RUN: http://127.0.0.1:8000/setup_demo.php\n";
    } else {
        echo "║  ✓ Database OK!\n";
        echo "║  Try: http://127.0.0.1:8000/shop\n";
    }
    echo "╚════════════════════════════════════════════╝\n";
    
    echo "</pre>";
    
} catch (Exception $e) {
    echo "<pre style='color:red;'>❌ CONNECTION ERROR:\n" . $e->getMessage() . "</pre>";
}
?>
