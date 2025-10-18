<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login Admin - Kedai KhaMelicious</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body {
      background: linear-gradient(135deg, #b30000, #ff4d4d);
      height: 100vh;
      display: flex;
      justify-content: center;
      align-items: center;
      font-family: 'Poppins', sans-serif;
    }
    .login-card {
      background: #fff;
      border-radius: 15px;
      padding: 30px;
      width: 100%;
      max-width: 380px;
      box-shadow: 0 5px 20px rgba(0,0,0,0.2);
    }
    .login-card h3 {
      color: #b30000;
      font-weight: 600;
    }
    .btn-login {
      background-color: #b30000;
      border: none;
    }
    .btn-login:hover {
      background-color: #800000;
    }
    .text-muted a {
      color: #b30000;
      text-decoration: none;
      font-weight: 500;
    }
  </style>
</head>
<body>

  <div class="login-card text-center">
    <h3 class="mb-4">Login Admin</h3>

    <?php if(session()->getFlashdata('error')): ?>
      <div class="alert alert-danger"><?= session()->getFlashdata('error') ?></div>
    <?php endif; ?>

    <form action="<?= base_url('/auth/processLogin') ?>" method="post">
      <div class="mb-3 text-start">
        <label class="form-label">Username</label>
        <input type="text" name="username" class="form-control" placeholder="Masukkan username" required>
      </div>
      <div class="mb-3 text-start">
        <label class="form-label">Password</label>
        <input type="password" name="password" class="form-control" placeholder="Masukkan password" required>
      </div>
      <button type="submit" class="btn btn-login text-white w-100 py-2">Masuk</button>
    </form>

    <p class="text-muted mt-4 mb-0">Belum punya akun? <br> <span class="fw-semibold text-dark">Hubungi Admin Kedai KhaMelicious.</span></p>
  </div>

</body>
</html>
