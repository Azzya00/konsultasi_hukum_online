<?php
// Koneksi database
$conn = new mysqli("localhost", "root", "", "layanan_hukum");
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

// Ambil ID Layanan 'Perjanjian Pra-Nikah & Perkawinan' dari database
$layanan_kawin_query = $conn->query("SELECT id FROM layanan WHERE nama_layanan = 'Perjanjian Pra-Nikah & Perkawinan' LIMIT 1"); // <<< GANTI SESUAI NAMA DI DATABASE
$layanan_id_kawin = 0;
if ($layanan_kawin_query && $layanan_kawin_query->num_rows > 0) {
    $layanan_id_kawin = $layanan_kawin_query->fetch_assoc()['id'];
}

// Ambil ID Advokat pertama (contoh saja, sesuaikan kebutuhan Anda)
$advokat_contoh_query = $conn->query("SELECT id FROM advokat LIMIT 1");
$advokat_id_contoh = 0;
if ($advokat_contoh_query && $advokat_contoh_query->num_rows > 0) {
    $advokat_id_contoh = $advokat_contoh_query->fetch_assoc()['id'];
}

if ($layanan_id_kawin == 0) {
    error_log("Layanan 'Perjanjian Pra-Nikah & Perkawinan' tidak ditemukan di database.");
}
if ($advokat_id_contoh == 0) {
    error_log("Tidak ada advokat ditemukan di database.");
}

// Tidak perlu menutup koneksi di sini jika halaman masih butuh koneksi untuk rendering
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SaifulMLaw - Perjanjian Pra-Nikah & Perkawinan</title>
    <style>
        /* CSS yang sama dengan u_opini.php */
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; background-color: #f5f6fa; color: #333; line-height: 1.6; }
        .main-header { background-color: white; padding: 15px 30px; box-shadow: 0 2px 5px rgba(0,0,0,0.1); display: flex; align-items: center; justify-content: space-between; position: relative; }
        .main-header .logo-group { display: flex; align-items: center; }
        .main-header .logo-group img { height: 50px; margin-right: 10px; }
        .main-header .logo-group span { font-weight: bold; font-size: 20px; color: #22026f; }
        .logo { cursor: pointer; transition: opacity 0.3s ease; }
        .logo:hover { opacity: 0.8; }
        .logo img { height: 50px; }
        .back-btn { background: #d39e00; border: none; padding: 10px 15px; border-radius: 5px; font-size: 14px; cursor: pointer; color: white; font-weight: 500; transition: background-color 0.3s ease; text-decoration: none; display: flex; align-items: center; gap: 8px; }
        .back-btn:hover { background-color: #b8890a; }
        .title { font-size: 24px; color: #d39e00; font-weight: bold; position: absolute; left: 50%; transform: translateX(-50%); }
        .container { max-width: 1200px; margin: 0 auto; padding: 30px; display: grid; grid-template-columns: 2fr 1fr; gap: 40px; }
        .main-content { background: white; padding: 40px; border-radius: 10px; box-shadow: 0 3px 15px rgba(0,0,0,0.1); }
        .doc-header { text-align: center; margin-bottom: 40px; }
        .doc-title { font-size: 28px; font-weight: bold; color: #d39e00; margin-bottom: 15px; }
        .doc-subtitle { font-size: 16px; color: #666; margin-bottom: 30px; }
        .case-info { background: #f8f9ff; padding: 25px; border-radius: 8px; margin-bottom: 30px; border-left: 4px solid #d39e00; }
        .case-number { font-size: 18px; font-weight: bold; color: #d39e00; margin-bottom: 10px; }
        .case-details { display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-top: 20px; }
        .detail-item { font-size: 14px; }
        .detail-label { font-weight: bold; color: #333; margin-bottom: 5px; }
        .detail-value { color: #666; }
        .parties { margin: 30px 0; }
        .party { margin-bottom: 25px; }
        .party-type { font-weight: bold; color: #d39e00; font-size: 16px; margin-bottom: 10px; }
        .party-details { background: #f9f9f9; padding: 15px; border-radius: 5px; font-size: 14px; line-height: 1.5; }
        .timeline { margin: 30px 0; }
        .timeline-title { font-size: 18px; font-weight: bold; color: #d39e00; margin-bottom: 20px; }
        .timeline-item { display: flex; gap: 15px; margin-bottom: 15px; padding: 15px; background: #f9f9f9; border-radius: 5px; border-left: 3px solid #ff6b35; }
        .timeline-number { background: #ff6b35; color: white; width: 25px; height: 25px; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-weight: bold; font-size: 12px; flex-shrink: 0; }
        .timeline-content { font-size: 14px; color: #333; }
        .sidebar { display: flex; flex-direction: column; gap: 20px; }
        .sidebar-card { background: white; padding: 25px; border-radius: 10px; box-shadow: 0 3px 15px rgba(0,0,0,0.1); }
        .pesan-dokumen-btn { background: linear-gradient(135deg, #ff6b35, #ff8c42); color: white; border: none; padding: 15px 25px; font-size: 16px; font-weight: bold; border-radius: 8px; cursor: pointer; width: 100%; box-shadow: 0 4px 15px rgba(255, 107, 53, 0.3); transition: all 0.3s ease; text-decoration: none; display: block; text-align: center; }
        .pesan-dokumen-btn:hover { transform: translateY(-2px); box-shadow: 0 6px 20px rgba(255, 107, 53, 0.4); }
        .price-info { text-align: center; margin-bottom: 20px; }
        .price { font-size: 24px; font-weight: bold; color: #d39e00; }
        .consultation-info { font-size: 14px; color: #666; margin-bottom: 20px; }
        .related-links { list-style: none; }
        .related-links li { margin-bottom: 10px; }
        .related-links a { color: #d39e00; text-decoration: none; font-size: 14px; transition: color 0.3s ease; }
        .related-links a:hover { color: #ff6b35; text-decoration: underline; }
        .section-title { font-size: 16px; font-weight: bold; color: #333; margin-bottom: 15px; border-bottom: 2px solid #ff6b35; padding-bottom: 5px; }
        @media (max-width: 768px) { .container { grid-template-columns: 1fr; padding: 20px; } .main-content { padding: 25px; } .case-details { grid-template-columns: 1fr; } .main-header { padding: 10px 20px; } .title { font-size: 20px; } }
        .advokat-section { padding: 40px; background-color: fff; margin-bottom: 2rem; }
        .advokat-list { display: flex; flex-wrap: wrap; gap: 20px; justify-content: center; margin-top:2rem; }
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
            <h1 class="doc-title">Perjanjian Pra-Nikah & Perkawinan</h1>
            <p class="doc-subtitle">Jaga kepentingan Anda dengan perjanjian hukum yang jelas sebelum atau selama pernikahan.</p>
        </div>

        <div class="case-info">
            <p class="case-number">Informasi Umum Layanan</p>
            <div class="case-details">
                <div class="detail-item">
                    <div class="detail-label">Jenis Layanan</div>
                    <div class="detail-value">Penyusunan Perjanjian Pra-Nikah dan Perkawinan</div>
                </div>
                <div class="detail-item">
                    <div class="detail-label">Tujuan</div>
                    <div class="detail-value">Mengatur hak dan kewajiban harta kekayaan pasangan selama pernikahan.</div>
                </div>
                <div class="detail-item">
                    <div class="detail-label">Format Dokumen</div>
                    <div class="detail-value">Dokumen tertulis, diserahkan dalam bentuk digital (Word/PDF).</div>
                </div>
                <div class="detail-item">
                    <div class="detail-label">Waktu Pengerjaan</div>
                    <div class="detail-value">Estimasi 3-5 hari kerja setelah data lengkap diterima.</div>
                </div>
            </div>
        </div>

        <div class="parties">
                <div class="party">
                    <div class="party-type">Pengacara</div>
                    <div class="advokat-list">
                        <?php
                        $result = $conn->query("SELECT * FROM advokat WHERE keahlian LIKE '%Ketenagakerjaan%'");
                        while ($row = $result->fetch_assoc()):
                        ?>
                        <div class="advokat-card">
                            <img src="uploads/<?= $row['foto'] ?>" alt="Foto Advokat">
                            <h3><?= $row['nama'] ?></h3>
                            <p><strong>Keahlian:</strong> <?= $row['keahlian'] ?></p>
                            <p><strong>Pendidikan:</strong> <?= $row['pendidikan'] ?></p>
                            <a href="detail_advokat.php?id=<?= $row['id'] ?>">Lihat Profil</a>
                        </div>
                        <?php endwhile; ?>
                    </div>
                </div>
            </div>
            
        <div class="timeline">
            <h2 class="timeline-title">Bagaimana Kami Membantu?</h2>
            <div class="timeline-item">
                <div class="timeline-number">1</div>
                <div class="timeline-content">
                    <div class="detail-label">Konsultasi Kebutuhan & Tujuan</div>
                    <div class="detail-value">Diskusikan aset, kewajiban, dan tujuan Anda untuk perjanjian.</div>
                </div>
            </div>
            <div class="timeline-item">
                <div class="timeline-number">2</div>
                <div class="timeline-content">
                    <div class="detail-label">Pengumpulan Data & Dokumen</div>
                    <div class="detail-value">Kumpulkan semua informasi relevan terkait harta dan kepentingan masing-masing pihak.</div>
                </div>
            </div>
            <div class="timeline-item">
                <div class="timeline-number">3</div>
                <div class="timeline-content">
                    <div class="detail-label">Penyusunan Draf Perjanjian</div>
                    <div class="detail-value">Tim advokat akan menyusun draf perjanjian sesuai hukum dan kesepakatan Anda.</div>
                </div>
            </div>
            <div class="timeline-item">
                <div class="timeline-number">4</div>
                <div class="timeline-content">
                    <div class="detail-label">Review & Finalisasi</div>
                    <div class="detail-value">Review draf bersama, lakukan revisi jika perlu, lalu finalisasi dokumen.</div>
                </div>
            </div>
        </div>

    </div>

    <div class="sidebar">
        <div class="sidebar-card">
            <div class="price-info">
                <p class="section-title">Biaya Layanan</p>
                <p class="price">Rp. 1.500.000</p> <p class="consultation-info">Harga dapat bervariasi tergantung kompleksitas perjanjian.</p>
            </div>
            <?php if ($advokat_id_contoh > 0 && $layanan_id_kawin > 0): ?>
                <a href="pembayaran.php?advokat_id=<?= htmlspecialchars($advokat_id_contoh) ?>&layanan_id=<?= htmlspecialchars($layanan_id_kawin) ?>" class="pesan-dokumen-btn">
                    Pesan Layanan Ini
                </a>
            <?php else: ?>
                <p style="color: red; text-align: center;">Layanan tidak tersedia. Mohon hubungi admin.</p>
            <?php endif; ?>
        </div>

        <div class="sidebar-card">
            <h3 class="section-title">Layanan Terkait</h3>
            <ul class="related-links">
                <li><a href="k_cerai.php">Gugatan Perceraian</a></li>
                <li><a href="u_kontrak.php">Pembuatan & Analisis Kontrak</a></li>
                <li><a href="u_konsultasi_online.php">Konsultasi Online</a></li>
            </ul>
        </div>
    </div>
</div>

</body>
</html>
<?php
if ($conn) {
    $conn->close();
}
?>