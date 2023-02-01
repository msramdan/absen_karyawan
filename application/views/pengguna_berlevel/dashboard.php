<link rel="stylesheet" href="https://unpkg.com/leaflet@1.6.0/dist/leaflet.css" integrity="sha512-xwE/Az9zrjBIphAcBb3F6JVqxf46+CDLwfLMHloNu6KEQCAWi6HcDUbeOfBIptF7tcCzusKFjFw2yuvEpDL9wQ==" crossorigin="" />
<script src="https://unpkg.com/leaflet@1.6.0/dist/leaflet.js" integrity="sha512-gZwIG9x3wUXg2hdXF6+rVkLF/0Vi9U8D2Ntg4Ga5I5BZpVkVxlJWbSQtXPSiUTtC0TjtGOmxa1AJPuV0CPthew==" crossorigin=""></script>

<style>
	.map-embed {
		width: 100%;
		height: 50vh;
	}
</style>

<div id="content" class="app-content">
  <div class="row">
    <div class="col-md-8">
			<section style="width: 100%; height: 100%;">
				<div class="map-embed" id="map-lapangan"></div>
			</section>
    </div>
    <div class="col-md-4">
      <div class="widget widget-stats bg-gradient-cyan-blue">
        <div class="stats-icon stats-icon-lg"><i class="fa fa-users"></i></div>
        <div class="stats-content">
          <div class="stats-title">Karyawan Aktif</div>
          <div class="stats-number"> 10 Orang</div>
          <div class="stats-progress progress">
            <div class="progress-bar" style="width: 100%;"></div>
          </div>
        </div>
      </div>
			<div class="widget widget-stats bg-gradient-indigo">
				<div class="stats-icon stats-icon-lg"><i class="fa fa-spinner"></i></div>
				<div class="stats-content">
					<div class="stats-title">Data Absensi</div>
					<div class="stats-number"> 12,213</div>
					<div class="stats-progress progress">
						<div class="progress-bar" style="width: 100%;"></div>
					</div>
				</div>
			</div>
    </div>
  </div>
</div>

<script>
	$(document).ready(function() {
		// initialize map
		const getLocationMap = L.map('map-lapangan');

		// initialize OSM
		const osmUrl = 'https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png';
		const osmAttrib = 'Map Objek Wisata © <a href="https://openstreetmap.org">OpenStreetMap</a> contributors';
		const osm = new L.TileLayer(osmUrl, {
			minZoom: 8,
			maxZoom: 50,
			attribution: osmAttrib
		});

		getLocationMap.scrollWheelZoom.disable()
		getLocationMap.setView(new L.LatLng('-6.7609425', '108.4415617'), 10)
		getLocationMap.addLayer(osm)
		const getLocationMapMarker = L.marker([0, 0]).addTo(getLocationMap);

		function refreshMarkers(data) {
			let list_of_location = data


			getLocationMap.eachLayer(function(layer) {
				if (layer.options.attribution !== osmAttrib) {
					getLocationMap.removeLayer(layer);
				}
			})

			let list_of_location_html = ''
			for (let i = 0; i < list_of_location.length; i++) {

				list_of_location_html += `<li class="list-group-item" data-lat="${list_of_location[i].latitude}" data-lng="${list_of_location[i].longitude}">${list_of_location[i].nama_lapangan}</li>`
				let marker = L.marker([list_of_location[i].latitude, list_of_location[i].longitude]).addTo(getLocationMap);
				marker.bindPopup(`<b>${list_of_location[i].nama_lapangan}</b><br>Jumlah Karyawan: ${list_of_location[i].jumlah}<br>
				<a href="<?php echo base_url('admin/lapangan/update/') ?>${list_of_location[i].lapangan_id}" class="btn btn-primary" style="color: white; margin-top: 1rem;">Detail</a>
				`);

			}
			$('.results').html(list_of_location_html)
		}

		function GetListofLocation() {
			$.ajax({
				url: '<?= base_url('admin/dashboard/get_list_location_lapangan_count_users') ?>',
				type: 'GET',
				dataType: 'json',
				success: function(data) {
					console.log(data)
					refreshMarkers(data)
				}
			})
		}

		GetListofLocation()

		function getToLoc(lat, lng, displayname = null) {
			const zoom = 23;

			getLocationMap.setView(new L.LatLng(lat, lng), zoom);
			getLocationMapMarker.setLatLng([lat, lng])

		}
	})
</script>
	