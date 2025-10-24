<?php
// Koneksi ke database 💖
$host = "localhost";
$user = "root";
$pass = "";
$db   = "db_chatgpt"; // nama database kamu

$conn = new mysqli($host, $user, $pass, $db);

// Cek koneksi 😿
if ($conn->connect_error) {
    die("<h3 style='color:pink;text-align:center;'>Koneksi ke database gagal 💔 : " . $conn->connect_error . "</h3>");
}

// Jika form dikirim
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $email    = $_POST['email'];
    $password = $_POST['password'];

    // Enkripsi password
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    // Cek apakah email sudah terdaftar 💌
    $cek = $conn->prepare("SELECT * FROM users WHERE email = ?");
    $cek->bind_param("s", $email);
    $cek->execute();
    $result = $cek->get_result();

    if ($result->num_rows > 0) {
        echo "<script>alert('😿 Email sudah digunakan, coba pakai yang lain ya~');</script>";
    } else {
        // Simpan ke database 💾
        $stmt = $conn->prepare("INSERT INTO users (username, email, password) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $username, $email, $hashedPassword);

        if ($stmt->execute()) {
            echo "<script>alert('🎀 Registrasi berhasil! Selamat datang, $username 💕'); window.location.href='login.php';</script>";
        } else {
            echo "<script>alert('😿 Wah, ada kesalahan saat menyimpan data.');</script>";
        }

        $stmt->close();
    }
}
$conn->close();
?>

<!DOCTYPE html>
<html lang="id">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Registrasi Kasir Imut 💕</title>
    <style>
      body {
        font-family: "Poppins", sans-serif;
        background: linear-gradient(135deg, #ffe6f2, #e0f7fa);
        height: 100vh;
        display: flex;
        justify-content: center;
        align-items: center;
      }

      .container {
        background-color: #fff;
        border-radius: 20px;
        padding: 30px;
        width: 360px;
        box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
        text-align: center;
        border: 3px solid #ffd6e7;
        position: relative;
      }

      h2 {
        color: #ff69b4;
        font-size: 24px;
        margin-bottom: 20px;
      }

      label {
        display: block;
        text-align: left;
        margin-top: 12px;
        color: #444;
        font-weight: 600;
      }

      input[type="text"],
      input[type="email"],
      input[type="password"] {
        width: 100%;
        padding: 10px;
        margin-top: 5px;
        border: 2px solid #ffb6c1;
        border-radius: 10px;
        outline: none;
        transition: 0.3s;
        font-size: 14px;
      }

      input:focus {
        border-color: #ff69b4;
        box-shadow: 0 0 8px rgba(255, 182, 193, 0.6);
      }

      button {
        background-color: #ff69b4;
        color: white;
        border: none;
        border-radius: 12px;
        padding: 10px 0;
        width: 100%;
        margin-top: 20px;
        font-size: 16px;
        cursor: pointer;
        transition: 0.3s;
        box-shadow: 0 4px 8px rgba(255, 105, 180, 0.3);
      }

      button:hover {
        background-color: #ff85c1;
        transform: scale(1.03);
      }

      .login-link {
        margin-top: 15px;
        font-size: 14px;
      }

      .login-link a {
        color: #ff69b4;
        text-decoration: none;
        font-weight: bold;
      }

      .login-link a:hover {
        text-decoration: underline;
      }

      .emoji {
        font-size: 40px;
        position: absolute;
        top: -20px;
        right: -10px;
      }
    </style>
  </head>
  <body>
    <div class="container">
      <div class="emoji">🌸</div>
      <h2>Registrasi Kasir 💖</h2>
      <form method="POST">
        <label for="username">✨ Username</label>
        <input type="text" id="username" name="username" placeholder="Masukkan username unyu" required />

        <label for="email">📧 Email</label>
        <input type="email" id="email" name="email" placeholder="Masukkan email kamu" required />

        <label for="password">🔒 Password</label>
        <input type="password" id="password" name="password" placeholder="Masukkan password rahasia" required />

        <button type="submit">💌 Daftar Sekarang</button>

        <div class="login-link">
          <p>Sudah punya akun? <a href="login.html">Login yuk~ 💫</a></p>
        </div>
      </form>
    </div>
  </body>
</html>
