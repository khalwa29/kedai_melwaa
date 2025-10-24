<?php
session_start();

// Pastikan user sudah login
if (!isset($_SESSION["email"])) {
    header("Location: login.php");
    exit;
}

// Koneksi database
$koneksi = new mysqli("localhost", "root", "", "db_chatgpt");
if ($koneksi->connect_error) {
    die("Koneksi gagal: " . $koneksi->connect_error);
}

// Cek POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id_transaksi = $_POST['id_transaksi'] ?? '';
    $jumlah_bayar = $_POST['jumlah_bayar'] ?? '';

    if (empty($id_transaksi) || empty($jumlah_bayar)) {
        $_SESSION['error'] = "ID transaksi dan jumlah bayar wajib diisi.";
        header("Location: pembayaran.php");
        exit;
    }

    // Update status pembayaran
    $stmt = $koneksi->prepare("UPDATE tb_jual SET status='Lunas', jumlah_bayar=? WHERE id_jual=?");
    $stmt->bind_param("di", $jumlah_bayar, $id_transaksi);

    if ($stmt->execute()) {
        $_SESSION['success'] = "Pembayaran berhasil diproses.";
        // Redirect langsung ke laporan
        header("Location: laporan.php");
        exit;
    } else {
        $_SESSION['error'] = "Terjadi kesalahan: " . $stmt->error;
        header("Location: pembayaran.php");
        exit;
    }
    $stmt->close();
}
$koneksi->close();
?>
