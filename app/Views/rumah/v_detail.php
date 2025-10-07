<div class="col-md-12">
    <div class="card card-outline card-primary">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h3 class="card-title m-0"><?= $judul ?></h3>
            
        </div>

        <div class="card-body">
            <div>
                <button class="btn btn-sm btn-outline-primary" onclick="showMap()">Tampilkan Peta</button>
                <button class="btn btn-sm btn-outline-secondary" onclick="showImage()">Tampilkan Foto</button>
            </div>
            
            <div class="mb-4">
                <div id="map-container" style="display: block;">
                    <div id="map" style="width: 100%; height: 500px; border-radius: 8px;"></div>
                </div>
            </div>

            <div class="mb-4">
                <div id="image-container" style="display: none;">
                    <img src="<?= base_url('foto/' . $rumah['foto']) ?>" class="img-fluid rounded" style="width: 100%; height: 500px; object-fit: cover;">
                </div>
            </div>

            <table class="table table-bordered">
                    <tr>
                        <th>Nama Pemilik Rumah</th>
                        <th width="30px">:</th>
                        <td><?= $rumah['nama_kk'] ?></td>
                    </tr>
                    <tr>
                        <th>NIK</th>
                        <th>:</th>
                        <td><?= $rumah['nik'] ?></td>
                    </tr>
                    <tr>
                        <th>Keterangan</th>
                        <th>:</th>
                        <td><?= $rumah['keterangan'] ?></td>
                    </tr>
                    <tr>
                        <th>Mata Pencaharian</th>
                        <th>:</th>
                        <td><?= $rumah['mata_pencaharian'] ?></td>
                    </tr>
                    <tr>
                        <th>Jenis Atap</th>
                        <th>:</th>
                        <td><?= $rumah['jenis_atap'] ?></td>
                    </tr>
                    <tr>
                        <th>Jenis Dinding</th>
                        <th>:</th>
                        <td><?= $rumah['jenis_dinding'] ?></td>
                    </tr>
                    <tr>
                        <th>Jenis Lantai</th>
                        <th>:</th>
                        <td><?= $rumah['jenis_lantai'] ?></td>
                    </tr>
                    <tr>
                        <th>Ventilasi</th>
                        <th>:</th>
                        <td><?= $rumah['ventilasi'] ?></td>
                    </tr>
                    <tr>
                        <th>Pencahayaan</th>
                        <th>:</th>
                        <td><?= $rumah['pencahayaan'] ?></td>
                    </tr>
                    <tr>
                        <th>Air Bersih</th>
                        <th>:</th>
                        <td><?= $rumah['air_bersih'] ?></td>
                    </tr>
                    <tr>
                        <th>Sanitasi</th>
                        <th>:</th>
                        <td><?= $rumah['sanitasi'] ?></td>
                    </tr>
                    <tr>
                        <th>Jenis Bantuan</th>
                        <th>:</th>
                        <td><?= $rumah['jenis_bantuan'] ?></td>
                    </tr>
                    <tr>
                        <th>Alamat Lengkap</th>
                        <th>:</th>
                        <td>
                            <?= $rumah['alamat'] ?>,
                            <?= $rumah['nama_kecamatan'] ?>,
                            <?= $rumah['nama_kabupaten'] ?>,
                            <?= $rumah['nama_provinsi'] ?>
                        </td>
                    </tr>
                    <tr>
                        <th>Koordinat</th>
                        <th>:</th>
                        <td><?= $rumah['koordinat'] ?></td>
                    </tr>
                    <tr>
                        <th>Foto Rumah</th>
                        <th>:</th>
                        <td>
                            <img src="<?= base_url('foto/' . $rumah['foto']) ?>" alt="Foto Rumah" width="300">
                        </td>
                    </tr>
                </table>

            <div class="mt-3 text-end">
                <a href="<?= base_url('Rumah') ?>" class="btn btn-success btn-flat">Kembali</a>
            </div>
            
        </div>
    </div>
</div>

<script>
    function showMap() {
        document.getElementById("map-container").style.display = "block";
        document.getElementById("image-container").style.display = "none";
        setTimeout(() => {
            map.invalidateSize(); 
        }, 200);
    }

    function showImage() {
        document.getElementById("map-container").style.display = "none";
        document.getElementById("image-container").style.display = "block";
    }
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
		center: [<?= $rumah['koordinat']?>],
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

    L.marker([<?= $rumah['koordinat'] ?>]).addTo(map)


    L.geoJSON(<?= $rumah['geojson'] ?>, {
        fillColor: '<?= $rumah['warna'] ?>',
        fillOpacity: 0.5,
    })
    .bindPopup("<b><?= $rumah['nama_wilayah'] ?></b>")
    .addTo(map);

    var icon = L.icon({
    iconUrl: '<?= base_url('Marker/' . $rumah['Marker'])?>',
    iconSize:     [30, 40], 
});
    L.marker([<?= $rumah['koordinat'] ?>], {
        icon:icon
    }).addTo(map);

</script>