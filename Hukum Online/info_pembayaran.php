<?php
$conn = new mysqli("localhost", "root", "", "layanan_hukum");
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

if (!isset($_GET['id'])) {
    echo "ID pembayaran tidak ditemukan.";
    exit;
}

$id = intval($_GET['id']);

$sql = "SELECT * FROM pembayaran WHERE id = $id";
$result = $conn->query($sql);

if ($result->num_rows == 0) {
    echo "Data pembayaran tidak ditemukan.";
    exit;
}

$pembayaran = $result->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Informasi Pembayaran</title>
</head>
<body>
    <h1>Informasi Pembayaran</h1>
    <p><strong>ID Pembayaran:</strong> <?= htmlspecialchars($pembayaran['id']) ?></p>
    <p><strong>Nama Pelanggan:</strong> <?= htmlspecialchars($pembayaran['nama_pelanggan']) ?></p>
    <p><strong>Jenis Layanan:</strong> <?= htmlspecialchars($pembayaran['jenis_layanan']) ?></p>
    <p><strong>Biaya:</strong> Rp <?= number_format($pembayaran['biaya'], 0, ',', '.') ?></p>
    <p><strong>Status:</strong> <?= htmlspecialchars($pembayaran['status']) ?></p>
    <p><strong>Tanggal Pembayaran:</strong> <?= htmlspecialchars($pembayaran['tanggal']) ?></p>

    <a href="index.php">Kembali ke Beranda</a>
</body>
</html>
