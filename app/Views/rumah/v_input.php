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

            <?php if (session()->getFlashdata('errors')) { ?>
                <div class="alert alert-danger alert-dismissible">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                    <h5><i class="icon fas fa-exclamation-triangle"></i> Error!</h5>
                    <ul>
                        <?php foreach (session()->getFlashdata('errors') as $error) { ?>
                            <li><?= esc($error) ?></li>
                        <?php } ?>
                    </ul>
                </div>
            <?php } ?>

            <?= form_open_multipart('Rumah/InsertData') ?>

            <div class="row">
                <div class="col-md-4 mb-3">
                    <label>Nama Kepala Keluarga</label>
                    <input name="nama_kk" value="<?= old('nama_kk') ?>" placeholder="Nama Kepala Keluarga" class="form-control">
                    <p class="text-danger"><?= $validation->hasError('nama_kk') ? $validation->getError('nama_kk') : '' ?></p>
                </div>
                <div class="col-md-4 mb-3">
                    <label>NIK</label>
                    <input name="nik" value="<?= old('nik') ?>" placeholder="NIK" class="form-control">
                    <p class="text-danger"><?= $validation->hasError('nik') ? $validation->getError('nik') : '' ?></p>
                </div>
                <div class="col-md-4 mb-3">
                    <label>Mata Pencaharian</label>
                    <input name="mata pencaharian" value="<?= old('mata pencaharian') ?>" placeholder="Mata Pencaharian" class="form-control">
                    <p class="text-danger"><?= $validation->hasError('mata pencaharian') ? $validation->getError('mata pencaharian') : '' ?></p>
                </div>
            </div>

            <div class="row">
                <div class="col-md-4 mb-3">
                    <label>Jenis Atap</label>
                    <select name="jenis_atap" class="form-control">
                        <option value="">--Pilih Jenis Atap--</option>
                        <option value="Genteng" <?= old('jenis_atap') == 'Genteng' ? 'selected' : '' ?>>Genteng</option>
                        <option value="Seng" <?= old('jenis_atap') == 'Seng' ? 'selected' : '' ?>>Seng</option>
                        <option value="Asbes" <?= old('jenis_atap') == 'Asbes' ? 'selected' : '' ?>>Asbes</option>
                        <option value="Polycarbonate" <?= old('jenis_atap') == 'Polycarbonate' ? 'selected' : '' ?>>Polycarbonate</option>
                        <option value="Metal Roof" <?= old('jenis_atap') == 'Metal Roof' ? 'selected' : '' ?>>Metal Roof</option>
                    </select>
                    <p class="text-danger"><?= $validation->hasError('jenis_atap') ? $validation->getError('jenis_atap') : '' ?></p>
                </div>
                <div class="col-md-4 mb-3">
                    <label>Jenis Dinding</label>
                    <select name="jenis_dinding" class="form-control">
                        <option value="">--Pilih Jenis Dinding--</option>
                        <option value="Tembok" <?= old('jenis_dinding') == 'Tembok' ? 'selected' : '' ?>>Tembok</option>
                        <option value="Kayu" <?= old('jenis_dinding') == 'Kayu' ? 'selected' : '' ?>>Kayu</option>
                        <option value="GRC" <?= old('jenis_dinding') == 'GRC' ? 'selected' : '' ?>>GRC</option>
                        <option value="Triplek" <?= old('jenis_dinding') == 'Triplek' ? 'selected' : '' ?>>Triplek</option>
                        <option value="Bata Ringan" <?= old('jenis_dinding') == 'Bata Ringan' ? 'selected' : '' ?>>Bata Ringan</option>
                    </select>
                    <p class="text-danger"><?= $validation->hasError('jenis_dinding') ? $validation->getError('jenis_dinding') : '' ?></p>
                </div>
                <div class="col-md-4 mb-3">
                    <label>Jenis Lantai</label>
                    <select name="jenis_lantai" class="form-control">
                        <option value="">--Pilih Jenis Lantai--</option>
                        <option value="Keramik" <?= old('jenis_lantai') == 'Keramik' ? 'selected' : '' ?>>Keramik</option>
                        <option value="Tanah" <?= old('jenis_lantai') == 'Tanah' ? 'selected' : '' ?>>Tanah</option>
                        <option value="Semen" <?= old('jenis_lantai') == 'Semen' ? 'selected' : '' ?>>Semen</option>
                        <option value="Granit" <?= old('jenis_lantai') == 'Granit' ? 'selected' : '' ?>>Granit</option>
                        <option value="Marmer" <?= old('jenis_lantai') == 'Marmer' ? 'selected' : '' ?>>Marmer</option>
                        <option value="Parquet" <?= old('jenis_lantai') == 'Parquet' ? 'selected' : '' ?>>Parquet</option>
                        <option value="Vinyl" <?= old('jenis_lantai') == 'Vinyl' ? 'selected' : '' ?>>Vinyl</option>
                    </select>
                    <p class="text-danger"><?= $validation->hasError('jenis_lantai') ? $validation->getError('jenis_lantai') : '' ?></p>
                </div>
            </div>

            <div class="row">
               <div class="form-group col-md-6 mb-3">
                  <label>Keterangan</label>
                  <select name="id_keterangan" class="form-control">
                      <option value="">--Pilih Keterangan--</option>
                      
                    <?php foreach ($keterangan as $key => $value) {?>
                      <option value="<?= $value['id_keterangan'] ?>"><?= $value['keterangan'] ?></option>
                    <?php } ?>

                  </select>
                  <p class="text-danger"><?= $validation->hasError('id_keterangan') ? $validation->getError('id_keterangan') : '' ?></p>
               </div>

                  <div class="col-md-6 mb-3">
                    <label>Ventilasi</label>
                    <input name="ventilasi" value="<?= old('ventilasi') ?>" placeholder="Ventilasi" class="form-control">
                    <p class="text-danger"><?= $validation->hasError('ventilasi') ? $validation->getError('ventilasi') : '' ?></p>
                  </div>
                  <div class="col-md-6 mb-3">
                    <label>Pencahayaan</label>
                    <input name="pencahayaan" value="<?= old('pencahayaan') ?>" placeholder="Pencahayaan" class="form-control">
                    <p class="text-danger"><?= $validation->hasError('pencahayaan') ? $validation->getError('pencahayaan') : '' ?></p>
                  </div>
                  <div class="col-md-6 mb-3">
                    <label>Air Bersih</label>
                    <input name="air_bersih" value="<?= old('air_bersih') ?>" placeholder="Air Bersih" class="form-control">
                    <p class="text-danger"><?= $validation->hasError('air_bersih') ? $validation->getError('air_bersih') : '' ?></p>
                  </div>
                  <div class="col-md-6 mb-3">
                    <label>Sanitasi</label>
                    <input name="sanitasi" value="<?= old('sanitasi') ?>" placeholder="Sanitasi" class="form-control">
                    <p class="text-danger"><?= $validation->hasError('sanitasi') ? $validation->getError('sanitasi') : '' ?></p>
                  </div>
                <div class="col-md-6 mb-3">
                    <label>Jenis Bantuan</label>
                    <input name="jenis_bantuan" value="<?= old('jenis_bantuan') ?>" placeholder="Jenis Bantuan" class="form-control">
                    <p class="text-danger"><?= $validation->hasError('jenis_bantuan') ? $validation->getError('jenis_bantuan') : '' ?></p>
                </div>
            </div>

            <div class="form-group mb-3">
                <label>Coordinat Rumah</label>
                <div id="map" style="width: 100%; height: 400px;"></div>
                <input name="coordinat" id="Coordinat" value="<?= old('coordinat') ?>" placeholder="Coordinat Rumah" class="form-control" readonly>
                <p class="text-danger"><?= $validation->hasError('coordinat') ? $validation->getError('coordinat') : '' ?></p>
            </div>

            <div class="row">
                <div class="col-sm-4">
                    <div class="form-group">
                        <label>Provinsi</label>
                        <select name="id_provinsi" id="id_provinsi" class="form-control select2" style="width: 100%;">
                            <option value=""> --Pilih Provinsi-- </option>
                            <?php foreach ($provinsi as $key => $value) { ?>
                                <option value="<?= $value['id_provinsi'] ?>" <?= old('id_provinsi') == $value['id_provinsi'] ? 'selected' : '' ?>>
                                    <?= $value['nama_provinsi'] ?>
                                </option>
                            <?php } ?>
                        </select>
                        <p class="text-danger"><?= $validation->hasError('id_provinsi') ? $validation->getError('id_provinsi') : '' ?></p>
                    </div>
                </div>

                <div class="col-sm-4">
                <div class="form-group">
                    <label>Kabupaten</label>
                    <select name="id_kabupaten" id="id_kabupaten" class="form-control select2">
                      <option value=""> --Pilih Kabupaten-- </option>
                    </select>
                    <p class="text-danger"><?= $validation->hasError('id_kabupaten') ? $validation->getError('id_kabupaten') : '' ?></p>
                </div>
                </div>

            <div class="col-sm-4">
                <div class="form-group">
                    <label>Kacamatan</label>
                    <select name="id_kecamatan" id="id_kecamatan" class="form-control select2">
                      <option value=""> --Pilih Kecamatan-- </option>
                    </select>
                    <p class="text-danger"><?= $validation->hasError('id_kecamatan') ? $validation->getError('id_kecamatan') : '' ?></p>
                </div>
            </div>

            </div>

            <div class="row">
                <div class="col-md-8 mb-3">
                    <label>Alamat</label>
                    <input name="alamat" value="<?= old('alamat') ?>" placeholder="Alamat" class="form-control">
                    <p class="text-danger"><?= $validation->hasError('alamat') ? $validation->getError('alamat') : '' ?></p>
                </div>
                <div class="col-md-4 mb-3">
                    <label>Wilayah Administrasi</label>
                    <select name="id_wilayah" class="form-control">
                        <option value="">--Pilih Wilayah Administrasi--</option>
                        <?php foreach ($wilayah as $key => $value) { ?>
                            <option value="<?= $value['id_wilayah'] ?>" <?= old('id_wilayah') == $value['id_wilayah'] ? 'selected' : '' ?>>
                                <?= $value['nama_wilayah'] ?>
                            </option>
                        <?php } ?>
                    </select>
                    <p class="text-danger"><?= $validation->hasError('id_wilayah') ? $validation->getError('id_wilayah') : '' ?></p>
                </div>
            </div>

            <div class="mb-3">
                <label>Foto Rumah</label>
                <input type="file" name="foto" class="form-control" accept="image/*" required>
                <p class="text-danger"><?= $validation->hasError('foto') ? $validation->getError('foto') : '' ?></p>
            </div>

            <button class="btn btn-primary btn-flat" type="submit">Simpan</button>
            <a href="<?= base_url('Rumah') ?>" class="btn btn-success btn-flat">Kembali</a>

            <?= form_close(); ?>
        </div>
    </div>
</div>

<script>
  $(document).ready(function () {
    //Initialize Select2 Elements
    $('.select2').select2();

    $('#id_provinsi').change(function () {
      var id_provinsi= $('#id_provinsi').val();
      $.ajax({
        type: "POST",
        url: "<?= base_url('Rumah/Kabupaten') ?>",
        data: {
          id_provinsi: id_provinsi,
        },
        success: function(response) {
          $('#id_kabupaten').html(response);
        }
      });
    });

    $('#id_kabupaten').change(function () {
      var id_kabupaten= $('#id_kabupaten').val();
      $.ajax({
        type: "POST",
        url: "<?= base_url('Rumah/Kecamatan') ?>",
        data: {
          id_kabupaten: id_kabupaten,
        },
        success: function(response) {
          $('#id_kecamatan').html(response);
        }
      });
    });
  });
</script>
<script>
     var peta1 = L.tileLayer('https://{s}.basemaps.cartocdn.com/light_all/{z}/{x}/{y}{r}.png', {
	attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors &copy; <a href="https://carto.com/">CARTO</a>',
	subdomains: 'abcd',
});
    var peta2 = L.tileLayer('https://server.arcgisonline.com/ArcGIS/rest/services/World_Imagery/MapServer/tile/{z}/{y}/{x}', {
        attribution: '&copy; Esri &mdash; Source: Esri, i-cubed, USDA, USGS, AEX, GeoEye'
    });


	var peta3 = L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
		attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
	});

	var peta4 = L.tileLayer('https://{s}.basemaps.cartocdn.com/dark_all/{z}/{x}/{y}{r}.png', {
        attribution: '&copy; <a href="https://carto.com/">Carto</a>',
    });


	var map = L.map('map', {
		center: [<?= $web['coordinat_wilayah']?>],
		zoom: <?= $web['zoom_view']?>,
		layers: [peta3]
	});

	var baseMaps = {
		'OpenStreetMap': peta1,
		'Satelite': peta2,
		'Streets': peta3,
		'Nigth' : peta4,
	};

	var layerControl = L.control.layers(baseMaps).addTo(map);

  var coordinatInput = document.querySelector("input[name='coordinat']");

  var curLocation = [<?= $web['coordinat_wilayah'] ?>];
  map.attributionControl.setPrefix(false);
  var marker = new L.marker(curLocation, {
    draggable : 'true',
  });

  //mengambil coordinat saat marker di geser
  marker.on('dragend', function(e) {
    var position = marker.getLatLng();
    marker.setLatLng(position, {
      curLocation
    }).bindPopup(position).update();
    $("#Coordinat").val(position.lat + "," + position.lng);
  });

  //mengambil coordinat saat map onclick
  map.on("click", function(e) {
    var lat = e.latlng.lat;
    var lng = e.latlng.lng;
    if (!marker) {
      marker = L.marker(e.latlng).addTo(map);
    }else {
      marker.setLatLng(e.latlng);
    }
    coordinatInput.value = lat + ',' + lng;
  });

  map.addLayer(marker);
</script>