<div class="col-md-12">
  <div class="card card-outline card-primary">
    <div class="card-header">
      <h3 class="card-title"><?= $judul ?></h3>
    </div>
    <div class="card-body">
      <?php
      session();
      $validation = \Config\Services::validation();
      ?>

      <?= form_open_multipart('Rumah/UpdateData/' . $rumah['id_rumah']) ?>
      <input type="hidden" name="fotoLama" value="<?= $rumah['foto'] ?>">

      <div class="row">
        <div class="col-md-6 mb-3">
          <label>Nama Kepala Keluarga</label>
          <input name="nama_kk" value="<?= old('nama_kk', $rumah['nama_kk']) ?>" class="form-control">
          <p class="text-danger"><?= $validation->getError('nama_kk') ?></p>
        </div>
        <div class="col-md-6 mb-3">
          <label>NIK</label>
          <input name="nik" value="<?= old('nik', $rumah['nik']) ?>" class="form-control">
          <p class="text-danger"><?= $validation->getError('nik') ?></p>
        </div>
      </div>

      <div class="row">
        <div class="col-md-4 mb-3">
          <label>Jenis Atap</label>
          <select name="jenis_atap" class="form-control">
            <option value="">--Pilih Jenis Atap--</option>
            <?php
            $jenis_atap_options = ['Genteng', 'Seng', 'Asbes', 'Polycarbonate', 'Metal Roof'];
            foreach ($jenis_atap_options as $option) {
              $selected = old('jenis_atap', $rumah['jenis_atap']) == $option ? 'selected' : '';
              echo "<option value=\"$option\" $selected>$option</option>";
            }
            ?>
          </select>
          <p class="text-danger"><?= $validation->getError('jenis_atap') ?></p>
        </div>
        <div class="col-md-4 mb-3">
          <label>Jenis Dinding</label>
          <select name="jenis_dinding" class="form-control">
            <option value="">--Pilih Jenis Dinding--</option>
            <?php
            $jenis_dinding_options = ['Tembok', 'Kayu', 'GRC', 'Triplek', 'Bata Ringan'];
            foreach ($jenis_dinding_options as $option) {
              $selected = old('jenis_dinding', $rumah['jenis_dinding']) == $option ? 'selected' : '';
              echo "<option value=\"$option\" $selected>$option</option>";
            }
            ?>
          </select>
          <p class="text-danger"><?= $validation->getError('jenis_dinding') ?></p>
        </div>
        <div class="col-md-4 mb-3">
          <label>Jenis Lantai</label>
          <select name="jenis_lantai" class="form-control">
            <option value="">--Pilih Jenis Lantai--</option>
            <?php
            $jenis_lantai_options = ['Keramik', 'Tanah', 'Semen', 'Granit', 'Marmer', 'Parquet', 'Vinyl'];
            foreach ($jenis_lantai_options as $option) {
              $selected = old('jenis_lantai', $rumah['jenis_lantai']) == $option ? 'selected' : '';
              echo "<option value=\"$option\" $selected>$option</option>";
            }
            ?>
          </select>
          <p class="text-danger"><?= $validation->getError('jenis_lantai') ?></p>
        </div>
      </div>

      <div class="row">
        <div class="form-group col-md-6 mb-3">
          <label>Keterangan</label>
          <select name="id_keterangan" class="form-control">
            <option value="">--Pilih Keterangan--</option>
            <?php foreach ($keterangan as $k) { ?>
              <option value="<?= $k['id_keterangan'] ?>" <?= old('id_keterangan', $rumah['id_keterangan']) == $k['id_keterangan'] ? 'selected' : '' ?>>
                <?= $k['keterangan'] ?>
              </option>
            <?php } ?>
          </select>
          <p class="text-danger"><?= $validation->getError('id_keterangan') ?></p>
        </div>
        <div class="col-md-6 mb-3">
          <label>Mata Pencaharian</label>
          <input name="mata_pencaharian" value="<?= old('mata_pencaharian', $rumah['mata_pencaharian']) ?>" class="form-control">
          <p class="text-danger"><?= $validation->getError('mata_pencaharian') ?></p>
        </div>
        <div class="col-md-6 mb-3">
          <label>Jenis Atap</label>
          <input name="jenis_atap" value="<?= old('jenis_atap', $rumah['jenis_atap']) ?>" class="form-control">
          <p class="text-danger"><?= $validation->getError('jenis_atap') ?></p>
        </div>
        <div class="col-md-6 mb-3">
          <label>Jenis Dinding</label>
          <input name="jenis_dinding" value="<?= old('jenis_dinding', $rumah['jenis_dinding']) ?>" class="form-control">
          <p class="text-danger"><?= $validation->getError('jenis_dinding') ?></p>
        </div>
        <div class="col-md-6 mb-3">
          <label>Jenis Lantai</label>
          <input name="jenis_lantai" value="<?= old('jenis_lantai', $rumah['jenis_lantai']) ?>" class="form-control">
          <p class="text-danger"><?= $validation->getError('jenis_lantai') ?></p>
        </div>
        <div class="col-md-6 mb-3">
          <label>Ventilasi</label>
          <input name="ventilasi" value="<?= old('ventilasi', $rumah['ventilasi']) ?>" class="form-control">
          <p class="text-danger"><?= $validation->getError('ventilasi') ?></p>
        </div>
        <div class="col-md-6 mb-3">
          <label>Pencahayaan</label>
          <input name="pencahayaan" value="<?= old('pencahayaan', $rumah['pencahayaan']) ?>" class="form-control">
          <p class="text-danger"><?= $validation->getError('pencahayaan') ?></p>
        </div>
        <div class="col-md-6 mb-3">
          <label>Air Bersih</label>
          <input name="air_bersih" value="<?= old('air_bersih', $rumah['air_bersih']) ?>" class="form-control">
          <p class="text-danger"><?= $validation->getError('air_bersih') ?></p>
        </div>
        <div class="col-md-6 mb-3">
          <label>Sanitasi</label>
          <input name="sanitasi" value="<?= old('sanitasi', $rumah['sanitasi']) ?>" class="form-control">
          <p class="text-danger"><?= $validation->getError('sanitasi') ?></p>
        </div>
        <div class="col-md-6 mb-3">
          <label>Jenis Bantuan</label>
          <input name="jenis_bantuan" value="<?= old('jenis_bantuan', $rumah['jenis_bantuan']) ?>" class="form-control">
          <p class="text-danger"><?= $validation->getError('jenis_bantuan') ?></p>
        </div>
      </div>

      <div class="form-group mb-3">
        <label>Koordinat Rumah</label>
        <div id="map" style="width: 100%; height: 400px;"></div>
        <input name="coordinat" id="coordinat" value="<?= old('koordinat', $rumah['koordinat']) ?>" class="form-control" readonly>
        <p class="text-danger"><?= $validation->getError('coordinat') ?></p>
      </div>

      <div class="row">
        <div class="col-sm-4 mb-3">
          <label>Provinsi</label>
          <select name="id_provinsi" id="id_provinsi" class="form-control select2">
            <option value="">--Pilih Provinsi--</option>
            <?php foreach ($provinsi as $prov) { ?>
              <option value="<?= $prov['id_provinsi'] ?>" <?= $prov['id_provinsi'] == $rumah['id_provinsi'] ? 'selected' : '' ?>>
                <?= $prov['nama_provinsi'] ?>
              </option>
            <?php } ?>
          </select>
          <p class="text-danger"><?= $validation->getError('id_provinsi') ?></p>
        </div>
        <div class="col-sm-4 mb-3">
          <label>Kabupaten</label>
          <select name="id_kabupaten" id="id_kabupaten" class="form-control select2">
            <option value="<?= $rumah['id_kabupaten'] ?>"><?= $rumah['nama_kabupaten'] ?></option>
          </select>
          <p class="text-danger"><?= $validation->getError('id_kabupaten') ?></p>
        </div>
        <div class="col-sm-4 mb-3">
          <label>Kecamatan</label>
          <select name="id_kecamatan" id="id_kecamatan" class="form-control select2">
            <option value="<?= $rumah['id_kecamatan'] ?>"><?= $rumah['nama_kecamatan'] ?></option>
          </select>
          <p class="text-danger"><?= $validation->getError('id_kecamatan') ?></p>
        </div>
      </div>

      <div class="row">
        <div class="col-md-8 mb-3">
          <label>Alamat</label>
          <input name="alamat" value="<?= old('alamat', $rumah['alamat']) ?>" class="form-control">
          <p class="text-danger"><?= $validation->getError('alamat') ?></p>
        </div>
        <div class="col-md-4 mb-3">
          <label>Wilayah Administrasi</label>
          <select name="id_wilayah" class="form-control">
            <option value="">--Pilih Wilayah Administrasi--</option>
            <?php foreach ($wilayah as $w) { ?>
              <option value="<?= $w['id_wilayah'] ?>" <?= $w['id_wilayah'] == $rumah['id_wilayah'] ? 'selected' : '' ?>>
                <?= $w['nama_wilayah'] ?>
              </option>
            <?php } ?>
          </select>
          <p class="text-danger"><?= $validation->getError('id_wilayah') ?></p>
        </div>
      </div>

      <div class="mb-3">
        <label>Foto Rumah (kosongkan jika tidak ingin diganti)</label>
        <input type="file" name="foto" class="form-control" accept="image/*">
        <p class="text-danger"><?= $validation->getError('foto') ?></p>
        <img src="<?= base_url('foto/' . $rumah['foto']) ?>" alt="foto rumah" width="100" class="mt-2">
      </div>

      <button type="submit" class="btn btn-primary">Update</button>
      <a href="<?= base_url('Rumah') ?>" class="btn btn-success">Kembali</a>
      <?= form_close(); ?>
    </div>
  </div>
</div>

<script>
  $('.select2').select2();
$('#id_provinsi').change(function () {
    $.post("<?= base_url('Rumah/Kabupaten') ?>", { id_provinsi: $(this).val() }, function (data) {
        $('#id_kabupaten').html(data);
    });
});
$('#id_kabupaten').change(function () {
    $.post("<?= base_url('Rumah/Kecamatan') ?>", { id_kabupaten: $(this).val() }, function (data) {
        $('#id_kecamatan').html(data);
    });
});

// Definisi semua layer
var peta1 = L.tileLayer('https://{s}.basemaps.cartocdn.com/light_all/{z}/{x}/{y}{r}.png', {
    attribution: '&copy; OpenStreetMap contributors &copy; CARTO',
    subdomains: 'abcd'
});
var peta2 = L.tileLayer('https://server.arcgisonline.com/ArcGIS/rest/services/World_Imagery/MapServer/tile/{z}/{y}/{x}', {
    attribution: '&copy; Esri &mdash; Source: Esri, i-cubed, USDA, USGS, AEX, GeoEye'
});
var peta3 = L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
    attribution: '&copy; OpenStreetMap contributors'
});
var peta4 = L.tileLayer('https://{s}.basemaps.cartocdn.com/dark_all/{z}/{x}/{y}{r}.png', {
    attribution: '&copy; Carto'
});

// Inisialisasi map
var map = L.map('map', {
    center: [<?= $web['coordinat_wilayah'] ?>],
    zoom: <?= $web['zoom_view'] ?>,
    layers: [peta2]
});

// Control pilihan layer
var baseMaps = {
    'OpenStreetMap': peta1,
    'Satelite': peta2,
    'Streets': peta3,
    'Night': peta4,
    
};
L.control.layers(baseMaps).addTo(map);

// Marker koordinat rumah
var koordinatStr = "<?= old('coordinat', $rumah['koordinat']) ?>";
var marker = null;

// Jika koordinat rumah sudah ada
if (koordinatStr) {
    var koordinat = koordinatStr.split(',');
    marker = L.marker(koordinat, { draggable: true }).addTo(map);
    map.setView(koordinat, 15);
    $('#coordinat').val(koordinat[0] + "," + koordinat[1]);

    marker.on('dragend', function (e) {
        var pos = marker.getLatLng();
        $('#coordinat').val(pos.lat + "," + pos.lng);
    });

// Jika koordinat kosong, set marker di pusat wilayah utama
} else {
    var wilayahCenter = [<?= $web['coordinat_wilayah'] ?>];
    marker = L.marker(wilayahCenter, { draggable: true }).addTo(map);
    map.setView(wilayahCenter, 15);
    $('#coordinat').val(wilayahCenter[0] + "," + wilayahCenter[1]);

    marker.on('dragend', function (e) {
        var pos = marker.getLatLng();
        $('#coordinat').val(pos.lat + "," + pos.lng);
    });
}

// Klik map untuk pindah marker
map.on('click', function (e) {
    marker.setLatLng(e.latlng);
    $('#coordinat').val(e.latlng.lat + "," + e.latlng.lng);
});
</script>