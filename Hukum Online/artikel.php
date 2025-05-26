<?php
$host = "localhost";
$user = "root";
$pass = "";
$db   = "layanan_hukum";

$conn = new mysqli($host, $user, $pass, $db);
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

$id = $_GET['id'] ?? 0;
$artikel = $conn->query("SELECT * FROM artikel WHERE id = $id")->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title><?= $artikel['judul'] ?></title>
    <style>
        body {
            font-family: Arial, sans-serif;
            padding: 40px;
            line-height: 1.6;
            background: #fdfdfd;
            color: #222;
        }

        .container {
            max-width: 800px;
            margin: auto;
            background: white;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }

        h1 {
            margin-bottom: 20px;
            color: #004aad;
        }

        .back-link {
            display: inline-block;
            margin-top: 30px;
            color: #004aad;
            text-decoration: none;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1><?= $artikel['judul'] ?></h1>
        <p><?= nl2br($artikel['lengkap']) ?></p>

        <a class="back-link" href="javascript:history.back()">← Kembali</a>
    </div>
</body>
</html>
