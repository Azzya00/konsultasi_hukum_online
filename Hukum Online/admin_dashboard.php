<?php
session_start();
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    die("Akses ditolak");
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Dashboard Admin</title>
  <style>
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
    }

    body {
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
      background-color: #f8f9fa;
    }

    .header {
      background-color: #f4c10f;
      color: #212529;
      padding: 20px 40px;
      text-align: left;
      border-bottom: 3px solid #d29e00;
    }

    .header h2 {
      font-size: 24px;
      font-weight: bold;
    }

    .nav {
      background-color: #343a40;
      padding: 10px 40px;
    }

    .nav a {
      color: #f8f9fa;
      margin-right: 25px;
      text-decoration: none;
      font-weight: bold;
      transition: color 0.3s ease;
    }

    .nav a:hover {
      color: #f4c10f;
    }

    .content {
      padding: 40px;
      background-color: #ffffff;
      margin: 20px auto;
      max-width: 1000px;
      border-radius: 10px;
      box-shadow: 0 2px 8px rgba(0,0,0,0.1);
    }

    .content h3 {
      margin-bottom: 15px;
      color: #333;
    }

    .content p {
      color: #555;
    }

    @media (max-width: 768px) {
      .nav {
        display: flex;
        flex-direction: column;
      }
      .nav a {
        margin-bottom: 10px;
      }
    }
  </style>
</head>
<body>

<div class="header">
  <h2>Dashboard Admin - Selamat Datang, <?= htmlspecialchars($_SESSION['email']) ?></h2>
</div>

<div class="nav">
  <a href="kelola_users.php">Kelola Pengguna</a>
  <a href="kelola_advokat.php">Kelola Advokat</a>
  <a href="kelola_layanan.php">Kelola Layanan</a>
  <a href="logout.php">Logout</a>
</div>

<div class="content">
  <h3>Selamat datang di Panel Admin</h3>
  <p>Anda dapat mengelola data pengguna, advokat, dan layanan melalui menu navigasi di atas. Gunakan sistem ini dengan bijak dan bertanggung jawab.</p>
</div>

</body>
</html>
