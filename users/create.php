<?php
session_start();
require_once '../helper/connection.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: ../login.php");
    exit;
}

$user_id = $_SESSION['user_id'];

$check = mysqli_query($conn, "SELECT role FROM users WHERE id='$user_id'");
$data = mysqli_fetch_assoc($check);

if ($data['role'] !== 'ADMIN') {
    header("Location: ../index.php");
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

    <?php include '../components/sidebar-admin.php'; ?>

    <div class="dashboard-content">

        <div class="table-container" style="margin-left: 50px; max-width: 700px;">

            <h2 class="mb-4">Tambah User</h2>

            <form action="store.php" method="POST">

                <!-- NAME -->
                <div class="mb-3">
                    <label class="form-label fw-semibold">Nama</label>
                    <input type="text" name="name" class="form-control"
                           placeholder="Masukkan nama user" required>
                </div>

                <!-- EMAIL -->
                <div class="mb-3">
                    <label class="form-label fw-semibold">Email</label>
                    <input type="email" name="email" class="form-control"
                           placeholder="Masukkan email" required>
                </div>

                <!-- PASSWORD -->
                <div class="mb-3">
                    <label class="form-label fw-semibold">Password</label>
                    <input type="password" name="password" class="form-control"
                           placeholder="Masukkan password" required>
                </div>

                <!-- STORE NAME (optional) -->
                <div class="mb-3">
                    <label class="form-label fw-semibold">Nama Toko (Opsional)</label>
                    <input type="text" name="store_name" class="form-control"
                           placeholder="Kosongkan jika tidak ada toko">
                </div>

                <!-- BUTTONS -->
                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-primary">
                        Simpan User
                    </button>

                    <a href="dashboard.php" class="btn-outline">
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