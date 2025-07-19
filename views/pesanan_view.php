<?php include 'partials/header.php'; ?>
    
<main>
    <div class="container page-content">
        <h1 class="page-main-title">Riwayat Pesanan Saya</h1>

        <?php
        if (isset($_SESSION['success_message'])) {
            echo '<div class="message success-message">' . htmlspecialchars($_SESSION['success_message']) . '</div>';
            unset($_SESSION['success_message']);
        }
        ?>

        <div class="transaction-list">
            <?php if (empty($transactions)): ?>
                <div class="card-empty">
                    <p>Anda belum memiliki riwayat pesanan.</p>
                    <a href="beranda_controller.php#katalog" class="btn btn-primary">Mulai Sewa Sekarang</a>
                </div>
            <?php else: ?>
                <?php foreach ($transactions as $trx): ?>
                    <div class="transaction-card">
                        <div class="trx-image">
                            <img src="../assets/uploads/<?php echo htmlspecialchars($trx['gambar']); ?>" alt="Gambar <?php echo htmlspecialchars($trx['model']); ?>">
                        </div>
                        <div class="trx-details">
                            <h3 class="trx-motor-title"><?php echo htmlspecialchars($trx['merk'] . ' ' . $trx['model']); ?></h3>
                            <p class="trx-dates">
                                <strong>Sewa:</strong> <?php echo date('d M Y', strtotime($trx['tanggal_sewa'])); ?> | 
                                <strong>Kembali:</strong> <?php echo date('d M Y', strtotime($trx['tanggal_kembali'])); ?>
                            </p>
                            <p class="trx-price"><strong>Total Harga:</strong> Rp <?php echo number_format($trx['total_harga'], 0, ',', '.'); ?></p>
                        </div>
                        <div class="trx-status">
                            <?php
                                $raw_status = htmlspecialchars($trx['status_transaksi']);
                                $status_for_class = str_replace(' ', '-', $raw_status);
                                $status_for_class = str_replace('_', '-', $status_for_class);
                                $status_class = 'status-' . $status_for_class;
                                $status_for_text = str_replace('_', ' ', $raw_status);
                                $status_text = ucfirst($status_for_text);
                            ?>
                            <span class="status-badge <?php echo $status_class; ?>">
                                <?php echo $status_text; ?>
                            </span>
                            <a href="nota_controller.php?id=<?php echo $trx['id_transaksi']; ?>" class="btn-nota">Lihat Nota</a>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </div>
</main>
    
<?php include 'partials/footer.php'; ?>
