<?php
session_start();

// Koneksi database
$koneksi = new mysqli("localhost", "root", "", "db_kasir");
if ($koneksi->connect_error) {
    die("Koneksi database gagal: " . $koneksi->connect_error);
}

// Ambil nomor faktur dari URL
$nomor_faktur = $_GET['nomor_faktur'] ?? '';

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

// Ambil nama pelanggan dari session
$nama_pelanggan = $_SESSION['pesanan_selesai']['nama'] ?? 'Pelanggan';
$metode_bayar = $_SESSION['pesanan_selesai']['metode_bayar'] ?? ($jual['metode_bayar'] ?? 'tunai');
?>

<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Struk Transaksi <?= htmlspecialchars($nomor_faktur) ?> - Khawalicious Mart</title>
<style>
* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
}

body { 
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; 
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    min-height: 100vh;
    padding: 20px;
    display: flex;
    justify-content: center;
    align-items: center;
}

.container {
    max-width: 400px;
    width: 100%;
}

.struk-box {
    background: white;
    border-radius: 15px;
    box-shadow: 0 15px 35px rgba(0,0,0,0.2);
    overflow: hidden;
}

.header {
    background: linear-gradient(135deg, #ff69b4, #ff1493);
    color: white;
    padding: 20px;
    text-align: center;
}

.store-name {
    font-size: 24px;
    font-weight: bold;
    margin-bottom: 5px;
}

.store-address {
    font-size: 12px;
    opacity: 0.9;
}

.struk-content {
    padding: 20px;
}

.customer-info {
    background: #f8f9fa;
    padding: 15px;
    border-radius: 10px;
    margin-bottom: 20px;
    border-left: 4px solid #ff69b4;
}

.customer-name {
    font-weight: bold;
    color: #ff69b4;
    font-size: 16px;
}

.info-row {
    display: flex;
    justify-content: space-between;
    margin-bottom: 5px;
    font-size: 13px;
}

.divider {
    border-top: 2px dashed #ddd;
    margin: 15px 0;
}

.product-table {
    width: 100%;
    border-collapse: collapse;
    margin-bottom: 15px;
}

.product-table th {
    text-align: left;
    padding: 8px 0;
    border-bottom: 1px solid #eee;
    font-size: 12px;
    color: #666;
}

.product-table td {
    padding: 8px 0;
    border-bottom: 1px solid #f5f5f5;
}

.product-name {
    font-weight: bold;
    font-size: 13px;
}

.product-price {
    font-size: 11px;
    color: #888;
}

.product-qty {
    text-align: center;
}

.product-total {
    text-align: right;
    font-weight: bold;
}

.payment-info {
    background: #f0f8ff;
    padding: 15px;
    border-radius: 10px;
    margin: 15px 0;
    border-left: 4px solid #007bff;
}

.payment-row {
    display: flex;
    justify-content: space-between;
    margin-bottom: 8px;
    font-size: 13px;
}

.payment-row.total {
    font-weight: bold;
    font-size: 14px;
    border-top: 1px solid #007bff;
    padding-top: 8px;
    margin-top: 8px;
}

.footer {
    text-align: center;
    padding: 15px;
    background: #f8f9fa;
    border-top: 1px dashed #ddd;
}

.thank-you {
    font-weight: bold;
    color: #ff69b4;
    margin-bottom: 10px;
}

.warning {
    font-size: 11px;
    color: #666;
    line-height: 1.4;
}

.action-buttons {
    display: flex;
    gap: 10px;
    margin-top: 20px;
}

.btn {
    flex: 1;
    padding: 12px;
    border: none;
    border-radius: 8px;
    font-weight: bold;
    cursor: pointer;
    text-decoration: none;
    text-align: center;
    transition: all 0.3s;
    font-size: 14px;
}

.btn-print {
    background: #ff69b4;
    color: white;
}

.btn-print:hover {
    background: #e0559c;
    transform: translateY(-2px);
}

.btn-new {
    background: #28a745;
    color: white;
}

.btn-new:hover {
    background: #218838;
    transform: translateY(-2px);
}

/* Print Styles */
@media print {
    body {
        background: white !important;
        padding: 0 !important;
    }
    .container {
        max-width: 100% !important;
        box-shadow: none !important;
    }
    .struk-box {
        box-shadow: none !important;
        border-radius: 0 !important;
    }
    .action-buttons {
        display: none !important;
    }
    .btn {
        display: none !important;
    }
}

/* Responsive */
@media (max-width: 480px) {
    body {
        padding: 10px;
    }
    .container {
        max-width: 100%;
    }
}
</style>
</head>
<body>
    <div class="container">
        <div class="struk-box">
            <!-- HEADER -->
            <div class="header">
                <div class="store-name">Khawalicious Mart</div>
                <div class="store-address">Jl. Kemerdekaan No. 123 - Telp: (021) 1234-5678</div>
            </div>

            <!-- CONTENT -->
            <div class="struk-content">
                <!-- INFO PELANGGAN -->
                <div class="customer-info">
                    <div class="customer-name"><?= htmlspecialchars($nama_pelanggan) ?></div>
                    <div class="info-row">
                        <span>No. Faktur:</span>
                        <span><?= htmlspecialchars($nomor_faktur) ?></span>
                    </div>
                    <div class="info-row">
                        <span>Tanggal:</span>
                        <span><?= date('d/m/Y H:i', strtotime($jual['tanggal_beli'])) ?></span>
                    </div>
                </div>

                <div class="divider"></div>

                <!-- DETAIL PRODUK -->
                <table class="product-table">
                    <thead>
                        <tr>
                            <th>Produk</th>
                            <th style="width: 40px;">Qty</th>
                            <th style="width: 80px; text-align: right;">Subtotal</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                        $detail->data_seek(0);
                        while($row = $detail->fetch_assoc()): 
                        ?>
                        <tr>
                            <td>
                                <div class="product-name"><?= htmlspecialchars($row['nama_produk']) ?></div>
                                <div class="product-price">@Rp <?= number_format($row['harga_jual'], 0, ',', '.') ?></div>
                            </td>
                            <td class="product-qty"><?= (int)$row['qty'] ?></td>
                            <td class="product-total">Rp <?= number_format($row['total_harga'], 0, ',', '.') ?></td>
                        </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>

                <div class="divider"></div>

                <!-- INFO PEMBAYARAN -->
                <div class="payment-info">
                    <div class="payment-row">
                        <span>Metode Bayar:</span>
                        <span><?= strtoupper($metode_bayar) ?></span>
                    </div>
                    <div class="payment-row">
                        <span>Total Belanja:</span>
                        <span>Rp <?= number_format($jual['total_belanja'], 0, ',', '.') ?></span>
                    </div>
                    <div class="payment-row">
                        <span>Jumlah Bayar:</span>
                        <span>Rp <?= number_format($jual['total_bayar'], 0, ',', '.') ?></span>
                    </div>
                    <div class="payment-row total">
                        <span>Kembalian:</span>
                        <span>Rp <?= number_format($jual['kembalian'], 0, ',', '.') ?></span>
                    </div>
                </div>

                <!-- FOOTER -->
                <div class="footer">
                    <div class="thank-you">Terima kasih <?= htmlspecialchars($nama_pelanggan) ?>!</div>
                    <div class="warning">
                        Barang yang sudah dibeli tidak dapat ditukar/dikembalikan<br>
                        *** Selamat Belanja Kembali ***
                    </div>
                </div>

                <!-- ACTION BUTTONS -->
                <div class="action-buttons">
                    <button class="btn btn-print" onclick="window.print()">
                        🖨 Cetak Struk
                    </button>
                    <a href="index.php" class="btn btn-new">
                        🛒 Belanja Lagi
                    </a>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Auto focus untuk UX yang better
        document.querySelector('.btn-print').focus();
        
        // Simpan data ke session storage
        sessionStorage.setItem('last_struk', '<?= $nomor_faktur ?>');
        sessionStorage.setItem('last_customer', '<?= $nama_pelanggan ?>');
        
        // Auto print setelah 1 detik (optional)
        // setTimeout(() => {
        //     window.print();
        // }, 1000);
    </script>
</body>
</html>