<?php
/**
 * transaksi_model.php
 * Model untuk tabel 'transaksi'.
 */

/**
 * Mengambil semua data transaksi dari database, beserta detail user dan motor.
 * @param PDO $conn Koneksi database PDO.
 * @return array Array berisi semua transaksi.
 */
function getAllTransactions(PDO $conn): array
{
    // Menggunakan alias dan nama kolom yang sesuai (t.id_user, t.id_motor, m.id_motor)
    // Pastikan nama kolom di tabel 'transaksi' adalah 'id_transaksi' dan 'status_transaksi'
    $sql = "SELECT 
                t.id_transaksi,
                t.id_user,
                u.username,
                t.id_motor,
                m.merk,
                m.model,
                t.tanggal_sewa,
                t.tanggal_kembali,
                t.total_harga,
                t.status_transaksi
            FROM 
                transaksi t
            JOIN 
                users u ON t.id_user = u.id_user -- Asumsi kolom ID user di tabel users adalah 'id_user'
            JOIN 
                motor m ON t.id_motor = m.id_motor -- Asumsi nama tabel motor adalah 'motor' dan ID-nya 'id_motor'
            ORDER BY 
                t.tanggal_sewa DESC"; // Urutkan dari yang terbaru

    $stmt = $conn->query($sql);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

// fungsi createTransaction dan getTransactionsByUserId tetap sama...
function createTransaction(PDO $conn, array $data): bool
{
    try {
        // Status awal adalah 'menunggu_konfirmasi'
        $sql = "INSERT INTO transaksi (id_user, id_motor, tanggal_sewa, tanggal_kembali, total_harga, status_transaksi) VALUES (:id_user, :id_motor, :tanggal_sewa, :tanggal_kembali, :total_harga, 'menunggu_konfirmasi')";
        $stmt = $conn->prepare($sql);
        $stmt->execute([
            ':id_user' => $data['id_user'],
            ':id_motor' => $data['id_motor'],
            ':tanggal_sewa' => $data['tanggal_sewa'],
            ':tanggal_kembali' => $data['tanggal_kembali'],
            ':total_harga' => $data['total_harga']
        ]);
        return true;
    } catch (PDOException $e) {
        error_log($e->getMessage());
        return false;
    }
}

function getTransactionsByUserId(PDO $conn, int $id_user): array
{
    // Menggunakan alias dan nama kolom yang sesuai (t.id_user, t.id_motor, m.id_motor)
    $sql = "SELECT t.*, m.merk, m.model, m.gambar 
            FROM transaksi t
            JOIN motor m ON t.id_motor = m.id_motor
            WHERE t.id_user = :id_user
            ORDER BY t.tanggal_sewa DESC";
    $stmt = $conn->prepare($sql);
    $stmt->execute([':id_user' => $id_user]);
    return $stmt->fetchAll();
}

function updateTransactionStatus(PDO $conn, int $id_transaksi, string $new_status): bool
{
    $sql = "UPDATE transaksi SET status_transaksi = :new_status WHERE id_transaksi = :id_transaksi";
    
    try {
        $stmt = $conn->prepare($sql);
        $stmt->execute([
            ':new_status' => $new_status,
            ':id_transaksi' => $id_transaksi
        ]);
        // rowCount() > 0 memastikan bahwa ada baris yang benar-benar diubah.
        return $stmt->rowCount() > 0;
    } catch (PDOException $e) {
        error_log("Error in updateTransactionStatus (PDO): " . $e->getMessage());
        return false;
    }
}



/**
 * Fungsi untuk mengambil semua detail dari satu transaksi.
 *
 * @param PDO $conn Objek koneksi database.
 * @param int $id_transaksi ID Transaksi.
 * @return array|false Detail transaksi jika ditemukan.
 */
function getTransactionDetailsById(PDO $conn, int $id_transaksi)
{
    $sql = "SELECT 
                t.*, 
                u.nama_lengkap, u.email, 
                m.merk, m.model, m.tahun, m.harga_perHari
            FROM transaksi t
            JOIN users u ON t.id_user = u.id_user
            JOIN motor m ON t.id_motor = m.id_motor
            WHERE t.id_transaksi = :id_transaksi";
    $stmt = $conn->prepare($sql);
    $stmt->execute([':id_transaksi' => $id_transaksi]);
    return $stmt->fetch();
}

/**
 * Menghitung jumlah pesanan yang perlu dikonfirmasi.
 * @return int Jumlah pesanan.
 */
function countPendingTransactions(PDO $conn): int
{
    $sql = "SELECT COUNT(id_transaksi) FROM transaksi WHERE status_transaksi = 'menunggu_konfirmasi'";
    return (int) $conn->query($sql)->fetchColumn();
}

/**
 * Menghitung jumlah motor yang harus kembali hari ini.
 * @return int Jumlah motor.
 */
function countDueTodayTransactions(PDO $conn): int
{
    $today = date('Y-m-d');
    $sql = "SELECT COUNT(id_transaksi) FROM transaksi WHERE tanggal_kembali = :today AND status_transaksi = 'sedang_berjalan'";
    $stmt = $conn->prepare($sql);
    $stmt->execute([':today' => $today]);
    return (int) $stmt->fetchColumn();
}

/**
 * Menghitung jumlah motor yang sedang disewa.
 * @return int Jumlah motor.
 */
function countActiveRentals(PDO $conn): int
{
    $sql = "SELECT COUNT(id_transaksi) FROM transaksi WHERE status_transaksi = 'sedang_berjalan'";
    return (int) $conn->query($sql)->fetchColumn();
}

/**
 * Menghitung total pendapatan bulan ini.
 * @return float Total pendapatan.
 */
function getMonthlyRevenue(PDO $conn): float
{
    $first_day_of_month = date('Y-m-01');
    $last_day_of_month = date('Y-m-t');
    $sql = "SELECT SUM(total_harga) FROM transaksi WHERE status_transaksi = 'selesai' AND tanggal_kembali BETWEEN :start_date AND :end_date";
    $stmt = $conn->prepare($sql);
    $stmt->execute([
        ':start_date' => $first_day_of_month,
        ':end_date' => $last_day_of_month
    ]);
    return (float) $stmt->fetchColumn();
}
?>
