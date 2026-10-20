<?php
session_start();
require_once '../helper/connection.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: ../login.php");
    exit;
}

/* GET ALL BOOKMARKS (ADMIN) */
$bookmark_query = mysqli_query(
    $conn,
    "SELECT
        b.id AS bookmark_id,
        b.created_at,

        p.id AS product_id,
        p.name AS product_name,
        p.image_url,
        p.category,
        p.price,
        p.stok,

        u.name AS seller_name,
        u.store_name,

        bu.name AS user_name

     FROM bookmarks b

     JOIN products p ON b.product_id = p.id
     JOIN users u ON p.seller_id = u.id
     JOIN users bu ON b.user_id = bu.id

     ORDER BY b.created_at DESC"
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
    <link rel="stylesheet" href="../css/style_dashboard.css">
    <link rel="stylesheet" href="../css/style_dashboard-admin.css">
</head>

<body>

<?php include '../components/navbar.php'; ?>

<div class="admin-layout">

    <?php include '../components/sidebar-admin.php'; ?>

    <div class="admin-content">

        <div class="admin-header">
            <h1>Bookmark</h1>
            <p>Kelola semua produk yang di-bookmark oleh user.</p>
        </div>

        <div class="table-container">

            <table>

                <thead>
                    <tr>
                        <th>Produk</th>
                        <th>User</th>
                        <th>Penjual</th>
                        <th>Kategori</th>
                        <th>Harga</th>
                        <th>Tanggal</th>
                        <th>Aksi</th>
                    </tr>
                </thead>

                <tbody>

                <?php if (mysqli_num_rows($bookmark_query) > 0): ?>

                    <?php while ($b = mysqli_fetch_assoc($bookmark_query)): ?>

                        <tr>

                            <!-- PRODUCT -->
                            <td>
                                <div class="product-cell">
                                    <img
                                        src="<?= htmlspecialchars($b['image_url']) ?>"
                                        alt="<?= htmlspecialchars($b['product_name']) ?>"
                                    >
                                    <?= htmlspecialchars($b['product_name']) ?>
                                </div>
                            </td>

                            <!-- USER -->
                            <td>
                                <?= htmlspecialchars($b['user_name']) ?>
                            </td>

                            <!-- SELLER -->
                            <td>
                                <?= htmlspecialchars(
                                    $b['store_name'] ? $b['store_name'] : $b['seller_name']
                                ) ?>
                            </td>

                            <!-- CATEGORY -->
                            <td>
                                <?= htmlspecialchars($b['category']) ?>
                            </td>

                            <!-- PRICE -->
                            <td class="price">
                                Rp <?= number_format($b['price'], 0, ',', '.') ?>
                            </td>

                            <!-- DATE -->
                            <td>
                                <?= htmlspecialchars($b['created_at']) ?>
                            </td>

                            <!-- ACTION -->
                            <td>
                                <a
                                    href="delete.php?id=<?= $b['bookmark_id'] ?>"
                                    class="action-btn"
                                    onclick="return confirm('Hapus bookmark ini?')"
                                >
                                    <i class="bi bi-trash"></i>
                                </a>
                            </td>

                        </tr>

                    <?php endwhile; ?>

                <?php else: ?>

                    <tr>
                        <td colspan="7" class="text-center">
                            Belum ada bookmark.
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