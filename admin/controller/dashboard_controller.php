<?php
$active_menu = 'dashboard'; 
$page_title = "Dashboard";

require_once '../../includes/db_connect.php';
require_once '../../models/motor_model.php';
require_once '../../models/transaksi_model.php';

// Mengambil semua data statistik dari model
try {
    $pesanan_baru = countPendingTransactions($conn);
    $kembali_hari_ini = countDueTodayTransactions($conn);
    $motor_disewa = countActiveRentals($conn);
    $stok_tersedia = countAvailableStock($conn);
    $stok_habis = countOutOfStockMotors($conn);
    $pendapatan_bulan_ini = getMonthlyRevenue($conn);
} catch (Exception $e) {
    // Jika ada error, hentikan dan tampilkan pesan
    die("Error saat mengambil data dashboard: " . $e->getMessage());
}

// Memuat file view untuk menampilkan halaman dashboard
include '../views/dashboard_view.php';
?>
