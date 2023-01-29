<style>
table#dataTable_UsersNotAssigned.dataTable tbody tr.over {
  background-color: #ffa;
}

table#dataTable_UsersNotAssigned.dataTable tbody tr.over>.sorting_1 {
  background-color: #ffa;
}

table#dataTable_UsersAssigned.dataTable tbody tr.over {
  background-color: #ffa;
}

table#dataTable_UsersAssigned.dataTable tbody tr.over>.sorting_1 {
  background-color: #ffa;
}

#events {
  margin-bottom: 1em;
  padding: 1em;
  background-color: #f6f6f6;
  border: 1px solid #999;
  border-radius: 3px;
  height: 100px;
	width:100%;
  overflow: auto;
	color:black;
}
</style>
<div id="content" class="app-content">
  <div class="col-12 ui-sortable">
    <div class="panel panel-inverse" data-sortable-id="form-stuff-1" data-init="true">
      <div class="panel-heading ui-sortable-handle">
        <h4 class="panel-title">Users Assign</h4>
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
        <div class="row">
          <div class="col-md-6">
            <h4>List Karyawan/Users</h4>
            <table class="table table-bordered table-hover table-td-valign-middle text-white"
              id="dataTable_UsersNotAssigned">
              <thead>
                <tr>
                  <th>No</th>
                  <th>Username</th>
                  <th>Nama Lengkap</th>
									<th>Action</th>
                </tr>
              </thead>
              <tbody>
                <?php 
								$no = 1;
								foreach ($users_not_assigned_yet as $una) {
								?>
                <tr>
                  <td><?= $no++ ?></td>
                  <td><?= $una->username ?><input type="hidden" name="user_id[]" value="<?= encrypt_url($una->id) ?>"></td>
                  <td><?= $una->nama_lengkap ?></td>
									<td><button type="button" class="btn btn-success btn-sm btn-assign-user" data-user_id="<?= encrypt_url($una->id) ?>">Assign</button></td>
                </tr>
                <?php } ?>
              </tbody>
            </table>
          </div>
          <div class="col-md-6">
            <h4>List Karyawan/Users yang berada pada <?= $nama_lapangan ?></h4>
            <table class="table table-bordered table-hover table-td-valign-middle text-white"
							id="dataTable_UsersAssigned">
							<thead>
								<tr>
									<th>No</th>
									<th>Username</th>
									<th>Nama Lengkap</th>
									<th>Action</th>
								</tr>
							</thead>
							<tbody>
								<?php
								$noua = 1;
								foreach ($users_assigned as $ua) {
								?>
									<tr>
										<td><?= $noua++ ?></td>
										<td><?= $ua->username ?><input type="hidden" name="user_id[]" value="<?= encrypt_url($ua->id) ?>"></td>
										<td><?= $ua->nama_lengkap ?></td>
										<td><button type="button" class="btn btn-danger btn-sm btn-unassign-user" data-user_id="<?= encrypt_url($ua->id) ?>">Unassign</button></td>
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

<script>
$(document).ready(function() {
  var table = $('#dataTable_UsersNotAssigned').DataTable();
	var table2 = $('#dataTable_UsersAssigned').DataTable({
		// add button save to datatable
		dom: 'Bfrtip',
		buttons: [
			{
				text: '<i class="fa fa-save"></i> Save',
				'className': 'btn btn-info btn-sm btn-save-assigned-user',
				action: function(e, dt, node, config){
					// get all user_id from table 2
					var user_id = [];
					$('#dataTable_UsersAssigned tbody tr').each(function(){
						user_id.push($(this).find('input[name="user_id[]"]').val());
					})

					// send to controller
					$.ajax({
						url: '<?= base_url($this->uri->segment(1).'/lapangan/save_assigned_user') ?>',
						type: 'POST',
						data: {
							lapangan_id: '<?= $id ?>',
							user_id: user_id
						},
						success: function(response){
							Swal.fire({
								title: 'Success',
								text: response.message,
								icon: 'success',
								confirmButtonText: 'OK'
							})
						}
					})
				}
			}
		],
	});

	function recalculateRowNumber(tablenya){
		tablenya
			.rows()
			.every(function(rowIdx, tableLoop, rowLoop){
				var data = this.data();
				data[0] = rowIdx + 1;
				this.data(data);
			})
			.draw();
	}

	$(document).on('click', '.btn-assign-user', function(){
		// move row from table 1 to table 2
		// get row from table 1
		var row = $(this).closest('tr');
		var user_id = $(this).data('user_id');
		var username = row.find('td:eq(1)').text();
		var nama_lengkap = row.find('td:eq(2)').text();

		// add row to table 2
		table2.row.add([
			table2.rows().count() + 1,
			username + '<input type="hidden" name="user_id[]" value="'+ user_id +'">',
			nama_lengkap,
			'<button type="button" class="btn btn-danger btn-sm btn-unassign-user" data-user_id="'+user_id+'">Unassign</button>'
		]).draw(false);

		// remove row from table 1
		table.row(row).remove().draw(false);

		recalculateRowNumber(table);
	})

	$(document).on('click', '.btn-unassign-user', function(){
		// move row from table 2 to table 1
		// get row from table 2
		var row = $(this).closest('tr');
		var user_id = $(this).data('user_id');
		var username = row.find('td:eq(1)').text();
		var nama_lengkap = row.find('td:eq(2)').text();

		// add row to table 1
		table.row.add([
			table.rows().count() + 1,
			username,
			nama_lengkap,
			'<button type="button" class="btn btn-success btn-sm btn-assign-user" data-user_id="'+user_id+'">Assign</button>'
		]).draw(false);

		// remove row from table 2
		table2.row(row).remove().draw(false);

		recalculateRowNumber(table2);
	})
});
</script>
