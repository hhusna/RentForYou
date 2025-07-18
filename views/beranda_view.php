<?php include 'partials/header.php'; // Memuat header ?>

<main>
    <!-- 1. Hero Section -->
    <section class="hero-section">
        <div class="hero-content">
            <h1>RentForYou siap menjadi partner<br>travelingmu dengan nyaman dan lancar!</h1>
        </div>
    </section>

    <div class="container page-content">
        <?php 
        // Menyisipkan bagian katalog dari file terpisah
        include 'partials/katalog_section.php'; 

        // Menyisipkan bagian Syarat & Ketentuan
        include 'partials/s&k_section.php';
        
        // Menyisipkan bagian fasilitas
        include 'partials/fasilitas_section.php'; 

        ?>
    </div>
</main>

<?php include 'partials/footer.php'; ?> 