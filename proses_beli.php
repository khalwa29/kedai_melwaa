<?php
session_start();
$koneksi = new mysqli("localhost", "root", "", "db_kasir");
if ($koneksi->connect_error) {
    die("Koneksi gagal: " . $koneksi->connect_error);
}

// Ambil data dari form
$nama = $_POST['nama'];
$id_produk = $_POST['id_produk']; // array
$qty = $_POST['qty'];             // array
$catatan = $_POST['catatan'];     // array

$pesanan = [];
$total = 0;

// Loop tiap item pesanan
foreach ($id_produk as $index => $id) {
    $produk = $koneksi->query("SELECT * FROM tb_produk WHERE id_produk='$id'")->fetch_assoc();
    if ($produk) {
        $subtotal = $produk['harga_jual'] * $qty[$index];
        $total += $subtotal;
        $pesanan[] = [
            'nama_produk' => $produk['nama_produk'],
            'kategori'    => $produk['kategori'],
            'harga'       => $produk['harga_jual'],
            'qty'         => $qty[$index],
            'catatan'     => $catatan[$index],
            'subtotal'    => $subtotal
        ];
    }
}

// Simpan pesanan ke session (bisa juga ke database)
$_SESSION['pesanan'] = [
    'nama' => $nama,
    'items' => $pesanan,
    'total' => $total
];

// Redirect ke halaman struk
header("Location: struk.php");
exit;
?>
