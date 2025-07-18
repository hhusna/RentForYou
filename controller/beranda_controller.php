<?php
    session_start();
    require_once '../includes/db_connect.php';
    require_once '../models/motor_model.php';

    // Mengatur judul halaman
    $page_title = "Sewa Motor Terbaik di Jogja - RentForYou";

    // --- FILTER ---
    $filters = [];
    if (!empty($_GET['merk'])) $filters['merk'] = $_GET['merk'];
    if (!empty($_GET['harga'])) $filters['harga'] = $_GET['harga'];
    if (!empty($_GET['q'])) $filters['q'] = $_GET['q'];

    try {
        // Memanggil fungsi yang benar dari model
        if (!empty($filters)) {
            $motors = getMotorsByFilter($conn, $filters);
        } else {
            $motors = getMotorsForCatalog($conn);
        }
    } catch (Exception $e) {
        // Hentikan eksekusi dan tampilkan error jika ada masalah
        die("Error: Tidak bisa mengambil data motor. " . $e->getMessage());
    }

    include '../views/beranda_view.php';
?>
