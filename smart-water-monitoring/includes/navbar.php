<?php
if (!isset($activePage)) {
    $activePage = '';
}
$username = $_SESSION['admin_username'] ?? 'Admin';
?>
<nav class="navbar navbar-expand-lg sticky-top main-navbar">
  <div class="container-fluid">
    <a class="navbar-brand d-flex align-items-center gap-2" href="index.php">
      <span class="brand-icon">💧</span>
      <span class="brand-text">Smart Water Monitoring</span>
    </a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navMenu">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navMenu">
      <ul class="navbar-nav ms-auto align-items-lg-center gap-1">
        <li class="nav-item">
          <a class="nav-link <?= $activePage === 'dashboard' ? 'active' : '' ?>" href="index.php">
            <i class="bi bi-speedometer2"></i> Dashboard
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link <?= $activePage === 'riwayat' ? 'active' : '' ?>" href="riwayat.php">
            <i class="bi bi-table"></i> Riwayat Data
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link <?= $activePage === 'grafik' ? 'active' : '' ?>" href="grafik.php">
            <i class="bi bi-graph-up"></i> Grafik
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link <?= $activePage === 'tentang' ? 'active' : '' ?>" href="tentang.php">
            <i class="bi bi-info-circle"></i> Tentang
          </a>
        </li>
        <li class="nav-item ms-lg-2">
          <button id="themeToggle" class="btn btn-sm btn-theme-toggle" title="Ganti tema">
            <span id="themeIcon">🌙</span> <span id="themeLabel">Dark</span>
          </button>
        </li>
        <li class="nav-item dropdown ms-lg-2">
          <a class="nav-link dropdown-toggle d-flex align-items-center gap-1" href="#" role="button" data-bs-toggle="dropdown">
            <i class="bi bi-person-circle"></i> <?= htmlspecialchars($username) ?>
          </a>
          <ul class="dropdown-menu dropdown-menu-end">
            <li><a class="dropdown-item text-danger" href="logout.php"><i class="bi bi-box-arrow-right"></i> Logout</a></li>
          </ul>
        </li>
      </ul>
    </div>
  </div>
</nav>
