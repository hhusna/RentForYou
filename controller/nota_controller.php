<?php
session_start();
require_once '../includes/db_connect.php';
require_once '../models/transaksi_model.php';

// Pastikan pengguna sudah login
if (!isset($_SESSION['user_id'])) {
    header("Location: login_controller.php");
    exit();
}

// Pastikan ada ID transaksi yang dikirim
if (!isset($_GET['id']) || empty($_GET['id'])) {
    header("Location: pesanan_controller.php");
    exit();
}

$id_transaksi = (int)$_GET['id'];

// Mengambil detail transaksi dari database
try {
    $transaction = getTransactionDetailsById($conn, $id_transaksi);
} catch (Exception $e) {
    die("Error: " . $e->getMessage());
}

// Jika transaksi tidak ditemukan
if (!$transaction) {
    die("Nota tidak ditemukan.");
}

// Keamanan: Pastikan hanya pemilik transaksi atau admin yang bisa melihat nota
if ($_SESSION['role'] !== 'admin' && $_SESSION['user_id'] !== $transaction['id_user']) {
    die("Anda tidak memiliki akses untuk melihat nota ini.");
}

// Mengatur judul halaman
$page_title = "Nota Transaksi #" . $transaction['id_transaksi'];

// Memuat file view untuk menampilkan halaman nota
include '../views/nota_view.php';
?>
