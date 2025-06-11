<?php
session_start();
$conn = new mysqli("localhost", "root", "", "layanan_hukum");

$email = $_POST['email'];
$password = $_POST['password'];

$query = $conn->query("SELECT * FROM users WHERE email = '$email'");
$user = $query->fetch_assoc();

if ($user && password_verify($password, $user['password'])) {
    $_SESSION['user'] = $user;

    if ($user['role'] === 'admin') {
        header("Location: admin_dashboard.php");
    } else {
        header("Location: user_dashboard.php");
    }
} else {
    echo "<script>alert('Login gagal! Email atau password salah.'); window.location='login.html';</script>";
}
?>
