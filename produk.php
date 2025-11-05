<?php
// Koneksi ke database
$koneksi = new mysqli("localhost", "root", "", "db_kasir");
if ($koneksi->connect_error) {
    die("Koneksi gagal: " . $koneksi->connect_error);
}

// Ambil semua data dari tb_produk
$result = $koneksi->query("SELECT * FROM tb_produk ORDER BY kategori, nama_produk");
?>
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Menu Kedai Melwaa 💕</title>
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
<style>
body {
    font-family: 'Poppins', sans-serif;
    background: linear-gradient(135deg, #fff1f8, #e2f7ff);
    margin: 0;
    padding: 0;
    color: #333;
}
header {
    background: linear-gradient(90deg, #ff8cb8, #6ee3ff);
    color: white;
    padding: 20px;
    text-align: center;
    font-size: 22px;
    font-weight: 600;
    box-shadow: 0 4px 10px rgba(0,0,0,0.1);
    position: relative;
}
.back-btn {
    position: absolute;
    right: 20px;
    top: 50%;
    transform: translateY(-50%);
    background: #00bcd4;
    color: #fff;
    padding: 8px 15px;
    border-radius: 10px;
    text-decoration: none;
    font-weight: 600;
    transition: background 0.3s ease;
}
.back-btn:hover {
    background: #0097a7;
}
.menu-container {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
    gap: 25px;
    padding: 40px;
}
.card {
    background: #fff;
    border-radius: 20px;
    padding: 20px;
    text-align: center;
    box-shadow: 0 6px 15px rgba(255,182,193,0.25);
    transition: transform 0.3s ease;
}
.card:hover {
    transform: translateY(-5px);
}
.card img {
    width: 100%;
    height: 150px;
    object-fit: cover;
    border-radius: 15px;
    margin-bottom: 15px;
}
.card h3 {
    color: #ff69b4;
    margin: 10px 0 5px;
}
.card p {
    color: #666;
    margin-bottom: 10px;
}
.card button {
    background: linear-gradient(90deg, #ff69b4, #77e3f0);
    border: none;
    color: #fff;
    border-radius: 8px;
    padding: 8px 14px;
    cursor: pointer;
    font-weight: 600;
}
.card button:hover {
    transform: scale(1.05);
}
footer {
    text-align: center;
    padding: 15px;
    color: #777;
}
</style>
</head>
<body>

<header>
    🍰 Menu Kedai Melwaa 🍹
    <a href="dashboard_user.php" class="back-btn">⬅ Kembali ke Dashboard</a>
</header>

<div class="menu-container">
<?php while ($row = $result->fetch_assoc()): ?>
    <div class="card">
        <img src="uploads/<?= htmlspecialchars($row['foto']) ?>" alt="<?= htmlspecialchars($row['nama_produk']) ?>">
        <h3><?= htmlspecialchars($row['nama_produk']) ?></h3>
        <p><b>Rp <?= number_format($row['harga_jual'], 0, ',', '.') ?></b></p>
        <small><?= ucfirst($row['kategori']) ?> — Stok: <?= $row['stok'] ?> <?= htmlspecialchars($row['satuan']) ?></small><br><br>
    </div>
<?php endwhile; ?>
</div>

<footer>💖 Kedai Melwaa — “Maniskan Harimu Setiap Saat.” 💖</footer>

</body>
</html>
