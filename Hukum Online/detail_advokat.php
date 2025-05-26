<?php
$host = "localhost";
$user = "root";
$pass = "";
$db   = "layanan_hukum";

$conn = new mysqli($host, $user, $pass, $db);
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

$id = $_GET['id'] ?? 0;
$advokat = $conn->query("SELECT * FROM advokat WHERE id = $id")->fetch_assoc();
$artikel = $conn->query("SELECT * FROM artikel WHERE advokat_id = $id");
$layanan = $conn->query("SELECT * FROM layanan WHERE advokat_id = $id");
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Profil Advokat - <?= $advokat['nama'] ?></title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: Arial, sans-serif;
        }

        .hero-advokat {
            background-color: #d29e00;
            color: white;
            padding: 12px 10px;
        }

        .hero-content {
            display: flex;
            align-items: center;
            gap: 20px;
            max-width: 1500px;
            margin: 0 auto;
        }

        .hero-content img.logo {
            height: 50px;
            width: auto;
        }

        .hero-content h2 {
            font-size: 20px;
            font-weight: 500;
        }

        .profile {
            display: flex;
            flex-direction: column;
            align-items: center;
            margin-top: 30px;
            margin-bottom: 40px;
        }

        .foto {
            width: 120px;
            height: 120px;
            object-fit: cover;
            border-radius: 50%;
            border: 3px solid white;
            margin-bottom: 15px;
        }

        .section {
            padding: 30px 40px;
        }

        .artikel .advokat-list {
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
            justify-content: center;
        }

        .advokat-card {
            background: #fff;
            border: 1px solid #ccc;
            border-radius: 10px;
            width: 280px;
            padding: 20px;
            text-align: center;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }

        .advokat-card img {
            width: 100%;
            height: 160px;
            object-fit: cover;
            border-radius: 8px;
            margin-bottom: 10px;
        }

        .advokat-card h4 {
            margin-bottom: 10px;
            color: #333;
        }

        .advokat-card p {
            color: #555;
            font-size: 14px;
        }

        .layanan-list {
            display: flex;
            gap: 20px;
            flex-wrap: wrap;
            justify-content: center;
        }

        .layanan-card {
            background: #fff;
            border: 1px solid #ccc;
            border-radius: 10px;
            width: 280px;
            padding: 20px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }

        .layanan-card h4 {
            font-size: 16px;
            margin-bottom: 8px;
            color: #222;
        }

        .layanan-card p {
            font-size: 14px;
            color: #444;
        }

        .button-primary {
    background: #004aad;
    color: white;
    padding: 12px 24px;
    border: none;
    border-radius: 8px;
    font-size: 16px;
    cursor: pointer;
    text-decoration: none;
}

        .ulasan-container {
    display: flex;
    flex-wrap: wrap;
    justify-content: center;
    gap: 20px;
    margin-top: 20px;
}

.ulasan-card {
    background: #ffffff;
    border: 1px solid #ddd;
    border-radius: 10px;
    width: 260px;
    padding: 15px 20px;
    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.08);
    display: flex;
    flex-direction: column;
    justify-content: space-between;
}

.ulasan-card .rating {
    font-size: 18px;
    color: #ffc107;
    margin-bottom: 10px;
}

.ulasan-card h4 {
    font-size: 16px;
    color: #333;
    margin-bottom: 8px;
}

.ulasan-card p {
    font-size: 14px;
    color: #555;
    margin-bottom: 12px;
}

.ulasan-card .nama {
    font-size: 13px;
    color: #888;
    text-align: right;
}

        .back-button {
            text-align: center;
            margin: 40px 0;
        }

        .back-button a {
            text-decoration: none;
            color: white;
            background: #004aad;
            padding: 10px 20px;
            border-radius: 6px;
            font-weight: bold;
        }
    </style>
</head>
<body>

<!-- Hero / Box Kuning dengan Logo & Judul -->
<section class="hero-advokat">
    <div class="hero-content">
        <img src="logo.png" alt="Logo" class="logo">
        <h2>Profil Advokat</h2>
    </div>
</section>

<!-- Profile Advokat -->
<div class="profile">
    <img class="foto" src="uploads/<?= $advokat['foto'] ?>" alt="Foto Advokat">
    <h3><?= $advokat['nama'] ?></h3>
    <p><strong>Pendidikan:</strong> <?= $advokat['pendidikan'] ?></p>
    <p><strong>Keahlian:</strong> <?= $advokat['keahlian'] ?></p>
    <p><strong>Pengalaman:</strong> <?= $advokat['pengalaman'] ?></p>
</div>

<!-- Artikel Section -->
<section class="section artikel">
    <h3 style="text-align: center; margin-bottom: 20px;">Artikel Terkait</h3>
    <div class="advokat-list">
        <?php while ($a = $artikel->fetch_assoc()): ?>
            <div class="advokat-card">
                <img src="gambar/<?= $a['gambar'] ?>" alt="<?= $a['judul'] ?>">
                <h4>
                    <a href="artikel.php?id=<?= $a['id'] ?>" style="color: #004aad; text-decoration: none;">
                        <?= $a['judul'] ?>
                    </a>
                </h4>
                <p><?= substr($a['isi'], 0, 120) ?>...</p>
            </div>
        <?php endwhile; ?>
    </div>
</section>

<!-- Layanan Section -->
<section class="section layanan">
    <h3 style="text-align: center; margin-bottom: 20px;">Layanan yang Ditawarkan</h3>
    <div class="layanan-list">
        <?php while ($l = $layanan->fetch_assoc()): ?>
            <div class="layanan-card">
                <h4><?= $l['nama_layanan'] ?> - Rp<?= number_format($l['harga'], 0, ',', '.') ?></h4>
                <p><?= $l['deskripsi'] ?></p>

                <form action="pembayaran.php" method="GET">
                    <input type="hidden" name="advokat_id" value="<?= $advokat['id'] ?>">
                    <input type="hidden" name="layanan_id" value="<?= $l['id'] ?>">
                    <input type="hidden" name="harga_layanan" value="<?= $l['harga'] ?>">
                    <input type="hidden" name="harga_konsultasi" value="350000">
                    <button type="submit" style="margin-top:10px; background:#004aad; color:white; padding:8px 16px; border:none; border-radius:5px;">Pesan Sekarang</button>
                </form>
            </div>
        <?php endwhile; ?>
    </div>
</section>

<!-- Tombol Berikan Ulasan -->
<div style="text-align: center; margin-top: 40px;">
    <a href="ulasan_advokat.php?id=<?= $advokat['id'] ?>" style="text-decoration: none;">
        <button style="background: #004aad; color: white; padding: 12px 24px; border: none; border-radius: 8px; font-size: 16px; cursor: pointer;">
            Berikan Ulasan
        </button>
    </a>
</div>

<!-- Ulasan -->
<section class="section ulasan">
    <h3 style="text-align: center; margin-bottom: 20px;">Ulasan Klien</h3>
    <div class="ulasan-container">
        <?php
        $ulasan = $conn->query("SELECT * FROM ulasan WHERE id_advokat = $id ORDER BY id DESC");
        if ($ulasan->num_rows > 0):
            while ($u = $ulasan->fetch_assoc()):
        ?>
            <div class="ulasan-card">
                <div class="rating"><?= str_repeat("⭐", (int)$u['rating']) ?></div>
                <h4><?= htmlspecialchars($u['layanan']) ?></h4>
                <p><?= htmlspecialchars($u['pesan']) ?></p>
                <span class="nama"><?= htmlspecialchars($u['nama']) ?></span>
            </div>
        <?php endwhile; else: ?>
            <p style="text-align: center; color: #777;">Belum ada ulasan untuk advokat ini.</p>
        <?php endif; ?>
    </div>
</section>

<!-- Tombol Kembali -->
<div class="back-button">
    <a href="index.php">← Kembali ke Beranda</a>
</div>

</body>
</html>
