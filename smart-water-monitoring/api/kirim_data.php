<?php
require_once '../config/database.php';
require_once '../includes/functions.php';

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    jsonResponse(['success' => false, 'message' => 'Hanya menerima metode POST'], 405);
}

$input = $_POST;
if (empty($input)) {
    $rawBody = file_get_contents('php://input');
    $decoded = json_decode($rawBody, true);
    if (is_array($decoded)) {
        $input = $decoded;
    }
}

$volume = isset($input['volume']) ? (float) $input['volume'] : null;
$tinggi = isset($input['tinggi']) ? (float) $input['tinggi'] : null;
$jarak  = isset($input['jarak'])  ? (float) $input['jarak']  : null;

if ($volume === null || $tinggi === null || $jarak === null) {
    jsonResponse([
        'success' => false,
        'message' => 'Parameter volume, tinggi, dan jarak wajib dikirim.'
    ], 400);
}

if ($volume < 0 || $tinggi < 0 || $jarak < 0) {
    jsonResponse(['success' => false, 'message' => 'Nilai tidak boleh negatif.'], 400);
}

$status = tentukanStatusAir($volume);

try {
    $stmt = $pdo->prepare(
        "INSERT INTO monitoring (volume, tinggi, jarak, status, created_at) VALUES (?, ?, ?, ?, NOW())"
    );
    $stmt->execute([$volume, $tinggi, $jarak, $status]);

    jsonResponse([
        'success' => true,
        'message' => 'Data berhasil disimpan',
        'data' => [
            'id'     => $pdo->lastInsertId(),
            'volume' => $volume,
            'tinggi' => $tinggi,
            'jarak'  => $jarak,
            'status' => $status,
        ]
    ]);
} catch (Exception $e) {
    jsonResponse(['success' => false, 'message' => 'Gagal menyimpan data: ' . $e->getMessage()], 500);
}
