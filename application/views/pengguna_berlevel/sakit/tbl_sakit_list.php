<div id="content" class="app-content">
            <h1 class="page-header">DATA TBL_SAKIT</h1>  
            <div class="panel panel-inverse">
              <div class="panel-heading">
                <h4 class="panel-title"></h4>
                    <div class="panel-heading-btn">
                        <a href="javascript:;" class="btn btn-xs btn-icon btn-default" data-toggle="panel-expand"><i class="fa fa-expand"></i></a>
                        <a href="javascript:;" class="btn btn-xs btn-icon btn-success" data-toggle="panel-reload"><i class="fa fa-redo"></i></a>
                        <a href="javascript:;" class="btn btn-xs btn-icon btn-warning" data-toggle="panel-collapse"><i class="fa fa-minus"></i></a>
                        <a href="javascript:;" class="btn btn-xs btn-icon btn-danger" data-toggle="panel-remove"><i class="fa fa-times"></i></a>
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
        <?php echo anchor(site_url(levelUser($this->session->userdata('level')).'/sakit/create'), '<i class="fas fa-plus-square" aria-hidden="true"></i> Tambah Data', 'class="btn btn-danger btn-sm tambah_data"'); ?>
                </div>
            </div>
        </div>    
        <div class="box-body" style="overflow-x: scroll; ">
        <table id="data-table-default" class="table table-bordered table-hover table-td-valign-middle text-white">
         <thead>
            <tr>
                <th>No</th>
		<th>Users Id</th>
		<th>Tanggal</th>
		<th>Alasan</th>
		<th>Status</th>
		<th>Created At</th>
		<th>Updated At</th>
		<th>Action</th>
            </tr></thead><tbody><?php $no = 1;
            foreach ($sakit_data as $sakit)
            {
                ?>
                <tr>
			<td><?= $no++?></td>
			<td><?php echo $sakit->users_id ?></td>
			<td><?php echo $sakit->tanggal ?></td>
			<td><?php echo $sakit->alasan ?></td>
			<td><?php echo $sakit->status ?></td>
			<td><?php echo $sakit->created_at ?></td>
			<td><?php echo $sakit->updated_at ?></td>
			<td style="text-align:center" width="200px">
				<?php 
				echo anchor(site_url(levelUser($this->session->userdata('level')).'/sakit/read/'.encrypt_url($sakit->id)),'<i class="fas fa-eye" aria-hidden="true"></i>','class="btn btn-success btn-sm read_data"'); 
				echo '  '; 
				echo anchor(site_url(levelUser($this->session->userdata('level')).'/sakit/update/'.encrypt_url($sakit->id)),'<i class="fas fa-pencil-alt" aria-hidden="true"></i>','class="btn btn-primary btn-sm update_data"'); 
				echo '  '; 
				echo anchor(site_url(levelUser($this->session->userdata('level')).'/sakit/delete/'.encrypt_url($sakit->id)),'<i class="fas fa-trash-alt" aria-hidden="true"></i>','class="btn btn-danger btn-sm delete_data" Delete','onclick="javasciprt: return confirm(\'Are You Sure ?\')"'); 
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