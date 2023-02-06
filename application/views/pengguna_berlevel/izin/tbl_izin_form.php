<div id="content" class="app-content">
  <div class="col-md-6 ui-sortable">
    <div class="panel panel-inverse" data-sortable-id="form-stuff-1" style="" data-init="true">

      <div class="panel-heading ui-sortable-handle">
        <h4 class="panel-title">KELOLA DATA TBL_IZIN</h4>
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

        <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data">
          <thead>
            <table id="data-table-default" class="table  table-bordered table-hover table-td-valign-middle">
              <tr>
                <td>Users Id <?php echo form_error('users_id') ?></td>
                <td>
									<select name="users_id" id="users_id" class="form-control">
										<option value="">-- Ketik Username/Nama Karyawan --</option>
									</select>
								</td>
              </tr>
              <tr>
                <td>Tanggal <?php echo form_error('tanggal') ?></td>
                <td><input type="date" class="form-control" name="tanggal" id="tanggal" placeholder="Tanggal"
                    value="<?php echo $tanggal; ?>" /></td>
              </tr>

              <tr>
                <td>Alasan <?php echo form_error('alasan') ?></td>
                <td> <textarea class="form-control" rows="3" name="alasan" id="alasan"
                    placeholder="Alasan"><?php echo $alasan; ?></textarea></td>
              </tr>
							<tr>
								<td>Lampiran</td>
								<td>
									<input type="file" class="form-control" name="lampiran" id="lampiran" placeholder="Lampiran" />
									<?php
										if($button == 'Update' && $lampiran != NULL) {
											?>
												<br>
												<a href="<?php echo base_url('assets/assets/img/user/izin/'.$lampiran) ?>" target="_blank">Lihat Lampiran</a>
												<input type="hidden" name="lampiran_old" value="<?php echo $lampiran; ?>" />
											<?php
										}
									?>
								</td>
							</tr>
              <tr>
                <td></td>
                <td><input type="hidden" name="id" value="<?php echo $id; ?>" />
                  <button type="submit" class="btn btn-danger"><i class="fas fa-save"></i>
                    <?php echo $button ?></button>
                  <a href="<?php echo site_url(levelUser($this->session->userdata('level')).'/izin') ?>"
                    class="btn btn-info"><i class="fas fa-undo"></i> Kembali</a>
                </td>
              </tr>
          </thead>
          </table>
        </form>
      </div>
    </div>
  </div>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/selectize.js/0.11.0/js/standalone/selectize.js"></script>

<script>
	$(document).ready(function() {

		$('#users_id').selectize({
			// fetch data from api
			valueField: 'id',
			labelField: 'text',
			searchField: 'text',
			options: [],
			create: false,
			load: function(query, callback) {
				if (!query.length) return callback();
				$.ajax({
					url: '<?php echo base_url('admin/cuti/get_user_by_name_or_username') ?>',
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

		<?php
		if($button == 'Update' || $users_id != NULL) {
			$getdatausers = $this->db->get_where('tbl_users', ['id' => $users_id])->row();
			$idnya = $getdatausers->id;
			$usernamenya = $getdatausers->username;
			$namanya = $getdatausers->nama_lengkap;
			?>
				$('#users_id')[0].selectize.addOption({id: '<?php echo $idnya ?>', text: '<?php echo $namanya.' - '.$usernamenya ?>'});
				
				$('#users_id')[0].selectize.setValue('<?php echo $idnya ?>');
			<?php
		}
		?>
	})
</script>
