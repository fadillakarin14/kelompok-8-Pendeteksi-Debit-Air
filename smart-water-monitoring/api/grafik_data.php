<?php
session_start();
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header('Content-Type: application/json');
    http_response_code(401);
    echo json_encode(['success' => false, 'message' => 'Unauthorized']);
    exit;
}

require_once '../config/database.php';

header('Content-Type: application/json');

$limit = isset($_GET['limit']) ? (int) $_GET['limit'] : 20;
$limit = max(5, min(100, $limit));

try {
    $stmt = $pdo->prepare("SELECT volume, tinggi, jarak, status, created_at FROM monitoring ORDER BY created_at DESC LIMIT ?");
    $stmt->bindValue(1, $limit, PDO::PARAM_INT);
    $stmt->execute();
    $rows = array_reverse($stmt->fetchAll());

    $labels  = [];
    $volume  = [];
    $tinggi  = [];

    foreach ($rows as $row) {
        $labels[] = date('H:i:s', strtotime($row['created_at']));
        $volume[] = (float) $row['volume'];
        $tinggi[] = (float) $row['tinggi'];
    }

    echo json_encode([
        'success' => true,
        'labels'  => $labels,
        'volume'  => $volume,
        'tinggi'  => $tinggi,
    ]);
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['success' => false, 'message' => $e->getMessage()]);
}
