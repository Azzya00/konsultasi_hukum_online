<?php
session_start();

// Periksa apakah user sudah login.
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php"); // Ganti dengan halaman login user Anda
    exit;
}

$conn = new mysqli("localhost", "root", "", "layanan_hukum");
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

$payment_id = $_GET['payment_id'] ?? 0;
$pembayaran = null;

if ($payment_id > 0) {
    $stmt = $conn->prepare("SELECT id, status, bukti_transfer FROM pembayaran WHERE id = ? AND user_id = ?");
    $stmt->bind_param("ii", $payment_id, $_SESSION['user_id']);
    $stmt->execute();
    $result = $stmt->get_result();
    $pembayaran = $result->fetch_assoc();
    $stmt->close();

    if (!$pembayaran) {
        echo "Pembayaran tidak ditemukan atau Anda tidak memiliki akses ke pembayaran ini.";
        exit;
    }
} else {
    echo "ID Pembayaran tidak valid.";
    exit;
}

$message = '';
$message_type = '';

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit_bukti'])) {
    if (isset($_FILES['bukti_transfer']) && $_FILES['bukti_transfer']['error'] == UPLOAD_ERR_OK) {
        $target_dir = "uploads/bukti_transfer/";
        if (!is_dir($target_dir)) {
            mkdir($target_dir, 0777, true);
        }

        $file_name = basename($_FILES["bukti_transfer"]["name"]);
        $file_type = pathinfo($file_name, PATHINFO_EXTENSION);
        $new_file_name = uniqid('bukti_re_') . '.' . $file_type;
        $target_file = $target_dir . $new_file_name;

        $allowed_types = ['jpg', 'jpeg', 'png', 'gif', 'pdf'];
        if (in_array(strtolower($file_type), $allowed_types)) {
            // Hapus bukti transfer lama jika ada
            if ($pembayaran['bukti_transfer'] && file_exists($target_dir . $pembayaran['bukti_transfer'])) {
                unlink($target_dir . $pembayaran['bukti_transfer']);
            }

            if (move_uploaded_file($_FILES["bukti_transfer"]["tmp_name"], $target_file)) {
                // Update bukti transfer dan status di database
                // Jika user mengupload ulang, status kembali ke 'menunggu_verifikasi'
                $stmt_update = $conn->prepare("UPDATE pembayaran SET bukti_transfer = ?, status = 'menunggu_verifikasi' WHERE id = ?");
                $stmt_update->bind_param("si", $new_file_name, $payment_id);

                if ($stmt_update->execute()) {
                    $message = "Bukti transfer berhasil diunggah ulang! Pembayaran Anda akan segera diverifikasi.";
                    $message_type = 'success';
                    // Update data $pembayaran agar tampilan langsung berubah
                    $pembayaran['bukti_transfer'] = $new_file_name;
                    $pembayaran['status'] = 'menunggu_verifikasi';
                } else {
                    $message = "Gagal memperbarui database: " . $stmt_update->error;
                    $message_type = 'error';
                }
                $stmt_update->close();
            } else {
                $message = "Gagal mengunggah file bukti transfer.";
                $message_type = 'error';
            }
        } else {
            $message = "Tipe file tidak diizinkan. Hanya JPG, JPEG, PNG, GIF, PDF.";
            $message_type = 'error';
        }
    } else {
        $message = "Silakan pilih file bukti transfer.";
        $message_type = 'error';
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Upload Bukti Pembayaran Manual</title>
    <style>
        body { font-family: Arial, sans-serif; background-color: #f4f7f6; display: flex; justify-content: center; align-items: center; min-height: 100vh; margin: 0; }
        .container { background-color: #fff; padding: 30px; border-radius: 8px; box-shadow: 0 4px 10px rgba(0,0,0,0.1); max-width: 500px; width: 100%; text-align: center; }
        h2 { color: #2c3e50; margin-bottom: 25px; }
        .alert { padding: 12px; margin-bottom: 20px; border-radius: 5px; font-weight: bold; }
        .alert-success { background-color: #d4edda; color: #155724; border: 1px solid #c3e6cb; }
        .alert-error { background-color: #f8d7da; color: #721c24; border: 1px solid #f5c6cb; }
        form label { display: block; margin-bottom: 8px; font-weight: bold; color: #555; text-align: left; }
        form input[type="file"] { width: calc(100% - 22px); padding: 10px; margin-bottom: 20px; border: 1px solid #ccc; border-radius: 5px; }
        form button { background-color: #007bff; color: white; padding: 10px 20px; border: none; border-radius: 5px; cursor: pointer; font-size: 1em; transition: background-color 0.3s ease; }
        form button:hover { background-color: #0056b3; }
        .info-detail { background-color: #f9f9f9; border: 1px solid #eee; padding: 15px; border-radius: 8px; margin-bottom: 20px; text-align: left; }
        .info-detail p { margin: 5px 0; }
        .current-bukti { margin-top: 15px; margin-bottom: 15px; }
        .current-bukti img { max-width: 100%; height: auto; border: 1px solid #ddd; border-radius: 5px; }
        .back-link { margin-top: 20px; display: block; color: #004aad; text-decoration: none; }
        .back-link:hover { text-decoration: underline; }
    </style>
</head>
<body>
    <div class="container">
        <h2>Upload Bukti Pembayaran</h2>

        <?php if ($message): ?>
            <div class="alert alert-<?= $message_type ?>"><?= htmlspecialchars($message) ?></div>
        <?php endif; ?>

        <div class="info-detail">
            <p><strong>Nomor Pesanan:</strong> <?= htmlspecialchars($pembayaran['id']) ?></p>
            <p><strong>Status Saat Ini:</strong> <span style="font-weight: bold; color: <?= ($pembayaran['status'] == 'terverifikasi' || $pembayaran['status'] == 'selesai') ? 'green' : (($pembayaran['status'] == 'dibatalkan') ? 'red' : 'orange') ?>"><?= htmlspecialchars(str_replace('_', ' ', strtoupper($pembayaran['status']))) ?></span></p>
            <?php if (!empty($pembayaran['bukti_transfer'])): ?>
                <div class="current-bukti">
                    <p>Bukti Transfer Saat Ini:</p>
                    <a href="uploads/bukti_transfer/<?= htmlspecialchars($pembayaran['bukti_transfer']) ?>" target="_blank">
                        <img src="uploads/bukti_transfer/<?= htmlspecialchars($pembayaran['bukti_transfer']) ?>" alt="Bukti Transfer" style="max-width: 150px; height: auto;">
                    </a>
                </div>
            <?php endif; ?>
        </div>

        <?php if ($pembayaran['status'] != 'terverifikasi' && $pembayaran['status'] != 'selesai'): ?>
            <form action="konfirmasi_manual.php?payment_id=<?= htmlspecialchars($payment_id) ?>" method="post" enctype="multipart/form-data">
                <label for="bukti_transfer">Pilih File Bukti Transfer Baru:</label>
                <input type="file" id="bukti_transfer" name="bukti_transfer" accept="image/*" required>
                <button type="submit" name="submit_bukti">Upload Bukti</button>
            </form>
        <?php else: ?>
            <p style="color: green; font-weight: bold;">Pembayaran ini sudah <?= htmlspecialchars(str_replace('_', ' ', strtoupper($pembayaran['status']))) ?>. Tidak perlu mengunggah bukti lagi.</p>
        <?php endif; ?>

        <a href="riwayat_konsultasi.php" class="back-link">Kembali ke Riwayat Transaksi</a>
    </div>
</body>
</html>