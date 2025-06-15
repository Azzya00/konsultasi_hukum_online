<?php
include 'koneksi.php';

$result = mysqli_query($conn, "SELECT * FROM users");
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Kelola Pengguna</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f4f4f4;
            padding: 30px;
        }

        h2 {
            color: #333;
        }

        a.tambah {
            display: inline-block;
            margin-bottom: 20px;
            padding: 10px 15px;
            background-color: #004aad;
            color: white;
            text-decoration: none;
            border-radius: 5px;
        }

        a.tambah:hover {
            background-color: #003c8f;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            background: #fff;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        }

        th, td {
            border: 1px solid #ddd;
            padding: 12px;
            text-align: left;
        }

        th {
            background-color: #d29e00;
            color: white;
        }

        tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        a.hapus {
            color: #dc3545;
            font-weight: bold;
            text-decoration: none;
        }

        a.hapus:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>

<h2>Daftar Pengguna</h2>
<a href="tambah_user.php" class="tambah">+ Tambah Pengguna</a>

<table>
    <tr>
        <th>ID</th>
        <th>Nama</th>
        <th>Email</th>
        <th>Role</th>
        <th>Aksi</th>
    </tr>
    <?php while($row = mysqli_fetch_assoc($result)): ?>
    <tr>
        <td><?= htmlspecialchars($row['id']); ?></td>
        <td><?= htmlspecialchars($row['nama']); ?></td>
        <td><?= htmlspecialchars($row['email']); ?></td>
        <td><?= htmlspecialchars($row['role']); ?></td>
        <td>
            <a href="hapus_user.php?id=<?= $row['id']; ?>" class="hapus" onclick="return confirm('Yakin ingin menghapus?')">Hapus</a>
        </td>
    </tr>
    <?php endwhile; ?>
</table>

</body>
</html>
