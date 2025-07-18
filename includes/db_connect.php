<?php
/**
 * File ini digunakan untuk menghubungkan aplikasi ke database MySQL.
 * Simpan file ini di dalam folder /includes/
 */

// --- PENGATURAN KONEKSI DATABASE ---
// Sesuaikan dengan pengaturan di server lokal (XAMPP) atau hosting-mu.

$host = "localhost";        // atau 127.0.0.1
$db_name = "rentforyou";    // Nama database yang sudah kita buat (SUDAH DIPERBAIKI)
$username = "root";         // Username default untuk XAMPP
$password = "";             // Password default untuk XAMPP (kosong)

// --- MEMBUAT KONEKSI MENGGUNAKAN PDO ---
// PDO (PHP Data Objects) adalah cara yang lebih modern dan aman untuk berinteraksi dengan database.

try {
    // Membuat objek koneksi PDO baru
    $conn = new PDO("mysql:host={$host};dbname={$db_name}", $username, $password);

    // Mengatur mode error PDO ke exception
    // Ini akan membuat PDO "melempar" kesalahan sebagai exception, yang bisa kita tangkap.
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Mengatur mode pengambilan data default ke associative array
    // Ini membuat hasil query menjadi array dengan nama kolom sebagai key (misal: $row['username'])
    $conn->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);

} catch(PDOException $e) {
    // Jika koneksi gagal, hentikan script dan tampilkan pesan error.
    // Sebaiknya pesan ini tidak ditampilkan di lingkungan produksi untuk alasan keamanan.
    die("Koneksi ke database gagal: " . $e->getMessage());
}

// Jika tidak ada error, variabel $conn sekarang siap digunakan untuk melakukan query ke database.
?>
