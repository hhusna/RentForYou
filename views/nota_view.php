<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $page_title; ?></title>
    <link rel="stylesheet" href="../assets/css/nota_style.css">
</head>
<body>
    <div class="nota-container">
        <div class="nota-header">
            <h1>NOTA PEMESANAN</h1>
            <p class="company-name">RentForYou</p>
        </div>

        <div class="nota-info">
            <div class="info-left">
                <strong>No. Nota:</strong> #<?php echo htmlspecialchars($transaction['id_transaksi']); ?><br>
                <strong>Tanggal Terbit:</strong> <?php echo date('d M Y'); ?>
            </div>
            <div class="info-right">
                <strong>Kepada Yth:</strong><br>
                <?php echo htmlspecialchars($transaction['nama_lengkap']); ?><br>
                <?php echo htmlspecialchars($transaction['email']); ?>
            </div>
        </div>

        <table class="nota-table">
            <thead>
                <tr>
                    <th>Deskripsi</th>
                    <th>Durasi</th>
                    <th>Harga/Hari</th>
                    <th>Subtotal</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>
                        <strong><?php echo htmlspecialchars($transaction['merk'] . ' ' . $transaction['model']); ?></strong><br>
                        <small>Tahun <?php echo htmlspecialchars($transaction['tahun']); ?></small>
                    </td>
                    <td>
                        <?php
                            $tgl1 = new DateTime($transaction['tanggal_sewa']);
                            $tgl2 = new DateTime($transaction['tanggal_kembali']);
                            $durasi = $tgl2->diff($tgl1)->days + 1;
                            echo $durasi . ' hari';
                        ?>
                    </td>
                    <td>Rp <?php echo number_format($transaction['harga_perHari'], 0, ',', '.'); ?></td>
                    <td>Rp <?php echo number_format($transaction['total_harga'], 0, ',', '.'); ?></td>
                </tr>
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="3" class="total-label">TOTAL</td>
                    <td class="total-amount">Rp <?php echo number_format($transaction['total_harga'], 0, ',', '.'); ?></td>
                </tr>
            </tfoot>
        </table>

        <div class="nota-footer">
            <p>Terima kasih telah menyewa di RentForYou. Harap simpan nota ini sebagai bukti pembayaran.</p>
            <strong>Status: <?php echo ucfirst(str_replace('_', ' ', $transaction['status_transaksi'])); ?></strong>
        </div>

        <div class="nota-actions">
            <a href="pesanan_controller.php">Kembali ke Pesanan</a>
            <button onclick="window.print()">Cetak Nota</button>
        </div>
    </div>
</body>
</html>
