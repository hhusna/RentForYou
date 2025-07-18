<?php
require_once '../../includes/db_connect.php';
require_once '../../models/motor_model.php';
session_start();

$page_title = "Edit Data Motor";
$active_menu = 'kelola_motor'; // Agar menu sidebar tetap aktif

// Pastikan ada ID motor yang dikirim
if (!isset($_GET['id'])) {
    header("Location: kelola_motor_controller.php");
    exit();
}
$id_motor = (int)$_GET['id'];

// Proses form jika disubmit (method POST)
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = [
        'merk' => $_POST['merk'],
        'model' => $_POST['model'],
        'tahun' => $_POST['tahun'],
        'harga_perHari' => $_POST['harga_perHari'],
        'stok' => $_POST['stok'],
        'deskripsi' => $_POST['deskripsi']
    ];

    // Logika upload gambar baru jika ada
    if (isset($_FILES['gambar']) && $_FILES['gambar']['error'] === UPLOAD_ERR_OK) {
        $file = $_FILES['gambar'];
        $fileName = time() . '_' . basename($file['name']);
        $uploadDir = '../../assets/uploads/';
        $uploadFilePath = $uploadDir . $fileName;

        if (move_uploaded_file($file['tmp_name'], $uploadFilePath)) {
            $data['gambar'] = $fileName; // Tambahkan nama file baru ke data
            // TODO: Hapus file gambar lama jika perlu
        } else {
            $_SESSION['error_message'] = "Gagal mengupload gambar baru.";
        }
    }

    if (!isset($_SESSION['error_message'])) {
        if (updateMotor($conn, $id_motor, $data)) {
            $_SESSION['success_message'] = "Data motor berhasil diperbarui!";
            header("Location: kelola_motor_controller.php");
            exit();
        } else {
            $_SESSION['error_message'] = "Gagal memperbarui data motor.";
        }
    }
}

// Ambil data motor yang akan diedit untuk ditampilkan di form
$motor = getMotorById($conn, $id_motor);
if (!$motor) {
    die("Motor tidak ditemukan.");
}

include '../views/edit_motor_view.php';
?>
