<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Layanan Hukum Lainnya</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #fafafa;
            margin: 0;
            padding: 0;
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


        .container {
            padding: 40px 20px;
            display: grid;
            grid-template-columns: repeat(3, 1fr); /* Batas 3 kolom per baris */
            gap: 30px 20px;
            justify-items: center;
        }

        .kategori-item {
            text-align: center;
            text-decoration: none;
            color: black;
            width: 100px;
        }

        .circle-icon {
            width: 70px;
            height: 70px;
            background: #233dc9;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 10px auto;
        }

        .circle-icon img {
            width: 85px;
            height: 85px;
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
        <h2>Semua Layanan</h2>
    </div>
</section>

<div class="container">
    <?php
    $kategori = [
        'Ketenagakerjaan',
        'Wasiat',
        'Waris',
        'Dokumen Bisnis',
        'Bisnis',
        'Perceraian'
    ];

    foreach ($kategori as $nama_kategori):
        $gambar = 'image/' . strtolower(str_replace(' ', '_', $nama_kategori)) . '.png';
    ?>
        <a class="kategori-item" href="kategori_advokat.php?kategori=<?= urlencode($nama_kategori); ?>">
            <div class="circle-icon">
                <img src="<?= $gambar ?>" alt="<?= $nama_kategori ?>">
            </div>
            <?= $nama_kategori ?>
        </a>
    <?php endforeach; ?>
</div>

<!-- Tombol Kembali -->
<div class="back-button">
    <a href="index.php">← Kembali ke Beranda</a>
</div>
</body>
</html>
