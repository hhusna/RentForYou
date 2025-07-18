<?php
// Memulai session di awal
session_start();

// Memuat file koneksi dan model
require_once '../includes/db_connect.php';
require_once '../models/user_model.php';

// Inisialisasi variabel untuk pesan
$errors = [];

// Memeriksa apakah form telah disubmit
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username']);
    $password = $_POST['password'];
    $role_to_login = $_POST['role']; 

    if (empty($username) || empty($password)) {
        $errors[] = "Username dan password wajib diisi.";
    }

    if (empty($errors)) {
        $user = getUserByUsername($conn, $username);

        if ($user && password_verify($password, $user['password'])) {
            if ($user['role'] === $role_to_login) {
                $_SESSION['user_id'] = $user['id_user'];
                $_SESSION['username'] = $user['username'];
                $_SESSION['nama_lengkap'] = $user['nama_lengkap'];
                $_SESSION['role'] = $user['role'];

                // Arahkan ke halaman yang sesuai
                if ($user['role'] === 'admin') {
                    // PERBAIKAN: Arahkan ke controller dashboard yang benar dengan path absolut
                    header("Location: /RentForYou/admin/controller/dashboard_controller.php");
                } else {
                    header("Location: /RentForYou/controller/beranda_controller.php");
                }
                exit();
            } else {
                $errors[] = "Anda tidak memiliki akses untuk login sebagai " . ucfirst($role_to_login) . ".";
            }
        } else {
            $errors[] = "Username atau password salah.";
        }
    }

    if (!empty($errors)) {
        $_SESSION['error_message'] = implode('<br>', $errors);
        header("Location: login_controller.php");
        exit();
    }
}

// Jika request adalah GET, tampilkan view login
include '../views/login_view.php';
?>
