<?php
require_once '../../includes/db_connect.php'; // Pastikan ini mengembalikan objek PDO
require_once '../../models/transaksi_model.php'; // Sertakan model transaksi
session_start();

$page_title = "Kelola Transaksi"; // Judul halaman untuk header

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: /RentForYou/controller/login_controller.php");
    exit();
}

$page_title = "Kelola Transaksi";

// Tangani aksi POST untuk mengubah status transaksi (misal: dari tombol di view)
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action'], $_POST['id_transaksi'])) {
    $id_transaksi = (int)$_POST['id_transaksi'];
    $action = $_POST['action'];
    $new_status = '';

    // Tentukan status baru berdasarkan aksi yang dikirim dari form
    switch ($action) {
        case 'setujui':
            $new_status = 'pesanan_disetujui';
            break;
        case 'tolak':
            $new_status = 'pesanan_ditolak';
            break;
        case 'mulai_sewa':
            $new_status = 'sedang_berjalan';
            break;
        case 'selesai':
            $new_status = 'selesai';
            break;
    }

    // Jika status baru valid, panggil fungsi model untuk memperbarui database
    if (!empty($new_status)) {
        if (updateTransactionStatus($conn, $id_transaksi, $new_status)) {
            $_SESSION['success_message'] = "Status transaksi #" . $id_transaksi . " berhasil diperbarui.";
        } else {
            $_SESSION['error_message'] = "Gagal memperbarui status transaksi.";
        }
    } else {
        $_SESSION['error_message'] = "Aksi tidak valid.";
    }

    // Redirect kembali ke halaman ini untuk mencegah pengiriman form berulang kali
    header("Location: kelola_transaksi_controller.php");
    exit();
}

// Ambil semua data transaksi untuk ditampilkan di halaman
// Ini akan memanggil fungsi getAllTransactions dari model yang ada di Canvas
try {
    $transactions = getAllTransactions($conn);
} catch (Exception $e) {
    $transactions = [];
    $_SESSION['error_message'] = "Terjadi error saat mengambil data transaksi: " . $e->getMessage();
}

// Sertakan view untuk menampilkan data
include '../views/kelola_transaksi_view.php';
?>
