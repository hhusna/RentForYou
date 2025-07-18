<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - RentForYou</title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body class="form-page">
    <div class="form-container" style="max-width: 480px;">
        <form id="login-form" action="../controller/login_controller.php" method="POST" class="form-card">
            <h2>Selamat Datang RentFriends!</h2>

            <?php
            // Menampilkan pesan error jika ada
            if (isset($_SESSION['error_message'])) {
                echo '<div class="message error-message">' . $_SESSION['error_message'] . '</div>';
                unset($_SESSION['error_message']);
            }
            // Menampilkan pesan sukses dari registrasi jika ada
            if (isset($_SESSION['success_message'])) {
                echo '<div class="message success-message">' . $_SESSION['success_message'] . '</div>';
                unset($_SESSION['success_message']);
            }
            ?>

            <div class="form-group">
                <label for="username">Username</label>
                <input type="text" id="username" name="username" required>
            </div>

            <div class="form-group">
                <div class="label-container">
                    <label for="password">Password</label>
                    <a href="#" class="forgot-password">Lupa password?</a>
                </div>
                <input type="password" id="password" name="password" required>
            </div>
            
            <!-- Hidden input untuk menyimpan role -->
            <input type="hidden" id="role" name="role" value="">

            <!-- Tombol Login -->
            <div class="login-buttons">
                <button type="button" class="btn-login" data-role="admin">Login as Admin</button>
                <button type="button" class="btn-login" data-role="pengguna">Login as User</button>
            </div>

            <p class="form-footer">Belum punya akun? <a href="registrasi_controller.php">Registrasi di sini</a></p>
        </form>
    </div>

    <script>
        // Script untuk menangani klik tombol login
        document.querySelectorAll('.btn-login').forEach(button => {
            button.addEventListener('click', function() {
                // Set nilai role di hidden input
                document.getElementById('role').value = this.dataset.role;
                // Submit form
                document.getElementById('login-form').submit();
            });
        });
    </script>

</body>
</html>
