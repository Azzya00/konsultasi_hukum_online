<?php
session_start();

// PENTING: Implementasi Pengecekan Login Admin di Sini (jika belum ada)
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

$layanan = [];
$sql = "SELECT id, nama_layanan, deskripsi, harga FROM layanan ORDER BY nama_layanan ASC";
$result = $conn->query($sql);

if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $layanan[] = $row;
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Kelola Layanan</title>
    <style>
        /* CSS Umum untuk Admin Panel (Sama dengan admin_dashboard.php, kelola_pembayaran.php, kelola_advokat.php) */
        body { font-family: Arial, sans-serif; margin: 0; background-color: #f4f7f6; color: #333; }
        .header-admin { background-color: #34495e; color: white; padding: 20px; text-align: center; }
        .header-admin h1 { margin: 0; font-size: 28px; }
        .header-admin nav ul { list-style: none; padding: 0; margin: 10px 0 0; display: flex; justify-content: center; gap: 20px; }
        .header-admin nav a { color: white; text-decoration: none; font-weight: bold; padding: 5px 10px; border-radius: 4px; transition: background-color 0.3s ease; }
        .header-admin nav a:hover, .header-admin nav a.active { background-color: #2c3e50; }

        .container { max-width: 900px; margin: 30px auto; padding: 20px; background: white; border-radius: 8px; box-shadow: 0 4px 10px rgba(0,0,0,0.1); }
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
        }
        .btn-primary { background-color: #007bff; } /* Untuk tombol Edit */
        .btn-primary:hover { background-color: #0056b3; }
        .btn-danger { background-color: #dc3545; }
        .btn-danger:hover { background-color: #c82333; }
        .btn-success { background-color: #28a745; } /* Untuk tombol Tambah Layanan */
        .btn-success:hover { background-color: #218838; }

        .table-actions {
            text-align: right;
            margin-bottom: 15px;
        }
    </style>
</head>
<body>
    <div class="header-admin">
        <h1>Admin Panel</h1>
        <nav>
            <ul>
                <li><a href="admin_dashboard.php">Dashboard</a></li>
                <li><a href="kelola_pembayaran.php">Kelola Pembayaran</a></li>
                <li><a href="kelola_advokat.php">Kelola Advokat</a></li>
                <li><a href="kelola_layanan.php" class="active">Kelola Layanan</a></li>
                <li><a href="kelola_users.php">Kelola Pengguna</a></li>
                <li><a href="../logout.php">Logout</a></li>
            </ul>
        </nav>
    </div>

    <div class="container">
        <h2>Kelola Layanan Hukum</h2>

        <div class="table-actions">
            <a href="tambah_layanan.php" class="btn-action btn-success">Tambah Layanan Baru</a>
        </div>

        <?php if (empty($layanan)): ?>
            <div class="empty-state">
                <p>Tidak ada layanan hukum terdaftar.</p>
            </div>
        <?php else: ?>
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nama Layanan</th>
                        <th>Deskripsi</th>
                        <th>Harga</th>
                        <th class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($layanan as $lay): ?>
                    <tr>
                        <td><?= htmlspecialchars($lay['id']) ?></td>
                        <td><?= htmlspecialchars($lay['nama_layanan']) ?></td>
                        <td><?= htmlspecialchars(substr($lay['deskripsi'], 0, 100)) ?>...</td> <td>Rp<?= number_format($lay['harga'], 0, ',', '.') ?></td>
                        <td class="text-center">
                            <a href="edit_layanan.php?id=<?= htmlspecialchars($lay['id']) ?>" class="btn-action btn-primary">Edit</a>
                            <a href="hapus_layanan.php?id=<?= htmlspecialchars($lay['id']) ?>" class="btn-action btn-danger" onclick="return confirm('Yakin ingin menghapus layanan ini?')">Hapus</a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php endif; ?>
    </div>
</body>
</html>