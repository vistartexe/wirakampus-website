<?php
session_start();
require_once '../helper/connection.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: ../login.php");
    exit;
}

$user_id = $_SESSION['user_id'];

/* Get user role */
$user_query = mysqli_query($conn, "SELECT role FROM users WHERE id='$user_id'");
$user_data = mysqli_fetch_assoc($user_query);
$role = $user_data['role'];

$id = (int) $_POST['id'];

/* Input */
$name = mysqli_real_escape_string($conn, $_POST['name']);
$category = mysqli_real_escape_string($conn, $_POST['category']);
$price = (int) $_POST['price'];
$stok = (int) $_POST['stok'];
$whatsapp = mysqli_real_escape_string($conn, $_POST['whatsapp']);

/* --------------------------------------------------------------------------
   GET OLD PRODUCT (ROLE BASED)
-------------------------------------------------------------------------- */
if ($role === 'ADMIN') {

    $result = mysqli_query(
        $conn,
        "SELECT * FROM products WHERE id='$id' LIMIT 1"
    );

} else {

    $result = mysqli_query(
        $conn,
        "SELECT * FROM products 
         WHERE id='$id' 
         AND seller_id='$user_id'
         LIMIT 1"
    );
}

$product = mysqli_fetch_assoc($result);

/* If not found or unauthorized */
if (!$product) {
    if ($role === 'ADMIN') {
        header("Location: ../admin-dashboard/dashboard-admin.php");
    } else {
        header("Location: ../seller-dashboard/index.php");
    }
    exit;
}

$image_url = $product['image_url'];

/* --------------------------------------------------------------------------
   UPLOAD NEW IMAGE
-------------------------------------------------------------------------- */
if (isset($_FILES['image']) && $_FILES['image']['error'] === 0) {

    $allowed = ['jpg', 'jpeg', 'png', 'webp'];

    $extension = strtolower(
        pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION)
    );

    if (!in_array($extension, $allowed)) {
        die("Format gambar tidak didukung.");
    }

    $filename = uniqid('product_', true) . '.' . $extension;

    $upload_dir = '../uploads/products/';

    if (!is_dir($upload_dir)) {
        mkdir($upload_dir, 0777, true);
    }

    $upload_path = $upload_dir . $filename;

    if (move_uploaded_file($_FILES['image']['tmp_name'], $upload_path)) {

        /* Delete old image */
        if (!empty($product['image_url'])) {

            $old_file = '../' . str_replace('/wirakampus/', '', $product['image_url']);

            if (file_exists($old_file)) {
                unlink($old_file);
            }
        }

        $image_url = '/wirakampus/uploads/products/' . $filename;

    } else {
        die("Gagal mengunggah gambar.");
    }
}

/* --------------------------------------------------------------------------
   UPDATE QUERY (ROLE BASED)
-------------------------------------------------------------------------- */
if ($role === 'ADMIN') {

    $query = "
        UPDATE products
        SET
            name='$name',
            category='$category',
            price='$price',
            stok='$stok',
            image_url='$image_url',
            whatsapp='$whatsapp'
        WHERE id='$id'
    ";

} else {

    $query = "
        UPDATE products
        SET
            name='$name',
            category='$category',
            price='$price',
            stok='$stok',
            image_url='$image_url',
            whatsapp='$whatsapp'
        WHERE id='$id'
        AND seller_id='$user_id'
    ";
}

mysqli_query($conn, $query);

/* --------------------------------------------------------------------------
   REDIRECT BASED ON ROLE
-------------------------------------------------------------------------- */
if ($role === 'ADMIN') {
    header("Location: dashboard.php");
} else {
    header("Location: ../seller-dashboard/index.php");
}

exit;