<?php
session_start();
require_once '../helper/connection.php';

/* GET FILTERS */
$category = isset($_GET['category']) ? $_GET['category'] : 'All';
$search   = isset($_GET['q']) ? mysqli_real_escape_string($conn, $_GET['q']) : '';

/* BASE QUERY */
$sql = "
SELECT 
    p.*,
    u.name AS seller_name,
    u.profile_pic AS seller_pic
FROM products p
JOIN users u ON p.seller_id = u.id
WHERE 1=1
";

/* CATEGORY FILTER */
if (!empty($category) && $category != 'All') {
    $category_safe = mysqli_real_escape_string($conn, $category);
    $sql .= " AND p.category = '$category_safe'";
}

/* SEARCH FILTER */
if (!empty($search)) {
    $sql .= " AND p.name LIKE '%$search%'";
}

/* ORDER */
$sql .= " ORDER BY p.created_at DESC";

$product_query = mysqli_query($conn, $sql);
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Catalog | WiraKampus</title>
  
  <!-- Bootstrap -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">

  <!-- Icons -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">

  <!-- Favicon -->
  <link rel="icon" type="image/png" sizes="70x45" href="/wirakampus/img/logo_WK.png">

  <!-- CSS -->
  <link rel="stylesheet" href="../css/globals.css">
  <link rel="stylesheet" href="../css/style_index.css">
  <link rel="stylesheet" href="../css/style_catalog.css">
</head>

<body>

<?php include '../components/navbar.php'; ?>

<main class="catalog-container">

  <h2>Catalog Produk</h2>
  <p class="text-muted">Temukan kebutuhanmu di sini</p>

  <div class="catalog-layout">

    <!-- FILTER -->
    <aside class="filter-sidebar">
      <h5>Kategori</h5>
      <div class="filter-list">

        <a href="?category=All"
           class="<?= ($category=='All' && empty($search))?'active-category':'' ?>">
          Semua
        </a>

        <a href="?category=Styling"
           class="<?= ($category=='Styling')?'active-category':'' ?>">
          Styling
        </a>

        <a href="?category=Food"
           class="<?= ($category=='Food')?'active-category':'' ?>">
          Food
        </a>

        <a href="?category=Preloved"
           class="<?= ($category=='Preloved')?'active-category':'' ?>">
          Preloved
        </a>

        <a href="?category=Jasa"
           class="<?= ($category=='Jasa')?'active-category':'' ?>">
          Jasa
        </a>

      </div>
    </aside>

    <!-- PRODUCTS -->
    <div class="product-grid">

      <?php if (mysqli_num_rows($product_query) > 0): ?>
        <?php while ($p = mysqli_fetch_assoc($product_query)): ?>

          <?php
            $sellerPic = !empty($p['seller_pic'])
              ? "/wirakampus/uploads/profiles/" . $p['seller_pic']
              : "/wirakampus/img/bg.png";

            $productImage = !empty($p['image_url'])
              ? $p['image_url']
              : "/wirakampus/img/bg.png";
          ?>

          <a href="detail.php?id=<?= $p['id'] ?>" class="product-card">

            <div class="product-image-container">
              <img src="<?= htmlspecialchars($productImage) ?>" alt="product">
            </div>

            <div class="product-title">
              <?= htmlspecialchars($p['name']) ?>
            </div>

            <div class="product-price">
              Rp <?= number_format($p['price'], 0, ',', '.') ?>
            </div>

            <div class="seller">
              <img src="<?= $sellerPic ?>" alt="seller">
              <span><?= htmlspecialchars($p['seller_name']) ?></span>
            </div>

          </a>

        <?php endwhile; ?>
      <?php else: ?>
        <p class="text-muted">Produk tidak ditemukan.</p>
      <?php endif; ?>

    </div>

  </div>

</main>

</body>
</html>