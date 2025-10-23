<?= $this->extend('templates/header') ?>
<?= $this->section('content') ?>

<h3>Edit Menu</h3>
<form action="<?= base_url('menu/update/'.$menu['id']) ?>" method="post" enctype="multipart/form-data">
    <div class="mb-3">
        <label>Nama Menu</label>
        <input type="text" name="menu" class="form-control" value="<?= esc($menu['menu']) ?>" required>
    </div>
    <div class="mb-3">
        <label>Kategori</label>
        <select name="kategori" class="form-control" required>
            <option value="Makanan" <?= $menu['kategori']=='Makanan'?'selected':'' ?>>Makanan</option>
            <option value="Minuman" <?= $menu['kategori']=='Minuman'?'selected':'' ?>>Minuman</option>
        </select>
    </div>
    <div class="mb-3">
        <label>Harga</label>
        <input type="number" name="harga" class="form-control" value="<?= esc($menu['harga']) ?>" required>
    </div>
    <div class="mb-3">
        <label>Foto (kosongkan jika tidak diganti)</label>
        <input type="file" name="foto" class="form-control">
        <img src="<?= base_url('img/menu/'.$menu['foto']) ?>" width="100" class="mt-2">
    </div>
    <button type="submit" class="btn btn-primary">Update</button>
    <a href="<?= base_url('menu') ?>" class="btn btn-secondary">Batal</a>
</form>

<?= $this->endSection() ?>
