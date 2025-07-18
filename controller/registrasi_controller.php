<?php
// Memulai session di awal agar bisa digunakan untuk pesan error/sukses
session_start();

// Memuat file koneksi database dan model pengguna
require_once '../includes/db_connect.php';
require_once '../models/user_model.php';

// Inisialisasi variabel untuk pesan error
$errors = [];

// Memeriksa apakah request yang datang adalah POST (artinya form telah disubmit)
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // 1. Mengambil dan membersihkan data dari form
    $nama_lengkap = trim($_POST['nama_lengkap']);
    $username = trim($_POST['username']);
    $no_hp = trim($_POST['no_hp']);
    $email = trim($_POST['email']);
    $password = $_POST['password'];
    $konfirmasi_password = $_POST['konfirmasi_password'];

    // 2. Validasi Input
    if (empty($nama_lengkap)) $errors[] = "Nama lengkap wajib diisi.";
    if (empty($username)) $errors[] = "Username wajib diisi.";
    if (empty($no_hp)) $errors[] = "Nomor handphone wajib diisi.";
    if (empty($email)) {
        $errors[] = "Email wajib diisi.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Format email tidak valid.";
    }
    if (empty($password)) $errors[] = "Password wajib diisi.";
    if ($password !== $konfirmasi_password) $errors[] = "Konfirmasi password tidak cocok.";
    if (strlen($password) < 8) $errors[] = "Password minimal harus 8 karakter.";

    // Cek apakah username atau email sudah ada di database
    if (empty($errors)) {
        $user_exist = getUserByUsername($conn, $username);
        if ($user_exist) {
            $errors[] = "Username sudah digunakan, silakan pilih yang lain.";
        }
        // Anda juga bisa menambahkan pengecekan untuk email jika diperlukan
    }

    // 3. Proses Data jika tidak ada error
    if (empty($errors)) {
        // Hash password sebelum disimpan ke database untuk keamanan
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        // Menyiapkan data untuk disimpan
        $data = [
            'nama_lengkap' => $nama_lengkap,
            'username' => $username,
            'no_hp' => $no_hp,
            'email' => $email,
            'password' => $hashed_password
        ];

        // Memanggil fungsi createUser dari model
        $new_user_id = createUser($conn, $data);

        if ($new_user_id) {
            // Jika user berhasil dibuat, buat juga profil verifikasinya
            createVerificationProfile($conn, $new_user_id);

            // Set pesan sukses dan arahkan ke halaman login
            $_SESSION['success_message'] = "Registrasi berhasil! Silakan login.";
            header("Location: login_controller.php");
            exit();
        } else {
            $errors[] = "Terjadi kesalahan pada server. Silakan coba lagi.";
        }
    }

    // Jika ada error, simpan pesan error di session untuk ditampilkan di form
    if (!empty($errors)) {
        $_SESSION['error_message'] = implode('<br>', $errors);
        header("Location: registrasi_controller.php");
        exit();
    }
}

// Jika request adalah GET (pertama kali halaman dibuka), tampilkan view registrasi
include '../views/registrasi_view.php';

?>
