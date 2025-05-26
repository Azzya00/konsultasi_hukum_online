<?php
$conn = new mysqli("localhost", "root", "", "layanan_hukum");
$ulasan = $conn->query("SELECT * FROM ulasan ORDER BY id DESC");
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Semua Ulasan Klien</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            padding: 40px;
            background: #f4f4f4;
        }

        h2 {
            text-align: center;
            margin-bottom: 40px;
        }

        .ulasan-list {
            max-width: 800px;
            margin: auto;
        }

        .ulasan-item {
            background-color: #fff;
            padding: 20px 25px;
            margin-bottom: 20px;
            border-left: 5px solid #004aad;
            border-radius: 8px;
            box-shadow: 0 1px 5px rgba(0,0,0,0.05);
        }

        .ulasan-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 10px;
        }

        .ulasan-layanan {
            font-weight: bold;
            font-size: 16px;
            color: #004aad;
        }

        .ulasan-rating {
            color: #ffc107;
            font-size: 18px;
        }

        .ulasan-pesan {
            margin: 10px 0;
            line-height: 1.6;
            font-size: 15px;
            color: #333;
        }

        .ulasan-nama {
            text-align: right;
            font-size: 13px;
            color: #777;
        }

        .tambah-ulasan {
            margin-top: 40px;
            text-align: center;
        }

        .tambah-ulasan a button {
            padding: 10px 20px;
            background: #004aad;
            color: white;
            border: none;
            border-radius: 8px;
            font-size: 16px;
            cursor: pointer;
        }

    </style>
</head>
<body>

<div class="header-kuning">
  <div class="header-wrapper">
    <img src="logo.png" alt="Logo SaifulMLaw">
    <h1>Semua Ulasan Klien</h1>
  </div>
</div>


<div class="ulasan-list">
    <?php while ($row = $ulasan->fetch_assoc()): ?>
        <div class="ulasan-item">
            <div class="ulasan-header">
                <div class="ulasan-layanan"><?= htmlspecialchars($row['layanan']) ?></div>
                <div class="ulasan-rating">
                    <?= str_repeat('★', $row['rating']) ?>
                    <?= str_repeat('☆', 5 - $row['rating']) ?>
                </div>
            </div>
            <div class="ulasan-pesan"><?= nl2br(htmlspecialchars($row['pesan'])) ?></div>
            <div class="ulasan-nama">— <?= htmlspecialchars($row['nama']) ?></div>
        </div>
    <?php endwhile; ?>
</div>

<div class="tambah-ulasan">
    <a href="tambah_ulasan.php">
        <button>Tambah Ulasan Baru</button>
    </a>
</div>

<!-- Tombol Kembali -->
<div class="back-button">
    <a href="index.php">← Kembali ke Beranda</a>
</div>

</body>
</html>
