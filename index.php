<?php
// index.php
?>

<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Kasir Khawalicious</title>
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
<style>
* { box-sizing: border-box; transition: all 0.3s ease; }

body {
    font-family: 'Poppins', sans-serif;
    margin: 0;
    padding: 0;
    height: 100vh;
    display: flex;
    justify-content: center;
    align-items: center;
    background: linear-gradient(135deg, #fff1f8, #e2f7ff);
    color: #333;
}

.container {
    text-align: center;
    background: #fff;
    padding: 50px 40px;
    border-radius: 20px;
    box-shadow: 0 8px 20px rgba(255,182,193,0.25);
    max-width: 400px;
    width: 90%;
}

h1 {
    font-size: 28px;
    color: #ff69b4;
    margin-bottom: 20px;
}

p {
    font-size: 16px;
    color: #555;
    margin-bottom: 30px;
}

button {
    padding: 12px 25px;
    font-size: 16px;
    font-weight: 600;
    border: none;
    border-radius: 10px;
    margin: 10px;
    cursor: pointer;
    color: #fff;
    background: linear-gradient(90deg, #ff69b4, #77e3f0);
    transition: 0.3s;
}

button:hover {
    transform: translateY(-3px);
    box-shadow: 0 8px 15px rgba(119,227,240,0.3);
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
    <h1 class="judul"> Kasir Khawalicious </h1>
    <p>🎉✨ Selamat datang! Silakan pilih login atau registrasi untuk memulai. 🥳🍪</p>

    <button onclick="window.location.href='login.php'">Login</button>
    <button onclick="window.location.href='registrasi.html'">Registrasi</button>

    <footer>Kasir Khawalicious — “Belanja Mudah, Untung Setiap Hari!” 💕</footer>
</div>


</body>
</html>
