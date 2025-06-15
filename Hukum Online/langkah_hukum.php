<?php
// Database connection
$conn = new mysqli("localhost", "root", "", "layanan_hukum");
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}


?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SaifulMLaw - Layanan Hukum</title>
    <style>
        /* Navbar */
        .navbar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            background: #fff;
            height: 30px;
            padding: 2rem 2rem;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            position: sticky;
            top: 0;
            z-index: 10;
        }

        .navbar .logo img {
            height: 60px;
        }

        .navbar .nav-links {
            display: flex;
            gap: 1.5rem;
            list-style: none;
        }

        .navbar .nav-links a {
            color: #333;
            text-decoration: none;
            font-weight: 500;
        }

        .navbar .nav-links .active a {
            color: #004aad;
        }

        /* Banner */
        .banner {
            min-width: 360px;
            min-height: 372px;
            background-color: #d39e00;
            text-align: center;
            padding: 25px 0px;
            display: flex;
            flex-direction: column;
            align-items: center;
            width: 100%;
        }

        /* Service Sections */
        .services-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 30px;
            margin-bottom: 24px;
        }

        .services-left {
            display: flex;
            flex-direction: column;
            gap: 30px;
        }

        .services-right {
            display: flex;
            flex-direction: column;
            gap: 30px;
        }

        .service-section {
            text-align: left;
        }

        .service-header {
            font-size: 20px;
            display: flex;
            align-items: center;
            margin: 7px 0px 15px;
        }

        /* Modified service items for left alignment */
        .service-items {
            display: flex;
            flex-direction: column;
            gap: 8px;
            margin-top: 19px;
        }

        .service-item {
            display: block;
            width: 100%;
            color: #d39e00;
            font-weight: 700;
            cursor: pointer;
            text-decoration: none;
            transition: color 0.3s;
            padding: 8px 0;
        }

        .service-item:hover {
            color: #b8860b;
        }

        .service-container {
            min-height: 100px;
            padding: 32px 32px 0px;
            max-width: 656px;
            margin: 0px auto;
        }

        /* Contact Section */
        .contact-section {
            display: block;
            max-width: 360px;
            padding: 0px 20px;
            margin: 0px auto;
            text-align: center;
        }

        .contact-section button {
            background-color: #d39e00;
            color: white;
            border: none;
            padding: 12px 24px;
            border-radius: 5px;
            cursor: pointer;
            font-weight: bold;
            margin-top: 15px;
        }

        .contact-section button:hover {
            background-color: #b8860b;
        }

        /* Why Choose Us */
        .why-choose {
            max-width: 656px;
            margin: 20px auto;
            padding: 20px;
            text-align: center;
        }

        .reasons {
            display: flex;
            justify-content: space-around;
            margin-top: 20px;
            gap: 20px;
        }

        .reason-item {
            text-align: center;
            flex: 1;
        }

        .reason-item img {
            margin-bottom: 10px;
        }

        /* Lawyers Section */
        .lawyers-section {
            text-align: left;
            padding: 20px 0px;
            background-color: rgb(249, 249, 249);
            border-bottom: 1px solid rgb(230, 230, 230);
        }

        .lawyers-container {
            width: 100%;
            max-width: 656px;
            margin: 0px auto;
            overflow: hidden;
            height: 314px;
            padding: 27px 0px;
            position: relative;
        }

        /* Footer */
        .footer {
            display: block;
            font-size: 14px;
            font-weight: 300;
            width: 100%;
            background: rgb(68, 68, 68);
            color: rgb(255, 255, 255);
            line-height: 1.5em;
            padding: 30px 24px 20px;
            margin: 0px;
        }

        .footer-content {
            display: flex;
            justify-content: space-between;
            max-width: 656px;
            margin: 0 auto;
            gap: 30px;
        }

        .footer-section {
            flex: 1;
        }

        .footer-section h4 {
            margin-bottom: 15px;
            color: #d39e00;
        }

        .footer-section a {
            display: block;
            color: white;
            text-decoration: none;
            margin-bottom: 8px;
        }

        .footer-section a:hover {
            color: #d39e00;
        }

        .social-icons {
            display: flex;
            gap: 10px;
            margin-top: 10px;
        }

        .social-icons img {
            width: 24px;
            height: 24px;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .services-grid {
                grid-template-columns: 1fr;
                gap: 20px;
            }
            
            .service-item {
                width: 100%;
            }
            
            .reasons {
                flex-direction: column;
                gap: 15px;
            }
            
            .footer-content {
                flex-direction: column;
                gap: 20px;
            }
            
            .navbar .nav-links {
                display: none;
            }
        }

        @media (max-width: 992px) {
            .lawyers-list {
                margin-left: 10px;
            }
        }
    </style>
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar">
        <div class="logo">
            <img src="logo.png" alt="Logo SaifulMLaw">
        </div>
        <ul class="nav-links">
            <li class="active"><a href="index.php">Beranda</a></li>
            <li><a href="langkah_hukum.php">Langkah Hukum</a></li>
            <li><a href="riwayat_konsultasi.php">Riwayat</a></li>
            <li><a href="#">Masuk</a></li>
        </ul>
    </nav>

    <!-- Banner -->
    <div class="banner">
        <img src="image/lhukum.png" alt="Langkah Hukum" style="width: 300px;">
        <h1>Ambil Langkah Hukum yang Tepat untuk Kasus Anda</h1>
        <p>Dapatkan layanan hukum dengan biaya terukur</p>
    </div>

    <!-- Services Container -->
    <div class="service-container">
        <div class="services-grid">
            <div class="services-left">
                <div class="service-section">
                    <h3 class="service-header">
                        <img src="image/dokumen_bisnis.png" style="width:40px; margin-right:10px;">
                        <span>Umum</span>
                    </h3>
                    <div class="service-items">
                        <a href="u_opini.php" class="service-item">Opini Hukum (Legal Opinion)</a>
                        <a href="u_ss.php" class="service-item">Pembuatan Surat Somasi</a>
                        <a href="u_js.php" class="service-item">Pembuatan Jawaban Somasi</a>
                        <a href="u_dokumen.php" class="service-item">Review Dokumen Hukum</a>
                        <a href="u_kontrak.php" class="service-item">Pembuatan Kontrak Kerjasama</a>
                    </div>
                </div>

                <div class="service-section">
                    <h3 class="service-header">
                        <img src="image/perceraian.png" style="width:40px; margin-right:10px;">
                        <span>Keluarga</span>
                    </h3>
                    <div class="service-items">
                        <a href="k_kawin.php" class="service-item">Perjanjian Perkawinan</a>
                        <a href="k_cerai.php" class="service-item">Pembuatan Surat Gugatan Cerai</a>
                        <a href="k_waris.php" class="service-item">Analisis Hak Waris</a>
                        <a href="k_wasiat.php" class="service-item">Pembuatan Surat Wasiat</a>
                    </div>
                </div>
            </div>

            <div class="services-right">
                <div class="service-section">
                    <h3 class="service-header">
                        <img src="image/bisnis.png" style="width:40px; margin-right:10px;">
                        <span>Bisnis</span>
                    </h3>
                    <div class="service-items">
                        <a href="b_retainer.php" class="service-item">Retainer</a>
                        <a href="b_vendor.php" class="service-item">Pembuatan Kontrak Vendor</a>
                        <a href="b_term.php" class="service-item">Pembuatan Ketentuan Layanan (Term & Conditions)</a>
                    </div>
                </div>

                <div class="service-section">
                    <h3 class="service-header">
                        <img src="image/wasiat.png" style="width:40px; margin-right:10px;">
                        <span>Merek</span>
                    </h3>
                    <div class="service-items">
                        <a href="m_daftar.php" class="service-item">Pendaftaran Merek</a>
                    </div>
                </div>

                <div class="service-section">
                    <h3 class="service-header">
                        <img src="image/waris.png" style="width:40px; margin-right:10px;">
                        <span>Perusahaan dan Ketenagakerjaan</span>
                    </h3>
                    <div class="service-items">
                        <a href="p_aturan.php" class="service-item">Pembuatan Peraturan Perusahaan</a>
                        <a href="p_kontrak.php" class="service-item">Pembuatan Kontrak Ketenagakerjaan</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Contact Section -->
    <div class="contact-section">
        <h4>Tidak menemukan layanan langkah hukum yang Anda butuhkan?</h4>
        <p>Hubungi kami untuk kami bantu dapatkan langkah hukum yang Anda butuhkan.</p>
        <button>Hubungi Admin</button>
    </div>

    <!-- Why Choose Us -->
    <div class="why-choose">
        <h4>Mengapa memilih SaifulMLaw?</h4>
        <div class="reasons">
            <div class="reason-item">
                <img src="image/experienced.png" style="width:48px; height:48px;">
                <p>Konsultan hukum berpengalaman</p>
            </div>
            <div class="reason-item">
                <img src="image/affordable.png" style="width:48px; height:48px;">
                <p>Biaya terukur</p>
            </div>
            <div class="reason-item">
                <img src="image/confidential.png" style="width:48px; height:48px;">
                <p>Data terjamin kerahasiaannya</p>
            </div>
        </div>
    </div>

    <!-- Lawyers Section -->
    <div class="lawyers-section">
        <h3>Temui Mitra Konsultan Hukum SaifulMLaw</h3>
        <div class="lawyers-container">
            <!-- Lawyers list would go here -->
        </div>
    </div>

    <!-- Footer -->
    <footer class="footer">
        <div class="footer-content">
            <div class="footer-section">
                <h4>Layanan Konsultasi</h4>
                <a>Konsultasi via Chat</a>
                <a>Konsultasi via Telepon</a>
                <a>Konsultasi Tatap Muka</a>
                <a>Pendampingan Hukum</a>
            </div>
            <div class="footer-section">
                <h4>Info Hukum</h4>
                <h4>Lainnya</h4>
                <a>Tentang kami</a>
                <a>Mitra Advokat</a>
                <a>Cara Pakai</a>
                <a>Syarat dan Ketentuan</a>
            </div>
            <div class="footer-section">
                <h4>Kontak Customer Service:</h4>
                <a href="https://wa.me/6282130007093">WhatsApp</a>
                <h4>Follow kami di</h4>
                <div class="social-icons">
                    <a href="#"><img src="image/instagram.png" alt="Instagram"></a>
                    <a href="#"><img src="image/facebook.png" alt="Facebook"></a>
                    <a href="#"><img src="image/twitter.png" alt="Twitter"></a>
                </div>
            </div>
        </div>
    </footer>
</body>
</html>