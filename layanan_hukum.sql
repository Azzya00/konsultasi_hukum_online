-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 09, 2025 at 07:57 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `layanan_hukum`
--

-- --------------------------------------------------------

--
-- Table structure for table `advokat`
--

CREATE TABLE `advokat` (
  `id` int(11) NOT NULL,
  `nama` varchar(100) DEFAULT NULL,
  `pendidikan` text DEFAULT NULL,
  `keahlian` text DEFAULT NULL,
  `pengalaman` varchar(50) DEFAULT NULL,
  `foto` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `advokat`
--

INSERT INTO `advokat` (`id`, `nama`, `pendidikan`, `keahlian`, `pengalaman`, `foto`) VALUES
(1, 'Saiful Mizan Yusuf', 'Magister Hukum dari Universitas Atma Jaya Yogyakarta', 'Bisnis, Keluarga, Hutang Piutang, Kekayaan Intelektual, Pertanahan', 'Lebih dari 10 tahun', 'foto1.jpg'),
(2, 'Taufan Adi Wijaya, S.H., M.H., C.L.A', 'Magister Hukum dari Universitas Surabaya', 'Hutang Piutang, Ketenagakerjaan, Keluarga, Pidana, Laporan Polisi', 'Lebih dari 8 tahun', 'foto2.jpg'),
(3, 'Rizky Rahmawati Pasaribu, S.H., LL.M.', 'Magister Hukum dari Radboud University, Belanda', 'Hutang Piutang, Pidana dan Laporan Polisi, Keluarga, Ketenagakerjaan', 'Lebih dari 17 tahun', 'foto3.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `artikel`
--

CREATE TABLE `artikel` (
  `id` int(11) NOT NULL,
  `advokat_id` int(11) DEFAULT NULL,
  `judul` varchar(255) DEFAULT NULL,
  `isi` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `artikel`
--

INSERT INTO `artikel` (`id`, `advokat_id`, `judul`, `isi`) VALUES
(1, 1, 'Strategi Hukum dalam Sengketa Bisnis', 'Pembahasan singkat mengenai strategi penyelesaian sengketa bisnis.'),
(2, 1, 'Perlindungan Kekayaan Intelektual', 'Cara mendaftarkan dan melindungi hak cipta atau paten Anda.'),
(3, 2, 'Hak dan Kewajiban Karyawan', 'Ulasan mengenai peran kontrak kerja dan hak pekerja.'),
(4, 2, 'Langkah Hukum atas Hutang Piutang', 'Solusi hukum saat menghadapi kredit macet.'),
(5, 3, 'Menangani Kasus Pidana Ringan', 'Langkah awal saat menghadapi tuduhan pidana ringan.'),
(6, 3, 'Peran Advokat dalam Proses Mediasi', 'Bagaimana advokat membantu proses mediasi keluarga.');

-- --------------------------------------------------------

--
-- Table structure for table `layanan`
--

CREATE TABLE `layanan` (
  `id` int(11) NOT NULL,
  `advokat_id` int(11) DEFAULT NULL,
  `nama_layanan` varchar(100) DEFAULT NULL,
  `harga` decimal(10,2) DEFAULT NULL,
  `deskripsi` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `layanan`
--

INSERT INTO `layanan` (`id`, `advokat_id`, `nama_layanan`, `harga`, `deskripsi`) VALUES
(1, 1, 'Konsultasi Bisnis dan Korporat', 500000.00, 'Pendampingan hukum terkait perjanjian bisnis dan korporasi.'),
(2, 1, 'Pendaftaran Hak Cipta', 300000.00, 'Bantuan dalam proses pendaftaran hak kekayaan intelektual.'),
(3, 2, 'Konsultasi Ketenagakerjaan', 400000.00, 'Solusi hukum untuk masalah tenaga kerja.'),
(4, 2, 'Penanganan Kasus Hutang Piutang', 600000.00, 'Pendampingan dalam penyelesaian kredit dan tagihan.'),
(5, 3, 'Pembelaan Kasus Pidana', 750000.00, 'Mewakili klien dalam proses hukum pidana.'),
(6, 3, 'Mediasi Keluarga', 350000.00, 'Penyelesaian sengketa keluarga tanpa pengadilan.');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `advokat`
--
ALTER TABLE `advokat`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `artikel`
--
ALTER TABLE `artikel`
  ADD PRIMARY KEY (`id`),
  ADD KEY `advokat_id` (`advokat_id`);

--
-- Indexes for table `layanan`
--
ALTER TABLE `layanan`
  ADD PRIMARY KEY (`id`),
  ADD KEY `advokat_id` (`advokat_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `advokat`
--
ALTER TABLE `advokat`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `artikel`
--
ALTER TABLE `artikel`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `layanan`
--
ALTER TABLE `layanan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `artikel`
--
ALTER TABLE `artikel`
  ADD CONSTRAINT `artikel_ibfk_1` FOREIGN KEY (`advokat_id`) REFERENCES `advokat` (`id`);

--
-- Constraints for table `layanan`
--
ALTER TABLE `layanan`
  ADD CONSTRAINT `layanan_ibfk_1` FOREIGN KEY (`advokat_id`) REFERENCES `advokat` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
