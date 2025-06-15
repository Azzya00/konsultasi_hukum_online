<?php
include 'koneksi.php';

$id = $_GET['id'];
$query = mysqli_query($conn, "SELECT * FROM advokat WHERE id = $id");
$data = mysqli_fetch_assoc($query);

if (!$data) {
    echo "Data tidak ditemukan.";
    exit;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nama = $_POST['nama'];
    $pendidikan = $_POST['pendidikan'];
    $keahlian = $_POST['keahlian'];
    $pengalaman = $_POST['pengalaman'];
    $jenis_konsultasi = $_POST['jenis_konsultasi'];

    // Upload foto baru
    $foto = $data['foto'];
    if ($_FILES['foto']['name']) {
        $file_name = $_FILES['foto']['name'];
        $tmp_name = $_FILES['foto']['tmp_name'];
        $target_dir = "uploads/";
        $ext = pathinfo($file_name, PATHINFO_EXTENSION);
        $new_file_name = uniqid() . "." . $ext;

        // Hapus foto lama
        if ($foto && file_exists($target_dir . $foto)) {
            unlink($target_dir . $foto);
        }

        move_uploaded_file($tmp_name, $target_dir . $new_file_name);
        $foto = $new_file_name;
    }

    $update = "UPDATE advokat SET 
        nama = '$nama',
        pendidikan = '$pendidikan',
        keahlian = '$keahlian',
        pengalaman = '$pengalaman',
        jenis_konsultasi = '$jenis_konsultasi',
        foto = '$foto'
        WHERE id = $id";

    mysqli_query($conn, $update);
    header("Location: kelola_advokat.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Edit Data Advokat</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f4f4f4;
            padding: 30px;
        }

        h2 {
            color: #333;
        }

        form {
            background: #fff;
            padding: 25px;
            border-radius: 8px;
            max-width: 600px;
            margin-top: 20px;
            box-shadow: 0 2px 6px rgba(0,0,0,0.1);
        }

        label {
            display: block;
            margin-top: 15px;
            font-weight: bold;
        }

        input[type="text"],
        textarea,
        input[type="file"] {
            width: 100%;
            padding: 10px;
            margin-top: 5px;
            border-radius: 5px;
            border: 1px solid #ccc;
            font-size: 14px;
        }

        button {
            margin-top: 20px;
            background: #004aad;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 6px;
            font-size: 16px;
            cursor: pointer;
        }

        button:hover {
            background: #003c8f;
        }

        img {
            margin-top: 10px;
            border-radius: 6px;
            border: 1px solid #ccc;
        }
    </style>
</head>
<body>

<h2>Edit Data Advokat</h2>

<form method="post" enctype="multipart/form-data">
    <label>Nama:</label>
    <input type="text" name="nama" value="<?= htmlspecialchars($data['nama']) ?>" required>

    <label>Pendidikan:</label>
    <textarea name="pendidikan" rows="3" required><?= htmlspecialchars($data['pendidikan']) ?></textarea>

    <label>Keahlian:</label>
    <textarea name="keahlian" rows="3" required><?= htmlspecialchars($data['keahlian']) ?></textarea>

    <label>Pengalaman:</label>
    <input type="text" name="pengalaman" value="<?= htmlspecialchars($data['pengalaman']) ?>" required>

    <label>Jenis Konsultasi:</label>
    <input type="text" name="jenis_konsultasi" value="<?= htmlspecialchars($data['jenis_konsultasi']) ?>" required>

    <label>Foto (kosongkan jika tidak ingin mengganti):</label>
    <?php if ($data['foto']) : ?>
        <img src="uploads/<?= $data['foto'] ?>" width="100"><br>
    <?php endif; ?>
    <input type="file" name="foto">

    <button type="submit">Simpan Perubahan</button>
</form>

</body>
</html>
