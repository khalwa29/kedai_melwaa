<?php
// File: admin/koneksi.php
$host = "localhost";
$username = "root";
$password = "";
$database = "db_kasir";

$conn = new mysqli($host, $username, $password, $database);

// Cek koneksi
if ($conn->connect_error) {
    die("<h3 style='color:pink;text-align:center;'>Koneksi gagal 💔 : " . $conn->connect_error . "</h3>");
}

// Set charset untuk mendukung karakter UTF-8
$conn->set_charset("utf8");
?>