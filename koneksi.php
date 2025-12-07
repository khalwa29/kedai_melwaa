<?php
<<<<<<< HEAD
// Pengaturan koneksi ke database
$host = "localhost";    // atau 127.0.0.1
$user = "root";         // username default XAMPP
$password = "";         // biasanya kosong (jika belum diubah)
$database = "db_kasir"; // ganti dengan nama database kamu

// Membuat koneksi
$koneksi = new mysqli($host, $user, $password, $database);

// Cek koneksi
if ($koneksi->connect_error) {
    die("<h3 style='color:pink;text-align:center;'>💖 Koneksi ke database gagal: " . $koneksi->connect_error . "</h3>");
}

// Jika koneksi berhasil (opsional)
# echo "<!-- 💕 Koneksi ke database berhasil -->";
?>
=======
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
>>>>>>> 4a5e0947be7db5afdb64477fe81736dacf39c30f
