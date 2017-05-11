<?php
require_once('header.php');
check_permis(!$users->is_admin());
?>
<script type="text/javascript" src="js/jquery.dataTables.min.js"></script>
<script type="text/javascript">
	$(document).ready(function(){
		$('#users_list').dataTable( {
			"columns": [null,  null, null, null, null, null],
			"processing": true,
        	"serverSide": true,
        	"ajax": "dataTable_users.html",
        	"columnDefs": [
			    { "orderable": false, "targets": 0 },
			    { "orderable": false, "targets": 1 },
			    { "orderable": false, "targets": 2 },
			    { "orderable": false, "targets": 3 },
			    { "orderable": false, "targets": 4 },
			    { "orderable": false, "targets": 5 }
			]
		} );
	});
</script>
<h1><a href="index.html" class="nav-button transform"><span></span></a>&nbsp;Danh sách Tài khoản.</h1>
<a href="users_add.html" class="button primary"><span class="mif-plus"></span> Thêm Tài khoản</a>
<table class="table striped hovered" id="users_list">
	<thead>
		<tr>
			<th>STT</th>
			<th>Username</th>
			<th>Họ tên</th>
	        <th>Quyền</th>
			<th><span class="mif-pencil"></span></th>
			<th><span class="mif-bin"></span></th>
		</tr>
	</thead>
	<tbody></tbody>
</table>
<?php require_once('footer.php'); ?>