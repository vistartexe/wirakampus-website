<?php
session_start();
require_once '../helper/connection.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: ../login.php");
    exit;
}

$user_id = $_SESSION['user_id'];
$id = (int) $_GET['id'];

/* Get user role */
$user_query = mysqli_query($conn, "SELECT role FROM users WHERE id='$user_id'");
$user_data = mysqli_fetch_assoc($user_query);
$role = $user_data['role'];

/* Build query based on role */
if ($role === 'ADMIN') {

    // Admin can delete ANY product
    $query = "DELETE FROM products WHERE id = '$id'";

} else {

    // Seller can only delete their own product
    $query = "DELETE FROM products 
              WHERE id = '$id' 
              AND seller_id = '$user_id'";
}

/* Execute */
mysqli_query($conn, $query);

/* Redirect based on role */
if ($role === 'ADMIN') {
    header("Location: dashboard.php");
} else {
    header("Location: ../seller-dashboard/index.php");
}

exit;