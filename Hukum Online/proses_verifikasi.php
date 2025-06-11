<?php
session_start();

// PENTING: Implementasikan pengecekan login admin di sini!
/*
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_role'] !== 'admin') {
    header("Location: ../login_admin.php"); // Arahkan ke halaman login admin Anda
    exit;
}
*/

$conn = new mysqli("localhost", "root", "", "layanan_hukum");
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['payment_id']) && isset($_POST['status'])) {
    $payment_id = intval($_POST['payment_id']);
    $new_status_action = $_POST['status']; // 'terverifikasi' atau 'dibatalkan'

    // Tentukan status yang akan disimpan di database
    $database_status = '';
    if ($new_status_action == 'terverifikasi') {
        $database_status = 'selesai'; // Ubah status menjadi 'selesai' setelah verifikasi
    } elseif ($new_status_action == 'dibatalkan') {
        $database_status = 'dibatalkan';
    } else {
        // Handle status yang tidak valid
        header("Location: kelola_pembayaran.php?action=error&message=Invalid status action");
        exit;
    }

    $stmt = $conn->prepare("UPDATE pembayaran SET status = ? WHERE id = ?");
    $stmt->bind_param("si", $database_status, $payment_id);

    if ($stmt->execute()) {
        header("Location: kelola_pembayaran.php?action=success&id=" . $payment_id . "&new_status=" . $database_status);
        exit;
    } else {
        header("Location: kelola_pembayaran.php?action=error&message=" . urlencode($stmt->error));
        exit;
    }
    $stmt->close();

} else {
    // Jika tidak ada data POST yang valid
    header("Location: kelola_pembayaran.php?action=error&message=No valid data received");
    exit;
}

$conn->close();
?>