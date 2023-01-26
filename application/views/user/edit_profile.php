<div id="content" class="app-content p-0">

	<div class="profile">
		<div class="profile-header">

			<div class="profile-header-cover"></div>


			<div class="profile-header-content">

				<div class="profile-header-img">
					<?php $this->fungsi->user_login()->photo; ?>
					<img src="<?= base_url() ?>assets/assets/img/user/<?= $this->fungsi->user_login()->photo; ?>" alt="">
				</div>


				<div class="profile-header-info">
					<h4 class="mt-0 mb-1"><?= ucfirst($this->fungsi->user_login()->username) ?></h4>
					<a href="#" class="btn btn-xs btn-yellow">Edit Profile</a>
				</div>

			</div>


			<ul class="profile-header-tab nav nav-tabs">
				<li class="nav-item"><a href="#profile-about" class="nav-link active" data-bs-toggle="tab">ABOUT</a></li>
			</ul>

		</div>
	</div>


	<div class="profile-content">

		<div class="tab-content p-0">

			<div class="tab-pane fade active show" id="profile-about">

				<div class="table-responsive form-inline">
					<form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data">
						<table class="table table-profile align-middle">
							<tbody>
								<input type="hidden" class="form-control" name="id" id="id" placeholder="id" value="<?php echo $id; ?>" />
								<input type="hidden" class="form-control" name="level" id="level" placeholder="level" value="<?php echo $level; ?>" />
								<tr class="highlight">
									<td class="field">Username <?php echo form_error('username') ?></td>
									<td><input readonly="" type="text" class="form-control" name="username" id="Username" placeholder="Username" value="<?php echo $username; ?>" /></td>
								</tr>
								<tr class="divider">
									<td colspan="2"></td>
								</tr>

								<?php if ($this->uri->segment(2) == "create" || $this->uri->segment(2) == "create_action") { ?>
									<tr class="highlight">
										<td class="field">Password <?php echo form_error('password') ?></td>
										<td><input type="password" class="form-control" name="password" id="password" placeholder="Password" value="<?php echo $password; ?>" /></td>
									</tr>
								<?php } else { ?>
									<tr class="highlight">
										<td class="field">Password <?php echo form_error('password') ?></td>
										<td><input type="password" class="form-control" name="password" id="password" placeholder="Password" value="" />
											<small style="color: white">(Biarkan kosong jika tidak diganti)</small>
										</td>
									</tr>
								<?php } ?>

								<tr class="divider">
									<td colspan="2"></td>
								</tr>
								<?php if ($this->uri->segment(2) == 'create' || $this->uri->segment(2) == 'create_action') { ?>
									<tr class="highlight">
										<td class="field">photo <?php echo form_error('photo') ?></td>
										<td><input type="file" class="form-control" name="photo" id="photo" placeholder="photo" requiwhite="" value="" onchange="return validasiEkstensi()" />
										</td>
									</tr>
								<?php } else { ?>
									<tr class="highlight">
										<td class="field">Photo <?php echo form_error('photo') ?></td>
										<td>
											<a href="#modal-dialog" data-bs-toggle="modal"><img style="width: 150px;height: 150px;border-radius: 5%;" src="<?php echo base_url(); ?>assets/assets/img/user/<?= $photo ?>" width="200" height="150"></img></a>
											<input type="hidden" name="photo_lama" value="<?= $photo ?>">
											<p style="color: white">Note :Pilih photo Jika Ingin Merubah photo</p>
											<input type="file" class="form-control" name="photo" id="photo" placeholder="photo" value="" onchange="return validasiEkstensi()" />
										</td>

									</tr>
								<?php } ?>

								<tr class="divider">
									<td colspan="2"></td>
								</tr>

								<tr class="highlight">
									<td class="field">&nbsp;</td>
									<td class="">
										<button type="submit" class="btn btn-primary w-150px"><i class="fas fa-save"></i> <?php echo $button ?></button>
									</td>
								</tr>
							</tbody>
						</table>
					</form>
				</div>

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
