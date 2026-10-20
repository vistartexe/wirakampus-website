<?php
session_start();
require_once '../helper/connection.php';

// Cek login
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$user_id = $_SESSION['user_id'];
$success_msg = "";
$error_msg = "";

// Ambil data user terbaru
function getUser($conn, $user_id) {
    $q = mysqli_query($conn, "SELECT * FROM users WHERE id = $user_id");
    return mysqli_fetch_assoc($q);
}

$user = getUser($conn, $user_id);

// PROSES UPDATE
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $nama = mysqli_real_escape_string($conn, $_POST['nama']);
    $nim = mysqli_real_escape_string($conn, $_POST['nim']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $is_public = isset($_POST['is_public']) ? 1 : 0;

    $update_query = "
        UPDATE users 
        SET name='$nama', nim='$nim', email='$email', is_public=$is_public
    ";

    $new_profile_pic = null;

    // UPLOAD FOTO
    if (isset($_FILES['profile_pic']) && $_FILES['profile_pic']['error'] == 0) {

        $allowed = ['jpg', 'jpeg', 'png', 'gif'];
        $filename = $_FILES['profile_pic']['name'];
        $ext = strtolower(pathinfo($filename, PATHINFO_EXTENSION));

        if (in_array($ext, $allowed)) {

            $new_filename = "profile_" . $user_id . "_" . time() . "." . $ext;
            $upload_path = "../uploads/profiles/" . $new_filename;

            if (move_uploaded_file($_FILES['profile_pic']['tmp_name'], $upload_path)) {
                $update_query .= ", profile_pic='$new_filename'";
                $new_profile_pic = $new_filename;
            } else {
                $error_msg = "Gagal mengunggah foto profil.";
            }

        } else {
            $error_msg = "Format foto tidak didukung (JPG, PNG, GIF).";
        }
    }

    $update_query .= " WHERE id=$user_id";

    if (empty($error_msg)) {
        if (mysqli_query($conn, $update_query)) {

            $success_msg = "Profil berhasil diperbarui!";

            // REFRESH SESSION (INI PENTING UNTUK NAVBAR)
            $_SESSION['user_name'] = $nama;
            $_SESSION['email'] = $email;

            if ($new_profile_pic) {
                $_SESSION['profile_pic'] = $new_profile_pic;
            }

            // REFRESH DATA USER
            $user = getUser($conn, $user_id);

        } else {
            $error_msg = "Gagal memperbarui profil: " . mysqli_error($conn);
        }
    }
}

// PROFILE IMAGE
$profile_pic_url = !empty($user['profile_pic'])
    ? "../uploads/profiles/" . $user['profile_pic']
    : "../img/bg.png";
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Profile | WiraKampus</title>
  
  <!-- Bootstrap -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">

  <!-- Icons -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">

  <!-- Favicon -->
  <link rel="icon" type="image/png" sizes="70x45" href="/wirakampus/img/logo_WK.png">

  <!-- CSS -->
  <link rel="stylesheet" href="../css/globals.css">
  <link rel="stylesheet" href="../css/style_index.css">
  <link rel="stylesheet" href="../css/style_profile.css">

</head>
<body>

<?php include '../components/navbar.php'; ?>

<main class="profile-page">
  <div class="glass-card profile-card">

    <!-- LEFT SIDE -->
    <div class="profile-left">

      <div class="avatar-container"
           onclick="document.getElementById('profile_pic_input').click()">

        <img id="avatar-preview"
             src="<?= htmlspecialchars($profile_pic_url) ?>"
             class="profile-avatar">

        <div class="avatar-overlay">
          <i class="bi bi-upload"></i>
        </div>
      </div>

      <div class="profile-name"><?= htmlspecialchars($user['name']) ?></div>
      <div class="profile-email"><?= htmlspecialchars($user['email']) ?></div>

      <div class="profile-menu">

        <a href="public.php?id=<?= $user['id'] ?>">
          <i class="bi bi-person"></i> Profil Publik
        </a>

        <?php if (($user['role'] ?? '') === 'ADMIN'): ?>
          <a href="../admin-dashboard/index.php">
            <i class="bi bi-grid"></i> Admin Dashboard
          </a>
        <?php else: ?>
          <a href="../seller-dashboard/index.php">
            <i class="bi bi-grid"></i> Seller Dashboard
          </a>
        <?php endif; ?>

        <a href="../logout.php" class="logout">
          <i class="bi bi-box-arrow-right"></i> Keluar
        </a>

      </div>
    </div>

    <!-- RIGHT SIDE -->
    <div class="profile-right">

      <?php if (!empty($success_msg)): ?>
        <div class="alert alert-success"><?= $success_msg ?></div>
      <?php endif; ?>

      <?php if (!empty($error_msg)): ?>
        <div class="alert alert-danger"><?= $error_msg ?></div>
      <?php endif; ?>

      <form method="POST" enctype="multipart/form-data">

        <input type="file"
               id="profile_pic_input"
               name="profile_pic"
               hidden
               accept="image/*"
               onchange="previewImage(this)">

        <div class="section-title">Informasi Pribadi</div>

        <div class="form-grid">

          <div class="form-group">
            <label>Nama Lengkap</label>
            <input type="text" name="nama"
                   value="<?= htmlspecialchars($user['name']) ?>"
                   class="global-input" required>
          </div>

          <div class="form-group">
            <label>NIM</label>
            <input type="text" name="nim"
                   value="<?= htmlspecialchars($user['nim'] ?? '') ?>"
                   class="global-input">
          </div>

          <div class="form-group full">
            <label>Email</label>
            <input type="email" name="email"
                   value="<?= htmlspecialchars($user['email']) ?>"
                   class="global-input" required>
          </div>

        </div>

        <div class="section-title">Preferensi</div>

        <div class="preference-item">
          <div class="preference-info">
            <h4>Profil Publik</h4>
            <p>Izinkan pengguna lain melihat informasi profil dan toko Anda (jika ada).</p>
          </div>
          <div>
            <input type="checkbox" id="toggle_public" name="is_public" class="toggle-checkbox" <?= $user['is_public'] ? 'checked' : '' ?>>
            <label for="toggle_public" class="toggle-label">
              <div class="toggle-knob"></div>
            </label>
          </div>
        </div>

        <div class="form-actions">
          <button type="submit" class="btn-primary">
            Simpan Perubahan
          </button>
        </div>

      </form>
    </div>
  </div>
</main>

<script>
function previewImage(input) {
  if (input.files && input.files[0]) {
    const reader = new FileReader();
    reader.onload = function(e) {
      document.getElementById('avatar-preview').src = e.target.result;
    }
    reader.readAsDataURL(input.files[0]);
  }
}
</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>