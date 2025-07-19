<?php
/**
 * logout_controller.php
 * Menangani proses logout pengguna.
 */

// 1. Selalu mulai session di awal
session_start();

// 2. Hapus semua variabel yang tersimpan di dalam session
$_SESSION = array();

// 3. Hancurkan session
// Jika menggunakan cookie session, hapus juga cookie-nya.
if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(session_name(), '', time() - 42000,
        $params["path"], $params["domain"],
        $params["secure"], $params["httponly"]
    );
}

// Terakhir, hancurkan session-nya.
session_destroy();

// 4. Arahkan pengguna kembali ke halaman login CONTROLLER 
header("Location:../controller/beranda_controller.php");
exit();
?>
