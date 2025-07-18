<?php
/**
 * user_model.php
 * Model ini bertanggung jawab untuk semua operasi database
 * yang terkait dengan tabel 'users' dan 'verifikasi_identitas'.
 */

/**
 * Fungsi untuk membuat user baru (registrasi).
 *
 * @param PDO $conn Objek koneksi database.
 * @param array $data Data user yang berisi 'username', 'password' (sudah di-hash), 'email', 'nama_lengkap', 'no_hp'.
 * @return string|false ID user baru jika berhasil, false jika gagal.
 */
function createUser(PDO $conn, array $data)
{
    try {
        $sql = "INSERT INTO users (username, password, email, nama_lengkap, no_hp) VALUES (:username, :password, :email, :nama_lengkap, :no_hp)";
        $stmt = $conn->prepare($sql);
        $stmt->execute([
            ':username' => $data['username'],
            ':password' => $data['password'],
            ':email' => $data['email'],
            ':nama_lengkap' => $data['nama_lengkap'],
            ':no_hp' => $data['no_hp']
        ]);
        // Mengembalikan ID dari user yang baru saja dibuat
        return $conn->lastInsertId();
    } catch (PDOException $e) {
        error_log($e->getMessage());
        return false;
    }
}

/**
 * Fungsi untuk mengambil data user berdasarkan username.
 *
 * @param PDO $conn Objek koneksi database.
 * @param string $username Username yang dicari.
 * @return array|false Data user jika ditemukan, false jika tidak.
 */
function getUserByUsername(PDO $conn, string $username)
{
    $sql = "SELECT * FROM users WHERE username = :username";
    $stmt = $conn->prepare($sql);
    $stmt->execute([':username' => $username]);
    return $stmt->fetch();
}

/**
 * Fungsi untuk mengambil data user berdasarkan ID.
 *
 * @param PDO $conn Objek koneksi database.
 * @param int $id_user ID user yang dicari.
 * @return array|false Data user jika ditemukan, false jika tidak.
 */
function getUserById(PDO $conn, int $id_user)
{
    // Menggunakan id_user sesuai dengan nama kolom di database
    $sql = "SELECT * FROM users WHERE id_user = :id_user";
    $stmt = $conn->prepare($sql);
    $stmt->execute([':id_user' => $id_user]);
    return $stmt->fetch();
}

/**
 * Fungsi untuk membuat atau memperbarui data verifikasi pengguna.
 *
 * @param PDO $conn Objek koneksi database.
 * @param array $data Berisi id_user, alamat, foto_ktp, foto_sim.
 * @return bool True jika berhasil, false jika gagal.
 */
function updateVerificationData(PDO $conn, array $data): bool
{
    try {
        $sql = "UPDATE verifikasi_identitas 
                SET alamat = :alamat, foto_ktp = :foto_ktp, foto_sim = :foto_sim, status_verifikasi = 'pending'
                WHERE id_user = :id_user";
        $stmt = $conn->prepare($sql);
        return $stmt->execute([
            ':alamat' => $data['alamat'],
            ':foto_ktp' => $data['foto_ktp'],
            ':foto_sim' => $data['foto_sim'],
            ':id_user' => $data['id_user']
        ]);
    } catch (PDOException $e) {
        error_log($e->getMessage());
        return false;
    }
}

/**
 * Fungsi untuk membuat profil verifikasi baru untuk pengguna.
 *
 * @param PDO $conn Objek koneksi database.
 * @param int $id_user ID pengguna yang akan dibuatkan profil.
 * @return bool True jika berhasil, false jika gagal.
 */
function createVerificationProfile(PDO $conn, int $id_user): bool
{
    try {
        // Menggunakan id_user sesuai dengan nama kolom di database
        $sql = "INSERT INTO verifikasi_identitas (id_user, status_verifikasi) VALUES (:id_user, 'belum_diverifikasi')";
        $stmt = $conn->prepare($sql);
        $stmt->execute([':id_user' => $id_user]);
        return true;
    } catch (PDOException $e) {
        error_log($e->getMessage());
        return false;
    }
}

/**
 * Fungsi untuk mengambil data verifikasi berdasarkan ID user.
 *
 * @param PDO $conn Objek koneksi database.
 * @param int $id_user ID user.
 * @return array|false Data verifikasi jika ditemukan.
 */
function getVerificationDataByUserId(PDO $conn, int $id_user)
{
    $sql = "SELECT * FROM verifikasi_identitas WHERE id_user = :id_user";
    $stmt = $conn->prepare($sql);
    $stmt->execute([':id_user' => $id_user]);
    return $stmt->fetch();
}

?>
