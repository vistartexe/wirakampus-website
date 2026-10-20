<?php
session_start();

require_once 'helper/connection.php';
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>WiraKampus</title>

  <!-- Bootstrap -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">

  <!-- Icons -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">

  <!-- Favicon -->
  <link rel="icon" type="image/png" sizes="70x45" href="/wirakampus/img/logo_WK.png">

  <!-- CSS -->
  <link rel="stylesheet" href="css/globals.css">
  <link rel="stylesheet" href="css/style_index.css">

</head>
<body>
  <?php include 'components/navbar.php'; ?>

  <!-- Hero Section -->
  <section class="hero">
    <div class="hero-text">
      <h1>
        <span class="line1">JUAL BELI DI LINGKUNGAN</span>
        <span class="line2">MAHASISWA</span>
      </h1>
      <p>Platform e-commerce eksklusif untuk kemudahan jual beli. Aman, cepat, dan dari mahasiswa untuk mahasiswa.</p>
      <div style="display: flex; gap: 16px; flex-wrap: wrap;">
        <a href="register.php" class="btn-primary">
          <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="margin-right: 8px;"><circle cx="9" cy="21" r="1"></circle><circle cx="20" cy="21" r="1"></circle><path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"></path></svg>
          BUAT TOKO
        </a>
        <a href="catalog/index.php" class="btn-outline">
          <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="margin-right: 8px;"><rect x="3" y="3" width="7" height="7"></rect><rect x="14" y="3" width="7" height="7"></rect><rect x="14" y="14" width="7" height="7"></rect><rect x="3" y="14" width="7" height="7"></rect></svg>
          CATALOG
        </a>
      </div>
    </div>
    <div class="hero-illustration">
      <div class="glass-card">
        <img src="img/dasboard.png" alt="Student Marketplace 3D" width="200" height="350">
      </div>
    </div>
  </section>

  <!-- Keunggulan Section -->
  <section class="features">
    <h2>PLATFORM TERBAIK JUAL BELI MAHASISWA</h2>
    <p>Dirancang khusus untuk memenuhi kebutuhan transaksi di kampus.</p>
    
    <div class="features-grid">
      <div class="feature-item">
        <div class="feature-icon-wrapper">
          <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20.59 13.41l-7.17 7.17a2 2 0 0 1-2.83 0L2 12V2h10l8.59 8.59a2 2 0 0 1 0 2.82z"></path><line x1="7" y1="7" x2="7.01" y2="7"></line></svg>
        </div>
        <h4>Harga Enak</h4>
        <p>Produk berkualitas dengan harga yang ramah di kantong mahasiswa.</p>
      </div>
      <div class="feature-item">
        <div class="feature-icon-wrapper">
          <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"></path><circle cx="12" cy="10" r="3"></circle></svg>
        </div>
        <h4>Flexible Deliver</h4>
        <p>Bisa COD di area kampus, menyesuaikan jadwal kuliahmu.</p>
      </div>
      <div class="feature-item">
        <div class="feature-icon-wrapper">
          <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path><circle cx="9" cy="7" r="4"></circle><path d="M23 21v-2a4 4 0 0 0-3-3.87"></path><path d="M16 3.13a4 4 0 0 1 0 7.75"></path></svg>
        </div>
        <h4>Komunitas Mahasiswa</h4>
        <p>Dukung teman se-kampus dengan bertransaksi di ekosistem sendiri.</p>
      </div>
      <div class="feature-item">
        <div class="feature-icon-wrapper">
          <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"></path></svg>
        </div>
        <h4>Transaksi Terjamin</h4>
        <p>Identitas penjual terverifikasi, transaksi lebih aman dan terpercaya.</p>
      </div>
    </div>
  </section>

  <!-- Kategori Section -->
  <section class="categories">
    <div class="category-grid">
      <!-- Styling -->
      <div class="glass-card category-card">
        <img src="img/STYLING.png" alt="Styling">
        <div class="category-card-info">
          <h4>Styling</h4>
          <p>Produk berkualitas dan banyak pilihan dengan harga yang mahasiswa banget.</p>
        </div>
      </div>
      <!-- Food -->
      <div class="glass-card category-card">
        <img src="img/FOOD.png" alt="Food">
        <div class="category-card-info">
          <h4>Food</h4>
          <p>Berbagai pilihan makanan dan minuman favorit mahasiswa dengan harga terjangkau</p>
        </div>
      </div>
      <!-- Preloved -->
      <div class="glass-card category-card">
        <img src="img/PRELOVED.png" alt="Preloved">
        <div class="category-card-info">
          <h4>Preloved</h4>
          <p>Secondhand tapi tetap berkualitas, solusi hemat untuk kebutuhan kampus</p>
        </div>
      </div>
      <!-- Jasa -->
      <div class="glass-card category-card">
        <img src="img/JASA.png" alt="Jasa">
        <div class="category-card-info">
          <h4>Jasa</h4>
          <p>Solusi cepat untuk urusan kampus, mahasiswa membantu mahasiswa</p>
        </div>
      </div>
    </div>
  </section>

  <!-- Brand Section -->
  <section class="brand-section" style="margin-bottom:50px; margin-top:-50px">
    <div class="brand-title">
      <span class="wira">Wira</span><span class="kampus">Kampus</span>
    </div>
    <div class="brand-line"></div>
  </section>

  <!-- Footer -->
  <footer class="footer">
    <div class="footer-grid">
      <div>
        <h5>Wira<span class="text-warning">Kampus</span></h5>
        <p>Platform jual beli khusus mahasiswa untuk memenuhi kebutuhan kampus dengan mudah, cepat, dan terpercaya.</p>
      </div>
      <div>
        <h5>Menu</h5>
        <ul>
          <li style="margin-left:-32px"><a href="index.php">Home</a></li>
          <li style="margin-left:-32px"><a href="catalog/index.php">Catalog</a></li>
        </ul>
      </div>
    </div>

    <hr>
    
    <div class="footer-bottom">
      © 2026 WiraKampus. All rights reserved.
    </div>
  </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.min.js" integrity="sha384-G/EV+4j2dNv+tEPo3++6LCgdCROaejBqfUeNjuKAiuXbjrxilcCdDz6ZAVfHWe1Y" crossorigin="anonymous"></script>  
</body>
</html>
