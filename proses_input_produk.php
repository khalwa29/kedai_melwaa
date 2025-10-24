<?php
$koneksi = mysqli_connect("localhost", "root", "", "db_chatgpt");

if (!$koneksi) {
    die("Koneksi gagal: " . mysqli_connect_error());
}

// Ambil data dari form
$nama_produk = $_POST['nama_produk'];
$harga = $_POST['harga'];
$kategori = $_POST['kategori'];

// Query simpan data
$sql = "INSERT INTO tb_<?php
session_start();

// Pastikan user sudah login
if (!isset($_SESSION["email"])) {
    header("Location: login.php");
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
    // Ambil data dari form
    $kode       = trim($_POST['kode_produk']);
    $nama       = trim($_POST['nama_produk']);
    $kategori   = $_POST['kategori'];
    $harga_beli = $_POST['harga_beli'];
    $harga_jual = $_POST['harga_jual'];
    $stok       = $_POST['stok'];
    $satuan     = $_POST['satuan'];

    // Validasi sederhana
    if (empty($kode) || empty($nama) || empty($kategori) || empty($satuan)) {
        echo "<script>alert('Semua field wajib diisi!'); window.history.back();</script>";
        exit;
    }

    // Gunakan prepared statement agar aman dari SQL Injection
    $stmt = $koneksi->prepare("INSERT INTO tb_produk (kode_produk, nama_produk, kategori, harga_beli, harga_jual, stok, satuan)
                               VALUES (?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("sssiiis", $kode, $nama, $kategori, $harga_beli, $harga_jual, $stok, $satuan);

    if ($stmt->execute()) {
        header("Location: produk.php?status=success");
        exit;
    } else {
        echo "Error SQL: " . $stmt->error;
    }

    $stmt->close();
}

$koneksi->close();
?>
produk (nama_produk, harga, kategori, )
        VALUES ('$nama_produk', '$harga', '$kategori')";

if (mysqli_query($koneksi, $sql)) {
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
        <p>Anda akan diarahkan kembali ke halaman input...</p>
      </div>
    </body>
    </html>
    ";
} else {
    echo "❌ Gagal menyimpan data: " . mysqli_error($koneksi);
}

mysqli_close($koneksi);
?>
