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

// ===========================
// 1️⃣ Buat nomor faktur otomatis
// ===========================
$q_faktur = $koneksi->query("SELECT MAX(nomor_faktur) AS faktur_terakhir FROM tb_jual");
$d_faktur = $q_faktur->fetch_assoc();
$last_faktur = $d_faktur['faktur_terakhir'];

if ($last_faktur) {
    $num = (int) substr($last_faktur, 3); // ambil angka setelah 'FAK'
    $new_num = $num + 1;
    $nomor_faktur = "FAK" . str_pad($new_num, 3, "0", STR_PAD_LEFT);
} else {
    $nomor_faktur = "FAK001";
}

// ===========================
// 2️⃣ Hitung total & simpan detail ke tb_rinci_jual
// ===========================
$total_belanja = 0;

foreach ($id_produk as $index => $id) {
    $produk = $koneksi->query("SELECT * FROM tb_produk WHERE id_produk='$id'")->fetch_assoc();
    if ($produk) {
        $harga_modal = $produk['harga_modal'];
        $harga_jual  = $produk['harga_jual'];
        $jumlah      = $qty[$index];
        $total_harga = $harga_jual * $jumlah;
        $untung      = ($harga_jual - $harga_modal) * $jumlah;
        $total_belanja += $total_harga;

        $koneksi->query("INSERT INTO rinci_jual 
            (nomor_faktur, kode_produk, nama_produk, harga_modal, harga_jual, qty, total_harga, untung)
            VALUES 
            ('$nomor_faktur', '{$produk['kode_produk']}', '{$produk['nama_produk']}', 
             '$harga_modal', '$harga_jual', '$jumlah', '$total_harga', '$untung')");
    }
}

// ===========================
// 3️⃣ Simpan ke tb_jual
// ===========================
$total_bayar = $total_belanja; // bisa diubah kalau pakai pembayaran e-wallet, tunai, dll
$kembalian = 0; // nanti dihitung sesuai metode bayar

$koneksi->query("INSERT INTO tb_jual (nomor_faktur, tanggal_beli, total_belanja, total_bayar, kembalian)
VALUES ('$nomor_faktur', NOW(), '$total_belanja', '$total_bayar', '$kembalian')");

// ===========================
// 4️⃣ Simpan juga ke session (opsional, kalau masih dipakai)
// ===========================
$_SESSION['pesanan'] = [
    'nama' => $nama,
    'nomor_faktur' => $nomor_faktur,
    'total' => $total_belanja
];

// ===========================
// 5️⃣ Redirect ke halaman struk
// ===========================
header("Location: struk.php?nomor_faktur=$nomor_faktur");
exit;
?>
