<?php
// Koneksi ke database
$koneksi = new mysqli("localhost", "root", "", "db_kasir");
if ($koneksi->connect_error) {
    die("Koneksi gagal: " . $koneksi->connect_error);
}

// Ambil semua data produk
$result = $koneksi->query("SELECT * FROM tb_produk ORDER BY kategori, nama_produk ASC");

// Simpan data produk ke array untuk JS
$produk_array = [];
while ($row = $result->fetch_assoc()) {
    $produk_array[] = $row;
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Form Pesanan Multi Menu - Kedai Melwaa 💕</title>
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
<style>
body { font-family: 'Poppins', sans-serif; background: #fff9fc; margin: 0; padding: 20px; }
h1 { text-align: center; color: #ff4b9d; margin-bottom: 20px; }
form { max-width: 600px; margin: 20px auto; background: #fff; padding: 25px; border-radius: 15px; box-shadow: 0 4px 12px rgba(0,0,0,0.1);}
label { display: block; margin-top: 15px; font-weight: 600; }
input, select, textarea { width: 100%; padding: 10px; border-radius: 8px; border: 1px solid #ddd; margin-top: 5px; box-sizing: border-box; }
button { margin-top: 20px; width: 100%; padding: 10px; background: linear-gradient(90deg, #ff69b4, #ff85c1); color: #fff; border: none; border-radius: 10px; font-weight: 600; cursor: pointer; }
button:hover { background: linear-gradient(90deg, #ff85c1, #ffa3d1); }
.back-btn { display: block; text-align: center; margin: 20px auto; text-decoration: none; background: #00bcd4; color: #fff; padding: 10px 25px; border-radius: 10px; font-weight: 600; }
.back-btn:hover { background: #0097a7; }
.order-item { border: 1px solid #eee; padding: 15px; border-radius: 10px; margin-top: 15px; position: relative; }
.remove-btn { position: absolute; top: 10px; right: 10px; background: #f44336; color: #fff; border: none; border-radius: 5px; padding: 5px 10px; cursor: pointer; }
.remove-btn:hover { background: #d32f2f; }
</style>
</head>
<body>

<h1>📝 Form Pesanan Multi Menu Kedai Melwaa</h1>

<form action="proses_beli.php" method="POST" id="order-form">
    <label>Nama Pemesan</label>
    <input type="text" name="nama" required placeholder="Masukkan nama Anda">

    <div id="order-items">
        <!-- Baris menu akan ditambahkan di sini -->
    </div>

    <button type="button" onclick="addMenuItem()">➕ Tambah Menu</button>
    <button type="submit">Pesan Sekarang 🛒</button>
</form>

<a href="dashboard_user.php" class="back-btn">⬅ Kembali ke Dashboard</a>

<script>
// Data produk dari PHP
const produkArray = <?php echo json_encode($produk_array); ?>;
let itemCount = 0;

function addMenuItem() {
    itemCount++;
    const container = document.getElementById('order-items');
    const div = document.createElement('div');
    div.className = 'order-item';
    div.id = 'item-' + itemCount;

    let options = '<option value="">-- Pilih Menu --</option>';
    produkArray.forEach(p => {
        options += `<option value="${p.id_produk}" data-kategori="${p.kategori}" data-stok="${p.stok}">${p.nama_produk} (Rp ${p.harga_jual.toLocaleString('id-ID')})</option>`;
    });

    div.innerHTML = `
        <button type="button" class="remove-btn" onclick="removeItem(${itemCount})">✖</button>
        <label>Menu</label>
        <select name="id_produk[]" onchange="updateKategori(this)" required>${options}</select>
        <label>Kategori</label>
        <input type="text" name="kategori[]" readonly placeholder="Kategori otomatis">
        <label>Jumlah</label>
        <select name="qty[]" required>
            <option value="1">1</option>
        </select>
        <label>Catatan</label>
        <textarea name="catatan[]" rows="2" placeholder="Misal: kurang pedas, tambah es..."></textarea>
    `;

    container.appendChild(div);
}

function removeItem(id) {
    const el = document.getElementById('item-' + id);
    el.remove();
}

function updateKategori(selectElem) {
    const selectedOption = selectElem.options[selectElem.selectedIndex];
    const kategori = selectedOption.getAttribute('data-kategori');
    const stok = parseInt(selectedOption.getAttribute('data-stok')) || 1;

    const parent = selectElem.parentElement;
    parent.querySelector('input[name="kategori[]"]').value = kategori;

    const qtySelect = parent.querySelector('select[name="qty[]"]');
    qtySelect.innerHTML = '';
    for (let i = 1; i <= stok; i++) {
        const opt = document.createElement('option');
        opt.value = i;
        opt.textContent = i;
        qtySelect.appendChild(opt);
    }
}

// Tambahkan baris pertama otomatis
addMenuItem();
</script>

</body>
</html>
