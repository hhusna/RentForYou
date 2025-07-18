<?php
require_once '../../includes/db_connect.php';
require_once '../../models/motor_model.php';
session_start();

// Pastikan ada ID motor yang dikirim
if (isset($_GET['id'])) {
    $id_motor = (int)$_GET['id'];

    // Panggil fungsi deleteMotor dari model
    if (deleteMotor($conn, $id_motor)) {
        // Jika berhasil, set pesan sukses
        $_SESSION['success_message'] = "Data motor berhasil dihapus.";
    } else {
        // Jika gagal, set pesan error
        $_SESSION['error_message'] = "Gagal menghapus data motor. Mungkin motor ini terkait dengan transaksi yang ada.";
    }
} else {
    // Jika tidak ada ID, set pesan error
    $_SESSION['error_message'] = "ID motor tidak valid.";
}

// Arahkan kembali ke halaman kelola motor untuk melihat hasilnya
header("Location: kelola_motor_controller.php");
exit();
?>
