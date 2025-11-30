<?php
session_start();
if (!isset($_SESSION["email"])) {
    header("Location: ../login.php");
    exit;
}

// Koneksi database
$koneksi = new mysqli("localhost", "root", "", "db_kasir");
if ($koneksi->connect_error) {
    die("Koneksi gagal: " . $koneksi->connect_error);
}

// Ambil data transaksi berdasarkan nomor faktur
$nomor_faktur = $_GET['nomor_faktur'] ?? '';

if (empty($nomor_faktur)) {
    die("Nomor faktur tidak valid");
}

// Ambil data header transaksi
$stmt = $koneksi->prepare("SELECT * FROM tb_jual WHERE nomor_faktur = ?");
$stmt->bind_param("s", $nomor_faktur);
$stmt->execute();
$result = $stmt->get_result();
$transaksi = $result->fetch_assoc();
$stmt->close();

if (!$transaksi) {
    die("Transaksi tidak ditemukan");
}

// Ambil detail transaksi
$stmt = $koneksi->prepare("SELECT * FROM rinci_jual WHERE nomor_faktur = ?");
$stmt->bind_param("s", $nomor_faktur);
$stmt->execute();
$result = $stmt->get_result();
$detail_transaksi = $result->fetch_all(MYSQLI_ASSOC);
$stmt->close();

$koneksi->close();
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Struk - Kedai Melwaa</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        body {
            font-family: 'Courier New', monospace;
            font-size: 12px;
            line-height: 1.3;
            background: #fff;
            color: #000;
            padding: 10px;
        }
        .struk-container {
            max-width: 300px;
            margin: 0 auto;
            border: 1px solid #000;
            padding: 15px;
        }
        .header {
            text-align: center;
            margin-bottom: 10px;
            border-bottom: 1px dashed #000;
            padding-bottom: 10px;
        }
        .header h1 {
            font-size: 16px;
            font-weight: bold;
            margin-bottom: 5px;
        }
        .info-transaksi {
            margin-bottom: 10px;
            border-bottom: 1px dashed #000;
            padding-bottom: 10px;
        }
        .info-transaksi .row {
            display: flex;
            justify-content: space-between;
            margin: 3px 0;
        }
        .detail-items {
            margin-bottom: 10px;
            border-bottom: 1px dashed #000;
            padding-bottom: 10px;
        }
        .item-row {
            display: flex;
            justify-content: space-between;
            margin: 4px 0;
        }
        .item-name {
            flex: 2;
        }
        .item-qty, .item-price, .item-total {
            flex: 1;
            text-align: right;
        }
        .total-section {
            margin-bottom: 10px;
            border-bottom: 1px dashed #000;
            padding-bottom: 10px;
        }
        .total-row {
            display: flex;
            justify-content: space-between;
            margin: 5px 0;
            font-weight: bold;
        }
        .footer {
            text-align: center;
            margin-top: 15px;
        }
        .barcode {
            text-align: center;
            margin: 10px 0;
            font-family: 'Courier New', monospace;
            font-size: 14px;
            letter-spacing: 2px;
        }
        @media print {
            .no-print {
                display: none;
            }
            body {
                padding: 0;
            }
            .struk-container {
                border: none;
                padding: 10px;
            }
        }
        .button-group {
            text-align: center;
            margin: 15px 0;
        }
        .btn {
            padding: 8px 15px;
            margin: 0 5px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            text-decoration: none;
            display: inline-block;
            font-size: 12px;
        }
        .btn-print {
            background: #007bff;
            color: white;
        }
        .btn-kasir {
            background: #28a745;
            color: white;
        }
        .btn-dashboard {
            background: #6f42c1;
            color: white;
        }
    </style>
</head>
<body>
    <div class="struk-container">
        <!-- Header -->
        <div class="header">
            <h1>KEDAI MELWAA</h1>
            <p>Jl. Contoh Alamat No. 123</p>
            <p>Telp: 0812-3456-7890</p>
            <p>================================</p>
        </div>

        <!-- Info Transaksi -->
        <div class="info-transaksi">
            <div class="row">
                <span>No. Faktur:</span>
                <span><?= htmlspecialchars($transaksi['nomor_faktur']) ?></span>
            </div>
            <div class="row">
                <span>Tanggal:</span>
                <span><?= date('d/m/Y H:i', strtotime($transaksi['tanggal_beli'])) ?></span>
            </div>
            <div class="row">
                <span>Kasir:</span>
                <span><?= htmlspecialchars($_SESSION['username'] ?? 'Admin') ?></span>
            </div>
            <div class="row">
                <span>Metode:</span>
                <span><?= htmlspecialchars($transaksi['metode_bayar'] ?? 'Tunai') ?></span>
            </div>
            <p>--------------------------------</p>
        </div>

        <!-- Detail Items -->
        <div class="detail-items">
            <?php foreach ($detail_transaksi as $item): ?>
            <div class="item-row">
                <div class="item-name"><?= htmlspecialchars($item['nama_produk']) ?></div>
                <div class="item-qty"><?= $item['qty'] ?>x</div>
                <div class="item-price"><?= number_format($item['harga_jual'], 0, ',', '.') ?></div>
                <div class="item-total"><?= number_format($item['total_harga'], 0, ',', '.') ?></div>
            </div>
            <?php endforeach; ?>
            <p>--------------------------------</p>
        </div>

        <!-- Total Section -->
        <div class="total-section">
            <div class="total-row">
                <span>Sub Total:</span>
                <span>Rp <?= number_format($transaksi['total_belanja'], 0, ',', '.') ?></span>
            </div>
            <div class="total-row">
                <span>Bayar:</span>
                <span>Rp <?= number_format($transaksi['total_bayar'], 0, ',', '.') ?></span>
            </div>
            <div class="total-row">
                <span>Kembalian:</span>
                <span>Rp <?= number_format($transaksi['kembalian'], 0, ',', '.') ?></span>
            </div>
            <p>================================</p>
        </div>

        <!-- Footer -->
        <div class="footer">
            <p>** TERIMA KASIH **</p>
            <p>Selamat menikmati hidangan kami</p>
            <div class="barcode">
                <?= $transaksi['nomor_faktur'] ?>
            </div>
        </div>
    </div>

    <!-- Tombol Aksi -->
    <div class="button-group no-print">
        <button class="btn btn-print" onclick="window.print()">🖨️ Cetak Struk</button>
        <a href="kasir.php" class="btn btn-kasir">💰 Kembali ke Kasir</a>
        
    </div>

    <script>
        // Auto print ketika halaman struk dibuka
        window.onload = function() {
            setTimeout(() => {
                window.print();
            }, 500);
        };
    </script>
</body>
</html>