<?php
$kategori = $_GET['kategori'] ?? '';

$conn = new mysqli("localhost", "root", "", "layanan_hukum");
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

$sql = "SELECT * FROM advokat WHERE keahlian LIKE '%$kategori%'";
$data = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Advokat - Kategori <?= htmlspecialchars($kategori); ?></title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0px;
            background: #f8f8f8;
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

        .advokat-list {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            gap: 25px;
        }

        .advokat-card {
            background: #fff;
            border-radius: 10px;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.1);
            width: 260px;
            padding: 20px;
            text-align: center;
        }

        .advokat-card img {
            width: 100px;
            height: 100px;
            border-radius: 50%;
            object-fit: cover;
            margin-bottom: 10px;
            border: 2px solid #ddd;
        }

        .advokat-card h4 {
            margin: 10px 0 5px;
        }

        .advokat-card p {
            font-size: 14px;
            color: #555;
        }

        .advokat-card a {
            display: inline-block;
            margin-top: 10px;
            text-decoration: none;
            color: white;
            background: #004aad;
            padding: 8px 12px;
            border-radius: 6px;
            font-size: 14px;
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

<section class="hero-advokat">
    <div class="hero-content">
        <img src="logo.png" alt="Logo SaifulMLaw" class="logo">
        <h2>Daftar Advokat Kategori: <?= htmlspecialchars($kategori); ?></h2>
    </div>
</section>
</div>

<div class="advokat-list">
    <?php while ($a = $data->fetch_assoc()): ?>
        <div class="advokat-card">
            <img src="uploads/<?= $a['foto'] ?>" alt="Foto Advokat">
            <h4><?= $a['nama']; ?></h4>
            <p><?= $a['keahlian']; ?></p>
            <a href="detail_advokat.php?id=<?= $a['id'] ?>">Lihat Profil</a>
        </div>
    <?php endwhile; ?>
</div>

<!-- Tombol Kembali -->
<div class="back-button">
    <a href="index.php">← Kembali ke Beranda</a>
</div>
</body>
</html>
