<?php
// Restore dari SQL file original
$sqlFile = 'c:/laragon/www/TUBESPEMWEB/tubespemweb_toko.sql';

if (!file_exists($sqlFile)) {
    die("❌ File tidak found: $sqlFile");
}

$host = 'localhost';
$db = 'tubespemweb_toko';
$user = 'root';
$pass = '';

try {
    echo "<pre>";
    echo "🔄 Restoring database dari SQL file...\n\n";
    
    // Connect
    $pdo = new PDO("mysql:host=$host;charset=utf8mb4", $user, $pass);
    
    // Drop dan recreate database
    $pdo->exec("DROP DATABASE IF EXISTS `tubespemweb_toko`");
    echo "✓ Dropped old database\n";
    
    $pdo->exec("CREATE DATABASE `tubespemweb_toko` CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci");
    echo "✓ Created new database\n";
    
    // Use database
    $pdo = new PDO("mysql:host=$host;dbname=$db;charset=utf8mb4", $user, $pass);
    
    // Read SQL file
    $sql = file_get_contents($sqlFile);
    
    // Execute
    $pdo->exec($sql);
    echo "✓ SQL file executed\n";
    
    // Verify tables
    echo "\n=== VERIFYING TABLES ===\n";
    $tables = ['users', 'kategori_produk', 'produk', 'pesanan', 'pesanan_item', 'pengiriman'];
    
    foreach ($tables as $table) {
        try {
            $result = $pdo->query("SELECT COUNT(*) as cnt FROM `$table`");
            $row = $result->fetch(PDO::FETCH_ASSOC);
            echo "✓ $table ({$row['cnt']} rows)\n";
        } catch (Exception $e) {
            echo "❌ $table - ERROR\n";
        }
    }
    
    // Show produk count
    echo "\n=== PRODUK ===\n";
    $result = $pdo->query("SELECT COUNT(*) as cnt FROM produk WHERE status='aktif'");
    $row = $result->fetch(PDO::FETCH_ASSOC);
    echo "Active produk: {$row['cnt']}\n";
    
    $result = $pdo->query("SELECT id, nama, harga, stok FROM produk LIMIT 5");
    $produks = $result->fetchAll(PDO::FETCH_ASSOC);
    foreach ($produks as $p) {
        echo "  - {$p['nama']} (Rp {$p['harga']}, Stok:{$p['stok']})\n";
    }
    
    echo "\n✅ DATABASE RESTORED!\n";
    echo "Buka: http://127.0.0.1:8000/shop\n";
    echo "</pre>";
    
} catch (Exception $e) {
    echo "<pre>❌ Error: " . $e->getMessage() . "\nFile path: $sqlFile</pre>";
}
?>
