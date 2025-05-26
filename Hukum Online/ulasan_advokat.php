<?php
$conn = new mysqli("localhost", "root", "", "layanan_hukum");

$id_advokat = $_GET['id'] ?? null;
if (!$id_advokat) {
    die("ID advokat tidak tersedia.");
}

// Ambil layanan dari advokat
$query = $conn->query("SELECT keahlian FROM advokat WHERE id = $id_advokat");
$data = $query->fetch_assoc();
$layanan = explode(", ", $data['keahlian']); // Pisahkan jadi array

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $selected_layanan = $_POST['layanan'];
    $pesan = $_POST['pesan'];
    $nama = $_POST['nama'];
    $rating = $_POST['rating'];

    $stmt = $conn->prepare("INSERT INTO ulasan (id_advokat, layanan, pesan, nama, rating) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("isssi", $id_advokat, $selected_layanan, $pesan, $nama, $rating);
    $stmt->execute();

    header("Location: detail_advokat.php?id=$id_advokat");
    exit;
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Tambah Ulasan Advokat</title>
    <style>
        body { font-family: Arial; padding: 30px; background: #f4f4f4; }
        h2 { text-align: center; }
        form {
            max-width: 500px;
            margin: auto;
            background: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        .rating {
            direction: rtl;
            unicode-bidi: bidi-override;
            text-align: left;
            margin-top: 10px;
        }
        .rating input { display: none; }
        .rating label {
            font-size: 24px;
            color: #ccc;
            cursor: pointer;
        }
        .rating input:checked ~ label,
        .rating label:hover,
        .rating label:hover ~ label {
            color: #ffc107;
        }
        input, textarea, select {
            width: 100%;
            padding: 12px;
            margin-top: 10px;
            border: 1px solid #ccc;
            border-radius: 6px;
        }
        button {
            margin-top: 20px;
            background: #004aad;
            color: white;
            border: none;
            padding: 12px;
            width: 100%;
            border-radius: 8px;
            font-size: 16px;
            cursor: pointer;
        }
    </style>
</head>
<body>

<h2>Tambah Ulasan untuk Advokat</h2>

<form method="POST">
    <label for="layanan">Jenis Layanan</label>
    <select name="layanan" required>
        <?php foreach ($layanan as $item): ?>
            <option value="<?= htmlspecialchars($item) ?>"><?= htmlspecialchars($item) ?></option>
        <?php endforeach; ?>
    </select>

    <label for="pesan">Pesan Ulasan</label>
    <textarea name="pesan" rows="5" required></textarea>

    <label for="nama">Nama / Email (anonim diperbolehkan)</label>
    <input type="text" name="nama" required>

    <label for="rating">Rating</label>
    <div class="rating">
        <input type="radio" name="rating" id="star5" value="5" required><label for="star5">&#9733;</label>
        <input type="radio" name="rating" id="star4" value="4"><label for="star4">&#9733;</label>
        <input type="radio" name="rating" id="star3" value="3"><label for="star3">&#9733;</label>
        <input type="radio" name="rating" id="star2" value="2"><label for="star2">&#9733;</label>
        <input type="radio" name="rating" id="star1" value="1"><label for="star1">&#9733;</label>
    </div>

    <button type="submit">Kirim Ulasan</button>
</form>

<!-- Tombol Kembali -->
<div class="back-button" style="text-align:center; margin-top: 20px;">
    <a href="detail_advokat.php?id=<?= $id_advokat ?>">← Kembali ke Detail Advokat</a>
</div>

</body>
</html>
