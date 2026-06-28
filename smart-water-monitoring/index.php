<?php
require_once 'includes/auth.php';
require_once 'config/database.php';
require_once 'includes/functions.php';

$stmt = $pdo->query("SELECT * FROM monitoring ORDER BY created_at DESC LIMIT 1");
$data = $stmt->fetch();

$volume   = $data['volume'] ?? 0;
$tinggi   = $data['tinggi'] ?? 0;
$jarak    = $data['jarak'] ?? 0;
$status   = $data['status'] ?? tentukanStatusAir(0);
$lastTime = $data['created_at'] ?? null;

$online      = sensorOnline($lastTime);
$persen      = persentaseVolume($volume);
$warnaStatus = warnaStatusAir($status);
$notif       = cekNotifikasi($volume);

$activePage = 'dashboard';
?>
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Dashboard — Smart Water Monitoring</title>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
<link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
<div class="page-wrapper">
  <?php include 'includes/navbar.php'; ?>

  <div class="container py-4">

    <div class="sensor-wave-bg mb-4">
      <div class="d-flex flex-wrap justify-content-between align-items-center gap-3">
        <div>
          <h1 class="mb-1" style="font-size:1.5rem;">🌊 SMART WATER MONITORING</h1>
          <p class="mb-0" style="opacity:0.85; font-size:0.9rem;">Pemantauan volume &amp; tinggi air tangki secara real-time</p>
        </div>
        <div class="update-ticker text-white" id="lastUpdateBox">
          <span class="pulse-dot <?= $online ? '' : 'offline' ?>" id="pulseDot"></span>
          <span id="updateText">Update terakhir: <?= $lastTime ? date('d/m/Y H:i:s', strtotime($lastTime)) : '-' ?></span>
        </div>
      </div>
      <svg viewBox="0 0 1440 100" preserveAspectRatio="none"><path fill="#ffffff" d="M0,40 C360,100 1080,0 1440,60 L1440,100 L0,100 Z"></path></svg>
    </div>

    <div id="notifArea">
      <?php if ($notif): ?>
        <div class="notif-banner <?= $notif['type'] ?>">
          <span><?= $notif['message'] ?></span>
        </div>
      <?php endif; ?>
    </div>

    <div class="row g-3 mb-4" id="metricCards">
      <div class="col-6 col-md-3">
        <div class="metric-card">
          <div class="metric-icon">💧</div>
          <div class="metric-label">Volume Air</div>
          <div class="metric-value" id="cardVolume"><?= number_format($volume, 0) ?> <small style="font-size:1rem;">mL</small></div>
          <div class="metric-sub" id="cardPersen"><?= $persen ?>% kapasitas</div>
        </div>
      </div>
      <div class="col-6 col-md-3">
        <div class="metric-card">
          <div class="metric-icon">📏</div>
          <div class="metric-label">Tinggi Air</div>
          <div class="metric-value" id="cardTinggi"><?= number_format($tinggi, 1) ?> <small style="font-size:1rem;">cm</small></div>
          <div class="metric-sub">dari dasar tangki</div>
        </div>
      </div>
      <div class="col-6 col-md-3">
        <div class="metric-card">
          <div class="metric-icon">📡</div>
          <div class="metric-label">Jarak Sensor</div>
          <div class="metric-value" id="cardJarak"><?= number_format($jarak, 1) ?> <small style="font-size:1rem;">cm</small></div>
          <div class="metric-sub">ke permukaan air</div>
        </div>
      </div>
      <div class="col-6 col-md-3">
        <div class="metric-card">
          <div class="metric-icon">⚙️</div>
          <div class="metric-label">Status Sensor</div>
          <div class="metric-value" style="font-size:1.1rem;">
            <span class="status-pill <?= $online ? 'success' : 'danger' ?>" id="sensorStatusPill">
              <?= $online ? '🟢 Online' : '🔴 Offline' ?>
            </span>
          </div>
          <div class="metric-sub">ESP32</div>
        </div>
      </div>
    </div>

    <div class="row g-3">
      <div class="col-lg-6">
        <div class="panel p-4 h-100">
          <h2 class="h6 text-uppercase fw-bold" style="color:var(--text-secondary); letter-spacing:0.05em;">Status Air</h2>
          <div class="d-flex align-items-center gap-3 mb-3">
            <span class="status-pill <?= $warnaStatus ?>" style="font-size:1rem;" id="statusBadgeBig">
              <?= emojiStatusAir($status) ?> <?= $status ?>
            </span>
          </div>
          <div class="water-progress mb-2">
            <div class="water-progress-fill <?= $warnaStatus ?>" id="progressFill" style="width: <?= $persen ?>%;">
              <span id="progressLabel"><?= $persen ?>%</span>
            </div>
          </div>
          <p class="mb-0" style="font-size:0.85rem; color:var(--text-muted);">
            Kapasitas maksimum tangki: <?= KAPASITAS_MAKSIMUM_ML ?> mL
          </p>
        </div>
      </div>

      <div class="col-lg-6">
        <div class="panel p-4 h-100">
          <h2 class="h6 text-uppercase fw-bold" style="color:var(--text-secondary); letter-spacing:0.05em;">Ringkasan</h2>
          <div class="d-flex justify-content-between py-2" style="border-bottom:1px solid var(--border-color);">
            <span style="color:var(--text-secondary);">Tanggal</span>
            <span class="fw-semibold mono"><?= $lastTime ? formatTanggalIndo($lastTime) : '-' ?></span>
          </div>
          <div class="d-flex justify-content-between py-2" style="border-bottom:1px solid var(--border-color);">
            <span style="color:var(--text-secondary);">Jam</span>
            <span class="fw-semibold mono" id="ringkasanJam"><?= $lastTime ? date('H:i:s', strtotime($lastTime)) : '-' ?></span>
          </div>
          <div class="d-flex justify-content-between py-2" style="border-bottom:1px solid var(--border-color);">
            <span style="color:var(--text-secondary);">Status Tangki</span>
            <span class="fw-semibold" id="ringkasanStatus"><?= $status ?></span>
          </div>
          <div class="d-flex justify-content-between py-2">
            <span style="color:var(--text-secondary);">Sensor</span>
            <span class="fw-semibold" id="ringkasanSensor"><?= $online ? 'Online' : 'Offline' ?></span>
          </div>
        </div>
      </div>
    </div>

    <div class="panel p-4 mt-3 text-center">
      <p class="mb-2" style="color:var(--text-secondary);">📈 Ingin melihat tren data lebih detail?</p>
      <a href="grafik.php" class="btn btn-outline-aqua">Lihat Grafik Monitoring</a>
      <a href="riwayat.php" class="btn btn-outline-aqua ms-2">Lihat Riwayat Data</a>
    </div>

  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="assets/js/theme.js"></script>
<script>

function formatTanggalIndo(dateStr) {
  const bulan = ['Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember'];
  const d = new Date(dateStr);
  return d.getDate() + ' ' + bulan[d.getMonth()] + ' ' + d.getFullYear();
}

function pad(n) { return n.toString().padStart(2, '0'); }

function updateDashboard() {
  fetch('api/get_latest.php')
    .then(res => res.json())
    .then(json => {
      if (!json.success || !json.data) return;
      const d = json.data;

      document.getElementById('cardVolume').innerHTML = Math.round(d.volume) + ' <small style="font-size:1rem;">mL</small>';
      document.getElementById('cardTinggi').innerHTML = parseFloat(d.tinggi).toFixed(1) + ' <small style="font-size:1rem;">cm</small>';
      document.getElementById('cardJarak').innerHTML = parseFloat(d.jarak).toFixed(1) + ' <small style="font-size:1rem;">cm</small>';
      document.getElementById('cardPersen').textContent = d.persentase + '% kapasitas';

      const fill = document.getElementById('progressFill');
      fill.style.width = d.persentase + '%';
      fill.className = 'water-progress-fill ' + d.warna_status;
      document.getElementById('progressLabel').textContent = d.persentase + '%';

      const badge = document.getElementById('statusBadgeBig');
      badge.className = 'status-pill ' + d.warna_status;
      badge.style.fontSize = '1rem';
      badge.innerHTML = d.emoji_status + ' ' + d.status;

      const pill = document.getElementById('sensorStatusPill');
      const dot = document.getElementById('pulseDot');
      if (d.sensor_online) {
        pill.className = 'status-pill success';
        pill.innerHTML = '🟢 Online';
        dot.classList.remove('offline');
      } else {
        pill.className = 'status-pill danger';
        pill.innerHTML = '🔴 Offline';
        dot.classList.add('offline');
      }

      const dt = new Date(d.created_at.replace(' ', 'T'));
      document.getElementById('updateText').textContent = 'Update terakhir: ' + pad(dt.getDate()) + '/' + pad(dt.getMonth()+1) + '/' + dt.getFullYear() + ' ' + pad(dt.getHours()) + ':' + pad(dt.getMinutes()) + ':' + pad(dt.getSeconds());

      document.getElementById('ringkasanJam').textContent = pad(dt.getHours()) + ':' + pad(dt.getMinutes()) + ':' + pad(dt.getSeconds());
      document.getElementById('ringkasanStatus').textContent = d.status;
      document.getElementById('ringkasanSensor').textContent = d.sensor_online ? 'Online' : 'Offline';

      const notifArea = document.getElementById('notifArea');
      if (d.notifikasi) {
        notifArea.innerHTML = '<div class="notif-banner ' + d.notifikasi.type + '"><span>' + d.notifikasi.message + '</span></div>';
      } else {
        notifArea.innerHTML = '';
      }
    })
    .catch(err => console.error('Gagal mengambil data terbaru:', err));
}

setInterval(updateDashboard, 2000);
</script>
</body>
</html>
