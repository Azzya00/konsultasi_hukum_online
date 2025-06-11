<?php
$conn = new mysqli("localhost", "root", "", "layanan_hukum");

$email = $_POST['email'];
$newPassword = password_hash($_POST['new_password'], PASSWORD_DEFAULT);

$query = $conn->query("SELECT * FROM users WHERE email = '$email'");

if ($query->num_rows > 0) {
    $conn->query("UPDATE users SET password = '$newPassword' WHERE email = '$email'");
    echo "<script>alert('Password berhasil direset'); window.location='login.html';</script>";
} else {
    echo "<script>alert('Email tidak ditemukan'); window.location='forgot_password.php';</script>";
}
?>
