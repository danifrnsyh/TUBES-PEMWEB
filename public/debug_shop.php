<?php
// Debug shop page
$host = 'localhost';
$db = 'tubespemweb_toko';
$user = 'root';
$pass = '';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$db;charset=utf8mb4", $user, $pass);
    
    echo "<pre>";
    echo "=== DATABASE DEBUG ===\n\n";
    
    // Check pesanan_item
    try {
        $result = $pdo->query("DESCRIBE `pesanan_item`");
        $columns = $result->fetchAll(PDO::FETCH_ASSOC);
        echo "✓ pesanan_item table exists\n";
        echo "  Columns:\n";
        foreach ($columns as $col) {
            echo "    - {$col['Field']} ({$col['Type']})\n";
        }
    } catch (Exception $e) {
        echo "❌ pesanan_item error: " . $e->getMessage() . "\n";
    }
    
    echo "\n";
    
    // Check all tables row count
    $tables = ['users', 'kategori_produk', 'produk', 'pesanan', 'pesanan_item', 'pengiriman'];
    echo "=== TABLE ROW COUNTS ===\n";
    foreach ($tables as $table) {
        try {
            $result = $pdo->query("SELECT COUNT(*) as cnt FROM `$table`");
            $row = $result->fetch(PDO::FETCH_ASSOC);
            echo "$table: {$row['cnt']} rows\n";
        } catch (Exception $e) {
            echo "$table: ERROR - " . $e->getMessage() . "\n";
        }
    }
    
    echo "\n=== SAMPLE PRODUK ===\n";
    try {
        $result = $pdo->query("SELECT id, nama, harga, stok, status FROM `produk` LIMIT 5");
        $rows = $result->fetchAll(PDO::FETCH_ASSOC);
        if (empty($rows)) {
            echo "❌ NO PRODUCTS IN DATABASE!\n";
        } else {
            foreach ($rows as $row) {
                echo "{$row['id']} | {$row['nama']} | Rp {$row['harga']} | Stok: {$row['stok']} | Status: {$row['status']}\n";
            }
        }
    } catch (Exception $e) {
        echo "ERROR: " . $e->getMessage() . "\n";
    }
    
    echo "\n✓ Debug complete\n";
    echo "</pre>";
    
} catch (Exception $e) {
    echo "<pre>❌ Connection Error: " . $e->getMessage() . "</pre>";
}
?>
