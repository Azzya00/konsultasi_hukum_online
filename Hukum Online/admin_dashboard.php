<?php
session_start();

// PENTING: Implementasi Pengecekan Login Admin di Sini
// Ini adalah bagian KRUSIAL untuk keamanan.
// Pastikan admin sudah login dan memiliki role yang benar.
// Contoh sederhana (sesuaikan dengan sistem login Anda):
/*
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_role'] !== 'admin') {
    header("Location: ../login.php"); // Atau ke halaman login admin Anda, misal: login_admin.php
    exit;
}
*/

$conn = new mysqli("localhost", "root", "", "layanan_hukum");
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

// Ambil statistik dasar untuk dashboard (opsional)
$total_pembayaran_pending = $conn->query("SELECT COUNT(*) AS total FROM pembayaran WHERE status = 'pending'")->fetch_assoc()['total'];
$total_pembayaran_verifikasi = $conn->query("SELECT COUNT(*) AS total FROM pembayaran WHERE status = 'menunggu_verifikasi'")->fetch_assoc()['total'];
$total_pembayaran_paid = $conn->query("SELECT COUNT(*) AS total FROM pembayaran WHERE status = 'paid'")->fetch_assoc()['total'];
$total_advokat = $conn->query("SELECT COUNT(*) AS total FROM advokat")->fetch_assoc()['total'];
$total_users = $conn->query("SELECT COUNT(*) AS total FROM users")->fetch_assoc()['total'];

$conn->close();
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 0; background-color: #f4f7f6; color: #333; }
        .header-admin { background-color: #34495e; color: white; padding: 20px; text-align: center; }
        .header-admin h1 { margin: 0; font-size: 28px; }
        .header-admin nav ul { list-style: none; padding: 0; margin: 10px 0 0; display: flex; justify-content: center; gap: 20px; }
        .header-admin nav a { color: white; text-decoration: none; font-weight: bold; padding: 5px 10px; border-radius: 4px; transition: background-color 0.3s ease; }
        .header-admin nav a:hover, .header-admin nav a.active { background-color: #2c3e50; }

        .container { max-width: 1200px; margin: 30px auto; padding: 20px; background: white; border-radius: 8px; box-shadow: 0 4px 10px rgba(0,0,0,0.1); }
        h2 { text-align: center; color: #2c3e50; margin-bottom: 30px; }

        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
            margin-top: 30px;
        }
        .stat-card {
            background-color: #e0f2f7; /* Light blue */
            padding: 20px;
            border-radius: 8px;
            text-align: center;
            box-shadow: 0 2px 5px rgba(0,0,0,0.05);
            color: #004aad; /* Darker blue text */
        }
        .stat-card h3 {
            margin-top: 0;
            color: #2c3e50;
        }
        .stat-card .value {
            font-size: 3em;
            font-weight: bold;
            margin: 10px 0;
        }
        .stat-card .description {
            font-size: 0.9em;
            color: #555;
        }
        /* Specific colors for different cards */
        .stat-card.pending { background-color: #fff3cd; color: #856404; }
        .stat-card.verifikasi { background-color: #e0f7fa; color: #007bff; }
        .stat-card.paid { background-color: #d4edda; color: #28a745; }
        .stat-card.advokat { background-color: #fce4ec; color: #ad1457; }
        .stat-card.users { background-color: #e3f2fd; color: #1976d2; }
    </style>
</head>
<body>
    <div class="header-admin">
        <h1>Selamat Datang, Admin!</h1>
        <nav>
            <ul>
                <li><a href="admin_dashboard.php" class="active">Dashboard</a></li>
                <li><a href="kelola_pembayaran.php">Kelola Pembayaran</a></li>
                <li><a href="kelola_advokat.php">Kelola Advokat</a></li>
                <li><a href="kelola_layanan.php">Kelola Layanan</a></li>
                <li><a href="kelola_users.php">Kelola Pengguna</a></li>
                <li><a href="../logout.php">Logout</a></li> </ul>
        </nav>
    </div>

    <div class="container">
        <h2>Ringkasan Statistik</h2>
        <div class="stats-grid">
            <div class="stat-card pending">
                <h3>Pembayaran Pending</h3>
                <div class="value"><?= htmlspecialchars($total_pembayaran_pending) ?></div>
                <div class="description">Menunggu user transfer</div>
            </div>
            <div class="stat-card verifikasi">
                <h3>Menunggu Verifikasi</h3>
                <div class="value"><?= htmlspecialchars($total_pembayaran_verifikasi) ?></div>
                <div class="description">Bukti transfer sudah diunggah</div>
            </div>
            <div class="stat-card paid">
                <h3>Pembayaran Selesai</h3>
                <div class="value"><?= htmlspecialchars($total_pembayaran_paid) ?></div>
                <div class="description">Pembayaran telah diverifikasi</div>
            </div>
            <div class="stat-card advokat">
                <h3>Total Advokat</h3>
                <div class="value"><?= htmlspecialchars($total_advokat) ?></div>
                <div class="description">Jumlah advokat terdaftar</div>
            </div>
            <div class="stat-card users">
                <h3>Total Pengguna</h3>
                <div class="value"><?= htmlspecialchars($total_users) ?></div>
                <div class="description">Jumlah pengguna terdaftar</div>
            </div>
        </div>
    </div>
</body>
</html>