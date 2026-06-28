<?php

define('DB_HOST', 'localhost');
define('DB_NAME', 'smart_water_db');
define('DB_USER', 'root');
define('DB_PASS', '');

define('SENSOR_TIMEOUT_SECONDS', 10);

define('VOLUME_HAMPIR_PENUH', 400);
define('VOLUME_HAMPIR_HABIS', 50);

define('KAPASITAS_MAKSIMUM_ML', 565);

try {
    $pdo = new PDO(
        "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=utf8mb4",
        DB_USER,
        DB_PASS,
        [
            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES   => false,
        ]
    );
} catch (PDOException $e) {
    http_response_code(500);
    die(json_encode([
        'success' => false,
        'message' => 'Koneksi database gagal: ' . $e->getMessage()
    ]));
}
