<?php include 'partials/header_admin.php'; ?>

<div class="table-container">
    <div class="table-header">
        <h3>Daftar Semua Motor</h3>
        <a href="tambah_motor_controller.php" class="btn btn-primary">Tambah Motor Baru</a>
    </div>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Gambar</th>
                <th>Merk</th>
                <th>Model</th>
                <th>Tahun</th>
                <th>Harga/Hari</th>
                <th>Stok (Tersedia/Total)</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php if (empty($motors)): ?>
                <tr>
                    <td colspan="8">Belum ada data motor.</td>
                </tr>
            <?php else: ?>
                <?php foreach ($motors as $motor): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($motor['id_motor']); ?></td>
                        <td>
                            <?php if (!empty($motor['gambar'])): ?>
                                <img src="../assets/uploads/<?php echo htmlspecialchars($motor['gambar']); ?>" alt="Gambar Motor" width="80" style="border-radius: 6px;">
                            <?php else: ?>
                                <span>-</span>
                            <?php endif; ?>
                        </td>
                        <td><?php echo htmlspecialchars($motor['merk']); ?></td>
                        <td><?php echo htmlspecialchars($motor['model']); ?></td>
                        <td><?php echo htmlspecialchars($motor['tahun']); ?></td>
                        <td>Rp <?php echo number_format($motor['harga_perHari'], 0, ',', '.'); ?></td>
                        <td>                           
                            <strong><?php echo htmlspecialchars($motor['stok_tersedia']); ?></strong> / <?php echo htmlspecialchars($motor['stok_total']); ?>
                        </td>
                        <td class="action-buttons">
                            <a href="edit_motor_controller.php?id=<?php echo $motor['id_motor']; ?>" class="btn btn-edit">Edit</a>
                            <a href="hapus_motor_controller.php?id=<?php echo $motor['id_motor']; ?>" class="btn btn-delete" onclick="return confirm('Apakah Anda yakin ingin menghapus motor ini?');">Hapus</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<?php include 'partials/footer_admin.php'; ?>
