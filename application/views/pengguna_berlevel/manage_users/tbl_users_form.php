<div id="content" class="app-content">
  <div class="col-md-6 ui-sortable">
    <div class="panel panel-inverse" data-sortable-id="form-stuff-1" style="" data-init="true">

      <div class="panel-heading ui-sortable-handle">
        <h4 class="panel-title">KELOLA DATA TBL_USERS</h4>
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
                <td>Nama Lengkap <?php echo form_error('nama_lengkap') ?></td>
                <td> <input type="text" class="form-control" rows="3" name="nama_lengkap" id="nama_lengkap"
                    placeholder="Nama Lengkap" value="<?php echo $nama_lengkap; ?>"></td>
              </tr>
              <tr>
                <td>Jenis Kelamin <?php echo form_error('jenis_kelamin') ?></td>
                <td>
									<select class="form-control" name="jenis_kelamin" id="jenis_kelamin">
										<option value="Laki-laki" <?php if($jenis_kelamin == 'Laki-laki') { echo 'selected'; } ?>>Laki-laki</option>
										<option value="Perempuan" <?php if($jenis_kelamin == 'Perempuan') { echo 'selected'; } ?>>Perempuan</option>
									</select>
								</td>
              </tr>

              <tr>
                <td>Alamat <?php echo form_error('alamat') ?></td>
                <td> <textarea class="form-control" rows="3" name="alamat" id="alamat"
                    placeholder="Alamat"><?php echo $alamat; ?></textarea></td>
              </tr>
              <tr>
                <td>Nik <?php echo form_error('nik') ?></td>
                <td><input type="text" class="form-control" name="nik" id="nik" placeholder="Nik"
                    value="<?php echo $nik; ?>" /></td>
              </tr>
              <tr>
                <td>Email <?php echo form_error('email') ?></td>
                <td><input type="text" class="form-control" name="email" id="email" placeholder="Email"
                    value="<?php echo $email; ?>" /></td>
              </tr>
              <tr>
                <td>No Telp <?php echo form_error('no_telp') ?></td>
                <td><input type="text" class="form-control" name="no_telp" id="no_telp" placeholder="No Telp"
                    value="<?php echo $no_telp; ?>" /></td>
              </tr>
              <tr>
                <td>Username <?php echo form_error('username') ?></td>
                <td><input type="text" class="form-control" name="username" id="username" placeholder="Username"
                    value="<?php echo $username; ?>" /></td>
              </tr>
              <tr>
                <td>Password <?php echo form_error('password') ?></td>
                <td>
									<input type="text" class="form-control" name="password" id="password" placeholder="Password"
                    value="<?php echo $password; ?>" />
									<?php
									if($button == 'Update') {
										echo '<small class="text-danger">* Kosongkan jika tidak ingin mengubah password</small>';
										echo '<input type="hidden" name="old_password" value="'.$password.'">';
									}
									?>
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
                  <a href="<?php echo site_url(levelUser($this->session->userdata('level')).'/manage_users') ?>" class="btn btn-info"><i class="fas fa-undo"></i>
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
