<?php
$host = "localhost";
$user = "root";
$pass = "";
$db   = "kedai_db";

$conn = new mysqli($host, $user, $pass, $db);
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

// Ambil semua data pesanan
$sql = "SELECT * FROM pesanan ORDER BY created_at DESC";
$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Admin - Daftar Pesanan</title>
  <!-- Google Fonts -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
  <style>
    body {
      font-family: 'Poppins', sans-serif;
      background: #fdf0f6;
      padding: 20px;
    }
    h1 {
      text-align: center;
      color: #5a3e36;
    }
    .table-container {
      max-width: 1000px;
      margin: 30px auto;
      background: #fff;
      border-radius: 12px;
      box-shadow: 0 4px 10px rgba(0,0,0,0.1);
      overflow-x: auto;
    }
    table {
      border-collapse: collapse;
      width: 100%;
      border-radius: 12px;
      overflow: hidden;
    }
    th, td {
      padding: 12px 15px;
      text-align: left;
    }
    th {
      background: #e07a5f;
      color: #fff;
      font-weight: 600;
    }
    tr:nth-child(even) {
      background: #fdf6f0;
    }
    tr:hover {
      background: #ffe5d9;
    }
    .btn-home {
      display: block;
      width: max-content;
      margin: 20px auto;
      padding: 10px 20px;
      background: #f4a261;
      color: #fff;
      text-decoration: none;
      border-radius: 8px;
      font-weight: 500;
      transition: 0.3s;
    }
    .btn-home:hover {
      background: #e07a5f;
    }
  </style>
</head>
<body>
  <h1>📋 Daftar Pesanan Kedai</h1>
  <div class="table-container">
    <table>
      <tr>
        <th>ID</th>
        <th>Nama</th>
        <th>Menu</th>
        <th>Kategori</th>
        <th>Jumlah</th>
        <th>Catatan</th>
        <th>Waktu</th>
      </tr>
      <?php if ($result->num_rows > 0): ?>
        <?php while($row = $result->fetch_assoc()): ?>
          <tr>
            <td><?= $row['id'] ?></td>
            <td><?= htmlspecialchars($row['nama']) ?></td>
            <td><?= htmlspecialchars($row['menu']) ?></td>
            <td><?= htmlspecialchars($row['kategori']) ?></td>
            <td><?= $row['jumlah'] ?></td>
            <td><?= htmlspecialchars($row['catatan']) ?></td>
            <td><?= $row['created_at'] ?></td>
          </tr>
        <?php endwhile; ?>
      <?php else: ?>
        <tr>
          <td colspan="7" style="text-align:center;">Belum ada pesanan</td>
        </tr>
      <?php endif; ?>
    </table>
  </div>
  <a href="index.html" class="btn-home">⬅ Kembali ke Home</a>
</body>
</html>
<?php $conn->close(); ?>
