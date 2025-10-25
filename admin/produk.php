<?php
session_start();
if (!isset($_SESSION["email"])) {
    header("Location: login.php");
    exit;
}
$username = $_SESSION["username"];

// Koneksi ke database
$koneksi = new mysqli("localhost", "root", "", "db_kasir");

// Tambah produk baru
if (isset($_POST['tambah'])) {
    $kode = $_POST['kode_produk'];
    $nama = $_POST['nama_produk'];
    $kategori = $_POST['kategori'];
    $harga_beli = $_POST['harga_beli'];
    $harga_jual = $_POST['harga_jual'];
    $stok = $_POST['stok'];
    $satuan = $_POST['satuan'];

    $koneksi->query("INSERT INTO tb_produk (kode_produk, nama_produk, kategori, harga_beli, harga_jual, stok, satuan)
                     VALUES ('$kode', '$nama', '$kategori', '$harga_beli', '$harga_jual', '$stok', '$satuan')");
    header("Location: produk.php");
    exit;
}

// Hapus produk
if (isset($_GET['hapus'])) {
    $id = $_GET['hapus'];
    $koneksi->query("DELETE FROM produk WHERE id=$id");
    header("Location: produk.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Data Produk | Kasir Melwaa</title>
<style>
@import url('https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap');
body {
  font-family: 'Poppins', sans-serif;
  background: linear-gradient(135deg, #fff1f8, #e2f7ff);
  margin: 0;
  color: #333;
}
header {
  background: linear-gradient(90deg, #ff8cb8, #6ee3ff);
  color: #fff;
  padding: 25px 40px;
  display: flex;
  align-items: center;
  justify-content: space-between;
  box-shadow: 0 5px 15px rgba(0,0,0,0.1);
}
header a {
  background: #fff;
  color: #ff69b4;
  padding: 8px 16px;
  border-radius: 10px;
  text-decoration: none;
  font-weight: bold;
}
header a:hover { background: #ffe0ef; transform: scale(1.05); }
.container {
  background: #fff;
  margin: 40px auto;
  width: 90%;
  max-width: 1100px;
  padding: 30px;
  border-radius: 20px;
  box-shadow: 0 8px 25px rgba(255,182,193,0.3);
}
h2 {
  text-align: center;
  color: #ff69b4;
  margin-bottom: 30px;
}
form {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
  gap: 15px;
  margin-bottom: 25px;
}
input, select {
  padding: 10px;
  border-radius: 10px;
  border: 1px solid #ccc;
  font-family: 'Poppins', sans-serif;
}
button {
  background: linear-gradient(90deg, #ff69b4, #77e3f0);
  color: #fff;
  border: none;
  padding: 10px;
  border-radius: 10px;
  font-weight: bold;
  cursor: pointer;
}
button:hover { transform: scale(1.05); }
table {
  width: 100%;
  border-collapse: collapse;
}
th, td {
  padding: 10px 12px;
  border-bottom: 1px solid #ffe4ec;
  text-align: center;
}
th {
  background: linear-gradient(90deg, #ffb6c1, #a3f3ff);
  color: #fff;
}
tr:hover { background: #fff6fa; }
.action-btn {
  background: #ff69b4;
  color: white;
  padding: 5px 10px;
  border-radius: 8px;
  text-decoration: none;
  font-size: 13px;
}
.action-btn:hover { opacity: 0.8; }
.delete { background: #ff4d6d; }
footer {
  text-align: center;
  font-size: 13px;
  color: #777;
  padding: 15px;
  background: #fff;
  border-top: 1px solid #ffd9ec;
}
</style>
</head>
<body>
<header>
  <div>
    <h1>Kasir Melwaa 🍜🥤🍪</h1>
    <span>Hai, <?= htmlspecialchars($username) ?> — kelola produkmu di sini 💅</span>
  </div>
  <a href="dashboard_admin.php">🏠 Dashboard</a>
</header>

<div class="container">
  <h2>📦 Data Produk</h2>

  <!-- Form Tambah Produk -->
  <form method="POST">
    <input type="text" name="kode_produk" placeholder="Kode Produk" required>
    <input type="text" name="nama_produk" placeholder="Nama Produk" required>
    <select name="kategori" required>
      <option value="">Pilih Kategori</option>
      <option value="makanan">Makanan</option>
      <option value="minuman">Minuman</option>
      <option value="cemilan">Cemilan</option>
    </select>
    <input type="number" name="harga_beli" placeholder="Harga Beli" required>
    <input type="number" name="harga_jual" placeholder="Harga Jual" required>
    <input type="number" name="stok" placeholder="Stok" required>
    <select name="satuan" required>
      <option value="">Pilih Satuan</option>
      <option value="pcs">Pcs</option>
      <option value="bungkus">Paket</option>
    </select>
    <button type="submit" name="tambah">+ Tambah Produk</button>
  </form>

  <!-- Tabel Produk -->
  <table>
    <tr>
      <th>No</th>
      <th>Kode</th>
      <th>Nama Produk</th>
      <th>Kategori</th>
      <th>Harga Beli</th>
      <th>Harga Jual</th>
      <th>Stok</th>
      <th>Satuan</th>
    </tr>
    <?php
    $no = 1;
    $result = $koneksi->query("SELECT * FROM tb_produk ORDER BY id_produk DESC");
    while ($row = $result->fetch_assoc()):
    ?>
    <tr>
      <td><?= $no++ ?></td>
      <td><?= htmlspecialchars($row['kode_produk']) ?></td>
      <td><?= htmlspecialchars($row['nama_produk']) ?></td>
      <td><?= ucfirst($row['kategori']) ?></td>
      <td>Rp<?= number_format($row['harga_beli'], 0, ',', '.') ?></td>
      <td>Rp<?= number_format($row['harga_jual'], 0, ',', '.') ?></td>
      <td><?= $row['stok'] ?></td>
      <td><?= $row['satuan'] ?></td>
    </tr>
    <?php endwhile; ?>
  </table>
</div>

<footer>
  🍜🥤🍪 Kasir Melwaa — “Belanja Mudah, Untung Setiap Hari!” 💕
</footer>
</body>
</html>
