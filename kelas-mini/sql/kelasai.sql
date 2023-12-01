-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Server version:               8.0.30 - MySQL Community Server - GPL
-- Server OS:                    Win64
-- HeidiSQL Version:             12.1.0.6537
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

-- Dumping structure for table kelasai.admin
CREATE TABLE IF NOT EXISTS `admin` (
  `id` int NOT NULL,
  `usernameAdmin` varchar(50) CHARACTER SET utf8mb4 NOT NULL DEFAULT '',
  `passwordAdmin` varchar(250) CHARACTER SET utf8mb4 NOT NULL DEFAULT '',
  `namaAdmin` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Dumping data for table kelasai.admin: ~1 rows (approximately)
INSERT INTO `admin` (`id`, `usernameAdmin`, `passwordAdmin`, `namaAdmin`) VALUES
	(1, 'admin', '$2y$10$H1VaTcGqPdd9AgeBy1YF/Op1B5jThgSK.HSIMVLmWL7o/8eF8GWmS', 'Nuur M');

-- Dumping structure for table kelasai.guru
CREATE TABLE IF NOT EXISTS `guru` (
  `id` int NOT NULL AUTO_INCREMENT,
  `fotoGuru` varchar(250) CHARACTER SET utf8mb4 DEFAULT NULL,
  `nipGuru` varchar(250) CHARACTER SET utf8mb4 DEFAULT NULL,
  `passwordGuru` varchar(250) CHARACTER SET utf8mb4 DEFAULT NULL,
  `namaGuru` varchar(250) CHARACTER SET utf8mb4 DEFAULT NULL,
  `jabatanGuru` varchar(250) CHARACTER SET utf8mb4 DEFAULT NULL,
  `studiGuru` varchar(250) CHARACTER SET utf8mb4 DEFAULT NULL,
  `kelasGuru` varchar(250) DEFAULT NULL,
  `alamatGuru` varchar(250) CHARACTER SET utf8mb4 DEFAULT NULL,
  `hpGuru` varchar(250) DEFAULT NULL,
  `emailGuru` varchar(250) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4;

-- Dumping data for table kelasai.guru: ~2 rows (approximately)
INSERT INTO `guru` (`id`, `fotoGuru`, `nipGuru`, `passwordGuru`, `namaGuru`, `jabatanGuru`, `studiGuru`, `kelasGuru`, `alamatGuru`, `hpGuru`, `emailGuru`) VALUES
	(1, '../../adminlte/img/icon.png', '111', '$2y$10$KBY9ynmLqTTWZL15gkIE3u11sejplNTMwxQgMYbqfif.jS43lKCFG', 'M. Nuur', 'Guru Kelas', 'Agama', 'IPA-1;IPA-2;IPS-1', 'Desa Vrindavan Kecamatan Fufu', '8979880', 'Email Edit'),
	(7, 'https://img.freepik.com/premium-photo/anime-girl-with-black-hair-glasses-giving-thumbs-up-generative-ai_958124-30630.jpg?w=740', '112', '$2y$10$aovxnrebkJBefpQgjd2Ore5ShgxbAinG43GIjVYeKxpA6q9PsgLqu', 'Puro Guramu', 'Guru Kelas', 'Informatika', 'IPA-1;IPA-2;IPS-1', 'V_Address', '087898909091', 'puroguramu@gmail.com');

-- Dumping structure for table kelasai.jabatan
CREATE TABLE IF NOT EXISTS `jabatan` (
  `id` int NOT NULL AUTO_INCREMENT,
  `jabatan` varchar(250) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Dumping data for table kelasai.jabatan: ~2 rows (approximately)
INSERT INTO `jabatan` (`id`, `jabatan`) VALUES
	(1, 'Kepala Sekolah'),
	(2, 'Guru Kelas');

-- Dumping structure for table kelasai.kelas
CREATE TABLE IF NOT EXISTS `kelas` (
  `id` int NOT NULL AUTO_INCREMENT,
  `kelas` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4;

-- Dumping data for table kelasai.kelas: ~3 rows (approximately)
INSERT INTO `kelas` (`id`, `kelas`) VALUES
	(3, 'IPA-1'),
	(4, 'IPA-2'),
	(5, 'IPS-1');

-- Dumping structure for table kelasai.mapel
CREATE TABLE IF NOT EXISTS `mapel` (
  `id` int NOT NULL AUTO_INCREMENT,
  `mapel` varchar(250) CHARACTER SET utf8mb4 NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4;

-- Dumping data for table kelasai.mapel: ~3 rows (approximately)
INSERT INTO `mapel` (`id`, `mapel`) VALUES
	(1, 'Agama'),
	(2, 'Biologi'),
	(3, 'Informatika');

-- Dumping structure for table kelasai.siswa
CREATE TABLE IF NOT EXISTS `siswa` (
  `id` int NOT NULL AUTO_INCREMENT,
  `fotoSiswa` varchar(250) CHARACTER SET utf8mb4 DEFAULT NULL,
  `nisnSiswa` varchar(250) CHARACTER SET utf8mb4 DEFAULT NULL,
  `passwordSiswa` varchar(250) CHARACTER SET utf8mb4 DEFAULT NULL,
  `namaSiswa` varchar(250) CHARACTER SET utf8mb4 DEFAULT NULL,
  `kelasSiswa` varchar(250) CHARACTER SET utf8mb4 DEFAULT NULL,
  `alamatSiswa` varchar(250) CHARACTER SET utf8mb4 DEFAULT NULL,
  `hpSiswa` varchar(250) CHARACTER SET utf8mb4 DEFAULT NULL,
  `emailSiswa` varchar(250) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4;

-- Dumping data for table kelasai.siswa: ~1 rows (approximately)
INSERT INTO `siswa` (`id`, `fotoSiswa`, `nisnSiswa`, `passwordSiswa`, `namaSiswa`, `kelasSiswa`, `alamatSiswa`, `hpSiswa`, `emailSiswa`) VALUES
	(4, '../../adminlte/img/icon.png', '123', '$2y$10$zrV3id6bneQIrwCM4yJPOeBXVGlug.VrEuq06h9lK1987bu.8G8fS', 'Abel Nadia', 'IPA-2', 'Indonesia\r\n', '+62107098101', 'email@gmail.com');

-- Dumping structure for table kelasai.tugas
CREATE TABLE IF NOT EXISTS `tugas` (
  `id` int NOT NULL AUTO_INCREMENT,
  `namaGuru` varchar(250) CHARACTER SET utf8mb4 DEFAULT NULL,
  `namaSiswa` varchar(250) CHARACTER SET utf8mb4 DEFAULT NULL,
  `kelasSiswa` varchar(250) CHARACTER SET utf8mb4 DEFAULT NULL,
  `judulTugas` varchar(250) CHARACTER SET utf8mb4 DEFAULT NULL,
  `studiTugas` varchar(250) DEFAULT NULL,
  `keteranganTugas` longtext CHARACTER SET utf8mb4,
  `modulTugas` varchar(250) DEFAULT NULL,
  `deadlineTugas` varchar(250) CHARACTER SET utf8mb4 DEFAULT NULL,
  `pengumpulanTugas` varchar(250) DEFAULT NULL,
  `fileTugas` varchar(250) DEFAULT NULL,
  `nilaiTugas` varchar(250) CHARACTER SET utf8mb4 DEFAULT NULL,
  `statusTugas` varchar(250) DEFAULT NULL,
  `catatanNilai` longtext CHARACTER SET utf8mb4,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=24 DEFAULT CHARSET=utf8mb4;

-- Dumping data for table kelasai.tugas: ~6 rows (approximately)
INSERT INTO `tugas` (`id`, `namaGuru`, `namaSiswa`, `kelasSiswa`, `judulTugas`, `studiTugas`, `keteranganTugas`, `modulTugas`, `deadlineTugas`, `pengumpulanTugas`, `fileTugas`, `nilaiTugas`, `statusTugas`, `catatanNilai`) VALUES
	(17, 'M. Nuur', NULL, 'IPA-1', 'Praktikum Wudhu', 'Agama', 'Kumpulkan dalam bentuk video, upload ke youtube dan salin link untuk penilaian', '-', '2023-12-08', NULL, NULL, NULL, 'Belum Dinilai', NULL),
	(18, 'M. Nuur', NULL, 'IPA-2', 'Praktikum Wudhu', 'Agama', 'Kumpulkan dalam bentuk video, upload ke youtube dan salin link untuk penilaian', '-', '2023-12-08', NULL, NULL, NULL, 'Belum Dinilai', NULL),
	(19, 'M. Nuur', NULL, 'IPS-1', 'Praktikum Wudhu', 'Agama', 'Kumpulkan dalam bentuk video, upload ke youtube dan salin link untuk penilaian', '-', '2023-12-08', NULL, NULL, NULL, 'Belum Dinilai', NULL),
	(20, 'M. Nuur', 'Abel Nadia', 'IPA-2', 'Praktikum Wudhu', 'Agama', 'Kumpulkan dalam bentuk video, upload ke youtube dan salin link untuk penilaian', '-', '2023-12-08', '2023-11-30', 'https://www.youtube.com/watch?v=zcp9XMZz5ac&pp=ygUadGF0YSBjYXJhIHd1ZGh1IHlhbmcgYmVuYXI%3D', '95', 'Dinilai', NULL),
	(22, 'M. Nuur', 'Abel Nadia', 'IPA-2', 'Absensi', 'Agama', 'Kumpulkan dalam bentuk video, upload ke youtube dan salin link untuk penilaian', '-', '2023-12-08', '2023-11-30', 'https://www.youtube.com/watch?v=zcp9XMZz5ac&pp=ygUadGF0YSBjYXJhIHd1ZGh1IHlhbmcgYmVuYXI%3D', '95', 'Dinilai', NULL),
	(23, 'Puro Guramu', NULL, 'IPA-1', 'Buat Blogger', 'Informatika', 'Silakan buat blog di blogger.com, kemudian hasil nya kumpulkan berbentuk link.', '', '2023-12-15', NULL, NULL, NULL, 'Belum Dinilai', NULL);

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
