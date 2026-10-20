<?php
// Mulai sesi hanya jika belum dimulai
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Fungsi isLogin untuk mengecek login dan level akses pengguna
function isLogin($requiredRole = null) {
    // Cek apakah pengguna sudah login
    if (!isset($_SESSION['user_id'])) {
        header('Location: ../login.php');
        exit;
    }

    // Melakukan pengecekan level akses
    if ($requiredRole !== null && $_SESSION['user_id']['level'] !== $requiredRole) {
        exit;
    }
}
?>