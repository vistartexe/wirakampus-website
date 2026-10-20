<?php
session_start();
require_once '../helper/connection.php';

/* DASHBOARD STATS QUERY */

/* TOTAL USERS */
$user_query = mysqli_query($conn, "SELECT COUNT(*) AS total_users FROM users");
$user_data = mysqli_fetch_assoc($user_query);
$total_users = $user_data['total_users'];

/* TOTAL PRODUCTS */
$product_query = mysqli_query($conn, "SELECT COUNT(*) AS total_products FROM products");
$product_data = mysqli_fetch_assoc($product_query);
$total_products = $product_data['total_products'];

/* TOTAL BOOKMARKS */
$bookmark_query = mysqli_query($conn, "SELECT COUNT(*) AS total_bookmarks FROM bookmarks");
$bookmark_data = mysqli_fetch_assoc($bookmark_query);
$total_bookmarks = $bookmark_data['total_bookmarks'];

?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Dashboard | WiraKampus</title>

  <!-- Bootstrap -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">

  <!-- Icons -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">

  <!-- Favicon -->
  <link rel="icon" type="image/png" sizes="70x45" href="/wirakampus/img/logo_WK.png">

  <!-- CSS -->
  <link rel="stylesheet" href="../css/globals.css">
  <link rel="stylesheet" href="../css/style_index.css">
  <link rel="stylesheet" href="../css/style_dashboard-admin.css">
</head>

<body>

<?php include '../components/navbar.php'; ?>

<div class="admin-layout">

  <?php include '../components/sidebar-admin.php'; ?>

  <!-- CONTENT -->
  <div class="admin-content">

    <div class="admin-header">
      <h1>Dashboard</h1>
      <p>Selamat datang! Disinilah untuk overview.</p>
    </div>

    <div class="admin-stats">

      <!-- USERS -->
      <div class="admin-stat-card">
        <div class="stat-icon-box blue">
          <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
            <circle cx="12" cy="7" r="4"></circle>
          </svg>
        </div>
        <div class="admin-stat-info">
          <div class="admin-stat-label">TOTAL USERS</div>
          <div class="admin-stat-value"><?= $total_users ?></div>
        </div>
      </div>

      <!-- PRODUCTS -->
      <div class="admin-stat-card">
        <div class="stat-icon-box red">
          <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
            <polyline points="14 2 14 8 20 8"></polyline>
            <line x1="16" y1="13" x2="8" y2="13"></line>
            <line x1="16" y1="17" x2="8" y2="17"></line>
          </svg>
        </div>
        <div class="admin-stat-info">
          <div class="admin-stat-label">TOTAL PRODUCTS</div>
          <div class="admin-stat-value"><?= $total_products ?></div>
        </div>
      </div>

      <!-- BOOKMARKS -->
      <div class="admin-stat-card">
        <div class="stat-icon-box orange">
          <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
            <polyline points="14 2 14 8 20 8"></polyline>
            <line x1="16" y1="13" x2="8" y2="13"></line>
            <line x1="16" y1="17" x2="8" y2="17"></line>
          </svg>
        </div>
        <div class="admin-stat-info">
          <div class="admin-stat-label">TOTAL BOOKMARK</div>
          <div class="admin-stat-value"><?= $total_bookmarks ?></div>
        </div>
      </div>

    </div>

  </div>
</div>

<!-- JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>