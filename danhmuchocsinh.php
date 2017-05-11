<?php
require_once('header.php');
check_permis(!$users->is_admin());
?>
<script type="text/javascript" src="js/jquery.dataTables.min.js"></script>
<script type="text/javascript">
	$(document).ready(function(){
		$('#hocsinh_list').dataTable( {
			"processing": true,
        	"serverSide": true,
	        "ajax": "dataTable_hocsinh.html"
		});
	});
</script>
<h1><a href="index.php" class="nav-button transform"><span></span></a>&nbsp;Danh sách Học sinh.</h1>
<a href="themhocsinh.php" class="button primary"><span class="mif-plus"></span> Thêm Học sinh</a>
<table class="table striped hovered" id="hocsinh_list">
	<thead>
		<tr>
			<th>STT</th>
			<th>Mã số Học sinh</th>
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