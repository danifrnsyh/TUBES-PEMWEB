<?php
// Quick fix for produk_gambar created_at column
try {
    $pdo = new PDO('mysql:host=localhost;dbname=tubespemweb_toko', 'root', '');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    $sql = "ALTER TABLE `produk_gambar` MODIFY `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP NOT NULL";
    $pdo->exec($sql);
    
    echo "✓ Successfully fixed produk_gambar created_at column!\n";
} catch (PDOException $e) {
    echo "✗ Error: " . $e->getMessage() . "\n";
}
