<?php
$conn = new mysqli("localhost", "root", "", "layanan_hukum");
$semua = $conn->query("SELECT * FROM artikel ORDER BY id DESC");
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Semua Artikel</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            background: #f9f9f9;
        }

        .header-kuning {
            background-color: #d29e00;
            padding: 12px 20px;
            color: white;
            text-align: center;
            margin-bottom: 30px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
            width: 100%;
            box-sizing: border-box;
        }

        .header-kuning img {
            height: 40px;
            vertical-align: middle;
            margin-right: 10px;
        }

        .header-wrapper {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            flex-wrap: wrap;
        }

        .main-content {
            padding: 20px;
            max-width: 1200px;
            margin: 0 auto;
        }

        h2 {
            text-align: center;
            margin-bottom: 40px;
        }

        .grid {
            display: flex;
            flex-wrap: wrap;
            gap: 30px;
            justify-content: center;
        }

        .card {
            width: 280px;
            background: white;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            overflow: hidden;
            transition: transform 0.2s ease;
        }

        .card:hover {
            transform: translateY(-5px);
        }

        .card img {
            width: 100%;
            height: 160px;
            object-fit: cover;
        }

        .card-body {
            padding: 15px;
        }

        .card-body a {
            text-decoration: none;
            color: black;
            font-weight: bold;
            font-size: 16px;
        }

        .card-body p {
            font-size: 14px;
            color: #555;
            margin-top: 10px;
        }

        .card-body .kategori {
            font-size: 13px;
            color: gray;
            margin-top: 10px;
        }

        .back-button {
            text-align: center;
            margin: 40px 0 20px;
        }

        .back-button a {
            text-decoration: none;
            color: white;
            background: #004aad;
            padding: 10px 20px;
            border-radius: 6px;
            font-weight: bold;
            display: inline-block;
        }

        @media (max-width: 768px) {
            .card {
                width: 100%;
            }

            .header-wrapper {
                flex-direction: column;
            }

            .header-kuning {
                padding: 20px 15px;
            }
        }
    </style>
</head>
<body>

<div class="header-kuning">
    <div class="header-wrapper">
        <img src="logo.png" alt="Logo SaifulMLaw">
        <h1>Semua Artikel</h1>
    </div>
</div>

<div class="main-content">
    <div class="grid">
        <?php while ($a = $semua->fetch_assoc()): ?>
            <div class="card">
                <img src="gambar/<?= $a['gambar'] ?>" alt="<?= htmlspecialchars($a['judul']) ?>">
                <div class="card-body">
                    <a href="artikel.php?id=<?= $a['id'] ?>"><?= htmlspecialchars($a['judul']) ?></a>
                    <p><?= substr(strip_tags($a['isi']), 0, 100) ?>...</p>
                    <div class="kategori"><?= htmlspecialchars($a['kategori'] ?? 'Umum') ?></div>
                </div>
            </div>
        <?php endwhile; ?>
    </div>

    <div class="back-button">
        <a href="index.php">← Kembali ke Beranda</a>
    </div>
</div>

</body>
</html>
