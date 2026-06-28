<?php
session_start();
require_once 'config/database.php';

$error = '';

if (isset($_SESSION['admin_logged_in']) && $_SESSION['admin_logged_in'] === true) {
    header('Location: index.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';

    if ($username === '' || $password === '') {
        $error = 'Username dan password wajib diisi.';
    } else {
        $stmt = $pdo->prepare("SELECT * FROM users WHERE username = ? LIMIT 1");
        $stmt->execute([$username]);
        $user = $stmt->fetch();

        if ($user && password_verify($password, $user['password'])) {
            $_SESSION['admin_logged_in'] = true;
            $_SESSION['admin_username'] = $user['username'];
            header('Location: index.php');
            exit;
        } else {
            $error = 'Username atau password salah.';
        }
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Login Admin — Smart Water Monitoring</title>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
<link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
<div class="login-shell">
  <div class="login-card">
    <div class="text-center mb-4">
      <div class="mx-auto mb-2" style="font-size:2.5rem;">💧</div>
      <h1 class="page-title mb-1">Smart Water Monitoring</h1>
      <p class="page-subtitle">Masuk untuk mengakses dashboard</p>
    </div>

    <?php if ($error): ?>
      <div class="alert alert-danger d-flex align-items-center gap-2" role="alert">
        <i class="bi bi-exclamation-triangle-fill"></i>
        <span><?= htmlspecialchars($error) ?></span>
      </div>
    <?php endif; ?>

    <form method="POST" action="login.php">
      <div class="mb-3">
        <label for="username">Username</label>
        <input type="text" class="form-control" id="username" name="username" placeholder="admin" required autofocus>
      </div>
      <div class="mb-4">
        <label for="password">Password</label>
        <input type="password" class="form-control" id="password" name="password" placeholder="••••••••" required>
      </div>
      <button type="submit" class="btn btn-aqua w-100">
        <i class="bi bi-box-arrow-in-right"></i> Masuk
      </button>
    </form>

    <p class="text-center mt-4 mb-0" style="font-size:0.8rem; color:var(--text-muted);">
      Default: admin / admin123
    </p>
  </div>
</div>
</body>
</html>
