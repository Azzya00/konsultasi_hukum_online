<?php
// Koneksi database
$conn = new mysqli("localhost", "root", "", "layanan_hukum");
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

// Ambil ID Layanan 'Opini Hukum' dari database
// Anda harus memastikan ada layanan 'Opini Hukum' di tabel 'layanan'
$layanan_opini_hukum = $conn->query("SELECT id FROM layanan WHERE nama_layanan = 'Konsultasi Bisnis dan Korporat' LIMIT 1")->fetch_assoc();
$layanan_id_opini = $layanan_opini_hukum ? $layanan_opini_hukum['id'] : 0;

// Ambil ID Advokat pertama atau advokat spesifik (contoh saja, sesuaikan kebutuhan Anda)
$advokat_contoh = $conn->query("SELECT id FROM advokat LIMIT 1")->fetch_assoc();
$advokat_id_contoh = $advokat_contoh ? $advokat_contoh['id'] : 0;

// Jika ID tidak ditemukan, mungkin ada baiknya memberi pesan error
if ($layanan_id_opini == 0 || $advokat_id_contoh == 0) {
    //echo "<script>alert('Layanan atau Advokat tidak ditemukan di database.');</script>";
    // Mungkin redirect atau tampilkan pesan di halaman
}

?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SaifulMLaw - Layanan Hukum</title>
    <style>
        /* Tetap sama dengan CSS yang Anda berikan */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f5f6fa;
            color: #333;
            line-height: 1.6;
        }

        /* Perubahan untuk konsistensi header */
        .main-header { /* Ganti .header menjadi .main-header */
            background-color: white;
            padding: 15px 30px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
            display: flex;
            align-items: center;
            justify-content: space-between;
            position: relative;
        }

        .main-header .logo-group { /* Tambahkan ini jika logo dan teks bergabung */
            display: flex;
            align-items: center;
        }
        .main-header .logo-group img { /* Sesuaikan jika perlu */
            height: 50px;
            margin-right: 10px; /* Jarak antara logo dan teks */
        }
        .main-header .logo-group span { /* Untuk teks "SAIFULMLAW" */
            font-weight: bold;
            font-size: 20px;
            color: #22026f;
        }


        .logo { /* Ini bisa dihilangkan atau diganti dengan .logo-group */
            cursor: pointer;
            transition: opacity 0.3s ease;
        }

        .logo:hover {
            opacity: 0.8;
        }

        .logo img {
            height: 50px;
        }

        .back-btn {
            background: #d39e00;
            border: none;
            padding: 10px 15px;
            border-radius: 5px;
            font-size: 14px;
            cursor: pointer;
            color: white;
            font-weight: 500;
            transition: background-color 0.3s ease;
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .back-btn:hover {
            background-color: #b8890a;
        }

        .title {
            font-size: 24px;
            color: #d39e00;
            font-weight: bold;
            position: absolute;
            left: 50%;
            transform: translateX(-50%);
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 30px;
            display: grid;
            grid-template-columns: 2fr 1fr;
            gap: 40px;
        }

        .main-content {
            background: white;
            padding: 40px;
            border-radius: 10px;
            box-shadow: 0 3px 15px rgba(0,0,0,0.1);
        }

        .doc-header {
            text-align: center;
            margin-bottom: 40px;
        }

        .doc-title {
            font-size: 28px;
            font-weight: bold;
            color: #d39e00;
            margin-bottom: 15px;
        }

        .doc-subtitle {
            font-size: 16px;
            color: #666;
            margin-bottom: 30px;
        }

        .case-info {
            background: #f8f9ff;
            padding: 25px;
            border-radius: 8px;
            margin-bottom: 30px;
            border-left: 4px solid #d39e00;
        }

        .case-number {
            font-size: 18px;
            font-weight: bold;
            color: #d39e00;
            margin-bottom: 10px;
        }

        .case-details {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
            margin-top: 20px;
        }

        .detail-item {
            font-size: 14px;
        }

        .detail-label {
            font-weight: bold;
            color: #333;
            margin-bottom: 5px;
        }

        .detail-value {
            color: #666;
        }

        .parties {
            margin: 30px 0;
        }

        .party {
            margin-bottom: 25px;
        }

        .party-type {
            font-weight: bold;
            color: #d39e00;
            font-size: 16px;
            margin-bottom: 10px;
        }

        .party-details {
            background: #f9f9f9;
            padding: 15px;
            border-radius: 5px;
            font-size: 14px;
            line-height: 1.5;
        }

        .timeline {
            margin: 30px 0;
        }

        .timeline-title {
            font-size: 18px;
            font-weight: bold;
            color: #d39e00;
            margin-bottom: 20px;
        }

        .timeline-item {
            display: flex;
            gap: 15px;
            margin-bottom: 15px;
            padding: 15px;
            background: #f9f9f9;
            border-radius: 5px;
            border-left: 3px solid #ff6b35;
        }

        .timeline-number {
            background: #ff6b35;
            color: white;
            width: 25px;
            height: 25px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
            font-size: 12px;
            flex-shrink: 0;
        }

        .timeline-content {
            font-size: 14px;
            color: #333;
        }

        .sidebar {
            display: flex;
            flex-direction: column;
            gap: 20px;
        }

        .sidebar-card {
            background: white;
            padding: 25px;
            border-radius: 10px;
            box-shadow: 0 3px 15px rgba(0,0,0,0.1);
        }

        .pesan-dokumen-btn {
            background: linear-gradient(135deg, #ff6b35, #ff8c42);
            color: white;
            border: none;
            padding: 15px 25px;
            font-size: 16px;
            font-weight: bold;
            border-radius: 8px;
            cursor: pointer;
            width: 100%;
            box-shadow: 0 4px 15px rgba(255, 107, 53, 0.3);
            transition: all 0.3s ease;
            text-decoration: none; /* Penting untuk link */
            display: block; /* Agar mengisi lebar penuh */
            text-align: center;
        }

        .pesan-dokumen-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(255, 107, 53, 0.4);
        }

        .price-info {
            text-align: center;
            margin-bottom: 20px;
        }

        .price {
            font-size: 24px;
            font-weight: bold;
            color: #d39e00;
        }

        .consultation-info {
            font-size: 14px;
            color: #666;
            margin-bottom: 20px;
        }

        .related-links {
            list-style: none;
        }

        .related-links li {
            margin-bottom: 10px;
        }

        .related-links a {
            color: #d39e00;
            text-decoration: none;
            font-size: 14px;
            transition: color 0.3s ease;
        }

        .related-links a:hover {
            color: #ff6b35;
            text-decoration: underline;
        }

        .section-title {
            font-size: 16px;
            font-weight: bold;
            color: #333;
            margin-bottom: 15px;
            border-bottom: 2px solid #ff6b35;
            padding-bottom: 5px;
        }

        @media (max-width: 768px) {
            .container {
                grid-template-columns: 1fr;
                padding: 20px;
            }

            .main-content {
                padding: 25px;
            }

            .case-details {
                grid-template-columns: 1fr;
            }

            .main-header { /* Sesuaikan untuk media query */
                padding: 10px 20px;
            }

            .title {
                font-size: 20px;
            }
        }
        .advokat-section {
            padding: 40px;
            background-color: fff;
            margin-bottom: 2rem;
        }

        .advokat-list { /* CSS tambahan yang mungkin belum lengkap dari file Anda */
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
            justify-content: center;
            margin-top:2rem;
        }
    </style>
</head>
<body>

<nav class="main-header">
    <div class="logo-group">
        <img src="logo.png" alt="Logo">
        <span>SAIFULMLAW</span>
    </div>
    <a href="#" onclick="history.back(); return false;" class="back-btn">
        &larr; Kembali
    </a>
</nav>

<div class="container">
    <div class="main-content">
        <div class="doc-header">
            <h1 class="doc-title">Opini Hukum</h1>
            <p class="doc-subtitle">Dapatkan pandangan profesional dan solusi hukum untuk kasus Anda.</p>
        </div>

        <div class="case-info">
            <p class="case-number">Informasi Umum Layanan</p>
            <div class="case-details">
                <div class="detail-item">
                    <div class="detail-label">Jenis Layanan</div>
                    <div class="detail-value">Penulisan Opini Hukum</div>
                </div>
                <div class="detail-item">
                    <div class="detail-label">Tujuan</div>
                    <div class="detail-value">Memberikan pandangan hukum mendalam atas suatu permasalahan atau kasus.</div>
                </div>
                <div class="detail-item">
                    <div class="detail-label">Format Dokumen</div>
                    <div class="detail-value">Dokumen tertulis, diserahkan dalam bentuk PDF.</div>
                </div>
                <div class="detail-item">
                    <div class="detail-label">Waktu Pengerjaan</div>
                    <div class="detail-value">Estimasi 3-5 hari kerja setelah data lengkap diterima.</div>
                </div>
            </div>
        </div>

        <div class="timeline">
            <h2 class="timeline-title">Bagaimana Kami Membantu?</h2>
            <div class="timeline-item">
                <div class="timeline-number">1</div>
                <div class="timeline-content">
                    <div class="detail-label">Sampaikan Permasalahan Anda</div>
                    <div class="detail-value">Jelaskan secara rinci kasus atau permasalahan hukum yang Anda hadapi.</div>
                </div>
            </div>
            <div class="timeline-item">
                <div class="timeline-number">2</div>
                <div class="timeline-content">
                    <div class="detail-label">Analisis Mendalam</div>
                    <div class="detail-value">Tim advokat kami akan melakukan analisis hukum, riset peraturan, dan yurisprudensi terkait kasus Anda.</div>
                </div>
            </div>
            <div class="timeline-item">
                <div class="timeline-number">3</div>
                <div class="timeline-content">
                    <div class="detail-label">Penyusunan Opini Hukum</div>
                    <div class="detail-value">Kami akan menyusun opini hukum tertulis yang komprehensif, mencakup analisis, kesimpulan, dan rekomendasi solusi.</div>
                </div>
            </div>
            <div class="timeline-item">
                <div class="timeline-number">4</div>
                <div class="timeline-content">
                    <div class="detail-label">Penyerahan Dokumen</div>
                    <div class="detail-value">Opini hukum akan diserahkan kepada Anda dalam format digital yang siap digunakan.</div>
                </div>
            </div>
        </div>

    </div>

    <div class="sidebar">
        <div class="sidebar-card">
            <div class="price-info">
                <p class="section-title">Biaya Layanan</p>
                <p class="price">Rp. 1.500.000</p>
                <p class="consultation-info">Harga ini belum termasuk biaya konsultasi mendalam (telepon/chat).</p>
            </div>
            <?php if ($advokat_id_contoh > 0 && $layanan_id_opini > 0): ?>
                <a href="pembayaran.php?advokat_id=<?= htmlspecialchars($advokat_id_contoh) ?>&layanan_id=<?= htmlspecialchars($layanan_id_opini) ?>" class="pesan-dokumen-btn">
                    Pesan Dokumen Tersebut
                </a>
            <?php else: ?>
                <p style="color: red; text-align: center;">Layanan tidak tersedia. Mohon hubungi admin.</p>
            <?php endif; ?>
        </div>

        <div class="sidebar-card">
            <h3 class="section-title">Layanan Terkait</h3>
            <ul class="related-links">
                <li><a href="#">Konsultasi Online</a></li>
                <li><a href="#">Pembuatan Gugatan/Surat</a></li>
                <li><a href="#">Analisis Kontrak</a></li>
                <li><a href="#">Pendampingan Hukum</a></li>
            </ul>
        </div>
    </div>
</div>

</body>
</html>