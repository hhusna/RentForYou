<?php include 'partials/header_admin.php'; ?>

<div class="form-container-admin">
    <form action="edit_motor_controller.php?id=<?php echo $motor['id_motor']; ?>" method="POST" enctype="multipart/form-data">
        
        <?php
        if (isset($_SESSION['error_message'])) {
            echo '<div class="message error-message">' . $_SESSION['error_message'] . '</div>';
            unset($_SESSION['error_message']);
        }
        ?>

        <div class="form-group">
            <label for="merk">Merk</label>
            <input type="text" id="merk" name="merk" value="<?php echo htmlspecialchars($motor['merk']); ?>" required>
        </div>
        <div class="form-group">
            <label for="model">Model</label>
            <input type="text" id="model" name="model" value="<?php echo htmlspecialchars($motor['model']); ?>" required>
        </div>
        <div class="form-group">
            <label for="tahun">Tahun</label>
            <input type="number" id="tahun" name="tahun" value="<?php echo htmlspecialchars($motor['tahun']); ?>" required>
        </div>
        <div class="form-group">
            <label for="harga_perHari">Harga / Hari (Rp)</label>
            <input type="number" step="1000" id="harga_perHari" name="harga_perHari" value="<?php echo htmlspecialchars($motor['harga_perHari']); ?>" required>
        </div>
        <div class="form-group">
            <label for="stok">Stok</label>
            <input type="number" id="stok" name="stok" value="<?php echo htmlspecialchars($motor['stok']); ?>" required>
        </div>
        <div class="form-group">
            <label for="gambar">Gambar</label>
            <div class="custom-file-upload">
                <input type="file" id="gambar" name="gambar" accept="image/*" onchange="updateFileName(this)">
                <label for="gambar" class="file-upload-label">Browse...</label>
                <span id="file-name-display">
                    <?php echo !empty($motor['gambar']) ? htmlspecialchars($motor['gambar']) : 'No file selected.'; ?>
                </span>
            </div>
            <?php if (!empty($motor['gambar'])): ?>
                <img src="/RentForYou/assets/uploads/motor/<?php echo htmlspecialchars($motor['gambar']); ?>" alt="Gambar Saat Ini" style="max-width: 150px; margin-top: 10px; border-radius: 8px;">
            <?php endif; ?>
        </div>
        <div class="form-group">
            <label for="deskripsi">Deskripsi</label>
            <textarea id="deskripsi" name="deskripsi" rows="4"><?php echo htmlspecialchars($motor['deskripsi']); ?></textarea>
        </div>

        <button type="submit" class="btn btn-primary">Update Motor</button>
        <a href="kelola_motor_controller.php" class="btn" style="background-color: #6c757d;">Batal</a>
    </form>
</div>

<script>
function updateFileName(input) {
    const fileNameDisplay = document.getElementById('file-name-display');
    if (input.files.length > 0) {
        fileNameDisplay.textContent = input.files[0].name;
    }
}
</script>

<?php include 'partials/footer_admin.php'; ?>
