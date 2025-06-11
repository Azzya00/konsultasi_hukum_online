<?php
session_start();

// Cek apakah user sudah login
if (!isset($_SESSION['user_id'])) {
    // Jika belum login, arahkan ke halaman login
    header("Location: login.php");
    exit;
}

// Ambil data user dari database
$conn = new mysqli("localhost", "root", "", "layanan_hukum");

if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

$user_id = $_SESSION['user_id'];
$sql = "SELECT * FROM users WHERE id = $user_id LIMIT 1";
$result = $conn->query($sql);
$user = $result->fetch_assoc();

$conn->close();
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Profil Pengguna</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f4f4f4;
            margin: 0;
            padding: 0;
        }
        .profile-container {
            max-width: 500px;
            margin: 80px auto;
            background: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0,0,0,0.1);
        }
        h2 {
            text-align: center;
            color: #333;
        }
        .info {
            margin-top: 20px;
        }
        .info label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
            color: #444;
        }
        .info p {
            margin-top: 0;
            margin-bottom: 20px;
            background: #f9f9f9;
            padding: 10px;
            border-radius: 5px;
            border: 1px solid #ddd;
        }
        .logout {
            text-align: center;
            margin-top: 20px;
        }
        .logout a {
            background: #e74c3c;
            color: white;
            padding: 10px 20px;
            border-radius: 5px;
            text-decoration: none;
        }
    </style>
</head>
<body>

<div class="profile-container">
    <h2>Profil Pengguna</h2>

    <div class="info">
        <label>Email:</label>
        <p><?= htmlspecialchars($user['email']) ?></p>

        <label>Peran (Role):</label>
        <p><?= htmlspecialchars($user['role']) ?></p>

        <label>Dibuat pada:</label>
        <p><?= htmlspecialchars($user['created_at']) ?></p>
    </div>

    <div class="logout">
        <a href="logout.php">Logout</a>
    </div>
</div>

</body>
</html>
