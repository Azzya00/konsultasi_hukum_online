<?php
$conn = new mysqli("localhost", "root", "", "layanan_hukum");
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}
// Koneksi database

// Ambil data riwayat
$riwayat = [];

$sql = "SELECT p.*, a.nama AS nama_advokat, l.nama_layanan 
        FROM pembayaran p
        JOIN advokat a ON p.advokat_id = a.id
        JOIN layanan l ON p.layanan_id = l.id
        ORDER BY p.tanggal DESC";

$result = $conn->query($sql);

if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $riwayat[] = [
            'id' => $row['id'],
            'jenis' => $row['jenis_konsultasi'], // 'chat' atau 'chat_telepon'
            'status' => 'selesai', // atau kamu bisa tambahkan field status ke database nanti
            'judul' => $row['nama_layanan'],
            'deskripsi' => 'Dengan advokat: ' . $row['nama_advokat'],
            'tanggal' => $row['tanggal']
        ];
    }
}

?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Riwayat Konsultasi</title>
    <style>
        
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

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            margin: 0;
            padding: 20px;
            background-color: #f5f5f5;
            color: #333;
        }
        .container {
            max-width: 800px;
            margin: 0 auto;
            background: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        h1 {
            color: #2c3e50;
            margin-bottom: 5px;
        }
        .subtitle {
            color: #7f8c8d;
            margin-top: 0;
            margin-bottom: 20px;
        }
        .divider {
            border: 0;
            height: 1px;
            background: #e0e0e0;
            margin: 20px 0;
        }
        .empty-state {
            text-align: center;
            padding: 40px 20px;
            background: #f9f9f9;
            border-radius: 8px;
            margin: 20px 0;
        }
        .btn {
            display: inline-block;
            background: #3498db;
            color: white;
            padding: 10px 20px;
            border-radius: 4px;
            text-decoration: none;
            font-weight: bold;
            margin-top: 15px;
        }
        .riwayat-item {
            padding: 15px;
            border-bottom: 1px solid #eee;
        }
        .riwayat-item:last-child {
            border-bottom: none;
        }
        .badge {
            display: inline-block;
            padding: 3px 8px;
            border-radius: 12px;
            font-size: 12px;
            font-weight: bold;
        }
        .badge-chat {
            background: #e3f2fd;
            color: #1976d2;
        }
        .badge-dokumen {
            background: #e8f5e9;
            color: #388e3c;
        }
        .badge-status {
            background: #fff3e0;
            color: #e65100;
        }
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

    <div class="container">
        <h1>Riwayat Konsultasi</h1>
        <p class="subtitle">Konsultasi Chat • Pembuatan Dokumen</p>
        
        <hr class="divider">

        <?php if (empty($riwayat)): ?>
            <div class="empty-state">
                <h3>Belum Ada Riwayat</h3>
                <p>Pesan Konsultasi Baru untuk mendapatkan solusi hukum masalah Anda dari konsultan hukum SaifulMLaw!</p>
                <a href="#" class="btn">Pesan Konsultasi Baru</a>
            </div>
        <?php else: ?>
            <div class="riwayat-list">
                <?php foreach ($riwayat as $item): ?>
                    <div class="riwayat-item">
                        <span class="badge <?= $item['jenis'] === 'chat' ? 'badge-chat' : 'badge-dokumen' ?>">
                            <?= strtoupper($item['jenis']) ?>
                        </span>
                        <span class="badge badge-status">
                            <?= strtoupper($item['status']) ?>
                        </span>
                        <h3><a href="info_pembayaran.php?id=<?= $item['id'] ?>" style="text-decoration:none; color:#2c3e50;">
    <?= htmlspecialchars($item['judul']) ?>
</a></h3>

                        <p><?= htmlspecialchars($item['deskripsi']) ?></p>
                        <small><?= date('d M Y H:i', strtotime($item['tanggal'])) ?></small>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>
</body>
</html>