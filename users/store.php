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

/* Get POST data */
$name = mysqli_real_escape_string($conn, $_POST['name']);
$email = mysqli_real_escape_string($conn, $_POST['email']);
$password = mysqli_real_escape_string($conn, $_POST['password']);
$store_name = mysqli_real_escape_string($conn, $_POST['store_name']);

/* Default role (since admin-only creation flow) */
$role = "SELLER";

/* Check duplicate email */
$check_email = mysqli_query($conn, "SELECT id FROM users WHERE email='$email'");

if (mysqli_num_rows($check_email) > 0) {
    echo "<script>
        alert('Email sudah digunakan!');
        window.location.href = 'create.php';
    </script>";
    exit;
}

/* Insert user */
$query = mysqli_query(
    $conn,
    "INSERT INTO users (name, email, password, store_name, role)
     VALUES ('$name', '$email', '$password', '$store_name', '$role')"
);

if ($query) {
    echo "<script>
        alert('User berhasil ditambahkan!');
        window.location.href = 'dashboard.php';
    </script>";
} else {
    echo "<script>
        alert('Gagal menambahkan user!');
        window.location.href = 'create.php';
    </script>";
}
?>