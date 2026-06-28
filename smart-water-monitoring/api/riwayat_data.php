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

$search    = trim($_GET['search'] ?? '');
$tglMulai  = trim($_GET['tgl_mulai'] ?? '');
$tglSelesai = trim($_GET['tgl_selesai'] ?? '');
$page      = max(1, (int) ($_GET['page'] ?? 1));
$perPage   = 10;
$offset    = ($page - 1) * $perPage;

$where  = [];
$params = [];

if ($search !== '') {
    $where[] = "(status LIKE ? OR volume LIKE ? OR tinggi LIKE ?)";
    $params[] = "%$search%";
    $params[] = "%$search%";
    $params[] = "%$search%";
}

if ($tglMulai !== '') {
    $where[] = "DATE(created_at) >= ?";
    $params[] = $tglMulai;
}

if ($tglSelesai !== '') {
    $where[] = "DATE(created_at) <= ?";
    $params[] = $tglSelesai;
}

$whereSql = count($where) > 0 ? 'WHERE ' . implode(' AND ', $where) : '';

try {
    // Hitung total data untuk pagination
    $countStmt = $pdo->prepare("SELECT COUNT(*) AS total FROM monitoring $whereSql");
    $countStmt->execute($params);
    $total = (int) $countStmt->fetch()['total'];
    
    $sql = "SELECT * FROM monitoring $whereSql ORDER BY created_at DESC LIMIT $perPage OFFSET $offset";
    $stmt = $pdo->prepare($sql);
    $stmt->execute($params);
    $rows = $stmt->fetchAll();

    $data = array_map(function ($row) {
        return [
            'id'         => $row['id'],
            'waktu'      => date('d/m/Y H:i:s', strtotime($row['created_at'])),
            'volume'     => $row['volume'],
            'tinggi'     => $row['tinggi'],
            'jarak'      => $row['jarak'],
            'status'     => $row['status'],
            'warna'      => warnaStatusAir($row['status']),
            'emoji'      => emojiStatusAir($row['status']),
        ];
    }, $rows);

    echo json_encode([
        'success'    => true,
        'data'       => $data,
        'total'      => $total,
        'page'       => $page,
        'per_page'   => $perPage,
        'total_page' => max(1, ceil($total / $perPage)),
    ]);
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['success' => false, 'message' => $e->getMessage()]);
}
