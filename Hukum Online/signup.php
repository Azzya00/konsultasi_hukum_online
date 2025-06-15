<?php
$conn = new mysqli("localhost", "root", "", "layanan_hukum");

$success = '';
$error = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nama = $conn->real_escape_string($_POST['nama']);
    $email = $conn->real_escape_string($_POST['email']);
    $password = $_POST['password'];
    $konfirmasi = $_POST['konfirmasi'];
    $foto = 'default.png'; // default jika tidak upload

    if ($password !== $konfirmasi) {
        $error = "Konfirmasi password tidak cocok.";
    } else {
        $cek = $conn->query("SELECT * FROM users WHERE email = '$email'");
        if ($cek->num_rows > 0) {
            $error = "Email sudah terdaftar.";
        } else {
            // Proses upload foto jika ada
            if (!empty($_FILES["foto"]["name"])) {
                $target_dir = "uploads/";
                $foto = time() . "_" . basename($_FILES["foto"]["name"]);
                $target_file = $target_dir . $foto;

                $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
                $allowed_types = ['jpg', 'jpeg', 'png', 'gif'];

                if (!in_array($imageFileType, $allowed_types)) {
                    $error = "Hanya file JPG, PNG, JPEG, atau GIF yang diizinkan.";
                } elseif ($_FILES["foto"]["size"] > 2 * 1024 * 1024) {
                    $error = "Ukuran file maksimal 2MB.";
                } else {
                    move_uploaded_file($_FILES["foto"]["tmp_name"], $target_file);
                }
            }

            if (!$error) {
                $hash = password_hash($password, PASSWORD_DEFAULT);
                $sql = "INSERT INTO users (nama, email, password, foto, role) 
                        VALUES ('$nama', '$email', '$hash', '$foto', 'user')";

                if ($conn->query($sql) === TRUE) {
                    $success = "Pendaftaran berhasil! Silakan login.";
                    header("refresh:2;url=login.php");
                } else {
                    $error = "Terjadi kesalahan saat menyimpan data.";
                }
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Daftar Akun - SaifulMLaw</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #fefefe;
            margin: 0;
            padding: 0;
        }

        .header {
            background-color: #d29e00;
            padding: 20px;
            display: flex;
            align-items: center;
        }

        .header img {
            height: 50px;
            margin-right: 15px;
        }

        .header span {
            font-weight: bold;
            font-size: 20px;
            color: #22026f;
        }

        .container {
            max-width: 400px;
            margin: 60px auto;
            background: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0px 0px 10px rgba(0,0,0,0.1);
            text-align: center;
        }

        input[type="text"],
        input[type="email"],
        input[type="password"],
        input[type="file"] {
            width: 100%;
            padding: 12px;
            margin-top: 15px;
            margin-bottom: 10px;
            border-radius: 6px;
            border: 1px solid #ccc;
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
        }

        .error { color: red; }
        .success { color: green; }
    </style>
</head>
<body>

<div class="header">
    <img src="logo.png" alt="Logo">
    <span>SAIFULMLAW</span>
</div>

<div class="container">
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

</body>
</html>
