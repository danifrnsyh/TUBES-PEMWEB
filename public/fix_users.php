<?php
// Fix telepon column dan add users
$host = 'localhost';
$db = 'tubespemweb_toko';
$user = 'root';
$pass = '';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$db;charset=utf8mb4", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    echo "<pre>";
    echo "🔄 Fixing users table...\n\n";
    
    // Modify telepon column
    $pdo->exec("ALTER TABLE users MODIFY COLUMN telepon VARCHAR(20) DEFAULT NULL");
    echo "✓ Fixed telepon column (INT → VARCHAR)\n\n";
    
    // Add users
    echo "🔄 Adding users...\n";
    $pwd = password_hash('password123', PASSWORD_BCRYPT);
    
    $pdo->exec("INSERT INTO users (nama, email, password, peran, telepon, alamat, created_at, updated_at) VALUES 
    ('Pegawai', 'pegawai@test.com', '$pwd', 'Pegawai', '082234567890', 'Jakarta', NOW(), NOW()),
    ('Pembeli', 'pembeli@test.com', '$pwd', 'Pembeli', '081234567890', 'Jakarta', NOW(), NOW())");
    
    echo "✓ Added 1 Pegawai: pegawai@test.com\n";
    echo "✓ Added 1 Pembeli: pembeli@test.com\n";
    echo "  Password: password123\n\n";
    
    // Verify
    $result = $pdo->query("SELECT id, nama, email, peran, telepon FROM users");
    $users = $result->fetchAll(PDO::FETCH_ASSOC);
    
    echo "✅ Users sekarang:\n";
    foreach ($users as $u) {
        echo "  [{$u['id']}] {$u['nama']} ({$u['email']}) - {$u['peran']} - {$u['telepon']}\n";
    }
    
    echo "\n✅ Done!\n";
    echo "</pre>";
    
} catch (Exception $e) {
    echo "<pre>❌ Error: " . $e->getMessage() . "</pre>";
}
?>
