<?php
session_start();
if (!isset($_SESSION["email"])) {
    header("Location: login.php");
    exit;
}
$username = $_SESSION["username"] ?? 'Kasir';

// --- KONEKSI DATABASE ---
$koneksi = new mysqli("localhost", "root", "", "db_kasir");
if ($koneksi->connect_error) {
    http_response_code(500);
    echo json_encode(["error" => "Gagal terhubung ke database"]);
    exit;
}

// --- API MODE (untuk AJAX) ---
if (isset($_GET['action'])) {
    header('Content-Type: application/json; charset=UTF-8');
    $action = $_GET['action'];

    // === LIST PRODUK ===
    if ($action === 'list_products') {
        $page = max(1, (int)($_GET['page'] ?? 1));
        $perPage = 10;
        $offset = ($page - 1) * $perPage;
        $search = trim($_GET['search'] ?? '');

        if ($search !== '') {
            $like = "%{$search}%";
            $stmt = $koneksi->prepare("SELECT COUNT(*) FROM tb_produk WHERE nama_produk LIKE ? OR kode_produk LIKE ?");
            $stmt->bind_param('ss', $like, $like);
            $stmt->execute();
            $stmt->bind_result($totalRows);
            $stmt->fetch();
            $stmt->close();

            $stmt = $koneksi->prepare("
                SELECT id_produk, kode_produk, nama_produk, kategori, harga_jual, stok, satuan
                FROM tb_produk
                WHERE nama_produk LIKE ? OR kode_produk LIKE ?
                ORDER BY id_produk DESC LIMIT ? OFFSET ?
            ");
            $stmt->bind_param('ssii', $like, $like, $perPage, $offset);
        } else {
            $res = $koneksi->query("SELECT COUNT(*) as cnt FROM tb_produk");
            $row = $res->fetch_assoc();
            $totalRows = (int)$row['cnt'];

            $stmt = $koneksi->prepare("
                SELECT id_produk, kode_produk, nama_produk, kategori, harga_jual, stok, satuan
                FROM tb_produk ORDER BY id_produk DESC LIMIT ? OFFSET ?
            ");
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

    // === PROSES CHECKOUT ===
    if ($action === 'checkout' && $_SERVER['REQUEST_METHOD'] === 'POST') {
        $input = json_decode(file_get_contents('php://input'), true);
        if (!$input) {
            echo json_encode(["error" => "Data input tidak valid"]);
            exit;
        }

        $cart = $input['cart'] ?? [];
        $total = floatval($input['total'] ?? 0);
        $bayar = floatval($input['bayar'] ?? 0);
        $kembalian = floatval($input['kembalian'] ?? 0);
        $metode = $input['metode'] ?? 'Tunai';
        $ewallet = $input['ewallet'] ?? '-';

        if (empty($cart) || $total <= 0) {
            echo json_encode(["error" => "Keranjang kosong atau total tidak valid"]);
            exit;
        }

        $nomorFaktur = 'INV' . date('YmdHis') . rand(100, 999);

        $koneksi->begin_transaction();
        try {
            // Simpan ke tb_jual
            $stmt = $koneksi->prepare("
                INSERT INTO tb_jual 
                (nomor_faktur, tanggal_beli, total_belanja, total_bayar, kembalian, metode_bayar, ewallet)
                VALUES (?, NOW(), ?, ?, ?, ?, ?)
            ");
            $stmt->bind_param('sdddss', $nomorFaktur, $total, $bayar, $kembalian, $metode, $ewallet);
            $stmt->execute();
            $stmt->close();

            // Simpan ke rinci_jual
            $stmtDetail = $koneksi->prepare("
                INSERT INTO rinci_jual 
                (nomor_faktur, kode_produk, nama_produk, harga_modal, harga_jual, qty, total_harga, untung)
                VALUES (?, ?, ?, ?, ?, ?, ?, ?)
            ");

            foreach ($cart as $item) {
                $kode_produk = $item['id_produk'];
                $nama_produk = $item['nama_produk'];
                $harga_modal = 0;
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
            echo json_encode(["success" => true, "nomor_faktur" => $nomorFaktur]);
            exit;
        } catch (Exception $e) {
            $koneksi->rollback();
            echo json_encode(["error" => "Gagal menyimpan transaksi: " . $e->getMessage()]);
            exit;
        }
    }

    echo json_encode(["error" => "Aksi tidak dikenali"]);
    exit;
}
?>

<!-- =============== HALAMAN KASIR =============== -->
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width,initial-scale=1">
<title>Kasir - Kedai Melwaa</title>
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<style>
body{font-family:'Poppins',sans-serif;background:linear-gradient(135deg,#fff1f8,#e2f7ff);margin:0;color:#333}
header{background:linear-gradient(90deg,#ff8cb8,#6ee3ff);color:#fff;padding:18px 24px;display:flex;justify-content:space-between;align-items:center}
header a{background:#fff;color:#ff69b4;padding:8px 12px;border-radius:10px;text-decoration:none;font-weight:600}
.wrap{max-width:1150px;margin:28px auto;padding:20px;background:#fff;border-radius:16px;box-shadow:0 8px 25px rgba(0,0,0,0.06)}
h2{color:#ff69b4;margin:0 0 12px}
.card{background:#fff;padding:12px;border-radius:12px;box-shadow:0 4px 14px rgba(255,182,193,0.15)}
table{width:100%;border-collapse:collapse}
th,td{padding:10px;border-bottom:1px solid #f6dfe9;text-align:left}
thead th{background:linear-gradient(90deg,#ffb6c1,#a3f3ff);color:#fff}
.add-btn{background:#ff69b4;color:#fff;padding:6px 10px;border-radius:8px;border:none;cursor:pointer}
.pagination{display:flex;gap:6px;margin-top:10px}
.pay-btn{background:linear-gradient(90deg,#ff69b4,#77e3f0);color:#fff;padding:10px 14px;border:none;border-radius:10px;cursor:pointer}
</style>
</head>
<body>
<header>
  <div>
    <h1 style="margin:0">Kasir Melwaa</h1>
    <div style="font-size:14px;margin-top:6px">Hai, <?= htmlspecialchars($username) ?></div>
  </div>
  <a href="dashboard_admin.php">🏠 Dashboard</a>
</header>

<div class="wrap">
  <h2>Daftar Produk</h2>
  <div class="card">
    <table id="productTable">
      <thead><tr><th>No</th><th>Kode</th><th>Nama</th><th>Harga</th><th>Stok</th><th>Satuan</th><th>Aksi</th></tr></thead>
      <tbody id="productBody"></tbody>
    </table>
  </div>

  <h2 style="margin-top:20px;">Keranjang Belanja</h2>
  <div class="card">
    <table id="cartTable">
      <thead><tr><th>No</th><th>Nama Produk</th><th>Harga</th><th>Qty</th><th>Total</th><th>Aksi</th></tr></thead>
      <tbody id="cartBody"></tbody>
    </table>

    <div style="margin-top:10px;display:flex;flex-wrap:wrap;gap:10px;align-items:center;">
      <label>Metode Bayar:
        <select id="metodeBayar">
          <option value="Tunai">Tunai</option>
          <option value="E-Wallet">E-Wallet</option>
        </select>
      </label>
      <label id="ewalletLabel" style="display:none;">
        Nama E-Wallet:
        <select id="ewalletName">
          <option value="">-- Pilih --</option>
          <option value="Dana">Dana</option>
          <option value="OVO">OVO</option>
          <option value="GoPay">GoPay</option>
          <option value="ShopeePay">ShopeePay</option>
        </select>
      </label>
      <label>Total Bayar: Rp <input id="inputBayar" type="number" min="0" step="1" value="0"></label>
      <label>Kembalian: Rp <input id="inputKembali" type="number" readonly></label>
      <button id="btnBayar" class="pay-btn">Bayar</button>
    </div>
  </div>
</div>

<script>
const apiUrl = 'kasir.php';
let cart = {};

function formatRupiah(num){return (Number(num)||0).toLocaleString('id-ID');}

async function fetchProducts(page=1){
  const res = await fetch(`${apiUrl}?action=list_products&page=${page}`);
  const data = await res.json();
  const tbody = document.getElementById('productBody');
  tbody.innerHTML = '';
  let no = 1;
  for(const p of data.products){
    const tr = document.createElement('tr');
    tr.innerHTML = `
      <td>${no++}</td><td>${p.kode_produk}</td><td>${p.nama_produk}</td>
      <td>Rp ${formatRupiah(p.harga_jual)}</td><td>${p.stok}</td><td>${p.satuan}</td>
      <td><button class='add-btn' onclick='addToCart(${p.id_produk},"${p.nama_produk}",${p.harga_jual})'>Tambah</button></td>
    `;
    tbody.appendChild(tr);
  }
}

function addToCart(id,nama,harga){
  if(!cart[id]) cart[id]={id_produk:id,nama_produk:nama,harga_jual:harga,qty:1};
  else cart[id].qty++;
  renderCart();
}

function renderCart(){
  const tbody=document.getElementById('cartBody');tbody.innerHTML='';
  let total=0,i=1;
  for(const id in cart){
    const item=cart[id],sub=item.harga_jual*item.qty;
    total+=sub;
    tbody.innerHTML+=`<tr><td>${i++}</td><td>${item.nama_produk}</td><td>Rp ${formatRupiah(item.harga_jual)}</td>
    <td><input type='number' min='1' value='${item.qty}' onchange='updateQty(${id},this.value)'></td>
    <td>Rp ${formatRupiah(sub)}</td><td><button onclick='removeItem(${id})'>❌</button></td></tr>`;
  }
  document.getElementById('inputBayar').dataset.total=total;
  recalcKembali();
}

function updateQty(id,val){if(val<=0)delete cart[id];else cart[id].qty=parseInt(val);renderCart();}
function removeItem(id){delete cart[id];renderCart();}
function recalcKembali(){
  const total=Number(document.getElementById('inputBayar').dataset.total||0);
  const bayar=Number(document.getElementById('inputBayar').value||0);
  document.getElementById('inputKembali').value=Math.max(0,bayar-total);
}

document.getElementById('inputBayar').addEventListener('input',recalcKembali);
document.getElementById('metodeBayar').addEventListener('change',function(){
  document.getElementById('ewalletLabel').style.display=(this.value==='E-Wallet')?'inline-block':'none';
});

document.getElementById('btnBayar').addEventListener('click', async()=>{
  const bayar=Number(document.getElementById('inputBayar').value||0);
  const total=Number(document.getElementById('inputBayar').dataset.total||0);
  const kembalian=Math.max(0,bayar-total);
  const metode=document.getElementById('metodeBayar').value;
  const ewallet=document.getElementById('ewalletName').value;

  if(Object.keys(cart).length===0) return Swal.fire("Keranjang Kosong","Tambahkan produk dahulu","warning");
  if(bayar < total) return Swal.fire("Pembayaran Kurang","Jumlah bayar belum cukup","error");

  const payload={cart:Object.values(cart),total,bayar,kembalian,metode,ewallet};

  try{
    const res=await fetch(`${apiUrl}?action=checkout`,{
      method:'POST',
      headers:{'Content-Type':'application/json'},
      body:JSON.stringify(payload)
    });
    const data=await res.json();

    if(data.success){
      await Swal.fire({
        title:"Transaksi Berhasil!",
        html:`Nomor Faktur: <b>${data.nomor_faktur}</b><br>Metode: ${metode}<br>Kembalian: Rp ${formatRupiah(kembalian)}`,
        icon:"success"
      });
      window.location.href=`struk.php?nomor_faktur=${data.nomor_faktur}`;
    }else{
      Swal.fire("Gagal",data.error||"Gagal menyimpan transaksi","error");
    }
  }catch(err){
    Swal.fire("Kesalahan","Tidak dapat terhubung ke server","error");
    console.error(err);
  }
});

fetchProducts();
</script>
</body>
</html>
