-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Server version:               10.4.32-MariaDB - mariadb.org binary distribution
-- Server OS:                    Win64
-- HeidiSQL Version:             12.10.0.7000
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

-- Dumping data for table rentforyou.motor: ~11 rows (approximately)
DELETE FROM `motor`;
INSERT INTO `motor` (`id_motor`, `merk`, `model`, `tahun`, `harga_perHari`, `stok`, `gambar`, `deskripsi`) VALUES
	(1, 'Honda', 'Vario 123', 2022, 75000.00, 6, '1752827229_Honda Vario 123 2022.jpg', 'Motor matic dan cocok untuk riding bersama partner travelingmu!'),
	(2, 'Honda', 'Beat Street', 2023, 70000.00, 3, '1752387677_BeatStreet2023.jpg', 'Partner paling pas untuk hunting foto di spot-spot instagramable wisata DIY!'),
	(3, 'Honda', 'PCX 160', 2023, 150000.00, 4, '1752827246_Honda PCX 160 2023.jpg', 'Nikmati kenyamanan si gagah untuk menyusuri wisata alam Yogyakarta!'),
	(4, 'Yamaha', 'NMAX 155', 2022, 155000.00, 4, '1752827298_Yamaha NMAX 155 2022.jpg', 'Performa tangguh untuk perjalanan jauh dari ujung timur menyusuri jalan lintas selatan hingga ujung barat.'),
	(5, 'Yamaha', 'Fazzio', 2023, 85000.00, 5, '1752827287_Yamaha Fazzio 2023.jpg', 'Tampil beda dengan gaya retro yang kekinian untuk menjadi partner nongkrong santai di Prawirotaman.'),
	(6, 'Yamaha', 'Aerox 155', 2022, 140000.00, 3, '1752827276_Yamaha Aerox 2022.png', 'Jelajahi jalanan Yogyakarta dengan Aerox bergaya sporty yang mencuri perhatian!'),
	(7, 'Suzuki', 'NEX II', 2021, 65000.00, 7, '1752794953_Suzuki NEX II 2021.png', 'Pilihan paling tepat dengan keunggulannya yang super irit, untuk keliling wisata di Yogyakarta tanpa pusing mikirin bensin.'),
	(8, 'Suzuki', 'Address FI', 2022, 70000.00, 5, '1752793607_Suzuki Address FI 2022.jpg', 'Dengan bagasi yang super luas, cocok untuk kamu yang mau hunting oleh-oleh.'),
	(10, 'Honda', 'Scoopy', 2023, 80000.00, 4, '1752390957_Honda Scoopy 2023.jpg', 'Gaya retro yang ikonik, bikin setiap perjalananmu di Jogja makin berkesan dan penuh warna.'),
	(11, 'Vespa', 'LX 125 i-Get', 2022, 200000.00, 5, '1752387670_VespaLX 125 i-Get 2022.jpg', 'Nikmati pesona Jogja dengan sentuhan klasik. Vespa LX adalah pilihan sempurna untuk berkeliling kota dengan gaya.'),
	(45, 'Vespa', 'Sprint 150', 2021, 250000.00, 1, '1752400617_Vespa Sprint 150 2021.jpg', '');

-- Dumping data for table rentforyou.transaksi: ~12 rows (approximately)
DELETE FROM `transaksi`;
INSERT INTO `transaksi` (`id_transaksi`, `id_user`, `id_motor`, `tanggal_sewa`, `tanggal_kembali`, `total_harga`, `status_transaksi`) VALUES
	(1, 2, 10, '2025-07-26', '2025-07-28', 240000.00, 'selesai'),
	(2, 2, 11, '2025-07-19', '2025-07-21', 600000.00, 'selesai'),
	(3, 2, 5, '2025-07-19', '2025-07-20', 170000.00, 'pesanan_ditolak'),
	(4, 2, 45, '2025-07-19', '2025-07-21', 750000.00, 'selesai'),
	(5, 1, 45, '2025-07-26', '2025-07-27', 500000.00, 'selesai'),
	(6, 1, 10, '2025-07-26', '2025-07-27', 160000.00, 'selesai'),
	(7, 2, 10, '2025-07-26', '2025-07-27', 160000.00, 'sedang_berjalan'),
	(8, 3, 7, '2025-07-26', '2025-07-28', 195000.00, 'selesai'),
	(9, 3, 8, '2025-07-26', '2025-07-27', 140000.00, 'sedang_berjalan'),
	(10, 1, 7, '2025-07-26', '2025-07-27', 130000.00, 'pesanan_disetujui'),
	(11, 2, 11, '2025-07-26', '2025-07-27', 400000.00, 'menunggu_konfirmasi'),
	(12, 3, 45, '2025-08-02', '2025-08-04', 750000.00, 'pesanan_disetujui');

-- Dumping data for table rentforyou.users: ~3 rows (approximately)
DELETE FROM `users`;
INSERT INTO `users` (`id_user`, `nama_lengkap`, `username`, `password`, `email`, `no_hp`, `role`) VALUES
	(1, 'Miftahul Husna', 'husna', '$2y$10$zOQ9UkcDLIeN0UH.nvHlI.jLBQtTf0C72IYgNUL..xPfTI0NjkZWW', 'husna@gmail.com', '085826056392', 'admin'),
	(2, 'Luthfiyya Rachmi', 'fiyya', '$2y$10$TBPAQK.wJAaj2LezDNsMq.knHaZT6y0KQHHHnet0dZsBdXRhfDLc6', 'fiyya@gmail.com', '085812345678', 'pengguna'),
	(3, 'Ica Bali', 'icabali', '$2y$10$nQseXesHZacka9E769tYLOzYsqE.W4qn2VPhtj1W12FgItfDhgZ6e', 'icabali@gmail.com', '085812345678', 'pengguna');

-- Dumping data for table rentforyou.verifikasi_identitas: ~1 rows (approximately)
DELETE FROM `verifikasi_identitas`;
INSERT INTO `verifikasi_identitas` (`id_verifikasi`, `id_user`, `alamat`, `foto_ktp`, `foto_sim`, `status_verifikasi`) VALUES
	(1, 3, 'cek123', '1752815127_ktp_Vespa Sprint 150 2021.jpg', '1752815127_sim_Suzuki NEX II 2021.png', '');

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
