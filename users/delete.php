<?php
session_start();
require_once '../helper/connection.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: ../login.php");
    exit;
}

/* Ensure only admin */
$user_id = $_SESSION['user_id'];

$check = mysqli_query($conn, "SELECT role FROM users WHERE id='$user_id'");
$data = mysqli_fetch_assoc($check);

if ($data['role'] !== 'ADMIN') {
    header("Location: ../index.php");
    exit;
}

/* Get target user ID */
if (!isset($_GET['id']) || empty($_GET['id'])) {
    header("Location: dashboard.php");
    exit;
}

$target_id = (int) $_GET['id'];

/* Optional safety: prevent admin deleting themselves */
if ($target_id == $user_id) {
    echo "<script>
        alert('Kamu tidak bisa menghapus akun sendiri!');
        window.location.href = 'dashboard.php';
    </script>";
    exit;
}

/* Check if user exists */
$check_user = mysqli_query($conn, "SELECT id FROM users WHERE id='$target_id'");

if (mysqli_num_rows($check_user) == 0) {
    echo "<script>
        alert('User tidak ditemukan!');
        window.location.href = 'dashboard.php';
    </script>";
    exit;
}

/* Delete user */
$delete = mysqli_query($conn, "DELETE FROM users WHERE id='$target_id'");

if ($delete) {
    echo "<script>
        alert('User berhasil dihapus!');
        window.location.href = 'dashboard.php';
    </script>";
} else {
    echo "<script>
        alert('Gagal menghapus user!');
        window.location.href = 'dashboard.php';
    </script>";
}
?>