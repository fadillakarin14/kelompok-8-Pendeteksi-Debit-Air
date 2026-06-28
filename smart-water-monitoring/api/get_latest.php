<?php
session_start();
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header('Content-Type: application/json');
    http_response_code(401);
    echo json_encode(['success' => false, 'message' => 'Unauthorized']);
    exit;
}

require_once '../config/database.php';
require_once '../includes/functions.php';

header('Content-Type: application/json');

try {
    $stmt = $pdo->query("SELECT * FROM monitoring ORDER BY created_at DESC LIMIT 1");
    $row = $stmt->fetch();

    if (!$row) {
        echo json_encode(['success' => true, 'data' => null]);
        exit;
    }

    $status  = $row['status'] ?: tentukanStatusAir($row['volume']);
    $persen  = persentaseVolume($row['volume']);
    $online  = sensorOnline($row['created_at']);
    $notif   = cekNotifikasi($row['volume']);

    echo json_encode([
        'success' => true,
        'data' => [
            'id'            => $row['id'],
            'volume'        => $row['volume'],
            'tinggi'        => $row['tinggi'],
            'jarak'         => $row['jarak'],
            'status'        => $status,
            'warna_status'  => warnaStatusAir($status),
            'emoji_status'  => emojiStatusAir($status),
            'persentase'    => $persen,
            'sensor_online' => $online,
            'created_at'    => $row['created_at'],
            'notifikasi'    => $notif,
        ]
    ]);
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['success' => false, 'message' => $e->getMessage()]);
}
