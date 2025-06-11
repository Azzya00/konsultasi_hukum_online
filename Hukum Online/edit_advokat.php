<?php
session_start();
// PENTING: Implementasi Pengecekan Login Admin di Sini (jika belum ada)
/*
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_role'] !== 'admin') {
    header("Location: ../login_admin.php"); // Atau ke halaman login admin Anda
    exit;
}
*/

// Ganti include 'koneksi.php'; dengan koneksi langsung
$conn = new mysqli("localhost", "root", "", "layanan_hukum");
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

$id = $_GET['id'] ?? 0; // Tambahkan ?? 0 untuk menghindari error jika id tidak ada
$query = $conn->query("SELECT * FROM advokat WHERE id = $id"); // Gunakan $conn->query
$data = $query->fetch_assoc();

if (!$data) {
    echo "Data advokat tidak ditemukan.";
    exit;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nama = $_POST['nama'];
    $email = $_POST['email']; // Ambil data email dari form
    $pendidikan = $_POST['pendidikan'];
    $keahlian = $_POST['keahlian'];
    $pengalaman = $_POST['pengalaman'];
    $jenis_konsultasi = $_POST['jenis_konsultasi'];

    // Upload foto baru
    $foto = $data['foto']; // Pertahankan foto lama
    if (isset($_FILES['foto']) && $_FILES['foto']['error'] == 0) { // Cek apakah ada file diupload
        $file_name = $_FILES['foto']['name'];
        $tmp_name = $_FILES['foto']['tmp_name'];
        $target_dir = "../uploads/"; // Perhatikan path, ini relatif ke root proyek jika edit_advokat.php ada di admin/
        $ext = pathinfo($file_name, PATHINFO_EXTENSION);
        $new_file_name = uniqid() . "." . $ext;

        // Hapus foto lama jika ada dan file baru berhasil diupload
        if ($foto && file_exists($target_dir . $foto)) {
            unlink($target_dir . $foto);
        }

        if (move_uploaded_file($tmp_name, $target_dir . $new_file_name)) {
             $foto = $new_file_name;
        } else {
            // Handle error upload
            echo "Gagal mengupload foto.";
            // Anda bisa log error ini atau menampilkan pesan ke user
        }
    }

    $update = "UPDATE advokat SET
        nama = ?,
        email = ?, -- Tambahkan email
        pendidikan = ?,
        keahlian = ?,
        pengalaman = ?,
        jenis_konsultasi = ?,
        foto = ?
        WHERE id = ?";

    $stmt = $conn->prepare($update);
    // 'sssssssi' -> s = string, i = integer
    $stmt->bind_param("sssssssi", $nama, $email, $pendidikan, $keahlian, $pengalaman, $jenis_konsultasi, $foto, $id);

    if ($stmt->execute()) {
        header("Location: kelola_advokat.php");
        exit;
    } else {
        echo "Error: " . $stmt->error;
    }
    $stmt->close();
}
$conn->close();
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Edit Data Advokat</title>
    <style>
        /* CSS Umum untuk Admin Panel (Sama dengan admin_dashboard.php, kelola_pembayaran.php, kelola_advokat.php) */
        body { font-family: Arial, sans-serif; margin: 0; background-color: #f4f7f6; color: #333; }
        .header-admin { background-color: #34495e; color: white; padding: 20px; text-align: center; }
        .header-admin h1 { margin: 0; font-size: 28px; }
        .header-admin nav ul { list-style: none; padding: 0; margin: 10px 0 0; display: flex; justify-content: center; gap: 20px; }
        .header-admin nav a { color: white; text-decoration: none; font-weight: bold; padding: 5px 10px; border-radius: 4px; transition: background-color 0.3s ease; }
        .header-admin nav a:hover { background-color: #2c3e50; } /* Tidak perlu active di sub-halaman */

        .container { max-width: 800px; margin: 30px auto; padding: 20px; background: white; border-radius: 8px; box-shadow: 0 4px 10px rgba(0,0,0,0.1); }
        h2 { text-align: center; color: #2c3e50; margin-bottom: 30px; }

        /* Style untuk form */
        form label { display: block; margin-bottom: 8px; font-weight: bold; color: #555; }
        form input[type="text"],
        form input[type="email"], /* Tambahkan input type email */
        form textarea,
        form input[type="file"] {
            width: calc(100% - 22px); /* Sesuaikan padding */
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 1em;
        }
        form textarea { resize: vertical; min-height: 80px; }
        form button {
            background-color: #007bff;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 1em;
            transition: background-color 0.3s ease;
        }
        form button:hover { background-color: #0056b3; }
        .current-photo {
            margin-top: 10px;
            margin-bottom: 15px;
            text-align: center;
        }
        .current-photo img {
            max-width: 150px;
            height: auto;
            border-radius: 5px;
            border: 1px solid #ddd;
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
                <li><a href="kelola_users.php">Kelola Pengguna</a></li>
                <li><a href="../logout.php">Logout</a></li>
            </ul>
        </nav>
    </div>

    <div class="container">
        <h2>Edit Data Advokat</h2>
        <form method="post" enctype="multipart/form-data">
            <label for="nama">Nama:</label>
            <input type="text" id="nama" name="nama" value="<?= htmlspecialchars($data['nama']) ?>" required>

            <label for="email">Email:</label>
            <input type="email" id="email" name="email" value="<?= htmlspecialchars($data['email']) ?>" required>

            <label for="pendidikan">Pendidikan:</label>
            <textarea id="pendidikan" name="pendidikan" rows="3" required><?= htmlspecialchars($data['pendidikan']) ?></textarea>

            <label for="keahlian">Keahlian:</label>
            <textarea id="keahlian" name="keahlian" rows="3" required><?= htmlspecialchars($data['keahlian']) ?></textarea>

            <label for="pengalaman">Pengalaman:</label>
            <input type="text" id="pengalaman" name="pengalaman" value="<?= htmlspecialchars($data['pengalaman']) ?>" required>

            <label for="jenis_konsultasi">Jenis Konsultasi:</label>
            <input type="text" id="jenis_konsultasi" name="jenis_konsultasi" value="<?= htmlspecialchars($data['jenis_konsultasi']) ?>" required>

            <label for="foto">Foto (kosongkan jika tidak ingin mengganti):</label>
            <?php if ($data['foto']) : ?>
                <div class="current-photo">
                    <p>Foto Saat Ini:</p>
                    <img src="../uploads/<?= htmlspecialchars($data['foto']) ?>" alt="Foto Advokat Saat Ini"><br>
                </div>
            <?php endif; ?>
            <input type="file" id="foto" name="foto" accept="image/*">

            <button type="submit">Simpan Perubahan</button>
        </form>
    </div>
</body>
</html>