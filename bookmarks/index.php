<?php
session_start();
require_once '../helper/connection.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: ../login.php");
    exit;
}

$user_id = (int) $_SESSION['user_id'];

/* GET BOOKMARK DATA */
$query = "
SELECT 
    p.id AS product_id,
    p.name,
    p.price,
    p.image_url,
    p.category
FROM bookmarks b
JOIN products p ON b.product_id = p.id
WHERE b.user_id = $user_id
ORDER BY b.created_at DESC
";

$result = mysqli_query($conn, $query);

$bookmarks = [];
while ($row = mysqli_fetch_assoc($result)) {
    $bookmarks[] = $row;
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Bookmark | WiraKampus</title>
  
  <!-- Bootstrap -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">

  <!-- Icons -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">

  <!-- Favicon -->
  <link rel="icon" type="image/png" sizes="70x45" href="/wirakampus/img/logo_WK.png">

  <!-- CSS -->
  <link rel="stylesheet" href="../css/globals.css">
  <link rel="stylesheet" href="../css/style_index.css">
  <link rel="stylesheet" href="../css/style_bookmark.css">

</head>

<body>

<?php include '../components/navbar.php'; ?>

<main class="page">

  <h1 class="header">Bookmark Anda</h1>

  <div class="bookmark-list">

    <?php if (empty($bookmarks)): ?>

      <div class="empty">
        <h3>Belum ada bookmark</h3>
        <a href="../catalog/index.php" class="btn btn-primary mt-3">
          Mulai Jelajahi
        </a>
      </div>

    <?php else: ?>

      <?php foreach ($bookmarks as $item): ?>

        <!-- CLICKABLE CARD -->
        <div class="glass-card item"
             onclick="goToProduct(<?= $item['product_id'] ?>)">

          <img src="<?= htmlspecialchars($item['image_url']) ?>" alt="product">

          <div class="info">
            <div class="badge"><?= htmlspecialchars($item['category']) ?></div>
            <div class="name"><?= htmlspecialchars($item['name']) ?></div>
            <div class="price">
              Rp <?= number_format($item['price'], 0, ',', '.') ?>
            </div>
          </div>

          <i class="bi bi-chevron-right"></i>

        </div>

      <?php endforeach; ?>

    <?php endif; ?>

  </div>
</main>

<script>
function goToProduct(productId) {
    window.location.href = "/wirakampus/catalog/detail.php?id=" + productId;
}
</script>

</body>
</html>