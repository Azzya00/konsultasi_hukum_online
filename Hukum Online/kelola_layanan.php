<?php
include 'koneksi.php';

// Ambil daftar advokat untuk dropdown
$advokat = $conn->query("SELECT id, nama FROM advokat");

// Tambah layanan
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['tambah'])) {
    $advokat_id = $_POST['advokat_id'];
    $nama = $_POST['nama_layanan'];
    $harga = $_POST['harga'];
    $deskripsi = $_POST['deskripsi'];

    $conn->query("INSERT INTO layanan (advokat_id, nama_layanan, harga, deskripsi) 
                  VALUES ('$advokat_id', '$nama', '$harga', '$deskripsi')");
    header("Location: kelola_layanan.php");
    exit;
}

// Hapus layanan
if (isset($_GET['hapus'])) {
    $id = $_GET['hapus'];
    $conn->query("DELETE FROM layanan WHERE id = $id");
    header("Location: kelola_layanan.php");
    exit;
}

// Ambil semua layanan
$layanan = $conn->query("
    SELECT layanan.*, advokat.nama AS nama_advokat
    FROM layanan
    LEFT JOIN advokat ON layanan.advokat_id = advokat.id
");
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Kelola Layanan Advokat</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f2f2f2;
            padding: 30px;
        }

        h2, h3 {
            color: #333;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            background: #fff;
            box-shadow: 0 2px 6px rgba(0,0,0,0.1);
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
            background: #f9f9f9;
        }

        form {
            background: #fff;
            padding: 20px;
            margin-top: 40px;
            box-shadow: 0 2px 6px rgba(0,0,0,0.1);
            border-radius: 6px;
        }

        label {
            display: block;
            margin-top: 15px;
            font-weight: bold;
        }

        input, select, textarea {
            width: 100%;
            padding: 10px;
            margin-top: 6px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        button {
            margin-top: 20px;
            background-color: #004aad;
            color: white;
            padding: 10px 16px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        button:hover {
            background-color: #003d99;
        }

        a.hapus {
            color: #dc3545;
            text-decoration: none;
            font-weight: bold;
        }

        a.hapus:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>

<h2>Daftar Layanan Advokat</h2>

<table>
    <tr>
        <th>Nama Advokat</th>
        <th>Nama Layanan</th>
        <th>Harga</th>
        <th>Deskripsi</th>
        <th>Aksi</th>
    </tr>
    <?php while($row = $layanan->fetch_assoc()): ?>
    <tr>
        <td><?= htmlspecialchars($row['nama_advokat']) ?></td>
        <td><?= htmlspecialchars($row['nama_layanan']) ?></td>
        <td>Rp <?= number_format($row['harga'], 2, ',', '.') ?></td>
        <td><?= nl2br(htmlspecialchars($row['deskripsi'])) ?></td>
        <td>
            <a href="?hapus=<?= $row['id'] ?>" class="hapus" onclick="return confirm('Yakin ingin menghapus layanan ini?')">Hapus</a>
        </td>
    </tr>
    <?php endwhile; ?>
</table>

<h3>Tambah Layanan Baru</h3>
<form method="post">
    <label for="advokat_id">Advokat</label>
    <select name="advokat_id" required>
        <option value="">-- Pilih Advokat --</option>
        <?php while($a = $advokat->fetch_assoc()): ?>
            <option value="<?= $a['id'] ?>"><?= htmlspecialchars($a['nama']) ?></option>
        <?php endwhile; ?>
    </select>

    <label for="nama_layanan">Nama Layanan</label>
    <input type="text" name="nama_layanan" required>

    <label for="harga">Harga (Rp)</label>
    <input type="number" step="0.01" name="harga" required>

    <label for="deskripsi">Deskripsi</label>
    <textarea name="deskripsi" rows="4" required></textarea>

    <button type="submit" name="tambah">+ Tambah Layanan</button>
</form>

</body>
</html>
