<?php
// Koneksi ke database
$koneksi = new mysqli("localhost", "root", "", "db_kasir");

// Cek koneksi
if ($koneksi->connect_error) {
    die("Koneksi gagal: " . $koneksi->connect_error);
}

// Cek apakah tombol register diklik
if (isset($_POST['register'])) {
    $nama = trim($_POST['nama']);
    $username = trim($_POST['username']);
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);
    $confirm_password = trim($_POST['confirm_password']);

    // Validasi input
    $errors = [];

    if (empty($nama) || empty($username) || empty($email) || empty($password) || empty($confirm_password)) {
        $errors[] = "Semua field wajib diisi!";
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Format email tidak valid!";
    }

    if (strlen($password) < 6) {
        $errors[] = "Password harus minimal 6 karakter!";
    }

    if ($password !== $confirm_password) {
        $errors[] = "Password dan konfirmasi password tidak cocok!";
    }

    if (!isset($_POST['agree_terms'])) {
        $errors[] = "Anda harus menyetujui syarat dan ketentuan!";
    }

    // Cek apakah email sudah terdaftar
    $stmt = $koneksi->prepare("SELECT id FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $errors[] = "Email sudah terdaftar!";
    }
    $stmt->close();

    // Cek apakah username sudah terdaftar
    $stmt = $koneksi->prepare("SELECT id FROM users WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $errors[] = "Username sudah terdaftar!";
    }
    $stmt->close();

    // Jika ada error, redirect kembali ke form dengan data error
    if (!empty($errors)) {
        $error_string = implode(",", $errors);
        $redirect_url = "login_admin.php?register_errors=" . urlencode($error_string) . 
                       "&nama=" . urlencode($nama) . 
                       "&username=" . urlencode($username) . 
                       "&email_old=" . urlencode($email);
        header("Location: $redirect_url");
        exit;
    }

    // Jika tidak ada error, proses pendaftaran
    // Hash password
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);
    
    // Default role sebagai admin
    $role = 'admin';
    
    // COBA BEBERAPA KEMUNGKINAN STRUKTUR TABEL users:
    
    // Opsi 1: Jika tabel punya kolom nama, username, email, password, role
    try {
        $stmt = $koneksi->prepare("INSERT INTO users (nama, username, email, password, role) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("sssss", $nama, $username, $email, $hashed_password, $role);
        
        if ($stmt->execute()) {
            // Redirect ke halaman login dengan pesan sukses
            header("Location: login_admin.php?message=Pendaftaran berhasil! Silakan login.&success=1");
            exit;
        } else {
            throw new Exception($stmt->error);
        }
    } catch (Exception $e) {
        // Opsi 2: Jika tabel punya kolom name (bukan nama)
        try {
            $stmt = $koneksi->prepare("INSERT INTO users (name, username, email, password, role) VALUES (?, ?, ?, ?, ?)");
            $stmt->bind_param("sssss", $nama, $username, $email, $hashed_password, $role);
            
            if ($stmt->execute()) {
                header("Location: login_admin.php?message=Pendaftaran berhasil! Silakan login.&success=1");
                exit;
            } else {
                throw new Exception($stmt->error);
            }
        } catch (Exception $e2) {
            // Opsi 3: Jika tabel hanya punya username, email, password (tanpa nama dan role)
            try {
                $stmt = $koneksi->prepare("INSERT INTO users (username, email, password) VALUES (?, ?, ?)");
                $stmt->bind_param("sss", $username, $email, $hashed_password);
                
                if ($stmt->execute()) {
                    header("Location: login_admin.php?message=Pendaftaran berhasil! Silakan login.&success=1");
                    exit;
                } else {
                    throw new Exception($stmt->error);
                }
            } catch (Exception $e3) {
                // Opsi 4: Jika tabel hanya punya email dan password
                try {
                    $stmt = $koneksi->prepare("INSERT INTO users (email, password) VALUES (?, ?)");
                    $stmt->bind_param("ss", $email, $hashed_password);
                    
                    if ($stmt->execute()) {
                        header("Location: login_admin.php?message=Pendaftaran berhasil! Silakan login.&success=1");
                        exit;
                    } else {
                        throw new Exception($stmt->error);
                    }
                } catch (Exception $e4) {
                    $errors[] = "Terjadi kesalahan database: " . $e4->getMessage();
                    $error_string = implode(",", $errors);
                    header("Location: login_admin.php?register_errors=" . urlencode($error_string));
                    exit;
                }
            }
        }
    }
    
    if (isset($stmt)) {
        $stmt->close();
    }
} else {
    // Jika akses langsung, redirect ke halaman login
    header("Location: login_admin.php");
    exit;
}

$koneksi->close();
?>