<div id="content" class="app-content">
  <div class="col-md-6 ui-sortable">
    <div class="panel panel-inverse" data-sortable-id="form-stuff-1" data-init="true">
      <div class="panel-heading ui-sortable-handle">
        <h4 class="panel-title">Tbl_sakit Read</h4>
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
        <table id="data-table-default" class="table table-hover table-bordered table-td-valign-middle">
          <tr>
            <td>Users Id</td>
            <td><?php echo $users_id; ?></td>
          </tr>
          <tr>
            <td>Tanggal</td>
            <td><?php echo $tanggal; ?></td>
          </tr>
          <tr>
            <td>Alasan</td>
            <td><?php echo $alasan; ?></td>
          </tr>
					<tr>
						<td>Lampiran</td>
						<td>
							<?php if ($lampiran != null) { ?>
							<a href="<?php echo base_url('assets/assets/img/user/sakit/'.$lampiran) ?>" target="_blank">Lihat Lampiran</a>
							<?php } else { ?>
							-
							<?php } ?>
						</td>
					</tr>
					<tr>
						<td>Updated At</td>
						<td><?php echo $updated_at; ?></td>
					</tr>
					<tr>
						<td>Created At</td>
						<td><?php echo $created_at; ?></td>
					</tr>
          <tr>
            <td>Status</td>
            <td><?php echo $status; ?></td>
          </tr>
          <tr>
            <td></td>
            <td><a href="<?php echo site_url(levelUser($this->session->userdata('level')).'/sakit') ?>"
                class="btn btn-default">Cancel</a></td>
          </tr>
        </table>
      </div>
    </div>
  </div>
</div>
