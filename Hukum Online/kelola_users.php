<?php
session_start();

// PENTING: Implementasi Pengecekan Login Admin di Sini
/*
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_role'] !== 'admin') {
    header("Location: ../login.php");
    exit;
}
*/

$conn = new mysqli("localhost", "root", "", "layanan_hukum");
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

$users = [];
$sql = "SELECT id, nama, email, created_at, foto FROM users ORDER BY created_at DESC"; // Menambahkan 'foto'
$result = $conn->query($sql);

if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $users[] = $row;
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Kelola Pengguna</title>
    <style>
        /* CSS yang sama dengan admin_dashboard.php atau kelola_pembayaran.php */
        body { font-family: Arial, sans-serif; margin: 0; background-color: #f4f7f6; color: #333; }
        .header-admin { background-color: #34495e; color: white; padding: 20px; text-align: center; }
        .header-admin h1 { margin: 0; font-size: 28px; }
        .header-admin nav ul { list-style: none; padding: 0; margin: 10px 0 0; display: flex; justify-content: center; gap: 20px; }
        .header-admin nav a { color: white; text-decoration: none; font-weight: bold; padding: 5px 10px; border-radius: 4px; transition: background-color 0.3s ease; }
        .header-admin nav a:hover, .header-admin nav a.active { background-color: #2c3e50; }

        .container { max-width: 1000px; margin: 30px auto; padding: 20px; background: white; border-radius: 8px; box-shadow: 0 4px 10px rgba(0,0,0,0.1); }
        h2 { text-align: center; color: #2c3e50; margin-bottom: 30px; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { padding: 12px 15px; border: 1px solid #ddd; text-align: left; }
        th { background-color: #e9ecef; font-weight: bold; color: #555; }
        tr:nth-child(even) { background-color: #f8f9fa; }
        .text-center { text-align: center; }
        .btn-action { /* Gaya tombol, bisa disesuaikan */
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
        .btn-danger { background-color: #dc3545; }
        .btn-danger:hover { background-color: #c82333; }
        .user-photo {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            object-fit: cover;
            vertical-align: middle;
            margin-right: 10px;
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
                <li><a href="kelola_layanan.php">Kelola Layanan</a></li>
                <li><a href="kelola_users.php" class="active">Kelola Pengguna</a></li>
                <li><a href="../logout.php">Logout</a></li>
            </ul>
        </nav>
    </div>

    <div class="container">
        <h2>Kelola Pengguna</h2>

        <?php if (empty($users)): ?>
            <div class="empty-state">
                <p>Tidak ada pengguna terdaftar.</p>
            </div>
        <?php else: ?>
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Foto</th>
                        <th>Nama</th>
                        <th>Email</th>
                        <th>Terdaftar Sejak</th>
                        <th class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($users as $user_data): ?>
                    <tr>
                        <td><?= htmlspecialchars($user_data['id']) ?></td>
                        <td>
                            <?php
                                $photo_path = !empty($user_data['foto']) ? '../uploads/' . htmlspecialchars($user_data['foto']) : '../uploads/default.png';
                                if (!file_exists($photo_path) || is_dir($photo_path)) {
                                    $photo_path = '../uploads/default.png'; // Fallback jika file tidak ada atau bukan file
                                }
                            ?>
                            <img src="<?= $photo_path ?>" alt="Foto Pengguna" class="user-photo">
                        </td>
                        <td><?= htmlspecialchars($user_data['nama']) ?></td>
                        <td><?= htmlspecialchars($user_data['email']) ?></td>
                        <td><?= date('d M Y', strtotime($user_data['created_at'])) ?></td>
                        <td class="text-center">
                            <a href="hapus_users.php?id=<?= htmlspecialchars($user_data['id']) ?>" class="btn-action btn-danger" onclick="return confirm('Yakin ingin menghapus pengguna ini?')">Hapus</a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php endif; ?>
    </div>
</body>
</html>