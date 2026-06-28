<?php

require_once '../includes/auth.php';
require_once '../config/database.php';
require_once '../includes/functions.php';

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
?>
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Export PDF — Riwayat Data Smart Water Monitoring</title>
<style>
  body { font-family: Arial, Helvetica, sans-serif; color: #0B2530; padding: 20px; }
  h1 { font-size: 18px; margin-bottom: 0; }
  p.subtitle { color: #4C7080; margin-top: 4px; font-size: 12px; }
  table { width: 100%; border-collapse: collapse; margin-top: 16px; font-size: 12px; }
  th, td { border: 1px solid #D3E6EA; padding: 6px 8px; text-align: left; }
  th { background: #EAF4F6; }
  .badge { padding: 2px 8px; border-radius: 10px; font-weight: bold; font-size: 11px; }
  .badge-success { background: #d9f4ea; color: #1FA97E; }
  .badge-warning { background: #fcefd2; color: #b9810f; }
  .badge-danger  { background: #fbe3e3; color: #c23d3d; }
  .no-print { margin-bottom: 16px; }
  @media print {
    .no-print { display: none; }
  }
</style>
</head>
<body onload="window.print()">

  <div class="no-print">
    <button onclick="window.print()" style="padding:8px 16px; cursor:pointer;">🖨️ Cetak / Simpan sebagai PDF</button>
  </div>

  <h1>💧 Smart Water Monitoring — Riwayat Data</h1>
  <p class="subtitle">
    Diekspor pada <?= date('d/m/Y H:i:s') ?>
    <?php if ($tglMulai || $tglSelesai): ?>
      | Periode: <?= $tglMulai ?: '...' ?> s/d <?= $tglSelesai ?: '...' ?>
    <?php endif; ?>
    <?php if ($search): ?> | Pencarian: "<?= htmlspecialchars($search) ?>"<?php endif; ?>
  </p>

  <table>
    <thead>
      <tr>
        <th>No</th>
        <th>Waktu</th>
        <th>Volume (mL)</th>
        <th>Tinggi (cm)</th>
        <th>Jarak (cm)</th>
        <th>Status</th>
      </tr>
    </thead>
    <tbody>
      <?php $no = 1; foreach ($rows as $row): ?>
        <?php
          $badgeClass = 'badge-secondary';
          if ($row['status'] === 'PENUH') $badgeClass = 'badge-success';
          elseif ($row['status'] === 'SEDANG') $badgeClass = 'badge-warning';
          elseif ($row['status'] === 'HAMPIR HABIS') $badgeClass = 'badge-danger';
        ?>
        <tr>
          <td><?= $no++ ?></td>
          <td><?= date('d/m/Y H:i:s', strtotime($row['created_at'])) ?></td>
          <td><?= $row['volume'] ?></td>
          <td><?= $row['tinggi'] ?></td>
          <td><?= $row['jarak'] ?></td>
          <td><span class="badge <?= $badgeClass ?>"><?= $row['status'] ?></span></td>
        </tr>
      <?php endforeach; ?>
      <?php if (count($rows) === 0): ?>
        <tr><td colspan="6" style="text-align:center;">Tidak ada data</td></tr>
      <?php endif; ?>
    </tbody>
  </table>

  <p style="margin-top:20px; font-size:11px; color:#7C9AA6;">Total data: <?= count($rows) ?> baris</p>

</body>
</html>
