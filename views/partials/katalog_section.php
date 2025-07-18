<section id="katalog" class="filter-search-section" style="padding-top: 40px;">
    
    <!-- Bagian Search Bar -->
    <div class="search-filter-form">
        <div class="search-filter-container">
            <div class="search-bar">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="search-icon" viewBox="0 0 16 16">
                    <path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001c.03.04.062.078.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1.007 1.007 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0z"/>
                </svg>
                <!-- Input pencarian sekarang memiliki ID untuk JavaScript -->
                <input type="search" id="live-search-input" placeholder="Ketik untuk mencari motor...">
            </div>
            <!-- Tombol filter tetap ada -->
            <button type="button" id="toggle-filter-btn" class="filter-button">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" viewBox="0 0 16 16">
                    <path d="M6 10.5a.5.5 0 0 1 .5-.5h3a.5.5 0 0 1 0 1h-3a.5.5 0 0 1-.5-.5zm-2-3a.5.5 0 0 1 .5-.5h7a.5.5 0 0 1 0 1h-7a.5.5 0 0 1-.5-.5zm-2-3a.5.5 0 0 1 .5-.5h11a.5.5 0 0 1 0 1h-11a.5.5 0 0 1-.5-.5z"/>
                </svg>
                <span>Filter</span>
            </button>
        </div>

        <!-- Panel Filter yang tersembunyi -->
        <div id="filter-panel" class="filter-panel" style="display: none;">
            <div class="filter-panel-content">
                <div class="filter-group">
                    <label for="filter-harga">Harga</label>
                    <select name="harga" id="filter-harga">
                        <option value="">Semua Harga</option>
                        <option value="0-75000"> &lt; Rp 75.000</option>
                        <option value="75001-150000">Rp 75rb - Rp 150rb</option>
                        <option value="150001-9999999"> &gt; Rp 150.000</option>
                    </select>
                </div>
                <div class="filter-group">
                    <label for="filter-merk">Merk Motor</label>
                    <select name="merk" id="filter-merk">
                        <option value="">Semua Merk</option>
                        <option value="Honda">Honda</option>
                        <option value="Yamaha">Yamaha</option>
                        <option value="Suzuki">Suzuki</option>
                        <option value="Vespa">Vespa</option>
                    </select>
                </div>
            </div>
        </div>
        </form>
    </div>
</section>

<!-- Display Motor -->
<section id="motor-list" class="motor-list-section">
    <div class="motor-grid" id="motor-grid-container">
        <?php if (empty($motors)): ?>
            <p style="text-align: center; grid-column: 1 / -1;">Motor tidak ditemukan.</p>
        <?php else: ?>
            <?php foreach ($motors as $motor): ?>
                <div class="motor-card">
                    <div class="card-image">
                        <img src="/RentForYou/assets/uploads/<?php echo htmlspecialchars($motor['gambar']); ?>" alt="Gambar <?php echo htmlspecialchars($motor['merk'] . ' ' . $motor['model']); ?>">
                    </div>
                    <div class="card-content">
                        <h3 class="card-title"><?php echo htmlspecialchars($motor['merk'].' '.$motor['model']); ?></h3>
                        <p class="card-price">Rp <?php echo number_format($motor['harga_perHari'], 0, ',', '.'); ?> / hari</p>
                        
                        <?php
                        // Logika ini sekarang akan bekerja karena $motor['stok_tersedia'] sudah ada
                        if ($motor['stok_tersedia'] > 0) {
                            if (isset($_SESSION['user_id'])) {
                                echo '<a href="detail_motor_controller.php?id=' . $motor['id_motor'] . '" class="btn-pesan">Pesan</a>';
                            } else {
                                echo '<a href="login_controller.php" class="btn-pesan">Login untuk Pesan</a>';
                            }
                        } else {
                            echo '<span class="btn-habis">Stok Habis</span>';
                        }
                        ?>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>
</section>

<script>
    // Memunculkan/menyembunyikan panel filter
    document.getElementById('toggle-filter-btn').addEventListener('click', function() {
        var filterPanel = document.getElementById('filter-panel');
        if (filterPanel.style.display === 'none') {
            filterPanel.style.display = 'block';
        } else {
            filterPanel.style.display = 'none';
        }
    });

    // --- LIVE SEARCH DENGAN AJAX ---
    const searchInput = document.getElementById('live-search-input');
    const merkFilter = document.getElementById('filter-merk');
    const hargaFilter = document.getElementById('filter-harga');
    const motorGrid = document.getElementById('motor-grid-container');

    function fetchMotors() {
        const keyword = searchInput.value;
        const merk = merkFilter.value;
        const harga = hargaFilter.value;

        // Membuat URL dengan semua parameter filter
        const params = new URLSearchParams({
            q: keyword,
            merk: merk,
            harga: harga
        }).toString();

        // Kirim request ke server
        fetch(`/RentForYou/ajax/live_search.php?${params}`)
            .then(response => response.text())
            .then(html => {
                // Ganti konten grid dengan hasil dari server
                motorGrid.innerHTML = html;
            })
            .catch(error => console.error('Error:', error));
    }

    // Tambahkan event listener ke setiap input/select
    searchInput.addEventListener('keyup', fetchMotors);
    merkFilter.addEventListener('change', fetchMotors);
    hargaFilter.addEventListener('change', fetchMotors);
</script>