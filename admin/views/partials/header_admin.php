<?php
// Memulai session dan memeriksa apakah user adalah admin
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Jika tidak ada session user atau rolenya bukan admin, tendang ke halaman login
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../controller/login_controller.php");
    exit();
}

// Variabel $active_menu akan di-set oleh setiap controller
$active_menu = $active_menu ?? ''; 
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $page_title ?? 'Admin Panel - RentForYou'; ?></title>
    <link rel="stylesheet" href="../admin/css/admin_style.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital@1&display=swap" rel="stylesheet">
</head>
<body>
    <div class="admin-wrapper">
        <aside class="sidebar">
            <div class="sidebar-logo">
                RentForYou
            </div>
            <nav class="sidebar-nav">
                <a href=" ../admin/controller/dashboard_controller.php" class="<?php if($active_menu == 'dashboard') echo 'active'; ?>">Dashboard</a>
                <a href=" ../admin/controller/kelola_motor_controller.php" class="<?php if($active_menu == 'kelola_motor') echo 'active'; ?>">Kelola Motor</a>
                <a href=" ../admin/controller/kelola_transaksi_controller.php" class="<?php if($active_menu == 'kelola_transaksi') echo 'active'; ?>">Kelola Transaksi</a>
            </nav>
        </aside>
        <main class="main-content">
            <header class="main-header">
                <h2 class="page-title"><?php echo $page_title ?? 'Admin Panel'; ?></h2>
                <div class="admin-user-menu">
                    <div class="admin-welcome">
                        <span class="welcome-text">Halo Admin, <br><strong><?php echo htmlspecialchars($_SESSION['nama_lengkap']); ?></strong></span>
                    </div>
                    <a href=" ../controller/logout_controller.php" class="admin-logout-btn" title="Logout">
                        <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" fill="currentColor" viewBox="0 0 16 16">
                            <path fill-rule="evenodd" d="M10 12.5a.5.5 0 0 1-.5.5h-8a.5.5 0 0 1-.5-.5v-9a.5.5 0 0 1 .5-.5h8a.5.5 0 0 1 .5.5v2a.5.5 0 0 0 1 0v-2A1.5 1.5 0 0 0 9.5 2h-8A1.5 1.5 0 0 0 0 3.5v9A1.5 1.5 0 0 0 1.5 14h8a1.5 1.5 0 0 0 1.5-1.5v-2a.5.5 0 0 0-1 0v2z"/>
                            <path fill-rule="evenodd" d="M15.854 8.354a.5.5 0 0 0 0-.708l-3-3a.5.5 0 0 0-.708.708L14.293 7.5H5.5a.5.5 0 0 0 0 1h8.793l-2.147 2.146a.5.5 0 0 0 .708.708l3-3z"/>
                        </svg>
                    </a>
                </div>
            </header>
            <div class="content-body">
