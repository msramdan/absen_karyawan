<div id="content" class="app-content">
  <div class="row">
    <div class="col-md-6 ui-sortable">
      <div class="panel panel-inverse" data-sortable-id="form-stuff-1" style="" data-init="true">

        <div class="panel-heading ui-sortable-handle">
          <h4 class="panel-title">KELOLA DATA TBL_LAPANGAN</h4>
          <div class="panel-heading-btn">
            <a href="javascript:;" class="btn btn-xs btn-icon btn-default" data-toggle="panel-expand"
              data-bs-original-title="" title="" data-tooltip-init="true"><i class="fa fa-expand"></i></a>
            <a href="javascript:;" class="btn btn-xs btn-icon btn-success" data-toggle="panel-reload"><i
                class="fa fa-redo"></i></a>
            <a href="javascript:;" class="btn btn-xs btn-icon btn-warning" data-toggle="panel-collapse"><i
                class="fa fa-minus"></i></a>
            <a href="javascript:;" class="btn btn-xs btn-icon btn-danger" data-toggle="panel-remove"><i
                class="fa fa-times"></i></a>
          </div>
        </div>
        <div class="panel-body">

          <form action="<?php echo $action; ?>" method="post">
            <thead>
              <table id="data-table-default" class="table  table-bordered table-hover table-td-valign-middle">
                <tr>
                  <td>Nama Lapangan <?php echo form_error('nama_lapangan') ?></td>
                  <td colspan="2"><input type="text" class="form-control" name="nama_lapangan" id="nama_lapangan"
                      placeholder="Nama Lapangan" value="<?php echo $nama_lapangan; ?>" /></td>
                </tr>
                <tr>
                  <td>Latitude <?php echo form_error('latitude') ?></td>
                  <td><input type="text" class="form-control" name="latitude" id="latitude" placeholder="Latitude"
                      value="<?php echo $latitude; ?>" /></td>
										<td rowspan="3"><button type="button" class="btn btn-primary" id="initToMap"><i class="fas fa-search-location"></i></button></td>
                </tr>
                <tr>
                  <td>Longitude <?php echo form_error('longitude') ?></td>
                  <td><input type="text" class="form-control" name="longitude" id="longitude" placeholder="Longitude"
                      value="<?php echo $longitude; ?>" /></td>
                </tr>
                <tr>
                  <td>Radius Diizinkan <?php echo form_error('radius_diizinkan') ?></td>
                  <td>
										<div class="input-group">
											<input type="number" class="form-control" name="radius_diizinkan" id="radius_diizinkan" placeholder="Radius Diizinkan" value="<?php echo $radius_diizinkan; ?>" min="1" />
											<div class="input-group-text">Meter</div>
										</div>
									</td>
                </tr>
                <tr>
                  <td>Jam Masuk Diizinkan <?php echo form_error('jam_masuk_diizinkan') ?></td>
                  <td colspan="2"><input type="time" class="form-control" name="jam_masuk_diizinkan" id="jam_masuk_diizinkan"
                      placeholder="Jam Masuk Diizinkan" value="<?php echo $jam_masuk_diizinkan; ?>" /></td>
                </tr>
                <tr>
                  <td>Jam Keluar Diizinkan <?php echo form_error('jam_keluar_diizinkan') ?></td>
                  <td colspan="2"><input type="time" class="form-control" name="jam_keluar_diizinkan" id="jam_keluar_diizinkan"
                      placeholder="Jam Keluar Diizinkan" value="<?php echo $jam_keluar_diizinkan; ?>" /></td>
                </tr>
                <tr>
                  <td>Petugas <?php echo form_error('petugas') ?></td>
                  <td colspan="2">
										<select name="petugas" id="petugas" class="form-control">
											<option value="">-- Pilih Petugas --</option>
											<?php foreach ($petugas as $key => $value) { ?>
												<option value="<?php echo $value->id ?>" <?php echo $value->id == $petugas ? 'selected' : '' ?>><?php echo $value->nama ?></option>
											<?php } ?>
										</select>
										<span class="text-danger">*Petugas yang dipilih hanya yang levelnya "Koordinator Lapangan"</span>
									</td>
                </tr>
                <tr>
                  <td></td>
                  <td colspan="2"><input type="hidden" name="id" value="<?php echo $id; ?>" />
                    <button type="submit" class="btn btn-danger"><i class="fas fa-save"></i>
                      <?php echo $button ?></button>
                    <a href="<?php echo site_url(levelUser($this->session->userdata('level')).'/lapangan') ?>" class="btn btn-info"><i class="fas fa-undo"></i>
                      Kembali</a>
                  </td>
                </tr>
            </thead>
            </table>
          </form>
        </div>
      </div>
    </div>
    <div class="col-md-6 ui-sortable">
      <div class="panel panel-inverse" data-sortable-id="form-stuff-1" style="" data-init="true">

        <div class="panel-heading ui-sortable-handle">
          <h4 class="panel-title">Peta</h4>
          <div class="panel-heading-btn">
            <a href="javascript:;" class="btn btn-xs btn-icon btn-default" data-toggle="panel-expand"
              data-bs-original-title="" title="" data-tooltip-init="true"><i class="fa fa-expand"></i></a>
            <a href="javascript:;" class="btn btn-xs btn-icon btn-success" data-toggle="panel-reload"><i
                class="fa fa-redo"></i></a>
            <a href="javascript:;" class="btn btn-xs btn-icon btn-warning" data-toggle="panel-collapse"><i
                class="fa fa-minus"></i></a>
            <a href="javascript:;" class="btn btn-xs btn-icon btn-danger" data-toggle="panel-remove"><i
                class="fa fa-times"></i></a>
          </div>
        </div>
        <div class="panel-body">
          <div id="map" style="width: 100%; height: 500px;">
          </div>
        </div>
      </div>
    </div>
  </div>

	<link rel="stylesheet" href="https://unpkg.com/leaflet@1.6.0/dist/leaflet.css" integrity="sha512-xwE/Az9zrjBIphAcBb3F6JVqxf46+CDLwfLMHloNu6KEQCAWi6HcDUbeOfBIptF7tcCzusKFjFw2yuvEpDL9wQ==" crossorigin=""/>
	<script src="https://unpkg.com/leaflet@1.6.0/dist/leaflet.js" integrity="sha512-gZwIG9x3wUXg2hdXF6+rVkLF/0Vi9U8D2Ntg4Ga5I5BZpVkVxlJWbSQtXPSiUTtC0TjtGOmxa1AJPuV0CPthew==" crossorigin=""></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/selectize.js/0.11.0/js/standalone/selectize.js"></script>

  <script>
  $(document).ready(function() {

		$('#petugas').selectize({
			// fetch data from api
			valueField: 'id',
			labelField: 'text',
			searchField: 'text',
			options: [],
			create: false,
			load: function(query, callback) {
				if (!query.length) return callback();
				$.ajax({
					url: '<?php echo base_url('admin/manage_admin/find_petugas') ?>',
					type: 'GET',
					dataType: 'json',
					data: {
						q: query,
					},
					error: function() {
						callback();
					},
					success: function(res) {
						callback(res.data);
					}
				});
			}
		});

    function checkKosongLatLong() {
      if ($('#latitude').val() == '' || $('#longitude').val() == '') {
        $('.alert-choose-loc').show();
      } else {
        $('.alert-choose-loc').hide();
      }
    }

		function addRadius(radius) {
			var lat = $('#latitude').val();
			var lng = $('#longitude').val();

			// remove old circle
			getLocationMap.eachLayer(function (layer) {
				if (layer instanceof L.Circle) {
					getLocationMap.removeLayer(layer);
				}
			});

			if(lat != '' && lng != '') {
				let circle = L.circle([lat, lng], {
					color: 'red',
					fillColor: '#f03',
					fillOpacity: 0.5,
					radius: radius
				}).addTo(getLocationMap);
			}
		}

    var delay = (function() {
      var timer = 0;
      return function(callback, ms) {
        clearTimeout(timer);
        timer = setTimeout(callback, ms);
      };
    })()

    // ref: https://switch2osm.org/using-tiles/getting-started-with-leaflet/


    // initialize map
    const getLocationMap = L.map('map');

    // initialize OSM
    const osmUrl = 'https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png';
    const osmAttrib = 'Leaflet © <a href="https://openstreetmap.org">OpenStreetMap</a> contributors';
    const osm = new L.TileLayer(osmUrl, {
      minZoom: 8,
      maxZoom: 50,
      attribution: osmAttrib
    });
    // render map

    getLocationMap.scrollWheelZoom.disable()
		getLocationMap.setView(new L.LatLng('-6.175392', '106.827153'), 14)
    getLocationMap.addLayer(osm)
    // initial hidden marker, and update on click
    const getLocationMapMarker = L.marker([0, 0]).addTo(getLocationMap);

    function getToLoc(lat, lng, displayname = null) {
      const zoom = 17;

      $.ajax({
        url: `https://nominatim.openstreetmap.org/reverse?format=json&lat=${lat}&lon=${lng}`,
        dataType: 'json',
        success: function(data) {
          $('#latitude').val(lat)
          $('#longitude').val(lng)
          if (displayname == null) {
            $('#search-loc').val(data.display_name)
          } else {
            $('#search-loc').val(displayname)
          }
        }
      });
      getLocationMap.setView(new L.LatLng(lat, lng), zoom);
      getLocationMapMarker.setLatLng([lat, lng])
      $('.results').hide();
      checkKosongLatLong()

    }

    <?php
			if($button == 'Update') {
				echo "getToLoc($latitude, $longitude)";
			}
		?>

    // listen click on map
    getLocationMap.on('click', function(e) {
      // set default lat and lng to 0,0
      const {
        lat = 0, lng = 0
      } = e.latlng;
      // update text DOM

      $('#latitude').val(lat)
      $('#longitude').val(lng)
      // update marker position
      getToLoc(lat, lng)
			addRadius($('#radius_diizinkan').val())
      checkKosongLatLong()

    });

		$(document).on('keyup', '#radius_diizinkan', function() {
			addRadius($(this).val())
		})

		$(document).on('click', '#initToMap', function() {

			if(
				$('#latitude').val() == '' ||
				$('#longitude').val() == '' ||
				$('#search-loc').val() == ''
			) {
				alert('Lengkapi data lokasi terlebih dahulu')
				return false;
			}

			getToLoc($('#latitude').val(), $('#longitude').val(), $('#search-loc').val())
		})

		<?php
		if($button == 'Update') {
			$getdataadmin = $this->db->get_where('tbl_admin', ['id' => $petugas])->row();
			$idnya = $getdataadmin->id;
			$usernamenya = $getdataadmin->username;
			?>
				$('#petugas')[0].selectize.addOption({id: '<?php echo $idnya ?>', text: '<?php echo $usernamenya ?>'});
				
				$('#petugas')[0].selectize.setValue('<?php echo $idnya ?>');
				addRadius($('#radius_diizinkan').val());
			<?php
		}
		?>
  })
  </script>
</div>
