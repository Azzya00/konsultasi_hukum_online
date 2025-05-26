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
        
        .header {
            background-color: white;
            padding: 15px 30px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
            display: flex;
            align-items: center;
            justify-content: space-between;
            position: relative;
        }
        
        .logo {
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
            
            .header {
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

        .advokat-list {
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
            justify-content: space-between;
            margin-top: 2rem;
        }

        .advokat-card {
            background: #fff;
            border: 1px solid #ddd;
            border-radius: 10px;
            width: calc(50% - 10px);
            padding: 20px;
            text-align: center;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .advokat-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 4px 15px rgba(0,0,0,0.15);
        }

        .advokat-card:nth-child(3) {
            width: 100%;
            max-width: calc(50% - 10px);
            margin: 0 auto;
        }

        .advokat-card img {
            width: 80px;
            height: 80px;
            border-radius: 50%;
            object-fit: cover;
            margin-bottom: 15px;
            border: 3px solid #d39e00;
        }

        .advokat-card h3 {
            color: #d39e00;
            font-size: 18px;
            margin-bottom: 10px;
            font-weight: bold;
        }

        .advokat-card p {
            font-size: 14px;
            color: #666;
            margin-bottom: 8px;
            line-height: 1.4;
        }

        .advokat-card a {
            color: #ff6b35;
            text-decoration: none;
            font-weight: bold;
            font-size: 14px;
            display: inline-block;
            margin-top: 10px;
            padding: 8px 15px;
            border: 2px solid #ff6b35;
            border-radius: 5px;
            transition: all 0.3s ease;
        }

        .advokat-card a:hover {
            background-color: #ff6b35;
            color: white;
        }

        @media (max-width: 768px) {
            .advokat-card {
                width: 100%;
            }
            
            .advokat-card:nth-child(3) {
                width: 100%;
                max-width: none;
            }
        }
    
    </style>
</head>
<body>
    <div class="header">
        <div class="logo" onclick="goToHome()">
            <img src="logo.png" alt="Logo SaifulMLaw">
        </div>
        <div class="title">Perjanjian Perkawinan</div>
        <a href="langkah_hukum.php" class="back-btn">
            ← Kembali
        </a>
    </div>

    
    <div class="container">
        <div class="main-content">
            <div class="doc-header">
                <p class="doc-subtitle">Perjanjian perkawinan berisikan tentang kesepakatan tertulis pasangan suami dan istri, perjanjian yang dikenal sebagai tanda cinta tercatat ini bisa disusun pada saat atau selama pernikahan berlangsung.</p>
            </div>
            
            <div class="case-info">
                <div class="case-number">Perkara dalam Rp.xxx</div>
                
                <div class="case-details">
                    <div class="detail-item">
                        <div class="detail-label">(^O^) (T^T)</div>
                    </div>
                    <div class="detail-item">
                        <div class="detail-label">Instansi / Lembaga Hukum :</div>
                        <div class="detail-value">+62 8xxx<br>DEPAN | Website: xx:xx - xx:xx WIB</div>
                    </div>
                </div>
            </div>
            
            <div class="parties">
                <div class="party">
                    <div class="party-type">Pengacara</div>
                    <div class="advokat-list">
                        <?php
                        $result = $conn->query("SELECT * FROM advokat LIMIT 3");
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
                <div class="timeline-title">Tahapan Konsultasi</div>
                
                <div class="timeline-item">
                    <div class="timeline-number">1</div>
                    <div class="timeline-content">
                     Mengajukan dokumen dan persyaratan awal untuk proses konsultasi hukum
                    </div>
                </div>
                
                <div class="timeline-item">
                    <div class="timeline-number">2</div>
                    <div class="timeline-content">
                     Verifikasi dan review dokumen yang telah diserahkan
                    </div>
                </div>
                
                <div class="timeline-item">
                    <div class="timeline-number">3</div>
                    <div class="timeline-content">
                     Analisis kasus dan penyusunan strategi hukum yang tepat
                    </div>
                </div>
                
                <div class="timeline-item">
                    <div class="timeline-number">4</div>
                    <div class="timeline-content">
                     Konsultasi dan diskusi mengenai opsi-opsi hukum yang tersedia
                    </div>
                </div>
                
                <div class="timeline-item">
                    <div class="timeline-number">5</div>
                    <div class="timeline-content">
                     Penyusunan dan persiapan dokumen hukum yang diperlukan
                    </div>
                </div>
                
                <div class="timeline-item">
                    <div class="timeline-number">6</div>
                    <div class="timeline-content">
                     Finalisasi dokumen dan penyerahan hasil konsultasi hukum
                    </div>
                </div>
            </div>
            
            <div class="section-title">Riwayat Langkah yang ditutup</div>
            <ol style="margin-left: 20px; margin-bottom: 20px;">
                <li>Konsultasi awal dan analisis kasus</li>
                <li>Pengumpulan dokumen dan bukti pendukung</li>
                <li>Review dan verifikasi kelengkapan berkas</li>
            </ol>
            
            <div class="section-title">Riwayat Langkah yang belum ditutup</div>
            <ol style="margin-left: 20px;">
                <li>Penyusunan opini hukum final</li>
                <li>Validasi dan finalisasi dokumen</li>
            </ol>
        </div>
        
        <div class="sidebar">
            <div class="sidebar-card">
                <div class="price-info">
                    <div class="price">Rp.xxx</div>
                </div>
                <button class="pesan-dokumen-btn" onclick="pesanDokumen()">
                    Pesan Dokumen
                </button>
            </div>
        </div>
    </div>
    
    <script>
        function goToHome() {
            window.location.href = 'index.php';
        }
        
        function pesanDokumen() {
            if (confirm('Apakah Anda ingin melanjutkan pemesanan dokumen hukum ini dengan biaya Rp.xxx?')) {
                alert('Terima kasih! Anda akan dihubungi untuk proses selanjutnya.');
            }
        }
        
        function openLink(type) {
            alert(`Membuka halaman ${type}`);
        }
        
        // Add smooth scrolling for better UX
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    target.scrollIntoView({
                        behavior: 'smooth'
                    });
                }
            });
        });
        
        // Add loading animation for buttons
        document.querySelectorAll('button').forEach(button => {
            button.addEventListener('click', function() {
                this.style.transform = 'scale(0.95)';
                setTimeout(() => {
                    this.style.transform = '';
                }, 150);
            });
        });
    </script>
</body>
</html>