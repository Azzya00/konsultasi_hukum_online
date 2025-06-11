<?php
session_start(); // Pastikan session dimulai jika Anda menggunakan session user ID

// Periksa apakah user sudah login. Jika tidak, redirect ke halaman login.
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php"); // Ganti dengan halaman login user Anda
    exit;
}

$advokat_id = $_GET['advokat_id'] ?? 0;
$layanan_id = $_GET['layanan_id'] ?? 0;
$harga_layanan = $_GET['harga_layanan'] ?? 0;
$harga_konsultasi = $_GET['harga_konsultasi'] ?? 0; // Pastikan ini juga diterima dari GET

$conn = new mysqli("localhost", "root", "", "layanan_hukum");
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

$advokat = null;
if ($advokat_id > 0) {
    $stmt = $conn->prepare("SELECT nama FROM advokat WHERE id = ?");
    $stmt->bind_param("i", $advokat_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $advokat = $result->fetch_assoc();
    $stmt->close();
}

$layanan = null;
if ($layanan_id > 0) {
    $stmt = $conn->prepare("SELECT nama_layanan, deskripsi, harga FROM layanan WHERE id = ?");
    $stmt->bind_param("i", $layanan_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $layanan = $result->fetch_assoc();
    $stmt->close();
}

if (!$advokat || !$layanan) {
    echo "Data advokat atau layanan tidak ditemukan.";
    exit;
}

// Hitung total harga
$total_harga = $harga_layanan + $harga_konsultasi; // Hitung dari kedua harga

?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pembayaran</title>
    <style>
        /* (CSS Anda tetap sama seperti sebelumnya, tidak saya sertakan di sini untuk brevity) */
        body { font-family: Arial, sans-serif; margin: 0; background-color: #f4f7f6; color: #333; }
        .container { max-width: 800px; margin: 30px auto; padding: 20px; background: white; border-radius: 8px; box-shadow: 0 4px 10px rgba(0,0,0,0.1); }
        h2 { text-align: center; color: #2c3e50; margin-bottom: 30px; }
        .payment-summary, .payment-form { margin-bottom: 25px; padding: 20px; border: 1px solid #ddd; border-radius: 8px; }
        .payment-summary p { margin: 10px 0; font-size: 1.1em; }
        .total-price { font-size: 1.5em; font-weight: bold; color: #007bff; margin-top: 15px; }
        form label { display: block; margin-bottom: 8px; font-weight: bold; color: #555; }
        form select, form input[type="text"], form input[type="file"] {
            width: calc(100% - 22px);
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 1em;
        }
        button {
            background-color: #28a745;
            color: white;
            padding: 12px 25px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 1.1em;
            transition: background-color 0.3s ease;
        }
        button:hover { background-color: #218838; }
        .alert-message {
            padding: 10px;
            margin-bottom: 15px;
            border-radius: 5px;
            font-weight: bold;
        }
        .alert-success { background-color: #d4edda; color: #155724; border-color: #c3e6cb; }
        .alert-error { background-color: #f8d7da; color: #721c24; border-color: #f5c6cb; }
    </style>
</head>
<body>
    <div class="container">
        <h2>Detail Pembayaran</h2>

        <div class="payment-summary">
            <h3>Ringkasan Pesanan</h3>
            <p><strong>Advokat:</strong> <?= htmlspecialchars($advokat['nama']) ?></p>
            <p><strong>Layanan:</strong> <?= htmlspecialchars($layanan['nama_layanan']) ?></p>
            <p><strong>Deskripsi Layanan:</strong> <?= htmlspecialchars($layanan['deskripsi']) ?></p>
            <p><strong>Harga Layanan:</strong> Rp<?= number_format($harga_layanan, 0, ',', '.') ?></p>
            <p><strong>Harga Konsultasi:</strong> Rp<?= number_format($harga_konsultasi, 0, ',', '.') ?></p>
            <p class="total-price">Total yang harus dibayar: Rp<?= number_format($total_harga, 0, ',', '.') ?></p>
        </div>

        <div class="payment-form">
            <h3>Form Pembayaran</h3>
            <?php if (isset($_GET['status']) && $_GET['status'] == 'error_upload'): ?>
                <div class="alert-message alert-error">Gagal mengunggah bukti pembayaran. Silakan coba lagi.</div>
            <?php endif; ?>
            <form action="proses_pembayaran.php" method="post" enctype="multipart/form-data">
                <input type="hidden" name="user_id" value="<?= htmlspecialchars($_SESSION['user_id'] ?? '') ?>">
                <input type="hidden" name="advokat_id" value="<?= htmlspecialchars($advokat_id) ?>">
                <input type="hidden" name="layanan_id" value="<?= htmlspecialchars($layanan_id) ?>">
                <input type="hidden" name="total_pembayaran" value="<?= htmlspecialchars($total_harga) ?>">
                <input type="hidden" name="jenis_konsultasi" value="chat_telepon"> <label for="metode_pembayaran">Metode Pembayaran:</label>
                <select id="metode_pembayaran" name="metode_pembayaran" required>
                    <option value="">Pilih Metode</option>
                    <option value="bank_transfer">Transfer Bank</option>
                    </select>

                <label for="bukti_transfer">Unggah Bukti Transfer:</label>
                <input type="file" id="bukti_transfer" name="bukti_transfer" accept="image/*" required>

                <button type="submit">Bayar Sekarang</button>
            </form>
        </div>
    </div>
</body>
</html>