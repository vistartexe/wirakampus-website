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

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $email = mysqli_real_escape_string($conn, $_POST['nim']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);

    $result = mysqli_query(
        $conn,
        "SELECT *
         FROM users
         WHERE email = '$email'
         AND password = '$password'
         LIMIT 1"
    );

    if(mysqli_num_rows($result) > 0){

        $user = mysqli_fetch_assoc($result);

        $_SESSION['user_id'] = $user['id'];
        $_SESSION['user_name'] = $user['name'];
        $_SESSION['user_role'] = $user['role'];
        $_SESSION['profile_pic'] = $user['profile_pic'];

        if($user['role'] == 'ADMIN'){
            header("Location: admin-dashboard/index.php");
        } else {
            header("Location: seller-dashboard/index.php");
        }

        exit;

    } else {
        $error = "E-mail atau Password salah!";
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Login | WiraKampus</title>
  
  <!-- Bootstrap -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">

  <!-- Icons -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">

  <!-- Favicon -->
  <link rel="icon" type="image/png" sizes="70x45" href="/wirakampus/img/logo_WK.png">

  <!-- CSS -->
  <link rel="stylesheet" href="css/globals.css">
  <link rel="stylesheet" href="css/style_index.css">
  <link rel="stylesheet" href="css/style_login.css">
  
</head>
<body>
  <div class="auth-page">
    <div class="glass-card auth-card">
      <div class="auth-header">
        <h1>
          <span class="daftar">LOGIN</span>
        </h1>
      </div>
      
      <?php if ($error): ?>
        <div class="error-msg" style="margin-top: -20px"><?= $error ?></div>
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
          <button type="submit" class="btn-primary" style="width:100%">LOGIN</button>
        </div>
      </form>
      
      <p style="text-align: center; margin-top: 24px; color: var(--text-secondary);">
          Belum punya akun?
          <a href="register.php" style="color: var(--text-secondary); font-weight: 600; text-decoration: none;">
              Register dulu!
          </a>
      </p>

      <div style="text-align: center; margin-top: 24px;">
        <a href="index.php" style="color: var(--text-muted); font-size: 13px; text-decoration: none;">&larr; Kembali ke Beranda</a>
      </div>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.min.js" integrity="sha384-G/EV+4j2dNv+tEPo3++6LCgdCROaejBqfUeNjuKAiuXbjrxilcCdDz6ZAVfHWe1Y" crossorigin="anonymous"></script>  
</body>
</html>
