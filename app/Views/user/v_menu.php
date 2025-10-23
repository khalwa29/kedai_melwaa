<?= $this->extend('templates/header') ?>
<?= $this->section('content') ?>

<h3>Kelola Menu</h3>
<a href="<?= base_url('menu/create') ?>" class="btn btn-success mb-3">Tambah Menu</a>

<table class="table table-bordered table-striped">
    <thead>
        <tr>
            <th>No</th>
            <th>Menu</th>
            <th>Kategori</th>
            <th>Harga</th>
            <th>Foto</th>
            <th>Aksi</th>
        </tr>
    </thead>
    <tbody>
        <?php $no=1; foreach($menus as $m): ?>
        <tr>
            <td><?= $no++ ?></td>
            <td><?= esc($m['menu']) ?></td>
            <td><?= esc($m['kategori']) ?></td>
            <td>Rp <?= number_format($m['harga'],0,',','.') ?></td>
            <td><img src="<?= base_url('img/menu/'.$m['foto']) ?>" width="80"></td>
            <td>
                <a href="<?= base_url('menu/edit/'.$m['id']) ?>" class="btn btn-warning btn-sm">Edit</a>
                <a href="<?= base_url('menu/delete/'.$m['id']) ?>" class="btn btn-danger btn-sm" onclick="return confirm('Yakin hapus?')">Hapus</a>
            </td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<?= $this->endSection() ?>
