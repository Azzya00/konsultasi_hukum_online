<?php
include 'koneksi.php';

// Proses hapus
if (isset($_GET['hapus'])) {
    $id = $_GET['hapus'];

    // Hapus foto dari folder jika ada
    $foto_q = mysqli_query($conn, "SELECT foto FROM advokat WHERE id = $id");
    $foto = mysqli_fetch_assoc($foto_q)['foto'];
    if ($foto && file_exists("uploads_advokat/$foto")) {
        unlink("uploads_advokat/$foto");
    }

    mysqli_query($conn, "DELETE FROM advokat WHERE id = $id");
    header("Location: kelola_advokat.php");
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Kelola Advokat</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f2f2f2;
            padding: 30px;
        }

        h2 {
            color: #333;
        }

        a.tambah {
            display: inline-block;
            margin-bottom: 15px;
            background: #004aad;
            color: white;
            padding: 8px 14px;
            border-radius: 5px;
            text-decoration: none;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            background: white;
            box-shadow: 0 2px 6px rgba(0,0,0,0.1);
        }

        table th, table td {
            padding: 12px 10px;
            border: 1px solid #ccc;
            text-align: center;
        }

        th {
            background: #d29e00;
            color: white;
        }

        img {
            border-radius: 50%;
            object-fit: cover;
        }

        a.edit, a.hapus {
            padding: 5px 10px;
            border-radius: 4px;
            text-decoration: none;
            color: white;
        }

        a.edit {
            background: #28a745;
        }

        a.hapus {
            background: #dc3545;
        }
    </style>
</head>
<body>

<h2>Kelola Data Advokat</h2>
<a href="tambah_advokat.php" class="tambah">+ Tambah Advokat</a>

<table>
    <tr>
        <th>No</th>
        <th>Nama</th>
        <th>Pendidikan</th>
        <th>Keahlian</th>
        <th>Pengalaman</th>
        <th>Jenis Konsultasi</th>
        <th>Foto</th>
        <th>Aksi</th>
    </tr>
    <?php
    $no = 1;
    $query = mysqli_query($conn, "SELECT * FROM advokat");
    while ($data = mysqli_fetch_assoc($query)) :
    ?>
    <tr>
        <td><?= $no++ ?></td>
        <td><?= htmlspecialchars($data['nama']) ?></td>
        <td><?= htmlspecialchars($data['pendidikan']) ?></td>
        <td><?= htmlspecialchars($data['keahlian']) ?></td>
        <td><?= htmlspecialchars($data['pengalaman']) ?></td>
        <td><?= htmlspecialchars($data['jenis_konsultasi']) ?></td>
        <td>
            <?php if ($data['foto']) : ?>
                <img src="uploads_advokat/<?= htmlspecialchars($data['foto']) ?>" width="60" height="60">
            <?php else : ?>
                Tidak ada
            <?php endif; ?>
        </td>
        <td>
            <a href="edit_advokat.php?id=<?= $data['id'] ?>" class="edit">Edit</a>
            <a href="kelola_advokat.php?hapus=<?= $data['id'] ?>" class="hapus" onclick="return confirm('Yakin ingin menghapus?')">Hapus</a>
        </td>
    </tr>
    <?php endwhile; ?>
</table>

</body>
</html>
