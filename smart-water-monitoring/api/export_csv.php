<?php

require_once '../includes/auth.php';
require_once '../config/database.php';

$tglMulai   = trim($_GET['tgl_mulai'] ?? '');
$tglSelesai = trim($_GET['tgl_selesai'] ?? '');
$search     = trim($_GET['search'] ?? '');

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

$stmt = $pdo->prepare("SELECT * FROM monitoring $whereSql ORDER BY created_at DESC");
$stmt->execute($params);
$rows = $stmt->fetchAll();

$filename = 'riwayat_air_' . date('Ymd_His') . '.csv';

header('Content-Type: text/csv; charset=utf-8');
header('Content-Disposition: attachment; filename="' . $filename . '"');

$output = fopen('php://output', 'w');

fputcsv($output, ['No', 'Waktu', 'Volume (mL)', 'Tinggi (cm)', 'Jarak (cm)', 'Status']);

$no = 1;
foreach ($rows as $row) {
    fputcsv($output, [
        $no++,
        date('d/m/Y H:i:s', strtotime($row['created_at'])),
        $row['volume'],
        $row['tinggi'],
        $row['jarak'],
        $row['status'],
    ]);
}

fclose($output);
exit;
