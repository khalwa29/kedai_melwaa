<?= $this->extend('templates/header') ?>
<?= $this->section('content') ?>

<section id="order" style="padding:2rem; max-width:600px; margin:auto;">
    <h2>Form Pesanan</h2>
    <form action="<?= site_url('order/store') ?>" method="post" style="display:flex; flex-direction:column; gap:15px;">
        <label>Nama</label>
        <input type="text" name="nama" required placeholder="Masukkan nama">

        <label>Menu</label>
        <select name="menu" required>
            <?php foreach($menuList as $m): ?>
                <option value="<?= esc($m['menu']) ?>" <?= ($m['menu'] == $selected_menu) ? 'selected' : '' ?>>
                    <?= esc($m['menu']) ?>
                </option>
            <?php endforeach; ?>
        </select>

        <label>Jumlah</label>
        <input type="number" name="jumlah" required min="1" value="1">

        <label>Catatan</label>
        <textarea name="catatan" placeholder="Misal: Kurangi gula, tambah es..."></textarea>

        <button type="submit" style="padding:15px 30px; font-size:20px; background:#e74c3c; color:white; border:none; border-radius:10px;">
            Submit Pesanan
        </button>
    </form>
</section>

<?= $this->endSection() ?>
