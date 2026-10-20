<?php
session_start();
require_once '../helper/connection.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: ../login.php");
    exit;
}

/* Statistics */

$total_users = mysqli_fetch_assoc(
    mysqli_query($conn, "SELECT COUNT(*) AS total FROM users")
)['total'];

$total_sellers = mysqli_fetch_assoc(
    mysqli_query(
        $conn,
        "SELECT COUNT(*) AS total FROM users WHERE role='SELLER'"
    )
)['total'];

/* USERS QUERY */

$user_query = mysqli_query(
    $conn,
    "SELECT id, name, email, role, store_name, created_at
     FROM users
     ORDER BY created_at DESC"
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
            <h1>Users</h1>
            <p>Kelola data pengguna disini.</p>

            <!-- CREATE BUTTON -->
            <div class="mt-3">
                <a href="create.php" class="btn btn-primary">
                    + Tambah User
                </a>
            </div>
        </div>

        <div class="table-container">

            <table>

                <thead>
                    <tr>
                        <th>Nama</th>
                        <th>Email</th>
                        <th>Role</th>
                        <th>Store</th>
                        <th>Tanggal Daftar</th>
                        <th>Aksi</th>
                    </tr>
                </thead>

                <tbody>

                <?php if (mysqli_num_rows($user_query) > 0): ?>

                    <?php while ($user = mysqli_fetch_assoc($user_query)): ?>

                        <tr>

                            <!-- NAME -->
                            <td>
                                <?= htmlspecialchars($user['name']) ?>
                            </td>

                            <!-- EMAIL -->
                            <td>
                                <?= htmlspecialchars($user['email']) ?>
                            </td>

                            <!-- ROLE -->
                            <td>
                                <span class="badge bg-secondary">
                                    <?= htmlspecialchars($user['role']) ?>
                                </span>
                            </td>

                            <!-- STORE -->
                            <td>
                                <?= !empty($user['store_name'])
                                    ? htmlspecialchars($user['store_name'])
                                    : '-' ?>
                            </td>

                            <!-- CREATED AT -->
                            <td>
                                <?= date('d-m-Y', strtotime($user['created_at'])) ?>
                            </td>

                            <!-- ACTIONS -->
                            <td>
                                <div class="d-flex gap-2">

                                    <!-- EDIT -->
                                    <a
                                        href="edit.php?id=<?= $user['id'] ?>"
                                        class="action-btn"
                                    >
                                        <i class="bi bi-pencil"></i>
                                    </a>

                                    <!-- DELETE -->
                                    <a
                                        href="delete.php?id=<?= $user['id'] ?>"
                                        class="action-btn"
                                        onclick="return confirm('Hapus user ini?')"
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
                            Belum ada user.
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