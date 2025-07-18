<?php

/**
 * Mengambil data motor berdasarkan merk dan model.
 * @param mysqli $conn Koneksi database.
 * @param string $merk Merk motor.
 * @param string $model Model motor.
 * @return array|false Data motor (id, merk, model, stok) jika ditemukan, false jika tidak.
 */
function getMotorByMerkModel($conn, $merk, $model) {
    $stmt = $conn->prepare("SELECT id, merk, model, stok FROM motors WHERE merk = ? AND model = ?");
    $stmt->bind_param("ss", $merk, $model);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows > 0) {
        return $result->fetch_assoc();
    }
    return false;
}

/**
 * Memperbarui stok motor berdasarkan ID.
 * @param mysqli $conn Koneksi database.
 * @param int $motorId ID motor di database.
 * @param int $newStock Nilai stok yang baru.
 * @return bool True jika berhasil, false jika gagal.
 */
function updateMotorStock($conn, $motorId, $newStock) {
    $stmt = $conn->prepare("UPDATE motors SET stok = ? WHERE id = ?");
    $stmt->bind_param("ii", $newStock, $motorId);
    return $stmt->execute();
}

/**
 * Membuat entri motor baru di database.
 * Catatan: Stok akan otomatis diatur ke 1 di sini sesuai logika bisnis.
 * @param mysqli $conn Koneksi database.
 * @param array $data Data motor (merk, model, tahun, harga_perHari, deskripsi, gambar).
 * @return bool True jika berhasil, false jika gagal.
 */
function createMotor($conn, $data) {
    // Pastikan 'stok' diatur ke 1 untuk entri baru, sesuai permintaan
    $data['stok'] = 1;

    $stmt = $conn->prepare("INSERT INTO motors (merk, model, tahun, harga_perHari, stok, deskripsi, gambar) VALUES (?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param(
        "ssiidsi", // s: string, i: integer, d: double (untuk harga_perHari)
        $data['merk'],
        $data['model'],
        $data['tahun'],
        $data['harga_perHari'],
        $data['stok'],
        $data['deskripsi'],
        $data['gambar']
    );
    return $stmt->execute();
}

/**
 * FUNGSI untuk mengambil motor yang tersedia untuk ditampilkan ke pengguna.
 *
 * @param PDO $conn Objek koneksi database.
 * @return array Daftar motor yang stoknya > 0.
 */
function getAvailableMotors(PDO $conn): array
{
    // Query ini hanya mengambil motor yang stoknya lebih dari 0
    $sql = "SELECT * FROM motor WHERE stok > 0 ORDER BY merk, model";
    $stmt = $conn->query($sql);
    return $stmt->fetchAll();
}

/**
 * FUNGSI untuk mengambil SEMUA motor untuk panel admin.
 *
 * @param PDO $conn Objek koneksi database.
 * @return array Daftar semua motor.
 */
function getAllMotorsForAdmin(PDO $conn): array
{
    // Query ini adalah inti dari solusinya.
    // Ia mengambil semua data motor, lalu menggunakan subquery untuk menghitung
    // berapa banyak unit dari setiap motor yang sedang disewa ('sedang_berjalan').
    // Hasilnya adalah kolom baru bernama 'stok_tersedia'.
    $sql = " SELECT 
                m.id_motor,
                m.gambar,
                m.merk,
                m.model,
                m.tahun,
                m.harga_perHari,
                m.stok AS stok_total,
                (m.stok - (
                    SELECT COUNT(*) 
                    FROM transaksi 
                    WHERE id_motor = m.id_motor 
                    AND status_transaksi IN ('pesanan_disetujui', 'sedang_berjalan')
                )) AS stok_tersedia
            FROM 
                motor m
            ORDER BY 
                m.id_motor DESC
        ";

    try {
        $stmt = $conn->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        // Handle error jika query gagal
        error_log("Error fetching motors for admin: " . $e->getMessage());
        return [];
    }
}

/**
 * Fungsi untuk mengambil data satu motor berdasarkan ID.
 *
 * @param PDO $conn Objek koneksi database.
 * @param int $id_motor ID motor yang dicari.
 * @return array|false Data motor jika ditemukan, false jika tidak.
 */
function getMotorById(PDO $conn, int $id_motor)
{
    // Menggunakan id_motor sesuai dengan nama kolom di database
    $sql = "SELECT * FROM motor WHERE id_motor = :id_motor";
    $stmt = $conn->prepare($sql);
    $stmt->execute([':id_motor' => $id_motor]);
    return $stmt->fetch();
}

/**
 * FUNGSI untuk mengambil motor untuk KATALOG PENGGUNA dengan stok dinamis.
 * Versi ini sudah DIPERBAIKI menggunakan PDO.
 *
 * @param PDO $conn Objek koneksi database PDO.
 * @return array Daftar semua motor dengan stok tersedia.
 */
function getMotorsForCatalog(PDO $conn): array
{
    $sql = " SELECT
                m.id_motor, m.gambar, m.merk, m.model, m.tahun, m.harga_perHari,
                m.stok AS stok_total,
                (m.stok - (
                    SELECT COUNT(*) FROM transaksi
                    WHERE id_motor = m.id_motor 
                    AND status_transaksi IN ('pesanan_disetujui', 'sedang_berjalan')
                )) AS stok_tersedia
            FROM motor m
            ORDER BY m.merk, m.model
    ";

    try {
        $stmt = $conn->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        error_log("PDO Query Error in getMotorsForCatalog: " . $e->getMessage());
        return [];
    }
}

/**
 * Fungsi untuk mengambil motor berdasarkan filter.
 *
 * @param PDO $conn Objek koneksi database.
 * @param array $filters Filter yang diterapkan (misal: ['merk' => 'Honda', 'harga_max' => 100000]).
 * @return array Daftar motor yang sudah difilter.
 */
function getMotorsByFilter(PDO $conn, array $filters): array
{
    $sql = " SELECT
                m.id_motor, m.gambar, m.merk, m.model, m.tahun, m.harga_perHari,
                m.stok AS stok_total,
                (m.stok - (
                    SELECT COUNT(*) FROM transaksi
                    WHERE id_motor = m.id_motor 
                    AND status_transaksi IN ('pesanan_disetujui', 'sedang_berjalan')
                )) AS stok_tersedia
            FROM motor m
    ";
    
    $where_clauses = [];
    $params = [];

    if (!empty($filters['merk'])) {
        $where_clauses[] = "m.merk = :merk";
        $params[':merk'] = $filters['merk'];
    }
    if (!empty($filters['harga'])) {
        $harga_range = explode('-', $filters['harga']);
        if (count($harga_range) === 2) {
            $where_clauses[] = "m.harga_perHari BETWEEN :harga_min AND :harga_max";
            $params[':harga_min'] = $harga_range[0];
            $params[':harga_max'] = $harga_range[1];
        }
    }
    if (!empty($filters['q'])) {
        $where_clauses[] = "(m.model LIKE :q OR m.merk LIKE :q)";
        $params[':q'] = '%' . $filters['q'] . '%';
    }

    if (!empty($where_clauses)) {
        $sql .= " WHERE " . implode(' AND ', $where_clauses);
    }
    
    $sql .= " ORDER BY m.merk, m.model";

    try {
        $stmt = $conn->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        error_log("PDO Query Error in getMotorsByFilter: " . $e->getMessage());
        return [];
    }
}

/**
 * Fungsi untuk mencari motor berdasarkan keyword.
 *
 * @param PDO $conn Objek koneksi database.
 * @param string $keyword Keyword pencarian.
 * @return array Hasil pencarian motor.
 */
function searchMotors(PDO $conn, string $keyword): array
{
    // Menggunakan id_motor sesuai dengan nama kolom di database
    $sql = "SELECT id_motor, merk, model FROM motor WHERE merk LIKE :keyword OR model LIKE :keyword LIMIT 5";
    $stmt = $conn->prepare($sql);
    $stmt->execute([':keyword' => '%' . $keyword . '%']);
    return $stmt->fetchAll();
}

/**
 * Fungsi untuk memperbarui data motor.
 *
 * @param PDO $conn Objek koneksi database.
 * @param int $id_motor ID motor yang akan diupdate.
 * @param array $data Data motor yang baru.
 * @return bool True jika berhasil, false jika gagal.
 */
function updateMotor(PDO $conn, int $id_motor, array $data): bool
{
    try {
        $sql = "UPDATE motor SET 
                    merk = :merk, 
                    model = :model, 
                    tahun = :tahun, 
                    harga_perHari = :harga_perHari, 
                    stok = :stok, 
                    deskripsi = :deskripsi";
        
        // Hanya tambahkan update gambar jika ada gambar baru yang di-upload
        if (!empty($data['gambar'])) {
            $sql .= ", gambar = :gambar";
        }
        
        $sql .= " WHERE id_motor = :id_motor";
        
        $data['id_motor'] = $id_motor; // Tambahkan id_motor ke array data untuk binding
        
        $stmt = $conn->prepare($sql);
        return $stmt->execute($data);

    } catch (PDOException $e) {
        error_log($e->getMessage());
        return false;
    }
}

/**
 * Fungsi untuk menghapus data motor.
 *
 * @param PDO $conn Objek koneksi database.
 * @param int $id_motor ID motor yang akan dihapus.
 * @return bool True jika berhasil, false jika gagal.
 */
function deleteMotor(PDO $conn, int $id_motor): bool
{
    try {
        // TODO: Hapus juga file gambar dari server sebelum menghapus data dari DB
        $sql = "DELETE FROM motor WHERE id_motor = :id_motor";
        $stmt = $conn->prepare($sql);
        return $stmt->execute([':id_motor' => $id_motor]);
    } catch (PDOException $e) {
        // Tangani jika motor tidak bisa dihapus karena terkait dengan transaksi
        error_log($e->getMessage());
        return false;
    }
}

/**
 * Menghitung total stok motor yang tersedia (siap disewa).
 * @return int Jumlah stok.
 */
function countAvailableStock(PDO $conn): int
{
    // Total stok fisik dikurangi motor yang sedang disewa
    $sql_total_stock = "SELECT SUM(stok) FROM motor";
    $total_stock = (int) $conn->query($sql_total_stock)->fetchColumn();

    $sql_rented = "SELECT COUNT(id_transaksi) FROM transaksi WHERE status_transaksi = 'sedang_berjalan'";
    $rented_count = (int) $conn->query($sql_rented)->fetchColumn();

    return $total_stock - $rented_count;
}

/**
 * Menghitung jumlah jenis motor yang stoknya habis.
 * @return int Jumlah jenis motor.
 */
function countOutOfStockMotors(PDO $conn): int
{
    $sql = "SELECT COUNT(id_motor) FROM motor WHERE stok = 0";
    return (int) $conn->query($sql)->fetchColumn();
}

?>
