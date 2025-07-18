<?php include 'partials/header.php'; ?>

<main>
    <div class="container page-content">
        <div class="booking-container">
            <h1 class="booking-page-title"><?php echo $page_title; ?></h1>

            <div class="booking-grid">
                <!-- Kolom Kiri: Form Verifikasi -->
                <div class="form-verification-section">
                    <form action="booking_controller.php" method="POST" enctype="multipart/form-data">
                        
                        <h3>Langkah 1: Lengkapi Data Diri</h3>
                        <p>Data ini hanya perlu diisi sekali saat pemesanan pertama.</p>
                        
                        <div class="form-group">
                            <label for="alamat">Alamat Lengkap (Sesuai KTP)</label>
                            <textarea name="alamat" id="alamat" rows="3" required></textarea>
                        </div>
                        <div class="form-group">
                            <label for="foto_ktp">Upload Foto KTP</label>
                            <input type="file" name="foto_ktp" id="foto_ktp" required>
                        </div>
                        <div class="form-group">
                            <label for="foto_sim">Upload Foto SIM C</label>
                            <input type="file" name="foto_sim" id="foto_sim" required>
                        </div>

                        <hr>

                        <h3>Langkah 2: Persetujuan</h3>
                        <div class="form-group-checkbox">
                            <input type="checkbox" name="setuju_sk" id="setuju_sk" required>
                            <label for="setuju_sk">Saya telah membaca dan menyetujui <a href="#" id="open-sk-modal" class="sk-link">Syarat & Ketentuan</a> yang berlaku.</label>
                        </div>

                        <button type="submit" name="ajukan_sewa" class="btn btn-pesan-besar">Ajukan Sewa</button>
                    </form>
                </div>

                <!-- Kolom Kanan: Ringkasan Pesanan -->
                <div class="order-summary-section">
                    <h3>Ringkasan Pesanan</h3>
                    <div class="summary-card">
                        <img src="/RentForYou/assets/uploads/<?php echo htmlspecialchars($motor['gambar']); ?>" alt="Gambar Motor">
                        <div class="summary-details">
                            <h4><?php echo htmlspecialchars($motor['merk'] . ' ' . $motor['model']); ?></h4>
                            <p><strong>Tanggal Sewa:</strong> <?php echo htmlspecialchars($_SESSION['booking_data']['tanggal_sewa']); ?></p>
                            <p><strong>Tanggal Kembali:</strong> <?php echo htmlspecialchars($_SESSION['booking_data']['tanggal_kembali']); ?></p>
                            <hr>
                            <p class="summary-price"><strong>Total Biaya:</strong> (akan dihitung)</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div id="sk-modal" class="modal">
        <div class="modal-content">
            <span class="modal-close">&times;</span>
            <h2>Syarat & Ketentuan</h2>
            <div class="modal-body">
                <p><strong>1. Jaminan Sewa:</strong> Penyewa wajib menitipkan e-KTP asli yang masih berlaku sebagai jaminan selama masa penyewaan.</p>
                <p><strong>2. Surat Izin Mengemudi:</strong> Penyewa wajib memiliki dan dapat menunjukkan SIM C asli yang masih berlaku.</p>
                <p><strong>3. Batas Waktu Sewa:</strong> Durasi sewa dihitung per 24 jam. Keterlambatan pengembalian akan dikenakan denda sesuai tarif yang berlaku.</p>
                <p><strong>4. Kerusakan & Kehilangan:</strong> Segala bentuk kerusakan atau kehilangan unit motor beserta kelengkapannya (helm, jas hujan) menjadi tanggung jawab penuh penyewa.</p>
                <p><strong>5. Penggunaan:</strong> Motor sewaan tidak diizinkan untuk dipindahtangankan, digadaikan, atau digunakan untuk kegiatan melanggar hukum.</p>
            </div>
        </div>
    </div>
</main>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const modal = document.getElementById('sk-modal');
    const openBtn = document.getElementById('open-sk-modal');
    const closeBtn = document.querySelector('.modal-close');

    // Fungsi untuk membuka pop-up
    if (openBtn) {
        openBtn.onclick = function(e) {
            e.preventDefault(); // Mencegah link berpindah halaman
            modal.style.display = 'block';
        }
    }

    // Fungsi untuk menutup pop-up via tombol 'x'
    if (closeBtn) {
        closeBtn.onclick = function() {
            modal.style.display = 'none';
        }
    }

    // Fungsi untuk menutup pop-up jika mengklik di luar area konten
    window.onclick = function(event) {
        if (event.target == modal) {
            modal.style.display = 'none';
        }
    }
});
</script>

<?php include 'partials/footer.php'; ?>
