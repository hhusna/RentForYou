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


-- Dumping database structure for rentforyou
DROP DATABASE IF EXISTS `rentforyou`;
CREATE DATABASE IF NOT EXISTS `rentforyou` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci */;
USE `rentforyou`;

-- Dumping structure for table rentforyou.motor
DROP TABLE IF EXISTS `motor`;
CREATE TABLE IF NOT EXISTS `motor` (
  `id_motor` int(11) NOT NULL AUTO_INCREMENT,
  `merk` varchar(50) NOT NULL,
  `model` varchar(100) NOT NULL,
  `tahun` int(4) NOT NULL,
  `harga_perHari` decimal(10,2) NOT NULL,
  `stok` int(2) NOT NULL,
  `gambar` varchar(255) DEFAULT NULL,
  `deskripsi` text DEFAULT NULL,
  PRIMARY KEY (`id_motor`)
) ENGINE=InnoDB AUTO_INCREMENT=46 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT='Tabel untuk identitas dan deskripsi motor';

-- Dumping data for table rentforyou.motor: ~0 rows (approximately)
DELETE FROM `motor`;

-- Dumping structure for table rentforyou.transaksi
DROP TABLE IF EXISTS `transaksi`;
CREATE TABLE IF NOT EXISTS `transaksi` (
  `id_transaksi` int(11) NOT NULL AUTO_INCREMENT,
  `id_user` int(11) NOT NULL,
  `id_motor` int(11) NOT NULL,
  `tanggal_sewa` date NOT NULL,
  `tanggal_kembali` date NOT NULL,
  `total_harga` decimal(10,2) NOT NULL DEFAULT 0.00,
  `status_transaksi` enum('menunggu_konfirmasi','pesanan_disetujui','sedang_berjalan','selesai','pesanan_ditolak') NOT NULL DEFAULT 'menunggu_konfirmasi',
  PRIMARY KEY (`id_transaksi`),
  KEY `user_id` (`id_user`),
  KEY `id_motor` (`id_motor`),
  CONSTRAINT `id_motor` FOREIGN KEY (`id_motor`) REFERENCES `motor` (`id_motor`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `user_id` FOREIGN KEY (`id_user`) REFERENCES `users` (`id_user`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT='Tabel detail transaksi';

-- Dumping data for table rentforyou.transaksi: ~0 rows (approximately)
DELETE FROM `transaksi`;

-- Dumping structure for table rentforyou.users
DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id_user` int(11) NOT NULL AUTO_INCREMENT,
  `nama_lengkap` varchar(255) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `no_hp` varchar(15) NOT NULL,
  `role` enum('admin','pengguna') NOT NULL DEFAULT 'pengguna',
  PRIMARY KEY (`id_user`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT='tabel identitas pengguna (user)';

-- Dumping data for table rentforyou.users: ~0 rows (approximately)
DELETE FROM `users`;

-- Dumping structure for table rentforyou.verifikasi_identitas
DROP TABLE IF EXISTS `verifikasi_identitas`;
CREATE TABLE IF NOT EXISTS `verifikasi_identitas` (
  `id_verifikasi` int(11) NOT NULL AUTO_INCREMENT,
  `id_user` int(11) NOT NULL,
  `alamat` text NOT NULL,
  `foto_ktp` varchar(255) NOT NULL,
  `foto_sim` varchar(255) NOT NULL,
  `status_verifikasi` enum('menunggu_konfirmasi','pesanan disetujui','pesanan ditolak','pesanan selesai') NOT NULL DEFAULT 'menunggu_konfirmasi',
  PRIMARY KEY (`id_verifikasi`),
  KEY `id_user` (`id_user`),
  CONSTRAINT `id_user` FOREIGN KEY (`id_user`) REFERENCES `users` (`id_user`) ON DELETE CASCADE ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT='Tabel verifikasi identitas penyewa sebelum melakukan booking';

-- Dumping data for table rentforyou.verifikasi_identitas: ~0 rows (approximately)
DELETE FROM `verifikasi_identitas`;

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
