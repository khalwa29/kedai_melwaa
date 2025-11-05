<?php
// Pengaturan koneksi ke database
$host     = "localhost";   // atau 127.0.0.1
$user     = "root";        // username default XAMPP
$password = "";            // biasanya kosong (jika belum diubah)
$database = "db_kasir";  // ganti dengan nama database kamu

// Membuat koneksi
$conn = new mysqli($host, $user, $password, $database);

// Cek koneksi
if ($conn->connect_error) {
    die("<h3 style='color:pink;text-align:center;'>💔 Koneksi ke database gagal: " . $conn->connect_error . "</h3>");
}

// Jika koneksi berhasil (opsional, bisa dihapus kalau tidak mau muncul pesan)
# echo "<!-- 💕 Koneksi ke database berhasil -->";
?>
