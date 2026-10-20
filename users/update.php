<?php
session_start();
require_once '../helper/connection.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: ../login.php");
    exit;
}

/* Ensure admin only */
$session_id = $_SESSION['user_id'];

$check = mysqli_query($conn, "SELECT role FROM users WHERE id='$session_id'");
$data = mysqli_fetch_assoc($check);

if ($data['role'] !== 'ADMIN') {
    header("Location: ../index.php");
    exit;
}

/* Validate input */
if (!isset($_POST['id'])) {
    header("Location: dashboard.php");
    exit;
}

$id = (int) $_POST['id'];

$name = mysqli_real_escape_string($conn, $_POST['name']);
$email = mysqli_real_escape_string($conn, $_POST['email']);
$store_name = mysqli_real_escape_string($conn, $_POST['store_name']);

/* OPTIONAL PASSWORD */
$password_sql = "";

if (!empty($_POST['password'])) {
    $password = mysqli_real_escape_string($conn, $_POST['password']);
    $password_sql = ", password='$password'";
}

/* CHECK EMAIL DUPLICATE (exclude current user) */
$check_email = mysqli_query(
    $conn,
    "SELECT id FROM users 
     WHERE email='$email' AND id != '$id'"
);

if (mysqli_num_rows($check_email) > 0) {
    echo "<script>
        alert('Email sudah digunakan user lain!');
        window.location.href = 'edit.php?id=$id';
    </script>";
    exit;
}

/* UPDATE USER */
$query = mysqli_query(
    $conn,
    "UPDATE users SET
        name='$name',
        email='$email',
        store_name='$store_name'
        $password_sql
     WHERE id='$id'"
);

if ($query) {
    echo "<script>
        alert('User berhasil diperbarui!');
        window.location.href = 'dashboard.php';
    </script>";
} else {
    echo "<script>
        alert('Gagal memperbarui user!');
        window.location.href = 'edit.php?id=$id';
    </script>";
}
?>