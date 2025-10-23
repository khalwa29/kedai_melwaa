<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Dashboard Admin - Kedai KhaMelicious</title>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body class="bg-light">

<nav class="navbar navbar-expand-lg navbar-dark bg-primary">
  <div class="container-fluid">
    <a class="navbar-brand" href="#">KhaMelicious Admin</a>
    <div class="d-flex">
      <a href="<?= base_url('auth/logout') ?>" class="btn btn-light btn-sm">Logout</a>
    </div>
  </div>
</nav>

<div class="container mt-5">
  <div class="alert alert-success">
    <h4>Selamat datang, <?= session()->get('username') ?>!</h4>
    <p>Anda login sebagai <strong>Admin</strong>.</p>
  </div>

  <div class="row g-4">
    <div class="col-md-4">
      <div class="card shadow-sm h-100 text-center">
        <div class="card-body">
          <h5 class="card-title">Kelola Menu</h5>
          <p class="card-text">Tambah, ubah, atau hapus data menu Kedai.</p>
          <a href="<?= base_url('menu') ?>" class="btn btn-primary btn-sm">Buka Menu</a>
        </div>
      </div>
    </div>

    <div class="col-md-4">
      <div class="card shadow-sm h-100 text-center">
        <div class="card-body">
          <h5 class="card-title">Kelola Order</h5>
          <p class="card-text">Lihat pesanan pelanggan dan cetak struk.</p>
          <a href="<?= base_url('order') ?>" class="btn btn-primary btn-sm">Lihat Order</a>
        </div>
      </div>
    </div>

    <div class="col-md-4">
      <div class="card shadow-sm h-100 text-center">
        <div class="card-body">
          <h5 class="card-title">Statistik Penjualan</h5>
          <p class="card-text">Analisis transaksi harian dan mingguan.</p>
          <a href="<?= base_url('statistik') ?>" class="btn btn-primary btn-sm">Lihat Statistik</a>
        </div>
      </div>
    </div>
  </div>
</div>

</body>
</html>
