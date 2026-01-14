<?php
// Direct PHP script to show database structure
$host = 'localhost';
$db = 'tubespemweb_toko';
$user = 'root';
$pass = '';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$db;charset=utf8mb4", $user, $pass);
    
    echo "<pre>";
    echo "=== DATABASE STRUCTURE ===\n\n";
    
    // Show tables
    $tables = ['users', 'pesanan', 'pesanan_item', 'produk', 'kategori_produk'];
    
    foreach ($tables as $table) {
        try {
            $result = $pdo->query("DESCRIBE `$table`");
            $columns = $result->fetchAll(PDO::FETCH_ASSOC);
            
            echo "TABLE: $table\n";
            echo "Columns (" . count($columns) . "):\n";
            foreach ($columns as $col) {
                echo "  - {$col['Field']} ({$col['Type']}) Null={$col['Null']} Key={$col['Key']}\n";
            }
            echo "\n";
        } catch (Exception $e) {
            echo "ERROR on $table: " . $e->getMessage() . "\n\n";
        }
    }
    
    // Show pesanan_item raw CREATE
    echo "\n=== RAW CREATE TABLE pesanan_item ===\n";
    try {
        $result = $pdo->query("SHOW CREATE TABLE `pesanan_item`");
        $row = $result->fetch(PDO::FETCH_ASSOC);
        echo $row['Create Table'] ?? 'Not found';
    } catch (Exception $e) {
        echo "Error: " . $e->getMessage();
    }
    echo "\n";
    
    echo "</pre>";
    
} catch (Exception $e) {
    echo "<pre>Connection error: " . $e->getMessage() . "</pre>";
}
?>
