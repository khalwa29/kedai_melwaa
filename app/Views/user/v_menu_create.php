<?= $this->extend('templates/header') ?>
<?= $this->section('content') ?>

<h3>Tambah Menu</h3>
<form action="<?= base_url('menu/store') ?>" method="post" enctype="multipart/form-data">
    <div class="mb-3">
        <label>Nama Menu</label>
        <input type="text" name="menu" class="form-control" required>
    </div>
    <div class="mb-3">
        <label>Kategori</label>
        <select name="kategori" class="form-control" required>
            <option value="Makanan">Makanan</option>
            <option value="Minuman">Minuman</option>
        </select>
    </div>
    <div class="mb-3">
        <label>Harga</label>
        <input type="number" name="harga" class="form-control" required>
    </div>
    <div class="mb-3">
        <label>Foto</label>
        <input type="file" name="foto" class="form-control" required>
    </div>
    <button type="submit" class="btn btn-primary">Simpan</button>
    <a href="<?= base_url('menu') ?>" class="btn btn-secondary">Batal</a>
</form>

<?= $this->endSection() ?>
