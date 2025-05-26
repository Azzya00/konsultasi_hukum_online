<?php
// Koneksi ke database
$conn = new mysqli("localhost", "root", "", "layanan_hukum");

// Cek koneksi
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

// Ambil parameter dari URL
$jenis = $_GET['jenis'] ?? 'semua';

// Query data advokat
if ($jenis === 'semua') {
    $result = $conn->query("SELECT * FROM advokat");
} else {
    $stmt = $conn->prepare("SELECT * FROM advokat WHERE jenis_konsultasi = ?");
    $stmt->bind_param("s", $jenis);
    $stmt->execute();
    $result = $stmt->get_result();
}
?>



<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Pilih Mitra Advokat</title>
  <link rel="stylesheet" href="style.css">
  <style>
    body {
      font-family: Arial, sans-serif;
      margin: 0;
      padding: 0;
    }

    /* Header kuning di bagian atas */
    .header-kuning {
      background-color: #d29e00;
      padding: 12px 10px;
      color: white;
      text-align: center;
      margin-bottom: 30px;
      box-shadow: 0 2px 5px rgba(0,0,0,0.1);
    }

    .header-wrapper {
      display: flex;
            align-items: center;
            gap: 20px;
            max-width: 1500px;
            margin: 0 auto;
    }

    .header-wrapper img {
      height: 55px;
    }

    .header-wrapper h1 {
      font-size: 20px;
      font-weight: 500;
      margin: 0;
    }

    .advokat-section {
      padding: 40px;
      background-color: #f9f9f9;
    }

    .advokat-list {
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
      transition: 0.3s ease;
    }

    .advokat-card:hover {
      box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
    }

    .advokat-card img {
      width: 100px;
      height: 100px;
      border-radius: 50%;
      object-fit: cover;
      margin-bottom: 10px;
    }

    .advokat-card h3 {
      font-size: 18px;
      margin: 10px 0;
    }

    .advokat-card p {
      font-size: 14px;
      color: #555;
      margin: 5px 0;
    }

    .advokat-card a {
      display: inline-block;
      margin-top: 10px;
      color: #004aad;
      text-decoration: none;
      font-weight: bold;
    }

    .advokat-card a:hover {
      text-decoration: underline;
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

<!-- Header Kuning -->
<div class="header-kuning">
  <div class="header-wrapper">
    <img src="logo.png" alt="Logo SaifulMLaw">
    <h1>Pilih Mitra Advokat</h1>
  </div>
</div>

<!-- Daftar Advokat -->
<section class="advokat-section">
  <div class="advokat-list">
    <?php while ($row = $result->fetch_assoc()): ?>
      <div class="advokat-card">
        <img src="uploads/<?= htmlspecialchars($row['foto']) ?>" alt="Foto Advokat">
        <h3><?= htmlspecialchars($row['nama']) ?></h3>
        <p><strong>Keahlian:</strong> <?= htmlspecialchars($row['keahlian']) ?></p>
        <p><strong>Pendidikan:</strong> <?= htmlspecialchars($row['pendidikan']) ?></p>
        <a href="detail_advokat.php?id=<?= $row['id'] ?>">Lihat Profil</a>
      </div>
    <?php endwhile; ?>
  </div>
</section>

<!-- Tombol Kembali -->
<div class="back-button">
    <a href="index.php">← Kembali ke Beranda</a>
</div>
</body>
</html>
