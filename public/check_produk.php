<?php
// Direct database check for produk
$host = 'localhost';
$db = 'tubespemweb_toko';
$user = 'root';
$pass = '';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$db;charset=utf8mb4", $user, $pass);
    
    echo "<pre>";
    echo "=== DIRECT DATABASE CHECK ===\n\n";
    
    // Count all produk
    $result = $pdo->query("SELECT COUNT(*) as cnt FROM produk");
    $row = $result->fetch(PDO::FETCH_ASSOC);
    echo "Total produk: {$row['cnt']}\n";
    
    // Count active produk
    $result = $pdo->query("SELECT COUNT(*) as cnt FROM produk WHERE status = 'aktif'");
    $row = $result->fetch(PDO::FETCH_ASSOC);
    echo "Active produk: {$row['cnt']}\n\n";
    
    // Show all produk
    echo "=== SEMUA PRODUK ===\n";
    $result = $pdo->query("SELECT id, nama, sku, harga, stok, status FROM produk ORDER BY created_at DESC");
    $produks = $result->fetchAll(PDO::FETCH_ASSOC);
    
    if (empty($produks)) {
        echo "❌ NO PRODUCTS!\n";
    } else {
        foreach ($produks as $p) {
            echo "{$p['id']} | {$p['nama']} | {$p['sku']} | Rp {$p['harga']} | Stok:{$p['stok']} | Status:{$p['status']}\n";
        }
    }
    
    echo "</pre>";
    
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}
?>
