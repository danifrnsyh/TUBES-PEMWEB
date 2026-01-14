<?php
// Manually create pesanan_item table from SQL file
$host = 'localhost';
$db = 'tubespemweb_toko';
$user = 'root';
$pass = '';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$db;charset=utf8mb4", $user, $pass);
    
    echo "<pre>";
    echo "🔄 Creating pesanan_item table...\n\n";
    
    // Drop if exists
    try {
        $pdo->exec("DROP TABLE IF EXISTS `pesanan_item`");
        echo "✓ Dropped old pesanan_item table\n";
    } catch (Exception $e) {}
    
    // Create pesanan_item exactly from SQL file
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
  KEY `FK_pesanan_item_produk` (`produk_id`),
  CONSTRAINT `FK_pesanan_id_pesanan` FOREIGN KEY (`pesanan_id`) REFERENCES `pesanan` (`id`) ON DELETE CASCADE,
  CONSTRAINT `FK_pesanan_item_produk` FOREIGN KEY (`produk_id`) REFERENCES `produk` (`id`) ON DELETE RESTRICT
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
SQL;

    $pdo->exec($sql);
    echo "✓ Created pesanan_item table\n";
    
    // Verify
    $result = $pdo->query("DESCRIBE `pesanan_item`");
    $columns = $result->fetchAll(PDO::FETCH_ASSOC);
    
    echo "\n✓ Table structure:\n";
    foreach ($columns as $col) {
        echo "  - {$col['Field']} ({$col['Type']})\n";
    }
    
    // Check all tables
    echo "\n\n=== ALL TABLES ===\n";
    $tables = ['users', 'kategori_produk', 'produk', 'pesanan', 'pesanan_item', 'pengiriman', 'pegawai_profiles'];
    foreach ($tables as $table) {
        try {
            $result = $pdo->query("SELECT COUNT(*) as cnt FROM `$table`");
            $row = $result->fetch(PDO::FETCH_ASSOC);
            echo "✓ $table ({$row['cnt']} rows)\n";
        } catch (Exception $e) {
            echo "❌ $table\n";
        }
    }
    
    echo "\n✓ ALL SET! Pesanan_item table ready!";
    echo "</pre>";
    
} catch (Exception $e) {
    echo "<pre>❌ Error: " . $e->getMessage() . "</pre>";
}
?>
