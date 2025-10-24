<?php
require __DIR__ . '/dompdf/autoload.inc.php';
use Dompdf\Dompdf;

$koneksi = new mysqli("localhost", "root", "", "db_chatgpt");

$tgl_awal  = $_GET['tgl_awal'] ?? '';
$tgl_akhir = $_GET['tgl_akhir'] ?? '';

$query = "
    SELECT 
        j.tanggal_beli,
        r.nama_produk,
        r.harga_jual,
        r.qty,
        r.total_harga
    FROM tb_jual j
    INNER JOIN rinci_jual r ON j.nomor_faktur = r.nomor_faktur
    WHERE DATE(j.tanggal_beli) BETWEEN '$tgl_awal' AND '$tgl_akhir'
    ORDER BY j.tanggal_beli ASC
";
$result = $koneksi->query($query);

$html = "
<h3 style='text-align:center;'>Laporan Penjualan</h3>
<p style='text-align:center;'>Periode: $tgl_awal s/d $tgl_akhir</p>
<table border='1' cellspacing='0' cellpadding='6' width='100%'>
<thead>
<tr>
<th>Tanggal Beli</th>
<th>Nama Produk</th>
<th>Harga Jual</th>
<th>Qty</th>
<th>Total Harga</th>
</tr>
</thead>
<tbody>
";

$total = 0;
while ($row = $result->fetch_assoc()) {
    $html .= "
    <tr>
        <td>{$row['tanggal_beli']}</td>
        <td>{$row['nama_produk']}</td>
        <td>Rp " . number_format($row['harga_jual'], 0, ',', '.') . "</td>
        <td>{$row['qty']}</td>
        <td>Rp " . number_format($row['total_harga'], 0, ',', '.') . "</td>
    </tr>";
    $total += $row['total_harga'];
}

$html .= "
<tr style='font-weight:bold;background:#f4f4f4'>
<td colspan='4' align='center'>TOTAL</td>
<td>Rp " . number_format($total, 0, ',', '.') . "</td>
</tr>
</tbody>
</table>
";

$dompdf = new Dompdf();
$dompdf->loadHtml($html);
$dompdf->setPaper('A4', 'portrait');
$dompdf->render();
$dompdf->stream("laporan_penjualan_{$tgl_awal}_{$tgl_akhir}.pdf", ["Attachment" => true]);
?>
