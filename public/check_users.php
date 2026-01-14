<?php
// Check users and restore if missing
$host = 'localhost';
$db = 'tubespemweb_toko';
$user = 'root';
$pass = '';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$db;charset=utf8mb4", $user, $pass);
    
    echo "<pre>";
    
    // Check existing users
    $result = $pdo->query("SELECT COUNT(*) as cnt FROM users");
    $cnt = $result->fetch(PDO::FETCH_ASSOC)['cnt'];
    
    echo "🔍 Users dalam database: $cnt\n\n";
    
    if ($cnt > 0) {
        $result = $pdo->query("SELECT id, nama, email, peran FROM users");
        $users = $result->fetchAll(PDO::FETCH_ASSOC);
        foreach ($users as $u) {
            echo "  ✓ [{$u['id']}] {$u['nama']} ({$u['email']}) - {$u['peran']}\n";
        }
    } else {
        echo "❌ Tidak ada users!\n\n";
        echo "🔄 Adding original users...\n\n";
        
        $pwd = password_hash('password123', PASSWORD_BCRYPT);
        
        $pdo->exec("INSERT INTO users (nama, email, password, peran, telepon, alamat, created_at, updated_at) VALUES 
        ('Pegawai Original', 'pegawai@test.com', '$pwd', 'Pegawai', 82234567890, 'Jakarta', NOW(), NOW()),
        ('Pembeli Original', 'pembeli@test.com', '$pwd', 'Pembeli', 81234567890, 'Jakarta', NOW(), NOW())");
        
        echo "✓ Added 1 Pegawai: pegawai@test.com\n";
        echo "✓ Added 1 Pembeli: pembeli@test.com\n";
        echo "  Password: password123\n\n";
        
        // Verify
        $result = $pdo->query("SELECT id, nama, email, peran FROM users");
        $users = $result->fetchAll(PDO::FETCH_ASSOC);
        echo "✅ Users sekarang:\n";
        foreach ($users as $u) {
            echo "  [{$u['id']}] {$u['nama']} ({$u['email']}) - {$u['peran']}\n";
        }
    }
    
    echo "\n✅ Done!\n";
    echo "</pre>";
    
} catch (Exception $e) {
    echo "<pre>❌ Error: " . $e->getMessage() . "</pre>";
}
?>
