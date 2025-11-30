<?php
// Koneksi ke database
$koneksi = new mysqli("localhost", "root", "", "db_kasir");
if ($koneksi->connect_error) {
    die("Koneksi gagal: " . $koneksi->connect_error);
}

// Ambil semua data dari tabel tb_produk
$result = $koneksi->query("SELECT * FROM tb_produk ORDER BY kategori, nama_produk");
?>
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Menu Kedai Melwaa 💕</title>
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">
<style>
* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
}

body {
    font-family: 'Poppins', sans-serif;
    background: linear-gradient(135deg, #fef4f9, #e8f4fd);
    min-height: 100vh;
    padding-bottom: 40px;
}

header {
    background: linear-gradient(90deg, #ff8cb8, #6ee3ff);
    color: white;
    padding: 25px 20px;
    text-align: center;
    font-size: 26px;
    font-weight: 700;
    box-shadow: 0 4px 15px rgba(0,0,0,0.15);
    position: relative;
    margin-bottom: 40px;
}

.back-btn {
    position: absolute;
    right: 20px;
    top: 50%;
    transform: translateY(-50%);
    background: rgba(255,255,255,0.3);
    color: #fff;
    padding: 10px 20px;
    border-radius: 12px;
    text-decoration: none;
    font-weight: 600;
    font-size: 14px;
    transition: all 0.3s ease;
    backdrop-filter: blur(10px);
}

.back-btn:hover {
    background: rgba(255,255,255,0.5);
    transform: translateY(-50%) scale(1.05);
}

.menu-container {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
    gap: 30px;
    padding: 0 40px;
    max-width: 1400px;
    margin: 0 auto;
}

.card {
    background: #fff;
    border-radius: 25px;
    overflow: hidden;
    box-shadow: 0 8px 25px rgba(255,140,184,0.15);
    transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
    cursor: pointer;
}

.card:hover {
    transform: translateY(-10px);
    box-shadow: 0 15px 40px rgba(255,140,184,0.3);
}

.card-image {
    width: 100%;
    height: 240px;
    overflow: hidden;
    position: relative;
    background: linear-gradient(135deg, #ffb6c1, #87ceeb);
}

.card-image img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform 0.4s ease;
}

.card:hover .card-image img {
    transform: scale(1.1);
}

.no-image {
    width: 100%;
    height: 100%;
    background: linear-gradient(135deg, #ffb6c1, #87ceeb);
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-size: 48px;
}

.card-content {
    padding: 20px;
    text-align: center;
}

.card-title {
    color: #ff1493;
    font-size: 20px;
    font-weight: 700;
    margin-bottom: 12px;
    min-height: 50px;
    display: flex;
    align-items: center;
    justify-content: center;
}

.card-price {
    color: #333;
    font-size: 22px;
    font-weight: 700;
    margin-bottom: 10px;
}

.card-info {
    color: #666;
    font-size: 13px;
    line-height: 1.6;
}

.category-badge {
    display: inline-block;
    background: linear-gradient(90deg, #ff69b4, #77e3f0);
    color: white;
    padding: 4px 12px;
    border-radius: 15px;
    font-size: 11px;
    font-weight: 600;
    text-transform: capitalize;
    margin-bottom: 5px;
}

footer {
    text-align: center;
    padding: 30px 20px;
    color: #ff69b4;
    font-weight: 600;
    margin-top: 50px;
    font-size: 16px;
}

@media (max-width: 768px) {
    .menu-container {
        grid-template-columns: repeat(auto-fill, minmax(220px, 1fr));
        gap: 20px;
        padding: 0 20px;
    }
    
    .card-image {
        height: 200px;
    }
    
    header {
        font-size: 20px;
        padding: 20px 15px;
    }
    
    .back-btn {
        font-size: 12px;
        padding: 8px 15px;
    }
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
        <div class="card-image">
            <?php 
            // Ambil nama file dari database
            $namaFile = !empty($row['foto']) ? $row['foto'] : '';
            
            // Cek berbagai kemungkinan lokasi foto
            $fotoPaths = [
                "uploads/" . $namaFile,
                "images/" . $namaFile,
                "../uploads/" . $namaFile,
            ];
            
            $fotoFound = false;
            $validPath = "";
            
            // Cek setiap kemungkinan path
            foreach ($fotoPaths as $path) {
                if (!empty($namaFile) && file_exists($path)) {
                    $fotoFound = true;
                    $validPath = $path;
                    break;
                }
            }
            
            if ($fotoFound): 
            ?>
                <img src="<?php echo htmlspecialchars($validPath); ?>" 
                     alt="<?php echo htmlspecialchars($row['nama_produk']); ?>" 
                     onerror="this.style.display='none'; this.parentElement.innerHTML='<div class=\'no-image\'>📸</div>';">
            <?php else: ?>
                <div class="no-image">📸</div>
            <?php endif; ?>
        </div>
        
        <div class="card-content">
            <h3 class="card-title"><?php echo htmlspecialchars($row['nama_produk']); ?></h3>
            <div class="card-price">Rp <?php echo number_format($row['harga_jual'], 0, ',', '.'); ?></div>
            <span class="category-badge"><?php echo ucfirst($row['kategori']); ?></span>
            <div class="card-info">Stok: <?php echo $row['stok']; ?> <?php echo htmlspecialchars($row['satuan']); ?></div>
        </div>
    </div>
<?php endwhile; ?>
</div>

<footer>💖 Kedai Melwaa — "Maniskan Harimu Setiap Saat." 💖</footer>
</body>
</html>