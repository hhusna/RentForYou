<?php
// Jika file ini dipanggil tanpa melalui controller, mulai session
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrasi Akun - RentForYou</title>
    <!-- Hubungkan ke file CSS utama Anda -->
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body class="form-page">
    <div class="form-container">
        <form action="../controller/registrasi_controller.php" method="POST" class="form-card">
            <h2>Registrasi Akun RentForYou</h2>

            <?php
            // Menampilkan pesan error jika ada
            if (isset($_SESSION['error_message'])) {
                echo '<div class="message error-message">' . $_SESSION['error_message'] . '</div>';
                // Hapus pesan setelah ditampilkan agar tidak muncul lagi
                unset($_SESSION['error_message']);
            }
            ?>

            <div class="form-row">
                <!-- Kolom Kiri -->
                <div class="form-column">
                    <div class="form-group">
                        <label for="nama_lengkap">Nama Lengkap</label>
                        <input type="text" id="nama_lengkap" name="nama_lengkap" required>
                    </div>
                    <div class="form-group">
                        <label for="username">Username</label>
                        <input type="text" id="username" name="username" required>
                    </div>
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" id="email" name="email" required>
                    </div>
                </div>

                <!-- Kolom Kanan -->
                <div class="form-column">
                    <div class="form-group">
                        <label for="no_hp">Nomor Handphone</label>
                        <input type="tel" id="no_hp" name="no_hp" required>
                    </div>
                    <div class="form-group">
                        <label for="password">Password</label>
                        <input type="password" id="password" name="password" required>
                    </div>
                    <div class="form-group">
                        <label for="konfirmasi_password">Konfirmasi Password</label>
                        <input type="password" id="konfirmasi_password" name="konfirmasi_password" required>
                    </div>
                </div>
            </div>

            <button type="submit" class="btn-submit">Buat Akun</button>
            <p class="form-footer">Sudah punya akun? <a href="login_controller.php">Login di sini</a></p>
        </form>
    </div>
</body>
</html>
