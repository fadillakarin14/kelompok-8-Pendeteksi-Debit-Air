<?php
require_once 'config/database.php';

$usernameBaru = 'admin';
$passwordBaru = 'admin123';

$hash = password_hash($passwordBaru, PASSWORD_BCRYPT);

try {
    $stmt = $pdo->prepare("SELECT id FROM users WHERE username = ?");
    $stmt->execute([$usernameBaru]);
    $existing = $stmt->fetch();

    if ($existing) {
        $stmt = $pdo->prepare("UPDATE users SET password = ? WHERE username = ?");
        $stmt->execute([$hash, $usernameBaru]);
        $aksi = 'diperbarui';
    } else {
        $stmt = $pdo->prepare("INSERT INTO users (username, password) VALUES (?, ?)");
        $stmt->execute([$usernameBaru, $hash]);
        $aksi = 'dibuat';
    }

    echo "<div style='font-family:sans-serif; max-width:500px; margin:60px auto; padding:24px; border:1px solid #ddd; border-radius:12px;'>";
    echo "<h2 style='color:#1FA97E;'>✅ Berhasil!</h2>";
    echo "<p>Akun admin berhasil <strong>$aksi</strong>.</p>";
    echo "<p>Silakan login dengan:</p>";
    echo "<ul><li>Username: <strong>$usernameBaru</strong></li><li>Password: <strong>$passwordBaru</strong></li></ul>";
    echo "<p style='color:#c23d3d;'><strong>PENTING:</strong> Hapus file <code>reset_password.php</code> ini dari server setelah berhasil login, demi keamanan.</p>";
    echo "<a href='login.php' style='display:inline-block; margin-top:10px; padding:10px 20px; background:#0E3A4C; color:#fff; text-decoration:none; border-radius:8px;'>Ke halaman login →</a>";
    echo "</div>";

} catch (Exception $e) {
    echo "<div style='font-family:sans-serif; max-width:500px; margin:60px auto; padding:24px; border:1px solid #f0c4c4; border-radius:12px; background:#fbe9e9;'>";
    echo "<h2 style='color:#c23d3d;'>❌ Terjadi Kesalahan</h2>";
    echo "<p>" . htmlspecialchars($e->getMessage()) . "</p>";
    echo "<p>Pastikan:</p>";
    echo "<ul>";
    echo "<li>Database <code>smart_water_db</code> sudah dibuat (import file <code>database/smart_water_db.sql</code>)</li>";
    echo "<li>Tabel <code>users</code> ada di dalamnya</li>";
    echo "<li>Konfigurasi di <code>config/database.php</code> sudah sesuai (host, nama database, user, password)</li>";
    echo "</ul>";
    echo "</div>";
}
