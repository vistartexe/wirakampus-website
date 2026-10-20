<?php
session_start();
require_once '../helper/connection.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: ../login.php");
    exit;
}

$user_id = $_SESSION['user_id'];

$product_query = mysqli_query(
    $conn,
    "SELECT * FROM products
     WHERE seller_id = '$user_id'
     ORDER BY created_at DESC"
);

$total_products = mysqli_num_rows($product_query);
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Dashboard | WiraKampus</title>

  <!-- Bootstrap -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">

  <!-- Icons -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">

  <!-- Favicon -->
  <link rel="icon" type="image/png" sizes="70x45" href="/wirakampus/img/logo_WK.png">

  <!-- CSS -->
  <link rel="stylesheet" href="../css/globals.css">
  <link rel="stylesheet" href="../css/style_index.css">
  <link rel="stylesheet" href="../css/style_dashboard.css">

</head>
<body>
  <?php include '../components/navbar.php'; ?>

  <div class="dashboard-layout">

    <?php include '../components/sidebar.php'; ?>
    
    <!-- Konten Kanan -->
    <div class="dashboard-content">
      
        <div class="glass-card stat-card" style="width:100%; margin-bottom: 20px">
          <div class="stat-icon">
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 19a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h5l2 3h9a2 2 0 0 1 2 2z"></path></svg>
          </div>
          <div class="stat-label">Total Produk</div>
          <div class="stat-value"><?= $total_products ?></div>
        </div>
      
      <div class="table-container">
        <table>
          <thead>
            <tr>
              <th>Produk</th>
              <th>Kategori</th>
              <th>Harga</th>
              <th>Stok</th>
              <th>Aksi</th>
            </tr>
          </thead>
          <tbody>

            <?php if(mysqli_num_rows($product_query) > 0): ?>

                <?php while($product = mysqli_fetch_assoc($product_query)): ?>

                <tr>
                    <td>
                        <div class="product-cell">
                            <img
                                src="<?= htmlspecialchars($product['image_url']) ?>"
                                alt="<?= htmlspecialchars($product['name']) ?>"
                            >

                            <?= htmlspecialchars($product['name']) ?>
                        </div>
                    </td>

                    <td>
                        <?= htmlspecialchars($product['category']) ?>
                    </td>

                    <td class="price">
                        Rp <?= number_format($product['price'],0,',','.') ?>
                    </td>

                    <td>
                        <?php if($product['stok'] > 0): ?>
                            <span class="status in-stock">
                                Sisa <?= $product['stok'] ?>
                            </span>
                        <?php else: ?>
                            <span class="status out-of-stock">
                                Stok Habis
                            </span>
                        <?php endif; ?>
                    </td>

                    <td>
                        <div class="actions">

                            <a
                                href="../products/edit.php?id=<?= $product['id'] ?>"
                                class="action-btn"
                            >
                                <i class="bi bi-pencil"></i>
                            </a>

                            <a
                                href="../products/delete.php?id=<?= $product['id'] ?>"
                                class="action-btn"
                                onclick="return confirm('Hapus produk ini?')"
                            >
                                <i class="bi bi-trash"></i>
                            </a>

                        </div>
                    </td>
                </tr>

                <?php endwhile; ?>

            <?php else: ?>

                <tr>
                    <td colspan="5" class="text-center">
                        Belum ada produk yang diunggah.
                    </td>
                </tr>

            <?php endif; ?>

            </tbody>
        </table>
      </div>
      
    </div>
  </div>
  
  <a href="../products/create.php" class="btn-primary fab-add">+ Unggah Produk</a>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.min.js" integrity="sha384-G/EV+4j2dNv+tEPo3++6LCgdCROaejBqfUeNjuKAiuXbjrxilcCdDz6ZAVfHWe1Y" crossorigin="anonymous"></script>  
</body>
</html>
