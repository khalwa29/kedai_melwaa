<?php
include 'koneksi.php';

// ambil nomor faktur dari URL
$nomor_faktur = $_GET['faktur'] ?? '';

if ($nomor_faktur == '') {
    die("<h3>Nomor faktur tidak ditemukan.</h3>");
}

// ambil data jual (master)
$q1 = $koneksi->prepare("SELECT * FROM tb_jual WHERE nomor_faktur = ?");
$q1->bind_param('s', $nomor_faktur);
$q1->execute();
$jual = $q1->get_result()->fetch_assoc();
$q1->close();

if (!$jual) {
    die("<h3>Data transaksi tidak ditemukan.</h3>");
}

// ambil detail produk
$q2 = $koneksi->prepare("SELECT * FROM rinci_jual WHERE nomor_faktur = ?");
$q2->bind_param('s', $nomor_faktur);
$q2->execute();
$detail = $q2->get_result();
?>

<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Struk Transaksi <?= htmlspecialchars($nomor_faktur) ?></title>
<style>
body { font-family: 'Poppins', sans-serif; background: #fff; color: #333; }
.container { width: 340px; margin: 20px auto; border: 1px dashed #aaa; padding: 16px; border-radius: 10px; }
h2 { text-align: center; margin-bottom: 10px; color: #ff69b4; }
table { width: 100%; border-collapse: collapse; font-size: 14px; }
td, th { padding: 4px 0; }
tfoot td { font-weight: bold; border-top: 1px solid #ccc; }
.center { text-align: center; }
.btn-print { background: #ff69b4; color: #fff; border: none; padding: 8px 12px; border-radius: 8px; cursor: pointer; width: 100%; margin-top: 10px; }
</style>
</head>
<body>
<div class="container">
  <h2>Khawalicious Mart</h2>
  <div style="text-align:center; font-size:13px;">Jl. Contoh No. 123<br><?= date('d/m/Y H:i', strtotime($jual['tanggal_beli'])) ?></div>
  <hr>
  <table>
    <thead>
      <tr><th>Produk</th><th>Qty</th><th align="right">Subtotal</th></tr>
    </thead>
    <tbody>
      <?php while($row = $detail->fetch_assoc()): ?>
      <tr>
        <td><?= htmlspecialchars($row['nama_produk']) ?></td>
        <td><?= (int)$row['qty'] ?></td>
        <td align="right">Rp <?= number_format($row['total_harga'],0,',','.') ?></td>
      </tr>
      <?php endwhile; ?>
    </tbody>
    <tfoot>
      <tr><td colspan="2">Total</td><td align="right">Rp <?= number_format($jual['total_belanja'],0,',','.') ?></td></tr>
      <tr><td colspan="2">Bayar</td><td align="right">Rp <?= number_format($jual['total_bayar'],0,',','.') ?></td></tr>
      <tr><td colspan="2">Kembalian</td><td align="right">Rp <?= number_format($jual['kembalian'],0,',','.') ?></td></tr>
    </tfoot>
  </table>
  <hr>
  <div class="center">Terima kasih telah berbelanja 💖</div>
  <button class="btn-print" onclick="window.print()">🖨 Cetak Struk</button>
</div>
</body>
</html>
