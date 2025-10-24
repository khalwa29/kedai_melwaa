<?php
// Koneksi ke database
$koneksi = new mysqli("localhost", "root", "", "db_kasir");
if ($koneksi->connect_error) {
    die("Koneksi gagal: " . $koneksi->connect_error);
}

// Ambil data produk dari tabel tb_produk
$query = "SELECT * FROM tb_produk ORDER BY kategori, nama_produk ASC";
$result = $koneksi->query($query);
?>

<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Beli Menu - Kedai Melwaa 💕</title>
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
<style>
/* ====== SEMUA CSS ORIGINAL DIPERTAHANKAN ====== */
body {
    font-family: 'Poppins', sans-serif;
    background: #fff9fc;
    margin: 0;
    padding: 20px;
}
h1 {
    text-align: center;
    color: #ff4b9d;
    margin-bottom: 10px;
}
p.subtitle {
    text-align: center;
    color: #666;
    margin-bottom: 30px;
}
.container {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
    gap: 20px;
}
.card {
    background: white;
    border-radius: 15px;
    box-shadow: 0 4px 8px rgba(0,0,0,0.1);
    overflow: hidden;
    transition: transform 0.2s ease-in-out;
}
.card:hover {
    transform: scale(1.03);
}
.card img {
    width: 100%;
    height: 180px;
    object-fit: cover;
}
.card-body {
    padding: 15px;
    text-align: center;
}
.card-body h3 {
    margin: 0;
    color: #333;
}
.card-body p {
    color: #666;
    margin: 5px 0 10px;
}
button {
    background: linear-gradient(90deg, #ff69b4, #ff85c1);
    color: white;
    border: none;
    border-radius: 10px;
    padding: 8px 15px;
    cursor: pointer;
    font-size: 14px;
    font-weight: 600;
}
button:hover {
    background: linear-gradient(90deg, #ff85c1, #ffa3d1);
}
input[type="number"] {
    width: 60px;
    text-align: center;
    border-radius: 8px;
    border: 1px solid #ddd;
    padding: 4px;
    margin-right: 8px;
}
.kategori {
    text-transform: capitalize;
    font-size: 13px;
    color: #999;
}
.success {
    text-align: center;
    background: #e0ffe9;
    color: #2d7a46;
    padding: 10px 15px;
    border-radius: 10px;
    margin-bottom: 20px;
    width: 60%;
    margin-left: auto;
    margin-right: auto;
}
.back-btn {
    display: block;
    text-align: center;
    margin-top: 30px;
    text-decoration: none;
    background: #ff69b4;
    color: #fff;
    padding: 10px 25px;
    border-radius: 10px;
    font-weight: 600;
}
.back-btn:hover {
    background: #ff85c1;
}
</style>
</head>
<body>

<h1>🍜 Daftar Menu Kedai Melwaa</h1>
<p class="subtitle">Silakan pilih menu yang ingin dibeli 💕</p>

<?php if (isset($_GET['success'])): ?>
    <div class="success"><?= htmlspecialchars($_GET['success']) ?></div>
<?php endif; ?>

<div class="container">
<?php while($row = $result->fetch_assoc()): ?>
    <div class="card">
        <img src="uploads/<?= htmlspecialchars($row['foto']) ?>" alt="<?= htmlspecialchars($row['nama_produk']) ?>">
        <div class="card-body">
            <h3><?= htmlspecialchars($row['nama_produk']) ?></h3>
            <p class="kategori"><?= htmlspecialchars($row['kategori']) ?></p>
            <p><b>Rp <?= number_format($row['harga_jual'], 0, ',', '.') ?></b></p>
            <form action="proses_beli.php" method="POST">
                <input type="hidden" name="id_produk" value="<?= $row['id_produk'] ?>">
                <input type="number" name="qty" min="1" value="1">
                <button type="submit">Tambah ke Keranjang 🛒</button>
            </form>
        </div>
    </div>
<?php endwhile; ?>
</div>

<a href="dashboard_user.php" class="back-btn">⬅ Kembali ke Dashboard</a>

</body>
</html>
