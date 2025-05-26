<?php
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
  <title>SaifulMLaw</title>
  <link rel="stylesheet" href="style.css">
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

    /* Hero Section */
    .hero {
      display: flex;
      justify-content: space-between;
      align-items: center;
      padding: 8rem 2rem;
      flex-wrap: wrap;
      background: #d39e00;
      color: #fff;
    }

    .hero-text h1 {
      font-size: 2rem;
      font-weight: bold;
      margin-bottom: 1rem;
    }

    .hero-text p {
      font-size: 1.2rem;
      max-width: 500px;
    }

    .hero-image img {
      max-width: 350px;
      margin-top: 1rem;
      margin-right: 6rem;
    }

    /* Advokat Section */
    .advokat-section {
      padding: 40px;
      background-color: fff;
      margin-bottom: 2rem;
    }

    .advokat-list {
      display: flex;
      flex-wrap: wrap;
      gap: 20px;
      justify-content: center;
      margin-top:2rem;
    }

    .advokat-card {
      background: #fff;
      border: 1px solid #ccc;
      border-radius: 10px;
      width: 280px;
      padding: 20px;
      text-align: center;
    }

    .advokat-card img {
      width: 100px;
      height: 100px;
      border-radius: 50%;
      object-fit: cover;
      margin-bottom: 10px;
    }

    .lihat-semua {
      margin-top: 20px;
      text-align: center;
    }

    .lihat-semua a button {
      padding: 10px 20px;
      font-size: 16px;
      background: #004aad;
      color: white;
      border: none;
      border-radius: 8px;
      cursor: pointer;
    }

    /* Artikel Section */
    .artikel-section {
      padding: 30px 20px;
      background: #fff;
      text-align: center;
    }

    .artikel-container {
      display: flex;
      justify-content: center;
      gap: 20px;
      flex-wrap: wrap;
      margin-top: 30px;
    }

    .artikel-card {
      background: #fff;
      border-radius: 10px;
      box-shadow: 0 4px 8px rgba(0,0,0,0.1);
      width: 300px;
      overflow: hidden;
      text-align: left;
    }

    .artikel-card img {
      width: 100%;
      height: 180px;
      object-fit: cover;
    }

    .artikel-card .content {
      padding: 16px;
    }

    .artikel-card .content h3 {
      font-size: 16px;
      margin: 0 0 10px;
    }

    .artikel-card .content p {
      font-size: 14px;
      color: #666;
      margin-bottom: 6px;
    }

    .artikel-btn {
      margin-top: 30px;
    }

    .artikel-btn a {
      display: inline-block;
      padding: 12px 24px;
      background: #1d3fd0;
      color: #fff;
      border-radius: 8px;
      text-decoration: none;
    }

    .carousel-wrapper {
    position: relative;
    max-width: 1100px;
    margin: auto;
    overflow: hidden;
}

.carousel {
    display: flex;
    transition: transform 0.5s ease;
    gap: 20px;
}

.card {
    min-width: 300px;
    background: white;
    padding: 20px;
    border-radius: 10px;
    box-shadow: 0 4px 12px rgba(0,0,0,0.1);
    flex-shrink: 0;
}

.stars {
    color: #ffc107;
    font-size: 20px;
    margin-bottom: 8px;
}

.pesan {
    font-size: 14px;
    margin: 12px 0;
}

.nama {
    font-size: 13px;
    color: #666;
}

.prev, .next {
    position: absolute;
    top: 50%;
    transform: translateY(-50%);
    background: #004aad;
    color: white;
    border: none;
    padding: 12px;
    font-size: 18px;
    cursor: pointer;
    border-radius: 50%;
    z-index: 1;
}

.prev { left: -5px; }
.next { right: -5px; }

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

  <!-- Hero Section -->
  <section class="hero">
    <div class="hero-text">
      <h1>Butuh bantuan hukum?<br>Jangan Ragu!</h1>
      <p>Kami siap membantu dengan layanan hukum online yang transparan, profesional, dan terjangkau</p>
    </div>
    <div class="hero-image">
      <img src="banner.png" alt="Chatting with Lawyer">
    </div>
  </section>

  <!-- Advokat Section -->
  <section class="advokat-section">
    <h2 style="text-align: center;">60+ Mitra Advokat Pilihan</h2>
    <div class="advokat-list">
      <?php
      $result = $conn->query("SELECT * FROM advokat LIMIT 6");
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
    <div class="lihat-semua">
      <a href="semua_advokat.php">
        <button>Lihat Semua Mitra Advokat</button>
      </a>
    </div>
  </section>

  <!-- Layanan Khusus -->
 <section style="padding: 60px 0; background-color: #f9f9f9;">
    <div style="text-align: center; margin-bottom: 40px;">
        <h2>Layanan Konsultasi Hukum</h2>
    </div>

    <div style="display: flex; justify-content: center; gap: 30px; flex-wrap: wrap;">
        <!-- Kartu Konsultasi Chat -->
        <div style="width: 280px; border: 1px solid #ccc; border-radius: 12px; padding: 20px; background: white; box-shadow: 0 2px 6px rgba(0,0,0,0.1);">
            <img src="chatormes/pesanchat.png" width="40">
            <h4>Konsultasi via Chat</h4>
            <p>Rp30.000 untuk 30 menit</p>
            <ul style="text-align: left;">
                <li>Konsultasi tahap awal</li>
                <li>Advokat dipilihkan oleh sistem</li>
            </ul>
            <a href="semua_advokat.php?jenis=chat" style="display: inline-block; background: #1d3fd0; color: white; padding: 10px 16px; margin-top: 10px; border-radius: 5px;">Pesan Konsultasi</a>
        </div>

        <!-- Kartu Konsultasi Telepon -->
        <div style="width: 280px; border: 1px solid #ccc; border-radius: 12px; padding: 20px; background: white; box-shadow: 0 2px 6px rgba(0,0,0,0.1);">
            <img src="chatormes/pesanpanggilan.png" width="40">
            <h4>Konsultasi via Telepon</h4>
            <p>Rp350.000 untuk 30 menit</p>
            <ul style="text-align: left;">
                <li>Diskusi lebih mendalam</li>
                <li>Bebas pilih advokat dan jadwal</li>
            </ul>
            <a href="semua_advokat.php?jenis=chat_telepon" style="display: inline-block; background: #1d3fd0; color: white; padding: 10px 16px; margin-top: 10px; border-radius: 5px;">Pesan Konsultasi</a>
        </div>
    </div>

    <div style="text-align: center; margin: 60px 0 20px;">
        <h2>Layanan Khusus</h2>
    </div>

    <div style="display: flex; justify-content: center; gap: 40px; flex-wrap: wrap;">
    <?php
    $kategori = [
        'Perceraian', 'Dokumen Bisnis', 'Ketenagakerjaan',
        'Bisnis', 'Waris', 'Wasiat'
    ];
    foreach ($kategori as $k) {
        $file_name = strtolower(str_replace(' ', '_', $k)) . '.png';

        echo '
            <a href="kategori_advokat.php?kategori='.urlencode($k).'" style="text-decoration: none; color: black;">
                <div style="text-align:center;">
                    <div style="width:70px; height:70px; background:#d39e00; border-radius:50%; display:flex; align-items:center; justify-content:center; margin:auto;">
                        <img src="image/'.$file_name.'" width="72" alt="'.$k.'">
                    </div>
                    <div style="margin-top:10px;">'.$k.'</div>
                </div>
            </a>
        ';
    }
    ?>
</div>


    <div style="text-align:center; margin-top:40px;">
        <p>Tidak menemukan layanan hukum yang Anda cari?</p>
        <a href="layanan_lain.php" style="display:inline-block; padding:10px 20px; background:#1d3fd0; color:white; border-radius:5px; margin-top: 10px">Layanan Hukum Lainnya</a>
    </div>
</section>

  <!-- Artikel Panduan Hukum -->
  <section class="artikel-section">
    <h2>Artikel Panduan Hukum</h2>
    <div class="artikel-container">
      <?php
      $artikel = $conn->query("SELECT * FROM artikel ORDER BY id DESC LIMIT 3");
      while ($a = $artikel->fetch_assoc()):
      ?>
        <div class="artikel-card">
          <img src="gambar/<?= $a['gambar'] ?>" alt="<?= $a['judul'] ?>">
          <div class="content">
            <h3><a href="artikel.php?id=<?= $a['id'] ?>" style="text-decoration:none; color:black;">
              <?= $a['judul'] ?>
            </a>
          </h3>
          <p><?= substr(strip_tags($a['isi']), 0, 100) ?>...</p>
            <p style="font-size:13px; color:#888;"><?= $a['kategori'] ?? 'Umum' ?></p>
          </div>
        </div>
      <?php endwhile; ?>
    </div>
    <div class="artikel-btn">
      <a href="semua_artikel.php">Lihat Semua Artikel</a>
    </div>
  </section>

<?php
$conn = new mysqli("localhost", "root", "", "layanan_hukum");
$ulasan = $conn->query("SELECT * FROM ulasan ORDER BY created_at DESC LIMIT 5");
?>

<section id="ulasan-klien" style="padding: 60px 20px; background: #fafafa;">
    <h2 style="text-align:center; font-size: 28px; margin-bottom: 40px;">Ulasan Klien Kami</h2>

    <div class="carousel-wrapper">
        <button class="prev" onclick="moveSlide(-1)">❮</button>
        <div class="carousel" id="carousel">
            <?php while($row = $ulasan->fetch_assoc()): ?>
                <div class="card">
                    <div class="stars"><?= str_repeat('★', (int)$row['rating']); ?></div>
                    <div class="layanan"><strong><?= htmlspecialchars($row['layanan']); ?></strong></div>
                    <p class="pesan"><?= nl2br(htmlspecialchars($row['pesan'])); ?></p>
                    <div class="nama"><?= htmlspecialchars($row['nama']); ?></div>
                </div>
            <?php endwhile; ?>
        </div>
        <button class="next" onclick="moveSlide(1)">❯</button>
    </div>

    <div style="text-align:center; margin-top: 30px;">
        <a href="semua_ulasan.php" style="padding: 10px 20px; background: #004aad; color: white; border-radius: 8px; text-decoration: none;">Lihat Semua Ulasan</a>
    </div>
</section>

<script>
    let currentIndex = 0;
    const carousel = document.getElementById('carousel');
    const cards = document.querySelectorAll('#carousel .card');

    function moveSlide(step) {
        const maxIndex = cards.length - 1;
        currentIndex += step;
        if (currentIndex < 0) currentIndex = 0;
        if (currentIndex > maxIndex) currentIndex = maxIndex;

        const offset = currentIndex * (cards[0].offsetWidth + 20); // 20 = gap
        carousel.style.transform = `translateX(-${offset}px)`;
    }
</script>


</body>
</html>
