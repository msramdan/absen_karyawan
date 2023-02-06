<div id="content" class="app-content">
  <h1 class="page-header">DATA TBL_IZIN</h1>
  <div class="panel panel-inverse">
    <div class="panel-heading">
      <h4 class="panel-title"></h4>
      <div class="panel-heading-btn">
        <a href="javascript:;" class="btn btn-xs btn-icon btn-default" data-toggle="panel-expand"><i
            class="fa fa-expand"></i></a>
        <a href="javascript:;" class="btn btn-xs btn-icon btn-success" data-toggle="panel-reload"><i
            class="fa fa-redo"></i></a>
        <a href="javascript:;" class="btn btn-xs btn-icon btn-warning" data-toggle="panel-collapse"><i
            class="fa fa-minus"></i></a>
        <a href="javascript:;" class="btn btn-xs btn-icon btn-danger" data-toggle="panel-remove"><i
            class="fa fa-times"></i></a>
      </div>
    </div>
    <div class="panel-body">
      <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
          <div class="x_panel">
            <div class="box-body">
              <div class='row'>
                <div class='col-md-9'>
                  <div style="padding-bottom: 10px;">
                    <?php echo anchor(site_url(levelUser($this->session->userdata('level')).'/izin/create'), '<i class="fas fa-plus-square" aria-hidden="true"></i> Tambah Data', 'class="btn btn-danger btn-sm tambah_data"'); ?>
                  </div>
                </div>
              </div>
              <div class="box-body" style="overflow-x: scroll; ">
							<table id="data-table-default"
                  class="table table-bordered table-hover table-td-valign-middle text-white">
                  <thead>
                    <tr>
                      <th>No</th>
                      <th>Users Id</th>
                      <th>Nama Lengkap</th>
											<th>Lampiran</th>
                      <th>Tanggal</th>
											<th>Data Masuk</th>
                      <th>Status</th>
                      <th>Action</th>
                    </tr>
                  </thead>
                  <tbody><?php $no = 1;
            foreach ($izin_data as $izin)
            {
                ?>
                    <tr>
                      <td><?= $no++?></td>
                      <td><?php echo $izin->users_id ?></td>
                      <td><?php echo $izin->nama_lengkap ?></td>
											<td><?= $izin->lampiran ? '<a href="'.base_url('assets/assets/img/user/izin/'.$izin->lampiran).'" target="_blank" class="btn btn-info btn-sm"><i class="fas fa-envelope-open-text" aria-hidden="true"></i></a>' : ''; ?></td>
                      <td><?php echo $izin->tanggal ?></td>
											<td><?php echo $izin->created_at ?></td>
                      <td style="text-align: center;font-size: 1.2rem;">
                        <?php
						$arrbutton = array(
							'approved' => [
								'btn' => 'btn-success',
								'icon' => 'fa-check-circle',
								'status' => 'approve',
								'text' => 'Approved'
							],
							'rejected' => [
								'btn' => 'btn-danger',
								'icon' => 'fa-times-circle',
								'status' => 'reject',
								'text' => 'Rejected'
							],
							null => [
								'btn' => 'btn-warning',
								'icon' => 'fa-clock',
								'status' => 'waiting',
								'text' => 'Waiting'
							]
						);
						?>
                        <div class="btn-group">
                          <?php
								foreach($arrbutton as $key => $value) {
									if($key == $izin->status) {
										echo '<button type="button" class="btn '.$value['btn'].' btn-sm">
											<i class="fas '.$value['icon'].'"></i> '.$value['text'].'
										</button>';
									}
								}
							?>
                        </div>
                      </td>
                      <td style="text-align:center" width="200px">
                        <a href="<?= site_url(levelUser($this->session->userdata('level')).'/izin/read/'.encrypt_url($izin->id)) ?>"
                          class="btn btn-info btn-sm"><i class="fas fa-eye" aria-hidden="true"></i></a>
                        <?php
						if($izin->status == null) {
							echo anchor(site_url(levelUser($this->session->userdata('level')).'/izin/update/'.encrypt_url($izin->id)),'<i class="fas fa-pencil-alt" aria-hidden="true"></i>','class="btn btn-primary btn-sm update_data"'); 
							echo '  '; 
							echo anchor(site_url(levelUser($this->session->userdata('level')).'/izin/delete/'.encrypt_url($izin->id)),'<i class="fas fa-trash-alt" aria-hidden="true"></i>','class="btn btn-danger btn-sm delete_data" Delete','onclick="javasciprt: return confirm(\'Are You Sure ?\')"'); 
							?>
                        <div class="btn-group">
                          <button class="btn btn-success btn-sm btn-approve" data-id="<?= $izin->id ?>"
                            data-status="approved"><i class="fas fa-check-circle"></i></button>
                          <button class="btn btn-danger btn-sm btn-reject" data-id="<?= $izin->id ?>"
                            data-status="rejected"><i class="fas fa-times-circle"></i></button>
                        </div>
                        <?php
						}
					?>
                      </td>
                    </tr>
                    <?php } ?>
                  </tbody>
                </table>

              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

<script>
$(document).ready(function() {
  $('.btn-approve').click(function() {
    var id = $(this).data('id');
    var status = $(this).data('status');
    Swal.fire({
      title: 'Apakah anda yakin?',
      text: "Anda akan mengubah status izin menjadi " + status,
      icon: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      confirmButtonText: 'Ya, ubah status!'
    }).then((result) => {
      if (result.isConfirmed) {
        window.location.href = '<?= base_url('admin/izin/update_status/') ?>' + id + '/' + status;
      }
    })
  })

  $('.btn-reject').click(function() {
    var id = $(this).data('id');
    var status = $(this).data('status');
    Swal.fire({
      title: 'Apakah anda yakin?',
      text: "Anda akan mengubah status izin menjadi " + status,
      icon: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      confirmButtonText: 'Ya, ubah status!'
    }).then((result) => {
      if (result.isConfirmed) {
        window.location.href = '<?= base_url('admin/izin/update_status/') ?>' + id + '/' + status;
      }
    })
  })
})
</script>
