<?php
session_start();

$conn = new mysqli("localhost", "root", "", "layanan_hukum");
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

// Dapatkan ID pembayaran dari URL, misal: konfirmasi_pembayaran.php?id=123
$payment_id = $_GET['id'] ?? 0;

$pembayaran = null;
if ($payment_id > 0) {
    // Ambil detail pembayaran berdasarkan ID
    $stmt = $conn->prepare("
        SELECT p.*, u.nama AS nama_pengguna, a.nama AS nama_advokat, l.nama_layanan
        FROM pembayaran p
        JOIN users u ON p.user_id = u.id
        JOIN advokat a ON p.advokat_id = a.id
        JOIN layanan l ON p.layanan_id = l.id
        WHERE p.id = ?
    ");
    $stmt->bind_param("i", $payment_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $pembayaran = $result->fetch_assoc(); // Ini yang mengisi variabel $pembayaran
    $stmt->close();
}

$conn->close();

if (!$pembayaran) {
    // Redirect atau tampilkan pesan error jika pembayaran tidak ditemukan
    header("Location: index.php?status=payment_not_found"); // Redirect ke halaman utama jika ID tidak valid
    exit;
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Status Pembayaran Anda</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 0; background-color: #eef2f7; display: flex; flex-direction: column; min-height: 100vh; }
        .main-header { background: #d29e00; padding: 20px 40px; color: white; font-size: 24px; font-weight: bold; text-align: center; }
        .container {
            max-width: 700px;
            margin: 30px auto;
            background: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
            text-align: center;
        }
        h2 { color: #28a745; margin-bottom: 20px; }
        .info-box {
            background-color: #f9f9f9;
            border: 1px solid #e0e0e0;
            border-radius: 8px;
            padding: 20px;
            margin-bottom: 25px;
            text-align: left;
        }
        .info-box p { margin: 10px 0; font-size: 16px; line-height: 1.6; }
        .info-box strong { color: #333; }
        .total-price {
            font-size: 24px;
            font-weight: bold;
            color: #d29e00;
            margin-top: 15px;
        }
        .instruction-box {
            background-color: #e8f0fe;
            border: 1px solid #b3d9ff;
            border-radius: 8px;
            padding: 20px;
            margin-bottom: 25px;
            text-align: left;
            color: #004aad;
        }
        .instruction-box ol { padding-left: 25px; margin-top: 15px; }
        .instruction-box li { margin-bottom: 10px; font-size: 15px; }
        .btn-group { display: flex; justify-content: center; gap: 15px; margin-top: 30px; }
        .btn {
            padding: 12px 25px;
            border: none;
            border-radius: 8px;
            font-size: 16px;
            cursor: pointer;
            text-decoration: none;
            transition: background-color 0.3s ease;
            font-weight: bold;
        }
        .btn-primary { background-color: #004aad; color: white; }
        .btn-primary:hover { background-color: #003380; }
        .btn-secondary { background-color: #f0f0f0; color: #333; border: 1px solid #ccc; }
        .btn-secondary:hover { background-color: #e0e0e0; }
        
        /* Tambahan untuk status pembayaran */
        .status-info {
            font-size: 1.2em;
            font-weight: bold;
            margin-bottom: 20px;
            padding: 10px;
            border-radius: 5px;
        }
        .status-pending { background-color: #ffc10740; color: #d29e00; } /* Yellowish */
        .status-verified { background-color: #28a74540; color: #28a745; } /* Greenish */
        .status-cancelled { background-color: #dc354540; color: #dc3545; } /* Reddish */
        .status-done { background-color: #007bff40; color: #007bff; } /* Bluish, for 'selesai' */

    </style>
</head>
<body>
    <div class="main-header">
        Detail Pembayaran
    </div>

    <div class="container">
        <h2>Informasi Pembayaran Anda</h2>
        
        <?php
        $status_class = '';
        $status_text = '';
        switch ($pembayaran['status']) {
            case 'pending':
                $status_class = 'status-pending';
                $status_text = 'MENUNGGU PEMBAYARAN';
                break;
            case 'menunggu_verifikasi':
                $status_class = 'status-pending';
                $status_text = 'MENUNGGU VERIFIKASI ADMIN';
                break;
            case 'terverifikasi': // <-- Ini masalahnya
                $status_class = 'status-verified';
                $status_text = 'PEMBAYARAN TERVERIFIKASI';
                break;
            case 'selesai': // <-- Ini sudah benar harusnya
                $status_class = 'status-done';
                $status_text = 'TRANSAKSI SELESAI';
                break;
            case 'dibatalkan':
                $status_class = 'status-cancelled';
                $status_text = 'PEMBAYARAN DIBATALKAN';
                break;
            default:
                $status_class = 'status-pending'; // Default fallback class
                $status_text = 'STATUS TIDAK DIKETAHUI';
                break;
        }
        ?>
        <p class="status-info <?= $status_class ?>"><?= $status_text ?></p>


        <div class="info-box">
            <p><strong>Nomor Pesanan:</strong> <?= htmlspecialchars($pembayaran['id']) ?></p>
            <p><strong>Tanggal Pesanan:</strong> <?= date('d M Y H:i', strtotime($pembayaran['tanggal'])) ?></p>
            <p><strong>Advokat:</strong> <?= htmlspecialchars($pembayaran['nama_advokat']) ?></p>
            <p><strong>Layanan Hukum:</strong> <?= htmlspecialchars($pembayaran['nama_layanan']) ?></p>
            <p><strong>Jenis Konsultasi:</strong> <?= htmlspecialchars($pembayaran['jenis_konsultasi'] == 'chat_telepon' ? 'Telepon & Chat' : 'Chat Saja') ?></p>
            <p><strong>Metode Pembayaran:</strong> <?= htmlspecialchars($pembayaran['metode_pembayaran']) ?></p>
            <p class="total-price">Total Pembayaran: Rp<?= number_format($pembayaran['total'], 0, ',', '.') ?></p>
            
            <?php if (!empty($pembayaran['bukti_transfer'])): ?>
                <p><strong>Bukti Transfer:</strong> <a href="uploads/bukti_transfer/<?= htmlspecialchars($pembayaran['bukti_transfer']) ?>" target="_blank">Lihat Bukti</a></p>
            <?php else: ?>
                <p><strong>Bukti Transfer:</strong> Belum diunggah.</p>
            <?php endif; ?>

        </div>

        <?php if ($pembayaran['status'] == 'pending' || $pembayaran['status'] == 'menunggu_verifikasi'): ?>
        <div class="instruction-box">
            <h3>Instruksi Pembayaran:</h3>
            <ol>
                <li>Transfer dana sejumlah **Rp<?= number_format($pembayaran['total'], 0, ',', '.') ?>** ke rekening berikut:
                    <br><strong>BCA: 1234567890 a.n SAIFULLAW</strong></li>
                <li>Sertakan **Nomor Pesanan (<?= htmlspecialchars($pembayaran['id']) ?>)** pada catatan transfer jika memungkinkan.</li>
                <li>Setelah transfer, mohon segera lakukan konfirmasi pembayaran manual jika belum otomatis dikirim <a href="konfirmasi_manual.php?payment_id=<?= htmlspecialchars($pembayaran['id']) ?>" style="color: #004aad; font-weight: bold;">di sini</a>.</li>
                <li>Pembayaran Anda akan diverifikasi dalam waktu maksimal 1x24 jam.</li>
            </ol>
        </div>
        <?php endif; ?>

        <div class="btn-group">
            <a href="riwayat_konsultasi.php" class="btn btn-primary">Lihat Riwayat Transaksi</a>
            <a href="index.php" class="btn btn-secondary">Kembali ke Beranda</a>
        </div>
    </div>
</body>
</html>