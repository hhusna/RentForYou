<?php
define('SITE_URL', 'http://rentforyou.project2ks2.my.id/');
$host = "localhost";        
$db_name = "projec15_rentforyou";    
$username = "projec15_root";         
$password = "@kaesquare123";             

// --- MEMBUAT KONEKSI MENGGUNAKAN PDO ---
// PDO (PHP Data Objects) adalah cara yang lebih modern dan aman untuk berinteraksi dengan database.

try {
    // Membuat objek koneksi PDO baru
    $conn = new PDO("mysql:host={$host};dbname={$db_name}", $username, $password);

    // Mengatur mode error PDO ke exception
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Mengatur mode pengambilan data default ke associative array
    $conn->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);

} catch(PDOException $e) {
    // Jika koneksi gagal, hentikan script dan tampilkan pesan error.
    die("Koneksi ke database gagal: " . $e->getMessage());
}

// Jika tidak ada error, variabel $conn sekarang siap digunakan untuk melakukan query ke database.
?>
