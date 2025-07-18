<?php
session_start();
require_once '../includes/db_connect.php';
require_once '../models/transaksi_model.php';

// Constraint: Pastikan pengguna sudah login
if (!isset($_SESSION['user_id'])) {
    $_SESSION['error_message'] = "Anda harus login untuk melihat halaman ini.";
    header("Location: login_controller.php");
    exit();
}

// Mengatur judul halaman
$page_title = "Pesanan Saya";

// Mengambil semua data transaksi untuk pengguna yang sedang login
try {
    $transactions = getTransactionsByUserId($conn, $_SESSION['user_id']);
} catch (Exception $e) {
    die("Error: Tidak bisa mengambil data pesanan. " . $e->getMessage());
}

// Memuat file view untuk menampilkan halaman
include '../views/pesanan_view.php';
?>
