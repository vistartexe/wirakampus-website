<?php
/**
 * File Koneksi Database
 * Digunakan untuk menghubungkan aplikasi dengan MySQL (XAMPP / phpMyAdmin)
 */

$host     = "localhost";      // Server database, default XAMPP adalah localhost
$username = "root";           // Username default XAMPP
$password = "";               // Password default XAMPP biasanya kosong
$database = "wirakampus";     // Ganti dengan nama database yang akan Anda buat di phpMyAdmin

// Membuat koneksi menggunakan ekstensi MySQLi
$conn = mysqli_connect($host, $username, $password, $database);

// Cek koneksi
if (!$conn) {
    die("Koneksi database gagal: " . mysqli_connect_error());
}
?>
