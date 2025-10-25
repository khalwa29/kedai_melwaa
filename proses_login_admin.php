<?php
session_start();

// Koneksi ke database
$koneksi = new mysqli("localhost", "root", "", "db_kasir");

// Cek koneksi
if ($koneksi->connect_error) {
    die("Koneksi gagal: " . $koneksi->connect_error);
}

// Cek apakah tombol login diklik
if (isset($_POST['login'])) {
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);

    // Validasi input
    if (empty($email) || empty($password)) {
        echo "<script>
                alert('Email dan Password wajib diisi!');
                window.location='login_admin.php';
              </script>";
        exit;
    }

    // Ambil data user berdasarkan email
    $stmt = $koneksi->prepare("SELECT * FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();

        // Verifikasi password
        if (password_verify($password, $user['password'])) {
            // Simpan data ke session
            $_SESSION['user_id']   = $user['id'];
            $_SESSION['username']  = $user['username'];
            $_SESSION['email']     = $user['email'];

            echo "<script>
                    alert('Login berhasil! Selamat datang, {$user['username']}');
                    window.location='dashboard_user.php';
                  </script>";
        } else {
            echo "<script>
                    alert('Password salah!');
                    window.location='login_admin.php';
                  </script>";
        }
    } else {
        echo "<script>
                alert('Email tidak ditemukan!');
                window.location='login_admin.php';
              </script>";
    }

    $stmt->close();
} else {
    header("Location: login_admin.php");
    exit;
}

$koneksi->close();
?>
