<?php
require_once 'includes/auth.php';
require_once 'config/database.php';
require_once 'includes/functions.php';

$activePage = 'riwayat';
?>
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Riwayat Data — Smart Water Monitoring</title>
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
        <h1 class="page-title">📋 Riwayat Data</h1>
        <p class="page-subtitle">Seluruh data yang dikirim oleh ESP32</p>
      </div>
      <div class="d-flex gap-2">
        <a href="#" id="btnExportCsv" class="btn btn-outline-aqua btn-sm"><i class="bi bi-filetype-csv"></i> Export CSV</a>
        <a href="#" id="btnExportPdf" class="btn btn-outline-aqua btn-sm" target="_blank"><i class="bi bi-filetype-pdf"></i> Export PDF</a>
      </div>
    </div>

    <div class="panel p-3 mb-3">
      <div class="row g-2 align-items-end">
        <div class="col-md-4">
          <label>Cari (status / volume / tinggi)</label>
          <input type="text" class="form-control" id="searchInput" placeholder="Contoh: PENUH atau 420">
        </div>
        <div class="col-md-3">
          <label>Dari Tanggal</label>
          <input type="date" class="form-control" id="tglMulai">
        </div>
        <div class="col-md-3">
          <label>Sampai Tanggal</label>
          <input type="date" class="form-control" id="tglSelesai">
        </div>
        <div class="col-md-2 d-flex gap-2">
          <button class="btn btn-aqua w-100" id="btnFilter"><i class="bi bi-funnel"></i> Filter</button>
        </div>
      </div>
      <div class="mt-2">
        <button class="btn btn-sm btn-link p-0" id="btnReset" style="color:var(--text-muted);">Reset filter</button>
      </div>
    </div>

    <div class="table-panel">
      <div class="table-responsive">
        <table class="table">
          <thead>
            <tr>
              <th>No</th>
              <th>Waktu</th>
              <th>Volume</th>
              <th>Tinggi</th>
              <th>Jarak</th>
              <th>Status</th>
            </tr>
          </thead>
          <tbody id="tableBody">
            <tr><td colspan="6" class="text-center py-4" style="color:var(--text-muted);">Memuat data...</td></tr>
          </tbody>
        </table>
      </div>
    </div>

    <div class="d-flex justify-content-between align-items-center mt-3">
      <span style="font-size:0.85rem; color:var(--text-muted);" id="infoTotal">-</span>
      <nav>
        <ul class="pagination pagination-sm mb-0" id="paginationArea"></ul>
      </nav>
    </div>

  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="assets/js/theme.js"></script>
<script>
let currentPage = 1;

function badgeClass(warna) {
  return 'status-pill ' + warna;
}

function buildQuery(page) {
  const params = new URLSearchParams();
  params.set('page', page);
  const search = document.getElementById('searchInput').value.trim();
  const tglMulai = document.getElementById('tglMulai').value;
  const tglSelesai = document.getElementById('tglSelesai').value;
  if (search) params.set('search', search);
  if (tglMulai) params.set('tgl_mulai', tglMulai);
  if (tglSelesai) params.set('tgl_selesai', tglSelesai);
  return params.toString();
}

function loadData(page = 1) {
  currentPage = page;
  const query = buildQuery(page);

  fetch('api/riwayat_data.php?' + query)
    .then(res => res.json())
    .then(json => {
      if (!json.success) return;

      const tbody = document.getElementById('tableBody');
      tbody.innerHTML = '';

      if (json.data.length === 0) {
        tbody.innerHTML = '<tr><td colspan="6" class="text-center py-4" style="color:var(--text-muted);">Tidak ada data ditemukan</td></tr>';
      } else {
        const startNo = (json.page - 1) * json.per_page;
        json.data.forEach((row, idx) => {
          tbody.innerHTML += `
            <tr>
              <td>${startNo + idx + 1}</td>
              <td class="mono">${row.waktu}</td>
              <td>${row.volume} mL</td>
              <td>${row.tinggi} cm</td>
              <td>${row.jarak} cm</td>
              <td><span class="${badgeClass(row.warna)}">${row.emoji} ${row.status}</span></td>
            </tr>`;
        });
      }

      document.getElementById('infoTotal').textContent = `Menampilkan ${json.data.length} dari ${json.total} data`;
      renderPagination(json.page, json.total_page);
    })
    .catch(err => console.error('Gagal memuat riwayat:', err));
}

function renderPagination(page, totalPage) {
  const area = document.getElementById('paginationArea');
  area.innerHTML = '';

  function pageItem(label, targetPage, disabled, active) {
    return `<li class="page-item ${disabled ? 'disabled' : ''} ${active ? 'active' : ''}">
      <a class="page-link" href="#" data-page="${targetPage}">${label}</a>
    </li>`;
  }

  area.innerHTML += pageItem('&laquo;', page - 1, page <= 1, false);
  for (let i = 1; i <= totalPage; i++) {
    if (totalPage > 7 && Math.abs(i - page) > 2 && i !== 1 && i !== totalPage) {
      if (i === 2 || i === totalPage - 1) area.innerHTML += `<li class="page-item disabled"><span class="page-link">...</span></li>`;
      continue;
    }
    area.innerHTML += pageItem(i, i, false, i === page);
  }
  area.innerHTML += pageItem('&raquo;', page + 1, page >= totalPage, false);

  area.querySelectorAll('a.page-link').forEach(a => {
    a.addEventListener('click', function (e) {
      e.preventDefault();
      const target = parseInt(this.dataset.page);
      if (!isNaN(target) && target >= 1 && target <= totalPage) loadData(target);
    });
  });
}

document.getElementById('btnFilter').addEventListener('click', () => loadData(1));
document.getElementById('searchInput').addEventListener('keyup', (e) => { if (e.key === 'Enter') loadData(1); });
document.getElementById('btnReset').addEventListener('click', () => {
  document.getElementById('searchInput').value = '';
  document.getElementById('tglMulai').value = '';
  document.getElementById('tglSelesai').value = '';
  loadData(1);
});

document.getElementById('btnExportCsv').addEventListener('click', function (e) {
  e.preventDefault();
  window.location.href = 'api/export_csv.php?' + buildQuery(1);
});
document.getElementById('btnExportPdf').addEventListener('click', function (e) {
  e.preventDefault();
  window.open('api/export_pdf.php?' + buildQuery(1), '_blank');
});

loadData(1);

setInterval(() => loadData(currentPage), 5000);
</script>
</body>
</html>
