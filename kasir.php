<?php
session_start();
if (!isset($_SESSION["email"])) {
    header("Location: login.php");
    exit;
}
$username = $_SESSION["username"] ?? 'Kasir';

// koneksi DB — sesuaikan host/user/pass/db jika perlu
$koneksi = new mysqli("localhost", "root", "", "db_chatgpt");
if ($koneksi->connect_error) {
    http_response_code(500);
    echo json_encode(["error" => "Database connection failed"]);
    exit;
}

// --- Endpoint API (AJAX) ---
if (isset($_GET['action'])) {
    header('Content-Type: application/json; charset=UTF-8');
    $action = $_GET['action'];

    if ($action === 'list_products') {
        // pagination
        $page = max(1, (int)($_GET['page'] ?? 1));
        $perPage = 10;
        $offset = ($page - 1) * $perPage;

        // optional search
        $search = trim($_GET['search'] ?? '');

        if ($search !== '') {
            $like = "%{$search}%";
            $stmt = $koneksi->prepare("SELECT COUNT(*) FROM tb_produk WHERE nama_produk LIKE ? OR kode_produk LIKE ?");
            $stmt->bind_param('ss', $like, $like);
            $stmt->execute();
            $stmt->bind_result($totalRows);
            $stmt->fetch();
            $stmt->close();

            $stmt = $koneksi->prepare("SELECT id_produk, kode_produk, nama_produk, kategori, harga_jual, stok, satuan FROM tb_produk WHERE nama_produk LIKE ? OR kode_produk LIKE ? ORDER BY id_produk DESC LIMIT ? OFFSET ?");
            $stmt->bind_param('ssii', $like, $like, $perPage, $offset);
        } else {
            $res = $koneksi->query("SELECT COUNT(*) as cnt FROM tb_produk");
            $row = $res->fetch_assoc();
            $totalRows = (int)$row['cnt'];

            $stmt = $koneksi->prepare("SELECT id_produk, kode_produk, nama_produk, kategori, harga_jual, stok, satuan FROM tb_produk ORDER BY id_produk DESC LIMIT ? OFFSET ?");
            $stmt->bind_param('ii', $perPage, $offset);
        }

        $stmt->execute();
        $result = $stmt->get_result();
        $products = $result->fetch_all(MYSQLI_ASSOC);
        $stmt->close();

        echo json_encode([
            "page" => $page,
            "perPage" => $perPage,
            "total" => $totalRows,
            "products" => $products
        ], JSON_UNESCAPED_UNICODE);
        exit;
    }

    if ($action === 'checkout' && $_SERVER['REQUEST_METHOD'] === 'POST') {
        // menerima JSON
        $input = json_decode(file_get_contents('php://input'), true);
        if (!$input) {
            echo json_encode(["error" => "Invalid input"]);
            exit;
        }
        $cart = $input['cart'] ?? [];
        $total = floatval($input['total'] ?? 0);
        $bayar = floatval($input['bayar'] ?? 0);
        $kembalian = floatval($input['kembalian'] ?? 0);

        if (empty($cart) || $total <= 0) {
            echo json_encode(["error" => "Cart kosong atau total tidak valid"]);
            exit;
        }

        // create unique invoice no
        $nomorFaktur = 'INV' . date('YmdHis') . rand(100, 999);

        $koneksi->begin_transaction();
        try {
            // insert master jual
            $stmt = $koneksi->prepare("INSERT INTO tb_jual (nomor_faktur, tanggal_beli, total_belanja, total_bayar, kembalian) VALUES (?, NOW(), ?, ?, ?)");
            $stmt->bind_param('sddd', $nomorFaktur, $total, $bayar, $kembalian);
            $stmt->execute();
            $id_jual = $stmt->insert_id;
            $stmt->close();

            // insert ke tabel rinci_jual (detail per produk)
$stmtDetail = $koneksi->prepare("
    INSERT INTO rinci_jual 
    (nomor_faktur, kode_produk, nama_produk, harga_modal, harga_jual, qty, total_harga, untung)
    VALUES (?, ?, ?, ?, ?, ?, ?, ?)
");

foreach ($cart as $item) {
    $kode_produk = $item['id_produk'];  // pastikan key ini sesuai dengan data di keranjang kamu
    $nama_produk = $item['nama_produk'];
    $harga_modal = 0; // sementara 0, nanti bisa diambil dari tabel produk
    $harga_jual = floatval($item['harga_jual']);
    $qty = intval($item['qty']);
    $total_harga = $harga_jual * $qty;
    $untung = ($harga_jual - $harga_modal) * $qty;

    $stmtDetail->bind_param(
        'sssddidd',
        $nomorFaktur,
        $kode_produk,
        $nama_produk,
        $harga_modal,
        $harga_jual,
        $qty,
        $total_harga,
        $untung
    );
    $stmtDetail->execute();
}
$stmtDetail->close();

            $koneksi->commit();
            echo json_encode(["success" => true, "nomor_faktur" => $nomorFaktur, "id_jual" => $id_jual]);
            exit;
        } catch (Exception $e) {
            $koneksi->rollback();
            http_response_code(500);
            echo json_encode(["error" => "Gagal menyimpan transaksi: " . $e->getMessage()]);
            exit;
        }
    }

    // unknown action
    echo json_encode(["error" => "Unknown action"]);
    exit;
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width,initial-scale=1">
<title>Kasir - Khawalicious</title>
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
<style>
  body{font-family:'Poppins',sans-serif;background:linear-gradient(135deg,#fff1f8,#e2f7ff);margin:0;color:#333}
  header{background:linear-gradient(90deg,#ff8cb8,#6ee3ff);color:#fff;padding:18px 24px;display:flex;justify-content:space-between;align-items:center}
  header a{background:#fff;color:#ff69b4;padding:8px 12px;border-radius:10px;text-decoration:none;font-weight:600}
  .wrap{max-width:1150px;margin:28px auto;padding:20px;background:#fff;border-radius:16px;box-shadow:0 8px 25px rgba(0,0,0,0.06)}
  h2{color:#ff69b4;margin:0 0 12px}
  .top-row{display:flex;gap:12px;flex-wrap:wrap;margin-bottom:12px}
  .search{flex:1;display:flex;gap:8px}
  .search input{flex:1;padding:8px 10px;border-radius:8px;border:1px solid #ddd}
  .card{background:#fff;padding:12px;border-radius:12px;box-shadow:0 4px 14px rgba(255,182,193,0.15)}
  table{width:100%;border-collapse:collapse}
  th,td{padding:10px;border-bottom:1px solid #f6dfe9;text-align:left}
  thead th{background:linear-gradient(90deg,#ffb6c1,#a3f3ff);color:#fff}
  .add-btn{background:#ff69b4;color:#fff;padding:6px 10px;border-radius:8px;border:none;cursor:pointer}
  .add-btn:disabled{opacity:0.6;cursor:not-allowed}
  .pagination{display:flex;gap:6px;flex-wrap:wrap;align-items:center;margin-top:10px}
  .page-btn{padding:6px 10px;border-radius:8px;border:1px solid #ffd9ec;background:#fff;cursor:pointer}
  .cart-area{margin-top:18px}
  .small{font-size:13px;color:#666}
  .controls{display:flex;gap:8px;flex-wrap:wrap;align-items:center}
  .right{margin-left:auto}
  input[type="number"], input[type="text"]{padding:8px;border-radius:8px;border:1px solid #ddd}
  .pay-btn{background:linear-gradient(90deg,#ff69b4,#77e3f0);color:#fff;padding:10px 14px;border:none;border-radius:10px;cursor:pointer}
  @media (max-width:800px){
    th,td{font-size:13px;padding:8px}
    .top-row{flex-direction:column}
  }
</style>
</head>
<body>
<header>
  <div>
    <h1 style="margin:0">Kasir Khawalicious</h1>
    <div style="font-size:14px;margin-top:6px">Hai, <?= htmlspecialchars($username) ?> — halaman transaksi</div>
  </div>
  <a href="dashboard.php">🏠 Dashboard</a>
</header>

<div class="wrap">
  <h2>Daftar Produk</h2>

  <div class="top-row">
    <div class="search">
      <input id="searchInput" type="text" placeholder="Cari nama atau kode produk...">
      <button id="searchBtn" class="page-btn">Cari</button>
    </div>
    <div class="controls right">
      <div class="small">Menampilkan <span id="showCount">0</span> produk</div>
    </div>
  </div>

  <div class="card">
    <div style="overflow:auto;">
      <table id="productTable">
        <thead>
          <tr>
            <th>No</th><th>Kode</th><th>Nama Produk</th><th>Harga Jual</th><th>Stok</th><th>Satuan</th><th>Aksi</th>
          </tr>
        </thead>
        <tbody id="productBody">
          <!-- diisi JS -->
        </tbody>
      </table>
    </div>

    <div class="pagination" id="pagination"></div>
  </div>

  <!-- CART -->
  <div class="cart-area">
    <h2>Keranjang Belanja</h2>
    <div class="card">
      <div style="overflow:auto;">
        <table id="cartTable">
          <thead>
            <tr><th>No</th><th>Nama Produk</th><th>Harga</th><th>Qty</th><th>Total</th><th>Aksi</th></tr>
          </thead>
          <tbody id="cartBody">
            <!-- JS -->
          </tbody>
        </table>
      </div>

      <div style="display:flex;gap:12px;align-items:center;margin-top:12px;flex-wrap:wrap">
        <div class="small">Total Belanja: <strong>Rp <span id="totalDisplay">0</span></strong></div>
        <div style="margin-left:auto;display:flex;gap:8px;align-items:center">
          <label>Total Bayar: Rp <input id="inputBayar" type="number" min="0" step="1" value="0" style="width:140px"></label>
          <label>Kembalian: Rp <input id="inputKembali" type="number" readonly style="width:140px"></label>
          <button id="btnBayar" class="pay-btn">Bayar</button>
        </div>
      </div>
      <div id="message" style="margin-top:10px;color:green"></div>
    </div>
  </div>
</div>

<script>
const apiUrl = 'kasir.php';
let currentPage = 1;
let totalRows = 0;
let perPage = 10;
let searchTerm = '';

// cart object: key = id_produk, value = item
let cart = {};

function formatRupiah(num){
  num = Number(num) || 0;
  return num.toLocaleString('id-ID', {minimumFractionDigits: 0, maximumFractionDigits: 0});
}

async function fetchProducts(page = 1){
  currentPage = page;
  const q = new URLSearchParams({action: 'list_products', page, search: searchTerm});
  const res = await fetch(apiUrl + '?' + q.toString());
  const data = await res.json();
  totalRows = data.total;
  perPage = data.perPage;
  renderProducts(data.products);
  renderPagination();
  document.getElementById('showCount').innerText = totalRows;
}

function renderProducts(products){
  const tbody = document.getElementById('productBody');
  tbody.innerHTML = '';
  let no = (currentPage - 1) * perPage + 1;
  for (const p of products) {
    const tr = document.createElement('tr');
    tr.innerHTML = `
      <td>${no++}</td>
      <td>${escapeHtml(p.kode_produk)}</td>
      <td>${escapeHtml(p.nama_produk)}</td>
      <td>Rp ${formatRupiah(p.harga_jual)}</td>
      <td>${p.stok}</td>
      <td>${p.satuan ?? ''}</td>
      <td><button class="add-btn" onclick='addToCart(${p.id_produk}, ${p.harga_jual}, "${escapeJs(p.nama_produk)}")'>+ Add to cart</button></td>
    `;
    tbody.appendChild(tr);
  }
}

function renderPagination(){
  const totalPages = Math.ceil(totalRows / perPage) || 1;
  const wrap = document.getElementById('pagination');
  wrap.innerHTML = '';
  if (currentPage > 1) {
    const btnPrev = createPageBtn('Prev', currentPage - 1);
    wrap.appendChild(btnPrev);
  }
  // show some pages (up to 7)
  let start = Math.max(1, currentPage - 3);
  let end = Math.min(totalPages, currentPage + 3);
  for (let p = start; p <= end; p++){
    const btn = createPageBtn(p, p, p === currentPage);
    wrap.appendChild(btn);
  }
  if (currentPage < totalPages) {
    const btnNext = createPageBtn('Next', currentPage + 1);
    wrap.appendChild(btnNext);
  }
}

function createPageBtn(label, page, active = false){
  const btn = document.createElement('button');
  btn.className = 'page-btn';
  btn.textContent = label;
  if (active) {
    btn.style.background = '#ff69b4';
    btn.style.color = '#fff';
    btn.disabled = true;
  }
  btn.onclick = () => fetchProducts(page);
  return btn;
}

function addToCart(id, harga, nama){
  id = String(id);
  if (cart[id]) {
    cart[id].qty += 1;
  } else {
    cart[id] = {
      id_produk: id,
      nama_produk: nama,
      harga_jual: Number(harga),
      qty: 1
    };
  }
  renderCart();
}

function updateQty(id, val){
  id = String(id);
  val = parseInt(val) || 0;
  if (val <= 0) {
    delete cart[id];
  } else {
    cart[id].qty = val;
  }
  renderCart();
}

function removeItem(id){
  id = String(id);
  delete cart[id];
  renderCart();
}

function renderCart(){
  const tbody = document.getElementById('cartBody');
  tbody.innerHTML = '';
  let i = 1;
  let total = 0;
  for (const key in cart) {
    const it = cart[key];
    const subtotal = it.harga_jual * it.qty;
    total += subtotal;
    const tr = document.createElement('tr');
    tr.innerHTML = `
      <td>${i++}</td>
      <td>${escapeHtml(it.nama_produk)}</td>
      <td>Rp ${formatRupiah(it.harga_jual)}</td>
      <td><input type="number" min="1" value="${it.qty}" style="width:70px" onchange="updateQty('${it.id_produk}', this.value)"></td>
      <td>Rp ${formatRupiah(subtotal)}</td>
      <td><button class="page-btn" onclick="removeItem('${it.id_produk}')">Hapus</button></td>
    `;
    tbody.appendChild(tr);
  }
  document.getElementById('totalDisplay').innerText = formatRupiah(total);
  // store total numeric for checkout
  document.getElementById('inputBayar').dataset.total = total;
  // update kembalian if bayar value present
  recalcKembali();
}

function recalcKembali(){
  const bayarEl = document.getElementById('inputBayar');
  const kembaliEl = document.getElementById('inputKembali');
  const total = Number(bayarEl.dataset.total || 0);
  const bayar = Number(bayarEl.value) || 0;
  const kembalian = Math.max(0, bayar - total);
  kembaliEl.value = Math.round(kembalian);
}

document.getElementById('searchBtn').addEventListener('click', () => {
  searchTerm = document.getElementById('searchInput').value.trim();
  fetchProducts(1);
});
document.getElementById('searchInput').addEventListener('keypress', (e) => {
  if (e.key === 'Enter') { searchTerm = e.target.value.trim(); fetchProducts(1); }
});

document.getElementById('inputBayar').addEventListener('input', recalcKembali);

document.getElementById('btnBayar').addEventListener('click', async () => {
  const bayarEl = document.getElementById('inputBayar');
  const total = Number(bayarEl.dataset.total || 0);
  const bayar = Number(bayarEl.value) || 0;
  const kembalian = Math.max(0, bayar - total);

  if (Object.keys(cart).length === 0) {
    alert('Keranjang kosong!');
    return;
  }
  if (bayar < total) {
    if (!confirm('Bayar kurang dari total. Simpan misal piutang? Tekan OK untuk lanjut menyimpan.')) {
      return;
    }
  }

  // prepare payload
  const payload = {
    cart: Object.values(cart),
    total: total,
    bayar: bayar,
    kembalian: kembalian
  };

  const resp = await fetch(apiUrl + '?action=checkout', {
    method: 'POST',
    headers: {'Content-Type': 'application/json'},
    body: JSON.stringify(payload)
  });
  const data = await resp.json();
  if (data.success) {
    document.getElementById('message').innerText = 'Transaksi berhasil. No Faktur: ' + data.nomor_faktur;
    // clear cart and display
    cart = {};
    renderCart();
    document.getElementById('inputBayar').value = 0;
    document.getElementById('inputKembali').value = 0;
    // refresh products (stok mungkin berubah in real app)
    fetchProducts(currentPage);
  } else {
    alert('Error: ' + (data.error || 'Gagal menyimpan transaksi'));
  }
});

// util: escapeHTML
function escapeHtml(unsafe) {
  return String(unsafe || '').replace(/[&<>"'`=\/]/g, function(s) {
    return {'&':'&amp;','<':'&lt;','>':'&gt;','"':'&quot;',"'":'&#39;','/':'&#x2F;','`':'&#x60;','=':'&#x3D;'}[s];
  });
}
// util: escape for embedding into JS string (basic)
function escapeJs(s) {
  return String(s || '').replace(/\\/g,'\\\\').replace(/'/g,"\\'").replace(/"/g,'&quot;');
}

// init
fetchProducts(1);
</script>
</body>
</html>
