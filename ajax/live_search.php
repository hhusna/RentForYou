<?php
// Memuat file-file yang diperlukan
require_once '../includes/db_connect.php';
require_once '../models/motor_model.php';

// Menyiapkan array untuk menampung semua filter
$filters = [];

// Menangkap semua parameter filter yang mungkin dikirim
if (!empty($_GET['q'])) {
    $filters['q'] = $_GET['q'];
}
if (!empty($_GET['merk'])) {
    $filters['merk'] = $_GET['merk'];
}
if (!empty($_GET['harga'])) {
    $filters['harga'] = $_GET['harga'];
}

// Ambil data motor berdasarkan filter yang terkumpul
$motors = getMotorsByFilter($conn, $filters);

// Jika ada hasilnya, buat HTML untuk setiap kartu motor
if (!empty($motors)) {
    foreach ($motors as $motor) {
        // Menentukan path gambar dan placeholder
        $image_path = " ../assets/uploads/" . htmlspecialchars($motor['gambar']);
        $placeholder_path = "https://placehold.co/600x400/f1f5f9/a0aec0?text=Gambar+Tidak+Tersedia";
        $real_image_path = $_SERVER['DOCUMENT_ROOT'] . '../assets/uploads/' . $motor['gambar'];
        $final_image_src = (!empty($motor['gambar']) && file_exists($real_image_path)) ? $image_path : $placeholder_path;

        // Echo (kirim) HTML untuk setiap kartu motor
        echo '<div class="motor-card">';
        echo '    <div class="card-image">';
        echo '        <img src="' . $final_image_src . '" alt="Gambar ' . htmlspecialchars($motor['merk'] . ' ' . $motor['model']) . '">';
        echo '    </div>';
        echo '    <div class="card-content">';
        echo '        <h3 class="card-title">' . htmlspecialchars($motor['model']) . '</h3>';
        echo '        <p class="card-price">Rp ' . number_format($motor['harga_perHari'], 0, ',', '.') . ' / hari</p>';
        echo '        <a href="detail_motor_controller.php?id=' . $motor['id_motor'] . '" class="btn btn-pesan">Pesan</a>';
        echo '    </div>';
        echo '</div>';
    }
} else {
    // Jika tidak ada hasil, kirim pesan
    echo '<p style="text-align: center; grid-column: 1 / -1;">Motor tidak ditemukan.</p>';
}
?>
