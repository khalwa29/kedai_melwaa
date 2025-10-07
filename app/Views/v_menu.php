<?= $this->extend('templates/header') ?>
<?= $this->section('content') ?>

<section id="menu">
    <h2 class="judul-menu" style="text-align:center;">Menu Kami</h2>
    <p style="text-align:center;">Nikmati berbagai pilihan makanan dan minuman yang kami sajikan dengan sepenuh hati.</p>

    <!-- MINUMAN -->
    <h3 class="judul-kategori" style="margin-top:2rem;">Minuman</h3>
    <div class="menu-grid" style="display:grid; grid-template-columns: repeat(auto-fit, minmax(180px, 1fr)); gap:20px; justify-items:center;">

        <?php foreach ($minuman as $m): ?>
        <div class="menu-card" style="width:180px; text-align:center; border-radius:10px; box-shadow:0 2px 5px rgba(0,0,0,0.1); overflow:hidden; background:#fff;">
            <div style="width:180px; height:150px; overflow:hidden;">
                <img src="<?= base_url('img/menu/'.$m->foto) ?>" 
                     alt="<?= esc($m->menu) ?>" 
                     style="width:100%; height:100%; object-fit:cover;">
            </div>
            <h3 class="menu-card-title" style="margin:10px 0 5px 0; font-size:16px;"><?= esc($m->menu) ?></h3>
            <p class="menu-card-price" style="color:#e74c3c; font-weight:bold;">Rp.<?= number_format($m->harga,0,',','.') ?></p>
        </div>
        <?php endforeach; ?>

    </div>

    <!-- MAKANAN -->
    <h3 class="judul-kategori" style="margin-top:2rem;">Makanan</h3>
    <div class="menu-grid" style="display:grid; grid-template-columns: repeat(auto-fit, minmax(180px, 1fr)); gap:20px; justify-items:center;">

        <?php foreach ($makanan as $m): ?>
        <div class="menu-card" style="width:180px; text-align:center; border-radius:10px; box-shadow:0 2px 5px rgba(0,0,0,0.1); overflow:hidden; background:#fff;">
            <div style="width:180px; height:150px; overflow:hidden;">
                <img src="<?= base_url('img/menu/'.$m->foto) ?>" 
                     alt="<?= esc($m->menu) ?>" 
                     style="width:100%; height:100%; object-fit:cover;">
            </div>
            <h3 class="menu-card-title" style="margin:10px 0 5px 0; font-size:16px;"><?= esc($m->menu) ?></h3>
            <p class="menu-card-price" style="color:#e74c3c; font-weight:bold;">Rp.<?= number_format($m->harga,0,',','.') ?></p>
        </div>
        <?php endforeach; ?>

    </div>

</section>

<?= $this->endSection() ?>
