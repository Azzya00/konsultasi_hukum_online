<?php
$conn = new mysqli("localhost", "root", "", "layanan_hukum");

if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

// Ambil data dari form POST
$advokat_id        = (int) $_POST['advokat_id'];
$layanan_id        = (int) $_POST['layanan_id'];
$nama              = $conn->real_escape_string($_POST['nama_pelanggan']);
$email             = $conn->real_escape_string($_POST['email_pelanggan']);
$metode            = $conn->real_escape_string($_POST['metode_pembayaran']);
$jenis_konsultasi  = $conn->real_escape_string($_POST['jenis_konsultasi']);
$total             = isset($_POST['total_harga']) ? (float) $_POST['total_harga'] : 0;

// Validasi total agar tidak kosong
if ($total <= 0) {
    echo "<script>alert('Total pembayaran tidak valid.'); window.history.back();</script>";
    exit;
}

// Siapkan dan eksekusi statement SQL
$stmt = $conn->prepare("
    INSERT INTO pembayaran 
    (advokat_id, layanan_id, nama_pelanggan, email_pelanggan, metode_pembayaran, jenis_konsultasi, total, tanggal) 
    VALUES (?, ?, ?, ?, ?, ?, ?, NOW())
");

$stmt->bind_param(
    "iissssd", 
    $advokat_id, 
    $layanan_id, 
    $nama, 
    $email, 
    $metode, 
    $jenis_konsultasi, 
    $total
);

if ($stmt->execute()) {
    echo "<script>alert('Pembayaran berhasil disimpan!'); window.location='riwayat_transaksi.php';</script>";
} else {
    echo "Gagal menyimpan pembayaran: " . $stmt->error;
}

$stmt->close();
$conn->close();
?>
