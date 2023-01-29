<div id="content" class="app-content">
  <h1 class="page-header">DATA TBL_LAPANGAN</h1>
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
                    <?php echo anchor(site_url(levelUser($this->session->userdata('level')).'/lapangan/create'), '<i class="fas fa-plus-square" aria-hidden="true"></i> Tambah Data', 'class="btn btn-danger btn-sm tambah_data"'); ?>
                  </div>
                </div>
              </div>
              <div class="box-body" style="overflow-x: scroll; ">
                <table id="data-table-default"
                  class="table table-bordered table-hover table-td-valign-middle text-white">
                  <thead>
                    <tr>
                      <th>No</th>
                      <th>Nama Lapangan</th>
                      <th>Latitude</th>
                      <th>Longitude</th>
                      <th>Radius Diizinkan</th>
                      <th>Jam Masuk Diizinkan</th>
                      <th>Jam Keluar Diizinkan</th>
											<th>Total Karyawan</th>
                      <th>Petugas</th>
                      <th>Action</th>
                    </tr>
                  </thead>
                  <tbody><?php $no = 1;
            foreach ($lapangan_data as $lapangan)
            {
                ?>
                    <tr>
                      <td><?= $no++?></td>
                      <td><?php echo $lapangan->nama_lapangan ?></td>
                      <td><?php echo $lapangan->latitude ?></td>
                      <td><?php echo $lapangan->longitude ?></td>
                      <td><?php echo $lapangan->radius_diizinkan ?></td>
                      <td><?php echo $lapangan->jam_masuk_diizinkan ?></td>
                      <td><?php echo $lapangan->jam_keluar_diizinkan ?></td>
											<td><?php echo $this->db->get_where('tbl_penempatan_karyawan', ['id_lapangan' => $lapangan->id])->num_rows() ?></td>
                      <td><?php echo $lapangan->petugas ?></td>
                      <td style="text-align:center" width="200px">
                        <?php 
				echo anchor(site_url(levelUser($this->session->userdata('level')).'/lapangan/read/'.encrypt_url($lapangan->id)),'<i class="fas fa-eye" aria-hidden="true"></i>','class="btn btn-success btn-sm read_data"'); 
				echo '  '; 
				echo anchor(site_url(levelUser($this->session->userdata('level')).'/lapangan/update/'.encrypt_url($lapangan->id)),'<i class="fas fa-pencil-alt" aria-hidden="true"></i>','class="btn btn-primary btn-sm update_data"'); 
				echo '  '; 
				echo anchor(site_url(levelUser($this->session->userdata('level')).'/lapangan/assign_users/'.encrypt_url($lapangan->id)),'<i class="fas fa-tasks" aria-hidden="true"></i>','class="btn btn-secondary btn-sm"');
				echo '  ';
				echo anchor(site_url(levelUser($this->session->userdata('level')).'/lapangan/delete/'.encrypt_url($lapangan->id)),'<i class="fas fa-trash-alt" aria-hidden="true"></i>','class="btn btn-danger btn-sm delete_data" Delete','onclick="javasciprt: return confirm(\'Are You Sure ?\')"');
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

