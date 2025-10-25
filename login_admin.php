<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login Admin</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body {
      background: linear-gradient(135deg, #e3f8ff, #ffe6f9);
      font-family: 'Poppins', sans-serif;
    }
    .login-container {
      width: 400px;
      margin: 100px auto;
      background: #fff;
      padding: 40px;
      border-radius: 15px;
      box-shadow: 0 5px 15px rgba(0,0,0,0.1);
    }
    .btn-custom {
      background-color: #ff69b4;
      color: white;
      border: none;
    }
    .btn-custom:hover {
      background-color: #ff4b91;
    }
  </style>
</head>
<body>

  <div class="login-container">
    <h3 class="text-center mb-4">Login Admin</h3>
    <form action="proses_login_admin.php" method="POST">
      <div class="mb-3">
        <label for="email" class="form-label">Email:</label>
        <input type="email" name="email" id="email" class="form-control" placeholder="Masukkan email" required>
      </div>
      <div class="mb-3">
        <label for="password" class="form-label">Password:</label>
        <input type="password" name="password" id="password" class="form-control" placeholder="Masukkan password" required>
      </div>
      <button type="submit" name="login" class="btn btn-custom w-100 mt-3">Login</button>
    </form>
  </div>

</body>
</html>
