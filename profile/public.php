<?php
session_start();
require_once '../helper/connection.php';

$id = isset($_GET['id']) ? intval($_GET['id']) : 0;
if ($id <= 0) {
    die("ID pengguna tidak valid.");
}

$query = "SELECT * FROM users WHERE id = $id";
$result = mysqli_query($conn, $query);
$user = mysqli_fetch_assoc($result);

if (!$user || $user['is_public'] == 0) {
    // Jika tidak ditemukan atau is_public = 0 (false)
    $error_msg = "Profil ini bersifat privat atau tidak ditemukan.";
} else {
    $profile_pic_url = !empty($user['profile_pic']) ? "../uploads/profiles/" . $user['profile_pic'] : "../img/bg.png";
    
    // Ambil produk jika dia seller
    $products = [];
    if ($user['role'] === 'SELLER') {
        $prod_q = "SELECT * FROM products WHERE seller_id = $id";
        $res_p = mysqli_query($conn, $prod_q);
        while ($row = mysqli_fetch_assoc($res_p)) {
            $products[] = $row;
        }
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title><?= htmlspecialchars($user['name']) ?> | WiraKampus</title>
  
  <!-- Bootstrap -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">

  <!-- Icons -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">

  <!-- Favicon -->
  <link rel="icon" type="image/png" sizes="70x45" href="/wirakampus/img/logo_WK.png">

  <!-- CSS -->
  <link rel="stylesheet" href="../css/globals.css">
  <link rel="stylesheet" href="../css/style_index.css">
  <link rel="stylesheet" href="../css/style_public.css">

</head>
<body>
  <?php include '../components/navbar.php'; ?>

  <main class="public-profile">
    <?php if (isset($error_msg)): ?>
      <div class="glass-card" style="padding: 40px; text-align: center;">
        <h2 style="color: var(--text-muted);"><?= $error_msg ?></h2>
      </div>
    <?php else: ?>
      <div class="profile-header">
        <img src="<?= htmlspecialchars($profile_pic_url) ?>" alt="Profile" class="profile-pic">
        <div class="profile-info">
          <h1><?= htmlspecialchars($user['name']) ?></h1>
          <div class="badge-role"><?= htmlspecialchars($user['role']) ?></div>
          <?php if (!empty($user['store_name'])): ?>
            <p style="color: var(--color-blue-dark); margin-top: 4px;"><strong>Toko: </strong><?= htmlspecialchars($user['store_name']) ?></p>
            <p style="color: var(--color-blue-dark); margin-top: 4px;"><strong>Deskripsi: </strong><br><?= htmlspecialchars($user['store_description']) ?></p>
          <?php endif; ?>
        </div>
      </div>

      <?php if ($user['role'] === 'SELLER'): ?>
        <h3 style="margin-bottom: 24px; color: var(--color-blue-dark);">Etalase Toko</h3>
        <?php if (count($products) > 0): ?>
          <div class="products-grid">
            <?php foreach($products as $prod): ?>
              <a href="../catalog/detail.php?id=<?= $prod['id'] ?>" class="product-card" style="text-decoration:none; display:block;">

                <img src="<?= htmlspecialchars($prod['image_url']) ?>" alt="Product" class="product-img">

                <div class="product-details">
                  <div class="product-name"><?= htmlspecialchars($prod['name']) ?></div>
                  <div class="product-price">Rp <?= number_format($prod['price'], 0, ',', '.') ?></div>
                </div>

              </a>
            <?php endforeach; ?>
          </div>
        <?php else: ?>
          <p style="color: var(--text-muted);">Belum ada produk yang dijual.</p>
        <?php endif; ?>
      <?php endif; ?>

    <?php endif; ?>
  </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.min.js" integrity="sha384-G/EV+4j2dNv+tEPo3++6LCgdCROaejBqfUeNjuKAiuXbjrxilcCdDz6ZAVfHWe1Y" crossorigin="anonymous"></script>  

</body>
</html>
