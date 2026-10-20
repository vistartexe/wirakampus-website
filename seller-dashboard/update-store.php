<?php
session_start();
require_once '../helper/connection.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: ../login.php");
    exit;
}

$user_id = $_SESSION['user_id'];

$store_name = mysqli_real_escape_string(
    $conn,
    $_POST['store_name']
);

$store_description = mysqli_real_escape_string(
    $conn,
    $_POST['store_description']
);

mysqli_query(
    $conn,
    "UPDATE users
     SET
        store_name = '$store_name',
        store_description = '$store_description'
     WHERE id = '$user_id'"
);

header("Location: ../seller-dashboard/index.php");
exit;