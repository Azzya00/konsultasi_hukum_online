<?php
$advokat_id = $_GET['advokat_id'] ?? 0;
$layanan_id = $_GET['layanan_id'] ?? 0;

$conn = new mysqli("localhost", "root", "", "layanan_hukum");
$advokat = $conn->query("SELECT * FROM advokat WHERE id = $advokat_id")->fetch_assoc();
$layanan = $conn->query("SELECT * FROM layanan WHERE id = $layanan_id")->fetch_assoc();

$harga_layanan = $layanan['harga'];
$harga_konsultasi = 0;
$total = $harga_layanan + $harga_konsultasi;
?>

<!DOCTYPE html>
<html>
<head>
    <title>Pembayaran</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 0; background: #f9f9f9; }
        .header { background: #d29e00; padding: 20px 40px; color: white; font-size: 24px; font-weight: bold; }
        .container { display: flex; justify-content: space-around; padding: 40px; gap: 20px; flex-wrap: wrap; }
        .card, .form-box { background: white; padding: 20px; border: 1px solid #ccc; border-radius: 8px; box-shadow: 0 2px 4px rgba(0,0,0,0.1); }
        .card { width: 300px; }
        .form-box { width: 400px; }
        .rekening-box { margin-top: 10px; padding: 10px; border: 1px dashed #ccc; background: #fefefe; display: none; }
        .total-box { text-align: center; margin-top: 30px; font-size: 18px; font-weight: bold; }
        .lanjut-btn {
            background: #004aad; color: white;
            border: none; padding: 12px 30px; border-radius: 8px;
            font-size: 16px; cursor: pointer; margin-top: 20px;
        }
    </style>
</head>
<body>

<div class="header">
    <span style="font-weight: normal; font-size: 16px;">SAIFULLAW</span> &nbsp;&nbsp; Pembayaran
</div>

<div class="container">
    <!-- Profil Advokat -->
    <div class="card">
        <h3><?= $advokat['nama'] ?></h3>
        <p><strong><?= $layanan['nama_layanan'] ?></strong></p>
        <p><?= $advokat['keahlian'] ?></p>
        <p>⭐ <?= number_format($advokat['rating'], 2) ?> dari 5 (<?= $advokat['total_review'] ?> review)</p>
        <p>📆 <?= $advokat['pengalaman'] ?></p>
        <p>🎓 <?= $advokat['pendidikan'] ?></p>
    </div>

    <!-- Form Pembayaran -->
    <div class="form-box">
        <form action="proses_pembayaran.php" method="POST">
            <input type="hidden" name="advokat_id" value="<?= $advokat_id ?>">
            <input type="hidden" name="layanan_id" value="<?= $layanan_id ?>">
            <input type="hidden" id="harga_layanan" value="<?= $harga_layanan ?>">

            <label>Pilih Jenis Konsultasi:</label><br>
            <input type="radio" name="jenis_konsultasi" value="chat_telepon" onclick="updateTotal()"> Telepon dan Chat (Rp350.000)<br>
            <input type="radio" name="jenis_konsultasi" value="chat" onclick="updateTotal()"> Chat Saja (Rp30.000)<br><br>

            <label for="metode_pembayaran">Metode Pembayaran:</label><br>
            <select name="metode_pembayaran" onchange="tampilkanRekening()" required>
                <option value="">-- Pilih --</option>
                <option value="Transfer Bank">Transfer Bank</option>
                <option value="E-Wallet">E-Wallet</option>
            </select><br><br>

            <div id="rekening-info" class="rekening-box"></div>

            <label for="nama_pelanggan">Nama Anda:</label><br>
            <input type="text" name="nama_pelanggan" required><br><br>

            <label for="email_pelanggan">Email:</label><br>
            <input type="email" name="email_pelanggan" required><br><br>

            <!-- Total Harga -->
            <div class="total-box">
                Total: Rp<span id="total-display"><?= number_format($total, 0, ',', '.') ?></span>
            </div>
            <input type="hidden" name="total_harga" id="total_hidden" value="<?= $total ?>">

            <button type="submit" class="lanjut-btn">Lanjutkan Pembayaran</button>
        </form>
    </div>
</div>

<script>
    function updateTotal() {
        const hargaLayanan = parseInt(document.getElementById("harga_layanan").value);
        const radio = document.querySelector('input[name="jenis_konsultasi"]:checked');
        let hargaKonsultasi = 0;

        if (radio) {
            if (radio.value === 'chat_telepon') {
                hargaKonsultasi = 350000;
            } else if (radio.value === 'chat') {
                hargaKonsultasi = 30000;
            }
        }

        const total = hargaLayanan + hargaKonsultasi;
        document.getElementById("total-display").textContent = total.toLocaleString('id-ID');
        document.getElementById("total_hidden").value = total;
    }

    function tampilkanRekening() {
        const metode = document.querySelector('select[name="metode_pembayaran"]').value;
        const rekeningBox = document.getElementById('rekening-info');

        if (metode === 'Transfer Bank') {
            rekeningBox.innerHTML = "<strong>No. Rekening:</strong><br>BCA: 1234567890 a.n SAIFULLAW";
            rekeningBox.style.display = 'block';
        } else if (metode === 'E-Wallet') {
            rekeningBox.innerHTML = "<strong>No. E-Wallet:</strong><br>OVO/DANA: 081234567890 a.n SAIFULLAW";
            rekeningBox.style.display = 'block';
        } else {
            rekeningBox.style.display = 'none';
        }
    }
</script>

</body>
</html>
