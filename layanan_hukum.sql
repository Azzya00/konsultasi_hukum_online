-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 02, 2025 at 11:55 PM
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
  `email` varchar(255) DEFAULT NULL,
  `spesialisasi` varchar(255) DEFAULT NULL,
  `pendidikan` text DEFAULT NULL,
  `keahlian` text DEFAULT NULL,
  `pengalaman` varchar(50) DEFAULT NULL,
  `rating` decimal(3,2) NOT NULL DEFAULT 0.00,
  `total_review` int(11) NOT NULL DEFAULT 0,
  `foto` varchar(255) DEFAULT NULL,
  `jenis_konsultasi` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `advokat`
--

INSERT INTO `advokat` (`id`, `nama`, `email`, `spesialisasi`, `pendidikan`, `keahlian`, `pengalaman`, `rating`, `total_review`, `foto`, `jenis_konsultasi`) VALUES
(1, 'Saiful Mizan Yusuf', NULL, NULL, 'Magister Hukum dari Universitas Atma Jaya Yogyakarta', 'Bisnis, Keluarga, Hutang Piutang, Kekayaan Intelektual, Pertanahan', 'Lebih dari 10 tahun', 0.00, 0, 'foto1.jpg', 'chat_telepon'),
(2, 'Irsan Adi Wijaya, S.H., M.H., C.L.A', NULL, NULL, 'Magister Hukum dari Universitas Surabaya', 'Hutang Piutang, Ketenagakerjaan, Keluarga, Pidana, Laporan Polisi', 'Lebih dari 8 tahun', 0.00, 0, 'foto2.jpg', 'chat_telepon'),
(3, 'Rizky Rahmawati Pasaribu, S.H., LL.M.', NULL, NULL, 'Magister Hukum dari Radboud University, Belanda', 'Hutang Piutang, Pidana dan Laporan Polisi, Keluarga, Ketenagakerjaan', 'Lebih dari 17 tahun', 0.00, 0, 'foto3.jpg', 'chat'),
(4, 'Intan Permata Sari, S.H.', NULL, NULL, 'S.H. dari Universitas Indonesia', 'Keluarga, Waris, Perceraian', '5 tahun', 0.00, 0, 'foto4.jpg', 'chat'),
(5, 'Budi Santoso, S.H., M.H.', NULL, NULL, 'Magister Hukum dari UGM', 'Pertanahan, Waris, Agraria', '7 tahun', 0.00, 0, 'foto5.jpg', 'chat_telepon'),
(6, 'Dewi Ayu Lestari, S.H.', NULL, NULL, 'S.H. dari Universitas Padjadjaran', 'Pidana, Perdata, Sengketa Konsumen', '6 tahun', 0.00, 0, 'foto6.jpg', 'chat'),
(7, 'Ahmad Fauzi, S.H., M.Kn.', NULL, NULL, 'Magister Kenotariatan dari UNDIP', 'Kekayaan Intelektual, Bisnis', '10 tahun', 0.00, 0, 'foto7.jpg', 'chat_telepon'),
(8, 'Rani Widya Kusuma, S.H.', NULL, NULL, 'S.H. dari Universitas Trisakti', 'Ketenagakerjaan, Pidana, Perceraian', '8 tahun', 0.00, 0, 'foto8.jpg', 'chat'),
(9, 'Agus Haryanto, S.H., M.H.', NULL, NULL, 'Magister Hukum dari Universitas Brawijaya', 'Bisnis, Keluarga, Hutang Piutang', '12 tahun', 0.00, 0, 'foto9.jpg', 'chat_telepon'),
(10, 'Nina Marlina, S.H.', NULL, NULL, 'S.H. dari Universitas Airlangga', 'Pidana, Ketenagakerjaan, Sengketa', '6 tahun', 0.00, 0, 'foto10.jpg', 'chat'),
(11, 'Fajar Nugroho, S.H., M.H.', NULL, NULL, 'Magister Hukum dari Universitas Hasanuddin', 'Waris, Agraria, Keluarga', '9 tahun', 0.00, 0, 'foto11.jpg', 'chat_telepon'),
(12, 'Larasati Ningsih, S.H.', NULL, NULL, 'S.H. dari Universitas Parahyangan', 'Bisnis, Perusahaan, Kontrak', '5 tahun', 0.00, 0, 'foto12.jpg', 'chat'),
(13, 'Rico Firmansyah, S.H.', NULL, NULL, 'S.H. dari Universitas Andalas', 'Laporan Polisi, Ketenagakerjaan', '6 tahun', 0.00, 0, 'foto13.jpg', 'chat'),
(14, 'Siti Maesaroh, S.H., M.H.', NULL, NULL, 'Magister Hukum dari Universitas Diponegoro', 'Pidana, Tindak Pidana Khusus', '11 tahun', 0.00, 0, 'foto14.jpg', 'chat_telepon'),
(15, 'Dimas Pratama, S.H.', NULL, NULL, 'S.H. dari Universitas Muhammadiyah Yogyakarta', 'Pertanahan, Keluarga, Perdata', '7 tahun', 0.00, 0, 'foto15.jpg', 'chat_telepon');

-- --------------------------------------------------------

--
-- Table structure for table `artikel`
--

CREATE TABLE `artikel` (
  `id` int(11) NOT NULL,
  `advokat_id` int(11) DEFAULT NULL,
  `judul` varchar(255) DEFAULT NULL,
  `isi` text DEFAULT NULL,
  `lengkap` text DEFAULT NULL,
  `gambar` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `artikel`
--

INSERT INTO `artikel` (`id`, `advokat_id`, `judul`, `isi`, `lengkap`, `gambar`) VALUES
(1, 1, 'Strategi Hukum dalam Sengketa Bisnis', 'Pembahasan singkat mengenai strategi penyelesaian sengketa bisnis.', '\nSengketa bisnis merupakan hal yang lumrah dalam dunia usaha. Ketika dua pihak atau lebih terlibat dalam perjanjian yang tidak berjalan sebagaimana mestinya, konflik bisa muncul dan memicu proses hukum. Untuk itulah, strategi penyelesaian sangat diperlukan agar kerugian dapat diminimalkan.\n\nLangkah pertama adalah mengenali bentuk sengketa yang terjadi. Apakah itu perselisihan kontrak, persaingan tidak sehat, wanprestasi, atau penipuan? Identifikasi jenis masalah menjadi dasar untuk menentukan pendekatan hukum yang tepat.\n\nSelanjutnya, penting untuk mengkaji kembali kontrak atau dokumen hukum yang menjadi dasar hubungan bisnis. Banyak kasus sengketa bermula dari penafsiran pasal dalam perjanjian yang tidak jelas atau multitafsir.\n\nSalah satu strategi efektif adalah negosiasi langsung antara pihak yang bersengketa. Negosiasi memungkinkan solusi damai tanpa perlu melalui jalur litigasi yang panjang dan mahal.\n\nJika negosiasi gagal, mediasi atau arbitrase dapat menjadi opsi. Arbitrase khususnya banyak digunakan di sektor bisnis karena lebih cepat, tertutup, dan hasilnya mengikat.\n\nNamun, dalam beberapa kasus, pengadilan tetap menjadi jalan terakhir. Dalam hal ini, penting bagi pelaku usaha untuk didampingi oleh advokat yang berpengalaman dalam hukum bisnis dan sengketa niaga.\n\nMemahami setiap tahapan serta menyiapkan bukti dan argumen hukum dengan baik dapat meningkatkan peluang kemenangan. Oleh karena itu, memiliki strategi hukum sejak awal dapat menyelamatkan reputasi dan aset perusahaan.\n', 'gambar1.jpeg'),
(2, 1, 'Perlindungan Kekayaan Intelektual', 'Cara mendaftarkan dan melindungi hak cipta atau paten Anda.', '\nKekayaan intelektual adalah hasil karya dari kreativitas manusia, yang memiliki nilai ekonomi dan perlu dilindungi secara hukum. Bentuk kekayaan intelektual antara lain hak cipta, paten, merek, dan desain industri.\n\nUntuk mendapatkan perlindungan hukum, langkah pertama adalah mendaftarkan kekayaan intelektual ke instansi terkait seperti Direktorat Jenderal Kekayaan Intelektual (DJKI). Pendaftaran menjamin eksklusivitas hak dan dapat digunakan sebagai dasar penegakan hukum.\n\nHak cipta secara otomatis dilindungi sejak suatu karya dibuat. Namun, pendaftaran tetap disarankan untuk memperkuat posisi hukum pemilik jika terjadi pelanggaran.\n\nUntuk paten, prosesnya lebih kompleks karena melibatkan pemeriksaan substantif terkait kebaruan, langkah inventif, dan aplikasi industri. Oleh karena itu, diperlukan pendampingan dari konsultan KI atau advokat.\n\nMerek dagang juga penting untuk membedakan produk atau jasa Anda dengan milik pesaing. Perlindungan merek yang terdaftar berlaku selama 10 tahun dan dapat diperpanjang.\n\nKetika hak kekayaan intelektual dilanggar, pemilik dapat menempuh jalur perdata atau pidana. Bukti kepemilikan dan pendaftaran menjadi alat bukti penting di pengadilan.\n\nDengan demikian, perlindungan kekayaan intelektual bukan hanya soal legalitas, tetapi juga strategi bisnis jangka panjang untuk menjaga orisinalitas dan daya saing.\n', 'gambar2.jpeg'),
(3, 2, 'Hak dan Kewajiban Karyawan', 'Ulasan mengenai peran kontrak kerja dan hak pekerja.', '\nDalam dunia kerja, hubungan antara pengusaha dan karyawan diatur secara hukum, khususnya melalui kontrak kerja yang memuat hak dan kewajiban masing-masing pihak. Kontrak ini menjadi fondasi dalam menjaga keharmonisan hubungan kerja.\n\nSalah satu hak dasar karyawan adalah mendapatkan upah sesuai ketentuan, bekerja dalam lingkungan yang aman, serta mendapatkan jaminan sosial dan cuti yang diatur dalam Undang-Undang Ketenagakerjaan.\n\nSebaliknya, karyawan juga memiliki kewajiban, antara lain melaksanakan pekerjaan sesuai tugasnya, menjaga rahasia perusahaan, dan mentaati tata tertib yang berlaku.\n\nMasalah sering muncul ketika terjadi pelanggaran kontrak atau pemutusan hubungan kerja sepihak. Dalam situasi ini, pekerja dapat mengadukan ke Dinas Ketenagakerjaan atau menempuh jalur hukum.\n\nPengusaha wajib memberikan surat peringatan sebelum memberhentikan karyawan, kecuali terjadi pelanggaran berat. PHK tanpa dasar hukum dapat digugat oleh karyawan ke Pengadilan Hubungan Industrial.\n\nSementara itu, karyawan juga tidak diperbolehkan meninggalkan pekerjaan tanpa pemberitahuan tertulis. Hal ini dapat dianggap wanprestasi.\n\nPemahaman akan hak dan kewajiban kedua belah pihak sangat penting untuk menciptakan lingkungan kerja yang adil dan produktif. Konsultasi dengan ahli hukum ketenagakerjaan dapat menjadi solusi saat terjadi konflik.\n', 'gambar3.jpeg'),
(4, 2, 'Langkah Hukum atas Hutang Piutang', 'Solusi hukum saat menghadapi kredit macet.', '\nMasalah hutang piutang menjadi salah satu penyebab sengketa paling umum di masyarakat. Tidak sedikit pihak yang kesulitan menagih hutang karena tidak memahami langkah hukum yang tersedia.\n\nLangkah pertama yang perlu dilakukan adalah membuat bukti tertulis, baik berupa perjanjian hutang, kwitansi, atau surat pengakuan hutang. Dokumen ini akan menjadi dasar dalam menagih secara hukum.\n\nJika terjadi gagal bayar, pemberi hutang dapat melakukan somasi atau teguran tertulis sebagai langkah awal penagihan. Ini penting sebelum melanjutkan ke tahap hukum lebih lanjut.\n\nApabila somasi tidak ditanggapi, pemberi hutang dapat mengajukan gugatan perdata ke pengadilan negeri. Di sini, bukti pengakuan hutang dan komunikasi sebelumnya akan diperiksa.\n\nDalam kasus tertentu, pelanggaran hutang dapat dianggap sebagai penipuan dan diproses secara pidana, terutama jika ada unsur itikad buruk sejak awal.\n\nPengajuan permohonan pailit juga menjadi salah satu jalan bagi kreditur jika debitur memiliki banyak hutang dan tidak mampu membayar.\n\nNamun, penyelesaian secara damai tetap lebih disarankan untuk menjaga hubungan baik dan menghemat biaya. Bantuan dari advokat dapat mempercepat penyelesaian dan memastikan hak Anda terpenuhi.\n', 'gambar4.jpeg'),
(5, 3, 'Menangani Kasus Pidana Ringan', 'Langkah awal saat menghadapi tuduhan pidana ringan.', '\nTidak semua kasus pidana berujung pada penahanan atau hukuman berat. Banyak pelanggaran yang tergolong pidana ringan, seperti pencemaran nama baik, perkelahian ringan, atau pencurian kecil.\n\nJika Anda atau seseorang yang Anda kenal terlibat dalam kasus pidana ringan, penting untuk tetap tenang dan memahami hak hukum yang dimiliki. Salah satunya adalah hak untuk mendapatkan pendampingan hukum.\n\nTahap pertama biasanya adalah pemanggilan oleh pihak kepolisian untuk dimintai keterangan. Di sini, peran advokat sangat penting untuk mendampingi agar keterangan tidak memberatkan.\n\nDalam banyak kasus pidana ringan, penyidik bisa menawarkan proses mediasi antar pihak. Jika tercapai kesepakatan damai, maka perkara bisa dihentikan melalui SP3.\n\nPengadilan juga memiliki kewenangan untuk memberikan putusan ringan seperti denda, pembinaan, atau hukuman bersyarat. Namun, hal ini sangat tergantung pada bukti dan argumen hukum yang diajukan.\n\nMeskipun ringan, kasus pidana tetap meninggalkan catatan hukum yang bisa berdampak di masa depan, misalnya dalam proses rekrutmen atau perjalanan ke luar negeri.\n\nOleh karena itu, pendampingan hukum dan penanganan yang cepat menjadi kunci agar kasus tidak berkembang menjadi lebih serius.\n', 'gambar5.jpeg'),
(6, 3, 'Peran Advokat dalam Proses Mediasi', 'Bagaimana advokat membantu proses mediasi keluarga.', '\nMediasi merupakan salah satu bentuk penyelesaian sengketa di luar pengadilan yang kini semakin populer, terutama dalam perkara keluarga seperti perceraian, warisan, atau perebutan hak asuh anak.\n\nDalam proses ini, advokat memainkan peran penting untuk memastikan hak klien tetap terlindungi meski tidak melalui jalur litigasi. Mereka bertindak sebagai juru runding, penasehat hukum, dan wakil klien dalam proses komunikasi.\n\nKeberadaan advokat membantu menyusun argumen dan dokumen yang dibutuhkan dalam proses mediasi. Selain itu, mereka juga memastikan semua kesepakatan dicatat secara legal dan mengikat secara hukum.\n\nTidak jarang, pihak yang tidak didampingi oleh kuasa hukum mengalami kerugian karena kurang memahami dampak jangka panjang dari kesepakatan yang dibuat.\n\nMediasi sering kali menghasilkan solusi win-win yang lebih cepat dan hemat biaya dibandingkan pengadilan. Namun, proses ini tetap memerlukan kepiawaian dalam negosiasi.\n\nDalam kasus keluarga, advokat juga berperan menjaga suasana agar tetap kondusif, apalagi jika sengketa menyangkut anak-anak atau orang tua lanjut usia.\n\nDengan demikian, peran advokat tidak hanya teknis tetapi juga strategis dan emosional dalam membantu klien mencapai penyelesaian yang adil dan berkelanjutan.\n', 'gambar6.jpeg');

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

-- --------------------------------------------------------

--
-- Table structure for table `pembayaran`
--

CREATE TABLE `pembayaran` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `advokat_id` int(11) DEFAULT NULL,
  `layanan_id` int(11) DEFAULT NULL,
  `nama_pelanggan` varchar(255) DEFAULT NULL,
  `email_pelanggan` varchar(255) DEFAULT NULL,
  `metode_pembayaran` varchar(50) DEFAULT NULL,
  `total` decimal(12,2) DEFAULT NULL,
  `status` varchar(50) DEFAULT 'pending',
  `tanggal` datetime DEFAULT current_timestamp(),
  `jenis_konsultasi` varchar(20) DEFAULT NULL,
  `bukti_transfer` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `pembayaran`
--

INSERT INTO `pembayaran` (`id`, `user_id`, `advokat_id`, `layanan_id`, `nama_pelanggan`, `email_pelanggan`, `metode_pembayaran`, `total`, `status`, `tanggal`, `jenis_konsultasi`, `bukti_transfer`) VALUES
(1, NULL, 1, 2, 'azzya', 'azzya@gmail.com', 'Transfer Bank', 650000.00, 'pending', '2025-05-20 20:15:12', 'chat_telepon', NULL),
(2, NULL, 1, 2, 'azzya', 'azzya@gmail.com', 'Transfer Bank', 650000.00, 'pending', '2025-05-20 20:15:18', 'chat_telepon', NULL),
(3, NULL, 1, 2, 'aredz', 'adya@gmail.com', 'E-Wallet', 330000.00, 'pending', '2025-05-20 20:41:32', 'chat', NULL),
(4, NULL, 1, 1, 'artya', 'artya@gmail.com', 'E-Wallet', 530000.00, 'pending', '2025-05-26 10:45:57', 'chat', NULL),
(5, NULL, 1, 1, 'user1', 'user1@gmail.com', 'Transfer Bank', 500000.00, 'pending', '2025-06-03 01:42:57', '', NULL),
(6, NULL, 1, 1, 'user1', 'user1@gmail.com', 'Transfer Bank', 850000.00, 'pending', '2025-06-03 01:43:18', 'chat_telepon', NULL),
(7, NULL, 1, 1, 'user1', 'user1@gmail.com', 'Transfer Bank', 850000.00, 'pending', '2025-06-03 01:44:29', 'chat_telepon', NULL),
(8, 3, 1, 1, 'user1', 'user1@gmail.com', 'Transfer Bank', 850000.00, 'pending', '2025-06-02 20:58:48', 'chat_telepon', NULL),
(9, 3, 1, 1, 'user1', 'user1@gmail.com', 'E-Wallet', 530000.00, 'terverifikasi', '2025-06-02 21:02:04', 'chat', 'bukti_683df755e2410_buktipembayaran.jpeg'),
(10, 3, 1, 1, 'user1', 'user1@gmail.com', 'Transfer Bank', 850000.00, 'pending', '2025-06-02 21:28:13', 'chat_telepon', NULL),
(11, 3, 1, 1, 'user1', 'user1@gmail.com', 'Transfer Bank', 850000.00, 'pending', '2025-06-02 22:49:58', 'chat_telepon', NULL),
(12, 3, 1, 1, 'user1', 'user1@gmail.com', 'Transfer Bank', 850000.00, 'pending', '2025-06-02 22:51:27', 'chat_telepon', NULL),
(13, 3, 1, 1, NULL, NULL, 'bank_transfer', 0.00, 'selesai', '2025-06-03 04:00:19', 'chat_telepon', 'bukti_683e10e390765.jpeg'),
(14, 3, 1, 1, NULL, NULL, 'bank_transfer', 0.00, 'selesai', '2025-06-03 04:11:00', 'chat_telepon', 'bukti_683e1364073d1.jpeg'),
(15, 3, 1, 1, NULL, NULL, 'bank_transfer', 0.00, 'selesai', '2025-06-03 04:12:20', 'chat_telepon', 'bukti_683e13b47af36.jpeg'),
(16, 4, 1, 1, NULL, NULL, 'bank_transfer', 0.00, 'selesai', '2025-06-03 04:23:34', 'chat_telepon', 'bukti_683e1656c47e1.jpeg');

-- --------------------------------------------------------

--
-- Table structure for table `ulasan`
--

CREATE TABLE `ulasan` (
  `id` int(11) NOT NULL,
  `id_advokat` int(11) DEFAULT NULL,
  `layanan` varchar(100) DEFAULT NULL,
  `pesan` text DEFAULT NULL,
  `nama` varchar(100) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `rating` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `ulasan`
--

INSERT INTO `ulasan` (`id`, `id_advokat`, `layanan`, `pesan`, `nama`, `created_at`, `rating`) VALUES
(1, NULL, 'Konsultasi Chat', 'bagus', 'azzya', '2025-05-19 13:16:34', 5),
(2, NULL, 'Konsultasi Chat', 'kurang memuaskan', 'aredz', '2025-05-19 13:16:55', 1),
(3, NULL, 'Layanan Bisnis', 'Lumayan', 'artya', '2025-05-19 13:24:37', 3),
(4, NULL, 'Konsultasi Telepon', 'Buruk sekali', 'araya', '2025-05-19 13:25:15', 1),
(5, NULL, 'Konsultasi Chat', 'Cepat respon', 'adya@gmail.com', '2025-05-19 13:26:52', 4),
(6, NULL, 'Layanan Bisnis', 'Saya sangat terbantu', 'azzya@gmail.com', '2025-05-19 13:28:08', 5),
(7, 1, 'Keluarga', 'bagus', 'azzya', '2025-05-26 08:59:12', 5);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `email` varchar(255) NOT NULL,
  `foto` varchar(255) DEFAULT 'default.png',
  `password` varchar(255) NOT NULL,
  `role` enum('user','admin') DEFAULT 'user',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `nama`, `email`, `foto`, `password`, `role`, `created_at`) VALUES
(1, '', 'azzya@gmail.com', 'anjay.jpeg', '$2y$10$VuRDFBBBrOfmPMo5Y9NVwupSKZ.nw2In0mIZoQZrWaQdUoeQzmmLy', 'user', '2025-05-27 07:44:04'),
(2, '', 'admin@email.com', 'default.png', '$2y$10$Nc.cKiCL4JYmuDjxQUanI.ky1s5Wbns6h1zHdmQAWnXePmChaTxdW', 'admin', '2025-05-29 11:48:07'),
(3, 'user1', 'user1@gmail.com', 'priasigma.jpeg', '$2y$10$m1/IksBcHkb2DPfPsCgnk.dJJzFWH1Ds.IMRcwKAUijgrjCCVBnVy', 'user', '2025-06-02 16:33:08'),
(4, 'user2', 'user2@gmail.com', 'default.png', '$2y$10$QG4w4axCPERqNsUy1uw5auSyF.iH5n5iXAc5tNE1GjwZE7/bxJa/C', 'user', '2025-06-02 21:23:08');

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
-- Indexes for table `pembayaran`
--
ALTER TABLE `pembayaran`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ulasan`
--
ALTER TABLE `ulasan`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_advokat` (`id_advokat`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `advokat`
--
ALTER TABLE `advokat`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `artikel`
--
ALTER TABLE `artikel`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `layanan`
--
ALTER TABLE `layanan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `pembayaran`
--
ALTER TABLE `pembayaran`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `ulasan`
--
ALTER TABLE `ulasan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

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

--
-- Constraints for table `ulasan`
--
ALTER TABLE `ulasan`
  ADD CONSTRAINT `fk_advokat` FOREIGN KEY (`id_advokat`) REFERENCES `advokat` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
