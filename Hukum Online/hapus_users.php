<?php
session_start();

// PENTING: Pengecekan Login Admin dan Role di sini
/*
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_role'] !== 'admin') {
    header("Location: ../login.php"); // Arahkan ke halaman login admin Anda
    exit;
}
*/

$conn = new mysqli("localhost", "root", "", "layanan_hukum");
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

if (isset($_GET['id'])) {
    $user_id = $_GET['id'];

    // Optional: Hapus juga foto profil pengguna jika ada
    $stmt_select_photo = $conn->prepare("SELECT foto FROM users WHERE id = ?");
    $stmt_select_photo->bind_param("i", $user_id);
    $stmt_select_photo->execute();
    $result_photo = $stmt_select_photo->get_result();
    $user_photo_data = $result_photo->fetch_assoc();
    $stmt_select_photo->close();

    if ($user_photo_data && !empty($user_photo_data['foto'])) {
        $photo_path = '../uploads/' . $user_photo_data['foto'];
        if (file_exists($photo_path) && !is_dir($photo_path) && basename($photo_path) !== 'default.png') {
            unlink($photo_path); // Hapus file foto dari server
        }
    }

    // Hapus pengguna dari database
    $stmt = $conn->prepare("DELETE FROM users WHERE id = ?");
    if ($stmt === false) {
        die("Error preparing statement: " . $conn->error);
    }
    $stmt->bind_param("i", $user_id);

    if ($stmt->execute()) {
        echo "<script>alert('Pengguna berhasil dihapus.'); window.location='kelola_users.php';</script>";
    } else {
        echo "<script>alert('Gagal menghapus pengguna: " . $stmt->error . "'); window.location='kelola_users.php';</script>";
    }
    $stmt->close();
} else {
    echo "<script>alert('ID Pengguna tidak ditemukan.'); window.location='kelola_users.php';</script>";
}

$conn->close();
?>