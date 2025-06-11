<?php
session_start();

// PENTING: Implementasi Pengecekan Login Admin di Sini!
/*
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_role'] !== 'admin') {
    header("Location: ../login_admin.php"); // Atau ke halaman login admin Anda
    exit;
}
*/

$conn = new mysqli("localhost", "root", "", "layanan_hukum");
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

$pembayaran = [];
// Ambil pembayaran yang statusnya 'menunggu_verifikasi'
$sql = "SELECT p.*, u.nama AS nama_pengguna, a.nama AS nama_advokat, l.nama_layanan
        FROM pembayaran p
        JOIN users u ON p.user_id = u.id
        JOIN advokat a ON p.advokat_id = a.id
        JOIN layanan l ON p.layanan_id = l.id
        WHERE p.status = 'menunggu_verifikasi'
        ORDER BY p.tanggal DESC"; // Mengambil hanya yang menunggu verifikasi
$result = $conn->query($sql);

if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $pembayaran[] = $row;
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Kelola Pembayaran</title>
    <style>
        /* CSS Umum untuk Admin Panel */
        body { font-family: Arial, sans-serif; margin: 0; background-color: #f4f7f6; color: #333; }
        .header-admin { background-color: #34495e; color: white; padding: 20px; text-align: center; }
        .header-admin h1 { margin: 0; font-size: 28px; }
        .header-admin nav ul { list-style: none; padding: 0; margin: 10px 0 0; display: flex; justify-content: center; gap: 20px; }
        .header-admin nav a { color: white; text-decoration: none; font-weight: bold; padding: 5px 10px; border-radius: 4px; transition: background-color 0.3s ease; }
        .header-admin nav a:hover, .header-admin nav a.active { background-color: #2c3e50; }

        .container { max-width: 1200px; margin: 30px auto; padding: 20px; background: white; border-radius: 8px; box-shadow: 0 4px 10px rgba(0,0,0,0.1); }
        h2 { text-align: center; color: #2c3e50; margin-bottom: 30px; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { padding: 12px 15px; border: 1px solid #ddd; text-align: left; }
        th { background-color: #e9ecef; font-weight: bold; color: #555; }
        tr:nth-child(even) { background-color: #f8f9fa; }
        .text-center { text-align: center; }
        .btn-action {
            padding: 8px 15px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 14px;
            text-decoration: none;
            color: white;
            transition: background-color 0.3s ease;
            margin-right: 5px;
            display: inline-block; /* Untuk form button */
        }
        .btn-success { background-color: #28a745; }
        .btn-success:hover { background-color: #218838; }
        .btn-danger { background-color: #dc3545; }
        .btn-danger:hover { background-color: #c82333; }
        .btn-info { background-color: #17a2b8; }
        .btn-info:hover { background-color: #138496; }
        .empty-state { text-align: center; color: #777; padding: 20px; border: 1px dashed #ddd; border-radius: 8px; margin-top: 20px; }
        .bukti-img { max-width: 80px; height: auto; border-radius: 5px; }
    </style>
</head>
<body>
    <div class="header-admin">
        <h1>Admin Panel</h1>
        <nav>
            <ul>
                <li><a href="admin_dashboard.php">Dashboard</a></li>
                <li><a href="kelola_pembayaran.php" class="active">Kelola Pembayaran</a></li>
                <li><a href="kelola_advokat.php">Kelola Advokat</a></li>
                <li><a href="kelola_layanan.php">Kelola Layanan</a></li>
                <li><a href="kelola_users.php">Kelola Pengguna</a></li>
                <li><a href="../logout.php">Logout</a></li>
            </ul>
        </nav>
    </div>

    <div class="container">
        <h2>Verifikasi Pembayaran</h2>
        <?php if (isset($_GET['action'])): ?>
            <?php if ($_GET['action'] == 'success'): ?>
                <div class="alert alert-success">Status pembayaran ID #<?= htmlspecialchars($_GET['id']) ?> berhasil diubah menjadi <?= htmlspecialchars(str_replace('_', ' ', strtoupper($_GET['new_status']))) ?>.</div>
            <?php elseif ($_GET['action'] == 'error'): ?>
                <div class="alert alert-danger">Terjadi kesalahan saat mengubah status pembayaran.</div>
            <?php endif; ?>
        <?php endif; ?>

        <?php if (empty($pembayaran)): ?>
            <div class="empty-state">
                <p>Tidak ada pembayaran yang menunggu verifikasi.</p>
            </div>
        <?php else: ?>
            <table>
                <thead>
                    <tr>
                        <th>ID Pesanan</th>
                        <th>User</th>
                        <th>Advokat</th>
                        <th>Layanan</th>
                        <th>Total</th>
                        <th>Metode</th>
                        <th>Tgl Pesan</th>
                        <th>Bukti Transfer</th>
                        <th>Status</th>
                        <th class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($pembayaran as $pmb): ?>
                        <tr>
                            <td><?= htmlspecialchars($pmb['id']) ?></td>
                            <td><?= htmlspecialchars($pmb['nama_pengguna']) ?></td>
                            <td><?= htmlspecialchars($pmb['nama_advokat']) ?></td>
                            <td><?= htmlspecialchars($pmb['nama_layanan']) ?></td>
                            <td>Rp<?= number_format($pmb['total'], 0, ',', '.') ?></td>
                            <td><?= htmlspecialchars($pmb['metode_pembayaran']) ?></td>
                            <td><?= date('d M Y H:i', strtotime($pmb['tanggal'])) ?></td>
                            <td>
                                <?php if (!empty($pmb['bukti_transfer'])): ?>
                                    <a href="../uploads/bukti_transfer/<?= htmlspecialchars($pmb['bukti_transfer']) ?>" target="_blank">
                                        <img src="../uploads/bukti_transfer/<?= htmlspecialchars($pmb['bukti_transfer']) ?>" alt="Bukti" class="bukti-img">
                                    </a>
                                <?php else: ?>
                                    Tidak ada
                                <?php endif; ?>
                            </td>
                            <td><?= htmlspecialchars(str_replace('_', ' ', strtoupper($pmb['status']))) ?></td>
                            <td class="text-center">
                                <form action="proses_verifikasi.php" method="post" style="display:inline-block;">
                                    <input type="hidden" name="payment_id" value="<?= htmlspecialchars($pmb['id']) ?>">
                                    <input type="hidden" name="status" value="terverifikasi">
                                    <button type="submit" class="btn-action btn-success">Konfirmasi</button>
                                </form>
                                <form action="proses_verifikasi.php" method="post" style="display:inline-block;">
                                    <input type="hidden" name="payment_id" value="<?= htmlspecialchars($pmb['id']) ?>">
                                    <input type="hidden" name="status" value="dibatalkan">
                                    <button type="submit" class="btn-action btn-danger">Batalkan</button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php endif; ?>
    </div>
</body>
</html>