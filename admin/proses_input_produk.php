<?php
session_start();

// Pastikan user sudah login
if (!isset($_SESSION['email'])) {
    header('Location: login.php');
    exit;
}

// Koneksi ke database
$koneksi = new mysqli("localhost", "root", "", "db_chatgpt");

// Cek koneksi
if ($koneksi->connect_error) {
    die("Koneksi gagal: " . $koneksi->connect_error);
}

// Jika tombol tambah ditekan
if (isset($_POST['tambah'])) {
}
    // Ambil data dari form
    $kode       = trim($_POST['kode_produk']);
    $nama       = trim($_POST['nama_produk']);
    $kategori   = trim($_POST['kategori']);
    $harga_beli = $_POST['harga_beli'];
    $harga_jual = $_POST['harga_jual'];
    $stok       = $_POST['stok'];
    $satuan     = trim($_POST['satuan']);

    // Upload foto
    $foto = '';
    if (!empty($_FILES['foto']['name'])) {
        $target_dir = "uploads/";
        if (!is_dir($target_dir)) {
            mkdir($target_dir, 0777, true);
        }

        $file_name = basename($_FILES["foto"]["name"]);
        $target_file = $target_dir . time() . "_" . $file_name;
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

        // Validasi file
        $allowed = ['jpg', 'jpeg', 'png', 'gif'];
        if (in_array($imageFileType, $allowed)) {
            if (move_uploaded_file($_FILES["foto"]["tmp_name"], $target_file)) {
                $foto = $target_file;
            } else {
                echo "<script>alert('Gagal mengupload gambar!'); window.history.back();</script>";
                exit;
            }
        } else {
            echo "<script>alert('Format gambar tidak valid (gunakan JPG, PNG, GIF)!'); window.history.back();</script>";
            exit;
        }
    }

    // Validasi sederhana
    if (empty($kode) || empty($nama) || empty($kategori) || empty($satuan)) {
        echo "<script>alert('Semua field wajib diisi!'); window.history.back();</script>";
        exit;
    }

    // Gunakan prepared statement agar aman dari SQL Injection
    $stmt = $koneksi->prepare("INSERT INTO tb_produk 
        (kode_produk, nama_produk, kategori, harga_beli, harga_jual, stok, satuan, foto)
        VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("sssiiiss", $kode, $nama, $kategori, $harga_beli, $harga_jual, $stok, $satuan, $foto);

    if ($stmt->execute()) {
        echo "
        <html>
        <head>
            <meta http-equiv='refresh' content='2;url=produk.php'>
            <style>
                body {
                    font-family: Poppins, sans-serif;
                    background: linear-gradient(135deg, #ffebf3, #e3f8ff);
                    text-align: center;
                    padding-top: 100px;
                    color: #333;
                }
                .success {
                    background: #fff;
                    display: inline-block;
                    padding: 25px 40px;
                    border-radius: 15px;
                    box-shadow: 0 8px 20px rgba(255,182,193,0.3);
                }
                h3 { color: #ff69b4; }
            </style>
        </head>
        <body>
            <div class='success'>
                <h3>✅ Data produk berhasil disimpan!</h3>
                <p>Anda akan diarahkan kembali ke halaman produk...</p>
            </div>
        </body>
        </html>
        ";
    } else {
        echo "❌ Gagal menyimpan data: " . $stmt->error;
    }

    $stmt->close();
}

// Tutup koneksi database
$koneksi->close();
?>
