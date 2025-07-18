<?php
// Memuat file-file yang diperlukan
require_once '../includes/db_connect.php';
require_once '../models/motor_model.php';

// Mengatur judul halaman
$page_title = "Katalog Motor - RentForYou";

// --- LOGIKA FILTER ---
$filters = [];
if (!empty($_GET['merk'])) {
    $filters['merk'] = $_GET['merk'];
}
if (!empty($_GET['harga'])) {
    $filters['harga'] = $_GET['harga'];
}

// Mengambil data motor dari database
try {
    if (!empty($filters)) {
        $motors = getMotorsByFilter($conn, $filters);
    } else {
        $motors = getAllMotors($conn);
    }
} catch (Exception $e) {
    die("Error: Tidak bisa mengambil data motor. " . $e->getMessage());
}

// Memuat file view untuk menampilkan halaman katalog
include '../views/katalog_view.php';
?>
