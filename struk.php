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

// Simpan data pelanggan untuk pre-fill di form berikutnya
$_SESSION['pesanan_selesai'] = [
    'nama' => $nama_pelanggan,
    'nomor_faktur' => $nomor_faktur,
    'metode_bayar' => $metode_bayar
];
?>

<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<<<<<<< HEAD
<title>Struk Transaksi <?= htmlspecialchars($nomor_faktur) ?> - KhaMelicious </title>
=======
<title>Struk Transaksi <?= htmlspecialchars($nomor_faktur) ?> - Kedai khalwa</title>
>>>>>>> 0030abb90f9df7113448d748683688fdb371dff4
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

.store-contact {
    font-size: 11px;
    opacity: 0.8;
    margin-top: 3px;
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
    margin-bottom: 10px;
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
    font-weight: bold;
    color: #333;
}

.product-total {
    text-align: right;
    font-weight: bold;
    color: #ff69b4;
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

.payment-row.highlight {
    font-weight: bold;
    color: #ff69b4;
}

.payment-row.total {
    font-weight: bold;
    font-size: 15px;
    color: #28a745;
    border-top: 2px solid #007bff;
    padding-top: 10px;
    margin-top: 10px;
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
    font-size: 16px;
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
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
}

.btn-print {
    background: #ff69b4;
    color: white;
}

.btn-print:hover {
    background: #e0559c;
    transform: translateY(-2px);
    box-shadow: 0 5px 15px rgba(255,105,180,0.3);
}

.btn-new {
    background: #28a745;
    color: white;
}

.btn-new:hover {
    background: #218838;
    transform: translateY(-2px);
    box-shadow: 0 5px 15px rgba(40,167,69,0.3);
}

.btn-dashboard {
    background: #6c757d;
    color: white;
    margin-top: 10px;
}

.btn-dashboard:hover {
    background: #5a6268;
    transform: translateY(-2px);
}

/* Print Styles */
@media print {
    body {
        background: white !important;
        padding: 0 !important;
        margin: 0 !important;
    }
    .container {
        max-width: 100% !important;
        box-shadow: none !important;
        margin: 0 !important;
        padding: 0 !important;
    }
    .struk-box {
        box-shadow: none !important;
        border-radius: 0 !important;
        width: 100% !important;
    }
    .action-buttons, .btn {
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
    .header {
        padding: 15px;
    }
    .struk-content {
        padding: 15px;
    }
    .action-buttons {
        flex-direction: column;
    }
}

/* Animation */
@keyframes fadeIn {
    from { opacity: 0; transform: translateY(20px); }
    to { opacity: 1; transform: translateY(0); }
}

.struk-box {
    animation: fadeIn 0.5s ease-out;
}
</style>
</head>
<body>
    <div class="container">
        <div class="struk-box">
            <!-- HEADER -->
            <div class="header">
<<<<<<< HEAD
                <div class="store-name">KhaMelicious Mart</div>
                <div class="store-address">Jl. Kemerdekaan No. 123 - Telp: (021) 1234-5678</div>
=======
                <div class="store-name">🍰 Kedai Melwaa</div>
                <div class="store-address">Jl. Kemerdekaan No. 123, Bumiayu</div>
                <div class="store-contact">📞 (021) 1234-5678 | 🕒 08:00 - 22:00</div>
>>>>>>> 0030abb90f9df7113448d748683688fdb371dff4
            </div>

            <!-- CONTENT -->
            <div class="struk-content">
                <!-- INFO PELANGGAN -->
                <div class="customer-info">
                    <div class="customer-name">👤 <?= htmlspecialchars($nama_pelanggan) ?></div>
                    <div class="info-row">
                        <span>📋 No. Faktur:</span>
                        <span><strong><?= htmlspecialchars($nomor_faktur) ?></strong></span>
                    </div>
                    <div class="info-row">
                        <span>📅 Tanggal:</span>
                        <span><?= date('d/m/Y', strtotime($jual['tanggal_beli'])) ?></span>
                    </div>
                    <div class="info-row">
                        <span>🕐 Waktu:</span>
                        <span><?= date('H:i', strtotime($jual['tanggal_beli'])) ?></span>
                    </div>
                </div>

                <div class="divider"></div>

                <!-- DETAIL PRODUK -->
                <table class="product-table">
                    <thead>
                        <tr>
                            <th>Menu</th>
                            <th style="width: 40px; text-align: center;">Qty</th>
                            <th style="width: 90px; text-align: right;">Subtotal</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                        $detail->data_seek(0);
                        $total_items = 0;
                        while($row = $detail->fetch_assoc()): 
                            $total_items += $row['qty'];
                        ?>
                        <tr>
                            <td>
                                <div class="product-name"><?= htmlspecialchars($row['nama_produk']) ?></div>
                                <div class="product-price">Rp <?= number_format($row['harga_jual'], 0, ',', '.') ?></div>
                            </td>
                            <td class="product-qty"><?= (int)$row['qty'] ?></td>
                            <td class="product-total">Rp <?= number_format($row['total_harga'], 0, ',', '.') ?></td>
                        </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>

                <div class="info-row" style="margin-top: -10px; margin-bottom: 15px; font-size: 12px;">
                    <span>Total Item:</span>
                    <span><strong><?= $total_items ?> item</strong></span>
                </div>

                <div class="divider"></div>

                <!-- INFO PEMBAYARAN -->
                <div class="payment-info">
                    <div class="payment-row">
                        <span>💳 Metode Bayar:</span>
                        <span><?= strtoupper($metode_bayar) ?></span>
                    </div>
                    <div class="payment-row">
                        <span>🛒 Total Belanja:</span>
                        <span>Rp <?= number_format($jual['total_belanja'], 0, ',', '.') ?></span>
                    </div>
                    <div class="payment-row highlight">
                        <span>💰 Jumlah Bayar:</span>
                        <span>Rp <?= number_format($jual['total_bayar'], 0, ',', '.') ?></span>
                    </div>
                    <div class="payment-row total">
                        <span>💵 Kembalian:</span>
                        <span>Rp <?= number_format($jual['kembalian'], 0, ',', '.') ?></span>
                    </div>
                </div>

                <!-- FOOTER -->
                <div class="footer">
                    <div class="thank-you">Terima kasih <?= htmlspecialchars($nama_pelanggan) ?>! 💕</div>
                    <div class="warning">
                </div>

                <!-- ACTION BUTTONS -->
                <div class="action-buttons">
                    <button class="btn btn-print" onclick="window.print()">
                        🖨️ Cetak Struk
                    </button>
                    <a href="beli.php?belanja_lagi=1" class="btn btn-new">
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
        sessionStorage.setItem('last_total', '<?= $jual['total_belanja'] ?>');
        
        // Notifikasi sukses
        console.log('Struk berhasil dicetak: <?= $nomor_faktur ?>');
        
        // Auto print setelah 1 detik (opsional, aktifkan jika perlu)
        /*
        setTimeout(() => {
            window.print();
        }, 1000);
        */
        
        // Tambahkan event listener untuk tombol cetak
        document.querySelector('.btn-print').addEventListener('click', function() {
            setTimeout(() => {
                // Focus ke tombol belanja lagi setelah print
                document.querySelector('.btn-new').focus();
            }, 500);
        });
    </script>
</body>
</html>

<?php $koneksi->close(); ?>