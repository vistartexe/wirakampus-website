<?php
$profilePic = !empty($_SESSION['profile_pic'])
    ? "/wirakampus/uploads/profiles/" . $_SESSION['profile_pic']
    : "/wirakampus/img/bg.png";
?>

<nav class="navbar sticky-top navbar-expand-lg bg-light shadow-sm">
  <div class="container-fluid px-3">

  <a class="navbar-brand fw-bold" style="margin-right:2px" href="/wirakampus/index.php">
      <img src="/wirakampus/img/logo_WK.png" width="60" height="45"> <span style="color: var(--color-blue-dark);"> Wira</span><span class="text-warning">Kampus</span>
  </a>

  <div class="vr mx-3"></div>

  <a href="/wirakampus/catalog/index.php" class="btn-outline" style="margin-right: -10px">
    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="margin-right: 8px;"><rect x="3" y="3" width="7" height="7"></rect><rect x="14" y="3" width="7" height="7"></rect><rect x="14" y="14" width="7" height="7"></rect><rect x="3" y="14" width="7" height="7"></rect></svg>
    CATALOG
  </a>

  <form class="flex-grow-1 mx-4" method="GET" action="/wirakampus/catalog/index.php">
    <div class="input-group">
        <span class="input-group-text bg-white border-end-0">
          <i class="bi bi-search"></i>
        </span>

        <input 
            type="text" 
            class="form-control border-start-0"
            name="q"
            placeholder="Cari di WiraKampus"
            value="<?= isset($_GET['q']) ? htmlspecialchars($_GET['q']) : '' ?>"
        >
    </div>
  </form>

  <!-- RIGHT SIDE -->
  <div class="d-flex align-items-center ms-auto gap-2" style="margin: 0px">

  <?php if (isset($_SESSION['user_id'])): ?>
        <!-- CART ICON -->
        <a href="/wirakampus/bookmarks/index.php" class="bi bi-bookmark fs-4" style="margin-left: 10px; color: #f59e0b;"></a>

        <div class="vr mx-3"></div>

        <a href="/wirakampus/profile/index.php" style="display: flex; align-items: center; gap: 8px; text-decoration: none; color: var(--text-primary); font-weight: 500; font-size: 14px;">
        <img src="<?= $profilePic ?>" alt="Avatar" style="width: 32px; height: 32px; border-radius: 50%; object-fit: cover;">
        <?php echo $_SESSION['user_name'] ?>
        </a>

  <?php else: ?>
        <!-- REGISTER -->
        <a href="/wirakampus/register.php" class="btn-outline">Register</a>

        <!-- LOGIN -->
        <a href="/wirakampus/login.php" class="btn-primary">Login</a>
  <?php endif; ?>
  </div>
</nav>