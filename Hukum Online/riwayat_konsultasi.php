<?php
session_start();

$conn = new mysqli("localhost", "root", "", "layanan_hukum");
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

$user = null;
if (isset($_SESSION['user_id'])) {
    $stmt = $conn->prepare("SELECT id, nama, email, foto FROM users WHERE id = ?");
    $stmt->bind_param("i", $_SESSION['user_id']);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();
    $stmt->close(); // Tutup statement setelah digunakan
} else {
    // Jika tidak login, arahkan ke halaman login
    header("Location: login.php");
    exit;
}

$riwayat_pembayaran = [];
// Ambil riwayat pembayaran khusus untuk user yang sedang login
$sql_pembayaran = "SELECT p.*, a.nama AS nama_advokat, l.nama_layanan
                   FROM pembayaran p
                   JOIN advokat a ON p.advokat_id = a.id
                   JOIN layanan l ON p.layanan_id = l.id
                   WHERE p.user_id = ?
                   ORDER BY p.tanggal DESC";
$stmt_pembayaran = $conn->prepare($sql_pembayaran);
$stmt_pembayaran->bind_param("i", $_SESSION['user_id']);
$stmt_pembayaran->execute();
$result_pembayaran = $stmt_pembayaran->get_result();

if ($result_pembayaran && $result_pembayaran->num_rows > 0) {
    while ($row = $result_pembayaran->fetch_assoc()) {
        $riwayat_pembayaran[] = $row; // Ambil semua data pembayaran
    }
}
$stmt_pembayaran->close();
$conn->close();

// Fungsi untuk mendapatkan badge status yang lebih baik
function getStatusBadge($status) {
    $status_lower = strtolower($status);
    $class = 'badge-unknown'; // Default ke unknown jika tidak cocok
    $text = 'Status Tidak Dikenal';

    switch ($status_lower) {
        case 'pending':
            $class = 'badge-pending';
            $text = 'Menunggu Pembayaran';
            break;
        case 'menunggu_verifikasi':
            $class = 'badge-verifikasi';
            $text = 'Menunggu Verifikasi Admin';
            break;
        case 'terverifikasi': // Tambahkan ini jika Anda menggunakan 'terverifikasi' sebelum 'selesai'
            $class = 'badge-sukses';
            $text = 'Pembayaran Terverifikasi';
            break;
        case 'selesai': // <<< INI YANG DITAMBAHKAN/DIRUBAH
            $class = 'badge-sukses';
            $text = 'Pembayaran Selesai';
            break;
        case 'dibatalkan':
            $class = 'badge-batal';
            $text = 'Dibatalkan';
            break;
        // Hapus case 'paid' dan 'completed' jika status di database Anda bukan itu
        // case 'paid':
        // case 'completed':
        //    $class = 'badge-sukses';
        //    $text = 'Pembayaran Selesai';
        //    break;
    }
    return "<span class='badge {$class}'>{$text}</span>";
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Riwayat Konsultasi & Pembayaran</title>
    <style>
        /* CSS umum (dari index.php atau style.css jika ada) */
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            margin: 0;
            padding: 0; /* Hapus padding 20px dari body, pindahkan ke container */
            background-color: #f5f5f5;
            color: #333;
        }

        /* Navbar CSS (ambil dari index.php untuk konsistensi) */
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
        /* Tambahan untuk teks logo jika ada */
        .navbar .logo-group {
            display: flex;
            align-items: center;
        }
        .navbar .logo-group img {
            height: 60px;
            margin-right: 15px;
        }
        .navbar .logo-group span {
            font-weight: bold;
            font-size: 20px;
            color: #22026f;
        }

        .navbar .nav-links {
            display: flex;
            gap: 1.5rem;
            list-style: none;
            align-items: center;
        }

        .navbar .nav-links a {
            color: #333;
            text-decoration: none;
            font-weight: 500;
        }

        .navbar .nav-links .active a {
            color: #004aad;
        }

        /* Profile Dropdown dari index.php */
        .profile-container {
            position: relative;
        }

        .profile-img {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            object-fit: cover;
            cursor: pointer;
        }

        .profile-dropdown {
            display: none;
            position: absolute;
            right: 0;
            top: 50px;
            background-color: white;
            box-shadow: 0 2px 8px rgba(0,0,0,0.2);
            border-radius: 8px;
            overflow: hidden;
            z-index: 1000;
            min-width: 150px;
        }

        .profile-dropdown a {
            display: block;
            padding: 10px;
            text-decoration: none;
            color: #333;
            font-size: 14px;
        }

        .profile-dropdown a:hover {
            background-color: #f2f2f2;
        }


        .container {
            max-width: 900px; /* Lebarkan sedikit */
            margin: 20px auto; /* Tambahkan margin auto */
            background: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        h1 {
            color: #2c3e50;
            margin-bottom: 5px;
            text-align: center;
        }
        .subtitle {
            color: #7f8c8d;
            margin-top: 0;
            margin-bottom: 20px;
            text-align: center;
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
            color: #7f8c8d;
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
            transition: background 0.3s ease;
        }
        .btn:hover {
            background: #2980b9;
        }
        .riwayat-item {
            padding: 15px;
            border: 1px solid #eee; /* Tambah border */
            border-radius: 8px;
            margin-bottom: 15px;
            background: #fff;
            box-shadow: 0 2px 5px rgba(0,0,0,0.05);
            display: flex; /* Mengatur layout internal */
            flex-direction: column;
            gap: 10px;
        }
        .riwayat-item:last-child {
            border-bottom: 1px solid #eee; /* Pastikan border bawah ada */
        }
        .riwayat-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 10px;
        }
        .riwayat-header h3 {
            margin: 0;
            color: #004aad;
            font-size: 18px;
        }
        .riwayat-header .date {
            font-size: 13px;
            color: #888;
        }
        .riwayat-body p {
            margin: 5px 0;
            font-size: 15px;
            color: #555;
        }
        .riwayat-body strong {
            color: #333;
        }

        /* Badge Status */
        .badge {
            display: inline-block;
            padding: 5px 10px;
            border-radius: 5px;
            font-size: 13px;
            font-weight: bold;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        .badge-pending {
            background-color: #fff3cd; /* Kuning muda */
            color: #856404; /* Kuning gelap */
            border: 1px solid #ffeeba;
        }
        .badge-verifikasi {
            background-color: #e0f7fa; /* Biru muda */
            color: #007bff; /* Biru cerah */
            border: 1px solid #b3e5fc;
        }
        .badge-sukses {
            background-color: #d4edda; /* Hijau muda */
            color: #28a745; /* Hijau gelap */
            border: 1px solid #c3e6cb;
        }
        .badge-batal {
            background-color: #f8d7da; /* Merah muda */
            color: #dc3545; /* Merah gelap */
            border: 1px solid #f5c6cb;
        }
        .badge-unknown {
            background-color: #e2e3e5;
            color: #6c757d;
            border: 1px solid #d6d8db;
        }
        .action-buttons {
            margin-top: 10px;
            text-align: right; /* Tombol di kanan */
        }
        .action-buttons .btn-action {
            display: inline-block;
            padding: 8px 15px;
            border-radius: 5px;
            text-decoration: none;
            font-size: 14px;
            font-weight: bold;
            margin-left: 10px;
            transition: background-color 0.3s ease;
        }
        .btn-lihat {
            background: #007bff;
            color: white;
        }
        .btn-lihat:hover {
            background: #0056b3;
        }
        .btn-konfirmasi {
            background: #ffc107;
            color: #333;
        }
        .btn-konfirmasi:hover {
            background: #e0a800;
        }
        .btn-hapus {
            background: #dc3545;
            color: white;
        }
        .btn-hapus:hover {
            background: #c82333;
        }

        /* CSS untuk Navbar dari index.php agar konsisten */
        .navbar .logo-group {
            display: flex;
            align-items: center;
        }

        .navbar .logo-group img {
            height: 60px;
            margin-right: 15px;
        }

        .navbar .logo-group span {
            font-weight: bold;
            font-size: 20px;
            color: #22026f;
        }
    </style>
</head>
<body>
<nav class="navbar">
    <div class="logo-group"> <img src="logo.png" alt="Logo SaifulMLaw">
        <span>SAIFULMLAW</span>
    </div>
    <ul class="nav-links">
        <li><a href="index.php">Beranda</a></li>
        <li><a href="langkah_hukum.php">Langkah Hukum</a></li>
        <li class="active"><a href="riwayat_konsultasi.php">Riwayat</a></li>

        <?php if ($user): ?>
            <li class="profile-container">
                <img src="uploads/<?= htmlspecialchars($user['foto'] ?? 'default.png') ?>" alt="Foto Profil" class="profile-img" onclick="toggleProfileMenu()">
                <div class="profile-dropdown" id="profileDropdown">
                    <a href="user_profile.php">Profil Saya</a>
                    <a href="logout.php" onclick="return confirm('Yakin ingin logout?')">Logout</a>
                </div>
            </li>
        <?php else: ?>
            <li><a href="login.php">Masuk</a></li>
            <li><a href="signup.php">Daftar</a></li>
        <?php endif; ?>
    </ul>
</nav>

<div class="container">
    <h1>Riwayat Transaksi & Konsultasi</h1>
    <p class="subtitle">Lihat semua layanan hukum dan status pembayaran Anda.</p>
    <div class="divider"></div>

    <?php if (empty($riwayat_pembayaran)): ?>
        <div class="empty-state">
            <p>Anda belum memiliki riwayat transaksi.</p>
            <a href="langkah_hukum.php" class="btn">Mulai Konsultasi/Layanan</a>
        </div>
    <?php else: ?>
        <?php foreach ($riwayat_pembayaran as $item): ?>
            <div class="riwayat-item">
                <div class="riwayat-header">
                    <h3><?= htmlspecialchars($item['nama_layanan']) ?></h3>
                    <span class="date"><?= date('d M Y H:i', strtotime($item['tanggal'])) ?></span>
                </div>
                <div class="riwayat-body">
                    <p><strong>Nomor Pesanan:</strong> #<?= htmlspecialchars($item['id']) ?></p>
                    <p><strong>Advokat:</strong> <?= htmlspecialchars($item['nama_advokat']) ?></p>
                    <p><strong>Jenis Konsultasi:</strong> <?= htmlspecialchars($item['jenis_konsultasi'] == 'chat_telepon' ? 'Telepon & Chat' : 'Chat Saja') ?></p>
                    <p><strong>Total Pembayaran:</strong> Rp<?= number_format($item['total'], 0, ',', '.') ?></p>
                    <p><strong>Metode Pembayaran:</strong> <?= htmlspecialchars($item['metode_pembayaran']) ?></p>
                    <p><strong>Status:</strong> <?= getStatusBadge($item['status']) ?></p>
                </div>
                <div class="action-buttons">
                    <?php if ($item['status'] === 'pending' || $item['status'] === 'menunggu_verifikasi'): // Ubah kondisi ini agar tombol upload/konfirmasi muncul jika statusnya 'pending' atau 'menunggu_verifikasi' ?>
                        <?php if ($item['bukti_transfer']): ?>
                             <a href="uploads/bukti_transfer/<?= htmlspecialchars($item['bukti_transfer']) ?>" target="_blank" class="btn-action btn-lihat">Lihat Bukti Transfer</a>
                             <a href="konfirmasi_manual.php?payment_id=<?= htmlspecialchars($item['id']) ?>" class="btn-action btn-konfirmasi">Upload Bukti Ulang</a>
                        <?php else: ?>
                             <a href="konfirmasi_manual.php?payment_id=<?= htmlspecialchars($item['id']) ?>" class="btn-action btn-konfirmasi">Upload Bukti Transfer</a>
                        <?php endif; ?>
                    <?php elseif ($item['status'] === 'selesai' || $item['status'] === 'terverifikasi'): // Jika sudah selesai atau terverifikasi, berikan tombol untuk memulai konsultasi ?>
                        <a href="ruang_konsultasi.php?payment_id=<?= htmlspecialchars($item['id']) ?>" class="btn-action btn-lihat" style="background-color: #28a745;">Mulai Konsultasi</a>
                    <?php elseif ($item['status'] === 'dibatalkan'): ?>
                        <span style="color: red; font-weight: bold; font-size: 14px;">Transaksi Dibatalkan</span>
                    <?php endif; ?>
                </div>
            </div>
        <?php endforeach; ?>
    <?php endif; ?>
</div>

<script>
    function toggleProfileMenu() {
        var dropdown = document.getElementById("profileDropdown");
        dropdown.style.display = dropdown.style.display === "block" ? "none" : "block";
    }

    // Tutup dropdown jika klik di luar
    window.onclick = function(event) {
        if (!event.target.matches('.profile-img')) {
            var dropdowns = document.getElementsByClassName("profile-dropdown");
            for (var i = 0; i < dropdowns.length; i++) {
                var openDropdown = dropdowns[i];
                if (openDropdown.style.display === 'block') {
                    openDropdown.style.display = 'none';
                }
            }
        }
    }
</script>

</body>
</html>