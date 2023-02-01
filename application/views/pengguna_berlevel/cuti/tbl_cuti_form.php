<div id="content" class="app-content">
  <div class="col-md-6 ui-sortable">
    <div class="panel panel-inverse" data-sortable-id="form-stuff-1" style="" data-init="true">

      <div class="panel-heading ui-sortable-handle">
        <h4 class="panel-title">KELOLA DATA TBL_CUTI</h4>
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
                <td>Users Id <?php echo form_error('users_id') ?></td>
                <td>
									<select name="users_id" id="users_id" class="form-control">
										<option value="">-- Ketik Username/Nama Karyawan --</option>
										<?php foreach ($users_id as $key => $value) { ?>
											<option value="<?php echo $value->id ?>" <?php echo $value->id == $users_id ? 'selected' : '' ?>><?php echo $value->nama ?></option>
										<?php } ?>
									</select>
								</td>
              </tr>
              <tr>
                <td>Tanggal Mulai <?php echo form_error('tanggal_mulai') ?></td>
                <td><input type="date" class="form-control tanggal_input" name="tanggal_mulai" id="tanggal_mulai"
                    placeholder="Tanggal Mulai" value="<?php echo $tanggal_mulai; ?>" /></td>
              </tr>
              <tr>
                <td>Tanggal Akhir <?php echo form_error('tanggal_akhir') ?></td>
                <td><input type="date" class="form-control tanggal_input" name="tanggal_akhir" id="tanggal_akhir"
                    placeholder="Tanggal Akhir" value="<?php echo $tanggal_akhir; ?>" /></td>
              </tr>

              <tr>
                <td>Alasan <?php echo form_error('alasan') ?></td>
                <td> <textarea class="form-control" rows="3" name="alasan" id="alasan"
                    placeholder="Alasan"><?php echo $alasan; ?></textarea></td>
              </tr>
              <tr>
                <td></td>
                <td><input type="hidden" name="id" value="<?php echo $id; ?>" />
                  <button type="submit" class="btn btn-danger"><i class="fas fa-save"></i>
                    <?php echo $button ?></button>
                  <a href="<?php echo site_url(levelUser($this->session->userdata('level')).'/cuti') ?>"
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

		var today = new Date().toISOString().split('T')[0];
		$('.tanggal_input').attr('min', today);
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
	})
</script>
