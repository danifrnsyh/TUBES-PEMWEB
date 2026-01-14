<?php
// Direct PHP test
require_once '/laragon/www/TUBESPEMWEB/vendor/autoload.php';

try {
    echo "<pre>";
    echo "🔄 Testing Laravel app...\n\n";
    
    // Create app
    $app = require_once '/laragon/www/TUBESPEMWEB/bootstrap/app.php';
    echo "✓ App bootstrapped\n";
    
    // Get database connection
    $db = $app['db'];
    echo "✓ Database connected\n";
    
    // Check produk count
    $count = $db->table('produk')->count();
    echo "✓ Produk count: $count\n";
    
    // Sample produk
    $produks = $db->table('produk')->where('status', 'aktif')->limit(5)->get();
    echo "✓ Active produks: " . count($produks) . "\n";
    
    foreach ($produks as $p) {
        echo "  - ID:{$p->id} | {$p->nama} | Rp {$p->harga} | Stok: {$p->stok}\n";
    }
    
    echo "\n✓ Everything working!\n";
    echo "</pre>";
    
} catch (Exception $e) {
    echo "<pre>❌ Error: " . $e->getMessage() . "\n";
    echo $e->getTraceAsString() . "</pre>";
}
?>
