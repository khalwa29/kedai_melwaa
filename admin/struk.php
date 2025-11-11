<?php
include "koneksi.php";

// --- Validasi nomor faktur ---
if (!isset($_GET['nomor_faktur']) || empty($_GET['nomor_faktur'])) {
    die("<h3 style='text-align:center;color:red;'>Nomor faktur tidak ditemukan!</h3>");
}

$nomor_faktur = mysqli_real_escape_string($koneksi, $_GET['nomor_faktur']);

// --- Ambil data transaksi utama ---
$q = mysqli_query($koneksi, "SELECT * FROM tb_jual WHERE nomor_faktur='$nomor_faktur'");
if (!$q || mysqli_num_rows($q) == 0) {
    die("<h3 style='text-align:center;color:red;'>Data transaksi dengan nomor faktur $nomor_faktur tidak ditemukan!</h3>");
}
$d = mysqli_fetch_assoc($q);

// --- Ambil data rincian barang ---
$q_detail = mysqli_query($koneksi, "SELECT * FROM rinci_jual WHERE nomor_faktur='$nomor_faktur'");

// --- Ambil metode pembayaran dari URL (opsional) ---
$metode = isset($_GET['metode']) ? $_GET['metode'] : 'Tunai';
$ewallet = isset($_GET['ewallet']) ? $_GET['ewallet'] : '-';
?>

<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Struk Pembelian</title>
<style>
body {
    font-family: "Courier New", monospace;
    width: 320px;
    margin: 20px auto;
    border: 1px dashed #000;
    padding: 10px;
}
h2, h3 {
    text-align: center;
    margin: 0;
}
p, td, th {
    font-size: 13px;
}
table {
    width: 100%;
    border-collapse: collapse;
}
td, th {
    padding: 3px;
}
.text-right { text-align: right; }
.text-center { text-align: center; }
hr { border: none; border-top: 1px dashed #000; }
.print { margin-top: 10px; text-align: center; }
button {
    background: #333;
    color: white;
    padding: 6px 12px;
    border: none;
    border-radius: 5px;
    cursor: pointer;
}
button:hover {
    background: #555;
}
</style>
</head>

<body>

<h2>TOKO MAKMUR JAYA</h2>
<p class="text-center">Jl. Raya No.123 - Telp: 0812-3456-7890</p>
<hr>

<table>
<tr>
    <td>No. Faktur</td>
    <td>: <?= htmlspecialchars($d['nomor_faktur']) ?></td>
</tr>
<tr>
    <td>Tanggal</td>
    <td>: <?= date("d-m-Y H:i", strtotime($d['tanggal_beli'])) ?></td>
</tr>
<tr>
    <td>Metode Bayar</td>
    <td>: <?= htmlspecialchars($metode) ?></td>
</tr>
<?php if ($metode == 'E-Wallet'): ?>
<tr>
    <td>Nama E-Wallet</td>
    <td>: <?= htmlspecialchars($ewallet) ?></td>
</tr>
<?php endif; ?>
</table>

<hr>
<table>
<tr>
    <th>Nama</th>
    <th>Qty</th>
    <th class="text-right">Harga</th>
    <th class="text-right">Sub</th>
</tr>

<?php if (mysqli_num_rows($q_detail) > 0): ?>
    <?php while ($p = mysqli_fetch_assoc($q_detail)) { ?>
    <tr>
        <td><?= htmlspecialchars($p['nama_produk']) ?></td>
        <td><?= $p['qty'] ?></td>
        <td class="text-right"><?= number_format($p['harga_jual'], 0, ',', '.') ?></td>
        <td class="text-right"><?= number_format($p['total_harga'], 0, ',', '.') ?></td>
    </tr>
    <?php } ?>
<?php else: ?>
    <tr><td colspan="4" class="text-center">Tidak ada data barang.</td></tr>
<?php endif; ?>

</table>
<hr>

<table>
<tr>
    <td>Total Belanja</td>
    <td class="text-right">Rp <?= number_format($d['total_belanja'], 0, ',', '.') ?></td>
</tr>
<tr>
    <td>Total Bayar</td>
    <td class="text-right">Rp <?= number_format($d['total_bayar'], 0, ',', '.') ?></td>
</tr>
<tr>
    <td>Kembalian</td>
    <td class="text-right">Rp <?= number_format($d['kembalian'], 0, ',', '.') ?></td>
</tr>
</table>
<hr>

<h3>Terima Kasih!</h3>
<p class="text-center">Barang yang sudah dibeli tidak dapat dikembalikan.</p>

<div class="print">
    <button onclick="window.print()">🖨️ Cetak Struk</button>
</div>

</body>
</html>
