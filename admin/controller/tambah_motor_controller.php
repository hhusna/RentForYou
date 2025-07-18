<?php
require_once '../../includes/db_connect.php';
require_once '../../models/motor_model.php';
session_start();

$page_title = "Tambah Motor Baru";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = [
        'merk' => $_POST['merk'],
        'model' => $_POST['model'],
        'tahun' => $_POST['tahun'],
        'harga_perHari' => $_POST['harga_perHari'],
        'deskripsi' => $_POST['deskripsi'],
        'gambar' => '' // Default value
    ];

    // --- LOGIKA UPLOAD GAMBAR ---
    if (isset($_FILES['gambar']) && $_FILES['gambar']['error'] === UPLOAD_ERR_OK) {
        $file = $_FILES['gambar'];
        $fileName = time() . '_' . basename($file['name']);
        // Tentukan folder tujuan upload. Pastikan folder ini ada dan bisa ditulis (writable).
        $uploadDir = '../../assets/uploads/';
        $uploadFilePath = $uploadDir . $fileName;

        // Pindahkan file yang di-upload ke folder tujuan
        if (move_uploaded_file($file['tmp_name'], $uploadFilePath)) {
            $data['gambar'] = $fileName; // Simpan nama file ke data
        } else {
            $_SESSION['error_message'] = "Gagal mengupload gambar.";
        }
    }

    if (!isset($_SESSION['error_message'])) {
        // 1. Cek apakah motor dengan merk dan model yang sama sudah ada di database
        $existingMotor = getMotorByMerkModel($conn, $merk, $model);

        if ($existingMotor) {
            // 2. Jika motor sudah ada, tambahkan stoknya
            $newStock = $existingMotor['stok'] + 1;
            if (updateMotorStock($conn, $existingMotor['id'], $newStock)) {
                $_SESSION['success_message'] = "Stok motor '{$merk} {$model}' berhasil ditambahkan menjadi {$newStock}!";
                header("Location: kelola_motor_controller.php");
                exit();
            } else {
                $_SESSION['error_message'] = "Gagal memperbarui stok motor.";
            }
        } else {
            // 3. Jika motor belum ada, buat entri baru dengan stok = 1
            $data = [
                'merk' => $merk,
                'model' => $model,
                'tahun' => $tahun,
                'harga_perHari' => $harga_perHari,
                'stok' => 1, // Otomatis stok = 1 untuk motor baru
                'deskripsi' => $deskripsi,
                'gambar' => $gambar
            ];

            if (createMotor($conn, $data)) {
                $_SESSION['success_message'] = "Motor baru '{$merk} {$model}' berhasil ditambahkan dengan stok 1!";
                header("Location: kelola_motor_controller.php");
                exit();
            } else {
                $_SESSION['error_message'] = "Gagal menambahkan motor baru ke database.";
            }
        }
    }
}

include '../views/tambah_motor_view.php';
?>
