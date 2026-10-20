<?php
session_start();
require_once 'helper/connection.php';

// Jika sudah login, redirect sesuai role
if (isset($_SESSION['user_id'])) {
    if ($_SESSION['user_role'] === 'ADMIN') {
        header("Location: admin-dashboard/index.php");
    } else if ($_SESSION['user_role'] === 'SELLER') {
        header("Location: seller-dashboard/index.php");
    } else {
        header("Location: index.php");
    }
    exit;
}

$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nim = mysqli_real_escape_string($conn, $_POST['nim']);
    $password = $_POST['password'];
    
    // Insert ke database
    $query = "INSERT INTO users (name, email, password, role) VALUES ('Mahasiswa', '$nim', '$password', 'SELLER')";
    mysqli_query($conn, $query);
    
    $success = "Pendaftaran berhasil! Sekarang anda dapat login.";
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Register | WiraKampus</title>
  
  <!-- Bootstrap -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">

  <!-- Icons -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">

  <!-- Favicon -->
  <link rel="icon" type="image/png" sizes="70x45" href="/wirakampus/img/logo_WK.png">

  <!-- CSS -->
  <link rel="stylesheet" href="css/globals.css">
  <link rel="stylesheet" href="css/style_register.css">
  
</head>
<body>
  <div class="auth-page">
    <div class="glass-card auth-card">
      <div class="auth-header">
        <h1>
          <span class="daftar">REGISTER</span>
        </h1>
        <p style="margin-top:-10px">dan rasakan pengalaman immersive dalam aktivitas jual beli di lingkungan mahasiswa</p>
      </div>
      
      <?php if ($error): ?>
        <div class="error-msg" style="margin-top:-20px"><?= $error ?></div>
      <?php endif; ?>
      <?php if ($success): ?>
        <div class="success-msg" style="margin-top:-20px"><?= $success ?></div>
      <?php endif; ?>
      
      <form method="POST" action="">
        <div class="form-group">
          <label>E-MAIL :</label>
          <input type="text" name="nim" required autocomplete="off">
        </div>
        
        <div class="form-group">
          <label>PASSWORD :</label>
          <input type="password" name="password" required>
        </div>

        <div class="auth-actions">
          <button type="submit" class="btn-primary" style="width:100%">REGISTER</button>
        </div>
      </form>
      
      <p style="text-align: center; margin-top: 24px; color: var(--text-secondary);">
          Sudah punya akun?
          <a href="login.php" style="color: var(--text-secondary); font-weight: 600; text-decoration: none;">
              Login sekarang!
          </a>
      </p>

      <div style="text-align: center; margin-top: 24px;">
        <a href="index.php" style="color: var(--text-muted); font-size: 13px; text-decoration: none;">&larr; Kembali ke Beranda</a>
      </div>
    </div>
  </div>
</body>
</html>
