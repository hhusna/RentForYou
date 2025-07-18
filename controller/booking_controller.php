<?php
session_start();
require_once '../includes/db_connect.php';
require_once '../models/user_model.php';
require_once '../models/motor_model.php';
require_once '../models/transaksi_model.php';

// --- LANGKAH 1: PENGECEKAN LOGIN (CONSTRAINT) ---
// Jika tidak ada session user_id, artinya pengguna belum login.
if (!isset($_SESSION['user_id'])) {
    // Simpan pesan untuk ditampilkan di halaman login
    $_SESSION['error_message'] = "Anda harus login terlebih dahulu untuk melakukan pemesanan.";
    // Arahkan ke halaman login
    header("Location: login_controller.php");
    exit();
}

// --- LANGKAH 2: PROSES DATA ---
// Jika metode request adalah POST, artinya pengguna baru saja mengirimkan data.
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
    // Jika pengguna mengirimkan form dari halaman detail motor
    if (isset($_POST['lanjut_pesan'])) {
        // Ambil data dari form detail motor
        $id_motor = $_POST['id_motor'];
        $tanggal_sewa = $_POST['tanggal_sewa'];
        $tanggal_kembali = $_POST['tanggal_kembali'];
        
        // Simpan data ini ke session agar tidak hilang saat mengisi form verifikasi
        $_SESSION['booking_data'] = [
            'id_motor' => $id_motor,
            'tanggal_sewa' => $tanggal_sewa,
            'tanggal_kembali' => $tanggal_kembali
        ];
        
        // Ambil data motor untuk ditampilkan di halaman booking
        $motor = getMotorById($conn, $id_motor);
        // Ambil status verifikasi user
        // (Kita akan buat fungsi ini di user_model.php)
        $verifikasi = getVerificationDataByUserId($conn, $_SESSION['user_id']);
        
        $is_verified = false;
        if ($verifikasi && $verifikasi['status_verifikasi'] === 'terverifikasi') {
            $is_verified = true;
        }

        // Jika user belum terverifikasi, tampilkan form verifikasi
        if (!$is_verified) {
            $page_title = "Lengkapi Data Diri";
            include '../views/booking_view.php';
            exit();
        } else {
            // Jika sudah terverifikasi, bisa langsung proses transaksi
            // (Logika ini bisa dikembangkan lebih lanjut)
            // Untuk sekarang, kita anggap semua harus lewat form booking
            $page_title = "Konfirmasi Pemesanan";
            include '../views/booking_view.php';
            exit();
        }
    }

// Jika pengguna mengirimkan form dari halaman booking (form verifikasi)
    if (isset($_POST['ajukan_sewa'])) {
        $id_user = $_SESSION['user_id'];
        $alamat = $_POST['alamat'];
        
        // --- Proses Upload File ---
        $uploadDir = '../../assets/uploads/identitas/';
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }

        $foto_ktp_name = '';
        if (isset($_FILES['foto_ktp']) && $_FILES['foto_ktp']['error'] === UPLOAD_ERR_OK) {
            $foto_ktp_name = time() . '_ktp_' . basename($_FILES['foto_ktp']['name']);
            move_uploaded_file($_FILES['foto_ktp']['tmp_name'], $uploadDir . $foto_ktp_name);
        }

        $foto_sim_name = '';
        if (isset($_FILES['foto_sim']) && $_FILES['foto_sim']['error'] === UPLOAD_ERR_OK) {
            $foto_sim_name = time() . '_sim_' . basename($_FILES['foto_sim']['name']);
            move_uploaded_file($_FILES['foto_sim']['tmp_name'], $uploadDir . $foto_sim_name);
        }

        // Simpan data verifikasi ke database
        $verificationData = [
            'id_user' => $id_user,
            'alamat' => $alamat,
            'foto_ktp' => $foto_ktp_name,
            'foto_sim' => $foto_sim_name
        ];
        updateVerificationData($conn, $verificationData);

        // --- Proses Transaksi ---
        $booking_data = $_SESSION['booking_data'];
        $motor = getMotorById($conn, $booking_data['id_motor']);
        
        // Hitung total harga
        $tgl1 = new DateTime($booking_data['tanggal_sewa']);
        $tgl2 = new DateTime($booking_data['tanggal_kembali']);
        $durasi = $tgl2->diff($tgl1)->days + 1; // +1 agar hari pertama dihitung
        $total_harga = $durasi * $motor['harga_perHari'];

        // Siapkan data untuk disimpan ke tabel transaksi
        $transactionData = [
            'id_user' => $id_user,
            'id_motor' => $booking_data['id_motor'],
            'tanggal_sewa' => $booking_data['tanggal_sewa'],
            'tanggal_kembali' => $booking_data['tanggal_kembali'],
            'total_harga' => $total_harga
        ];

        // Buat transaksi baru di database
        if (createTransaction($conn, $transactionData)) {
            unset($_SESSION['booking_data']); // Hapus data booking dari session
            $_SESSION['success_message'] = "Pengajuan sewa berhasil! Mohon tunggu konfirmasi dari admin.";
            header("Location: pesanan_controller.php");
            exit();
        } else {
            $_SESSION['error_message'] = "Gagal menyimpan data pesanan.";
            header("Location: booking_controller.php"); // Kembali ke halaman booking jika gagal
            exit();
        }
    }
}

// Jika tidak ada request POST, kembalikan ke beranda
header("Location: beranda_controller.php");
exit();
