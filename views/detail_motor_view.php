<?php include 'partials/header.php'; // Memuat header ?>

<main>
    <div class="container page-content">
        <div class="detail-container">
            
            <!-- Kolom Kiri: Gambar Motor -->
            <div class="detail-image-column">
                <img src="/RentForYou/assets/uploads/<?php echo htmlspecialchars($motor['gambar']); ?>" class="main-detail-image">
            </div>

            <!-- Kolom Kanan: Info & Form Booking -->
            <div class="detail-info-column">
                <h1 class="detail-title"><?php echo htmlspecialchars($motor['merk'] . ' ' . $motor['model']); ?></h1>
                <!-- ... (detail lainnya) ... -->

                <hr class="detail-divider">

                <!-- Form Booking -->
                <form action="booking_controller.php" method="POST" class="booking-form">
                    <h3 class="booking-title">Pesan Sekarang</h3>
                    
                    <input type="hidden" name="id_motor" value="<?php echo $motor['id_motor']; ?>">

                    <div class="date-inputs">
                        <div class="form-group">
                            <label for="tanggal_sewa">Tanggal Sewa</label>
                            <input type="date" id="tanggal_sewa" name="tanggal_sewa" required>
                        </div>
                        <div class="form-group">
                            <label for="tanggal_kembali">Tanggal Kembali</label>
                            <input type="date" id="tanggal_kembali" name="tanggal_kembali" required>
                        </div>
                    </div>
                    
                    <!-- Tombol ini sekarang punya name="lanjut_pesan" -->
                    <button type="submit" name="lanjut_pesan" class="btn btn-pesan-besar">Lanjut ke Pemesanan</button>
                </form>
            </div>

        </div>
    </div>
</main>

<?php include 'partials/footer.php'; // Memuat footer ?>
