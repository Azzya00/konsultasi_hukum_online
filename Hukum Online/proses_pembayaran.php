<?php
session_start();

$conn = new mysqli("localhost", "root", "", "layanan_hukum");
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user_id = $_POST['user_id'] ?? $_SESSION['user_id']; // Ambil dari POST atau SESSION
    $advokat_id = $_POST['advokat_id'] ?? 0;
    $layanan_id = $_POST['layanan_id'] ?? 0;
    $total_pembayaran = $_POST['total_pembayaran'] ?? 0;
    $metode_pembayaran = $_POST['metode_pembayaran'] ?? '';
    $jenis_konsultasi = $_POST['jenis_konsultasi'] ?? 'chat_saja'; // Default, sesuaikan

    $bukti_transfer_name = null;

    // Proses Upload Bukti Transfer
    if (isset($_FILES['bukti_transfer']) && $_FILES['bukti_transfer']['error'] == UPLOAD_ERR_OK) {
        $target_dir = "uploads/bukti_transfer/"; // Pastikan folder ini ada di root proyek
        if (!is_dir($target_dir)) {
            mkdir($target_dir, 0777, true); // Buat folder jika belum ada
        }

        $file_name = basename($_FILES["bukti_transfer"]["name"]);
        $file_type = pathinfo($file_name, PATHINFO_EXTENSION);
        $new_file_name = uniqid('bukti_') . '.' . $file_type;
        $target_file = $target_dir . $new_file_name;

        // Izinkan format gambar tertentu
        $allowed_types = ['jpg', 'jpeg', 'png', 'gif', 'pdf']; // Tambahkan pdf jika dibutuhkan
        if (in_array(strtolower($file_type), $allowed_types)) {
            if (move_uploaded_file($_FILES["bukti_transfer"]["tmp_name"], $target_file)) {
                $bukti_transfer_name = $new_file_name;
            } else {
                // Gagal upload
                header("Location: pembayaran.php?status=error_upload");
                exit;
            }
        } else {
            // Tipe file tidak diizinkan
            header("Location: pembayaran.php?status=error_invalid_file_type");
            exit;
        }
    } else {
        // Tidak ada file diupload atau ada error upload
        header("Location: pembayaran.php?status=error_no_file_uploaded");
        exit;
    }

    // Insert data pembayaran ke database
    $status = 'menunggu_verifikasi'; // Set status awal pembayaran

    $stmt = $conn->prepare("INSERT INTO pembayaran (user_id, advokat_id, layanan_id, total, metode_pembayaran, jenis_konsultasi, bukti_transfer, tanggal, status) VALUES (?, ?, ?, ?, ?, ?, ?, NOW(), ?)");
    $stmt->bind_param("iiidssss", $user_id, $advokat_id, $layanan_id, $total_pembayaran, $metode_pembayaran, $jenis_konsultasi, $bukti_transfer_name, $status);

    if ($stmt->execute()) {
        $last_id = $stmt->insert_id; // Dapatkan ID pembayaran yang baru saja dibuat
        header("Location: konfirmasi_pembayaran.php?id=" . $last_id); // Redirect ke halaman konfirmasi user dengan ID pembayaran
        exit;
    } else {
        echo "Error: " . $stmt->error;
    }
    $stmt->close();
} else {
    // Jika bukan metode POST, redirect ke halaman utama
    header("Location: index.php");
    exit;
}

$conn->close();
?>