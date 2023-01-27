<div id="content" class="app-content">
  <div class="col-md-6 ui-sortable">
    <div class="panel panel-inverse" data-sortable-id="form-stuff-1" style="" data-init="true">

      <div class="panel-heading ui-sortable-handle">
        <h4 class="panel-title">KELOLA DATA TBL_ADMIN</h4>
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
                <td>Username <?php echo form_error('username') ?></td>
                <td><input type="text" class="form-control" name="username" id="username" placeholder="Username"
                    value="<?php echo $username; ?>" /></td>
              </tr>
              <tr>
                <td>Password <?php echo form_error('password') ?></td>
                <td><input type="password" class="form-control" name="password" id="password" placeholder="Password"
                    value="" />
										<?php
										if($button == 'Update') {
											?>
												<small class="text-danger">* Kosongkan jika tidak ingin mengubah password</small>
												<input type="hidden" name="old_password" value="<?php echo $password; ?>">
											<?php
										}
										?>
								</td>
              </tr>
              <tr>
                <td>Level <?php echo form_error('level') ?></td>
                <td>
									<div class="form-check mb-2">
										<input class="form-check-input" type="radio" name="level" id="level1" value="1" <?php echo $level == 1 ? "checked" : "" ?>>
										<label class="form-check-label" for="level1">
											Admin
										</label>
									</div>
									<div class="form-check mb-2">
										<input class="form-check-input" type="radio" name="level" id="level2" value="2" <?php echo $level == 2 ? "checked" : "" ?>>
										<label class="form-check-label" for="level2">
											Owner
										</label>
									</div>
									<div class="form-check mb-2">
										<input class="form-check-input" type="radio" name="level" id="level3" value="3" <?php echo $level == 3 ? "checked" : "" ?>>
										<label class="form-check-label" for="level3">
											Koordinator Lapangan
										</label>
									</div>
								</td>
              </tr>
              <tr>
                <td>Photo <?php echo form_error('photo') ?></td>
                <td>
									<a href="#modal-dialog" data-bs-toggle="modal" id="preview"><img src="<?php echo base_url(); ?>assets/assets/img/user/<?= $photo ?? 'default.jpg'; ?>" style="width: 150px;height: 150px;border-radius: 5%;"></img></a>
									<input type="hidden" name="old_photo" value="<?= $photo ?>">
									<p style="color:white">Note :Pilih photo Jika Ingin Merubah photo</p>
									<input type="file" class="form-control" name="photo" id="photo" placeholder="photo" value="" onchange="return validasiEkstensi()" />
								</td>
              </tr>
              <tr>
                <td></td>
                <td><input type="hidden" name="id" value="<?php echo $id; ?>" />
                  <button type="submit" class="btn btn-danger"><i class="fas fa-save"></i>
                    <?php echo $button ?></button>
                  <a href="<?php echo site_url(levelUser($this->session->userdata('level')).'/manage_admin') ?>" class="btn btn-info"><i class="fas fa-undo"></i>
                    Kembali</a>
                </td>
              </tr>
          </thead>
          </table>
        </form>
      </div>
    </div>
  </div>
</div>

<!-- #modal-dialog -->
<div class="modal fade" id="modal-dialog">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title">Photo <?php echo $username; ?></h4>
				<button type="button" class="btn-close" data-bs-dismiss="modal" aria-hidden="true"></button>
			</div>
			<div class="modal-body">
				<img src="<?php echo base_url(); ?>assets/assets/img/user/<?= $photo ?>" width="100%" />
			</div>
			<div class="modal-footer">
				<a href="javascript:;" class="btn btn-white" data-bs-dismiss="modal">Close</a>
			</div>
		</div>
	</div>
</div>


<script type="text/javascript">
	function validasiEkstensi() {
		var inputFile = document.getElementById('photo');
		var pathFile = inputFile.value;
		var ekstensiOk = /(\.jpg|\.jpeg|\.png)$/i;
		if (!ekstensiOk.exec(pathFile)) {
			alert('Silakan upload file yang memiliki ekstensi .jpeg/.jpg/.png');
			inputFile.value = '';
			return false;
		} else {
			// Preview photo
			if (inputFile.files && inputFile.files[0]) {
				var reader = new FileReader();
				reader.onload = function(e) {
					document.getElementById('preview').innerHTML = '<img src="' + e.target.result + '" style="width: 150px;height: 150px;border-radius: 5%;"/>';
				};
				reader.readAsDataURL(inputFile.files[0]);
			}
		}
	}
</script>
