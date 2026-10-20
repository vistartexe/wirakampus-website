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

/* If admin → load all sellers */
$sellers = [];
if ($role === 'ADMIN') {
    $seller_result = mysqli_query(
        $conn,
        "SELECT id, name, store_name FROM users WHERE role='SELLER'"
    );

    while ($row = mysqli_fetch_assoc($seller_result)) {
        $sellers[] = $row;
    }
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

    <!-- ROLE BASED SIDEBAR -->
    <?php
    if ($role === 'ADMIN') {
        include '../components/sidebar-admin.php';
    } else {
        include '../components/sidebar.php';
    }
    ?>

    <div class="dashboard-content">

        <div class="table-container" style="margin-left: 50px;">

            <h2 class="mb-4">Unggah Produk</h2>

            <form action="store.php" method="POST" enctype="multipart/form-data">

                <!-- ADMIN ONLY: SELECT SELLER -->
                <?php if ($role === 'ADMIN'): ?>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Pilih Penjual</label>

                        <select name="seller_id" class="form-select" required>
                            <option value="">-- Pilih Seller --</option>

                            <?php foreach ($sellers as $s): ?>
                                <option value="<?= $s['id'] ?>">
                                    <?= htmlspecialchars($s['store_name'] ?? $s['name']) ?>
                                </option>
                            <?php endforeach; ?>

                        </select>
                    </div>
                <?php endif; ?>

                <!-- Nama Produk -->
                <div class="mb-3">
                    <label class="form-label fw-semibold">Nama Produk</label>
                    <input type="text" name="name" class="form-control"
                           placeholder="Masukkan nama produk" required>
                </div>

                <!-- Kategori -->
                <div class="mb-3">
                    <label class="form-label fw-semibold">Kategori</label>

                    <select name="category" class="form-select" required>
                        <option value="">-- Pilih Kategori --</option>
                        <option value="Styling">Styling</option>
                        <option value="Food">Food</option>
                        <option value="Preloved">Preloved</option>
                        <option value="Jasa">Jasa</option>
                    </select>
                </div>

                <!-- Harga & Stok -->
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-semibold">Harga</label>
                        <input type="number" name="price" class="form-control"
                               min="0" required>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-semibold">Stok</label>
                        <input type="number" name="stok" class="form-control"
                               min="0" required>
                    </div>
                </div>

                <!-- Image -->
                <div class="mb-3">
                    <label class="form-label fw-semibold">Gambar Produk</label>

                    <input type="file" name="image" class="form-control"
                           accept=".jpg,.jpeg,.png" required>

                    <small class="text-muted">
                        Format: JPG, JPEG, PNG
                    </small>
                </div>

                <!-- WhatsApp -->
                <div class="mb-4">
                    <label class="form-label fw-semibold">Nomor WhatsApp</label>

                    <input type="text" name="whatsapp" class="form-control"
                           placeholder="08xxxxxxxxxx" required>
                </div>

                <!-- Buttons -->
                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-primary">
                        Unggah Produk
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