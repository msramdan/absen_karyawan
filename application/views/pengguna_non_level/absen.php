<style>
#canvas-jam {
  margin: auto;
  display: block;
}

#video_capture {
  margin: auto;
  display: none;
}

#canvas_camera {
  margin: auto;
  display: none;
}

.note-capture-photo {
  position: absolute;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  background: rgba(0, 0, 0, 0.5);
  display: flex;
  align-items: center;
  justify-content: center;
  flex-direction: column;
  color: white;
  text-align: center;
}

.success-indicator {
  color: green;
  font-size: 2rem;
  position: absolute;
  top: 50%;
}
</style>

<div id="content" class="app-content">
	<div class="alertnya">
		<div class="alert alert-success alert-dismissible fade show" role="alert">
			<strong>Perhatian</strong> Pastikan izin lokasi diberikan untuk mengetahui lokasi anda.
			<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
		</div>
	</div>
	<?php
	if($masukataupulang != 'Sudah Absen') {
		?>
		<div class="row">
			<div class="col-md-6">
				<h3 class="text-center">
					Absen <?= $masukataupulang ?>
				</h3>
				<canvas id="canvas-jam" width="200" height="200" style=""></canvas>
				<div id="embed-map" style="height: 340px; width: 100%;"></div>
			</div>
			<div class="col-md-6">
				
				<form id="form-absen" method="post" action="<?= base_url('karyawan/absen/act_absen') ?>">
					<div class="d-flex flex-column">
						<div class="camera_wrapper" style="height: 240px; width: 100%; position:relative;">
							<video id="video_capture" width="320" height="240" autoplay></video>
							<canvas canvas id="canvas_camera" width="320" height="240">
							</canvas>
							<div class="note-capture-photo">
								<i class="fa fa-camera" style="font-size: 6rem;margin: auto;"></i>
								<p class="text-center">Silahkan Ambil Photo</p>
							</div>
							<i class="fa fa-check-circle success-indicator" style="display: none;"></i>
						</div>
						<div class="d-flex gap-2 w-100 mt-2">
							<button id="start-camera" type="button" class="btn btn-danger w-100">Ambil Foto</button>
							<button id="click-photo" type="button" class="btn w-100 btn-success" style="display: none;">Click Photo</button>
						</div>
						<input type="text" name="latitude" id="latitude">
						<input type="text" name="longitude" id="longitude">
						<input type="text" name="imageDataURL" id="photo">
						<button id="btn-act-absen" type="submit" class="btn btn-absen btn-primary mt-2 w-100"><?= $masukataupulang ?></button>
					</div>
				</form>
			</div>
		</div>
		<?php
	} else {
		?>
		<div class="row">
			<div class="col">
				
				<div class="alert alert-success alert-dismissible fade show" role="alert">
					<strong>Sudah Absen</strong> Terima kasih atas kerja sama anda.
					<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
				</div>

			</div>
		</div>
		<?php } ?>
</div>
<script src="<?= base_url('assets/assets/js/clock.js') ?>"></script>
<script src="<?= base_url('assets/assets/js/camera-capture.js') ?>"></script>
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.6.0/dist/leaflet.css" integrity="sha512-xwE/Az9zrjBIphAcBb3F6JVqxf46+CDLwfLMHloNu6KEQCAWi6HcDUbeOfBIptF7tcCzusKFjFw2yuvEpDL9wQ==" crossorigin=""/>
	<script src="https://unpkg.com/leaflet@1.6.0/dist/leaflet.js" integrity="sha512-gZwIG9x3wUXg2hdXF6+rVkLF/0Vi9U8D2Ntg4Ga5I5BZpVkVxlJWbSQtXPSiUTtC0TjtGOmxa1AJPuV0CPthew==" crossorigin=""></script>
<script>
	// initialize map
	const getLocationMap = L.map('embed-map');

	// initialize OSM
	const osmUrl = 'https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png';
	const osmAttrib = 'Leaflet © <a href="https://openstreetmap.org">OpenStreetMap</a> contributors';
	const osm = new L.TileLayer(osmUrl, {
		minZoom: 8,
		maxZoom: 50,
		attribution: osmAttrib
	});

	let myCircle;
	// render map

	let insidekah = false;
	let outsidekah = false;

	getLocationMap.scrollWheelZoom.disable()
	getLocationMap.setView(new L.LatLng('-6.175392', '106.827153'), 14)
	getLocationMap.addLayer(osm)
	// initial hidden marker, and update on click
	let getLocationMapMarker = L.marker(['-6.175392', '106.827153']).addTo(getLocationMap);

	function getToLoc(lat, lng) {
		const zoom = 17;
		getLocationMap.setView(new L.LatLng(lat, lng), zoom);
		
		// remove old marker
		if (getLocationMapMarker) {
			getLocationMap.removeLayer(getLocationMapMarker)
		}
		// add new marker
		getLocationMapMarker = L.marker([lat, lng]).addTo(getLocationMap);
		getLocationMapMarker.setLatLng([lat, lng])

		$('#latitude').val(lat)
		$('#longitude').val(lng)

		var d = getLocationMapMarker.getLatLng().distanceTo(myCircle.getLatLng());
		var isInside = d < myCircle.getRadius();
		if (isInside) {
			outsidekah = false
			if (insidekah == false) {
				insidekah = true
				console.log('Inside')
			}
		} else {
			insidekah = false
			if (outsidekah == false) {
				outsidekah = true
				console.log('Outside')
			}
		}
	}

	function createRadius(lat, lng, radius) {
		myCircle = L.circle([lat, lng], {
			color: 'red',
			fillColor: '#f03',
			fillOpacity: 0.5,
			radius: radius
		}).addTo(getLocationMap);
	}

	// get current location
	function getCurrentLocation() {
		if (navigator.geolocation) {
			navigator.geolocation.getCurrentPosition(function(position) {
				getToLoc(position.coords.latitude, position.coords.longitude)
				
				$('.alertnya').html('')
			});
		} else {
			alert("Geolocation is not supported by this browser.");
			$('.alertnya').html(`
				<div class="alert alert-danger alert-dismissible fade show" role="alert">
					<strong>Perhatian</strong> Izin lokasi harus diberikan untuk mengetahui lokasi anda.
					<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
				</div>
			`)
		}
	}

	function addLapanganRadius(){
		$.ajax({
			url: '<?= base_url('karyawan/absen/getLapanganRadius') ?>',
			type: 'POST',
			data: {
				lapangan_id: '<?= $lapangan_id ?>'
			},
			success: function(res){
				console.log(res)
				res = JSON.parse(res)
				createRadius(res.lat, res.lng, res.radius_diizinkan)
			}
		})
	}

	$(document).ready(function() {
		addLapanganRadius()
		setInterval(() => {
			getCurrentLocation()
			console.log('location updated')
		}, 2000);

		$(document).on('click','#btn-act-masuk', function() {
			$.ajax({
				url: '<?= base_url('karyawan/absen/absenMasuk') ?>',
				type: 'POST',
				data: {
					lapangan_id: '<?= $lapangan_id ?>'
				},
				success: function(res){
					console.log(res)
					res = JSON.parse(res)
					if (res.status == 'success') {
						Swal.fire({
							icon: 'success',
							title: 'Berhasil',
							text: res.message,
							showConfirmButton: false,
							timer: 1500
						})
					} else {
						Swal.fire({
							icon: 'error',
							title: 'Gagal',
							text: res.message,
							showConfirmButton: false,
							timer: 1500
						})
					}
				}
			})		
		})

	})

</script>
