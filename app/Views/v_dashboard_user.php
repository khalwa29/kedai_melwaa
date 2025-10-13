<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Dashboard User - Kedai KhaMelicious</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body class="bg-light">

<nav class="navbar navbar-expand-lg navbar-dark bg-success">
  <div class="container-fluid">
    <a class="navbar-brand" href="#">KhaMelicious</a>
    <div class="d-flex">
      <a href="<?= base_url('auth/logout') ?>" class="btn btn-light btn-sm">Logout</a>
    </div>
  </div>
</nav>

<div class="container mt-5">
  <div class="alert alert-info">
    <h4>Hai, <?= session()->get('username') ?>!</h4>
    <p>Selamat datang di halaman pelanggan <strong>Kedai KhaMelicious</strong>.</p>
  </div>

  <div class="row">
    <div class="col-md-6">
      <div class="card shadow-sm">
        <div class="card-body text-center">
          <h5>Lihat Menu</h5>
          <p>Temukan berbagai varian minuman dan makanan spesial dari Kedai KhaMelicious.</p>
          <a href="<?= base_url('menu') ?>" class="btn btn-success btn-sm">Lihat Menu</a>
        </div>
      </div>
    </div>

    <div class="col-md-6">
      <div class="card shadow-sm">
        <div class="card-body text-center">
          <h5>Pesan Sekarang</h5>
          <p>Buat pesanan baru dan nikmati produk favoritmu.</p>
          <a href="<?= base_url('order') ?>" class="btn btn-success btn-sm">Pesan Sekarang</a>
        </div>
      </div>
    </div>
  </div>
</div>

</body>
</html>
