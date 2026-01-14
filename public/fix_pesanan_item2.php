<?php
// Check pesanan table structure first
$host = 'localhost';
$db = 'tubespemweb_toko';
$user = 'root';
$pass = '';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$db;charset=utf8mb4", $user, $pass);
    
    echo "<pre>";
    echo "=== PESANAN TABLE STRUCTURE ===\n\n";
    
    $result = $pdo->query("DESCRIBE `pesanan`");
    $columns = $result->fetchAll(PDO::FETCH_ASSOC);
    
    foreach ($columns as $col) {
        echo "{$col['Field']}: {$col['Type']} Null={$col['Null']} Key={$col['Key']}\n";
    }
    
    echo "\n\n=== CREATING PESANAN_ITEM WITHOUT FK ===\n";
    
    // Drop if exists
    try {
        $pdo->exec("DROP TABLE IF EXISTS `pesanan_item`");
        echo "✓ Dropped old pesanan_item\n";
    } catch (Exception $e) {}
    
    // Create without foreign keys first
    $sql = <<<SQL
CREATE TABLE `pesanan_item` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `pesanan_id` bigint unsigned NOT NULL,
  `produk_id` bigint unsigned NOT NULL,
  `nama_produk` varchar(255) NOT NULL,
  `sku` varchar(255) NOT NULL,
  `jumlah` int NOT NULL,
  `harga_unit` bigint NOT NULL,
  `subtotal` bigint NOT NULL,
  `metode` enum('Bayar Ditempat','Transfer') CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `status` enum('pending','berhasil','gagal') NOT NULL DEFAULT 'pending',
  `bukti` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `FK_pesanan_id_pesanan` (`pesanan_id`),
  KEY `FK_pesanan_item_produk` (`produk_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
SQL;

    $pdo->exec($sql);
    echo "✓ Created pesanan_item (without FK)\n";
    
    // Now add foreign keys
    echo "\nAdding foreign keys...\n";
    
    try {
        $pdo->exec("ALTER TABLE `pesanan_item` ADD CONSTRAINT `FK_pesanan_id_pesanan` FOREIGN KEY (`pesanan_id`) REFERENCES `pesanan` (`id`) ON DELETE CASCADE");
        echo "✓ FK pesanan_id added\n";
    } catch (Exception $e) {
        echo "⚠️  FK pesanan_id error: " . $e->getMessage() . "\n";
    }
    
    try {
        $pdo->exec("ALTER TABLE `pesanan_item` ADD CONSTRAINT `FK_pesanan_item_produk` FOREIGN KEY (`produk_id`) REFERENCES `produk` (`id`) ON DELETE RESTRICT");
        echo "✓ FK produk_id added\n";
    } catch (Exception $e) {
        echo "⚠️  FK produk_id error: " . $e->getMessage() . "\n";
    }
    
    echo "\n✓ Done!\n";
    echo "</pre>";
    
} catch (Exception $e) {
    echo "<pre>❌ Error: " . $e->getMessage() . "</pre>";
}
?>
