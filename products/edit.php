<?php
session_start();
require_once '../helper/connection.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: ../login.php");
    exit;
}

$user_id = $_SESSION['user_id'];

/* Get user role */
$user_query = mysqli_query($conn, "SELECT role FROM users WHERE id='$user_id'");
$user_data = mysqli_fetch_assoc($user_query);
$role = $user_data['role'];

/* Check product ID */
if (!isset($_GET['id'])) {
    if ($role === 'ADMIN') {
        header("Location: dashboard.php");
    } else {
        header("Location: ../seller-dashboard/index.php");
    }
    exit;
}

$id = (int) $_GET['id'];

/* ROLE-BASED PRODUCT ACCESS */
if ($role === 'ADMIN') {

    // Admin can access any product
    $query = "SELECT * FROM products WHERE id = '$id' LIMIT 1";

} else {

    // Seller can only access their own product
    $query = "SELECT * FROM products 
              WHERE id = '$id' 
              AND seller_id = '$user_id'
              LIMIT 1";
}

$result = mysqli_query($conn, $query);
$product = mysqli_fetch_assoc($result);

/* If not found or unauthorized */
if (!$product) {
    if ($role === 'ADMIN') {
        header("Location: dashboard.php");
    } else {
        header("Location: ../seller-dashboard/index.php");
    }
    exit;
}
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
    <link rel="stylesheet" href="../css/style_dashboard-admin.css">
</head>

<body>

<?php include '../components/navbar.php'; ?>

<div class="dashboard-layout">

    <!-- ROLE-BASED SIDEBAR -->
    <?php
    if ($role === 'ADMIN') {
        include '../components/sidebar-admin.php';
    } else {
        include '../components/sidebar.php';
    }
    ?>

    <div class="dashboard-content">

        <div class="table-container" style="margin-left: 50px;">

            <h2 class="mb-4">Edit Produk</h2>

            <form action="update.php" method="POST" enctype="multipart/form-data">

                <!-- Product ID -->
                <input type="hidden" name="id" value="<?= $product['id'] ?>">

                <!-- Nama Produk -->
                <div class="mb-3">
                    <label class="form-label fw-semibold">Nama Produk</label>
                    <input type="text" name="name" class="form-control"
                           value="<?= htmlspecialchars($product['name']) ?>" required>
                </div>

                <!-- Kategori -->
                <div class="mb-3">
                    <label class="form-label fw-semibold">Kategori</label>

                    <select name="category" class="form-select" required>
                        <option value="">-- Pilih Kategori --</option>

                        <option value="Styling" <?= $product['category'] == 'Styling' ? 'selected' : '' ?>>Styling</option>
                        <option value="Food" <?= $product['category'] == 'Food' ? 'selected' : '' ?>>Food</option>
                        <option value="Preloved" <?= $product['category'] == 'Preloved' ? 'selected' : '' ?>>Preloved</option>
                        <option value="Jasa" <?= $product['category'] == 'Jasa' ? 'selected' : '' ?>>Jasa</option>
                    </select>
                </div>

                <!-- Harga & Stok -->
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-semibold">Harga</label>
                        <input type="number" name="price" class="form-control"
                               value="<?= $product['price'] ?>" min="0" required>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-semibold">Stok</label>
                        <input type="number" name="stok" class="form-control"
                               value="<?= $product['stok'] ?>" min="0" required>
                    </div>
                </div>

                <!-- Current Image -->
                <?php if (!empty($product['image_url'])): ?>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Gambar Saat Ini</label>
                        <div>
                            <img src="<?= htmlspecialchars($product['image_url']) ?>"
                                 style="max-width:250px;border-radius:12px;border:1px solid #ddd;">
                        </div>
                    </div>
                <?php endif; ?>

                <!-- Upload new image -->
                <div class="mb-3">
                    <label class="form-label fw-semibold">Ganti Gambar</label>
                    <input type="file" name="image" class="form-control"
                           accept=".jpg,.jpeg,.png,.webp">

                    <small class="text-muted">
                        Kosongkan jika tidak ingin mengganti gambar
                    </small>
                </div>

                <!-- WhatsApp -->
                <div class="mb-4">
                    <label class="form-label fw-semibold">Nomor WhatsApp</label>
                    <input type="text" name="whatsapp" class="form-control"
                           value="<?= htmlspecialchars($product['whatsapp']) ?>" required>
                </div>

                <!-- Buttons -->
                <div class="d-flex gap-2">
                    <button type="submit" class="btn-primary">
                        Simpan Perubahan
                    </button>

                    <a href="<?= $role === 'ADMIN' ? 'dashboard.php' : '../seller-dashboard/index.php' ?>"
                       class="btn-outline">
                        Batal
                    </a>
                </div>

            </form>

        </div>

    </div>

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>