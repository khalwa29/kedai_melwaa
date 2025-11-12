<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Dashboard User 💕</title>
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
<style>
body {
    font-family: 'Poppins', sans-serif;
    background: linear-gradient(135deg, #fff1f8, #e2f7ff);
    text-align: center;
    padding: 60px 20px;
    color: #333;
}

.container {
    max-width: 600px;
    margin: auto;
    background: #fff;
    border-radius: 20px;
    padding: 40px;
    box-shadow: 0 8px 20px rgba(255,182,193,0.25);
}

h1 {
    color: #ff69b4;
    font-size: 28px;
    margin-bottom: 15px;
}

p {
    font-size: 16px;
    margin-bottom: 40px;
}

button {
    background: linear-gradient(90deg, #ff69b4, #77e3f0);
    color: white;
    border: none;
    border-radius: 12px;
    padding: 12px 25px;
    margin: 10px;
    cursor: pointer;
    font-size: 16px;
    font-weight: 600;
    box-shadow: 0 4px 10px rgba(0,0,0,0.1);
    transition: transform 0.3s, box-shadow 0.3s;
}

button:hover {
    transform: translateY(-3px);
    box-shadow: 0 8px 15px rgba(255,105,180,0.3);
}

footer {
    margin-top: 30px;
    font-size: 13px;
    color: #777;
}
</style>
</head>
<body>

<div class="container">
    <h1>☕ Selamat Datang di Kedai Melwaa!</h1>
    <p>Hai pelanggan manis 💖, siap menikmati menu spesial hari ini?</p>

    <!-- Tombol Lihat Menu diarahkan ke produk.php -->
    <button onclick="window.location.href='produk.php'">📋 Lihat Menu</button>
    <button onclick="window.location.href='beli.php'">🛍️ Pesan Sekarang</button>
    <button onclick="window.location.href='index.php'">🏠 Kembali ke Beranda</button>

    <footer>Kedai Melwaa — “Nikmatin Harimu dengan Secangkir Bahagia.” 💕</footer>
</div>

</body>
</html>
