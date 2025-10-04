<?php
include 'koneksi.php';

// Ambil data dari form
$nama     = $_POST['nama'] ?? '';
$menu     = $_POST['menu'] ?? '';
$kategori = $_POST['kategori'] ?? '';
$jumlah   = (int)($_POST['jumlah'] ?? 1);
$catatan  = $_POST['catatan'] ?? '';

// Cek apakah semua field wajib ada
if($nama && $menu && $kategori) {

    $stmt = $conn->prepare("INSERT INTO tb_pesanan (nama, menu, kategori, jumlah, catatan) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("sssis", $nama, $menu, $kategori, $jumlah, $catatan);

    if ($stmt->execute()) {
        $last_id = $conn->insert_id; // Ambil ID pesanan terbaru

        // --- Bagian STRUK ---
        // Ganti id_pesanan menjadi id sesuai nama kolom primary key di tabel
        $sql = "SELECT * FROM tb_pesanan WHERE id = $last_id";
        $result = $conn->query($sql);
        $data = $result->fetch_assoc();
        ?>
        <!DOCTYPE html>
        <html>
        <head>
            <meta charset="UTF-8">
            <title>Struk Pesanan</title>
            <style>
                body { font-family: Arial, sans-serif; display: flex; justify-content: center; margin-top: 50px; }
                .struk { border: 1px solid #000; padding: 20px; width: 300px; }
                .struk h3 { text-align: center; margin-bottom: 20px; }
                .struk p { margin: 5px 0; }
                .struk hr { margin: 10px 0; }
                .btn-print { display: block; margin: 20px auto 0; padding: 8px 15px; cursor: pointer; }
            </style>
        </head>
        <body>
            <div class="struk">
                <h3>Kedai KhaMelicious</h3>
                <p><strong>Nama:</strong> <?= htmlspecialchars($data['nama']); ?></p>
                <p><strong>Menu:</strong> <?= htmlspecialchars($data['menu']); ?></p>
                <p><strong>Kategori:</strong> <?= htmlspecialchars($data['kategori']); ?></p>
                <p><strong>Jumlah:</strong> <?= htmlspecialchars($data['jumlah']); ?></p>
                <p><strong>Catatan:</strong> <?= htmlspecialchars($data['catatan']); ?></p>
                <p><strong>Tanggal:</strong> <?= $data['created_at']; ?></p>
                <hr>
                <p style="text-align:center;">Terima kasih atas pesanan Anda!</p>
                <button class="btn-print" onclick="window.print()">Cetak Struk</button>
            </div>
        </body>
        </html>
        <?php
        // --- END STRUK ---
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
} else {
    echo "<script>
            alert('Data tidak lengkap!');
            window.location='index.html';
          </script>";
}

$conn->close();
?>
