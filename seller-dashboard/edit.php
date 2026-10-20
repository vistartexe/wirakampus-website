<?php
session_start();
require_once '../helper/connection.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: ../login.php");
    exit;
}

$user_id = $_SESSION['user_id'];

$result = mysqli_query(
    $conn,
    "SELECT *
     FROM users
     WHERE id = '$user_id'
     LIMIT 1"
);

$user = mysqli_fetch_assoc($result);

if (!$user) {
    header("Location: ../login.php");
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
</head>

<body>

<?php include '../components/navbar.php'; ?>

<div class="dashboard-layout">

    <?php include '../components/sidebar.php'; ?>

    <!-- Content -->
    <div class="dashboard-content">

        <div class="table-container">

            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2>Edit Toko</h2>
            </div>

            <form action="update-store.php" method="POST">

                <div class="mb-4">

                    <label class="form-label fw-semibold">
                        Nama Toko
                    </label>

                    <input
                        type="text"
                        name="store_name"
                        class="form-control"
                        value="<?= htmlspecialchars($user['store_name'] ?? '') ?>"
                        placeholder="Masukkan nama toko"
                        required>

                </div>

                <div class="mb-4">

                    <label class="form-label fw-semibold">
                        Deskripsi Toko
                    </label>

                    <textarea
                        name="store_description"
                        class="form-control"
                        rows="4"
                        placeholder="Deskripsi singkat toko Anda"><?= htmlspecialchars($user['store_description'] ?? '') ?></textarea>

                </div>

                <div class="d-flex gap-2">

                    <button
                        type="submit"
                        class="btn-primary">
                        Simpan Perubahan
                    </button>

                    <a
                        href="../seller-dashboard/index.php"
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