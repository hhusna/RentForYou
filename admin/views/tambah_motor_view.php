<?php include 'partials/header_admin.php'; ?>

<div class="form-container-admin">
    <form action="tambah_motor_controller.php" method="POST" enctype="multipart/form-data">
        
        <?php
        // Menampilkan pesan error/sukses jika ada
        if (isset($_SESSION['error_message'])) {
            echo '<div class="message error-message">' . $_SESSION['error_message'] . '</div>';
            unset($_SESSION['error_message']);
        }
        ?>

        <div class="form-group">
            <label for="merk">Merk</label>
            <input type="text" id="merk" name="merk" required>
        </div>
        <div class="form-group">
            <label for="model">Model</label>
            <input type="text" id="model" name="model" required>
        </div>
        <div class="form-group">
            <label for="tahun">Tahun</label>
            <input type="number" id="tahun" name="tahun" required>
        </div>
        <div class="form-group">
            <label for="harga_perHari">Harga / Hari (Rp)</label>
            <input type="number" step="1000" id="harga_perHari" name="harga_perHari" required>
        </div>
        <div class="form-group">
            <label for="gambar">Gambar Motor</label>
            <input type="file" id="gambar" name="gambar" accept="image/*">
        </div>
        <div class="form-group">
            <label for="deskripsi">Deskripsi</label>
            <textarea id="deskripsi" name="deskripsi" rows="4"></textarea>
        </div>

        <button type="submit" class="btn btn-primary">Simpan Motor</button>
    </form>
</div>

<?php include 'partials/footer_admin.php'; ?>
