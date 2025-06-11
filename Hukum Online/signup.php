<?php
// Aktifkan reporting error untuk debugging sementara. Hapus ini setelah selesai.
error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start(); // Pastikan session_start() ada jika Anda menggunakan sesi di sini

$conn = new mysqli("localhost", "root", "", "layanan_hukum");

if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

$success = '';
$error = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nama = $conn->real_escape_string($_POST['nama']);
    $email = $conn->real_escape_string($_POST['email']);
    $password = $_POST['password'];
    $konfirmasi = $_POST['konfirmasi']; // Pastikan ini sesuai dengan nama input di HTML
    $foto = 'default.png'; // default jika tidak upload

    if ($password !== $konfirmasi) {
        $error = "Konfirmasi password tidak cocok.";
    } else {
        // Cek apakah email sudah terdaftar
        $stmt_check = $conn->prepare("SELECT id FROM users WHERE email = ?");
        $stmt_check->bind_param("s", $email);
        $stmt_check->execute();
        $cek_result = $stmt_check->get_result();

        if ($cek_result->num_rows > 0) {
            $error = "Email sudah terdaftar.";
        } else {
            // Proses upload foto jika ada
            if (!empty($_FILES["foto"]["name"])) {
                $target_dir = "uploads/";
                // Pastikan direktori 'uploads/' ada dan bisa ditulis (writable)
                if (!is_dir($target_dir)) {
                    mkdir($target_dir, 0777, true); // Buat direktori jika belum ada
                }

                $foto = time() . "_" . basename($_FILES["foto"]["name"]);
                $target_file = $target_dir . $foto;

                $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
                $allowed_types = ['jpg', 'jpeg', 'png', 'gif'];

                if (!in_array($imageFileType, $allowed_types)) {
                    $error = "Hanya file JPG, PNG, JPEG, atau GIF yang diizinkan.";
                } elseif ($_FILES["foto"]["size"] > 2 * 1024 * 1024) { // 2MB
                    $error = "Ukuran file maksimal 2MB.";
                } else {
                    if (!move_uploaded_file($_FILES["foto"]["tmp_name"], $target_file)) {
                        $error = "Gagal mengupload foto. Periksa izin folder 'uploads'.";
                    }
                }
            }

            if (!$error) { // Hanya proses insert jika tidak ada error dari validasi/upload
                $hash = password_hash($password, PASSWORD_DEFAULT);

                // Gunakan prepared statements untuk insert demi keamanan
                $stmt_insert = $conn->prepare("INSERT INTO users (nama, email, password, foto, role) VALUES (?, ?, ?, ?, 'user')");
                $stmt_insert->bind_param("ssss", $nama, $email, $hash, $foto);

                if ($stmt_insert->execute()) {
                    $success = "Pendaftaran berhasil! Silakan login.";
                    // Header refresh: Biarkan di sini agar pesan sukses terlihat sebentar
                    header("refresh:3;url=login.php");
                    exit; // Penting: exit setelah header redirect
                } else {
                    $error = "Terjadi kesalahan saat menyimpan data: " . $stmt_insert->error; // Tampilkan error dari prepared statement
                }
                $stmt_insert->close();
            }
        }
        $stmt_check->close();
    }
}
$conn->close();
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Daftar Akun - SaifulMLaw</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4; /* Mengubah dari #fefefe ke #f4f4f4 agar konsisten */
            margin: 0;
            padding: 0;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }

        /* Mengubah kelas .header Anda untuk menambahkan tombol kembali */
        .main-header { /* Ubah nama kelas dari .header menjadi .main-header agar lebih spesifik */
            background-color: #d39e00; /* Mengubah dari #d29e00 ke #d39e00 agar konsisten */
            padding: 2rem 2rem; /* Menyesuaikan padding agar sejajar dengan navbar utama */
            display: flex;
            justify-content: space-between; /* Untuk menempatkan logo dan tombol kembali di ujung */
            align-items: center;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1); /* Tambahkan shadow */
        }

        .main-header .logo-group {
            display: flex; /* Untuk mensejajarkan logo dan teks */
            align-items: center;
        }

        .main-header .logo-group img {
            height: 60px; /* Ukuran logo seperti di navbar utama Anda */
            margin-right: 15px;
        }

        .main-header .logo-group span {
            font-weight: bold;
            font-size: 20px;
            color: #22026f;
        }

        .main-header .back-button {
            display: inline-block;
            padding: 8px 15px;
            background-color: #d39e00; /* Warna tombol sesuai permintaan */
            color: #fff; /* Teks putih */
            text-decoration: none;
            border-radius: 5px;
            font-size: 14px;
            border: 1px solid #fff; /* Border putih agar lebih menonjol */
            cursor: pointer;
            transition: background-color 0.3s ease, border-color 0.3s ease;
        }

        .main-header .back-button:hover {
            background-color: #b8860b; /* Warna hover sedikit lebih gelap */
            border-color: #eee;
        }

        /* Kontainer form */
        .container {
            flex-grow: 1; /* Agar kontainer form mengisi sisa ruang vertikal */
            display: flex;
            justify-content: center;
            align-items: center;
            max-width: 100%; /* Hapus max-width dari sini, biarkan form-box yang mengatur */
            margin: 0; /* Hapus margin auto, karena flexbox akan mengatur */
            padding: 20px; /* Tambahkan padding ke container luar */
            box-sizing: border-box;
        }

        /* Signup box */
        .signup-box-custom { /* Ganti .container menjadi .signup-box-custom agar tidak bentrok */
            max-width: 400px;
            background: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0px 0px 10px rgba(0,0,0,0.1);
            text-align: center;
            width: 100%; /* Tambahkan lebar 100% untuk responsif */
        }

        .signup-box-custom h2 {
            margin-bottom: 25px;
            color: #333;
        }
        
        input[type="text"],
        input[type="email"],
        input[type="password"] {
            width: calc(100% - 24px); /* Menyesuaikan width dengan padding */
            padding: 12px;
            margin-top: 15px;
            margin-bottom: 10px;
            border-radius: 6px;
            border: 1px solid #ccc;
        }
        /* Styling untuk input file agar lebih rapi */
        input[type="file"] {
            width: calc(100% - 24px);
            padding: 12px;
            margin-top: 15px;
            margin-bottom: 10px;
            border-radius: 6px;
            border: 1px solid #ccc;
            /* Tambahan styling untuk file input agar tampilannya lebih konsisten */
            text-align: left; /* Teks "Choose File" di kiri */
            box-sizing: border-box; /* Pastikan padding dihitung dalam width */
        }
        /* Styling khusus untuk button di dalam input type="file" (Chrome/Edge/Safari) */
        input[type="file"]::file-selector-button {
            margin-right: 10px;
            border: none;
            background: #004aad;
            padding: 10px 15px;
            border-radius: 5px;
            color: #fff;
            cursor: pointer;
            transition: background .2s ease-in-out;
            text-transform: none;
        }
        input[type="file"]::file-selector-button:hover {
            background: #003380;
        }

        .btn {
            width: 100%;
            padding: 12px;
            margin-top: 10px;
            background-color: #1d2ea4;
            color: white;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            font-weight: bold;
        }

        .btn:hover {
            background-color: #0d1a6f;
        }

        .error, .success {
            font-size: 14px;
            margin-top: 15px;
            margin-bottom: 15px; /* Tambahkan margin bawah */
        }

        .error { color: red; }
        .success { color: green; }
    </style>
</head>
<body>

<nav class="main-header">
    <div class="logo-group">
        <img src="logo.png" alt="Logo">
        <span>SAIFULMLAW</span>
    </div>
    <a href="#" onclick="history.back(); return false;" class="back-button">
        &larr; Kembali
    </a>
</nav>

<div class="container">
    <div class="signup-box-custom">
        <h2>Daftar Akun Baru</h2>

        <?php if ($error): ?>
            <div class="error"><?= $error ?></div>
        <?php endif; ?>
        <?php if ($success): ?>
            <div class="success"><?= $success ?></div>
        <?php endif; ?>

        <form method="post" enctype="multipart/form-data">
            <input type="text" name="nama" placeholder="Nama Lengkap" required>
            <input type="email" name="email" placeholder="Email aktif Anda" required>
            <input type="password" name="password" placeholder="Password" required>
            <input type="password" name="konfirmasi" placeholder="Ulangi Password" required>
            <input type="file" name="foto" accept="image/*">
            <button type="submit" class="btn">Daftar Sekarang</button>
        </form>
    </div>
</div>

</body>
</html>