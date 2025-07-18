<?php include 'partials/header_admin.php'; ?>

<div class="dashboard-grid">
    
    <div class="stat-card transaksi">
        <div class="stat-card-info">
            <h3>Pesanan Baru</h3>
            <p class="stat-number"><?php echo $pesanan_baru; ?></p>
        </div>
        <div class="stat-card-icon">
            <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" fill="currentColor" viewBox="0 0 16 16"><path d="M8 16a.5.5 0 0 1-.5-.5V3h-1.5a.5.5 0 0 1 0-1H11a.5.5 0 0 1 0 1H9.5v12.5a.5.5 0 0 1-1 0zM3.5 2a.5.5 0 0 0-.5.5v12a.5.5 0 0 0 1 0v-12a.5.5 0 0 0-.5-.5z"/></svg>
        </div>
    </div>

    <div class="stat-card sewa">
        <div class="stat-card-info">
            <h3>Kembali Hari Ini</h3>
            <p class="stat-number"><?php echo $kembali_hari_ini; ?></p>
        </div>
        <div class="stat-card-icon">
            <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" fill="currentColor" viewBox="0 0 16 16"><path fill-rule="evenodd" d="M1 11.5a.5.5 0 0 0 .5.5h11.793l-3.147 3.146a.5.5 0 0 0 .708.708l4-4a.5.5 0 0 0 0-.708l-4-4a.5.5 0 0 0-.708.708L13.293 11H1.5a.5.5 0 0 0-.5.5zm14-7a.5.5 0 0 1-.5.5H2.707l3.147 3.146a.5.5 0 1 1-.708.708l-4-4a.5.5 0 0 1 0-.708l4-4a.5.5 0 1 1 .708.708L2.707 4H14.5a.5.5 0 0 1 .5.5z"/></svg>
        </div>
    </div>

    <div class="stat-card motor">
        <div class="stat-card-info">
            <h3>Motor Disewa</h3>
            <p class="stat-number"><?php echo $motor_disewa; ?></p>
        </div>
        <div class="stat-card-icon">
            <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" fill="currentColor" viewBox="0 0 16 16"><path d="M3.61 3.213A.5.5 0 0 1 4.141 3H11.a.5.5 0 0 1 0 .598l-3 5A.5.5 0 0 1 8 9H5a.5.5 0 0 1-.424-.765L1.58 3.213zM4.96 7.5H8.44l1.762-3H6.722L4.96 7.5z"/><path d="M14 14a1 1 0 1 1-2 0 1 1 0 0 1 2 0zM1.5 14a1 1 0 1 1-2 0 1 1 0 0 1 2 0z"/><path d="M6 13.5a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0zm5.5-1.5a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0z"/></svg>
        </div>
    </div>

    <div class="stat-card customer">
        <div class="stat-card-info">
            <h3>Stok Tersedia</h3>
            <p class="stat-number"><?php echo $stok_tersedia; ?></p>
        </div>
        <div class="stat-card-icon">
            <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" fill="currentColor" viewBox="0 0 16 16"><path d="M8 1a2.5 2.5 0 0 1 2.5 2.5V4h-5v-.5A2.5 2.5 0 0 1 8 1zm3.5 3v-.5a3.5 3.5 0 1 0-7 0V4H1v10a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2V4h-3.5zM2 5h12v9a1 1 0 0 1-1 1H3a1 1 0 0 1-1-1V5z"/></svg>
        </div>
    </div>

    <div class="stat-card" style="border-left-color: #ef4444;"> <div class="stat-card-info">
            <h3>Stok Habis</h3>
            <p class="stat-number"><?php echo $stok_habis; ?></p>
        </div>
        <div class="stat-card-icon">
            <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" fill="currentColor" viewBox="0 0 16 16"><path d="M12.5 1a.5.5 0 0 1 0 1h-11a.5.5 0 0 1 0-1h11zm-11 2a.5.5 0 0 1 0 1h11a.5.5 0 0 1 0-1h-11zm11 2a.5.5 0 0 1 0 1h-11a.5.5 0 0 1 0-1h11zm-11 2a.5.5 0 0 1 0 1h11a.5.5 0 0 1 0-1h-11zm11 2a.5.5 0 0 1 0 1h-11a.5.5 0 0 1 0-1h11z"/></svg>
        </div>
    </div>

    <div class="stat-card pendapatan">
        <div class="stat-card-info">
            <h3>Pendapatan Bulan Ini</h3>
            <p class="stat-number">Rp <?php echo number_format($pendapatan_bulan_ini, 0, ',', '.'); ?></p>
        </div>
        <div class="stat-card-icon">
            <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" fill="currentColor" viewBox="0 0 16 16"><path d="M8 16a.5.5 0 0 1-.5-.5v-1a.5.5 0 0 1 1 0v1a.5.5 0 0 1-.5.5zM6 14.5a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-1 0v-1a.5.5 0 0 1 .5-.5zm4 0a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-1 0v-1a.5.5 0 0 1 .5-.5z"/><path d="M8 13a3 3 0 1 1 0-6 3 3 0 0 1 0 6zm0-1a2 2 0 1 0 0-4 2 2 0 0 0 0 4z"/><path d="M4 2.5a.5.5 0 0 1 .5-.5h7a.5.5 0 0 1 0 1h-7a.5.5 0 0 1-.5-.5zM3 3.5a.5.5 0 0 1 .5-.5h9a.5.5 0 0 1 0 1h-9a.5.5 0 0 1-.5-.5zM1 4.5a.5.5 0 0 1 .5-.5h13a.5.5 0 0 1 0 1h-13a.5.5 0 0 1-.5-.5z"/></svg>
        </div>
    </div>

</div>

<?php include 'partials/footer_admin.php'; ?>
