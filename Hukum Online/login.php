<?php
session_start();
$error = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $conn = new mysqli("localhost", "root", "", "layanan_hukum");

    if ($conn->connect_error) {
        die("Koneksi gagal: " . $conn->connect_error);
    }

    $email = $conn->real_escape_string($_POST['email']);
    $password = $_POST['password'];

    $sql = "SELECT * FROM users WHERE email='$email' LIMIT 1";
    $result = $conn->query($sql);

    if ($result->num_rows === 1) {
        $user = $result->fetch_assoc();

        // Pastikan password_verify berfungsi. Cek apakah password di DB Anda sudah di-hash.
        // Jika password di DB masih plain text, password_verify akan selalu false.
        // Anda mungkin perlu mengubahnya menjadi $password === $user['password']
        // TAPI SANGAT DISARANKAN UNTUK SELALU MENGGUNAKAN password_hash() SAAT REGISTRASI.
        if (password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['email'] = $user['email'];
            $_SESSION['role'] = $user['role'];
            $_SESSION['foto'] = $user['foto'];

            if ($user['role'] === 'admin') {
                header("Location: admin_dashboard.php");
            } else {
                header("Location: index.php");
            }
            exit;
        } else {
            $error = "Password salah!";
        }
    } else {
        $error = "Email tidak ditemukan!";
    }

    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Login - SaifulMLaw</title>
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

        /* Login box */
        .login-box-custom { /* Ganti .container menjadi .login-box-custom agar tidak bentrok */
            max-width: 400px;
            background: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0px 0px 10px rgba(0,0,0,0.1);
            text-align: center;
            width: 100%; /* Tambahkan lebar 100% untuk responsif */
        }

        .login-box-custom h2 {
            margin-bottom: 25px;
            color: #333;
        }

        .login-box-custom p {
            margin-bottom: 20px;
            color: #666;
            font-size: 15px;
        }

        input[type="email"],
        input[type="password"] {
            width: calc(100% - 24px); /* Menyesuaikan width dengan padding */
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

        .forgot {
            text-align: right;
            font-size: 14px;
            margin-top: -5px;
            margin-bottom: 20px;
        }

        .forgot a {
            color: gray;
            text-decoration: none;
        }

        .privacy {
            font-size: 13px;
            margin-top: 25px;
        }

        .privacy a {
            color: #1d2ea4;
            text-decoration: underline;
        }

        .error {
            color: red;
            font-size: 14px;
            margin-top: 10px;
            margin-bottom: 15px; /* Tambahkan margin bawah agar tidak terlalu mepet form */
        }
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
    <div class="login-box-custom">
        <h2>Masukkan email aktif</h2>
        <p>untuk menggunakan layanan SaifulMLaw dan melihat riwayat konsultasi Anda.</p>

        <?php if ($error): ?>
            <div class="error"><?= $error ?></div>
        <?php endif; ?>

        <form method="post">
            <input type="email" name="email" placeholder="Masukkan email..." required>
            <input type="password" name="password" placeholder="Masukkan kata sandi..." required>

            <div class="forgot">
                <a href="forgot_password.php">Forgot your password?</a>
            </div>

            <button type="submit" class="btn">Sign In</button>
            <button type="button" class="btn" onclick="location.href='signup.php'">Sign Up</button>

            <div class="privacy">
                Privasi Anda terjaga, <a href="#">pelajari lebih lanjut</a>.
            </div>
        </form>
    </div>
</div>

</body>
</html>