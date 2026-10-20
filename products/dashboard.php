<?php
session_start();
require_once '../helper/connection.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: ../login.php");
    exit;
}

/* All Products */

$product_query = mysqli_query(
    $conn,
    "SELECT
        p.*,
        u.name AS seller_name,
        u.store_name
     FROM products p
     JOIN users u ON p.seller_id = u.id
     ORDER BY p.created_at DESC"
);
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
<div class="admin-layout">

    <?php include '../components/sidebar-admin.php'; ?>

    <div class="admin-content">

        <div class="admin-header">
            <h1>Products</h1>
            <p>Kelola produk yang seller telah unggah disini.</p>

            <!-- CREATE BUTTON -->
            <div class="mt-3">
                <a href="create.php" class="btn btn-primary">
                    + Tambah Produk
                </a>
            </div>
        </div>

        <div class="table-container">

            <table>

                <thead>
                    <tr>
                        <th>Produk</th>
                        <th>Penjual</th>
                        <th>Kategori</th>
                        <th>Harga</th>
                        <th>Stok</th>
                        <th>Aksi</th>
                    </tr>
                </thead>

                <tbody>

                <?php if (mysqli_num_rows($product_query) > 0): ?>

                    <?php while ($product = mysqli_fetch_assoc($product_query)): ?>

                        <tr>

                            <!-- PRODUCT -->
                            <td>
                                <div class="product-cell">
                                    <img
                                        src="<?= htmlspecialchars($product['image_url']) ?>"
                                        alt="<?= htmlspecialchars($product['name']) ?>"
                                    >
                                    <?= htmlspecialchars($product['name']) ?>
                                </div>
                            </td>

                            <!-- SELLER -->
                            <td>
                                <?= htmlspecialchars(
                                    $product['store_name']
                                    ? $product['store_name']
                                    : $product['seller_name']
                                ) ?>
                            </td>

                            <!-- CATEGORY -->
                            <td>
                                <?= htmlspecialchars($product['category']) ?>
                            </td>

                            <!-- PRICE -->
                            <td class="price">
                                Rp <?= number_format($product['price'], 0, ',', '.') ?>
                            </td>

                            <!-- STOCK -->
                            <td>
                                <?php if ($product['stok'] > 0): ?>
                                    <span class="status in-stock">
                                        Sisa <?= $product['stok'] ?>
                                    </span>
                                <?php else: ?>
                                    <span class="status out-of-stock">
                                        Stok Habis
                                    </span>
                                <?php endif; ?>
                            </td>

                            <!-- ACTIONS -->
                            <td>
                                <div class="d-flex gap-2">

                                    <!-- EDIT -->
                                    <a
                                        href="edit.php?id=<?= $product['id'] ?>"
                                        class="action-btn"
                                    >
                                        <i class="bi bi-pencil"></i>
                                    </a>

                                    <!-- DELETE -->
                                    <a
                                        href="delete.php?id=<?= $product['id'] ?>"
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
                        <td colspan="6" class="text-center">
                            Belum ada produk.
                        </td>
                    </tr>

                <?php endif; ?>

                </tbody>

            </table>

        </div>

    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>