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
          <p style="color:var(--text-primary); margin-bottom:0;">
            <strong>Smart Water Monitoring System</strong> merupakan sistem monitoring volume air berbasis
            <strong>ESP32</strong> yang menggunakan sensor ultrasonik <strong>SRF05</strong> untuk mengukur
            ketinggian permukaan air. Data yang diperoleh diproses oleh ESP32 untuk menghitung volume air
            dalam satuan mililiter (mL). Sistem dilengkapi dengan <strong>buzzer</strong> sebagai indikator
            ketika volume air melebihi batas yang telah ditentukan, dan layar <strong>OLED</strong> untuk
            menampilkan data secara langsung di perangkat. Selanjutnya, data dikirim melalui jaringan WiFi
            menggunakan protokol HTTP ke server PHP dan disimpan pada database MySQL, sehingga dapat
            dipantau melalui website secara real-time.
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
              <span>
                Rizky Surya Diputra<br>
                <small style="color:var(--text-muted);">23552011390</small>
              </span>
            </li>
            <li class="d-flex align-items-center gap-2 py-2" style="border-bottom:1px solid var(--border-color);">
              <span class="about-icon-box" style="width:36px; height:36px; font-size:1rem;">👤</span>
              <span>
                Karina NurFadilla<br>
                <small style="color:var(--text-muted);">23552011012</small>
              </span>
            </li>
            <li class="d-flex align-items-center gap-2 py-2">
              <span class="about-icon-box" style="width:36px; height:36px; font-size:1rem;">👤</span>
              <span>
                Liesna Nur'aeni Apriliani<br>
                <small style="color:var(--text-muted);">23552011394</small>
              </span>
            </li>
          </ul>
        </div>
      </div>
    </div>

    <!-- Komponen -->
    <div class="row g-3 mb-3">
      <div class="col-12">
        <div class="panel p-4 h-100">
          <h2 class="h6 text-uppercase fw-bold mb-3" style="color:var(--text-secondary); letter-spacing:0.05em;">Komponen yang Digunakan</h2>
          <div class="row g-3">
            <div class="col-md-3 col-6 d-flex gap-2 align-items-start">
              <span class="about-icon-box">🖥️</span>
              <div>
                <strong>ESP32 Wemos D1 R32</strong><br>
                <small style="color:var(--text-secondary);">Mikrokontroler utama</small>
              </div>
            </div>
            <div class="col-md-3 col-6 d-flex gap-2 align-items-start">
              <span class="about-icon-box">📡</span>
              <div>
                <strong>Sensor SRF05</strong><br>
                <small style="color:var(--text-secondary);">Mengukur jarak permukaan air</small>
              </div>
            </div>
            <div class="col-md-3 col-6 d-flex gap-2 align-items-start">
              <span class="about-icon-box">📺</span>
              <div>
                <strong>OLED SSD1306</strong><br>
                <small style="color:var(--text-secondary);">Menampilkan data monitoring</small>
              </div>
            </div>
            <div class="col-md-3 col-6 d-flex gap-2 align-items-start">
              <span class="about-icon-box">🔔</span>
              <div>
                <strong>Buzzer</strong><br>
                <small style="color:var(--text-secondary);">Alarm saat air hampir penuh</small>
              </div>
            </div>
            <div class="col-md-3 col-6 d-flex gap-2 align-items-start">
              <span class="about-icon-box">🍞</span>
              <div>
                <strong>Breadboard</strong><br>
                <small style="color:var(--text-secondary);">Media perakitan rangkaian</small>
              </div>
            </div>
            <div class="col-md-3 col-6 d-flex gap-2 align-items-start">
              <span class="about-icon-box">🔌</span>
              <div>
                <strong>Kabel Jumper</strong><br>
                <small style="color:var(--text-secondary);">Menghubungkan komponen</small>
              </div>
            </div>
            <div class="col-md-3 col-6 d-flex gap-2 align-items-start">
              <span class="about-icon-box">📶</span>
              <div>
                <strong>Wi-Fi</strong><br>
                <small style="color:var(--text-secondary);">Mengirim data ke server</small>
              </div>
            </div>
            <div class="col-md-3 col-6 d-flex gap-2 align-items-start">
              <span class="about-icon-box">💾</span>
              <div>
                <strong>Website &amp; MySQL</strong><br>
                <small style="color:var(--text-secondary);">Menyimpan dan menampilkan data</small>
              </div>
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
          <p class="mb-0" style="color:var(--text-secondary); font-size:0.9rem;">Sensor ultrasonik SRF05 mengukur jarak antara sensor dan permukaan air di dalam tangki.</p>
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
          <strong>OLED &amp; buzzer memberi indikator langsung</strong>
          <p class="mb-0" style="color:var(--text-secondary); font-size:0.9rem;">Layar OLED menampilkan jarak, tinggi air, dan volume secara langsung di perangkat, sementara buzzer akan menyala otomatis saat volume air melebihi ambang batas yang ditentukan.</p>
        </div>
      </div>
      <div class="flow-step">
        <span class="flow-number">04</span>
        <div>
          <strong>Data dikirim ke server via HTTP POST</strong>
          <p class="mb-0" style="color:var(--text-secondary); font-size:0.9rem;">ESP32 terhubung ke jaringan Wi-Fi dan mengirim data (volume, tinggi, jarak) ke endpoint <code>api/kirim_data.php</code> setiap beberapa detik.</p>
        </div>
      </div>
      <div class="flow-step">
        <span class="flow-number">05</span>
        <div>
          <strong>Server menyimpan data ke database</strong>
          <p class="mb-0" style="color:var(--text-secondary); font-size:0.9rem;">PHP memproses data masuk, menentukan status air (Hampir Habis/Sedang/Penuh), lalu menyimpannya ke tabel <code>monitoring</code> di MySQL.</p>
        </div>
      </div>
      <div class="flow-step">
        <span class="flow-number">06</span>
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
