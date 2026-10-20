<?php
session_start();
require_once '../helper/connection.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: ../login.php");
    exit;
}

$user_id = $_SESSION['user_id'];

/* Check admin role */
$check = mysqli_query($conn, "SELECT role FROM users WHERE id='$user_id'");
$data = mysqli_fetch_assoc($check);

if ($data['role'] !== 'ADMIN') {
    header("Location: ../index.php");
    exit;
}

/* Check user ID */
if (!isset($_GET['id'])) {
    header("Location: dashboard.php");
    exit;
}

$id = (int) $_GET['id'];

/* Load user */
$result = mysqli_query(
    $conn,
    "SELECT id, name, email, store_name, password FROM users WHERE id='$id' LIMIT 1"
);

$user = mysqli_fetch_assoc($result);

/* If not found */
if (!$user) {
    header("Location: dashboard.php");
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

            <h2 class="mb-4">Edit User</h2>

            <form action="update.php" method="POST">

                <!-- USER ID -->
                <input type="hidden" name="id" value="<?= $user['id'] ?>">

                <!-- NAME -->
                <div class="mb-3">
                    <label class="form-label fw-semibold">Nama</label>
                    <input type="text" name="name" class="form-control"
                           value="<?= htmlspecialchars($user['name']) ?>" required>
                </div>

                <!-- EMAIL -->
                <div class="mb-3">
                    <label class="form-label fw-semibold">Email</label>
                    <input type="email" name="email" class="form-control"
                           value="<?= htmlspecialchars($user['email']) ?>" required>
                </div>

                <!-- STORE NAME -->
                <div class="mb-3">
                    <label class="form-label fw-semibold">Nama Toko</label>
                    <input type="text" name="store_name" class="form-control"
                           value="<?= htmlspecialchars($user['store_name']) ?>">
                </div>

                <!-- PASSWORD (OPTIONAL UPDATE) -->
                <div class="mb-4">
                    <label class="form-label fw-semibold">Password (Opsional)</label>
                    <input type="text" name="password" class="form-control"
                           placeholder="Kosongkan jika tidak ingin mengganti password">

                    <small class="text-muted">
                        Biarkan kosong jika password tidak ingin diubah
                    </small>
                </div>

                <!-- BUTTONS -->
                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-primary">
                        Simpan Perubahan
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