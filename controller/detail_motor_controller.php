<?php
// Memuat file-file yang diperlukan
require_once '../includes/db_connect.php';
require_once '../models/motor_model.php';

// Pastikan ada ID motor yang dikirim melalui URL
if (!isset($_GET['id']) || empty($_GET['id'])) {
    // Jika tidak ada ID, arahkan kembali ke beranda
    header("Location: beranda_controller.php");
    exit();
}

$id_motor = (int)$_GET['id'];

// Mengambil data motor spesifik dari database
try {
    $motor = getMotorById($conn, $id_motor);
} catch (Exception $e) {
    die("Error: " . $e->getMessage());
}

// Jika motor dengan ID tersebut tidak ditemukan, tampilkan pesan error
if (!$motor) {
    // Anda bisa membuat halaman 404 yang lebih bagus nanti
    die("Motor tidak ditemukan.");
}

// Mengatur judul halaman secara dinamis
$page_title = "Detail " . htmlspecialchars($motor['merk'] . ' ' . $motor['model']);

// Memuat file view dan mengirimkan data motor ke dalamnya
include '../views/detail_motor_view.php';
?>
