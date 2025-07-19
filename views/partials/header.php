<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $page_title ?? 'RentForYou'; ?></title>
    <link rel="stylesheet" href="../assets/css/style.css">
    <style>
        html { scroll-behavior: smooth; }
    </style>
</head>
<body>
    <header class="header">
        <div class="container">
            <nav class="navbar">
                <a href="../controller/beranda_controller.php" class="nav-logo">RentForYou</a>
                <ul class="nav-menu">
                    <li class="nav-item"><a href="../controller/beranda_controller.php" class="nav-link">Beranda</a></li>
                    <li class="nav-item"><a href="../controller/beranda_controller.php#katalog" class="nav-link">Katalog</a></li>
                    <li class="nav-item"><a href="../controller/beranda_controller.php#syarat-ketentuan" class="nav-link">Syarat & Ketentuan</a></li>
                    <li class="nav-item"><a href="../controller/beranda_controller.php#fasilitas" class="nav-link">Fasilitas</a></li>
                </ul>
                <div class="nav-user">
                    <?php if (isset($_SESSION['user_id'])): ?>
                        <!-- Jika pengguna sudah login -->
                        <div class="user-menu">
                            <span class="welcome-user">Halo, <?php echo htmlspecialchars($_SESSION['nama_lengkap']); ?>!</span>
                            <ul class="dropdown-menu">
                                <li><a href="../controller/pesanan_controller.php">Pesanan Saya</a></li>
                                <li><a href="../controller/logout_controller.php">Logout</a></li>
                            </ul>
                        </div>
                    <?php else: ?>
                        <!-- Jika pengguna belum login -->
                        <a href="../controller/login_controller.php" class="btn-login-nav">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" viewBox="0 0 16 16">
                                <path d="M3 14s-1 0-1-1 1-4 6-4 6 3 6 4-1 1-1 1H3zm5-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6z"/>
                            </svg>
                            <span>Login</span>
                        </a>
                    <?php endif; ?>
                </div>
            </nav>
        </div>
    </header>
