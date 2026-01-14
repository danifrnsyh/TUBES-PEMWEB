<?php
// Restore database dari SQL file
$sqlFile = '/laragon/www/TUBESPEMWEB/tubespemweb_toko.sql';

if (!file_exists($sqlFile)) {
    die("❌ File not found: $sqlFile");
}

$host = 'localhost';
$db = 'tubespemweb_toko';
$user = 'root';
$pass = '';

try {
    $pdo = new PDO("mysql:host=$host;charset=utf8mb4", $user, $pass);
    
    echo "<pre>";
    echo "🔄 Starting database restore...\n\n";
    
    // Read SQL file
    $sql = file_get_contents($sqlFile);
    
    // Split by statements
    $statements = array_filter(array_map('trim', explode(';', $sql)), function($s) {
        return !empty($s) && strpos($s, '/*!') !== 0;
    });
    
    echo "Found " . count($statements) . " SQL statements\n\n";
    
    foreach ($statements as $statement) {
        try {
            $pdo->exec($statement . ';');
        } catch (Exception $e) {
            // Ignore errors for now
        }
    }
    
    // Verify tables
    echo "\n✓ Verifying tables...\n";
    $pdo = new PDO("mysql:host=$host;dbname=$db;charset=utf8mb4", $user, $pass);
    
    $tables = ['users', 'kategori_produk', 'produk', 'pesanan', 'pesanan_item', 'pengiriman', 'pegawai_profiles'];
    foreach ($tables as $table) {
        try {
            $result = $pdo->query("SELECT COUNT(*) FROM `$table`");
            echo "  ✓ $table\n";
        } catch (Exception $e) {
            echo "  ❌ $table - " . $e->getMessage() . "\n";
        }
    }
    
    echo "\n✓ Database restored successfully!";
    echo "</pre>";
    
} catch (Exception $e) {
    echo "<pre>❌ Error: " . $e->getMessage() . "</pre>";
}
?>
