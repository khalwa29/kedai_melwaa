<div class="col-md-12">
  <div class="card card-outline card-primary">
    <div class="card-header">
      <h3 class="card-title"><?= $judul ?></h3>

        <div class="card-tools">
          <a href="<?= base_url('Wilayah/Input') ?>" class="btn btn-flat btn-primary btn-sm">
            <i class="fas fa-plus"></i> Tambah
          </a>
        </div>
        <!-- /.card-tools -->
      </div>
      <!-- /.card-header -->
      <div class="card-body">
      <?php 
      //notif insert data
      if (session()->getFlashdata('insert')){
        echo '<div class="alert alert-success alert-dismissible">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            <h5><i class="icon fas fa-check"></i>';
        echo session()->getFlashdata('insert');
        echo '</h5></div>';
      }

      //notif update data
      if (session()->getFlashdata('update')){
        echo '<div class="alert alert-primary alert-dismissible">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            <h5><i class="icon fas fa-check"></i>';
        echo session()->getFlashdata('update');
        echo '</h5></div>';
      }

      //notif delete data
      if (session()->getFlashdata('delete')){
        echo '<div class="alert alert-danger alert-dismissible">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            <h5><i class="icon fas fa-check"></i>';
        echo session()->getFlashdata('delete');
        echo '</h5></div>';
      }

      ?>         
        <table id="example2" class="table table-bordered table-striped">
            <thead>
                <tr class="text-center">
                    <th width="50px">No</th>
                    <th>Nama Wilayah</th>
                    <th>Warna</th>
                    <th width="100px">Aksi</th>
                </tr>
            </thead>
            <tbody>
               <?php $no=1;
                foreach ($wilayah as $key => $value) { ?>
                  <tr>
                    <td><?= $no++ ?></td>
                    <td><?= $value['nama_wilayah'] ?></td>
                    <td style="background-color: <?= $value['warna'] ?> ;"></td>
                    <td class="text-center">
                      <a href="<?= base_url('Wilayah/Edit/'.$value['id_wilayah'])?>" class="btn btn-sm btn-warning btn-flat"><i class="fas fa-pencil-alt"></i></a>
                      <a href="<?= base_url('Wilayah/Delete/'.$value['id_wilayah'])?>" onclick="return confirm('Yakin hapus data..?')" class="btn btn-sm btn-danger btn-flat"><i class="fas fa-trash"></i></a>
                    </td>
                  </tr>  
               <?php } ?>
            </tbody>
        </table>

    </div>
    <!-- /.card-body -->
  </div>
  <!-- /.card -->
</div>

<div class="col-md-12">
  <div id="map" style="width: 100%; height: 500px;"></div>
</div>

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


    var label = L.tileLayer('https://server.arcgisonline.com/ArcGIS/rest/services/Reference/World_Transportation/MapServer/tile/{z}/{y}/{x}', {
	attribution: 'Labels &copy; Esri',
	transparent: true
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
  
  <?php foreach ($wilayah as $key => $value) { ?>
    L.geoJSON(<?= $value['geojson']?>, {
      fillColor: '<?= $value['warna']?>',
      fillOpacity: 0.6,
    })
    .bindPopup("<b><?= $value['nama_wilayah']?></b>")
    .addTo(map);
  <?php } ?>
</script>


<script>
  $(function () {
    $("#example1").DataTable({
      "responsive": true, 
      "lengthChange": false, 
      "autoWidth": false,
      "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
    }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
    $('#example2').DataTable({
      "paging": true,
      "lengthChange": true,
      "searching": true,
      "ordering": true,
      "info": true,
      "autoWidth": false,
      "responsive": true,
    });
  });
</script>