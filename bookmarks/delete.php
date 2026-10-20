<?php
session_start();
require_once '../helper/connection.php';

/* AUTH CHECK (ADMIN ONLY SYSTEM) */
if (!isset($_SESSION['user_id'])) {
    header("Location: ../login.php");
    exit;
}

/* VALIDATE ID */
if (!isset($_GET['id'])) {
    header("Location: dashboard.php");
    exit;
}

$bookmark_id = (int) $_GET['id'];

if ($bookmark_id <= 0) {
    header("Location: dashboard.php");
    exit;
}

/* DELETE BOOKMARK */
mysqli_query(
    $conn,
    "DELETE FROM bookmarks WHERE id = $bookmark_id"
);

/* REDIRECT BACK */
header("Location: dashboard.php");
exit;
?>