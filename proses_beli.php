<?php
session_start();

// Koneksi ke database
$koneksi = new mysqli("localhost", "root", "", "db_kasir");
if ($koneksi->connect_error) {
    die("Koneksi gagal: " . $koneksi->connect_error);
}

// Pastikan data dikirim via POST dan ada id_produk
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['id_produk'])) {
    $id_produk = intval($_POST['id_produk']);
    $qty = intval($_POST['qty'] ?? 1);

    // Ambil data produk berdasarkan ID
    $stmt = $koneksi->prepare("SELECT * FROM tb_produk WHERE id_produk = ?");
    $stmt->bind_param("i", $id_produk);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $produk = $result->fetch_assoc();

        // Buat keranjang jika belum ada
        if (!isset($_SESSION['keranjang'])) {
            $_SESSION['keranjang'] = [];
        }

        // Cek apakah produk sudah ada di keranjang
        $found = false;
        foreach ($_SESSION['keranjang'] as &$item) {
            if ($item['id_produk'] == $id_produk) {
                $item['qty'] += $qty;
                $found = true;
                break;
            }
        }

        // Jika belum ada, tambahkan produk baru
        if (!$found) {
            $_SESSION['keranjang'][] = [
                'id_produk' => $produk['id_produk'],
                'nama_produk' => $produk['nama_produk'],
                'harga' => $produk['harga_jual'],
                'foto' => $produk['foto'],
                'qty' => $qty
            ];
        }

        // Redirect kembali ke beli.php dengan pesan sukses
        header("Location: beli.php?success=" . urlencode($produk['nama_produk'] . " telah ditambahkan ke keranjang."));
        exit;
    } else {
        echo "<script>alert('Produk tidak ditemukan!');window.location='beli.php';</script>";
    }
} else {
    header("Location: beli.php");
    exit;
}
?>
