<div class="col-md-12">
  <div class="card card-outline card-primary">
    <div class="card-header">
      <h3 class="card-title"><?= $judul ?></h3>
      <div class="card-tools">
        <a href="Rumah/Input" class="btn btn-flat btn-primary btn-sm">
          <i class="fas fa-plus"></i> Tambah
        </a>
      </div>
    </div>
    <div class="card-body">
      <?php if (session()->getFlashdata('insert')): ?>
        <div class="alert alert-success alert-dismissible">
          <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
          <h5><i class="icon fas fa-check"></i> <?= session()->getFlashdata('insert') ?></h5>
        </div>
      <?php endif; ?>

      <?php if (session()->getFlashdata('update')): ?>
        <div class="alert alert-primary alert-dismissible">
          <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
          <h5><i class="icon fas fa-check"></i> <?= session()->getFlashdata('update') ?></h5>
        </div>
      <?php endif; ?>

      <?php if (session()->getFlashdata('delete')): ?>
        <div class="alert alert-danger alert-dismissible">
          <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
          <h5><i class="icon fas fa-check"></i> <?= session()->getFlashdata('delete') ?></h5>
        </div>
      <?php endif; ?>

      <div class="table-responsive">
      <table id="example2" class="table table-sm table-bordered table-striped">
        <thead>
          <tr class="text-center">
            <th width="50px">No</th>
            <th>Nama Kepala Keluarga</th>
            <th>NIK</th>
            <th>Alamat</th>
            <th>Mata Pencaharian</th>
            <th>Koordinat</th>
            <th>Keterangan</th>
            <th>Jenis Atap</th>
            <th>Jenis Dinding</th>
            <th>Jenis Lantai</th>
            <th>Ventilasi</th>
            <th>Pencahayaan</th>
            <th>Air Bersih</th>
            <th>Sanitasi</th>
            <th>Jenis Bantuan</th>
            <th>Foto Rumah</th>
            <th width="100px">Aksi</th>
          </tr>
        </thead>
        <tbody>
          <?php $no = 1; foreach ($rumah as $value): ?>
            <tr>
              <td><?= $no++ ?></td>
              <td><?= $value['nama_kk'] ?></td>
              <td><?= $value['nik'] ?></td>
              <td><?= $value['alamat'] ?></td>
              <td><?= $value['mata_pencaharian'] ?></td>
              <td><?= $value['koordinat'] ?></td>
              <td class="text-center"><?= $value['keterangan'] ?></td>
              <td class="text-center"><?= $value['jenis_atap'] ?></td>
              <td class="text-center"><?= $value['jenis_dinding'] ?></td>
              <td class="text-center"><?= $value['jenis_lantai'] ?></td>
              <td><?= $value['ventilasi'] ?></td>
              <td><?= $value['pencahayaan'] ?></td>
              <td><?= $value['air_bersih'] ?></td>
              <td><?= $value['sanitasi'] ?></td>
              <td class="text-center"><?= $value['jenis_bantuan'] ?></td>
              <td class="text-center">
                <img src="<?= base_url('foto/' . $value['foto']) ?>" width="150" height="100" alt="Foto Rumah">
              </td>
              <td class="text-center">
                <a href="<?= base_url('Rumah/Detail/' . $value['id_rumah']) ?>" class="btn btn-xs btn-success btn-flat">
                  <i class="fas fa-eye"></i>
                </a>
                <a href="<?= base_url('Rumah/Edit/' . $value['id_rumah']) ?>" class="btn btn-xs btn-warning btn-flat">
                  <i class="fas fa-pencil-alt"></i>
                </a>
                <a href="<?= base_url('Rumah/Delete/' . $value['id_rumah']) ?>" onclick="return confirm('Yakin Hapus Data...?')" class="btn btn-xs btn-danger btn-flat">
                  <i class="fas fa-trash"></i>
                </a>
              </td>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </div>
  </div>
</div>

<style>
  table td, table th {
    vertical-align: middle !important;
    text-align: center;
    word-wrap: break-word;
    max-width: 150px;
  }
  img {
    max-width: 100px;
    height: auto;
  }
</style>
<script>
  $(function () {
    $("#example2").DataTable({
      paging: true,
      lengthChange: true,
      searching: true,
      ordering: true,
      info: true,
      autoWidth: false,
      responsive: true,
    });
  });
</script>