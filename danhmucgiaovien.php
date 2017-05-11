<?php
require_once('header.php');
check_permis(!$users->is_admin());
?>
<script type="text/javascript" src="js/jquery.dataTables.min.js"></script>
<script type="text/javascript">
	$(document).ready(function(){
		$('#giaovien_list').dataTable( {
			"columns": [null,  null, null, null, null, null, null ],
			"processing": true,
        	"serverSide": true,
        	"ajax": "dataTable_giaovien.html",
        	"columnDefs": [
			    { "orderable": false, "targets": 0 },
			    { "orderable": false, "targets": 1 },
			    { "orderable": false, "targets": 2 },
			    { "orderable": false, "targets": 3 },
			    { "orderable": false, "targets": 4 },
			    { "orderable": false, "targets": 5 },
			    { "orderable": false, "targets": 6 },
			    { "orderable": false, "targets": 7 }
			]
		} );
	});
</script>
<h1><a href="index.html" class="nav-button transform"><span></span></a>&nbsp;Danh sách Giáo viên.</h1>
<a href="themgiaovien.html" class="button primary"><span class="mif-plus"></span> Thêm Giáo viên</a>
<table class="table striped hovered" id="giaovien_list">
	<thead>
		<tr>
			<th>STT</th>
			<th>Mã số Giáo viên</th>
			<th>Họ tên</th>
	        <th>Ngày sinh</th>
	        <th>Giới tính</th>
	        <th>Nơi sinh</th>
			<th><span class="mif-pencil"></span></th>
			<th><span class="mif-bin"></span></th>
		</tr>
	</thead>
	<tbody></tbody>
</table>
<?php require_once('footer.php'); ?>