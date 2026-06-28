<?php
require_once 'includes/auth.php';
$activePage = 'tentang';
?>
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Tentang — Smart Water Monitoring</title>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
<link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
<div class="page-wrapper">
  <?php include 'includes/navbar.php'; ?>

  <div class="container py-4">
    <div class="mb-4">
      <h1 class="page-title">ℹ️ Tentang Proyek</h1>
      <p class="page-subtitle">Smart Water Monitoring System berbasis ESP32</p>
    </div>

    <div class="row g-3 mb-3">
      <!-- Deskripsi Proyek -->
      <div class="col-lg-8">
        <div class="panel p-4 h-100">
          <h2 class="h6 text-uppercase fw-bold mb-3" style="color:var(--text-secondary); letter-spacing:0.05em;">Deskripsi Proyek</h2>
          <p style="color:var(--text-primary);">
            <strong>Smart Water Monitoring</strong> adalah sistem pemantauan volume dan tinggi air pada tangki
            secara <em>real-time</em> menggunakan mikrokontroler <strong>ESP32</strong> yang terhubung ke sensor
            ultrasonik. Data sensor dikirim secara berkala ke server melalui protokol <strong>HTTP POST</strong>,
            kemudian disimpan ke dalam database <strong>MySQL</strong> dan ditampilkan pada dashboard web yang
            dapat diakses dari komputer maupun perangkat mobile.
          </p>
          <p style="color:var(--text-primary); margin-bottom:0;">
            Sistem ini bertujuan membantu pemantauan ketersediaan air pada tangki penyimpanan agar pengguna dapat
            mengetahui kondisi air tanpa harus memeriksa secara manual, lengkap dengan notifikasi otomatis saat
            volume air hampir penuh atau hampir habis.
          </p>
        </div>
      </div>

      <!-- Anggota -->
      <div class="col-lg-4">
        <div class="panel p-4 h-100">
          <h2 class="h6 text-uppercase fw-bold mb-3" style="color:var(--text-secondary); letter-spacing:0.05em;">Anggota Tim</h2>
          <ul class="list-unstyled mb-0">
            <li class="d-flex align-items-center gap-2 py-2" style="border-bottom:1px solid var(--border-color);">
              <span class="about-icon-box" style="width:36px; height:36px; font-size:1rem;">👤</span>
              <span>Nama Anggota 1 — Hardware &amp; ESP32</span>
            </li>
            <li class="d-flex align-items-center gap-2 py-2" style="border-bottom:1px solid var(--border-color);">
              <span class="about-icon-box" style="width:36px; height:36px; font-size:1rem;">👤</span>
              <span>Nama Anggota 2 — Backend PHP</span>
            </li>
            <li class="d-flex align-items-center gap-2 py-2">
              <span class="about-icon-box" style="width:36px; height:36px; font-size:1rem;">👤</span>
              <span>Nama Anggota 3 — Frontend &amp; UI</span>
            </li>
          </ul>
          <p class="mt-3 mb-0" style="font-size:0.8rem; color:var(--text-muted);">
            *Ganti dengan nama anggota tim Anda yang sebenarnya pada file <code>tentang.php</code>.
          </p>
        </div>
      </div>
    </div>

    <div class="row g-3 mb-3">
      <!-- Komponen -->
      <div class="col-lg-6">
        <div class="panel p-4 h-100">
          <h2 class="h6 text-uppercase fw-bold mb-3" style="color:var(--text-secondary); letter-spacing:0.05em;">Komponen yang Digunakan</h2>
          <div class="row g-3">
            <div class="col-6 d-flex gap-2 align-items-start">
              <span class="about-icon-box">🔌</span>
              <div><strong>ESP32</strong><br><small style="color:var(--text-secondary);">Mikrokontroler utama</small></div>
            </div>
            <div class="col-6 d-flex gap-2 align-items-start">
              <span class="about-icon-box">📡</span>
              <div><strong>Sensor Ultrasonik HC-SR04</strong><br><small style="color:var(--text-secondary);">Mengukur jarak/tinggi air</small></div>
            </div>
            <div class="col-6 d-flex gap-2 align-items-start">
              <span class="about-icon-box">🔋</span>
              <div><strong>Power Supply</strong><br><small style="color:var(--text-secondary);">Sumber daya ESP32</small></div>
            </div>
            <div class="col-6 d-flex gap-2 align-items-start">
              <span class="about-icon-box">📶</span>
              <div><strong>Wi-Fi</strong><br><small style="color:var(--text-secondary);">Koneksi ke server</small></div>
            </div>
          </div>
        </div>
      </div>

      <!-- Teknologi -->
      <div class="col-lg-6">
        <div class="panel p-4 h-100">
          <h2 class="h6 text-uppercase fw-bold mb-3" style="color:var(--text-secondary); letter-spacing:0.05em;">Teknologi yang Digunakan</h2>
          <div class="row g-2">
            <div class="col-6">
              <strong style="color:var(--accent-wave);">Frontend</strong>
              <ul class="mt-1" style="font-size:0.88rem; color:var(--text-primary); padding-left:1.1rem;">
                <li>HTML5 &amp; CSS3</li>
                <li>Bootstrap 5</li>
                <li>JavaScript (Fetch API)</li>
                <li>Chart.js</li>
              </ul>
            </div>
            <div class="col-6">
              <strong style="color:var(--accent-wave);">Backend &amp; Server</strong>
              <ul class="mt-1" style="font-size:0.88rem; color:var(--text-primary); padding-left:1.1rem;">
                <li>PHP (native, PDO)</li>
                <li>MySQL</li>
                <li>HTTP POST</li>
                <li>Laragon / XAMPP</li>
              </ul>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Cara Kerja Sistem -->
    <div class="panel p-4">
      <h2 class="h6 text-uppercase fw-bold mb-2" style="color:var(--text-secondary); letter-spacing:0.05em;">Cara Kerja Sistem</h2>
      <div class="flow-step">
        <span class="flow-number">01</span>
        <div>
          <strong>Sensor membaca jarak</strong>
          <p class="mb-0" style="color:var(--text-secondary); font-size:0.9rem;">Sensor ultrasonik HC-SR04 mengukur jarak antara sensor dan permukaan air di dalam tangki.</p>
        </div>
      </div>
      <div class="flow-step">
        <span class="flow-number">02</span>
        <div>
          <strong>ESP32 menghitung tinggi &amp; volume air</strong>
          <p class="mb-0" style="color:var(--text-secondary); font-size:0.9rem;">Berdasarkan jarak sensor dan tinggi tangki, ESP32 menghitung tinggi air dan mengonversinya menjadi volume (mL).</p>
        </div>
      </div>
      <div class="flow-step">
        <span class="flow-number">03</span>
        <div>
          <strong>Data dikirim ke server via HTTP POST</strong>
          <p class="mb-0" style="color:var(--text-secondary); font-size:0.9rem;">ESP32 terhubung ke jaringan Wi-Fi dan mengirim data (volume, tinggi, jarak) ke endpoint <code>api/kirim_data.php</code> setiap beberapa detik.</p>
        </div>
      </div>
      <div class="flow-step">
        <span class="flow-number">04</span>
        <div>
          <strong>Server menyimpan data ke database</strong>
          <p class="mb-0" style="color:var(--text-secondary); font-size:0.9rem;">PHP memproses data masuk, menentukan status air (Hampir Habis/Sedang/Penuh), lalu menyimpannya ke tabel <code>monitoring</code> di MySQL.</p>
        </div>
      </div>
      <div class="flow-step">
        <span class="flow-number">05</span>
        <div>
          <strong>Dashboard menampilkan data secara real-time</strong>
          <p class="mb-0" style="color:var(--text-secondary); font-size:0.9rem;">Halaman web mengambil data terbaru secara otomatis menggunakan Fetch API setiap 2 detik tanpa perlu me-reload halaman.</p>
        </div>
      </div>
    </div>

  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="assets/js/theme.js"></script>
</body>
</html>
