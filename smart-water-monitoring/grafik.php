<?php
require_once 'includes/auth.php';
$activePage = 'grafik';
?>
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Grafik Monitoring — Smart Water Monitoring</title>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
<link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
<div class="page-wrapper">
  <?php include 'includes/navbar.php'; ?>

  <div class="container py-4">
    <div class="d-flex flex-wrap justify-content-between align-items-end gap-3 mb-4">
      <div>
        <h1 class="page-title">📈 Grafik Monitoring</h1>
        <p class="page-subtitle">Tren volume dan tinggi air — diperbarui otomatis setiap 3 detik</p>
      </div>
      <div class="d-flex align-items-center gap-2">
        <label class="mb-0" style="white-space:nowrap;">Jumlah data:</label>
        <select id="limitSelect" class="form-select form-select-sm" style="width:auto;">
          <option value="10">10 terakhir</option>
          <option value="20" selected>20 terakhir</option>
          <option value="50">50 terakhir</option>
          <option value="100">100 terakhir</option>
        </select>
      </div>
    </div>

    <div class="row g-3">
      <div class="col-lg-6">
        <div class="panel p-4">
          <h2 class="h6 text-uppercase fw-bold mb-3" style="color:var(--text-secondary); letter-spacing:0.05em;">
            💧 Volume Air (mL)
          </h2>
          <div class="chart-container">
            <canvas id="chartVolume"></canvas>
          </div>
        </div>
      </div>
      <div class="col-lg-6">
        <div class="panel p-4">
          <h2 class="h6 text-uppercase fw-bold mb-3" style="color:var(--text-secondary); letter-spacing:0.05em;">
            📏 Tinggi Air (cm)
          </h2>
          <div class="chart-container">
            <canvas id="chartTinggi"></canvas>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.4/dist/chart.umd.min.js"></script>
<script src="assets/js/theme.js"></script>
<script>
let chartVolume, chartTinggi;

function getThemeColors() {
  const isDark = document.documentElement.getAttribute('data-theme') === 'dark';
  return {
    grid: isDark ? 'rgba(255,255,255,0.06)' : 'rgba(14,58,76,0.06)',
    text: isDark ? '#9FC2CC' : '#4C7080',
  };
}

function buildChart(ctx, label, color, bgColor) {
  const colors = getThemeColors();
  return new Chart(ctx, {
    type: 'line',
    data: {
      labels: [],
      datasets: [{
        label: label,
        data: [],
        borderColor: color,
        backgroundColor: bgColor,
        fill: true,
        tension: 0.35,
        pointRadius: 3,
        pointBackgroundColor: color,
        borderWidth: 2.5,
      }]
    },
    options: {
      responsive: true,
      maintainAspectRatio: false,
      animation: { duration: 400 },
      scales: {
        x: { grid: { color: colors.grid }, ticks: { color: colors.text, font: { size: 11 } } },
        y: { grid: { color: colors.grid }, ticks: { color: colors.text, font: { size: 11 } }, beginAtZero: true }
      },
      plugins: {
        legend: { display: false },
        tooltip: { mode: 'index', intersect: false }
      }
    }
  });
}

document.addEventListener('DOMContentLoaded', function () {
  chartVolume = buildChart(document.getElementById('chartVolume'), 'Volume (mL)', '#19B8C4', 'rgba(25,184,196,0.12)');
  chartTinggi = buildChart(document.getElementById('chartTinggi'), 'Tinggi Air (cm)', '#2E8FA6', 'rgba(46,143,166,0.12)');
  updateCharts();
});

function updateCharts() {
  const limit = document.getElementById('limitSelect').value;
  fetch('api/grafik_data.php?limit=' + limit)
    .then(res => res.json())
    .then(json => {
      if (!json.success) return;
      chartVolume.data.labels = json.labels;
      chartVolume.data.datasets[0].data = json.volume;
      chartVolume.update();

      chartTinggi.data.labels = json.labels;
      chartTinggi.data.datasets[0].data = json.tinggi;
      chartTinggi.update();
    })
    .catch(err => console.error('Gagal memuat data grafik:', err));
}

document.getElementById('limitSelect').addEventListener('change', updateCharts);

// Grafik berubah otomatis setiap 3 detik
setInterval(updateCharts, 3000);
</script>
</body>
</html>
