<?php
// Memuat file-file yang diperlukan
require_once '../../includes/db_connect.php';
require_once '../../models/motor_model.php';

// Mengatur judul halaman
$page_title = "Kelola Data Motor";

// Mengambil semua data motor dari database (termasuk yang stoknya 0)
// Kita akan asumsikan fungsi getAllMotors() bisa menangani ini, atau buat fungsi baru jika perlu.
try {
    $motors = getAllMotorsForAdmin($conn); // Menggunakan fungsi yang sudah ada
} catch (Exception $e) {
    die("Error: " . $e->getMessage());
}

// Memuat file view untuk menampilkan halaman
include '../views/kelola_motor_view.php';
?>
