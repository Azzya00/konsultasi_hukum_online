<?php
$conn = mysqli_connect("localhost", "root", "", "layanan_hukum");
if (!$conn) {
    die("Koneksi gagal: " . mysqli_connect_error());
}
?>
