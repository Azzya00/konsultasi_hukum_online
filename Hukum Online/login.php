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

        if (password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['email'] = $user['email'];
            $_SESSION['role'] = $user['role'];

            // Arahkan berdasarkan role
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

        input[type="email"],
        input[type="password"] {
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
        }
    </style>
</head>
<body>

<div class="header">
    <img src="logo.png" alt="Logo">
    <span>SAIFULMLAW</span>
</div>

<div class="container">
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

</body>
</html>
