<?php
session_start();
require_once '../helper/connection.php';

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

/* HANDLE BOOKMARK AJAX */
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'bookmark') {

    if (!isset($_SESSION['user_id'])) {
        echo "login";
        exit;
    }

    $user_id = $_SESSION['user_id'];
    $product_id = (int)($_POST['product_id'] ?? 0);

    if ($product_id > 0) {

        // check existing bookmark
        $check = mysqli_query(
            $conn,
            "SELECT id FROM bookmarks 
             WHERE user_id = $user_id AND product_id = $product_id"
        );

        if (mysqli_num_rows($check) > 0) {

            // REMOVE
            mysqli_query(
                $conn,
                "DELETE FROM bookmarks 
                 WHERE user_id = $user_id AND product_id = $product_id"
            );

            echo "removed";
        } else {

            // ADD
            mysqli_query(
                $conn,
                "INSERT INTO bookmarks (user_id, product_id) 
                 VALUES ($user_id, $product_id)"
            );

            echo "added";
        }
    }

    exit;
}

/* GET product + seller */
$query = mysqli_query(
    $conn,
    "SELECT 
        p.*,
        u.id AS seller_id,
        u.name AS seller_name,
        u.profile_pic AS seller_pic
     FROM products p
     JOIN users u ON p.seller_id = u.id
     WHERE p.id = $id"
);

$product = mysqli_fetch_assoc($query);

if (!$product) {
    echo "Product not found";
    exit;
}

/* CHECK BOOKMARK STATUS */
$isBookmarked = false;

if (isset($_SESSION['user_id'])) {
    $uid = $_SESSION['user_id'];

    $bm = mysqli_query(
        $conn,
        "SELECT id FROM bookmarks 
         WHERE user_id = $uid AND product_id = $id"
    );

    $isBookmarked = mysqli_num_rows($bm) > 0;
}

/* PRODUCT IMAGE */
$productImage = !empty($product['image_url'])
    ? $product['image_url']
    : "/wirakampus/img/bg.png";

/* SELLER IMAGE */
$sellerPic = !empty($product['seller_pic'])
    ? "/wirakampus/uploads/profiles/" . $product['seller_pic']
    : "/wirakampus/img/bg.png";

/* WHATSAPP NUMBER */
$waNumber = preg_replace('/[^0-9]/', '', $product['whatsapp']);
if (substr($waNumber, 0, 1) == "0") {
    $waNumber = "62" . substr($waNumber, 1);
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title><?= htmlspecialchars($product['name']) ?> | WiraKampus</title>
  
  <!-- Bootstrap -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">

  <!-- Icons -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">

  <!-- Favicon -->
  <link rel="icon" type="image/png" sizes="70x45" href="/wirakampus/img/logo_WK.png">

  <!-- CSS -->
  <link rel="stylesheet" href="../css/globals.css">
  <link rel="stylesheet" href="../css/style_index.css">
  <link rel="stylesheet" href="../css/style_detail.css">

</head>

<body>

<?php include '../components/navbar.php'; ?>

<main class="product-page">

  <div class="product-layout">

    <!-- IMAGE -->
    <div class="product-gallery">
      <img src="<?= htmlspecialchars($productImage) ?>" class="main-image">
    </div>

    <!-- INFO -->
    <div class="product-info-card">

      <span class="badge"><?= htmlspecialchars($product['category']) ?></span>

      <div class="product-title">
        <?= htmlspecialchars($product['name']) ?>
      </div>

      <div class="product-price">
        Rp <?= number_format($product['price'], 0, ',', '.') ?>
      </div>

      <!-- SELLER -->
      <a href="../profile/public.php?id=<?= $product['seller_id'] ?>" class="seller-info">
        <img src="<?= $sellerPic ?>" class="seller-avatar">
        <div>
          <div><b><?= htmlspecialchars($product['seller_name']) ?></b></div>
          <div style="font-size:12px;color:#666;">Lihat profil seller</div>
        </div>
      </a>

      <!-- ACTION -->
      <div class="action-buttons">

        <a class="btn-primary"
           href="https://wa.me/<?= $waNumber ?>"
           target="_blank">
          Chat Penjual
        </a>

        <!-- BOOKMARK BUTTON -->
        <button id="bookmarkBtn"
                class="<?= $isBookmarked ? 'btn-primary' : 'btn-outline' ?>"
                onclick="toggleBookmark(<?= $product['id'] ?>)">
          <span id="bookmarkText">
            <?= $isBookmarked ? 'Saved' : 'Bookmark' ?>
          </span>
        </button>

      </div>

    </div>
  </div>

</main>

<script>
function toggleBookmark(productId) {

    let formData = new FormData();
    formData.append('action', 'bookmark');
    formData.append('product_id', productId);

    fetch(window.location.href, {
        method: 'POST',
        body: formData
    })
    .then(res => res.text())
    .then(res => {

        let btn = document.getElementById('bookmarkBtn');
        let text = document.getElementById('bookmarkText');

        res = res.trim();

        if (res === "added") {
            btn.classList.remove('btn-outline');
            btn.classList.add('btn-primary');
            text.innerText = "Saved";
        }

        else if (res === "removed") {
            btn.classList.remove('btn-primary');
            btn.classList.add('btn-outline');
            text.innerText = "Bookmark";
        }

        else if (res === "login") {
            alert("Silakan login terlebih dahulu");
            window.location.href = "../login.php";
        }
    });
}
</script>

</body>
</html>