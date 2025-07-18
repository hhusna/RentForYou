<?php include 'partials/header_admin.php'; ?>

<div class="table-container">
    <div class="table-header">
        <h3>Daftar Semua Transaksi</h3>
    </div>

    <?php
    // Menampilkan pesan error/sukses jika ada
    if (isset($_SESSION['error_message'])) {
        echo '<div class="message error-message">' . $_SESSION['error_message'] . '</div>';
        unset($_SESSION['error_message']);
    }
    if (isset($_SESSION['success_message'])) {
        echo '<div class="message success-message">' . $_SESSION['success_message'] . '</div>';
        unset($_SESSION['success_message']);
    }
    ?>

    <?php if (empty($transactions)): ?>
        <p class="text-center">Belum ada transaksi.</p>
    <?php else: ?>
        <table>
            <thead>
                <tr>
                    <th>ID Transaksi</th>
                    <th>User</th>
                    <th>Motor</th>
                    <th>Tanggal Sewa</th>
                    <th>Tanggal Kembali</th>
                    <th>Total Harga</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($transactions)): ?>
                    <tr>
                        <td colspan="8" style="text-align: center;">Belum ada data transaksi.</td>
                    </tr>
                <?php else: ?>
                    <?php foreach ($transactions as $trx): ?>
                        <tr>
                            <td>#<?php echo $trx['id_transaksi']; ?></td>
                            <td><?php echo htmlspecialchars($trx['username']); ?></td>
                            <td><?php echo htmlspecialchars($trx['merk'] . ' ' . $trx['model']); ?></td>
                            <td><?php echo date('d M Y', strtotime($trx['tanggal_sewa'])); ?></td>
                            <td><?php echo date('d M Y', strtotime($trx['tanggal_kembali'])); ?></td>
                            <td>Rp <?php echo number_format($trx['total_harga'], 0, ',', '.'); ?></td>
                            <td>
                                <span class="status-badge status-<?php echo str_replace('_', '-', $trx['status_transaksi']); ?>">
                                    <?php echo ucfirst(str_replace('_', ' ', $trx['status_transaksi'])); ?>
                                </span>
                            </td>
                            <td class="action-buttons">
                                <?php if ($trx['status_transaksi'] == 'menunggu_konfirmasi'): ?>
                                    <form action="kelola_transaksi_controller.php" method="POST">
                                        <input type="hidden" name="id_transaksi" value="<?php echo $trx['id_transaksi']; ?>">
                                        <input type="hidden" name="action" value="setujui">
                                        <button type="submit" class="btn btn-setujui">Setujui</button>
                                    </form>
                                    <form action="kelola_transaksi_controller.php" method="POST">
                                        <input type="hidden" name="id_transaksi" value="<?php echo $trx['id_transaksi']; ?>">
                                        <input type="hidden" name="action" value="tolak">
                                        <button type="submit" class="btn btn-delete">Tolak</button>
                                    </form>
                                <?php elseif ($trx['status_transaksi'] == 'pesanan_disetujui'): ?>
                                    <form action="kelola_transaksi_controller.php" method="POST">
                                        <input type="hidden" name="id_transaksi" value="<?php echo $trx['id_transaksi']; ?>">
                                        <input type="hidden" name="action" value="mulai_sewa">
                                        <button type="submit" class="btn btn-edit">Mulai Sewa</button>
                                    </form>
                                <?php elseif ($trx['status_transaksi'] == 'sedang_berjalan'): ?>
                                    <form action="kelola_transaksi_controller.php" method="POST">
                                        <input type="hidden" name="id_transaksi" value="<?php echo $trx['id_transaksi']; ?>">
                                        <input type="hidden" name="action" value="selesai">
                                        <button type="submit" class="btn btn-primary">Selesaikan</button>
                                    </form>
                                <?php else: ?>
                                    <span>-</span>
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    <?php endif; ?>
</div>

<?php include 'partials/footer_admin.php'; ?>