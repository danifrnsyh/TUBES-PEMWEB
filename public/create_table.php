<?php
// Create pesanan_item table yang hilang
$host = 'localhost';
$db = 'tubespemweb_toko';
$user = 'root';
$pass = '';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$db;charset=utf8mb4", $user, $pass);
    
    echo "<pre>";
    
    // Create pesanan_item table
    $sql = "CREATE TABLE IF NOT EXISTS `pesanan_item` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `pesanan_id` bigint unsigned NOT NULL,
  `produk_id` bigint unsigned NOT NULL,
  `nama_produk` varchar(255) NOT NULL,
  `sku` varchar(255) NOT NULL,
  `jumlah` int NOT NULL DEFAULT '1',
  `harga_unit` bigint NOT NULL,
  `subtotal` bigint NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `pesanan_item_pesanan_id_foreign` (`pesanan_id`),
  KEY `pesanan_item_produk_id_foreign` (`produk_id`),
  CONSTRAINT `pesanan_item_pesanan_id_foreign` FOREIGN KEY (`pesanan_id`) REFERENCES `pesanan` (`id`) ON DELETE CASCADE,
  CONSTRAINT `pesanan_item_produk_id_foreign` FOREIGN KEY (`produk_id`) REFERENCES `produk` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;";

    $pdo->exec($sql);
    echo "✓ TABLE pesanan_item CREATED!\n";
    
    // Verify
    $result = $pdo->query("DESCRIBE `pesanan_item`");
    $columns = $result->fetchAll(PDO::FETCH_ASSOC);
    
    echo "\nVerifikasi columns:\n";
    foreach ($columns as $col) {
        echo "  ✓ {$col['Field']} ({$col['Type']})\n";
    }
    
    echo "\n✓ Database sudah siap!";
    
} catch (Exception $e) {
    echo "❌ Error: " . $e->getMessage();
}
?>
